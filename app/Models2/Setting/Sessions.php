<?php

namespace App\Models2\Setting;

use Illuminate\Database\Eloquent\Model;
 
class Sessions extends Model
{
       /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql2';
    protected $table = 'sessions';
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
    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'payload', 'login_at', 'status'];
    
    public function user_to(){
      return $this->belongsTo(Users::class, 'user_id');
    }
    

}
