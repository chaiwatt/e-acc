<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use  App\Models\Bcertify\Formula;
use App\Models\Bcertify\TestBranch;
use App\Models\Bcertify\TestItem;


class SetStandardUserSub extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'set_standard_user_sub';

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
    protected $fillable = ['standard_user_id', 'standard_id', 'test_branch_id', 'items_id'];

    /*
      Sorting
    */
    public $sortable = ['standard_user_id', 'standard_id', 'test_branch_id', 'items_id'];

    public function DataFormula(){
      return $this->belongsTo(Formula::class, 'standard_id', 'id');
    }
    
    public function set_standard_user(){
      return $this->belongsTo(SetStandardUser::class, 'standard_user_id', 'id');
    }

    public function department(){
      return $this->belongsTo(TestBranch::class, 'test_branch_id', 'id');
    }
    public function TestItem(){
      return $this->belongsTo(TestItem::class, 'items_id', 'id');
    }
    

}
