<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use App\AttachFile;
use App\Models\Certify\RegisterExpertAssign;
use HP;

class RegisterExpert extends Model
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
    protected $fillable =['trader_id', 'taxid',
    'head_name', 'head_address_no', 'head_village', 'head_moo', 'head_soi', 'head_subdistrict', 'head_district', 'head_province', 'head_zipcode',
     'contact_address_no', 'contact_village', 'contact_moo', 'contact_soi', 'contact_subdistrict', 'contact_district', 'contact_province', 'contact_zipcode', 'department_id','position','historycv_text',
     'mobile_phone', 'email', 'operation_id', 'ref_no', 'bank_name', 'bank_title', 'bank_number', 'bank_file', 'historycv_file', 'address_same_head',
     'assign_date', 'assign_by', 'receive_date', 'receive_by', 'detail', 'confirm_date', 'confirm_by', 'expert_no', 'revoke_date', 'revoke_detail', 'revoke_by', 'state', 'created_by', 'updated_by'];
    /*
      Sorting
    */
    public $sortable = ['trader_id', 'taxid',
    'head_name', 'head_address_no', 'head_village', 'head_moo', 'head_soi', 'head_subdistrict', 'head_district', 'head_province', 'head_zipcode',
     'contact_address_no', 'contact_village', 'contact_moo', 'contact_soi', 'contact_subdistrict', 'contact_district', 'contact_province', 'contact_zipcode', 'department_id','position','historycv_text',
     'mobile_phone', 'email', 'operation_id', 'ref_no', 'bank_name', 'bank_title', 'bank_number', 'bank_file', 'historycv_file', 'address_same_head',
     'assign_date', 'assign_by', 'receive_date', 'receive_by', 'detail', 'confirm_date', 'confirm_by', 'expert_no', 'revoke_date', 'revoke_detail', 'revoke_by', 'state', 'created_by', 'updated_by'];
    

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
       $tb = new RegisterExpert;
        return $this->belongsTo(AttachFile::class,'id','ref_id')->where('ref_table',$tb->getTable())->where('section','historycv_file')->orderby('id','desc');
    }

    public function AttachFileBankFileTo()
    { 
       $tb = new RegisterExpert;
        return $this->belongsTo(AttachFile::class,'id','ref_id')->where('ref_table',$tb->getTable())->where('section','bank_file')->orderby('id','desc');
    }

    public function expert_assigns(){
      return $this->hasMany(RegisterExpertAssign::class, 'register_expert_id', 'id');
    }

    public function getShowAssignsAttribute(){
          $arr = $this->expert_assigns;
          $html = '';
          foreach($arr as $item){
              $html .= $item->assign_name->reg_fname."<br>";
          }
          return $html;
    }
    public function expert_education_many()
    {
        return $this->hasMany(RegisterExpertEducation::class, 'expert_id') ;
    }

}
