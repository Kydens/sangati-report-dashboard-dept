@extends('layout.AppLayout')

@section('content')
    {{-- <div class="p-3 bg-light">
        <h1 class="mb-0">Create Account</h1>
    </div> --}}
    <div class="container d-flex justify-content-center mt-5">
        <div class="card col-sm-6 px-3">
            <div class="card-body">
                <div class="card-title">
                    <h1>Tambah Akun</h1>
                </div>
                <hr>
                <div class="card-text">
                    <form action="{{ route('store-account') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @if ($errors->has('password'))
                                <span class="text text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="perusahaan_user">Pilih</label>
                            <select class="form-control" id="perusahaan_user" name="perusahaan_user" required>
                                <option value="" required>-- Perusahaan --</option>
                                @foreach ($perusahaans as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="departemen_user">Pilih</label>
                            <select class="form-control" id="departemen_user" name="departemen_user" required>
                                <option value="" required>-- Bagian Departemen --</option>
                                @foreach ($departemens as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
