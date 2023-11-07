<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Room;
use App\Models\Event;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        //
        $channels = Channel::where('event_id', $event->id)
            ->get();
        return view('rooms.create', compact('event', 'channels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Event $event, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required',
        ]);
        Room::create([
                'name' => $request->name,
                'channel_id' => $request->channel,
                'capacity' => $request->capacity
            ]);

        return redirect()->action([EventController::class, 'show'], ['event' => $event])
            ->with('success', 'Phòng đã được tạo thành công');
    }
}
