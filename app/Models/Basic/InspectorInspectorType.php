<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class InspectorInspectorType extends Model
{
	use Sortable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'besurv_inspector_inspector_types';

	/**
	 * The database primary key value.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

}
