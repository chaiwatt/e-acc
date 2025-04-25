<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use App\User;
use HP;

class CertiIBAuditorsCost  extends Model
{
    protected $table = 'app_certi_ib_auditors_cost';
    protected $primaryKey = 'id';
    protected $fillable = [
                             'auditors_id' , 'detail', 'amount', 'amount_date'
                          ];
   
                        
}
