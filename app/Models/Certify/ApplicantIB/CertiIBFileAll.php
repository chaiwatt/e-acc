<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;

class CertiIBFileAll extends Model
{
    protected $table = 'app_certi_ib_file_all';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_ib_id', 
                            'attach',
                            'attach_pdf',
                            'state' 
                            ];
                            
}
