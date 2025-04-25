<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Inspector extends Model
{
	use Sortable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'besurv_inspectors';

	/**
	 * The database primary key value.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';
	
}
