@extends('layout.AppLayout')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh; height 10dvh;">
        <div class="card" style="width:400px;">
            <div class="card-body shadow-sm">
                <h1 class="card-title mb-3">Login</h1>
                @if (Session::has('loginError'))
                    <div class="alert alert-danger">
                        {{ session('loginError') }}
                    </div>
                @endif
                <div class="card-text">
                    <form action="/auth/v1/login" method="post" autocomplete="off" focu>
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" autofocus>
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
@endsection
