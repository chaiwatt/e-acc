<?php

namespace App\Models\Tis;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class TisiEstandardDraftPlan extends Model
{
        use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tisi_estandard_draft_plan';

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
    protected $fillable = ['draft_id', 'offer_id', 'std_type', 'start_std', 'ref_std', 'tis_number', 'tis_book', 'tis_year', 'tis_name', 'tis_name_eng', 'method_id', 'ref_document', 'confirm_time', 'industry_target',
     'assign_id', 'assign_date', 'status_id', 'plan_startdate', 'plan_enddate', 'confirm_by', 'confirm_at', 'created_by', 'updated_by','period','budget','confirm_detail','ref_budget','budget_by','remark','reason','approve'];

    /*
      Sorting
    */
    public $sortable =    ['draft_id', 'offer_id', 'std_type', 'start_std', 'ref_std', 'tis_number', 'tis_book', 'tis_year', 'tis_name', 'tis_name_eng', 'method_id', 'ref_document', 'confirm_time', 'industry_target',
    'assign_id', 'assign_date', 'status_id', 'plan_startdate', 'plan_enddate', 'confirm_by', 'confirm_at', 'created_by', 'updated_by','period','budget','confirm_detail','ref_budget','budget_by','remark','reason'];

}
