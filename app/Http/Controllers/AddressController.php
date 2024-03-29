<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Region\Country;
use App\Models\Region\District;
use App\Models\Region\State;
use App\Models\UserAddress;
use App\Repositories\Interfaces\AccountInterface;
use App\Repositories\Interfaces\CityTownInterface;
use App\Repositories\Traits\ResponseTrait;
use App\Rules\PhoneNumberRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AddressController extends Controller
{
    use ResponseTrait;

    private AccountInterface $accountService;
    private CityTownInterface $cityTownService;

    public function __construct(AccountInterface $accountService, CityTownInterface $cityTownService)
    {
        $this->accountService = $accountService;
        $this->cityTownService = $cityTownService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addresses(Request $request)
    {
        $user = $request->user();
        $addresses = UserAddress::with(['country', 'state', 'district', 'neighborhood'])->where(['user_id' => $user->id])->latest()->get();
        $basket = Basket::getCurrentBasket();

        return view('site.user.address', compact('addresses', 'basket'));
    }

    /**
     * @param Request $request
     * @param $addressID
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, $addressID)
    {
        $address = $addressID ? UserAddress::findOrFail($addressID) : new UserAddress();
        if (Gate::denies('edit-address', $address) && $addressID) {
            abort(403);
        }

        $user = $request->user();
        $states = State::select(['id', 'title'])->where('country_id', Country::TURKEY)->orderBy('title')->get();
        $districts = $address->state_id ? District::select(['id', 'title'])->where('state_id', $address->state_id)->get() : [];

        return view('site.user.address-detail', compact('address', 'user', 'states', 'districts'));
    }

    /**
     * kullanıcı varsayılan adres atar.
     *
     * @param Request     $request
     * @param UserAddress $address
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setDefaultAddress(Request $request, UserAddress $address)
    {
        $request->user()->update(['default_address_id' => $address->id]);
        success();

        return back();
    }

    /**
     * @param Request $request
     * @param int     $addressID
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request, $addressID = 0)
    {
        $validated = $request->validate([
            'title'           => 'required|max:50',
            'adres'           => 'required|max:255|min:5',
            'name'            => 'required|max:50',
            'surname'         => 'required|max:50',
            'phone'           => ['required', 'max:20', new PhoneNumberRule($request->get('phone'))],
            'state_id'        => 'required|numeric',
            'district_id'     => 'required|numeric',
            'neighborhood_id' => 'nullable|numeric',
            'type'            => 'required|in:1,2',
            'email'           => 'required|email|max:60',
        ]);

        $validated['country_id'] = 1;
        $validated['user_id'] = $request->user()->id;

        $address = $this->accountService->updateOrCreateUserAddress($addressID, $validated, $request->user()->id);
        success();

        if ($request->has('setAsDefault')) {
            $request->user()->update([(UserAddress::TYPE_INVOICE === $validated['type'] ? 'default_invoice_address_id' : 'default_address_id') => $address->id]);
        }
        if ($request->get('fromPage')) {
            return redirect(route($request->get('fromPage')));
        }

        return redirect(route('user.address.edit', $address->id));
    }

    /**
     * kullanıcı varsayılan fatura adresi atar.
     *
     * @param Request     $request
     * @param UserAddress $address
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setDefaultInvoiceAddress(Request $request, UserAddress $address)
    {
        $this->accountService->setUserDefaultInvoiceAddress($request->user()->id, $address->id);
        success();

        return back();
    }

    /**
     * @param UserAddress $address
     */
    public function delete(UserAddress $address)
    {
        $address->delete();
        success();

        return back();
    }

    /**
     * ajax request.
     *
     * @param int $addressID
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $addressID)
    {
        $address = $addressID ? UserAddress::findOrFail($addressID) : new UserAddress();
        $states = State::select('id', 'title')->orderBy('title')->get();
        $districts = District::select('id', 'title')->where('state_id', $address->state_id)->get();

        return view('site.user.partials.adres-detail-modal', compact('states', 'districts', 'address'));
    }
}
