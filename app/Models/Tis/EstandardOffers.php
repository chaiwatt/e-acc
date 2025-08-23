<?php

namespace App\Models\Tis;

use App\AttachFile;
use App\Models\Sso\User;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

 
class EstandardOffers extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tisi_estandard_offers';

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
    protected $fillable = ['proposer_type','meeting_count','iso_number','standard_name','standard_name_en','national_strategy','reason','reason_detail','title','owner', 'title_eng', 'std_type', 'scope', 'objectve', 'path','caption', 'attach_old', 'attach_new', 'attach_type', 'stakeholders', 'name', 'telephone','department_id', 'department', 'email', 'address', 'ip_address', 'user_agent', 'state', 'created_by', 'updated_by','request_owner','company'];

    /*
      Sorting
    */
    public $sortable =  ['title', 'title_eng', 'std_type', 'scope', 'objectve', 'path','caption', 'attach_old', 'attach_new', 'attach_type', 'stakeholders', 'name', 'telephone','department_id', 'department', 'email', 'address', 'ip_address', 'user_agent', 'state', 'created_by', 'updated_by'];


  public function AttachFileAttachFileTo()
  { 
     $tb = new EstandardOffers;
     $files = $this->belongsTo(AttachFile::class,'id','ref_id')->where('ref_table',$tb->getTable())->where('section','attach_file')->orderby('id','desc');
    //  dd($file->get());
      return  $files;
  }

  public function getAttachments()
  {
    $tb = new EstandardOffers;
    return AttachFile::where('ref_table',$tb->getTable())->where('section','attach_file')->where('ref_id',$this->id)->orderby('id','desc')->get();
  }

  public function AttachFileAttachTo()
  { 
     $tb = new EstandardOffers;
      return $this->belongsTo(AttachFile::class,'id','ref_id')->where('ref_table',$tb->getTable())->where('section','attach')->orderby('id','desc');
  }

  public function requetOwner()
  { 
     $user = User::where('username',$this->owner)->first();
     return $user;
  }
}
