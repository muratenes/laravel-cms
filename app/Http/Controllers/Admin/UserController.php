<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Auth\Role;
use App\Repositories\Traits\ResponseTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $this->authorizeForUser(loggedAdminUser(), 'viewany', User::class);

        return view('admin.user.index');
    }

    public function edit(User $user)
    {
        $this->authorizeForUser(loggedAdminUser(), 'view', $user);

        return view('admin.user.edit', [
            'user'  => $user,
            'roles' => Role::all(),
        ]);
    }

    public function create()
    {
        $this->authorizeForUser(loggedAdminUser(), 'create', User::class);
        $roles = Role::all();

        return view('admin.user.edit', [
            'user'  => new User(),
            'roles' => $roles,
        ]);
    }

    /**
     * @param Request $request
     * @param int     $user_id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->validated());
        success();

        return redirect(route('admin.user.edit', $user->id));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());
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
