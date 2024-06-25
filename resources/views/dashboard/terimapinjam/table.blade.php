<table class="table align-middle">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Perusahaan</th>
            <th scope="col">Pengirim</th>
            <th scope="col">Penerima</th>
            <th scope="col">(Qty) Item</th>
            <th scope="col">Jenis Tanda</th>
            <th scope="col">Tanggal Pembuatan</th>
        </tr>
    </thead>
    <tbody>
        @if ($reports->isEmpty())
            <tr>
                <td colspan="8" style="text-align: center">Data tidak ditemukan atau kosong</td>
            </tr>
        @else
            @foreach ($reports as $key => $value)
                <tr>
                    <td>{{ $value->kop_id }}</td>
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
        @endif
    </tbody>
</table>
