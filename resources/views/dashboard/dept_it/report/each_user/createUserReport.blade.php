@extends('layout.AppLayout')

@section('content')
    <div class="container-fluid card px-4">
        <div class="row my-3">
            <h2 class="mb-4">Tambah Report</h2>
            <form method="post" action="{{ route('reportIT.store') }}" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <div class="d-flex gap-3 flex-column mb-3">
                        <div class="d-flex gap-3 mb-3">
                            <div class="col">
                                <label for="item" class="form-label">PIC Request</label>
                                <input type="text" class="form-control" id="user_request" name="user_request[]"
                                    placeholder="Masukkan Nama PIC" value="{{ old('user_request[]') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="item" class="form-label">Perusahaan PIC Request</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="user_req_perusahaan_id">Pilih</label>
                                    <select class="form-control" id="user_req_perusahaan_id" name="user_req_perusahaan_id[]"
                                        required>
                                        <option selected>-- Bagian Perusahaan --</option>
                                        @foreach ($perusahaans as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="item" class="form-label">Dept. PIC Request</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="user_req_departemen_id">Pilih</label>
                                    <select class="form-control" id="user_req_departemen_id" name="user_req_departemen_id[]"
                                        required>
                                        <option selected>-- Bagian Departemen --</option>
                                        @foreach ($departemens as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="item" class="form-label">Program / Project</label>
                            <input type="text" class="form-control" id="program" name="program[]"
                                placeholder="Masukkan Program / Project" value="{{ old('program[]') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="item" class="form-label">Job</label>
                            <textarea class="form-control" id="jenis_kegiatan" name="jenis_kegiatan[]" placeholder="Jelaskan job anda"
                                style="height: 100px" value="{{ old('jenis_kegiatan[]') }}" required></textarea>
                        </div>
                        <div class="d-flex gap-3">
                            <div>
                                <label for="created_at" class="form-label">Tanggal Pengerjaan</label>
                                <input type="date" class="form-control" id="created_at" name="created_at[]" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="status">Status Pengerjaan Job</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="status">Pilih</label>
                                    <select class="form-control" id="status" name="status[]" required>
                                        <option selected>-- Status Pengerjaan --</option>
                                        @foreach ($statuses as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="report-container"></div>
                </div>
                <div class="mb-3 d-flex align-items-center gap-2 mb-4">
                    <button type="button" id="add-item" class="btn btn-outline-dark" style="padding:6px 12p">
                        Tambah Report
                    </button>
                    <button type="button" id="delete-item" class="btn btn-danger" style="padding:6px 12px;">
                        Hapus Penambahan
                    </button>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-dark d-flex align-items-center gap-3">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#add-item').click(function() {
                var newItemRow = $(`
                <div class="d-flex gap-3 flex-column mb-3 report-row">
                    <hr />
                    <div class="d-flex gap-3 mb-3">
                        <div class="col-md-4">
                            <label for="item" class="form-label">PIC Request</label>
                            <input type="text" class="form-control" id="user_request" name="user_request[]"
                                placeholder="Masukkan Nama PIC" value="{{ old('user_request[]') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="item" class="form-label">Dept. PIC Request</label>
                            <div class="input-group">
                                <label class="input-group-text" for="departemen_id">Pilih</label>
                                <select class="form-control" id="departemen_id" name="departemen_id[]" required>
                                    <option selected>-- Bagian Departemen --</option>
                                    @foreach ($departemens as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <label for="item" class="form-label">Program / Project</label>
                            <input type="text" class="form-control" id="program" name="program[]"
                                placeholder="Masukkan Program / Project" value="{{ old('program[]') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="item" class="form-label">Jobs</label>
                        <textarea class="form-control" id="jenis_kegiatan" name="jenis_kegiatan[]" placeholder="Jelaskan job anda"
                            style="height: 100px" value="{{ old('jenis_kegiatan[]') }}" required></textarea>
                    </div>
                    <div class="d-flex gap-3">
                        <div>
                            <label for="created_at" class="form-label">Tanggal Pengerjaan</label>
                            <input type="date" class="form-control" id="created_at" name="created_at[]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="status">Status Pengerjaan Job</label>
                            <div class="input-group">
                                <label class="input-group-text" for="status">Pilih</label>
                                <select class="form-control" id="status" name="status[]" required>
                                    <option selected>-- Status Pengerjaan --</option>
                                    @foreach ($statuses as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            `);
                $('#report-container').append(newItemRow);
            });

            $('#delete-item').click(function() {
                $('.report-row').last().remove();
            })
        });
    </script>
@endsection
