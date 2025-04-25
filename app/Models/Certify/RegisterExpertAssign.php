<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use App\User;

class RegisterExpertAssign extends Model
{
    protected $table = 'register_expert_assigns';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'register_expert_id',
                            'user_id',
                            'created_by'
                            ];

    public function assign_name(){
        return $this->belongsTo(User::class, 'user_id');
    }
                            
}
