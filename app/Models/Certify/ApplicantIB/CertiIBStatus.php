<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;

class CertiIBStatus  extends Model
{
    protected $table = 'app_certi_ib_status';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'title'
                          ];
                            
}
