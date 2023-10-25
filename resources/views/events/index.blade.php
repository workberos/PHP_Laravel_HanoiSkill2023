@extends('layout.main')
@section('content')

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('events.index') }}">Quản lý sự kiện</a></li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Quản lý sự kiện</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a href="{{ route('events.create') }}" class="btn btn-sm btn-outline-secondary">Tạo sự kiện mới</a>
                    </div>
                </div>
            </div>

            <div class="row events">
                <?php
                foreach ($events as $event) {
                ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <a href="{{ route('events.show', $event->id) }}" class="btn text-left event">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $event->name }}</h5>
                                    <p class="card-subtitle">{{ $event->date }}</p>
                                    <hr>
                                    <p class="card-text">3,546 người đăng ký</p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>

        </main>
    </div>
</div>
@endsection