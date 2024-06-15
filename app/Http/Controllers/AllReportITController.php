<?php

namespace App\Http\Controllers;

use App\Exports\ReportAllUsersITExport;
use App\Models\Perusahaan;
use App\Models\Programs;
use App\Models\Report_userit;
use App\Models\Departemen;
use App\Models\Jobs;

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
        // dd($request->all());
        $perusahaans = Perusahaan::get();
        $departemens = Departemen::where('id', '>=', 2)->get();
        $query = Report_userit::query();

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $companyRequest = $request->user_req_perusahaan;
        $deptRequest = $request->user_req_departemen;

        if (isset($start_date) && isset($end_date) && $start_date > $end_date) {
            return redirect()->route('weeklyIT.index')->with('error', 'Start Date Melebihi End Date');
        }

        if ($deptRequest == 1) {
            return redirect()->route('weeklyIT.index');
        }

        if($start_date && $end_date) {
            $query->whereDate('tanggal_pengerjaan', '>=', $start_date)->whereDate('tanggal_pengerjaan', '<=', $end_date);
        }

        if (isset($companyRequest) && ($companyRequest != 0)) {
            $query->where('user_req_perusahaan_id', '=', $companyRequest);
        }

        if (isset($deptRequest) && ($deptRequest != 0)) {
            $query->where('user_req_departemen_id', '=', $deptRequest);
        }

        // dd($query);

        $reportAllUsersIT = $query->with('jobs')->orderBy('user_req_perusahaan_id', 'ASC')->orderBy('programs_id', 'ASC')->orderBy('tanggal_pengerjaan', 'ASC')->paginate(5);
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
        $statuses = Jobs::getStatuses();
        $perusahaans = Perusahaan::get();
        $departemens = Departemen::where('id', '>=', 2)->get();
        $programs = Programs::orderby('nama_program', 'ASC')->get();
        $reportAllUsersIT = Report_userit::findOrFail($id);
        return view('dashboard.dept_it.report.each_user.editUserReport', compact('statuses', 'departemens', 'perusahaans', 'programs', 'reportAllUsersIT'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $validateData = $request->validate([
            'user_req_departemen_id'=>'required',
            'user_req_perusahaan_id'=>'required',
            'user_request'=>'required|string|max:255',
            'program'=>'required|string|max:255',
            'jenis_kegiatan.*'=>'required|string|max:255',
            'status.*'=>'required|in:' . implode(',', array_keys(Jobs::getStatuses())),
            'tanggal_pengerjaan'=>'required|date',
        ]);

        // dd($validateData);

        $reportAllUsersIT = Report_userit::findOrFail($id);

        $reportAllUsersIT->update([
            'user_req_perusahaan_id' => $validateData['user_req_perusahaan_id'],
            'user_req_departemen_id' => $validateData['user_req_departemen_id'],
            'user_request' => $validateData['user_request'],
            'program' => $validateData['program'],
            'tanggal_pengerjaan' => $validateData['tanggal_pengerjaan'],
        ]);

        $reportAllUsersIT->jobs()->delete();

        foreach($validateData['jenis_kegiatan'] as $key => $jenis_kegiatan) {
            $jobs = Jobs::create([
                'report_userit_id' => $reportAllUsersIT->id,
                'jenis_kegiatan' => $jenis_kegiatan,
                'status' => $validateData['status'][$key],
            ]);
        }

        return redirect()->route('weeklyIT.index')->with('success', 'Report Telah Diedit');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $report = Report_userit::findOrFail($id);
        $report->delete();

        return redirect()->route('weeklyIT.index')->with('remove', 'Report Terhapus');
    }

    public function export_excel(Request $request)
    {
        $fileName = 'ITReport';

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $company = $request->user_req_perusahaan;
        $dept = $request->user_req_departemen;


        if ($dept == 1) {
            return redirect()->route('weeklyIT.index');
        }

        if ($start_date) {
            $fileName .= '_' . Carbon::parse($start_date)->format('d_M_Y');
        }

        if ($end_date) {
            $fileName .= '_-_' .  Carbon::parse($end_date)->format('d_M_Y');
        }

        if ($company && $company != 0) {
            $reportUserIT = Report_userit::with('perusahaan')->where('user_req_perusahaan_id', $company)->first();

            if($reportUserIT != null) {
                $fileName .= '_' . $reportUserIT->perusahaan->nama_perusahaan;
            }
        }

        if ($dept && $dept != 0) {
            $reportUserIT = Report_userit::with('departemen')->where('user_req_departemen_id', $dept)->first();

            if($reportUserIT != null) {
                $fileName .= '_' . $reportUserIT->departemen->nama_departemen;
            }
        }

        $fileName .= '.xlsx';

        return Excel::download(new ReportAllUsersITExport($request), $fileName);
    }
}
