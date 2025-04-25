<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use App\Models\Esurv\Applicant21OwnProductDetail;

class Applicant21Own extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_applicant_21owns';

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
    protected $fillable = ['ref_no', 'title', 'different_no', 'reason', 'foreign_standard_ref', 'country_ref', 'start_date', 'end_date', 'company_order', 'made_factory_chk', 'made_factory_name', 'made_factory_addr_no', 'made_factory_nicom', 'made_factory_soi', 'made_factory_road', 'made_factory_moo', 'made_factory_subdistrict', 'made_factory_district', 'made_factory_province', 'made_factory_zipcode', 'made_factory_tel', 'made_factory_fax', 'store_factory_chk', 'store_factory_name', 'store_factory_addr_no', 'store_factory_nicom', 'store_factory_soi', 'store_factory_road', 'store_factory_moo', 'store_factory_subdistrict', 'store_factory_district', 'store_factory_province', 'store_factory_zipcode', 'store_factory_tel', 'store_factory_fax', 'attach_product_plan', 'attach_hiring_book', 'attach_factory_license', 'attach_standard_to_made', 'attach_difference_standard', 'attach_drawing', 'attach_other', 'remark', 'state', 'ordering', 'created_by', 'updated_by','tax_id'];

    /*
      Sorting
    */
    public $sortable = ['ref_no', 'title', 'different_no', 'reason', 'foreign_standard_ref', 'country_ref', 'start_date', 'end_date', 'company_order', 'made_factory_chk', 'made_factory_name', 'made_factory_addr_no', 'made_factory_nicom', 'made_factory_soi', 'made_factory_road', 'made_factory_moo', 'made_factory_subdistrict', 'made_factory_district', 'made_factory_province', 'made_factory_zipcode', 'made_factory_tel', 'made_factory_fax', 'store_factory_chk', 'store_factory_name', 'store_factory_addr_no', 'store_factory_nicom', 'store_factory_soi', 'store_factory_road', 'store_factory_moo', 'store_factory_subdistrict', 'store_factory_district', 'store_factory_province', 'store_factory_zipcode', 'store_factory_tel', 'store_factory_fax', 'attach_product_plan', 'attach_hiring_book', 'attach_factory_license', 'attach_standard_to_made', 'attach_difference_standard', 'attach_drawing', 'attach_other', 'remark', 'state', 'ordering', 'created_by', 'updated_by','tax_id'];

    /*
      User Relation
    */
    public function user_created(){
      return $this->belongsTo(User::class, 'created_by');
    }

    public function user_updated(){
      return $this->belongsTo(User::class, 'updated_by');
    }

    public function getCreatedNameAttribute() {
  		return $this->user_created->trader_operater_name;
  	}

    public function getUpdatedNameAttribute() {
  		return @$this->user_updated->trader_operater_name;
  	}

    /* License */
    public function detail_list(){
      return $this->hasMany(Applicant21OwnProductDetail::class, 'applicant_21own_id');
    }

}
