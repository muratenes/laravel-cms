<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class PaymentFilter extends Filter
{

    public function vendor_id(string $value = null): Builder
    {
        return $this->builder->where('vendor_id', $value);
    }

    public function start_date(string $value = null): Builder
    {
        return $this->builder->where('due_date','>=', $value);
    }

    public function end_date(string $value = null): Builder
    {
        return $this->builder->where('due_date','<=', $value);
    }
}
