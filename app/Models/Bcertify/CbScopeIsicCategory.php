<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\CbScopeIsicIsic;
use App\Models\Bcertify\CbScopeIsicSubCategory;

class CbScopeIsicCategory extends Model
{
    use Sortable;
    protected $fillable = [
        'isic_id',
        'category_code',
        'description_th',
        'description_en'
    ];
    protected $table = 'cb_scope_isic_categories';
    protected $primaryKey = 'id';

    // ความสัมพันธ์ belongsTo ไปยัง ISIC
    public function isic()
    {
        return $this->belongsTo(CbScopeIsicIsic::class, 'isic_id');
    }

    // ความสัมพันธ์ 1-to-many กับ subcategories
    public function subcategories()
    {
        return $this->hasMany(CbScopeIsicSubCategory::class, 'category_id');
    }
}
