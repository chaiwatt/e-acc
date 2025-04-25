<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Country extends Model
{
	use Sortable;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tb_country';
	
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
	protected $fillable = ['title', 'title_en', 'full_title', 'created_by', 'updated_by'];
	
	/*
	  Sorting
	*/
	public $sortable = ['title', 'title_en', 'full_title', 'created_by', 'updated_by'];
	
	
}
