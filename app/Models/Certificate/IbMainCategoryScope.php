<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Model;
use App\Models\Certificate\IbSubCategoryScope;

class IbMainCategoryScope extends Model
{
    protected $table = 'ib_main_category_scopes';
    protected $fillable = ['name','name_en'];

    // Relationship: Main Category มี Sub Categories หลายตัว
    public function subCategoryScopes()
    {
        return $this->hasMany(IbSubCategoryScope::class, 'ib_main_category_scope_id');
    }
}
