<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CbScopeTemplate extends Model
{
        protected $fillable = [
                        'scope_std_name', 
                        'scope_header_text'
                    ];
}
