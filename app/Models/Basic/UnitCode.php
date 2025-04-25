<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;

class UnitCode extends Model
{
    use Sortable;

    //table name
    protected $table = 'tb_unitcode';

    //primary
    protected $primaryKey = 'Auto_num';

    /*
      Sorting
    */
    public $sortable = ['id_unit', 'name_unit', 'date_start', 'date_end', 'IsTisiUse'];

}
