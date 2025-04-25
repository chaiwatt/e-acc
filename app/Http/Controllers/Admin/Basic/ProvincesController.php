<?php

namespace App\Http\Controllers\Admin\Basic;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Basic\Province;
use Illuminate\Http\Request;

class ProvincesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('provinces','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $keyword = $request->get('search');
            $perPage = 20;

            if (!empty($keyword)) {
                $provinces = Province::where('title', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->orWhere('updated_by', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $provinces = Province::sortable()->paginate($perPage);
            }

            return view('admin/basic.provinces.index', compact('provinces'));
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
        $model = str_slug('provinces','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            return view('admin/basic.provinces.create');
        }
        abort(403);

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
        $model = str_slug('provinces','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {

            $requestData = $request->all();

            Province::create($requestData);
            return redirect('admin/basic/provinces')->with('flash_message', 'province added!');
        }
        abort(403);
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
        $model = str_slug('provinces','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $province = Province::findOrFail($id);
            return view('admin/basic.provinces.show', compact('province'));
        }
        abort(403);
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
        $model = str_slug('provinces','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $province = Province::findOrFail($id);
            return view('admin/basic.provinces.edit', compact('province'));
        }
        abort(403);
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
        $model = str_slug('provinces','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {

            $requestData = $request->all();

            $province = Province::findOrFail($id);
             $province->update($requestData);

             return redirect('admin/basic/provinces')->with('flash_message', 'province updated!');
        }
        abort(403);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $model = str_slug('provinces','-');
        if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            Province::destroy($id);

            return redirect('admin/basic/provinces')->with('flash_message', 'province deleted!');
        }
        abort(403);

    }
}
