@extends('layout.main')

@if ($message = Session::get('success'))
<script>
    alert("{{ $message }}");
</script>
@endif


@section('content')
<div class="container-fluid">

    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">Quản lý sự kiện</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{ $event->name }}</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="events/detail.html">Tổng quan</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Báo cáo</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item"><a class="nav-link" href="reports/index.html">Công suất phòng</a></li>
                </ul>
            </div>
        </nav>

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
                            <a href="tickets/create.html" class="btn btn-sm btn-outline-secondary">
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
                            @php
                                $value = json_decode($ticket->special_validity);
                            @endphp
                            @if($value !== null)
                                @if(isset($value->date))
                                <p class="card-text">Sắp có đến ngày {{ $value->date }}</p>
                                @else
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
                            <a href="sessions/create.html" class="btn btn-sm btn-outline-secondary">
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
                        <tr>
                            <td class="text-nowrap">08:30 - 10:00</td>
                            <td>Talk</td>
                            <td><a href="sessions/edit.html">Chủ đạo</a></td>
                            <td class="text-nowrap">Một người quan trọng</td>
                            <td class="text-nowrap">Chính / Phòng A</td>
                        </tr>
                        <tr>
                            <td class="text-nowrap">10:15 - 11:00</td>
                            <td>Talk</td>
                            <td><a href="sessions/edit.html">X có gì mới?</a></td>
                            <td class="text-nowrap">Người khác</td>
                            <td class="text-nowrap">Chính / Phòng A</td>
                        </tr>
                        <tr>
                            <td class="text-nowrap">10:15 - 11:00</td>
                            <td>Workshop</td>
                            <td><a href="sessions/edit.html">Thực hành với Y</a></td>
                            <td class="text-nowrap">Người khác</td>
                            <td class="text-nowrap">Phụ / Phòng C</td>
                        </tr>
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
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Chính</h5>
                            <p class="card-text">3 Phiên, 1 phòng</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Phụ</h5>
                            <p class="card-text">15 phiên, 2 phòng</p>
                        </div>
                    </div>
                </div>
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
                        <tr>
                            <td>Phòng A</td>
                            <td>1,000</td>
                        </tr>
                        <tr>
                            <td>Phòng B</td>
                            <td>100</td>
                        </tr>
                        <tr>
                            <td>Phòng C</td>
                            <td>100</td>
                        </tr>
                        <tr>
                            <td>Phòng D</td>
                            <td>250</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>
@endsection