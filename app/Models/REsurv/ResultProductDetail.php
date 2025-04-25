<?php

namespace App\Models\REsurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ResultProductDetail extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'result_product_detail';

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
    protected $fillable = ['name_result', 'type_result', 'id_result','action'];

    /*
      Sorting
    */
    public $sortable = ['name_result', 'type_result', 'id_result','action'];

}
