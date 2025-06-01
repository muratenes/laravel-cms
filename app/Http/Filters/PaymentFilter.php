<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class PaymentFilter extends Filter
{

    public function vendor_id(string $value = null): Builder
    {
        return $this->builder->where('vendor_id', $value);
    }

    public function date_range(string $value = null): Builder
    {
        if ($value) {
            [$start, $end] = explode(' - ', $value);
            $this->builder->whereBetween('due_date', [$start, $end]);
        }

        return $this->builder;
    }
}
