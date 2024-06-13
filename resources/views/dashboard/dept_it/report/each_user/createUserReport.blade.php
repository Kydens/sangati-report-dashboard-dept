@extends('layout.AppLayout')

@section('content')
    <div class="container-fluid card px-4">
        <div class="row my-3">
            <h2 class="mb-4 fw-bold">Tambah Report</h2>
            <hr />
            <form method="post" action="{{ route('reportIT.store') }}" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <div class="d-flex gap-3 flex-column mb-3">
                        <h4 class="fw-semibold mb-2">Report 1</h4>
                        <div class="d-flex gap-3 mb-3">
                            <div>
                                <label for="tanggal_pengerjaan" class="form-label">Tanggal Pengerjaan</label>
                                <input type="date" class="form-control" id="tanggal_pengerjaan"
                                    name="tanggal_pengerjaan[]" value="{{ old('tanggal_pengerjaan[]') }}" required>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-3 col">
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
                        <div class="col">
                            <label for="program" class="form-label">Program / Project</label>
                            <input type="text" class="form-control" id="program" name="program[]"
                                placeholder="Masukkan Program / Project" value="{{ old('program[]') }}" required>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="col">
                                <label for="item" class="form-label">Job</label>
                                <div class="d-flex align-items-start gap-3 mb-2">
                                    <textarea class="form-control" id="jenis_kegiatan" name="jenis_kegiatan[][]" placeholder="Jelaskan job anda"
                                        style="height: 100px" value="{{ old('jenis_kegiatan[][]') }}" required></textarea>
                                    <div>
                                        <button type="button" class="add-job btn btn-primary d-flex align-items-center"
                                            data-report-index="0">
                                            <i class="lni lni-plus"></i>
                                            Tambah Job
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="status">Status Pengerjaan Job</label>
                                    <div class="input-group">
                                        <label class="input-group-text" for="status">Pilih</label>
                                        <select class="form-control" id="status" name="status[][]" required>
                                            <option selected>-- Status Pengerjaan --</option>
                                            @foreach ($statuses as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="job-container-0"></div>
                        </div>
                    </div>
                    <div id="report-container"></div>
                </div>
                <div class="mb-3 d-flex align-items-center gap-2 mb-4">
                    <button type="button" id="add-report" class="btn btn-dark" style="padding:6px 12p">
                        Tambah Report
                    </button>
                    <button type="button" id="delete-report" class="btn btn-danger" style="padding:6px 12px;">
                        Hapus Penambahan
                    </button>
                    <button type="submit" class="btn btn-success" style="padding:6px 12px;">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        debugger;
        $(document).ready(function() {
            let counter = 1;

            $('#add-report').click(function() {
                let newReportRow = $(`
                    <div class="d-flex gap-3 flex-column mb-3 report-row">
                        <hr />
                        <h4 class="fw-semibold mb-2 reportCounter">Report ${counter+1}</h4>
                        <div class="d-flex gap-3 mb-3">
                            <div>
                                <label for="tanggal_pengerjaan" class="form-label">Tanggal Pengerjaan</label>
                                <input type="date" class="form-control" id="tanggal_pengerjaan"
                                    name="tanggal_pengerjaan[]" value="{{ old('tanggal_pengerjaan[]') }}" required>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-3 col">
                            <div class="col">
                                <label for="item" class="form-label">PIC Request</label>
                                <input type="text" class="form-control" id="user_request" name="user_request[]"
                                    placeholder="Masukkan Nama PIC" value="{{ old('user_request[]') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="item" class="form-label">Perusahaan PIC Request</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="user_req_perusahaan_id">Pilih</label>
                                    <select class="form-control" id="user_req_perusahaan_id"
                                        name="user_req_perusahaan_id[]" required>
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
                                    <select class="form-control" id="user_req_departemen_id"
                                        name="user_req_departemen_id[]" required>
                                        <option selected>-- Bagian Departemen --</option>
                                        @foreach ($departemens as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="program" class="form-label">Program / Project</label>
                            <input type="text" class="form-control" id="program" name="program[]"
                                placeholder="Masukkan Program / Project" value="{{ old('program[]') }}" required>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="col">
                                <label for="item" class="form-label">Job</label>
                                <div class="d-flex align-items-start gap-3">
                                    <textarea class="form-control" id="jenis_kegiatan" name="jenis_kegiatan[${counter}][]" placeholder="Jelaskan job anda"
                                        style="height: 100px" value="{{ old('jenis_kegiatan[${counter}][]') }}" required></textarea>
                                    <div>
                                        <button type="button"
                                            class="add-job btn btn-primary d-flex align-items-center" data-report-index="${counter}">
                                            <i class="lni lni-plus"></i>
                                            Tambah Job
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="status">Status Pengerjaan Job</label>
                                    <div class="input-group">
                                        <label class="input-group-text" for="status">Pilih</label>
                                        <select class="form-control" id="status" name="status[${counter}][]" required>
                                            <option selected>-- Status Pengerjaan --</option>
                                            @foreach ($statuses as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="job-container-${counter}"></div>
                        </div>
                    </div>
                `);

                $('#report-container').append(newReportRow);
                counter++;
            });

            $('#delete-report').click(function() {
                $('.report-row').last().remove();

                if (counter > 1) {
                    counter--;
                }
            });

            $(document).on('click', '.add-job', function() {
                let reportIndex = $(this).data('report-index');

                let newJobRow = $(`
                    <div class="col mt-3 added-job">
                        <label for="item" class="form-label">Job</label>
                        <div class="d-flex align-items-start gap-3">
                            <textarea class="form-control" id="jenis_kegiatan" name="jenis_kegiatan[${reportIndex}][]" placeholder="Jelaskan job anda"
                                style="height: 100px" value="{{ old('jenis_kegiatan[${reportIndex}][]') }}" required></textarea>
                            <div>
                                <button type="button"
                                    class="delete-job btn btn-danger d-flex align-items-center gap-2">
                                    <i class="lni lni-trash-can"></i>
                                    Hapus Job
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="form-label" for="status">Status Pengerjaan Job</label>
                            <div class="input-group">
                                <label class="input-group-text" for="status">Pilih</label>
                                <select class="form-control" id="status" name="status[${reportIndex}][]" required>
                                    <option selected>-- Status Pengerjaan --</option>
                                    @foreach ($statuses as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                `);

                $(`#job-container-${reportIndex}`).append(newJobRow);
            });

            $(document).on('click', '.delete-job', function() {
                $(this).closest('.added-job').remove()
            });
        });
    </script>
@endsection
