<?php

namespace App\Exports;

use App\Models\Report_terimapinjam;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TerimapinjamExport implements FromView, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
        // dd($request);
    }

    public function view(): View
    {
        $query = Report_terimapinjam::query();

        $monthInput = $this->request->month;
        $weekInput = $this->request->week;
        $berkasInput = $this->request->berkas;

        if ($monthInput) {
            $month = substr($monthInput, 5, 2);
            $year = substr($monthInput, 0, 4);

            $startOfMonth = Carbon::create($year, $month, 1);
            $startOfWeek = $startOfMonth->copy()->addWeeks($weekInput - 1)->startOfWeek(Carbon::MONDAY);
            $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);

            if ($startOfWeek->month != $month) {
                $startOfWeek = $startOfMonth;
            }
            if ($endOfWeek->month != $month) {
                $endOfWeek = $startOfMonth->copy()->endOfMonth();
            }

            if (isset($weekInput) && ($weekInput != null)) {
                $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            } else {
                $query->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month);
            }
        }

        if(isset($berkasInput) && ($berkasInput != 0))
        {
            $query->where('tanda_terimapinjam_id', '=', $berkasInput);

        };

        $reports = $query->with('item')->orderBy('created_at', 'DESC')->get();

        return view('dashboard.terimapinjam.table', compact('reports'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}