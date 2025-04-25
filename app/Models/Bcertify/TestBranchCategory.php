<?php

namespace App\Models\Bcertify;

use App\Models\Bcertify\TestBranch;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class TestBranchCategory extends Model
{
    use Sortable;
    protected $fillable = [
        'bcertify_test_branche_id',
        'name',
        'name_eng',
        'state'
    ];
    protected $table = 'test_branch_categories';
    protected $primaryKey = 'id';

    public function testBranch()
    {
        return $this->belongsTo(TestBranch::class, 'bcertify_test_branche_id', 'id');
    }
}
