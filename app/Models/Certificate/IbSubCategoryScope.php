<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Model;
use App\Models\Certificate\IbScopeTopic;
use App\Models\Certificate\IbMainCategoryScope;

class IbSubCategoryScope extends Model
{
    protected $fillable = ['name','name_en', 'ib_main_category_scope_id'];

    // Relationship: Sub Category อยู่ใน Main Category เดียว
    public function mainCategoryScope()
    {
        return $this->belongsTo(IbMainCategoryScope::class, 'ib_main_category_scope_id');
    }

    // Relationship: Sub Category มี Topics หลายตัว
    public function scopeTopics()
    {
        return $this->hasMany(IbScopeTopic::class, 'ib_sub_category_scope_id');
    }
}
