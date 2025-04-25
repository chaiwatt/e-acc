<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\CbScopeIsicSubCategory;

class CbScopeIsicSubCategoryTransaction extends Model
{
    use Sortable;
    protected $table = "cb_scope_isic_sub_category_transactions";
    protected $primaryKey = 'id';
    
    protected $fillable = ['cb_scope_isic_category_transaction_id', 'subcategory_id', 'is_checked'];

    public function cbScopeIsicSubCategory() {
        return $this->belongsTo(CbScopeIsicSubCategory::class, 'subcategory_id');
    }
}


