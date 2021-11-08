<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\Role;
use App\Models\Ayar;
use App\Repositories\Traits\ResponseTrait;
use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KullaniciController extends Controller
{
    use ResponseTrait;

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

    /**
     * @param Request $request
     * @param int     $user_id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request, $user_id = 0)
    {
        $validated = $request->validate([
            'name'     => 'required|min:3|max:50',
            'surname'  => 'required|min:3|max:50',
            'email'    => 0 === (int) $user_id ? 'email|unique:users' : 'email',
            'locale'   => 'string',
            'role_id'  => 'nullable|numeric',
            'phone'    => 'string|nullable',
            'password' => 'nullable|string|min:6',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->get('password'));
        }
        $validated['is_active'] = $request->has('is_active');
        if ($user_id > 0) {
            $user = User::where('id', $user_id)->firstOrFail();
            $user->update($validated);
        } else {
            $user = User::create($validated);
        }
        success();

        return redirect(route('admin.user.edit', $user->id));
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(User $user)
    {
        if ($user->email === config('admin.username')) {
            return $this->error('Bu kullanıcı silinemez.');
        }
        $user->update([
            'email' => $user->email . '|' . Str::random(10),
        ]);
        $user->delete();

        return $this->success();
    }
}
