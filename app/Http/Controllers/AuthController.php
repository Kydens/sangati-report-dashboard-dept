<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Perusahaan;
use App\Models\Departemen;
use Carbon\Carbon;

class AuthController extends Controller
{
    function loginIndex() {
        return view('auth.login');
    }

    function loginPost(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            $user = Auth::user();
            $user->isActive = true;
            $user->lastActive = Carbon::now();
            $user->save();


            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Email atau Password Salah!');
    }

    function createAccount() {
        $perusahaans = Perusahaan::where('id', '<', 6)->get();
        $departemens = Departemen::whereBetween('id', [2, 8])->get();
        return view('auth.createAccount', compact('perusahaans', 'departemens'));
    }

    function storeAccount(Request $request) {
        $validateData = $request->validate([
            'email'=>'required',
            'username'=>'required',
            'password'=>'required|min:5',
            'perusahaan_user'=>'required',
            'departemen_user'=>'required'
        ],[
            'password.min'=>'Password minimal 5 karakter.'
        ]);

        $userAcc = User::create([
            'email'=>$validateData['email'],
            'username'=>$validateData['username'],
            'password'=>Hash::make($validateData['password']),
            'perusahaan_id'=>$validateData['perusahaan_user'],
            'departemen_id'=>$validateData['departemen_user'],
        ]);

        return redirect()->route('dashboard.index');
    }

    function logout(Request $request){
        $user = Auth::user();
        $user->isActive = false;
        $user->save();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
