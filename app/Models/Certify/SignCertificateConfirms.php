<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class SignCertificateConfirms extends Model
{
    use Sortable;
    protected $table = "certify_sign_certificate_confirms";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['send_certificate_list_id', 'certificate_otp_id' ];

    public function sign_certificate_otp_to(){
        return $this->belongsTo(SignCertificateOtp::class, 'certificate_otp_id');
    }




}
 