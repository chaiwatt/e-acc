<?php

namespace App\Http\Controllers\REsurv;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Models\Ssurv\SaveExample;
use App\Http\Controllers\Controller;
use App\Models\REsurv\ResultProduct;
use App\Models\Ssurv\SaveExampleFile;

use App\Models\Ssurv\SaveExampleDetail;
use App\Models\Ssurv\SaveExampleMaplap;
use Illuminate\Support\Facades\Storage;
use App\Models\REsurv\ResultProductDetail;
use App\Models\Ssurv\SaveExampleTypeDetail;
use App\Models\Ssurv\SaveExampleMapLapDetail;
use App\Models\Ssurv\Tis;
use HP;

class ReportProductController extends Controller
{
    private $attach_path;//ที่เก็บไฟล์แนบ
    public function __construct()
    {
        $this->middleware('auth');
        $this->attach_path = 'esurv_attach/report_product/';
    }

    public function index(Request $request)
    {

        $user   = auth()->user();

        $filter = [];
        $filter['perPage'] = $request->get('perPage', 10);
        $filter['filter_search'] = $request->get('filter_search', '');
        $filter['filter_status'] = $request->get('filter_status', '');
        $filter['filter_tb3_Tisno'] = $request->get('filter_tb3_Tisno', '');

        $Query = new SaveExampleMaplap();

        $status = ['1', '2', '3', '4'];
        $Query = $Query->wherein('status', $status);
        $Query = $Query->where('status_send', 'ส่ง');
        $Query = $Query->groupBy('no_example_id');
        $Query = $Query->orderBy('created_at');

        if ($filter['filter_search']!='') {
                $Query = $Query->where(function ($query) use ($filter) {
                                    $query->where('licensee', 'LIKE', "%{$filter['filter_search']}%");
                         });
        }

        if ($filter['filter_tb3_Tisno'] != '') {
            $Query = $Query->where('tis_standard', $filter['filter_tb3_Tisno']);
        }

        if ($filter['filter_status'] != '') {
            $Query = $Query->where('status', $filter['filter_status']);
        }

        //แสดงเฉพาะรายการที่ส่งมาให้บริษัทนี้
        $Query = $Query->where('detail_product', $user->trader_autonumber);

        $report_product = $Query->sortable()->paginate($filter['perPage']);

        $temp_num = $report_product->firstItem();
        return view('resurv.report_product.index', ['report_product' => $report_product, 'filter' => $filter, 'temp_num' => $temp_num]);
    }

    public function create()
    {
        return view('resurv.report_product.create');
    }

    public function show($id)
    {
        return view('resurv.report_product.show', compact('report_product'));
    }

    public function edit($id)
    {
        $id_map = SaveExampleMaplap::query()->where('no_example_id', $id)->first();
        $data = SaveExample::find($id_map->example_id);
        $data_detail = SaveExampleDetail::query()->where('id_example', $id_map->example_id)->get();
        $data_res = ResultProduct::query()->where('tis_standard', $data->tis_standard)->pluck('id');
        $data_res_check = ResultProduct::query()->where('tis_standard', $data->tis_standard)->first();
        if ($data_res_check != null) {
            $data_res_detail = ResultProductDetail::query()->where('id_result', $data_res)->get();
        } else {
            $data_res_detail = null;
        }

        $data_res_detail_id = SaveExampleDetail::query()->where('id_example', $id_map->example_id)->pluck('id');
        $data_save_check = SaveExampleTypeDetail::query()->whereIn('example_detail_id', $data_res_detail_id)->where('no_example_id', $id)->first();
        $data_save_type = SaveExampleTypeDetail::query()->whereIn('example_detail_id', $data_res_detail_id)->where('no_example_id', $id)->get();
        $full_name = auth()->user()->reg_fname . ' ' . auth()->user()->reg_lname;

        if ($data_save_check == null) {
            $data_save_type = null;
        }
        $dis = (explode('-', $id));
        $data_file = SaveExampleFile::query()->where('example_id', $id)->get();
        $data_file_check = SaveExampleFile::query()->where('example_id', $id)->first();
        $data_map =SaveExampleMaplap::query()->where('example_id', $id_map->example_id)->where('detail_product_maplap','!=',null)->where('no_example_id', $id)->get();
        $temp_res_detail = ResultProduct::query()->where('tis_standard', $data->tis_standard)->first();
        return view('resurv.report_product.edit', [
            'data_map' => $id_map,
            'data' => $data,
            'data_detail' => $data_detail,
            'data_map_table'=>$data_map,
            'data_res_detail' => $data_res_detail,
            'data_save_type' => $data_save_type,
            'full_name' => $full_name,
            'main_res_id' => $temp_res_detail,
            'dis0' => $dis[0],
            'dis1' => $dis[1],
            'dis2' => $dis[2],
            'data_file' => $data_file,
            'data_file_check' => $data_file_check
            ]);
    }

    public function update(Request $request)
    {
        if ($request->get('status') == '1') {
            return response()->json([
                "status" => "error",
                "message" => "กรุณาเลือกสถานะ!"
            ]);
        }

        if ($request->number_labget != null) {

            $error_labget = 0;
            for ($i = 0; $i < count($request->number_labget); $i++) {
                if ($request->number_labget[$i] == null) {
                    $error_labget += 1;
                }
            }
            if ($error_labget > 0) {
                return response()->json([
                    "status" => "error",
                    "message" => "กรุณาระบุจำนวนที่ได้รับ!"
                ]);
            }
        }

        if ($request->get('tel_lab') == null) {
            return response()->json([
                "status" => "error",
                "message" => "กรุณาระบุเบอร์โทรศัพท์!"
            ]);
        }

        if ($request->get('email_lab') == null) {
            return response()->json([
                "status" => "error",
                "message" => "กรุณาระบุอีเมล!"
            ]);
        }

        $data = SaveExample::find($request->get('example_id'));
        if($data->type_send == 'all'){
            $data->status = $request->get('status');
            $data->save();
        }elseif($data->type_send == 'some'){
            if($data->status != 4){ // เซฟเฉพาะถ้าไม่ใช่ 4 เพราะถ้ามีแล็บไหนไม่รับเรื่อง ทำให้สถานะเป็น 4 แล้ว จะปฏิเสธการเซฟสถานะจากแล็บอื่นทั้งหมด
                $data->status = $request->get('status');
                $data->save();
            }
        }


        // $id_map = SaveExampleMaplap::query()->where('no_example_id', $request->get('no_example_id'))->first();
        // $data_map = SaveExampleMaplap::find($id_map->id);
        $data_maps = SaveExampleMaplap::query()->where('no_example_id', $request->get('no_example_id'))->get();

        if($request->get('status') == '4'){

            $status_send = 'ปฏิเสธ';
            // start แบบ all
            $query_next = SaveExampleMaplap::query()->where('example_id', $data_maps[0]->example_id)
                                            ->where('status_send', 'รอ')
                                            ->first();

            if($query_next != null){
                $next = SaveExampleMaplap::query()->where('no_example_id', $query_next->no_example_id )->get();
                if($next != null){
                    foreach($next as $nexts){
                        $nexts->status = '1';
                        $nexts->status_send = 'ส่ง';
                        $nexts->save();
                    }

                    $SaveExample2 = SaveExample::find($request->get('example_id'));
                    if($data->type_send == 'all'){
                        $SaveExample2->status = '1';
                        $SaveExample2->save();
                    }
                }
            }
            // end แบบ all

            // start แบบ some ถ้ามีหน่วยไหนปฏิเสธ สั่่งยกเลิกหน่วยตรวจที่เหลือทั้งหมด
            $query_some = SaveExampleMaplap::query()->where('example_id', $data_maps[0]->example_id)
                                            ->where('type_send', 'some')
                                            ->where('no_example_id', '!=', $request->get('no_example_id'))
                                            ->get();
            if($query_some != null){
                foreach($query_some as $somes){
                    $somes->status = 'ยกเลิก';
                    $somes->save();
                }
            }
            // end แบบ some

        }else{
            $status_send = $data_maps[0]->status_send;
        }

        $i = 0;
        foreach($data_maps as $data_map){

            $number_labget = $request->number_labget[$i];

            if($data_map->status == 'ยกเลิก'){
                $data_map->status = 'ยกเลิก';
            }else{
                $data_map->status = $request->get('status');
            }
            $data_map->remark = $request->get('remark_map');
            $data_map->tel_lab = $request->get('tel_lab');
            $data_map->email_lab = $request->get('email_lab');
            $data_map->number_labget = $number_labget;
            $data_map->status_send = $status_send;
            $data_map->user_lab = $request->get('user_lab');

            if($data_map->save()){
                if ($request->type_detail != null) {

                    $maplapdetail = SaveExampleMapLapDetail::query()->where('maplap_id', $data_map->id)
                    ->where('example_id', $data_map->example_id)
                    ->get();
                    for( $j = 0; $j < count($request->input('type_detail')[$i]); $j++ )
                    {
                            $maplapdetail[$j]->lab_input = $request->input('type_detail')[$i][$j];
                            $maplapdetail[$j]->save();
                    }
                }

                if ($request->file != null) {

                    if($request->hasfile('file.'.$i))
                    {
                        $file = $request->file('file.'.$i);
                            $name = $request->get('no_example_id').'_'.$file->getClientOriginalName();
                            $file->move('uploads/'.$this->attach_path, $name);

                            $old_file = SaveExampleFile::query()->where('example_id', $data_map->no_example_id)
                                                                ->where('example_id_no', $data_map->id)
                                                                ->first();
                            if($old_file){
                                $data_file = SaveExampleFile::find($old_file->id);
                            }else{
                                $data_file = new SaveExampleFile();
                            }

                            $data_file->file = $name;
                            $data_file->example_id = $data_map->no_example_id;
                            $data_file->example_id_no = $data_map->id;
                            $data_file->save();
                    }
                }
            }

            $i++;
        }

        // if ($request->file != null) {

        //     if($request->hasfile('file'))
        //     {
        //         $j = 0;

        //         foreach($request->file('file') as $file)
        //         {
        //             $name = $request->get('no_example_id').'_'.$file->getClientOriginalName();
        //             $file->move('uploads/'.$this->attach_path, $name);

        //             $old_file = SaveExampleFile::query()->where('example_id', $request->get('no_example_id'))
        //                                                 ->where('example_id_no', $request->example_id_no[$j])
        //                                                 ->first();
        //             if($old_file){
        //                 $data_file = SaveExampleFile::find($old_file->id);
        //             }else{
        //                 $data_file = new SaveExampleFile();
        //             }

        //             $data_file->file = $name;
        //             $data_file->example_id = $request->get('no_example_id');
        //             $data_file->example_id_no = $request->example_id_no[$j];
        //             $data_file->save();

        //             $j++;
        //         }
        //     }


        // }

        return response()->json([
            "status" => "success"
        ]);
    }

    public function detail($ID){
        $id_map = SaveExampleMaplap::query()->where('no_example_id', $ID)->first();
        $data = SaveExample::find($id_map->example_id);
        $data_detail = SaveExampleDetail::query()->where('id_example', $id_map->example_id)->get();
        $data_res = ResultProduct::query()->where('tis_standard', $data->tis_standard)->pluck('id');
        $data_res_check = ResultProduct::query()->where('tis_standard', $data->tis_standard)->first();
        if ($data_res_check != null) {
            $data_res_detail = ResultProductDetail::query()->where('id_result', $data_res)->get();
        } else {
            $data_res_detail = null;
        }

        $data_res_detail_id = SaveExampleDetail::query()->where('id_example', $id_map->example_id)->pluck('id');
        $data_save_check = SaveExampleTypeDetail::query()->whereIn('example_detail_id', $data_res_detail_id)->where('no_example_id', $ID)->first();
        $data_save_type = SaveExampleTypeDetail::query()->whereIn('example_detail_id', $data_res_detail_id)->where('no_example_id', $ID)->get();
        $full_name = auth()->user()->reg_fname . ' ' . auth()->user()->reg_lname;

        if ($data_save_check == null) {
            $data_save_type = null;
        }
        $dis = (explode('-', $ID));
        $data_file = SaveExampleFile::query()->where('example_id', $ID)->get();
        $data_file_check = SaveExampleFile::query()->where('example_id', $ID)->first();
        $data_map =SaveExampleMaplap::query()->where('example_id', $id_map->example_id)->where('detail_product_maplap','!=',null)->where('no_example_id', $ID)->get();
        $temp_res_detail = ResultProduct::query()->where('tis_standard', $data->tis_standard)->first();
        return view('resurv.report_product.detail', [
            'data_map' => $id_map,
            'data' => $data,
            'data_detail' => $data_detail,
            'data_map_table'=>$data_map,
            'data_res_detail' => $data_res_detail,
            'data_save_type' => $data_save_type,
            'full_name' => $full_name,
            'main_res_id' => $temp_res_detail,
            'dis0' => $dis[0], 'dis1' => $dis[1],
            'dis2' => $dis[2],
            'data_file' => $data_file,
            'data_file_check' => $data_file_check]);
    }

    public function download_file($NAME){
        // $public = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
        // return response()->download($public . $this->attach_path.$NAME);
        $public = public_path();
        $attach_path = $this->attach_path;
       if(HP::checkFileStorage($attach_path. $NAME)){
           HP::getFileStorage($attach_path. $NAME);
           $filePath =  response()->download($public.'/uploads/'.$attach_path.$NAME);
            return $filePath;
       }else{
          return 'ไม่พบไฟล์';
       }
    }

}
