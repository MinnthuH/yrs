<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashbaord Method
    public function index()
    {
        return view('dashboard');
    }
}
