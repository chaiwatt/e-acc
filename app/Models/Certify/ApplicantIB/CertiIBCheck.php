<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;

class CertiIBCheck extends Model
{
    protected $table = 'app_certi_ib_check';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_ib_id', //TB: app_certi_cb
                            'user_id',//TB:user_register
                            'created_by'
                            ];
                            
}
