<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class CertiLabStep extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_certi_lab_auditors_step';

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
    protected $fillable = ['title'];

    /*
      Sorting
    */
    public $sortable = ['title'];




}
