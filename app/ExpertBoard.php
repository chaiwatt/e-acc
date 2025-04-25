<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use App\Models\Basic\ExpertGroup;

class ExpertBoard extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'register_expert_board';

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
    protected $fillable = ['expert_id', 'board_type'];

    /*
      Sorting
    */
    public $sortable = ['expert_id', 'board_type'];


    public function board_type(){
      return $this->belongsTo(ExpertGroup::class, 'board_type');
    }

    public function getBoardNameAttribute() {
  		return $this->board_type->title;
  	}

}
