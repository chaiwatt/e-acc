<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Tb10Trader extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'tb10_nsw_lite_trader';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'trader_autonumber';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['trader_date', 'trader_inti', 'trader_operater_name', 'trader_type','trader_address_road'];

    /*
      Sorting
    */
    public $sortable = ['trader_date', 'trader_inti', 'trader_operater_name', 'trader_type','trader_address_road'];

}
