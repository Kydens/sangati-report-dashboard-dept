<table class="table align-middle">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Perusahaan</th>
            <th scope="col">Pengirim</th>
            <th scope="col">Penerima</th>
            <th scope="col">(Qty) Item</th>
            <th scope="col">Jenis Tanda</th>
            <th scope="col">Tanggal Pembuatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $key => $value)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $value->perusahaan->nama_perusahaan }}</td>
                <td>{!! Str::ucfirst($value->pengirim) !!}</td>
                <td>{!! Str::ucfirst($value->penerima) !!}</td>
                <td>
                    @php
                        $items = $value->item
                            ->map(function ($item) {
                                if ($item->detail) {
                                    return Str::ucfirst("({$item->quantity}) {$item->nama_item} ({$item->detail})");
                                }

                                return Str::ucfirst("({$item->quantity}) {$item->nama_item}");
                            })
                            ->toArray();

                    @endphp
                    {!! implode('<br />', $items) !!}
                </td>
                <td class="fw-bold">{{ $value->tanda_terimapinjam->jenis }}</td>
                <td>{{ $value->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
