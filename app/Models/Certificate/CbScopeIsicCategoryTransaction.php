<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\CbScopeIsicCategory;
use App\Models\Bcertify\CbScopeIsicSubCategory;
use App\Models\Certificate\CbScopeIsicSubCategoryTransaction;

class CbScopeIsicCategoryTransaction extends Model
{
    use Sortable;
    protected $table = "cb_scope_isic_category_transactions";
    protected $primaryKey = 'id';
    

    protected $fillable = ['cb_scope_isic_transaction_id', 'category_id', 'is_checked'];

    public function cbScopeIsicSubCategoryTransactions() {
        return $this->hasMany(CbScopeIsicSubCategoryTransaction::class, 'cb_scope_isic_category_transaction_id');
    }

    public function cbScopeIsicCategory() {
        return $this->belongsTo(CbScopeIsicCategory::class, 'category_id');
    }

    public function cbScopeIsicSubCategories()
    {
        $cbScopeIsicSubCategories = CbScopeIsicSubCategory::where('category_id',$this->category_id)->get();
        return $cbScopeIsicSubCategories;
        // return $this->hasMany(CbScopeIsicSubCategory::class, 'category_id');
    }

    
}

