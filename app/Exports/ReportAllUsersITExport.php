<?php

namespace App\Exports;

use App\Models\Report_userit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;

use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportAllUsersITExport implements FromView, ShouldAutoSize, WithStyles, WithEvents, WithDefaultStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use RegistersEventListeners;

    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }
    public function view(): View
    {
        $query = Report_userit::query();

        $start_date = $this->request->start_date;
        $end_date = $this->request->end_date;
        $companyRequest = $this->request->user_req_perusahaan;
        $deptRequest = $this->request->user_req_departemen;

        if (isset($start_date) && isset($end_date) && $start_date >= $end_date) {
            return redirect()->back();
        }

        if ($deptRequest == 1) {
            return redirect()->route('weeklyIT.index');
        }

        if($start_date && $end_date) {
            $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
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

    public static function afterSheet(AfterSheet $event) {
        $sheet =  $event->sheet->getDelegate();
        $dataReport = Report_userit::orderBy('user_req_perusahaan_id', 'ASC')->orderBy('created_at', 'ASC')->get();

        $rowData = 2;

        foreach($dataReport as $row) {
            $color = 'FFFFFF';

            if ($row->user_req_perusahaan_id == 1) {
                $color = 'FFD966';
            }

            if ($row->user_req_perusahaan_id == 2) {
                $color = 'C6EFCE';
            }

            if ($row->user_req_perusahaan_id == 3) {
                $color = 'FFE699';
            }

            if ($row->user_req_perusahaan_id == 4) {
                $color = 'FBEEC1';
            }

            if ($row->user_req_perusahaan_id == 5) {
                $color = '1568AB';
            }


            if ($color) {
                $sheet->getStyle("A{$rowData}:G{$rowData}")->applyFromArray([
                    'fill'=>[
                        'fillType'=>Fill::FILL_SOLID,
                        'color'=>['rgb'=>$color]
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            }

            $rowData++;
        }

        $sheet->getStyle("A1:G1")->applyFromArray([
            'fill'=>[
                'fillType'=>Fill::FILL_SOLID,
                'color'=>['rgb'=>'D0CECE']
            ]
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'=>[
                    'bold'=>true,
                    'color'=>['rgb'=>'000000'],
                ],
            ],
        ];
    }

    public function defaultStyles(Style $defaultStyle) {
        return [
            'font'=>[
                'name'=>'Calibri',
                'size'=>11,
                'color'=>['rgb'=>'305496'],
            ],
            'alignment'=>[
                'vertical'=>Alignment::VERTICAL_TOP,
            ]
        ];
    }
}
