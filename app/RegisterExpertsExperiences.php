<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use HP;

class RegisterExpertsExperiences extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'register_experts_experiences';

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
    protected $fillable = ['expert_id', 'years', 'department_id', 'position', 'role'];
    /*
      Sorting
    */
    public $sortable = ['expert_id', 'years', 'department_id', 'position', 'role'];

   

 

}
