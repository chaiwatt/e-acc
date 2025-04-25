<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CostItem extends Model
{
    protected $table = "app_certi_lab_cost_items";
    protected $fillable = [
        'app_certi_cost_id', 'amount_date', 'amount', 'created_by', 'updated_by'
    ];
    public function cost() {
        return $this->belongsTo(Cost::class, 'app_certi_cost_id');
    }
}
