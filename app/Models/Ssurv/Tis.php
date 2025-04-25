<?php

namespace App\Models\Ssurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Tis extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tb3_tis';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'tb3_TisAutono';

    /*
      Sorting
    */
    public $sortable = ['tb3_TisshortNo', 'tb3_Tisno', 'tb3_TisThainame', 'tb3_TisEngname'];

}
