<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\CbScopeIsicCategory;

class CbScopeIsicIsic extends Model
{
    use Sortable;
    protected $fillable = [
        'isic_code',
        'description_th',
        'description_en'
    ];
    protected $table = 'cb_scope_isic_isics';
    protected $primaryKey = 'id';

    public function categories()
    {
        return $this->hasMany(CbScopeIsicCategory::class, 'isic_id');
    }
}
