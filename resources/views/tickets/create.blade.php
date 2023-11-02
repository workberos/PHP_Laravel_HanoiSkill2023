@extends('layout.main')


@section('content')
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">Quản lý sự kiện</a></li>
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
            <h2 class="h4">Tạo vé mới</h2>
        </div>
    </div>

    <form class="needs-validation" action="{{ route('ticket.store',['event' => $event]) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-4 mb-3">
                <label for="inputName">Tên</label>
                <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" name="name" placeholder="" value="{{ old('name') }}">
                @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-4 mb-3">
                <label for="inputCost">Giá</label>
                <input type="number" class="form-control @error('cost') is-invalid @enderror" id="inputCost" name="cost" placeholder="" value="{{ old('cost') }}">
                @error('cost')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-4 mb-3">
                <label for="selectSpecialValidity">Hiệu lực đặc biệt</label>
                <select class="form-control form-control @error('special_validity') is-invalid @enderror" 
                id="selectSpecialValidity" name="special_validity" >
                    <option value="" selected>Không</option>
                    <option value="amount" {{ old('special_validity') == 'amount' ? 'selected' : '' }}>Số lượng giới hạn</option>
                    <option value="date" {{ old('special_validity') == 'date' ? 'selected' : '' }}>Đặt mua đến ngày</option>
                </select>
                @error('special_validity')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4 mb-3">
                <label for="inputAmount">Số lượng vé tối đa được bán</label>
                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="inputAmount" 
                name="amount" placeholder="" value="{{ old('amount') }}">
                @error('amount')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4 mb-3">
                <label for="inputValidTill">Vé có thể được bán đến</label>
                <input type="text" class="form-control @error('valid_until') is-invalid @enderror" id="inputValidTill" name="valid_until" placeholder="yyyy-mm-dd HH:MM" value="{{ old('valid_until') }}">
                @error('valid_until')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>

        <hr class="mb-4">
        <button class="btn btn-primary" type="submit">Lưu vé</button>
        <a href="events/detail.html" class="btn btn-link">Bỏ qua</a>
    </form>

</main>
</div>
</div>

@endsection