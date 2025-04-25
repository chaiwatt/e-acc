<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CostDate extends Model
{
    protected $table = "app_certi_lab_cost_dates";

    public function cost() {
        return $this->belongsTo(Cost::class, 'app_certi_cost_id');
    }
}
