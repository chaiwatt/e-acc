<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;
use App\Models\Basic\UnitCode;

class Applicant20BisProductDetail extends Model
{
	protected $table = 'esurv_applicant_20bis_product_details';

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
	protected $fillable = ['detail', 'quantity', 'unit', 'unit_other', 'applicant_20bis_id'];

	/* Unit */
	public function data_unit(){
		return $this->belongsTo(UnitCode::class, 'unit');
	}

	public function informed(){
		return $this->hasMany(Volume20BisProductDetail::class, 'detail_id', 'id');
	}

}
