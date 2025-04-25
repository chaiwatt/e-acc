<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;

class CertiCBCheck extends Model
{
    protected $table = 'app_certi_cb_check';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_cb_id', //TB: app_certi_cb
                            'user_id',
                            'created_by',
                            'updated_by' 
                            ];
                            
}
