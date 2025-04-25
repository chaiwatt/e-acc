<?php

namespace App\Models\REsurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ResultProduct extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'result_product';

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
    protected $fillable = ['tis_standard', 'status', 'user_create'];

    /*
      Sorting
    */
    public $sortable = ['tis_standard', 'status', 'user_create'];

    public function tis(){
        return $this->belongsTo(Tis::class, 'tis_standard','tb3_Tisno');
    }
    public function detail(){
        return $this->hasMany(ResultProductDetail::class, 'id_result','id');
    }
}
