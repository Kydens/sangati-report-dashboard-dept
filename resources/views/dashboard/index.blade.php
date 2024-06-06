@extends('layout.AppLayout')

@section('content')
    <h1>Dashboard Utama</h1>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="card" style="width: 18rem; border-left:12px solid green; background-color:#f3f5f7;">
                <a href="{{ route('report.index') }}">
                    <div class="card-body py-4">
                        <h5 class="card-title text-dark">Tanda Terima / Pinjam</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Report Tanda Terima / Pinjam</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
