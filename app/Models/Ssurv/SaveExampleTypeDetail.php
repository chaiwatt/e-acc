<?php

namespace App\Models\Ssurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class SaveExampleTypeDetail extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'save_example_type_detail';

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
    protected $fillable = ['type_detail', 'example_detail_id', 'action', 'result_id','id_res','no_example_id'];

    /*
      Sorting
    */
    public $sortable = ['type_detail', 'example_detail_id', 'action', 'result_id','id_res','no_example_id'];

}
