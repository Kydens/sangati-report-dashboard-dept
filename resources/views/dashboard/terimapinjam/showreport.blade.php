@extends('layout.PrintLayout')

@section('content')
    <p class="text-center text-uppercase mb-0 text-decoration-underline fw-bold" style="font-size: 18px;">
        {{ $report->tanda_terimapinjam->jenis }}
    </p>
    <table class="table table-borderless d-flex justify-content-start">
        <tbody>
            <tr>
                <td class="font">Telah terima dari</td>
                <td class="font">: {{ $report->pengirim }} ({{ $report->pengirim_dept->nama_departemen }})</td>
            </tr>
            <tr>
                <td class="font">Kepada</td>
                <td class="font">: {{ $report->penerima }} ({{ $report->penerima_dept->nama_departemen }})</td>
            </tr>
            <tr>
                <td class="font">Berupa</td>
                <td class="font">:
                    @php
                        $items = $report->item
                            ->map(function ($item) {
                                if ($item->detail) {
                                    return "{$item->quantity} {$item->nama_item} ({$item->detail})";
                                }

                                return "{$item->quantity} {$item->nama_item}";
                            })
                            ->toArray();

                        echo implode(', ', $items);
                    @endphp
                </td>
            </tr>
        </tbody>
    </table>
@endsection
