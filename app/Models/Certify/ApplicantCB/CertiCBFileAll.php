<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;

class CertiCBFileAll extends Model
{
    protected $table = 'app_certi_cb_file_all';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_cb_id', 
                            'attach',
                            'attach_pdf',
                            'state' 
                            ];
                            
}
