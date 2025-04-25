<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;

class Volume20TerProductDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_volume_20ter_product_details';

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
    protected $fillable = ['volume_20ter_id', 'detail_id', 'quantity'];

    /*
      Sorting
    */
    public $sortable = ['volume_20ter_id', 'detail_id', 'quantity'];

}
