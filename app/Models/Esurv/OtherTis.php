<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use App\Models\Esurv\Other;

class OtherTis extends Model
{
    use Sortable;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_other_tis';

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
    protected $fillable = ['other_id', 'tb3_Tisno'];

    /*
      Sorting
    */
    public $sortable = ['other_id', 'tb3_Tisno'];

    /* Product Group */
    public function other(){
      return $this->belongsTo(Other::class, 'other_id');
    }

}
