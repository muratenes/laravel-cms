<?php

namespace App\Http\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends Filter
{
    /**
     * @param null|string $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function category(string $value = null): Builder
    {
        if (config('admin.product.multiple_category')) {
            return $this->builder->whereHas('categories', function ($q) use ($value) {
                $q->where('category_id', $value);
            });
        }

        return $this->builder->where(function ($query) use ($value) {
            $query->where('parent_category_id', $value)->orWhere('sub_category_id', $value);
        });
    }

    /**
     * @param null|string $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function company(string $value = null): Builder
    {
        return $this->builder->where('company_id', $value);
    }

    /**
     * @param null|string $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function brand(string $value = null): Builder
    {
        return $this->builder->where('brand_id', $value);
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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function appointmentDate(string $value = null): Builder
    {
        if ($value) {
            $start = isset(explode('-', $value)[0]) ? str_replace(' ', '', explode('-', $value)[0]) : null;
            $end = isset(explode('-', $value)[1]) ? str_replace(' ', '', explode('-', $value)[1]) : null;

            return $this->builder->whereBetween('appointment_date', [
                Carbon::createFromDate($start)->format('Y-m-d'),
                Carbon::createFromDate($end)->format('Y-m-d'),
            ]);
        }

        return $this->builder;
    }
}
