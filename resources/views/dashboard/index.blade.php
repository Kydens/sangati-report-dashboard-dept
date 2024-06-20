@extends('layout.AppLayout')

@section('content')
    <div class="p-3 bg-light">
        <h1 class="mb-0">Dashboard Utama</h1>
    </div>
    <div class="container-fluid mt-4 mx-2 px-3">
        <div class="row">
            @if (Session::has('error-unauthorized'))
                <div class="alert alert-danger mb-3" role="alert">
                    {{ session('error-unauthorized') }}
                </div>
            @endif
            <div class="px-0 row">
                <div class="col">
                    <div class="d-flex flex-wrap gap-4">
                        @if (Auth::user()->roles_id == 1)
                            <div class="card shadow-sm"
                                style="width: 18rem; border-left:12px solid green; background-color:#fffffe;">
                                <a href="{{ route('report.index') }}">
                                    <div class="card-body py-4">
                                        <h5 class="card-title text-dark">Tanda Terima / Pinjam</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">Report Tanda Terima / Pinjam</h6>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if (Auth::user()->roles_id == 1 && Auth::user()->departemen_id == 4)
                            <div class="card shadow-sm"
                                style="width: 18rem; border-left:12px solid dodgerblue; background-color:#fffffe;">
                                <a href="{{ route('weeklyIT.index') }}">
                                    <div class="card-body py-4">
                                        <h5 class="card-title text-dark">All Reports IT</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">All Users' Report IT Dept.</h6>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if (Auth::user()->departemen_id == 4)
                            <div class="card shadow-sm"
                                style="width: 18rem; border-left:12px solid purple; background-color:#fffffe;">
                                <a href="{{ route('reportIT.index') }}">
                                    <div class="card-body py-4">
                                        <h5 class="card-title text-dark">Report IT</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">User Report IT Dept.</h6>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                @if ((Auth::user()->roles_id == 1 && Auth::user()->departemen_id == 4) || Auth::user()->departemen_id == 1)
                    <div class="col-sm-4">
                        <div class="card shadow-sm" style="width: 100%; background-color:#fffffe;">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="card-title">Status Users</h5>
                                    <a href="{{ route('create-account') }}" class="text-primary">
                                        <i class="lni lni-plus fw-bold"></i>
                                    </a>
                                </div>
                                <hr>
                                @foreach ($users as $user)
                                    <div class="d-flex justify-content-between">
                                        <p class="card-text text-capitalize">{{ $user->username }}</p>
                                        <p class="card-text {{ $user->isActive == true ? 'text-success' : 'text-muted ' }}">
                                            {{ $user->isActive == true ? 'Active' : 'Off' }}
                                        </p>
                                    </div>
                                @endforeach
                                {!! $users->links() !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
