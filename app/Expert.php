<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use App\AttachFile;
use HP;
use App\Models\Basic\AppointDepartment;
class Expert extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'register_experts';

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
    protected $fillable = ['trader_id', 'taxid',
     'head_name', 'head_address_no', 'head_village', 'head_moo', 'head_soi', 'head_subdistrict', 'head_district', 'head_province', 'head_zipcode',
      'contact_address_no', 'contact_village', 'contact_moo', 'contact_soi', 'contact_subdistrict', 'contact_district', 'contact_province', 'contact_zipcode', 'department_id','position','historycv_text',
      'mobile_phone', 'email', 'operation_id', 'ref_no', 'bank_name', 'bank_title', 'bank_number', 'bank_file', 'historycv_file', 'address_same_head','pic_profile','committee_specials_id','status',
      'assign_date', 'assign_by', 'receive_date', 'receive_by', 'detail', 'confirm_date', 'confirm_by', 'expert_no', 'revoke_date', 'revoke_detail', 'revoke_by', 'state', 'created_by', 'updated_by', 'token', 'deleted_by', 'deleted_at'];

    /*
      Sorting
    */
    public $sortable = ['trader_id', 'taxid',
    'head_name', 'head_address_no', 'head_village', 'head_moo', 'head_soi', 'head_subdistrict', 'head_district', 'head_province', 'head_zipcode',
     'contact_address_no', 'contact_village', 'contact_moo', 'contact_soi', 'contact_subdistrict', 'contact_district', 'contact_province', 'contact_zipcode' ,'department_id','position','historycv_text',
     'mobile_phone', 'email', 'operation_id', 'ref_no', 'bank_name', 'bank_title', 'bank_number', 'bank_file', 'historycv_file', 'address_same_head','pic_profile','committee_specials_id','status',
     'assign_date', 'assign_by', 'receive_date', 'receive_by', 'detail', 'confirm_date', 'confirm_by', 'expert_no', 'revoke_date', 'revoke_detail', 'revoke_by', 'state', 'created_by', 'updated_by', 'token', 'deleted_by', 'deleted_at'];
    

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

    public function AttachFileHistorycvFileTo()
    { 
       $tb = new Expert;
        return $this->belongsTo(AttachFile::class,'id','ref_id')->where('ref_table',$tb->getTable())->where('section','historycv_file')->orderby('id','desc');
    }

    public function AttachFileBankFileTo()
    { 
       $tb = new Expert;
        return $this->belongsTo(AttachFile::class,'id','ref_id')->where('ref_table',$tb->getTable())->where('section','bank_file')->orderby('id','desc');
    }
    public function expert_education_many()
    {
        return $this->hasMany(ExpertEducation::class, 'expert_id') ;
    }
    public function expert_experiences_many()
    {
        return $this->hasMany(RegisterExpertsExperiences::class, 'expert_id') ;
    }

    public function expert_historys_many()
    {
        return $this->hasMany(RegisterExpertsHistorys::class, 'expert_id') ;
    }

    public function appoint_department_to()
    {  
        return $this->belongsTo(AppointDepartment::class,'department_id');
    }
}
