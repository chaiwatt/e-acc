<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Bcertify\TestBranch;  
use App\Models\Bcertify\ProductCategory; 
class CertifyTestScope extends Model // ทดสอบ
{
    protected $table = 'app_certify_test_scopes';
    protected $fillable = [
        'app_certi_lab_id',
        'branch_id',
        'category_product_id',
        'product_id',
        'token'
        ];

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function certi_lab()
    {
        return $this->belongsTo(CertiLab::class ,'app_certi_lab_id' );
    }

    public function getBranch(){
        return  DB::table('bcertify_test_branches')->select('*')->where('id',$this->branch_id)->first();
    }

    public function get_detail(){
        return DB::table('app_certi_scope_test_detail')->where('certi_test_scope_id',$this->id)->get() ?? null;
    }

    public function get_how(){
        return DB::table('app_certi_scope_test_how')->where('certi_test_scope_id',$this->id)->get() ?? null;
    }

    public function get_category(){
        return DB::table('bcertify_product_categories')->where('id',$this->category_product_id)->first() ?? null;
    }

    public function get_product(){
        return DB::table('bcertify_product_items')->where('id',$this->product_id)->first() ?? null;
    }
    public function Tablebranch()
    {
        return $this->belongsTo(TestBranch::class ,'branch_id' );
    }
    public function TableCategoryProduct()
    {
        return $this->belongsTo(ProductCategory::class ,'category_product_id');
    }



//    public function get_branch(){
//        $standardNumber = $this->assessment_type;
//        $branchValue = array();
//        $branches = DB::table('certificate_branches')->select("*")->where('certificate_id',$this->id)->get();
//        foreach ($branches as $bb){
//            if ($standardNumber == '2'){
//                $branch = InspectBranch::whereId($bb->branch_id)->first();
//            }elseif ($standardNumber == '1'){
//                $branch = CertificationBranch::whereId($bb->branch_id)->first();
//            }elseif ($standardNumber == '3'){
//
//            }elseif ($standardNumber == '4'){
//                $branch = CalibrationBranch::whereId($bb->branch_id)->first();
//            }
//            array_push($branchValue,$branch);
//        }
//
//        return $branchValue;
//    }


}
