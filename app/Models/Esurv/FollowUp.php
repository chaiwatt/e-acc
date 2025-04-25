<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use HP;
use App\Models\Basic\Tis;
use App\Models\Esurv\Trader;
use App\Models\Basic\TisiLicense;
use App\Models\Esurv\FollowUpLicense;

use App\Models\Basic\Province; 
use App\Models\Basic\Amphur;
use App\Models\Basic\District;
class FollowUp extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_follow_ups';

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

    protected $fillable = [
                          'trader_autonumber',
                          'tb3_Tisno',
                          'factory_name',
                          'factory_address_no',
                          'factory_address_industrial_estate',
                          'factory_address_alley',
                          'factory_address_road',
                          'factory_address_village_no',
                          'factory_address_province',
                          'factory_address_amphoe',
                          'factory_address_tambon',
                          'factory_address_zip_code',
                          'factory_tel',
                          'factory_fax',
                          'factory_latitude',
                          'factory_longitude',
                          'warehouse',
                          'warehouse_name',
                          'warehouse_address_no',
                          'warehouse_address_industrial_estate',
                          'warehouse_address_alley',
                          'warehouse_address_road',
                          'warehouse_address_village_no',
                          'warehouse_address_province',
                          'warehouse_address_amphoe',
                          'warehouse_address_tambon',
                          'warehouse_address_zip_code',
                          'warehouse_tel',
                          'warehouse_fax',
                          'warehouse_latitude',
                          'warehouse_longitude',
                          'person',
                          'check_date',
                          'staff',
                          'follow_type',
                          'inform_manufacture', 'inform_manufacture_remark',
                          'inform_manufacture_text',
                          'reason_not_inform',
                          'show_mark',
                          'show_manufacturer',
                          'show_manufacturer_sub',
                          'show_manufacturer_image',
                          'show_manufacturer_text',
                          'show_label',
                          'quality_control',
                          'quality_control_text_yes',
                          'quality_control_text_no',
                          'quality_control_remark',
                          'test_tool_product',
                          'test_tool_product_text',
                          'test_tool_product_text_no',
                          'test_tool_product_remark',
                          'complaint_amount',
                          'complaint_collect',
                          'complaint_handle',
                          'show_mark_product',
                          'show_mark_product_detail',
                          'show_mark_product_detail_text',
                          'show_mark_product_remark',
                          'inform_import',
                          'inform_import_text',
                          'summarize',
                          'inspection_result_date_start',
                          'inspection_result_date_end',
                          'inspection_result',
                          'inspection_result_text',
                          'sampling',
                          'sampling_reference_document',
                          'additional_note',
                          'attach',
                          'conclude_result',
                          'conclude_result_remark',
                          'assessor',
                          'assessment_date',
                          'check_status',
                          'state',
                          'created_by',
                          'updated_by',
                          'reference_number',
                          'show_mark_product_text',
                          'check_product',
                          'check_product_text',
                          'check_proceed',
                          'check_proceed_text',
                            'status_history',
                          'inform_import_remark'
                        ];
    /*
      Sorting

    */
    public $sortable = ['trader_autonumber', 'tb3_Tisno', 'factory_name', 'factory_address', 'factory_latitude', 'factory_longitude', 'warehouse_address', 'warehouse_latitude', 'warehouse_longitude', 'person_found', 'check_date', 'follow_type', 'inform_manufacture', 'reason_not_inform', 'show_mark', 'show_manufacturer', 'show_manufacturer_sub', 'show_manufacturer_image', 'show_label', 'quality_control', 'quality_control_text', 'test_tool_product', 'test_tool_product_text', 'complaint_amount', 'complaint_collect', 'complaint_handle', 'show_mark_product', 'show_mark_product_text', 'summarize', 'inspection_result_date_start', 'inspection_result_date_end', 'inspection_result', 'inspection_result_text', 'sampling', 'sampling_reference_document', 'additional_note', 'attach', 'state', 'created_by', 'updated_by','inform_manufacture_text','check_product_text','inform_manufacture_remark','quality_control_text_yes',
                          'quality_control_remark','test_tool_product_text_no','test_tool_product_remark','inform_import_text','show_mark_product_remark','show_mark_product_detail_text','inform_import_remark','status_history'
                      ];



    /*
      User Relation
    */
    public function user_created(){
      return $this->belongsTo(User::class, 'created_by');
    }

    public function user_updated(){
      return $this->belongsTo(User::class, 'updated_by');
    }

    public function traders(){
      return $this->belongsTo(Trader::class, 'trader_autonumber');
    }

     public function trader_taxs(){
      return $this->belongsTo(Trader::class, 'trader_autonumber', 'tax_id');
    }

    public function tis_id(){
      return $this->belongsTo(Tis::class, 'tb3_Tisno');
    }

    public function trader_tb4(){
      return $this->belongsTo(TisiLicense::class, 'trader_autonumber', 'Autono');
    }

    public function trader_tb4_by_follow_up(){
      return $this->belongsTo(TisiLicense::class, 'trader_autonumber', 'tbl_taxpayer');
    }

    public function getCreatedNameAttribute() {
  		return @$this->user_created->reg_fname.' '.@$this->user_created->reg_lname;
  	}

    public function getUpdatedNameAttribute() {
  		return @$this->user_updated->reg_fname.' '.@$this->user_updated->reg_lname;
    }

    public function getTraderNameAttribute() {
  		return @$this->traders->trader_operater_name;
    }

    public function getTraderNameByTaxAttribute() {
  		return @$this->trader_taxs->trader_operater_name;
    }

    public function getTraderNameByFollowUpAttribute() {
  		return @$this->trader_tb4_by_follow_up->tbl_tradeName;
    }

    public function getTisNameAttribute() {
  		return @$this->tis_id->tb3_TisThainame;
    }

    public function getTraderTb4NameAttribute() {
  		return @$this->trader_tb4->tbl_tradeName;
    }

    public function getCheckStatusNameAttribute(){
      $arr = ['0' => 'ฉบับร่าง', 
              '1' => 'อยู่ระหว่าง ผก.รับรอง',
              '2' => 'ผก.รับรองแล้ว',
              '3' => 'อยู่ระหว่าง ผอ.รับรอง',
              '4' => 'ผอ.รับรองแล้ว',
              '5' => 'ปรับปรุงแก้ไข'
            ];
      return isset($this->check_status)?$arr[$this->check_status]:'n/a';
    }

    public function data_id_follow_up(){
      return $this->hasMany(FollowUpLicense::class, 'id_follow_up');
    }

    public function basic_rovince(){
      return $this->belongsTo(Province::class, 'warehouse_address_province');
    }
    public function basic_amphur(){
      return $this->belongsTo(Amphur::class, 'warehouse_address_amphoe');
    }
    public function basic_district(){
      return $this->belongsTo(District::class, 'warehouse_address_tambon');
    }
}
