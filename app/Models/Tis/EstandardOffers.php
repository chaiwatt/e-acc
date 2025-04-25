<?php

namespace App\Models\Tis;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

 
class EstandardOffers extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tisi_estandard_offers';

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
    protected $fillable = ['title','owner', 'title_eng', 'std_type', 'scope', 'objectve', 'path','caption', 'attach_old', 'attach_new', 'attach_type', 'stakeholders', 'name', 'telephone','department_id', 'department', 'email', 'address', 'ip_address', 'user_agent', 'state', 'created_by', 'updated_by'];

    /*
      Sorting
    */
    public $sortable =  ['title', 'title_eng', 'std_type', 'scope', 'objectve', 'path','caption', 'attach_old', 'attach_new', 'attach_type', 'stakeholders', 'name', 'telephone','department_id', 'department', 'email', 'address', 'ip_address', 'user_agent', 'state', 'created_by', 'updated_by'];




}
