<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'user_register';

  protected $primaryKey = 'runrecno';

  public function blogs(){
      return $this->hasMany(Blog::class);
  }

}
