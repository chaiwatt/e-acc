<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
 
class SignCertificateOtp extends Model
{
    use Sortable;
    protected $table = "certify_sign_certificate_otp";
    protected $primaryKey = 'id';
    protected $fillable = ['Ref_otp', 'otp','Req_date','Req_by','Confirm_date' ,'Confirm_by' ,'state'  ];



}
 