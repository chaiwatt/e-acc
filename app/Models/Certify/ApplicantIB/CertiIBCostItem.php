<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;

class CertiIBCostItem  extends Model
{
    protected $table = 'app_certi_ib_cost_items';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_cost_id', 'detail', 'amount', 'amount_date'
                          ];
                            
}
