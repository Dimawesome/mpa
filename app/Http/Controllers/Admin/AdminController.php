<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('guest')->except(['index','logout']);
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            if (Auth::attempt($request->only('username', 'password'))) {
                return redirect('/admin');
            }

            return back()->withErrors(['username' => 'nope']);
        }

        return view('admin.login', ['rules' => $this->user->rules()]);
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
