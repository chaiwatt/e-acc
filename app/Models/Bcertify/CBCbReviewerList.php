<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CBCbReviewerList extends Model
{
    use Sortable;

    protected $table = 'cb_reviewer_lists';


    protected $primaryKey = 'id';


    protected $fillable = ['app_certi_cb_id', 'auditors_status_id', 'status', 'user_id', 'temp_users', 'temp_departments'];
}
