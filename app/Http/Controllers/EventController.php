<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Event_ticket;
use App\Models\Session;
use App\Models\Channel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
  // Display a listing of the resource.
  public function index()
  {

    $events = Event::where('organizer_id', session('currentOrganizer')->id)
      ->orderBy('date', 'asc')
      ->get();

    return view('events.index', ['events' => $events]);
  }

  //Show the form for creating a new resource.
  public function create()
  {

    return view('events.create');
  }

  //Store a newly created resource in storage.
  public function store(Request $request)
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
      'slug' => 'required|unique:events|regex:/^[a-z0-9\-]+$/',
      'date' => 'required|date_format:Y-m-d',
    ], $message);

    $newEvent = Event::Create(
      [
        'name' => $request->name,
        'slug' => $request->slug,
        'date' => $request->date,
        'organizer_id' => session('currentOrganizer')->id,
      ]
    );

    return view('events.index');
  }


  //Display the specified resource.
  public function show(Event $event)
  {
    if($event->organizer_id !== session('currentOrganizer')->id){
      // Nếu không được phép truy cập sẽ trở về trang chủ
      return redirect()->action([EventController::class, 'index']);
    }
    $event_tickets = Event_ticket::where('event_id', $event->id)->get();

    $channels = Channel::where('event_id', $event->id)
      ->with('rooms')
      ->get();

    return view('events.detail', compact('event', 'event_tickets', 'channels'));
  }

  //Show the form for editing the specified resource.
  public function edit(Event $event)
  {

    return view('events.edit', compact('event'));
  }

  //Update the specified resource in storage.
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


    Event::where('id', $event->id)
      ->update($request->validate([
        'name' => 'required',
        'slug' => 'required|regex:/^[a-z0-9\-]+$/',
        'date' => 'required|date_format:Y-m-d',

      ], $message));

    return redirect()->action([EventController::class, 'show'], ['event' => $event])
      ->with('success', 'Cập nhật sự kiện thành công.');
  }
}
