<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CertiLabProgram extends Model
{
    //
    protected $table = "app_certi_lab_programs";

    protected $fillable = [
      'app_certi_lab_id',
        'no',
        'process_date',
        'product',
        'item',
        'depart',
        'result',
        'token'
    ];

    public function certi_lab()
    {
        return $this->belongsTo(CertiLab::class ,'app_certi_lab_id' );
    }
}
