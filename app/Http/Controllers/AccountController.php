<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDetailSaveRequest;
use App\Models\Order;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    use ResponseTrait;

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $defaultAddress = $user->default_address;
        $orders = Order::with('basket')->whereHas('basket', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->take(5)->get();

        return view('site.user.dashboard', compact('user', 'defaultAddress', 'orders'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userDetail()
    {
        return view('site.user.userDetail');
    }

    /**
     * @param Request $request
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'old_password'     => 'required',
            'new_password'     => 'required|min:6|max:255',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = $request->user();

        if (! \Hash::check($validated['old_password'], $user->password)) {
            return back()->withErrors(__('lang.old_password_does_not_match'));
        }
        $request->user()->update(['password' => Hash::make($request->new_password)]);
        success(__('lang.password_successfully_updated'));

        return back();
    }

    /**
     * @param UserDetailSaveRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userDetailSave(UserDetailSaveRequest $request)
    {
        $data = $request->validated();

        if ($request->filled('changePasswordCheckbox')) {
            $data['password'] = Hash::make(request('password'));
        }

        $request->user()->update($data);
        success(__('lang.profile_updated'));

        return redirect(route('user.detail'));
    }
}
