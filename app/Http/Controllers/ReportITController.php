<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jobs;
use App\Models\Perusahaan;
use App\Models\Report_userit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportITController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->id;
        $reportUserIT = Report_userit::where('users_id', '=', $user)->orderBy('tanggal_pengerjaan', 'DESC')->paginate(10);
        return view('dashboard.dept_it.report.each_user.userReport', compact('reportUserIT'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = Jobs::getStatuses();
        $departemens = Departemen::where('id', '>=', 2)->get();
        $perusahaans = Perusahaan::get();
        return view('dashboard.dept_it.report.each_user.createUserReport', compact('statuses', 'departemens', 'perusahaans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd(Jobs::getStatuses());
        // dd($request->all());

        $validateData = $request->validate([
            'user_req_departemen_id.*'=>'required',
            'user_req_perusahaan_id.*'=>'required',
            'user_request.*'=>'required|string|max:255',
            'program.*'=>'required|string|max:255',
            'jenis_kegiatan.*.*'=>'required|string|max:255',
            'status.*.*'=>'required|in:' . implode(',', array_keys(Jobs::getStatuses())),
            'tanggal_pengerjaan.*'=>'required|date',
        ]);

        // dd($validateData);

        foreach($validateData['user_request'] as $key1 => $user_request) {
            $reportUserIT = Report_userit::create([
                'users_id' => Auth::user()->id,
                'user_req_perusahaan_id' => $validateData['user_req_perusahaan_id'][$key1],
                'user_req_departemen_id' => $validateData['user_req_departemen_id'][$key1],
                'user_request' => $user_request,
                'program' => $validateData['program'][$key1],
                'tanggal_pengerjaan' => $validateData['tanggal_pengerjaan'][$key1],
            ]);

            foreach($validateData['jenis_kegiatan'][$key1] as $key2 => $jenis_kegiatan){
                $jobs = Jobs::create([
                    'report_userit_id' => $reportUserIT->id,
                    'jenis_kegiatan' => $jenis_kegiatan,
                    'status' => $validateData['status'][$key1][$key2],
                ]);
            }
        }

        // dd($jobs);
        // dd($reportUserIT);


        return redirect()->route('reportIT.index')->with('success', 'Report Ditambahkan');
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
}
