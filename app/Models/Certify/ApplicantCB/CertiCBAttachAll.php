<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;

class CertiCBAttachAll extends Model
{
    protected $table = 'app_certi_cb_attach_all';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_cb_id', //TB: app_certi_cb
                            'ref_id', 
                            'table_name',
                            'file_client_name',
                            'file_section',
                            'file_desc',
                            'file',
                            'token'
                            ];
                            
}
