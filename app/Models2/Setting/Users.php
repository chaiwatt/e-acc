<?php

namespace App\Models2\Setting;

use Illuminate\Database\Eloquent\Model;
 
class Users extends Model
{
       /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql2';
    protected $table = 'ros_users';
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
    protected $fillable = ['name', 'username', 'contact_name', 'contact_prefix_name', 'contact_prefix_text', 'contact_first_name'];
 


}
