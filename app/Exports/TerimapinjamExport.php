<?php

namespace App\Exports;

use App\Models\Report_terimapinjam;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TerimapinjamExport implements FromView, ShouldAutoSize, WithStyles, WithDefaultStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use RegistersEventListeners;

    private $request;
    private $reports;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->loadData();
    }

    private function loadData() {
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

        $this->reports = $query->with(['item', 'pengirim_dept', 'penerima_dept', 'tanda_terimapinjam'])->orderBy('created_at', 'DESC')->get();
    }

    public function view(): View
    {
        return view('dashboard.terimapinjam.table',[
            'reports' => $this->reports
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

     public function afterSheet(AfterSheet $event) {
        $sheet =  $event->sheet->getDelegate();
        $dataReport = $this->reports;

        $rowData = 2;

        foreach($dataReport as $row) {
            $color = 'FFFFFF';

            if ($row->perusahaan->id == 1 || $row->perusahaan->id == 3 || $row->perusahaan->id == 4 || 5) {
                $color = 'FFE699';
            } elseif ($row->perusahaan->id == 2) {
                $color = 'C6EFCE';
            }

            if ($color) {
                $sheet->getStyle("A{$rowData}:H{$rowData}")->applyFromArray([
                    'fill'=>[
                        'fillType'=>Fill::FILL_SOLID,
                        'color'=>['rgb'=>$color]
                    ]
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

    public function defaultStyles(Style $defaultStyle) {
        return [
            'font'=>[
                'name'=>'Calibri',
                'size'=>11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];
    }
}
