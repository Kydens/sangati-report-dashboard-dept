<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
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
        $reportUserIT = Report_userit::where('users_id', '=', $user)->orderBy('created_at', 'DESC')->paginate(10);
        return view('dashboard.dept_it.report.each_user.userReport', compact('reportUserIT'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = Report_userit::getStatuses();
        $departemens = Departemen::where('id', '>=', 2)->get();
        $perusahaans = Perusahaan::get();
        return view('dashboard.dept_it.report.each_user.createUserReport', compact('statuses', 'departemens', 'perusahaans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'user_req_departemen_id.*'=>'required',
            'user_req_perusahaan_id.*'=>'required',
            'user_request.*'=>'required|string|max:255',
            'program.*'=>'required|string|max:255',
            'jenis_kegiatan.*'=>'required|string|max:255',
            'status.*'=> 'required|in:' . implode(',', array_keys(Report_userit::getStatuses())),
        ]);

        foreach($validateData['user_request'] as $key => $user_request){
            Report_userit::create([
                'users_id'=>Auth::user()->id,
                'user_req_perusahaan_id'=>$validateData['user_req_perusahaan_id'][$key],
                'user_req_departemen_id'=>$validateData['user_req_departemen_id'][$key],
                'user_request'=>$user_request,
                'program'=>$validateData['program'][$key],
                'jenis_kegiatan'=>$validateData['jenis_kegiatan'][$key],
                'status'=>$validateData['status'][$key],
            ]);
        }

        return redirect('/dashboard/reportIT')->with('success', 'Report Ditambahkan');
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
