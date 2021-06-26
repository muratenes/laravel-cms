<?php

namespace App\Http\Filters;

use App\Models\SepetUrun;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends Filter
{
    /**
     * @param null|string $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function category(string $value = null): Builder
    {
        if (config('admin.product.multiple_category')) {
            return $this->builder->whereHas('basket.basket_items.product.categories', function ($q) use ($value) {
                $q->withTrashed()->where('category_id', $value);
            });
        }

        return $this->builder->whereHas('basket.basket_items.product', function ($q) use ($value) {
            $q->where(function ($query) use ($value) {
                $query->withTrashed()->where('parent_category_id', $value)->orWhere('sub_category_id', $value);
            });
        });
    }

    /**
     * @param null|string $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function status(string $value = null): Builder
    {
        return $this->builder->where('status', $value);
    }

    /**
     * @param null|string $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function state(string $value = null): Builder
    {
        return $this->builder->whereHas('delivery_address', function ($q) use ($value) {
            $q->withTrashed()->where('state_id', $value);
        });
    }

    /**
     * @param null|string $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function company(string $value = null): Builder
    {
        return $this->builder->whereHas('basket.basket_items.product', function ($q) use ($value) {
            $q->withTrashed()->where('company_id', $value);
        });
    }

    /**
     * @param null|string $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function firstDate(string $value = null): Builder
    {
        if ($value) {
            $start = isset(explode('-', $value)[0]) ? str_replace(' ', '', explode('-', $value)[0]) : null;
            $end = isset(explode('-', $value)[1]) ? str_replace(' ', '', explode('-', $value)[1]) : null;

            return $this->builder->whereBetween('first_date', [
                Carbon::createFromDate($start)->format('Y-m-d'),
                Carbon::createFromDate($end)->format('Y-m-d'),
            ]);
        }

        return $this->builder;
    }

    /**
     * @param null|string $value
     *
     * @return Builder
     */
    public function pendingRefund(string $value = null)
    {
        return $this->builder->whereHas('basket.basket_items', function ($q) {
            $q->withTrashed()->where('status', SepetUrun::STATUS_IADE_TALEP);
        });
    }
}
