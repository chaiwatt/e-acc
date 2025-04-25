<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'besurv_units';

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
	protected $fillable = ['title', 'state', 'created_by', 'updated_by'];

	/*
	  User Relation
	*/
	public function user_created(){
		return $this->belongsTo(User::class, 'created_by');
	}

	public function user_updated(){
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function getCreatedNameAttribute() {
		return $this->user_created->trader_operater_name;
	}

	public function getUpdatedNameAttribute() {
		return @$this->user_updated->trader_operater_name;
	}

}
