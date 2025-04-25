<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;
use App\Models\Basic\UnitCode;

class Tis extends Model
{

    //table name
    protected $table = 'tb3_tis';

    /*
      Unit Code Relation
    */
    public function unit_code(){
      return $this->belongsTo(UnitCode::class, 'unitcode_id');
    }

}
