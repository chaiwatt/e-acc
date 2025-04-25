<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Province extends Model
{
    use Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'province';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'PROVINCE_ID';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['PROVINCE_NAME', 'PROVINCE_NAME_EN', 'title', 'created_by', 'updated_by'];

    /*
      Sorting
    */
    public $sortable = ['PROVINCE_ID', 'PROVINCE_NAME', 'PROVINCE_NAME_EN', 'created_by', 'updated_by'];


}
