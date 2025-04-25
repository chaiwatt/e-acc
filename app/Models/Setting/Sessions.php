<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Sessions extends Model
{
       /**
     * The database table used by the model.
     *
     * @var string
     */
 
    protected $table = 'sso_sessions';
    public $timestamps = false;
    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'payload', 'login_at', 'status', 'act_instead'];
    
    public function user_to(){
      return $this->belongsTo(User::class, 'user_id');
    }
    
    public function act_instead_to(){
      return $this->belongsTo(User::class, 'act_instead');
    }

}
