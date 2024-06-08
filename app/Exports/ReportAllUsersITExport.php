<?php

namespace App\Exports;

use App\Models\Report_userit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportAllUsersITExport implements FromView, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }
    public function view(): View
    {
        $query = Report_userit::query();

        $monthInput = $this->request->input('month');
        $weekInput = $this->request->input('week');

        if ($weekInput && !$monthInput) {
            return redirect('/dashboard/weeklyIT')->with('error', 'Input Minggu tidak dapat kosong');
        }

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

            if (isset($weekInput) && ($weekInput != 0)) {
                $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            } else {
                $query->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month);
            }
        }

        if (isset($companyRequest) && ($companyRequest != 0)) {
            $query->where('user_req_perusahaan_id', '=', $companyRequest);
        }

        if (isset($deptRequest) && ($deptRequest != 0)) {
            $query->where('user_req_departemen_id', '=', $deptRequest);
        }

        $reportAllUsersIT = $query->orderBy('user_req_perusahaan_id', 'ASC')->orderBy('created_at', 'ASC')->get();
        return view('dashboard.dept_it.report.all_user.table', compact('reportAllUsersIT'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
