<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;

class CertiIBAttachAll extends Model
{
    protected $table = 'app_certi_ib_attach_all';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_ib_id', //TB: app_certi_cb
                            'table_name',
                            'ref_id',
                            'file_section',
                            'file_desc',
                            'file',
                            'file_client_name',
                            'token'
                            ];
                            
}
