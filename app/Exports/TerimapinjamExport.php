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
        // dd($this->request->all());
        $this->loadData();
    }

    private function loadData()
    {
        $query = Report_terimapinjam::query();

        $start_date = $this->request->start_date;
        $end_date = $this->request->end_date;
        $berkasInput = $this->request->berkas;
        $search = $this->request->search;

        if (isset($start_date) && isset($end_date) && $start_date > $end_date) {
            return redirect()->route('report.index')->with('error', 'Start Date Melebihi End Date');
        }

        if(isset($start_date) && isset($end_date)) {
            $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        }

        if(isset($berkasInput) && $berkasInput != 0)
        {
            $query->where('tanda_terimapinjam_id', '=', $berkasInput);
        };

        if(isset($search)) {
            $query->where(function($query) use ($search) {
                $query->where('kop_id', 'like', '%' . $search . '%')
                    ->orWhere('pengirim', 'like', '%' . $search . '%')
                    ->orWhere('penerima', 'like', '%' . $search . '%')
                    ->orWhereHas('item', function($query) use ($search) {
                        $query->where('nama_item', 'like', '%' . $search . '%');
                    });
            });
        }

        $this->reports = $query->with(['item', 'pengirim_dept', 'penerima_dept', 'tanda_terimapinjam'])->orderBy('perusahaan_id', 'ASC')->orderBy('kop_id', 'ASC')->get();
    }

    public function view(): View
    {
        // dd($this->reports);
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
