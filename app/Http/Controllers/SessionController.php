<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Event;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        // dd($event);
        $channels = Channel::where('event_id', $event->id)
            ->with('rooms')
            ->get();
        return view('sessions.create', compact('event', 'channels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $event)
    {
        $message = [
            'title.required' => 'Tiêu đề không được để trống',
            'speaker.required' => 'Người trình bày không được để trống',
            'start.required' => 'Thời gian bắt đầu được để trống',
            'end.required' => 'Thời gian kết thúc được để trống',
            'start.date_format' => "Ngày không đúng định dạng",
            'end.date_format' => "Ngày không đúng định dạng",
            'description' => 'Mô tả không được để trống',
        ];

        $request->validate([
            'title' => 'required',
            'speaker' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'description' => 'required',
        ], $message);


        // Kiểm tra xung đột thời gian
        $start = $request->start;
        $end = $request->end;
        $conflict = Session::where('room_id', $request->room)
        ->where(function ($query) use ($start, $end) {
            $query->whereBetween('start', [$start, $end])
                ->orWhereBetween('end', [$start, $end])
                ->orWhere(function ($query) use ($start, $end) {
                    $query->where('start', '<', $start)
                        ->where('end', '>', $end);
                });
        })
        ->first();

        if ($conflict) {
            // thong bao loi
            return redirect()->back()
            ->with('error', 'Phòng đã được sử dụng tại thời điểm này')
            ->withInput();
        }

        Session::Create([
            'type' => $request->type,
            'title' => $request->title,
            'speaker' => $request->speaker,
            'room_id' => $request->room,
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
        ]);


        return redirect()->action([EventController::class, 'show'], ['event' => $event])
            ->with('success', 'Phiên đã được tạo thành công');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Event $event, Session $session)
    {
        $channels = Channel::where('event_id', $event->id)
        ->with('rooms')
        ->get();
        return view('sessions.edit', compact('event', 'channels', 'session'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event, Session $session)
    {
        //
        $message = [
            'title.required' => 'Tiêu đề không được để trống',
            'speaker.required' => 'Người trình bày không được để trống',
            'start.required' => 'Thời gian bắt đầu được để trống',
            'end.required' => 'Thời gian kết thúc được để trống',
            'start.date_format' => "Ngày không đúng định dạng",
            'end.date_format' => "Ngày không đúng định dạng",
            'description' => 'Mô tả không được để trống',
        ];

        $request->validate([
            'title' => 'required',
            'speaker' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'description' => 'required',
        ], $message);

        
        Session::where('id', $session->id)
        ->update([
            'type' => $request->type,
            'title' => $request->title,
            'speaker' => $request->speaker,
            'room_id' => $request->room,
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
        ]);

        return redirect()->action([EventController::class, 'show'], ['event' => $event])
            ->with('success', 'Phiên đã được cập nhật thành công');
    }
}
