@extends('layout.AppLayout')

@section('content')
    <div class="container-fluid card px-4">
        <div class="row my-3">
            <h2 class="mb-4">Tambah Report</h2>
            <form method="post" action="{{ route('weeklyIT.update', $reportAllUsersIT->id) }}" autocomplete="off">
                @csrf
                <input type="hidden" id="hidden_input" name="hidden_input" />
                <div class="mb-3">
                    <div class="d-flex gap-3 flex-column mb-3">
                        <div class="d-flex gap-3 mb-3 col">
                            <div class="col">
                                <label for="item" class="form-label">PIC Request</label>
                                <input type="text" class="form-control" id="user_request" name="user_request"
                                    placeholder="Masukkan Nama PIC" value="{{ $reportAllUsersIT->user_request }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="item" class="form-label">Perusahaan PIC Request</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="user_req_perusahaan_id">Pilih</label>
                                    <select class="form-control" id="user_req_perusahaan_id" name="user_req_perusahaan_id"
                                        required>
                                        <option>-- Bagian Perusahaan --</option>
                                        @foreach ($perusahaans as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $reportAllUsersIT->user_req_perusahaan_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="item" class="form-label">Dept. PIC Request</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="user_req_departemen_id">Pilih</label>
                                    <select class="form-control" id="user_req_departemen_id" name="user_req_departemen_id"
                                        required>
                                        <option>-- Bagian Departemen --</option>
                                        @foreach ($departemens as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $reportAllUsersIT->user_req_departemen_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="program" class="form-label">Program / Project</label>
                            <input type="text" class="form-control" id="program" name="program"
                                placeholder="Masukkan Program / Project" value="{{ $reportAllUsersIT->program }}" required>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="col">
                                <label for="item" class="form-label">Job</label>
                                <textarea class="form-control" id="jenis_kegiatan" name="jenis_kegiatan" placeholder="Jelaskan job anda"
                                    style="height: 100px" required>{{ $reportAllUsersIT->jenis_kegiatan }}</textarea>
                            </div>
                            <div id="job-container"></div>
                            {{-- <div class="mt-2 col">
                                <button type="button" id="add-job" class="btn btn-dark"
                                    style="padding:6px 12px; width:fit-content;">
                                    Tambah Job
                                </button>
                                <button type="button" id="delete-job" class="btn btn-danger"
                                    style="padding:6px 12px; width:fit-content;">
                                    Hapus Job
                                </button>
                            </div> --}}
                        </div>
                        <div class="mt-3 d-flex gap-3">
                            <div>
                                <label for="tanggal_pengerjaan" class="form-label">Tanggal Pengerjaan</label>
                                <input type="date" class="form-control" id="tanggal_pengerjaan"
                                    name="tanggal_pengerjaan[]"
                                    value="{{ \Carbon\Carbon::parse($reportAllUsersIT->tanggan_pengerjaan)->format('Y-m-d') }}"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="status">Status Pengerjaan Job</label>
                                <div class="input-group">
                                    <label class="input-group-text" for="status">Pilih</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option selected>-- Status Pengerjaan --</option>
                                        @foreach ($statuses as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $reportAllUsersIT->status == $key ? 'selected' : '' }}>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="report-container"></div>
                </div>
                <div class="mb-3 d-flex align-items-center gap-2 mb-4">
                    <button type="submit" class="btn btn-success" style="padding:6px 12px;">
                        Edit
                    </button>
                </div>
                {{-- <div class="mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-end">
                                <button type="submit" class="btn btn-success d-flex align-items-center gap-3"
                                    id="submit">
                                    Submit Report
                                </button>
                            </div>
                            <div class="card-text">
                                <table class="table table-bordered" id="job_table">
                                    <thead>
                                        <tr class="table-dark text-center">
                                            <th class="col">Program / Project</th>
                                            <th class="col-md-8">Jobs</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function dataTable() {
                let sessionJobs = JSON.parse(sessionStorage.getItem('jobs')) || [];
                let tableBody = $('.table-body');

                tableBody.empty();

                sessionJobs.forEach((job) => {
                    let newRow =
                        '<tr class="table-row"><td>' + job.program + '</td><td>' + job.jenis_kegiatan +
                        '</td></tr>';
                    $('.table-body').append(newRow);

                    $('#hidden_input').val(JSON.stringify(sessionJobs));
                });
            }

            $('#add-report').click(function() {
                let newReportRow = $(`
                    <div class="d-flex gap-3 flex-column mb-3 report-row">
                        <hr />
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
                                placeholder="Masukkan Program / Project" required>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="col">
                                <label for="item" class="form-label">Job</label>
                                <textarea class="form-control" id="jenis_kegiatan" name="jenis_kegiatan[]" placeholder="Jelaskan job anda"
                                    style="height: 100px" required></textarea>
                            </div>
                            <div id="job-container"></div>

                        </div>
                        <div class="mt-3 d-flex gap-3">
                            <div>
                                <label for="tanggal_pengerjaan" class="form-label">Tanggal Pengerjaan</label>
                                <input type="date" class="form-control" id="tanggal_pengerjaan" name="tanggal_pengerjaan[]" required>
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
                $('#report-container').append(newReportRow);
            });

            $('#delete-report').click(function() {
                $('.report-row').last().remove();
            });

            // $('#add-job').click(function() {
            //     // debugger;
            //     let program = $('#program').val();
            //     let jenis_kegiatan = $('#jenis_kegiatan').val();

            //     if (jenis_kegiatan != '' && program != '') {
            //         let jobData = {
            //             // 'program': program,
            //             'jenis_kegiatan': jenis_kegiatan
            //         };

            //         let sessionJobs = JSON.parse(sessionStorage.getItem('jobs')) || [];
            //         sessionJobs.push(jobData);
            //         sessionStorage.setItem('jobs', JSON.stringify(sessionJobs));

            //         console.log(sessionJobs);

            //         dataTable();
            //     }
            // });

            // $('#submit').click(function() {
            //     sessionStorage.clear();
            // })

            // $('#delete-job').click(function() {
            //     let sessionJobs = JSON.parse(sessionStorage.getItem('jobs')) || [];
            //     sessionJobs.pop()
            //     sessionStorage.setItem('jobs', JSON.stringify(sessionJobs));
            //     $('.table-row').last().remove();

            //     dataTable();
            // });

            dataTable();
        });
    </script>
@endsection
