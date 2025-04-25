<?php

namespace App\Models\Certificate;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class  TrackingAssigns extends Model
{
    use Sortable;
    protected $table = "app_certi_tracking_assign";
    protected $primaryKey = 'id';
    protected $fillable = ['tracking_id','certificate_type', 'reference_refno', 'ref_table', 'ref_id', 'user_id', 'created_by', 'updated_by'];
}
