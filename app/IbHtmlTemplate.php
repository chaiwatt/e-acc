<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IbHtmlTemplate extends Model
{
    protected $table = 'ib_html_templates';

    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_ib_id','user_id','type_standard','standard_change','type_unit','html_pages', 'template_type','json_data'];
}

