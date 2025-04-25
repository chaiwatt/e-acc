<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class CostDetails extends Model
{
    use Sortable;

    protected $table = "cost_details";
    protected $primaryKey = 'id';
    protected $fillable = [
        'title'
    ];

}
