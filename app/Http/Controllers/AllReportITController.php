<?php

namespace App\Http\Controllers;

use App\Exports\ReportAllUsersITExport;
use App\Models\Perusahaan;
use App\Models\Report_userit;
use App\Models\Departemen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AllReportITController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request);
        $perusahaans = Perusahaan::get();
        $departemens = Departemen::where('id', '>=', 2)->get();
        $query = Report_userit::query();

        $monthInput = $request->input('month');
        $weekInput = $request->input('week');
        $companyRequest = $request->input('user_req_perusahaan');
        $deptRequest = $request->input('user_req_departemen');

        if ($weekInput && !$monthInput) {
            return redirect()->back()->with('error', 'Input Minggu tidak dapat kosong');
        }

        if ($deptRequest == 1) {
            return redirect()->route('weeklyIT.index');
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

        $reportAllUsersIT = $query->orderBy('created_at', 'ASC')->orderBy('user_req_perusahaan_id', 'ASC')->paginate(10);
        return view('dashboard.dept_it.report.all_user.allReport', compact('reportAllUsersIT', 'perusahaans', 'departemens', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $statuses = Report_userit::getStatuses();
        $perusahaans = Perusahaan::get();
        $departemens = Departemen::where('id', '>=', 2)->get();
        $reportAllUsersIT = Report_userit::findOrFail($id);
        return view('dashboard.dept_it.report.each_user.editUserReport', compact('statuses', 'departemens', 'perusahaans', 'reportAllUsersIT'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'user_req_departemen_id'=>'required',
            'user_req_perusahaan_id'=>'required',
            'user_request'=>'required|string|max:255',
            'program'=>'required|string|max:255',
            'jenis_kegiatan'=>'required|string|max:255',
            'status'=> 'required|in:' . implode(',', array_keys(Report_userit::getStatuses())),
        ]);

        $reportAllUsersIT = Report_userit::findOrFail($id);
        $users_id = $reportAllUsersIT->users_id;

        $validateData['users_id'] = $users_id;
        $reportAllUsersIT->update($validateData);


        return redirect('/dashboard/weeklyIT')->with('success', 'Report Telah Diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export_excel(Request $request)
    {
        $fileName = 'Report-IT';

        $month = $request->input('month');
        $week = $request->input('week');
        $company = $request->input('user_req_perusahaan');
        $dept = $request->input('user_req_departemen');



        if ($dept == 1) {
            return redirect()->route('weeklyIT.index');
        }

        if ($week) {
            $fileName .= '_Minggu_' . $week;
        }

        if ($month) {
            $fileName .= '_Bulan_' . $month;
        }

        if ($company && $company != 0) {
            $reportUserIT = Report_userit::with('perusahaan')->where('user_req_perusahaan_id', $company)->first();

            $fileName .= '_Perusahaan_' . $reportUserIT->perusahaan->nama_perusahaan;
        }

        if ($dept && $dept != 0) {
            $reportUserIT = Report_userit::with('departemen')->where('user_req_departemen_id', $dept)->first();

            $fileName .= '_Departemen_' . $reportUserIT->departemen->nama_perusahaan;
        }

        $fileName .= '.xlsx';

        return Excel::download(new ReportAllUsersITExport($request), $fileName);
    }
}
