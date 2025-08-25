<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard (empty page as per requirement).
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
