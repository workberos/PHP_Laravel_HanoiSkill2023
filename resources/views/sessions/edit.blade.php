@extends('layout.main')


@section('content')

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="events/index.html">Quản lý sự kiện</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{ $event->name }}</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('events.index') }}">Tổng quan</a></li>
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
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{ $event->name }}</h1>
                </div>
                <span class="h6">{{ $event->date }}</span>
            </div>

            <div class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Tạo phiên mới</h2>
                </div>
            </div>

            <form class="needs-validation" action="{{ route('session.update', ['event'=>$event, 'session' => $session]) }}" method="post">
            @csrf
            @method('PUT')
                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="selectType">Loại</label>
                        <select class="form-control" id="selectType" name="type">
                            <option value="talk" {{ $session->type == 'Talk'? 'selected':'' }}>Talk</option>
                            <option value="workshop" {{ $session->type == 'Workshop'? 'selected':'' }}>Workshop</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputTitle">Tiêu đề</label>
                        <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="inputTitle" name="title" 
                        placeholder="" value="{{ $session->title }}">
                        <div class="invalid-feedback">
                            Tiêu đề không được để trống.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputSpeaker">Người trình bày</label>
                        <input type="text" class="form-control @error('speaker') is-invalid @enderror" id="inputSpeaker" 
                        name="speaker" placeholder="" value="{{ $session->speaker }}">
                        <div class="invalid-feedback">
                            Người trình bày không được để trống.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                         <label for="selectRoom">Phòng</label>
                        <select class="form-control" id="selectRoom" name="room">
                        @foreach($channels as $channel)
                            @foreach($channel->rooms as $room)
                            <option value="{{ $room->id }}" {{ $session->room_id == $room->id ? 'selected' : ''}}> 
                                {{ $room->name }}/{{ $channel->name }}
                            </option>
                            @endforeach
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputCost">Giá</label>
                        <input type="number" class="form-control" id="inputCost" 
                        name="cost" placeholder="" value="{{ $session->cost? $session->cost: 0 }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6 mb-3">
                        <label for="inputStart">Bắt đầu</label>
                        <input type="text"
                               class="form-control"
                               id="inputStart"
                               name="start"
                               placeholder="yyyy-mm-dd HH:MM"
                               value="{{ $session->start }}">
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label for="inputEnd">Kết thúc</label>
                        <input type="text"
                               class="form-control"
                               id="inputEnd"
                               name="end"
                               placeholder="yyyy-mm-dd HH:MM"
                               value="{{ $session->end }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="textareaDescription">Mô tả</label>
                        <textarea class="form-control" id="textareaDescription" name="description" placeholder="" rows="5">{{ trim($session->description) }}</textarea>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary" type="submit">Lưu phiên</button>
                <a href="{{ route('events.show', ['event' => $event]) }}" class="btn btn-link">Bỏ qua</a>
            </form>

        </main>
    </div>
</div>

</body>
</html>
