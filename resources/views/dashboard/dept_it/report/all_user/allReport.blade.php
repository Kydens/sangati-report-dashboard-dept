@extends('layout.AppLayout')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between mb-3">
                    <h4 class="fw-bold">Report IT</h4>
                </div>
                <div class="card-text">
                    <form method="get" action="{{ route('weeklyIT.index') }}" id="filterForm">
                        <div class="mb-2 form-group d-flex flex-column gap-2">
                            <div class="row">
                                <div style="width:fit-content">
                                    <a class="btn btn-dark d-flex align-items-center gap-2"
                                        href="{{ route('weeklyIT.index') }}">
                                        <i class="lni lni-spinner-arrow"></i>
                                        Refresh
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="col-sm-1">
                                    <label for="week">Minggu :</label>
                                    <input type="number" class="form-control" name="week" min="1" max="4"
                                        placeholder="1-4" value="{{ $request->get('week') ?? '' }}">
                                </div>
                                <div class="col-sm-2">
                                    <label for="month">Bulan :</label>
                                    <input type="month" class="form-control" name="month"
                                        value="{{ $request->get('month') ?? '' }}">
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
                                <div class="align-items-end d-flex" style="width:fit-content">
                                    <button class="btn btn-success d-flex align-items-center gap-2" onclick="excel()"
                                        type="button">
                                        <i class="lni lni-inbox"></i>
                                        Export Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr class="table-dark align-middle">
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">PIC Request</th>
                                    <th scope="col" class="text-center">Perusahaan PIC Request</th>
                                    <th scope="col" class="text-center">Program / Project</th>
                                    <th scope="col" class="text-center col-md-4">Jenis Kegiatan</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">PIC</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportAllUsersIT as $key => $value)
                                    <tr>
                                        <td style="width: 1%; white-space:nowrap">{{ $value->created_at }}</td>
                                        <td>
                                            {{ $value->user_request }}
                                            <br>
                                            <small>({{ $value->departemen->nama_departemen }})</small>
                                        </td>
                                        <td>{{ $value->perusahaan->nama_perusahaan }}</td>
                                        <td>{{ $value->program }}</td>
                                        <td>{{ $value->jenis_kegiatan }}</td>
                                        <td class="{{ $value->status == 'Proses' ? 'table-warning text-center' : 'table-success text-center' }}"
                                            style="width: 1%; white-space:nowrap">
                                            {{ $value->status }}
                                        </td>
                                        <td class="text-capitalize">{{ $value->users->username }}</td>
                                        <td>
                                            <a href="{{ route('weeklyIT.edit', $value->id) }}"
                                                class="btn btn-dark d-flex align-items-center gap-2"
                                                style="width:fit-content">
                                                <i class="lni lni-pencil"></i>
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
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
    </script>
@endsection
