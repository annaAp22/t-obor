<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Slug;

class TagController extends Controller
{
    public function __construct() {
        $this->authorize('index', new Tag());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFormFilter($request->input());

        $tags = Tag::orderBy('views', 'desc')->orderBy('name');
        if (!empty($filters) && !empty($filters['name'])) {
            $tags->where('name', 'LIKE', '%'.$filters['name'].'%');
        }
        if (!empty($filters) && !empty($filters['sysname'])) {
            $tags->where('sysname', 'LIKE', '%'.$filters['sysname'].'%');
        }
        if (!empty($filters) && isset($filters['status']) && $filters['status']!='') {
            $tags->where('status', $filters['status']);
        }
        if (!empty($filters) && isset($filters['deleted']) && $filters['deleted']) {
            $tags->withTrashed();
        }
        $tags = $tags->paginate($filters['perpage'], null, 'page', !empty($filters['page']) ? $filters['page'] : null);

        return view('admin.tags.index', ['tags' => $tags, 'filters' => $filters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\admin\TagRequest $request)
    {
        Tag::create($request->all());
        return redirect()->route('admin.tags.index')->withMessage('Тег добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.tags.edit', ['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\admin\CategoryRequest $request, $id)
    {
        Tag::findOrFail($id)->update($request->all());
        return redirect()->route('admin.tags.index')->withMessage('Тег изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::destroy($id);
        return redirect()->route('admin.tags.index')->withMessage('Тег удалена');
    }

    /**
     * Востановление мягко удаленного тега
     * @param $id
     * @return mixed
     */
    public function restore($id) {
        Tag::withTrashed()->find($id)->restore();
        return redirect()->route('admin.tags.index')->withMessage('Тег востановлен');
    }

}
