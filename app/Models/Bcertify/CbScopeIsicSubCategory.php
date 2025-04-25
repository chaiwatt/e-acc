<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\CbScopeIsicCategory;

class CbScopeIsicSubCategory extends Model
{
    use Sortable;
    protected $fillable = [
        'category_id',
        'sub_category_code',
        'description_th',
        'description_en'
    ];
    protected $table = 'cb_scope_isic_sub_categories';
    protected $primaryKey = 'id';

    public function category()
    {
        return $this->belongsTo(CbScopeIsicCategory::class, 'category_id');
    }
}
