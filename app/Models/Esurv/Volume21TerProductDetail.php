<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;

class Volume21TerProductDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_volume_21ter_product_details';

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
    protected $fillable = ['volume_21ter_id', 'detail_id', 'quantity', 'quantity_export', 'start_product_date', 'end_product_date', 'start_import_date', 'end_import_date', 'start_export_date', 'end_export_date'];

    /*
      Sorting
    */
    public $sortable = ['volume_21ter_id', 'detail_id', 'quantity', 'quantity_export', 'start_product_date', 'end_product_date', 'start_import_date', 'end_import_date', 'start_export_date', 'end_export_date'];

}
