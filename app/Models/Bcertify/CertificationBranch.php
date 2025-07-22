<?php

namespace App\Models\Bcertify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;

class CertificationBranch extends Model
{
    use Sortable;

    protected $table = 'bcertify_certification_branches';


    protected $primaryKey = 'id';


    protected $fillable = ['title', 'title_en', 'initial', 'certificate_initial', 'formula_id', 'state', 'created_by', 'updated_by','model_name'];

    /*
      Sorting
    */
    public $sortable = ['title', 'title_en', 'initial', 'certificate_initial', 'formula_id', 'state', 'created_by', 'updated_by'];



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
    
    /* Formula */
    public function formula(){
      return $this->belongsTo(Formula::class, 'formula_id');
    }

}
