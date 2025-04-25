<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;

class TisiLicenseDetail extends Model
{

    //table name
    protected $table = 'tb4_licensesizedetial';

    //Primary Key
    protected $primaryKey = 'autoNO';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['itemNo'];

    /* Disable timestamps */
    public $timestamps = false;

    //Add Auto
    protected $appends = array('standard_detail', 'id', 'tbl_licenseNo');

    //รายละเอียดผลิตภัณฑ์
  	public function getStandardDetailAttribute() {
  		return $this->sizeDetial;
  	}

    //ไอดี
  	public function getIdAttribute() {
  		return $this->autoNO;
  	}

    //ไอดี
  	public function getTblLicenseNoAttribute() {
  		return $this->licenseNo;
  	}

}
