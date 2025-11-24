<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantCB\CertiCb;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CbHtmlTemplate extends Model
{
    protected $table = 'cb_html_templates';

    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_cb_id','user_id','type_standard','petitioner','trust_mark','html_pages', 'template_type','json_data'];

    public function certiCb(): BelongsTo
    {
        // Assuming the CertiLab model is named 'CertiLab' and the primary key is 'id'
        // and the foreign key in this table is 'app_certi_lab_id'
        return $this->belongsTo(CertiCb::class, 'app_certi_cb_id');
    }
}

