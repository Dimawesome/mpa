<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show dashboard page
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('dashboard');
    }
}
