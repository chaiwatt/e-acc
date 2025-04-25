<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Model;

class IbScopeDetail extends Model
{
    protected $table = 'ib_scope_details';
    protected $fillable = ['name','name_en', 'ib_scope_topic_id'];

    // Relationship: Detail อยู่ใน Topic เดียว
    public function scopeTopic()
    {
        return $this->belongsTo(IbScopeTopic::class, 'ib_scope_topic_id');
    }
}
