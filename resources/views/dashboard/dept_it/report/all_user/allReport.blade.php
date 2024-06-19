@extends('layout.AppLayout')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between mb-3">
                    <h4 class="fw-bold">Report IT</h4>
                </div>
                <div class="card-text">
                    @if (Session::has('remove'))
                        <div class="alert alert-danger">
                            {{ session('remove') }}
                        </div>
                    @endif
                    <form method="get" action="{{ route('weeklyIT.index') }}" id="filterForm">
                        <div class="mb-2 form-group d-flex flex-column gap-3">
                            <div class="d-flex align-items-start gap-2">
                                <div style="width:fit-content">
                                    <a class="btn btn-dark d-flex align-items-center gap-2"
                                        href="{{ route('weeklyIT.index') }}">
                                        <i class="lni lni-spinner-arrow"></i>
                                        Refresh
                                    </a>
                                </div>
                                <div style="width:fit-content">
                                    <button class="btn btn-success d-flex align-items-center gap-2" onclick="excel()"
                                        type="button">
                                        <i class="lni lni-inbox"></i>
                                        Export Excel
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="col-sm-2">
                                    <label for="week">Start Date :</label>
                                    <input type="date" class="form-control" name="start_date"
                                        value="{{ $request->get('start_date') ?? '' }}">
                                </div>
                                <div class="col-sm-2">
                                    <label for="month">End Date :</label>
                                    <input type="date" class="form-control" name="end_date"
                                        value="{{ $request->get('end_date') ?? '' }}">
                                </div>
                                <div class="col-sm-3">
                                    <label for="user_req_perusahaan">Perusahaan :</label>
                                    <select class="form-control" id="user_req_perusahaan" name="user_req_perusahaan"
                                        required>
                                        <option value="0" selected>-- Pilih Perusahaan PIC Request --</option>
                                        @foreach ($perusahaans as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $request->get('user_req_perusahaan') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_perusahaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="user_req_departemen">Departemen :</label>
                                    <select class="form-control" id="user_req_departemen" name="user_req_departemen"
                                        required>
                                        <option value="0" selected>-- Pilih Departemen PIC Request --</option>
                                        @foreach ($departemens as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $request->get('user_req_departemen') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_departemen }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="align-items-end d-flex" style="width:fit-content">
                                    <button class="btn btn-primary" onclick="formFilter()" type="button">Filter</button>
                                </div>
                            </div>
                            @if (Session::has('error'))
                                <small class="text text-danger">
                                    <i class="lni lni-cross-circle"></i>
                                    {{ session('error') }}
                                </small>
                            @endif
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-dark align-middle text-center">
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Perusahaan PIC Request</th>
                                    <th scope="col" class="text-center">Program / Project</th>
                                    <th scope="col" class="text-center">PIC Request</th>
                                    <th scope="col" class="text-center col-md-4">Jenis Kegiatan</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">PIC</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($reportAllUsersIT->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center py-4">Data tidak ditemukan atau kosong</td>
                                    </tr>
                                @else
                                    @foreach ($reportAllUsersIT as $key => $value)
                                        <tr>
                                            <td class="align-middle"
                                                style="width: 1%; white-space:nowrap; vertical-align:top">
                                                {{ \Carbon\Carbon::parse($value->tanggal_pengerjaan)->format('d M Y') }}
                                            </td>
                                            <td class="align-middle" style="vertical-align:top">
                                                {{ $value->perusahaan->nama_perusahaan }}
                                            </td>
                                            <td class="text-capitalize align-middle" style="vertical-align:top">
                                                {!! $value->program->nama_program !!}
                                            </td>
                                            <td class="text-capitalize align-middle" style="vertical-align:top">
                                                {!! $value->user_request !!}
                                                <br>
                                                <small>({{ $value->departemen->nama_departemen }})</small>
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
                                            <td class="text-capitalize align-middle text-center">
                                                {{ $value->users->username }}</td>
                                            <td class="align-middle d-flex gap-2">
                                                <a href="{{ route('weeklyIT.edit', $value->id) }}"
                                                    class="btn btn-dark d-flex align-items-center gap-2"
                                                    style="width:fit-content">
                                                    <i class="lni lni-pencil"></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('weeklyIT.destroy', $value->id) }}" method="POST"
                                                    class="btn btn-danger d-flex align-items-center gap-2"
                                                    style="width:fit-content">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="d-flex align-items-center gap-2"
                                                        style="background: none; border: none; color: inherit; cursor: pointer;">
                                                        <i class="lni lni-trash-can"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        {!! $reportAllUsersIT->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function formFilter() {
            const form = document.getElementById('filterForm');
            form.action = "{{ route('weeklyIT.index') }}";
            form.submit();
        }

        function excel() {
            const form = document.getElementById('filterForm');
            form.action = "{{ route('weeklyIT.export') }}";
            form.submit();
        }

        $(document).ready(function() {
            $('table tbody tr').each(function() {
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
