<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CostFile extends Model
{
    protected $table = "app_certi_lab_cost_files";
    protected $fillable = [
        'app_certi_cost_id', 'file_desc', 'file','file_client_name'
    ];


    public function check() {
        return $this->belongsTo(Check::class, 'app_certi_lab_checks');
    }
}
