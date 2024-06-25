@extends('layout.AppLayout')

@section('content')
    <div class="row">
        <div class="card" style="min-height: 100vh;">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between mb-3">
                    <h4 class="fw-bold">Cetak Berkas</h4>
                </div>
                <div class="card-text">
                    <form method="get" action="{{ route('report.index') }}" id="filterForm">
                        <div class="mb-2 form-group d-flex flex-column gap-3">
                            <div class="d-flex align-items-start gap-2">
                                <div style="width:fit-content">
                                    <a class="btn btn-dark d-flex align-items-center gap-2"
                                        href="{{ route('report.index') }}">
                                        <i class="lni lni-spinner-arrow"></i>
                                        Refresh
                                    </a>
                                </div>
                                <div style="width:fit-content">
                                    <button class="btn btn-success d-flex align-items-center gap-2" onclick="exportExcel()"
                                        type="button">
                                        <i class="lni lni-inbox"></i>
                                        Export Excel
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search..."
                                            aria-label="Search..." aria-describedby="button-addon2"
                                            value="{{ $request->get('search') ?? '' }}" name="search">
                                        <button class="btn btn-dark" type="submit" id="button-addon2"
                                            onclick="formFilter()">Search</button>
                                    </div>
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
                                <div class="col-sm-2">
                                    <label for="month">Jenis Berkas :</label>
                                    <select class="form-control" id="berkas" name="berkas" required>
                                        <option value="0" selected>-- Pilih jenis berkas --</option>
                                        @foreach ($berkass as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $request->get('berkas') == $item->id ? 'selected' : '' }}>
                                                {{ $item->jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="align-items-end d-flex" style="width:fit-content">
                                    <button class="btn btn-primary" onclick="formFilter()" type="button">Filter</button>
                                </div>
                                <div class="align-items-end d-flex" style="width:fit-content">
                                    <a class="btn btn-primary d-flex align-items-center gap-2"
                                        href="{{ route('report.create') }}">
                                        <i class="lni lni-plus"></i>
                                        Tambah
                                    </a>
                                </div>
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
                                    <th scope="col" class="text-center">Id</th>
                                    <th scope="col">Perusahaan</th>
                                    <th scope="col">Pengirim</th>
                                    <th scope="col">Penerima</th>
                                    <th scope="col">(Qty) Item</th>
                                    <th scope="col">Jenis Tanda</th>
                                    <th scope="col">Tanggal Pembuatan</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $key => $value)
                                    <tr>
                                        <td>{{ $value->kop_id }}</td>
                                        <td>{{ $value->perusahaan->nama_perusahaan }}</td>
                                        <td class="text-capitalize">
                                            {!! $value->pengirim !!}<br><small>({{ $value->pengirim_dept->nama_departemen }})</small>
                                        </td>
                                        <td class="text-capitalize">
                                            {!! $value->penerima !!}<br><small>({{ $value->penerima_dept->nama_departemen }})</small>
                                        </td>
                                        <td class="text-capitalize">
                                            @php
                                                $items = $value->item
                                                    ->map(function ($item) {
                                                        if ($item->detail) {
                                                            return "({$item->quantity}) {$item->nama_item} ({$item->detail})";
                                                        }

                                                        return "({$item->quantity}) {$item->nama_item}";
                                                    })
                                                    ->toArray();
                                            @endphp
                                            {!! implode(', ', $items) !!}
                                        </td>
                                        <td class="fw-bold">{{ $value->tanda_terimapinjam->jenis }}</td>
                                        <td>{{ $value->created_at }}</td>
                                        <td>
                                            <a href="{{ route('report.show', $value->id) }}"
                                                class="btn btn-dark d-flex align-items-center gap-2">
                                                <i class="lni lni-printer"></i>
                                                Cetak
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {!! $reports->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function exportExcel() {
            const form = document.getElementById('filterForm');
            form.action = "{{ route('report.export') }}";
            form.submit();
        }

        function formFilter() {
            const form = document.getElementById('filterForm');
            form.action = "{{ route('report.index') }}";
            form.submit();
        }
    </script>
@endsection
