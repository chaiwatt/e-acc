<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SignerGroup extends Model
{
    protected $fillable = ['name', 'signer_ids'];
}
