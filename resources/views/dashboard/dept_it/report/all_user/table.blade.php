<table class="table">
    <thead>
        <tr class="table-dark align-middle text-center">
            <th scope="col" class="text-center">Tanggal</th>
            <th scope="col" class="text-center">Perusahaan PIC Request</th>
            <th scope="col" class="text-center">Program / Project</th>
            <th scope="col" class="text-center">PIC Request</th>
            <th scope="col" class="text-center col-md-4">Jenis Kegiatan</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">PIC</th>
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
                    <td>{{ \Carbon\Carbon::parse($value->tanggal_pengerjaan)->format('d M Y') }}</td>
                    <td>{{ $value->perusahaan->nama_perusahaan }}</td>
                    <td>{!! Str::ucfirst($value->program) !!}</td>
                    <td>
                        {!! Str::ucfirst($value->user_request) !!}
                        <br>
                        <small>({{ $value->departemen->nama_departemen }})</small>
                    </td>
                    <td>
                        @php
                            $jobs = $value->jobs
                                ->map(function ($job) {
                                    return Str::ucfirst("{$job->jenis_kegiatan}");
                                })
                                ->toArray();
                        @endphp
                        {!! implode('<br />', $jobs) !!}
                    </td>
                    <td>
                        @php
                            $jobs = $value->jobs
                                ->map(function ($job) {
                                    return Str::ucfirst("{$job->status}");
                                })
                                ->toArray();
                        @endphp
                        {!! implode('<br />', $jobs) !!}
                    </td>
                    <td>{{ Str::ucfirst($value->users->username) }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
