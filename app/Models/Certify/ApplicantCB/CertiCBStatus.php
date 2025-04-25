<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;

class CertiCBStatus  extends Model
{
    protected $table = 'app_certi_cb_status';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'title'
                          ];
                            
}
