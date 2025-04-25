<?php

namespace App\Models\Basic;

use Kyslik\ColumnSortable\Sortable;
use App\Models\Basic\Tis;
use Eloquent as Model;

/**
 * Class TisiLicense
 * @package App\Models\Basic
 * @version January 7, 2019, 4:24 am UTC
 *
 * @property string tbl_licenseNo
 * @property string tbl_licenseType
 * @property date tbl_licenseDate
 * @property string tbl_tisiNo
 * @property string tbl_tradeName
 * @property string tbl_tradeAddress
 * @property string tbl_factoryName
 * @property string tbl_producer
 * @property string tbl_exporter
 * @property string tbl_input_data
 * @property string tbl_licenseStatus
 * @property string tbl_extend
 * @property string tbl_newtisNo
 * @property string tbl_pdf_path
 * @property string tbl_taxpayer
 * @property string tbl_factoryID
 * @property string tbl_factoryAddress
 * @property string tbl_factoryInprovince
 * @property string tbl_origin
 * @property string tbl_userID
 * @property string|\Carbon\Carbon tbl_date_timeEdit
 * @property string tbl_trademark
 */
class TisiLicense extends Model
{
    use Sortable;

    public $table = 'tb4_tisilicense';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $primaryKey = 'Autono';

    public $fillable = [
        'tbl_licenseNo',
        'tbl_licenseType',
        'tbl_licenseDate',
        'tbl_tisiNo',
        'tbl_tradeName',
        'tbl_tradeAddress',
        'tbl_factoryName',
        'tbl_producer',
        'tbl_exporter',
        'tbl_input_data',
        'tbl_licenseStatus',
        'tbl_extend',
        'tbl_newtisNo',
        'tbl_pdf_path',
        'tbl_taxpayer',
        'tbl_factoryID',
        'tbl_factoryAddress',
        'tbl_factoryInprovince',
        'tbl_origin',
        'tbl_userID',
        'tbl_date_timeEdit',
        'tbl_trademark'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'Autono' => 'integer',
        'tbl_licenseNo' => 'string',
        'tbl_licenseType' => 'string',
        'tbl_licenseDate' => 'date',
        'tbl_tisiNo' => 'string',
        'tbl_tradeName' => 'string',
        'tbl_tradeAddress' => 'string',
        'tbl_factoryName' => 'string',
        'tbl_producer' => 'string',
        'tbl_exporter' => 'string',
        'tbl_input_data' => 'string',
        'tbl_licenseStatus' => 'string',
        'tbl_extend' => 'string',
        'tbl_newtisNo' => 'string',
        'tbl_pdf_path' => 'string',
        'tbl_taxpayer' => 'string',
        'tbl_factoryID' => 'string',
        'tbl_factoryAddress' => 'string',
        'tbl_factoryInprovince' => 'string',
        'tbl_origin' => 'string',
        'tbl_userID' => 'string',
        'tbl_trademark' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /*
      Tis Relation
    */
    public function tis(){
      return $this->hasOne(Tis::class, 'tb3_Tisno', 'tbl_tisiNo');
    }


}
