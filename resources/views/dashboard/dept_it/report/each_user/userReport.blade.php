@extends('layout.AppLayout')

@section('content')
    <div class="container-fluid card">
        <div class="card-body">
            <div class="card-title d-flex justify-content-between mb-3">
                <h4 class="fw-bold">Report IT</h4>
            </div>
            <div class="card-text">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="get" action="{{ route('reportIT.index') }}" id="filterForm">
                    <div class="mb-2 form-group d-flex align-items-end gap-2">
                        <div class="align-items-end d-flex" style="width:fit-content">
                            <a class="btn btn-primary d-flex align-items-center gap-2"
                                href="{{ route('reportIT.create') }}">
                                <i class="lni lni-plus"></i>
                                Tambah
                            </a>
                        </div>
                    </div>
                    @if (Session::has('error'))
                        <small class="text text-danger">
                            <i class="lni lni-cross-circle"></i>
                            {{ session('error') }}
                        </small>
                    @endif
                </form>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="table-dark align-middle">
                                <th scope="col" class="text-center">Tanggal</th>
                                <th scope="col" class="text-center">PIC Request</th>
                                <th scope="col" class="text-center">Perusahaan PIC Request</th>
                                <th scope="col" class="text-center">Departemen PIC Request</th>
                                <th scope="col" class="text-center">Program / Project</th>
                                <th scope="col" class="text-center col-md-4">Jenis Kegiatan</th>
                                <th scope="col" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportUserIT as $key => $value)
                                <tr>
                                    <td style="width: 1%; white-space:nowrap">{{ $value->created_at }}</td>
                                    <td>{{ $value->user_request }}</td>
                                    <td>{{ $value->perusahaan->nama_perusahaan }}</td>
                                    <td>{{ $value->departemen->nama_departemen }}</td>
                                    <td>{{ $value->program }}</td>
                                    <td>{{ $value->jenis_kegiatan }}</td>
                                    <td class="{{ $value->status == 'Proses' ? 'table-warning text-center' : 'table-success text-center' }}"
                                        style="width: 1%; white-space:nowrap">
                                        {{ $value->status }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {!! $reportUserIT->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
