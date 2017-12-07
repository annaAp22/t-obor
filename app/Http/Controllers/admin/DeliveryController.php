<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Delivery;

class DeliveryController extends Controller
{
    public function __construct() {
        $this->authorize('index', new \App\Models\Order());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $deliveries = Delivery::orderBy('id', 'desc')->withTrashed()->paginate(10);

        return view('admin.deliveries.index', ['deliveries' => $deliveries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.deliveries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\admin\DeliveryRequest $request)
    {
        $data = $request->all();
        $data['img'] = Delivery::saveImg($request);
        Delivery::create($data);
        return redirect()->route('admin.deliveries.index')->withMessage('Способ доставки добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $delivery = Delivery::findOrFail($id);
        return view('admin.deliveries.edit', ['delivery' => $delivery]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\admin\DeliveryRequest $request, $id)
    {
        $delivery = Delivery::findOrFail($id);
        $data = $request->all();
        if($img = Delivery::saveImg($request)) {
            $data['img'] = $img;
            $delivery->deleteImg();
        }
        $delivery->update($data);
        return redirect()->back()->withMessage('Способ доставки изменен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Delivery::destroy($id);
        return redirect()->back()->withMessage('Способ доставки удален');
    }


    /**
     * Востановление мягко удаленной категории
     * @param $id
     * @return mixed
     */
    public function restore($id) {
        Delivery::withTrashed()->find($id)->restore();
        return redirect()->route('admin.deliveries.index')->withMessage('Способ доставки востановлен');
    }

}
