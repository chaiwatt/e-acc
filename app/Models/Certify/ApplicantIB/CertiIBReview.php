<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;

class CertiIBReview extends Model
{
    protected $table = 'app_certi_ib_review';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_ib_id', //TB: app_certi_cb
                            'files',
                            'review',
                            'attach',
                            'created_by',
                            'updated_by',
                            ];
                            
}
