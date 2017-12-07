<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandController extends Controller
{
    public function __construct() {
        $this->authorize('index', new Brand());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFormFilter($request->input());

        $brands = Brand::orderBy('id', 'desc');
        if (!empty($filters) && !empty($filters['name'])) {
            $brands->where('name', 'LIKE', '%'.$filters['name'].'%');
        }
        if (!empty($filters) && !empty($filters['sysname'])) {
            $brands->where('sysname', 'LIKE', '%'.$filters['sysname'].'%');
        }
        if (!empty($filters) && isset($filters['status']) && $filters['status']!='') {
            $brands->where('status', $filters['status']);
        }
        if (!empty($filters) && isset($filters['deleted']) && $filters['deleted']) {
            $brands->withTrashed();
        }
        $brands = $brands->paginate($filters['perpage'], null, 'page', !empty($filters['page']) ? $filters['page'] : null);

        return view('admin.brands.index', ['brands' => $brands, 'filters' => $filters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\admin\BrandRequest $request)
    {
        $data = $request->all();
        $data['img'] = Brand::saveImg($request);
        Brand::create($data);
        return redirect()->route('admin.brands.index')->withMessage('Бренд добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brend = Brand::findOrFail($id);
        return view('admin.brands.edit', ['brend' => $brend]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\admin\BrandRequest $request, $id)
    {
        $brend = Brand::findOrFail($id);
        $data = $request->all();
        if($img = Brand::saveImg($request)) {
            $data['img'] = $img;
            $brend->deleteImg();
        }
        $brend->update($data);
        return redirect()->route('admin.brands.index')->withMessage('Бренд изменен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Brand::destroy($id);
        return redirect()->route('admin.brands.index')->withMessage('Бренд удален');
    }


    /**
     * Востановление мягко удаленной категории
     * @param $id
     * @return mixed
     */
    public function restore($id) {
        Brand::withTrashed()->find($id)->restore();
        return redirect()->route('admin.brands.index')->withMessage('Бренд востановлен');
    }

}