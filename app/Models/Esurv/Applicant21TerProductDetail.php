<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;
use App\Models\Basic\UnitCode;

class Applicant21TerProductDetail extends Model
{
	protected $table = 'esurv_applicant_21ter_product_details';

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
	protected $fillable = ['detail', 'quantity', 'unit', 'unit_other', 'applicant_21ter_id'];

	public function data_unit(){
		return $this->belongsTo(UnitCode::class, 'unit');
	}

	public function informed(){
		return $this->hasMany(Volume21TerProductDetail::class, 'detail_id', 'id');
	}

}
