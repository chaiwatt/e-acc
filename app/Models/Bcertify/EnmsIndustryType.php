<?php

namespace App\Models\Bcertify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use App\Models\Bcertify\IndustryType;

class EnmsIndustryType extends Model
{
    use Sortable;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bcertify_enms_industry_types';

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
    protected $fillable = ['enms_id', 'industry_type_id'];

    /*
      Sorting
    */
    public $sortable = ['enms_id', 'industry_type_id'];

    /* Industry Type */
    public function industry_type(){
      return $this->belongsTo(IndustryType::class, 'industry_type_id');
    }

}
