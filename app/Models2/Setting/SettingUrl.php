<?php

namespace App\Models2\Setting;

use Illuminate\Database\Eloquent\Model;
 
class SettingUrl extends Model
{
       /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql2';
    protected $table = 'ros_setting_url';
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
    protected $fillable = ['column_name', 'data'];
 


}
