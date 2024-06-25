<?php

namespace App\Http\Controllers;

use App\Exports\TerimapinjamExport;
use App\Models\Departemen;
use \App\Models\Tanda_terimapinjam;
use \App\Models\Report_terimapinjam;
use \App\Models\Perusahaan;
use \App\Models\Item;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class Report_terimapinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_deptId = Auth::user()->departemen_id;

        $berkass = Tanda_terimapinjam::get();
        $query = Report_terimapinjam::query();

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $berkasInput = $request->berkas;
        $search = $request->search;

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

        $reports = $query->with(['item', 'pengirim_dept', 'penerima_dept', 'tanda_terimapinjam'])->where('departemen_id', '=', $user_deptId)->orderBy('created_at', 'DESC')->paginate(5)->withQueryString();

        return view('dashboard.terimapinjam.report', compact('reports', 'berkass', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perusahaans = Perusahaan::where('id', '<', 6)->get();
        $berkass = Tanda_terimapinjam::get();
        $departemens = Departemen::where('id', '>=', 2)->where('id', '<=', 8)->get();
        return view('dashboard.terimapinjam.addreport', compact('perusahaans', 'berkass', 'departemens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validateData = $request->validate([
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255|different:pengirim',
            'pengirim_dept_id' => 'required',
            'penerima_dept_id' => 'required',
            'perusahaan_id' => 'required',
            'tanda_terimapinjam_id' => 'required',
            'nama_item.*' => 'required|string|max:255',
            'quantity.*' => 'required|string|max:255',
            'detail.*' => 'string|max:255|nullable',
        ], [
            'penerima.different' => 'Pengirim dan Penerima tidak boleh sama.'
        ]);


        $departemen_id = Auth::user()->departemen_id;

        $report = Report_terimapinjam::create([
            'pengirim'=>$validateData['pengirim'],
            'penerima'=>$validateData['penerima'],
            'pengirim_dept_id'=>$validateData['pengirim_dept_id'],
            'penerima_dept_id'=>$validateData['penerima_dept_id'],
            'perusahaan_id'=>$validateData['perusahaan_id'],
            'departemen_id'=>$departemen_id,
            'tanda_terimapinjam_id'=>$validateData['tanda_terimapinjam_id'],
        ]);

        $report->kop_id = intval(htmlspecialchars($report->perusahaan_id . '000' . $report->id));
        $report->save();

        foreach ($validateData['nama_item'] as $key => $item) {
            Item::create([
                'report_terimapinjam_id' => $report->id,
                'nama_item' => htmlspecialchars($item),
                'quantity' => $validateData['quantity'][$key],
                'detail' => htmlspecialchars($validateData['detail'][$key]),
            ]);
        }

        return redirect()->route('report.show', ['id' => $report->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = Report_terimapinjam::with(['item', 'pengirim_dept', 'penerima_dept'])->findOrFail($id);
        $report->terakhir_cetak = Carbon::now();
        $report->save();
        return view('dashboard.terimapinjam.showreport', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Export Excel depends on request
     */
    public function export_excel(Request $request)
    {
        // dd($request->all());
        $fileName = 'Report_Berkas';

        $month = $request->input('month');
        $week = $request->input('week');
        $berkas = $request->input('berkas');

        if ($week) {
            $fileName .= '_Minggu_' . $week;
        }

        if ($month) {
            $fileName .= '_' . $month . '_';
        }

        if ($berkas == 1) {
            $fileName .= '_Tanda_Terima_';
        }

        if ($berkas == 2) {
            $fileName .= '_Tanda_Pinjam_';
        }

        $fileName .= '.xlsx';

        return Excel::download(new TerimapinjamExport($request), $fileName);
    }
}
