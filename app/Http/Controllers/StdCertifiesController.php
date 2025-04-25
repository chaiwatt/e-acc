<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certify\Standard;
use Yajra\Datatables\Datatables; 
use HP;
use DB;
class StdCertifiesController extends Controller
{


    public function index(Request $request)
    {
        //  $model = str_slug('','-');
        //     if(HP::CheckPermission('view-'.$model)){
                return view('std-certifies.index');
            // }
            // abort(403);
    }


    
    public function data_list(Request $request)
    { 

      $filter_search = $request->input('filter_search');
      $filter_std_no = $request->input('filter_std_no');
      $query = Standard::query() 
                                ->whereIn('status_id',[9]) 
                                ->where('publish_state',2)
                                ->when($filter_search, function ($query, $filter_search) use ($filter_std_no){
                                  $search_full = str_replace(' ', '', $filter_search ); 
                                  if($filter_std_no == 1){ // ตามเลข มตช.
                                    return  $query->Where(DB::raw("REPLACE(std_full,' ','')"), 'LIKE', "%".$search_full."%");
                                  }else if($filter_std_no ==2){ // ตามชื่อ มตช.
                                    return  $query->Where(DB::raw("REPLACE(std_title,' ','')"), 'LIKE', "%".$search_full."%");
                                  }else{
                                    return  $query->Where(DB::raw("CONCAT(REPLACE(std_full,' ',''),'',REPLACE(std_title,' ',''))"), 'LIKE', "%".$search_full."%");
                                  }
    
                              }) 
                      
                                ;                                             
      return Datatables::of($query)
                          ->addIndexColumn()

                          ->addColumn('std_full', function ($item) {
                              return   !empty($item->std_full)? $item->std_full:'';
                          }) 
                          ->addColumn('std_title', function ($item) {
                              return   !empty($item->std_title)? $item->std_title:'';
                          })
 
                          ->addColumn('gazette_post_date', function ($item) {
                            return   !empty($item->gazette_post_date) ? HP::DateThai($item->gazette_post_date):'-';
                          })

                          ->addColumn('action', function ($item)  {
                                  return  '<a href="' . url('/std-certifies/' .base64_encode($item->id)) . '"
                                         title="View " class="btn btn-info btn-xs">
                                            <i class="fa fa-eye"></i>
                                       </a>';
                          })
                          ->order(function ($query) {
                              $query->orderBy('id', 'DESC');
                          })
                        // ->rawColumns([ 'action']) 
                          ->make(true);
    } 


        public function show($id)
    {
        // $model = str_slug('','-');
 
        // if(HP::CheckPermission('view-'.$model)){
       
          $standard = Standard::findOrFail(base64_decode($id));
            return view('std-certifies.show', compact('standard'));
        // }
        // abort(403);
 

    }


}
