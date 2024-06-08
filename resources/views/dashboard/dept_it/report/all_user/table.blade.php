<table class="table align-middle">
    <thead>
        <tr class="table-dark align-middle">
            <th scope="col" class="text-center">Perusahaan</th>
            <th scope="col" class="text-center">Departemen</th>
            <th scope="col" class="text-center">Program / Project</th>
            <th scope="col" class="text-center">Date</th>
            <th scope="col" class="text-center">PIC Request</th>
            <th scope="col" class="text-center">Jenis Kegiatan</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">PIC</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reportAllUsersIT as $key => $value)
            <tr>
                <td class="text-capitalize">{{ $value->perusahaan->nama_perusahaan }}</td>
                <td class="text-capitalize">{{ $value->departemen->nama_departemen }}</td>
                <td class="text-capitalize">{{ $value->program }}</td>
                <td>{{ $value->created_at }}</td>
                <td class="text-capitalize">{{ $value->user_request }}</td>
                <td class="text-capitalize">{{ $value->jenis_kegiatan }}</td>
                <td class="text-capitalize">{{ $value->status }}</td>
                <td class="text-capitalize">{{ $value->users->username }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
