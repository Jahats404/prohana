<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardP()
    {
        return view('produsen.dashboard');
    }

    public function dashboardA()
    {
        return view('agen.dashboard');
    }

    public function dashboardD()
    {
        return view('distributor.dashboard');
    }
}