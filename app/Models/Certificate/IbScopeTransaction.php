<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Model;
use App\Models\Certificate\IbScopeTopic;
use App\Models\Certificate\IbScopeDetail;
use App\Models\Certify\ApplicantIB\CertiIb;
use App\Models\Certificate\IbSubCategoryScope;
use App\Models\Certificate\IbMainCategoryScope;

class IbScopeTransaction extends Model
{
    protected $table = 'ib_scope_transactions';

    // กำหนด fillable fields สำหรับ mass assignment
    protected $fillable = [
        'certi_ib_id',
        'ib_main_category_scope_id',
        'ib_sub_category_scope_id',
        'ib_scope_topic_id',
        'ib_scope_detail_id',
        'standard',
        'standard_en',
    ];

    // Relationship กับ CertiIb
    public function certiIb()
    {
        return $this->belongsTo(CertiIb::class, 'certi_ib_id');
    }

    // Relationship กับ IbMainCategoryScope
    public function ibMainCategoryScope()
    {
        return $this->belongsTo(IbMainCategoryScope::class, 'ib_main_category_scope_id');
    }

    // Relationship กับ IbSubCategoryScope
    public function ibSubCategoryScope()
    {
        return $this->belongsTo(IbSubCategoryScope::class, 'ib_sub_category_scope_id');
    }

    // Relationship กับ IbScopeTopic
    public function ibScopeTopic()
    {
        return $this->belongsTo(IbScopeTopic::class, 'ib_scope_topic_id');
    }

    // Relationship กับ IbScopeDetail
    public function ibScopeDetail()
    {
        return $this->belongsTo(IbScopeDetail::class, 'ib_scope_detail_id');
    }
}


// $table->unsignedInteger('certi_ib_id')->nullable(); 
// $table->unsignedInteger('ib_main_category_scope_id')->nullable(); 
// $table->unsignedInteger('ib_sub_category_scope_id')->nullable(); 
// $table->unsignedInteger('ib_scope_topic_id')->nullable(); 
// $table->unsignedInteger('ib_scope_detail_id')->nullable(); 