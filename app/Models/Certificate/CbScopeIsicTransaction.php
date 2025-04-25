<?php

namespace App\Models\Certificate;

use App\Models\Bcertify\CbScopeIsicCategory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\CbScopeIsicIsic;
use App\Models\Certify\ApplicantCB\CertiCb;

class CbScopeIsicTransaction extends Model
{
    use Sortable;
    protected $table = "cb_scope_isic_transactions";
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'certi_cb_id',
        'isic_id', 
        'is_checked'
    ];

    public function certiCb()
    {
        return $this->belongsTo(CertiCb::class, 'certi_cb_id', 'id');
    }

    public function cbScopeIsicCategoryTransactions() {
        return $this->hasMany(CbScopeIsicCategoryTransaction::class, 'cb_scope_isic_transaction_id');
    }

    public function isic()
    {
        return $this->belongsTo(CbScopeIsicIsic::class, 'isic_id', 'id');
    }

    public function cbScopeIsicCategories() {
        $cbScopeIsicCategories = CbScopeIsicCategory::where('isic_id',$this->isic_id)->get();
        return $cbScopeIsicCategories;
    }

}
