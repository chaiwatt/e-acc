<?php

namespace App\Models\Bcertify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;

class ConfigAttachForm extends Model
{
    use Sortable;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bcertify_config_attach_forms';

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
    protected $fillable = ['config_attach_id', 'form'];

    /*
      Sorting
    */
    public $sortable = ['config_attach_id', 'form'];

}
