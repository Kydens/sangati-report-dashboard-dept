@extends('layout.AppLayout')

@section('content')
    <div class="container-fluid card px-4">
        <div class="row my-3">
            <h2 class="mb-4 fw-bold">Tambah Report</h2>
            <hr />
            <form method="post" action="{{ route('reportIT.store') }}" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <div class="d-flex gap-3 flex-column mb-3 report-row" id="report-0">
                        <h4 class="fw-semibold mb-2">Report 1</h4>
                        <div class="d-flex gap-3 mb-3">
                            <div>
                                <label for="tanggal_pengerjaan" class="form-label">Tanggal Pengerjaan</label>
                                <input type="date" class="form-control" id="tanggal_pengerjaan"
                                    name="tanggal_pengerjaan[]" required>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-3 col">
                            <div class="col">
                                <label for="user_request" class="form-label">PIC Request</label>
                                <input type="text" class="form-control" id="user_request" name="user_request[]"
                                    placeholder="Masukkan Nama PIC" required>
                            </div>
                            <div class="col-md-4">
                                <label for="user_req_perusahaan_id" class="form-label">Perusahaan PIC Request</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="user_req_perusahaan_id">Pilih</label>
                                    <select class="form-control perusahaan-select" id="user_req_perusahaan_id-0"
                                        name="user_req_perusahaan_id[]" data-report-index="0" required>
                                        <option value="" selected>-- Bagian Perusahaan --</option>
                                        @foreach ($perusahaans as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="user_req_departemen_id" class="form-label">Dept. PIC Request</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="user_req_departemen_id">Pilih</label>
                                    <select class="form-control departemen-select" id="user_req_departemen_id-0"
                                        name="user_req_departemen_id[]" data-report-index="0" required>
                                        <option value="" required>-- Bagian Departemen --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col input-group">
                            <label class="input-group-text" for="program">Pilih</label>
                            <select class="form-control program-select" id="program-0" name="program[]" required>
                                <option value="" required>-- Program / Project --</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="col">
                                <label for="jenis_kegiatan" class="form-label">Job</label>
                                <div class="d-flex align-items-start gap-3 mb-2">
                                    <textarea class="form-control" id="jenis_kegiatan" name="jenis_kegiatan[0][]" placeholder="Jelaskan job anda"
                                        style="height: 100px" required></textarea>
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
                                        <select class="form-control" id="status" name="status[0][]" required>
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
                    <button type="button" id="add-report" class="btn btn-dark" style="padding:6px 12p">Tambah
                        Report</button>
                    <button type="button" id="delete-report" class="btn btn-danger" style="padding:6px 12px;">Hapus
                        Penambahan</button>
                    <button type="submit" class="btn btn-success" style="padding:6px 12px;">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let counter = 1;

            function loadDepartments(reportIndex) {
                let req_perusahaan = $(`#user_req_perusahaan_id-${reportIndex}`).val();

                if (req_perusahaan) {
                    $.ajax({
                        url: `{{ url('/dashboard/reportIT/departemen/${req_perusahaan}') }}`,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            let $departemenSelect = $(`#user_req_departemen_id-${reportIndex}`);
                            $departemenSelect.empty();
                            $departemenSelect.append(
                                '<option value="">-- Bagian Departemen --</option>');
                            if (data) {
                                $.each(data, function(key, departemen) {
                                    $departemenSelect.append('<option value="' + departemen.id +
                                        '">' + departemen.nama_departemen + '</option>');
                                });
                            }
                        }
                    });
                }
            }

            function loadPrograms(reportIndex) {
                let req_perusahaan = $(`#user_req_perusahaan_id-${reportIndex}`).val();
                let req_departemen = $(`#user_req_departemen_id-${reportIndex}`).val();

                if (req_perusahaan && req_departemen) {
                    $.ajax({
                        url: `{{ url('/dashboard/reportIT/program/${req_perusahaan}/${req_departemen}') }}`,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            let $programSelect = $(`#program-${reportIndex}`);
                            $programSelect.empty();
                            $programSelect.append(
                                '<option value="">-- Program / Project --</option>');
                            if (data) {
                                $.each(data, function(key, program) {
                                    $programSelect.append('<option value="' + program.id +
                                        '">' + program.nama_program + '</option>');
                                });
                            }
                        }
                    });
                }
            }

            $(document).on('change', '.perusahaan-select', function() {
                let reportIndex = $(this).data('report-index');
                loadDepartments(reportIndex);
            });

            $(document).on('change', '.departemen-select', function() {
                let reportIndex = $(this).data('report-index');
                loadPrograms(reportIndex);
            });

            $('#add-report').click(function() {
                let newReportRow = $(`
                    <div class="d-flex gap-3 flex-column mb-3 report-row" id="report-${counter}">
                        <hr />
                        <h4 class="fw-semibold mb-2">Report ${counter + 1}</h4>
                        <div class="d-flex gap-3 mb-3">
                            <div>
                                <label for="tanggal_pengerjaan" class="form-label">Tanggal Pengerjaan</label>
                                <input type="date" class="form-control" name="tanggal_pengerjaan[]" required>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-3 col">
                            <div class="col">
                                <label for="user_request" class="form-label">PIC Request</label>
                                <input type="text" class="form-control" name="user_request[]" placeholder="Masukkan Nama PIC" required>
                            </div>
                            <div class="col-md-4">
                                <label for="user_req_perusahaan_id" class="form-label">Perusahaan PIC Request</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="user_req_perusahaan_id">Pilih</label>
                                    <select class="form-control perusahaan-select" id="user_req_perusahaan_id-${counter}" name="user_req_perusahaan_id[]" data-report-index="${counter}" required>
                                        <option selected>-- Bagian Perusahaan --</option>
                                        @foreach ($perusahaans as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="user_req_departemen_id" class="form-label">Dept. PIC Request</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="user_req_departemen_id">Pilih</label>
                                    <select class="form-control departemen-select" id="user_req_departemen_id-${counter}" name="user_req_departemen_id[]" data-report-index="${counter}" required>
                                        <option selected>-- Bagian Departemen --</option>
                                        @foreach ($departemens as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col input-group">
                            <label class="input-group-text" for="program">Pilih</label>
                            <select class="form-control program-select" id="program-${counter}" name="program[]" required>
                                <option value="" selected>-- Program / Project --</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="col">
                                <label for="jenis_kegiatan" class="form-label">Job</label>
                                <div class="d-flex align-items-start gap-3 mb-2">
                                    <textarea class="form-control" name="jenis_kegiatan[${counter}][]" placeholder="Jelaskan job anda" style="height: 100px" required></textarea>
                                    <div>
                                        <button type="button" class="add-job btn btn-primary d-flex align-items-center" data-report-index="${counter}">
                                            <i class="lni lni-plus"></i>
                                            Tambah Job
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="status">Status Pengerjaan Job</label>
                                    <div class="input-group">
                                        <label class="input-group-text" for="status">Pilih</label>
                                        <select class="form-control" name="status[${counter}][]" required>
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
                if (counter > 1) {
                    $('.report-row').last().remove();
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
