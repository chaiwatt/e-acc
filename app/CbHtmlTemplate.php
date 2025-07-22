<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CbHtmlTemplate extends Model
{
    protected $table = 'cb_html_templates';

    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_cb_id','user_id','type_standard','petitioner','trust_mark','html_pages', 'template_type','json_data'];
}

