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
                        <div class="mb-2 form-group d-flex align-items-end gap-2">
                            <div class="" style="width:fit-content">
                                <strong>Filter</strong>
                                <a class="btn btn-dark d-flex align-items-center gap-2" href="/dashboard/terimapinjam">
                                    <i class="lni lni-spinner-arrow"></i>
                                    Refresh
                                </a>
                            </div>
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
                                <button class="btn btn-success d-flex align-items-center gap-2" onclick="exportExcel()"
                                    type="button">
                                    <i class="lni lni-inbox"></i>
                                    Export Excel
                                </button>
                            </div>
                            <div class="align-items-end d-flex" style="width:fit-content">
                                <a class="btn btn-primary d-flex align-items-center gap-2"
                                    href="{{ route('report.create') }}">
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
                                    <th scope="col">No</th>
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
                                        <th scope="row">{{ $reports->firstItem() + $key }}</th>
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
