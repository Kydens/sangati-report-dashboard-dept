@extends('layout.AppLayout')

@section('content')
    <div class="container-fluid card px-4">
        <div class="row my-3">
            <h2 class="mb-4 fw-bold">Edit Report</h2>
            <hr />
            <form method="post" action="{{ route('weeklyIT.update', $reportAllUsersIT->id) }}" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <div class="d-flex gap-3 flex-column mb-3">
                        <h4 class="fw-semibold mb-2">Report 1</h4>
                        <div class="d-flex gap-3 mb-3">
                            <div>
                                <label for="tanggal_pengerjaan" class="form-label">Tanggal Pengerjaan</label>
                                <input type="date" class="form-control" id="tanggal_pengerjaan" name="tanggal_pengerjaan"
                                    value="{{ old('tanggal_pengerjaan.0', $reportAllUsersIT->tanggal_pengerjaan) }}"
                                    required>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-3 col">
                            <div class="col">
                                <label for="item" class="form-label">PIC Request</label>
                                <input type="text" class="form-control" id="user_request" name="user_request"
                                    placeholder="Masukkan Nama PIC"
                                    value="{{ old('user_request.0', $reportAllUsersIT->user_request) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="item" class="form-label">Perusahaan PIC Request</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="user_req_perusahaan_id">Pilih</label>
                                    <select class="form-control user_req_perusahaan_id" id="user_req_perusahaan_id"
                                        name="user_req_perusahaan_id" required>
                                        <option>-- Bagian Perusahaan --</option>
                                        @foreach ($perusahaans as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $reportAllUsersIT->user_req_perusahaan_id ? 'selected' : '' }}>
                                                {{ $item->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="item" class="form-label">Dept. PIC Request</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="user_req_departemen_id">Pilih</label>
                                    <select class="form-control user_req_departemen_id" id="user_req_departemen_id"
                                        name="user_req_departemen_id" required>
                                        <option>-- Bagian Departemen --</option>
                                        @foreach ($departemens as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $reportAllUsersIT->user_req_departemen_id ? 'selected' : '' }}>
                                                {{ $item->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="program" class="form-label">Program / Project</label>
                            <div class="col input-group">
                                <label class="input-group-text" for="program">Pilih</label>
                                <select class="form-control" id="program" name="program" required>
                                    <option value="" required>-- Program / Project --</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="col added-job">
                                @foreach ($reportAllUsersIT->jobs as $index => $job)
                                    <div class="added-job">
                                        <label for="item" class="form-label">Job</label>
                                        <div class="d-flex align-items-start gap-3 mb-2">
                                            <textarea class="form-control" id="jenis_kegiatan" name="jenis_kegiatan[]" placeholder="Jelaskan job anda"
                                                style="height: 100px" required>{{ old('jenis_kegiatan.0.' . $index, $job->jenis_kegiatan) }}</textarea>
                                            <div>
                                                <button type="button"
                                                    class="delete-job btn btn-danger d-flex align-items-center">
                                                    <i class="lni lni-trash-can"></i>
                                                    Hapus Job
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label" for="status">Status Pengerjaan Job</label>
                                            <div class="input-group">
                                                <label class="input-group-text" for="status">Pilih</label>
                                                <select class="form-control" id="status" name="status[]" required>
                                                    <option>-- Status Pengerjaan --</option>
                                                    @foreach ($statuses as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ $key == $job->status ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div id="job-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 d-flex align-items-center gap-2 mb-4">
                    <button type="button" class="add-job btn btn-primary d-flex align-items-center">
                        <i class="lni lni-plus"></i>
                        Tambah Job
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
        $(document).ready(function() {
            let counter = 1;

            $(document).ready(function() {
                function loadPrograms(req_perusahaan, req_departemen) {
                    if (req_perusahaan && req_departemen) {
                        $.ajax({
                            url: `/dashboard/reportIT/program/${req_perusahaan}/${req_departemen}`,
                            type: 'GET',
                            data: {
                                '_token': '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(data) {
                                let $programSelect = $('#program');
                                $programSelect.empty();
                                $programSelect.append(
                                    '<option value="" required>-- Program / Project --</option>'
                                );
                                if (data) {
                                    $.each(data, function(key, program) {
                                        $programSelect.append(
                                            '<option value="' + program.id + '">' +
                                            program.nama_program + '</option>');
                                    });
                                } else {
                                    $programSelect.append(
                                        '<option value="" required>-- Kosong --</option>');
                                }
                            }
                        });
                    }
                }

                // Initial load
                loadPrograms($('#user_req_perusahaan_id').val(), $('#user_req_departemen_id').val());

                // Load programs when perusahaan or departemen is changed
                $('#user_req_perusahaan_id, #user_req_departemen_id').on('change', function() {
                    let req_perusahaan = $('#user_req_perusahaan_id').val();
                    let req_departemen = $('#user_req_departemen_id').val();
                    loadPrograms(req_perusahaan, req_departemen);
                });
            });

            $(document).on('click', '.add-job', function() {
                let newJobRow = $(`
                    <div class="added-job">
                        <label for="item" class="form-label">Job</label>
                        <div class="d-flex align-items-start gap-3 mb-2">
                            <textarea class="form-control" id="jenis_kegiatan" name="jenis_kegiatan[]" placeholder="Jelaskan job anda"
                                style="height: 100px" required></textarea>
                            <div>
                                <button type="button" class="delete-job btn btn-danger d-flex align-items-center">
                                    <i class="lni lni-trash-can"></i>
                                    Hapus Job
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="status">Status Pengerjaan Job</label>
                            <div class="input-group">
                                <label class="input-group-text" for="status">Pilih</label>
                                <select class="form-control" id="status" name="status[]" required>
                                    <option>-- Status Pengerjaan --</option>
                                    @foreach ($statuses as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                `);

                $(`#job-container`).append(newJobRow);
            });

            $(document).on('click', '.delete-job', function() {
                if (counter > 1) {
                    $(this).closest('.added-job').remove()
                    counter--;
                }
            });
        });
    </script>
@endsection
