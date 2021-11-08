<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\Role;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView()
    {
        if (Auth::guard('admin')->check()) {
            return redirect(route('admin.home_page'));
        }

        return view('admin.login');
    }

    /**
     * login post.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email'    => 'required|min:6|email',
            'password' => 'required|min:6',
        ]);
        $userLoginData = array_merge($validatedData, [
            'role_id'   => Role::ROLE_SUPER_ADMIN,
            'is_active' => 1,
        ]);

        if (Auth::guard('admin')->attempt($userLoginData, $request->has('remember_me', 0))) {
            return redirect(route('admin.home_page'));
        }
        Log::addLog('hatalı admin girişi', json_encode($userLoginData), Log::TYPE_WRONG_LOGIN);

        return back()->withInput()->withErrors(['email' => 'hatalı kullanıcı adı veya şifre']);
    }

    /**
     * logout from admin.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        request()->session()->flush();
        request()->session()->regenerate();

        return redirect(route('admin.login'));
    }
}
