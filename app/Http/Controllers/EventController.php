<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Event_ticket;
use App\Models\Session;
use App\Models\Channel;
use App\Models\Room;



class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('organizer_id', session('currentOrganizer')->id)
            ->orderBy('date', 'asc')
            ->get();
        return view('events.index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        echo $request;
        $message = [
            'name.required' => 'Tên không được để trống',

            'slug.required' => 'Slug không được để trống',
            'slug.unique' => 'Slug đã được sử dụng',
            'slug.regex' => "Slug không được để trống và chỉ chứa các kí tự a-z, 0-9 và '-'",
            'date.required' => 'Ngày không được để trống',
            'date.date_format' => "Ngày không đúng định dạng"
        ];


        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:events|regex:/^[a-z0-9\-]+$/',
            'date' => 'required|date_format:Y-m-d',

        ], $message);

        // Event::create($request->all())
        $newEvent = Event::Create(
            [
                'name' => $request->name,
                'slug' => $request->slug,
                'date' => $request->date,
                'organizer_id' => session('currentOrganizer')->id,
            ]
        );
        return redirect()->action([EventController::class, 'show'], ['event' => $newEvent])
            ->with('success', 'Đã tạo sự kiện thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event_tickets = Event_ticket::where('event_id', $event->id)->get();


        return view('events.detail', compact('event', 'event_tickets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $message = [
            'name.required' => 'Tên không được để trống',

            'slug.required' => 'Slug không được để trống',
            'slug.unique' => 'Slug đã được sử dụng',
            'slug.regex' => "Slug không được để trống và chỉ chứa các kí tự a-z, 0-9 và '-'",
            'date.required' => 'Ngày không được để trống',
            'date.date_format' => "Ngày không đúng định dạng"
        ];


        $request->validate([
            'name' => 'required',
            'slug' => 'required|regex:/^[a-z0-9\-]+$/',
            'date' => 'required|date_format:Y-m-d',

        ], $message);



        $updatingEvent = Event::where('id', $event->id)
            ->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'date' => $request->date,
            ]);



            
        return redirect()->action([EventController::class, 'show'], ['event' => $event])
            ->with('success', 'Cập nhật sự kiện thành công.');
    }
}
