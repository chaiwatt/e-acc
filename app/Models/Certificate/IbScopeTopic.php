<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Model;
use App\Models\Certificate\IbScopeDetail;
use App\Models\Certificate\IbSubCategoryScope;

class IbScopeTopic extends Model
{
    protected $table = 'ib_scope_topics';
    protected $fillable = ['name','name_en', 'ib_sub_category_scope_id','standard','standard_en'];

    // Relationship: Topic อยู่ใน Sub Category เดียว
    public function subCategoryScope()
    {
        return $this->belongsTo(IbSubCategoryScope::class, 'ib_sub_category_scope_id');
    }

    // Relationship: Topic มี Details หลายตัว
    public function scopeDetails()
    {
        return $this->hasMany(IbScopeDetail::class, 'ib_scope_topic_id');
    }
}
