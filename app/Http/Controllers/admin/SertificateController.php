<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Sertificate;

class SertificateController extends Controller
{
    public function __construct() {
        $this->authorize('index', new Sertificate());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sertificates = Sertificate::orderBy('id','desc')->get();
        return view('admin.sertificates.index', ['sertificates' => $sertificates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sertificates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\admin\SertificateRequest $request)
    {
        $filename = Sertificate::saveImg($request);
        Sertificate::create(['img' => $filename]);
        return redirect()->route('admin.sertificates.index')->withMessage('Сертификат добавлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sertificate = Sertificate::find($id);
        $sertificate->deleteImg();
        $sertificate->delete();
        return redirect()->route('admin.sertificates.index')->withMessage('Сертификат удален');
    }
}
