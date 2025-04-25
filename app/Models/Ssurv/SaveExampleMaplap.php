<?php

namespace App\Models\Ssurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class SaveExampleMaplap extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'save_example_map_lap';

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
    protected $fillable = ['num_row', 'name_lap', 'detail_product', 'detail_product_maplap', 'no_example_id', 'status', 'example_id','tis_standard',
                            'user_create','licensee','remark'];

    /*
      Sorting
    */
    public $sortable = ['num_row', 'name_lap', 'detail_product', 'detail_product_maplap', 'no_example_id', 'status', 'example_id','tis_standard',
                        'user_create','licensee' ,'remark'];
    public function tis(){
        return $this->belongsTo(Tis::class, 'tis_standard','tb3_Tisno');
    }

}
