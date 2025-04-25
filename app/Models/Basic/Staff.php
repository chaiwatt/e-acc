<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\HasRoles;

class Staff extends Model
{
	use Sortable;
    use HasRoles;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_register';

	/**
	 * The database primary key value.
	 *
	 * @var string
	 */
	protected $primaryKey = 'runrecno';
	protected $fillable = ['reg_email','reg_subdepart','role_id'];
	//ชื่อเต็มเจ้าหน้าที่
	public function getFullNameAttribute() {
		return $this->reg_fname." ".$this->reg_lname;
	}

	public function getroles() {
		return $this->roles();
	}

}
