<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use App\User;
use HP;

class CertiIBAuditorsStep  extends Model
{
    protected $table = 'app_certi_ib_auditors_step';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'title'
                          ];
}
