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

        $monthInput = $request->month;
        $weekInput = $request->week;
        $berkasInput = $request->berkas;

        if ($weekInput && !$monthInput) {
            return redirect()->back()->with('error', 'Minggu tidak dapat kosong');
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

        if(isset($berkasInput) && ($berkasInput != 0))
        {
            $query->where('tanda_terimapinjam_id', '=', $berkasInput);

        };

        if($user_deptId == 1) {
            $reports = $query->with('item')->orderBy('created_at', 'DESC')->paginate(5)->withQueryString();
        } else {
            $reports = $query->with('item')->where('departemen_id', '=', $user_deptId)->orderBy('created_at', 'DESC')->paginate(5)->withQueryString();
        }

        return view('dashboard.terimapinjam.report', compact('reports', 'berkass', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perusahaans = Perusahaan::get();
        $berkass = Tanda_terimapinjam::get();
        $departemens = Departemen::where('id', '>=', 2)->get();
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
        $validateData['departemen_id'] = $departemen_id;

        // dd($validateData);

        $report = Report_terimapinjam::create($validateData);

        foreach ($validateData['nama_item'] as $key => $item) {
            Item::create([
                'report_terimapinjam_id' => $report->id,
                'nama_item' => $item,
                'quantity' => $validateData['quantity'][$key],
                'detail' => $validateData['detail'][$key],
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
        // ddd($request);
        $fileName = 'Report';

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
            $fileName .= '_Berkas_Tanda_Terima_';
        }

        if ($berkas == 2) {
            $fileName .= '_Berkas_Tanda_Pinjam_';
        }

        $fileName .= '.xlsx';

        return Excel::download(new TerimapinjamExport($request), $fileName);
    }
}
