<table class="table align-middle">
    <thead>
        <tr class="table-dark align-middle">
            <th scope="col" class="text-center">Tanggal</th>
            <th scope="col" class="text-center">PIC Request</th>
            <th scope="col" class="text-center">Perusahaan PIC Request</th>
            <th scope="col" class="text-center">Departemen PIC Request</th>
            <th scope="col" class="text-center">Program / Project</th>
            <th scope="col" class="text-center col-md-4">Jenis Kegiatan</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">PIC</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reportAllUsersIT as $key => $value)
            <tr>
                <td style="width: 1%; white-space:nowrap">{{ $value->created_at }}</td>
                <td>{{ $value->user_request }}</td>
                <td>{{ $value->perusahaan->nama_perusahaan }}</td>
                <td>{{ $value->departemen->nama_departemen }}</td>
                <td>{{ $value->program }}</td>
                <td>{{ $value->jenis_kegiatan }}</td>
                <td class="{{ $value->status == 'Proses' ? 'table-warning text-center' : 'table-success text-center' }}"
                    style="width: 1%; white-space:nowrap">
                    {{ $value->status }}
                </td>
                <td class="text-capitalize">{{ $value->users->username }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
