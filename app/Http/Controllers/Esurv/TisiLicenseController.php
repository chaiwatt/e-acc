<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\InformVolume as inform_volume;
use App\Models\Esurv\InformVolumeLicense;
use App\Models\Esurv\InformVolumeLicenseDetail;
use App\Models\Basic\TisiLicenseDetail;
use App\Models\Basic\TisiLicense;
use App\Models\Basic\Tis;

use Illuminate\Http\Request;

use File;

class TisiLicenseController extends Controller
{
    private $attach_path;//ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');

        $this->attach_path = public_path().'/esurv_attach/inform_volume/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('licenses');
        if(auth()->user()->can('view-'.$model)) {

            $filter['filter_tis'] = $request->get('filter_tis');
            $filter['filter_licenseNo'] = $request->get('filter_licenseNo');
            $filter['filter_status'] = $request->get('filter_status', 'NULL');
            $perPage = 25;
            $tax_id = auth()->user()->trader_id;

            $status = array('0'=>'ยกเลิก', '1'=>'ใช้งาน', ''=>'ไม่ทราบ');
            $status_css = array('0'=>'label-danger', '1'=>'label-success', ''=>'label-default');

            $query = new TisiLicense;

            if (!empty($filter['filter_tis'])) {
              $query = $query->where('tbl_tisiNo', $filter['filter_tis']);
            }

            if(!empty($filter['filter_licenseNo'])){
              $query = $query->where('tbl_licenseNo', "LIKE", "%{$filter['filter_licenseNo']}%");
            }

            if($filter['filter_status']!='NULL'){
              $query = $query->where('tbl_licenseStatus', $filter['filter_status']);
            }

            $inform_volume = $query->where('tbl_taxpayer', $tax_id)
                                   ->sortable()
                                   ->with('tis')
                                   ->paginate($perPage);

            return view('esurv.tisi_license.index', compact('inform_volume', 'status', 'status_css', 'filter'));
        }

        abort(403);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id, Request $request)
    {

    }

}
