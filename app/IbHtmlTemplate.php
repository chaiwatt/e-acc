<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantIB\CertiIb;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IbHtmlTemplate extends Model
{
    protected $table = 'ib_html_templates';

    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_ib_id','user_id','type_standard','standard_change','type_unit','html_pages', 'template_type','json_data'];

    public function certiIb(): BelongsTo
    {
        // Assuming the CertiLab model is named 'CertiLab' and the primary key is 'id'
        // and the foreign key in this table is 'app_certi_lab_id'
        return $this->belongsTo(CertiIb::class, 'app_certi_ib_id');
    }
}

