@extends('layout.main')

@if ($message = Session::get('success'))
<script>
  alert("{{ $message }}");
</script>
@endif


@section('content')
<div class="container-fluid">

  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="border-bottom mb-3 pt-3 pb-2 event-title">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
          <h1 class="h2">{{ $event->name }}</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary">Sửa sự kiện</a>
            </div>
          </div>
        </div>
        <span class="h6">{{ $event->date }}</span>
      </div>

      <!-- Tickets -->
      <div id="tickets" class="mb-3 pt-3 pb-2">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
          <h2 class="h4">Vé</h2>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <a href="{{ route('ticket.create', ['event' => $event]) }}" class="btn btn-sm btn-outline-secondary">
                Tạo vé mới
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="row tickets">
        @foreach($event_tickets as $ticket)
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">{{ $ticket->name }}</h5>
              <p class="card-text">{{ $ticket->cost}}-</p>

              <?php $value = json_decode($ticket->special_validity); ?>
              @if($value != null)
              @if(isset($value->date))
              <p class="card-text">Sắp có đến ngày {{ $value->date }}</p>
              @elseif(isset($value->amount))
              <p class="card-text">{{ $value->amount }} vé có sẵn</p>
              @endif
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Sessions -->
      <div id="sessions" class="mb-3 pt-3 pb-2">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
          <h2 class="h4">Phiên</h2>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              
              <a href="{{ route('session.create', ['event' => $event]) }}" class="btn btn-sm btn-outline-secondary">
                Tạo phiên mới
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive sessions">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Thời gian</th>
              <th>Loại</th>
              <th class="w-100">Tiêu đề</th>
              <th>Người trình bày</th>
              <th>Kênh</th>
            </tr>
          </thead>
          <tbody>
            @foreach($channels as $channel)
            @foreach($channel->rooms as $room)
            @foreach($room->sessions as $session)
            <tr>
              <td class="text-nowrap">{{ date('H:i', strtotime($session->start)) }} - {{ date('H:i', strtotime($session->end))}}</td>
              <td>{{ $session->type }}</td>
              <td><a href="{{ route('session.edit', ['session'=> $session, 'event' => $event]) }}">{{ $session->title }} </a></td>
              <td class="text-nowrap">{{ $session->speaker }} </td>
              <td class="text-nowrap">{{ $channel->name }} / {{ $room->name }}</td>
            </tr>
            @endforeach
            @endforeach
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Channels -->
      <div id="channels" class="mb-3 pt-3 pb-2">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
          <h2 class="h4">Kênh</h2>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <a href="channels/create.html" class="btn btn-sm btn-outline-secondary">
                Tạo kênh mới
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="row channels">

        @foreach ($channels as $channel)
        <?php $session_count = 0; ?>
        @foreach ($channel->rooms as $room)
        <?php $session_count += $room->sessions->count(); ?>
        @endforeach
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <div class="card-body">
              <h5 class="card-title"> {{ $channel->name }}</h5>
              <p class="card-text"> {{ $session_count }} Phiên, {{ $channel->rooms->count() }} phòng</p>
            </div>
          </div>
        </div>

        @endforeach
      </div>

      <!-- Rooms -->
      <div id="rooms" class="mb-3 pt-3 pb-2">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
          <h2 class="h4">Phòng</h2>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <a href="rooms/create.html" class="btn btn-sm btn-outline-secondary">
                Tạo phòng mới
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive rooms">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Tên</th>
              <th>Công suất</th>
            </tr>
          </thead>
          <tbody>
          @if(isset($channel))
            @foreach($channel->rooms as $room)
            <tr>
              <td> {{ $room->name }}</td>
              <td>{{ $room->capacity }}</td>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>

    </main>
  </div>
</div>
@endsection