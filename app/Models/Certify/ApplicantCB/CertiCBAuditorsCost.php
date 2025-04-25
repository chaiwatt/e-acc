<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;
use App\User;
use HP;

class CertiCBAuditorsCost  extends Model
{
    protected $table = 'app_certi_cb_auditors_cost';
    protected $primaryKey = 'id';
    protected $fillable = [
                             'auditors_id' , 'detail', 'amount', 'amount_date'
                          ];
   
                        
}
