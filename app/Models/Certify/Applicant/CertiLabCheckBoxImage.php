<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CertiLabCheckBoxImage extends Model
{
    protected $table = "app_certi_lab_check_box_images";

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['app_certi_lab_check_box_id', 'name', 'path_image', 'token', 'file_client_name'];

    public function checkbox()
    {
        return $this->belongsTo(CertiLabCheckBox::class,'app_certi_lab_check_box_id');
    }
}
