<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\Role;
use App\Models\Ayar;
use App\Models\Log;
use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KullaniciController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            return redirect(route('admin.home_page'));
        }
        if (request()->isMethod('POST')) {
            $validatedData = $request->validate([
                'email'    => 'required|min:6|email',
                'password' => 'required|min:6',
            ]);
            $user_login_data = ['email' => request('email'), 'password' => request('password'), 'is_admin' => 1, 'is_active' => 1];
            if (Auth::guard('admin')->attempt($user_login_data, request()->has('remember_me', 0))) {
                return redirect(route('admin.home_page'));
            }
            Log::addLog('hatalı admin girişi', json_encode($user_login_data), Log::TYPE_WRONG_LOGIN);

            return back()->withInput()->withErrors(['email' => 'hatalı kullanıcı adı veya şifre']);
        }

        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        request()->session()->flush();
        request()->session()->regenerate();

        return redirect(route('admin.login'));
    }

    public function listUsers()
    {
        $perPageItem = 10;
        $query = request('q');
        $auth = Auth::guard('admin')->user();
        if ($query) {
            $list = User::where(function ($qq) use ($query) {
                $qq->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('surname', 'like', "%{$query}%")
                ;
            })->when($auth->email !== config('admin.username'), function ($qq) {
                $qq->where('email', '!=', config('admin.username'));
            })->orderByDesc('id')
                ->paginate($perPageItem)
            ;
        } else {
            $list = User::when($auth->email !== config('admin.username'), function ($qq) {
                $qq->where('email', '!=', config('admin.username'));
            })->orderByDesc('id')->paginate($perPageItem);
        }

        return view('admin.user.list_users', compact('list'));
    }

    public function newOrEditUser($user_id = 0)
    {
        $user = new User();
        $roles = Role::all();
        $auth = Auth::guard('admin')->user();
        if ($user_id > 0) {
            $user = User::whereId($user_id)->firstOrFail();
            if ($auth->email !== config('admin.username')) {
                $roles = Role::whereNotIn('name', ['super-admin'])->get();
            }
            if ($user->email === config('admin.username') && $auth->email !== config('admin.username')) {
                return back()->withErrors('yetkiniz yok');
            }
        }
        $activeLanguages = Ayar::activeLanguages();

        return view('admin.user.new_edit_user', compact('user', 'roles', 'activeLanguages'));
    }

    public function saveUser(Request $request, $user_id = 0)
    {
        $email_validate = 0 === (int) $user_id ? 'email|unique:users' : 'email';
        $validated = $request->validate([
            'name'    => 'required|min:3|max:50',
            'surname' => 'required|min:3|max:50',
            'email'   => $email_validate,
            'locale'  => 'string',
            'role_id' => 'nullable|numeric',
            'phone'   => 'string|nullable',
        ]);

        if (request()->filled('password')) {
            $request_data['password'] = Hash::make(request('password'));
        }
        $validated['is_active'] = (bool) $request->has('is_active');
        $validated['is_admin'] = request()->has('is_admin') ? 1 : 0;
        if ($user_id > 0) { // update
            $user = User::where('id', $user_id)->firstOrFail();
            $user->update($validated);
        } else {
            $user = User::create($validated);
        }
        success();

        return redirect(route('admin.user.edit', $user->id));
    }

    public function deleteUser($user_id)
    {
        $user = User::where('id', $user_id)->firstOrFail();
        if ($user->email === config('admin.username')) {
            return back()->withErrors('Bu kullanıcı silinemez');
        }
        $user->email = $user->email . '|' . Str::random(10);
        $user->save();
        $user->delete();
        success();

        return redirect(route('admin.users'));
    }
}
