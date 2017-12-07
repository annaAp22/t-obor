<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
    public function __construct() {
        $this->authorize('index', new Banner());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFormFilter($request->input());

        $banners = Banner::orderBy('id', 'desc');

        if (!empty($filters) && isset($filters['type']) && $filters['type']!='') {
            $banners->where('type', $filters['type']);
        }
        if (!empty($filters) && isset($filters['status']) && $filters['status']!='') {
            $banners->where('status', $filters['status']);
        }
        if (!empty($filters) && isset($filters['deleted']) && $filters['deleted']) {
            $banners->withTrashed();
        }
        $banners = $banners->paginate($filters['perpage'], null, 'page', !empty($filters['page']) ? $filters['page'] : null);

        return view('admin.banners.index', ['banners' => $banners,'filters' => $filters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\admin\BannerRequest $request)
    {
        $data = $request->all();
        $data['img'] = Banner::saveImg($request, $request->input('type'));
        Banner::create($data);

        return redirect()->route('admin.banners.index')->withMessage('Банер добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', ['banner' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\admin\BannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $data = $request->all();
        if($img = Banner::saveImg($request, $request->input('type'))) {
            $data['img'] = $img;
            $banner->deleteImg();
        }
        $banner->update($data);
        return redirect()->route('admin.banners.index')->withMessage('Банер изменен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Banner::destroy($id);
        return redirect()->route('admin.banners.index')->withMessage('Банер удален');
    }


    /**
     * Востановление мягко удаленной
     * @param $id
     * @return mixed
     */
    public function restore($id) {
        Banner::withTrashed()->find($id)->restore();
        return redirect()->route('admin.banners.index')->withMessage('Банер востановлен');
    }

}
