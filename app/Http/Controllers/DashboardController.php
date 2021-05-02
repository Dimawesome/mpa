<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Show dashboard page
     * @return View
     */
    public function index(): View
    {
        return \view('dashboard.dashboard');
    }
}
