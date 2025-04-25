<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;

class Volume21OwnProductDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_volume_21own_product_details';

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
    protected $fillable = ['volume_21own_id', 'detail_id', 'quantity'];

    /*
      Sorting
    */
    public $sortable = ['volume_21own_id', 'detail_id', 'quantity'];

}
