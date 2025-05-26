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

    public function start_date(string $value = null): Builder
    {
        return $this->builder->where('due_date','>=', $value);
    }

    public function end_date(string $value = null): Builder
    {
        return $this->builder->where('due_date','<=', $value);
    }
}
