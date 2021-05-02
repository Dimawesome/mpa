<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * AdminController constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('guest')->except(['index', 'logout']);
    }

    /**
     * Return admin dashboard
     *
     * @return View
     */
    public function index(): View
    {
        return \view('admin.dashboard');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            if (Auth::attempt($request->only('username', 'password'))) {
                return redirect('/admin');
            }

            return back()->withErrors(['username' => 'nope']);
        }

        return \view('admin.login', ['rules' => $this->user->rules()]);
    }

    /**
     * Log the user out of the administration
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard()->logout();
        $request->session()->invalidate();

        return redirect()->route('admin.login');
    }
}
