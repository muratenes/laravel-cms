<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\CouponInterface;

class CouponController extends AdminController
{
    protected CouponInterface $model;
    protected CategoryInterface $categoryService;

    public function __construct(CouponInterface $model, CategoryInterface $kategoriService)
    {
        $this->model = $model;
        $this->categoryService = $kategoriService;
    }

    public function list()
    {
        $query = request()->get('q', null);
        $list = $this->model->allWithPagination([['code', 'like', "%{$query}%"]]);

        return view('admin.coupon.listCoupons', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $entry = new Coupon();
        if (0 != $id) {
            $entry = $this->model->getById($id);
        }
        $categories = $this->categoryService->all(['active' => 1]);
        $selected_categories = [];
        $currencies = $this->activeCurrencies();
        if (0 != $id) {
            $coupon = $this->model->find($id, null, ['categories']);
            $selected_categories = $coupon->categories()->pluck('category_id')->all();
        }

        return view('admin.coupon.newOrEditCoupon', compact('entry', 'categories', 'selected_categories', 'currencies'));
    }

    public function save(CouponRequest $request, $id = 0)
    {
        $requestData = $request->validated();
        $requestData['active'] = activeStatus();
        if (0 != $id) {
            $this->model->update($requestData, $id);
            $entry = $this->model->find($id, null, ['categories']);
        } else {
            $entry = Coupon::create($requestData);
        }
        if ($entry) {
            $entry->categories()->sync($request->get('categories'));

            return redirect(route('admin.coupons.edit', $entry->id));
        }

        return back()->withInput();
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return redirect(route('admin.coupons'));
    }
}
