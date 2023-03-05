<?php

namespace App\Http\Controllers;

use App\Jobs\SendUserVerificationMail;
use App\Models\Basket;
use App\Repositories\Traits\CartTrait;
use App\Repositories\Traits\SepetSupportTrait;
use App\User;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use CartTrait;
    use SepetSupportTrait;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginForm()
    {
        return view('site.user.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, ['email' => 'required|email', 'password' => 'required']);

        $credentials = $request->only(['email', 'password']);
        $credentials['is_active'] = 1;

        if (auth()->attempt($credentials, $request->get('rememberme', 0))) {
//            request()->session()->regenerate();
            $current_basket = Basket::getCurrentBasket();
            $current_basket->update(['coupon_id' => session()->get('coupon_id')]);
            // todo : login olmuş kullanıcının sepetindeki ürünleri cart'a da eklemek gerekiyor yoksa siliyor
            $this->matchSessionCartWithBasketItems($current_basket);

            success(__('lang.welcome_to_app'));

            return redirect()->intended('/');
        }
        $errors = ['email' => __('lang.wrong_username_or_password')];

        return back()->withErrors($errors);
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->flush();
        request()->session()->regenerate();

        return redirect(route('homeView'));
    }

    public function registerForm()
    {
        return view('site.user.register');
    }

    public function register(Request $request)
    {
        $validated = $this->validate($request, [
            'name'     => 'required|min:3|max:60',
            'surname'  => 'required|min:3|max:60',
            'email'    => 'required|min:5|max:60|email|unique:users',
            'password' => 'required|min:5|max:60|confirmed',
        ]);

        $data = array_merge($validated, [
            'password'        => Hash::make(request('password')),
            'activation_code' => Str::random(60),
            'is_active'       => 0,
        ]);

        $user = User::create($data);

        $this->dispatch(new SendUserVerificationMail($validated['email'], $user));

        return redirect()->to('/')
            ->with('message', __('lang.please_verify_email_for_active_account'))
            ->with('message_type', 'warning')
        ;
    }

    public function activateUser($activation_code)
    {
        $user = User::where('activation_code', $activation_code)->first();
        if (null !== $user) {
            $user->activation_code = null;
            $user->is_active = true;
            $user->save();

            return redirect()->to('/')
                ->with('message', 'Kullanıcı kaydınız başarıyla tamamlandı')
                ->with('message_type', 'success')
            ;
        }

        return redirect()->to('/')
            ->with('message', 'Gönderilen doğrulama bilgisi (token) için süre dolmuş veya geçersiz token ')
            ->with('message_type', 'danger')
        ;
    }
}
