<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;
use App\User;
use HP;

class CertiCBAuditorsStep  extends Model
{
    protected $table = 'app_certi_cb_auditors_step';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'title'
                          ];
}
