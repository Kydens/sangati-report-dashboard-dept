@extends('layout.AppLayout')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh; height 10dvh;">
        <div class="card d-flex shadow" style="width:700px;">
            <div class="row p-4">
                <div class="col d-flex align-items-center justify-content-center">
                    <img src="{{ asset('storage/post-images/sangati.png') }}" alt="sangati">
                </div>
                <div class="col">
                    <div class="card-body">
                        <h1 class="card-title mb-3">Login</h1>
                        @if (Session::has('loginError'))
                            <div class="alert alert-danger">
                                {{ session('loginError') }}
                            </div>
                        @endif
                        <div class="card-text">
                            <form action="{{ route('loginPost') }}" method="post" autocomplete="off" focu>
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="{{ old('username') }}" autofocus>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
