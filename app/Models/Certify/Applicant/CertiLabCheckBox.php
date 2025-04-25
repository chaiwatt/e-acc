<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CertiLabCheckBox extends Model
{
    //

    protected $table = "app_certi_lab_check_box";
    protected $primaryKey = 'id';
    protected $fillable = [
        'app_certi_lab_id',
        'token'
        ];

    public function checkboximage()
    {
        return $this->hasMany(CertiLabCheckBoxImage::class,'app_certi_lab_check_box_id');
    }

    public function certi_lab()
    {
        return $this->belongsTo(CertiLab::class ,'app_certi_lab_id' );
    }
}
