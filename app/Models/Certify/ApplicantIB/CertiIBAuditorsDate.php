<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use App\User;
use HP;

class CertiIBAuditorsDate  extends Model
{
    protected $table = 'app_certi_ib_auditors_date';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'auditors_id',
                            'start_date',
                            'end_date'
                          ];
   
                        
}
