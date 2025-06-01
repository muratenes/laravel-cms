<?php

namespace App\Http\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends Filter
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
