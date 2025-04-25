<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use HP;

class RegisterExpertsHistorys extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'register_experts_historys';

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
    protected $fillable = ['expert_id', 'operation_at', 'department_id', 'committee_no', 'expert_group_id', 'position_id'];
    /*
      Sorting
    */
    public $sortable = ['expert_id', 'operation_at', 'department_id', 'committee_no', 'expert_group_id', 'position_id'];

   


}
