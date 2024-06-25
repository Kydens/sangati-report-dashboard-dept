<table>
    <thead>
        <tr>
            <th>Perusahaan PIC Request</th>
            <th>Departemen PIC Request</th>
            <th>Program / Project</th>
            <th>Tanggal</th>
            <th>PIC Request</th>
            <th>Jenis Kegiatan</th>
            <th>Status</th>
            <th>PIC</th>
        </tr>
    </thead>
    <tbody>
        @if ($reportAllUsersIT->isEmpty())
            <tr>
                <td colspan="8" style="text-align: center">Data tidak ditemukan atau kosong</td>
            </tr>
        @else
            @foreach ($reportAllUsersIT as $key => $value)
                <tr>
                    <td>{{ $value->perusahaan->nama_perusahaan }}</td>
                    <td>{{ $value->departemen->nama_departemen }}</td>
                    <td>{!! $value->program->nama_program !!}</td>
                    <td>{{ \Carbon\Carbon::parse($value->tanggal_pengerjaan)->format('d M Y') }}</td>
                    <td>{!! Str::ucfirst($value->user_request) !!}</td>
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
