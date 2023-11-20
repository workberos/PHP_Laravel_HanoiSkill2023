<?php

namespace App\Http\Controllers;

use App\Models\attendee;
use App\Models\Event;
use App\Models\Event_ticket;
use App\Models\Organizer;
use App\Models\Registration;
use App\Models\Session_registration;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getEvents()
    {
        $events = Event::where('date', '>', date('Y-m-d'))
            ->with(['organizer' => function ($query) {
                $query->select('id', 'name', 'slug');
            }])
            ->get();

        return response()->json(['events' => $events]);
    }

    public function getEventDetails(Request $request, $organizerSlug, $eventSlug)
    {

        // Check lỗi
        $organizer = Organizer::where('slug', $organizerSlug)->first();
        if (!$organizer) {
            return response()->json(['message' => "Không tìm thấy nhà tổ chức"], 404);
        }
        $event = Event::where('slug', $eventSlug)
            ->where('organizer_id', $organizer->id)
            ->first();
        if (!$event) {
            return response()->json(['message' => "Không tìm thấy sự kiện"], 404);
        }


        // Ẩn organizer_id
        $event = $event->makeHidden('organizer_id');

        // Khởi tạo mảng channels
        foreach ($event->channels as $channel) {
            $channel = $channel->makeHidden('event_id');

            foreach ($channel->rooms as $room) {
                $room = $room->makeHidden('channel_id', 'capacity');

                foreach ($room->sessions as $session) {
                    $session = $session->makeHidden('room_id');
                }
                $roomData['sessions'] = $session;
            }

            $channel['rooms'] = $room;
        }


        foreach ($event->tickets as $ticket) {
            $ticket = $ticket->makeHidden('event_id', 'special_validity');

            $ticket['description'] = null;
            $ticket['available'] = false;
            $special_valitity = json_decode($ticket->special_validity);
            if ($special_valitity != null) {
                $ticket['available'] = true;
                if ($special_valitity->type == 'date') {
                    $ticket['description'] = "Có sẵn đến ngày " . date('d-m-Y', strtotime($special_valitity->date));
                } else {
                    $ticket['description'] = $special_valitity->amount . ' vé sẵn có';
                }
            }
        }
        return response()->json($event);
    }

    // C3
    public function login(Request $request) {
        $user = attendee::where('lastname', $request->lastname)
        ->where('registration_code', $request->registration_code)
        ->first();

        if(!$user) {
            return response()->json(["message" => "Đăng nhập không hợp lệ"], 401);
        };

        // Cập nhật login token khi đăng nhập thành công
        $user->update(['login_token'=> md5($user->username)]);


        // tạo request
        $res = [];
        $res['firstname'] = $user->firstname;
        $res['lastname'] = $user->lastname;
        $res['username'] = $user->username;
        $res['email'] = $user->firstname;
        $res['token'] = $user->login_token;

        return response()->json($res);
    }

    public function logout(Request $request) {
        $user = attendee::where('login_token', $request->token)
        ->first();
        if(!$user) {
            return response()->json(["message" => "token không hợp lệ"]);
        }

        $user->update(['login_token'=> null]);
        return response()->json(["message" => "Đăng xuất thành công"]);
        
    }


    // C4:
    public function registration(Request $request, $organizerSlug, $eventSlug) {

        $attendee = attendee::where('login_token', $request->token)->first();
        if(!$attendee) {
            return response()->json(["message" => "Người dùng chưa đăng nhập"], 401);
        }

        $is_registered = Registration::where('attendee_id', $attendee->id)
                    ->where('ticket_id', $request->ticket_id)
                    ->first();
        if($is_registered) {
            return response()->json(["message" => "Người dùng đã đăng ký"], 401);

        }

        $ticket = Event_ticket::where('id', $request->ticket_id)->first();
        if($ticket->special_validity) {
            return response()->json(["message" => "Vé không sẵn có"]);
        }


        $registration = Registration::create([
            'attendee_id' => $attendee->id,
            'ticket_id' => $request->ticket_id,
            'registration_time' => date('Y-m-d H:i:s')
        ]);

        

        // session_ids là option
        if(isset($request->session_ids)) {
            foreach($request->session_ids as $session_id) {
                // Thêm mới session_registration
                Session_registration::create([
                    'registration_id' => $registration->id,
                    'session_id'=> $session_id
                ]);
            }
        }
        return response()->json(["message" => "Đăng kí thành công"]);

    }

    // c4b chưa làm
    public function registrationList(Request $request) { 
        $attendee = attendee::where('login_token', $request->token)->first();
        if(!$attendee) {
            return response()->json(["message" => "Người dùng chưa đăng nhập"], 401);
        }

        $registrations = registration::where('attendee_id', $attendee->id)->get();
        

        $data = ["registration"];
        return ;
    }
}
