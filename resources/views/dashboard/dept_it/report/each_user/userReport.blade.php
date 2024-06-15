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
                    <table class="table table-bordered">
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
                            @if ($reportUserIT->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center py-4">Data tidak ditemukan atau kosong</td>
                                </tr>
                            @else
                                @foreach ($reportUserIT as $key => $value)
                                    <tr>
                                        <td class="align-middle" style="width: 1%; white-space:nowrap; vertical-align:top;">
                                            {{ \Carbon\Carbon::parse($value->tanggal_pengerjaan)->format('d M Y') }}</td>
                                        <td class="text-capitalize align-middle" style="vertical-align:top">
                                            {!! $value->user_request !!}
                                        </td>
                                        <td class="align-middle" style="vertical-align:top">
                                            {{ $value->perusahaan->nama_perusahaan }}</td>
                                        <td class="align-middle text-center" style="vertical-align:top">
                                            {{ $value->departemen->nama_departemen }}</td>
                                        <td class="text-capitalize align-middle" style="vertical-align:top">
                                            {!! $value->program->nama_program !!}
                                        </td>
                                        <td class="p-0" style="vertical-align:top">
                                            @php
                                                $jobs = $value->jobs
                                                    ->map(function ($job) {
                                                        return "<div class='jenis-kegiatan text-capitalize p-2'>{$job->jenis_kegiatan}</div>";
                                                    })
                                                    ->toArray();
                                            @endphp
                                            {!! implode('', $jobs) !!}
                                        </td>
                                        <td class="p-0" style="vertical-align:top">
                                            @php
                                                $jobs = $value->jobs
                                                    ->map(function ($job) {
                                                        $class =
                                                            $job->status == 'Done'
                                                                ? 'bg-success bg-opacity-25'
                                                                : 'bg-warning bg-opacity-25';
                                                        return "<div class='status p-2 text-center $class'>{$job->status}</div>";
                                                    })
                                                    ->toArray();
                                            @endphp
                                            {!! implode('', $jobs) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    {!! $reportUserIT->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('tr').each(function() {
                var maxHeight = 0;
                var jobTypes = $(this).find('.jenis-kegiatan');
                var jobStatuses = $(this).find('.status');

                jobTypes.each(function() {
                    if ($(this).height() > maxHeight) {
                        maxHeight = $(this).height();
                    }
                });

                jobStatuses.each(function() {
                    if ($(this).height() > maxHeight) {
                        maxHeight = $(this).height();
                    }
                });

                jobTypes.height(maxHeight);
                jobStatuses.height(maxHeight);
            });
        });
    </script>
@endsection
