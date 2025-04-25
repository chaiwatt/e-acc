<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\TestBranchCategory;

class TestBranchParam extends Model
{
    use Sortable;
    protected $fillable = [
        'test_branch_category_id',
        'name',
        'name_eng',
        'state'
    ];
    protected $table = 'test_branch_params';
    protected $primaryKey = 'id';

    public function testBranchCategory()
    {
        return $this->belongsTo(TestBranchCategory::class, 'test_branch_category_id', 'id');
    }
}
