@extends('layout.PrintLayout')

@section('content')
    <p class="text-center text-uppercase mb-0 text-decoration-underline fw-bold" style="font-size: 18px;">
        {{ $report->tanda_terimapinjam->jenis }}
    </p>
    <table class="table table-borderless">
        <tbody>
            <tr>
                <td style="width: 1%; white-space: nowrap;">
                    Telah terima dari
                </td>
                <td>: {{ $report->pengirim }}
                    ({{ $report->pengirim_dept->nama_departemen }})</td>
            </tr>
            <tr>
                <td style="width: 1%; white-space: nowrap;">Kepada</td>
                <td>: {{ $report->penerima }} ({{ $report->penerima_dept->nama_departemen }})</td>
            </tr>
            <tr>
                <td style="width: 1%; white-space: nowrap;">Berupa</td>
                <td>:
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
