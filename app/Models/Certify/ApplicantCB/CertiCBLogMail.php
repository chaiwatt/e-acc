<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;

class CertiCBLogMail extends Model
{
    protected $table = 'app_certi_cb_log_mail';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_cb_id', //TB: app_certi_cb
                            'system',
                            'table_name',
                            'ref_id',
                            'name',
                            'details_one',
                            'details_two',
                            'details_three',
                            'details_four',
                            'attachs',
                            'files',
                            'link_url',
                            'contact',
                            'officer',
                            'operator',
                            'token'
                            ];
                            
}
