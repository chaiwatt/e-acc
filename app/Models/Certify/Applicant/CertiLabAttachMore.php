<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CertiLabAttachMore extends Model
{
    protected $table = 'app_certi_lab_attach_more';
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
    protected $fillable = ['app_certi_lab_id', 'file_desc', 'file', 'file_client_name'];

    public function attach()
    {
        return $this->belongsTo(CertiLabAttach::class,'app_certi_lab_attach_id');
    }

}
