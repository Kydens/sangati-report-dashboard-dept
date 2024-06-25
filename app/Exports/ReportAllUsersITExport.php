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
    private $reportAllUsersIT;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->loadData();
    }

    private function loadData()
    {
        $query = Report_userit::query();

        $start_date = $this->request->start_date;
        $end_date = $this->request->end_date;
        $companyRequest = $this->request->user_req_perusahaan;
        $deptRequest = $this->request->user_req_departemen;

        if (isset($start_date) && isset($end_date) && $start_date >= $end_date) {
            throw new \Exception('Start date must be earlier than end date');
        }

        if ($deptRequest == 1) {
            throw new \Exception('Invalid department');
        }

        if($start_date && $end_date) {
            $query->whereDate('tanggal_pengerjaan', '>=', $start_date)
                  ->whereDate('tanggal_pengerjaan', '<=', $end_date);
        }

        if (isset($companyRequest) && ($companyRequest != 0)) {
            $query->where('user_req_perusahaan_id', '=', $companyRequest);
        }

        if (isset($deptRequest) && ($deptRequest != 0)) {
            $query->where('user_req_departemen_id', '=', $deptRequest);
        }

        $this->reportAllUsersIT = $query->with(['perusahaan', 'departemen', 'program', 'jobs'])->orderBy('user_req_perusahaan_id', 'ASC')->orderBy('user_req_departemen_id', 'ASC')->orderBy('programs_id', 'ASC')->orderBy('tanggal_pengerjaan', 'ASC')->orderBy('users_id', 'ASC')->get();
    }

    public function view(): View
    {
        return view('dashboard.dept_it.report.all_user.table', [
            'reportAllUsersIT' => $this->reportAllUsersIT
        ]);

    }

    public function afterSheet(AfterSheet $event) {
        $sheet =  $event->sheet->getDelegate();
        $dataReport = $this->reportAllUsersIT;

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
                $color = 'C5D9F1';
            }

            if ($row->user_req_perusahaan_id == 6) {
                $color = 'EEECE1';
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

        $sheet->getStyle("A1:H1")->applyFromArray([
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
