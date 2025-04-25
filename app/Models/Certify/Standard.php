<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use App\Models\Certify\GazetteStandard;
use App\Models\Bcertify\Standardtype;

class Standard extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'certify_standards';

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
    protected $fillable = ['setstandard_id', 'std_no', 'std_book', 'std_year', 'std_full', 'std_title', 'std_title_en', 'method_id', 'format_id', 'std_abstract', 'std_abstract_en', 'isbn_no', 'status_id', 'created_by', 'updated_by',
                          'std_file', 'std_sign_date', 'gazette_state', 'gazette_book', 'gazette_section', 'gazette_post_date', 'gazette_effective_date', 'gazette_file', 'publish_state', 'revoke_date', 'revoke_remark', 'revoke_book', 'revoke_file'];

    /*
      Sorting
    */
    public $sortable = ['setstandard_id', 'std_no', 'std_book', 'std_year', 'std_full', 'std_title', 'std_title_en', 'method_id', 'format_id', 'std_abstract', 'std_abstract_en', 'isbn_no', 'status_id', 'created_by', 'updated_by',
                        'std_file', 'std_sign_date', 'gazette_state', 'gazette_book', 'gazette_section', 'gazette_post_date', 'gazette_effective_date', 'gazette_file', 'publish_state', 'revoke_date', 'revoke_remark', 'revoke_book', 'revoke_file'];

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
  		return $this->user_created->reg_fname.' '.$this->user_created->reg_lname;
  	}

    public function getUpdatedNameAttribute() {
  		return @$this->user_updated->reg_fname.' '.@$this->user_updated->reg_lname;
  	}

    public function standard_type() {
      return $this->belongsTo(Standardtype::class, 'setstandard_id');
    }

    public function gazette_standard() {
      return $this->belongsTo(GazetteStandard::class, 'id', 'standard_id');
    }

    public function getSetStandardStatusAttribute()
    {
      if ($this->status_id == 4){
          return "อยู่ระหว่างจัดทำมาตรฐานการรับรอง";
      }elseif ($this->status_id == 5){
          return "ดำเนินการ และเสนอผู้มีอำนาจลงนาม";
      }elseif ($this->status_id == 6){
          return "ลงนามเรียบร้อย";
      }elseif ($this->status_id == 7){
          return "เสนอราชกิจจานุเบกษา";
      }elseif ($this->status_id == 8){
          return "ประกาศราชกิจจานุเบกษาเรียบร้อย";
      }else{
          return "n/a";
      }
    }

    public function getPublishStatusAttribute()
    {
      if ($this->publish_state == 1){
          return "รอเผยแพร่";
      }elseif ($this->publish_state == 2){
          return "เผยแพร่";
      }elseif ($this->publish_state == 3){
          return "ยกเลิก";
      }else{
          return "n/a";
      }
    }


}
