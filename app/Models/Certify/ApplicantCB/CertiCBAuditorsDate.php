<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;
use App\User;
use HP;

class CertiCBAuditorsDate  extends Model
{
    protected $table = 'app_certi_cb_auditors_date';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'auditors_id',
                            'start_date',
                            'end_date'
                          ];
   
                        
}
