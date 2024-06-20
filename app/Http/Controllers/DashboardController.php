<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index()
    {
        $users = User::where('departemen_id', '>', 1)->orderBy('isActive', 'DESC')->orderBy('updated_at', 'DESC')->paginate(5);
        return view('dashboard.index', compact('users'));
    }
}
