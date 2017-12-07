<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Slug;

class CategoryController extends Controller
{
    public function __construct() {
        $this->authorize('index', new Category());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFormFilter($request->input());

        $categories = Category::orderBy('sort');
        if (!empty($filters) && !empty($filters['name'])) {
            $categories->where('name', 'LIKE', '%'.$filters['name'].'%');
        }
        if (!empty($filters) && !empty($filters['sysname'])) {
            $categories->where('sysname', 'LIKE', '%'.$filters['sysname'].'%');
        }
        if (!empty($filters) && !empty($filters['id_category'])) {
            $categories->where('id_parent', $filters['id_category']);
        }
        if (!empty($filters) && isset($filters['status']) && $filters['status']!='') {
            $categories->where('status', $filters['status']);
        }
        if (!empty($filters) && isset($filters['deleted']) && $filters['deleted']) {
            $categories->withTrashed();
        }
        $categories = $categories->paginate($filters['perpage'], null, 'page', !empty($filters['page']) ? $filters['page'] : null);

        $categories_filter = Category::where('id_parent', 0)->orderBy('sort')->get();

        return view('admin.categories.index', ['categories' => $categories, 'categories_filter' => $categories_filter, 'filters' => $filters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('id_parent', 0)->orderBy('sort')->get();
        return view('admin.categories.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\admin\CategoryRequest $request)
    {
        $data = $request->all();
        $data['icon'] = Category::saveIcon($request);
        $data['img'] = Category::saveImg($request);
        $data['img_main'] = Category::saveImgMain($request);
        //минимальная сортировка внутри категории родителя для нового элемента, чтобы он был в начале
        $data['sort'] = Category::where('id_parent',$data['id_parent'])->min('sort');
        $data['sort'] = (isset($data['sort']) ? $data['sort']-1 : 0) ;
        Category::create($data);
        return redirect()->route('admin.categories.index')->withMessage('Категория добавлена');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('id_parent', 0)->where('id', '!=', $id)->orderBy('sort')->get();
        return view('admin.categories.edit', ['category' => $category, 'categories' => $categories]);
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
        $category = Category::findOrFail($id);
        $data = $request->all();
        if($icon = Category::saveIcon($request)) {
            $data['icon'] = $icon;
            $category->deleteIcon();
        }
        if($img = Category::saveImg($request)) {
            $data['img'] = $img;
            $category->deleteImg();
        }
        if($img_main = Category::saveImgMain($request)) {
            $data['img_main'] = $img_main;
            $category->deleteImgMain();
        }
        $category->update($data);

        return redirect()->route('admin.categories.index')->withMessage('Категория изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('admin.categories.index')->withMessage('Категория удалена');
    }

    /**
     * Сортировка категорий
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function sort(Request $request) {
        $categories = Category::where('id_parent', 0)->orderBy('sort')->get();
        return view('admin.categories.sort', ['categories' => $categories]);
    }

    /**
     * Сохранение сортировки категорий
     * @param Request $request
     * @return mixed
     */
    public function sortSave(Request $request) {
        if($request->has('ids')) {
            foreach($request->input('ids') as $id_parent => $cats) {
                foreach($cats as $sort => $id) {
                    Category::find($id)->update(['id_parent' => $id_parent, 'sort' => $sort]);
                }
            }
        }
        return redirect()->route('admin.categories.sort')->withMessage('Сортировка сохранена');
    }

    /**
     * Востановление мягко удаленной категории
     * @param $id
     * @return mixed
     */
    public function restore($id) {
        Category::withTrashed()->find($id)->restore();
        return redirect()->route('admin.categories.index')->withMessage('Категория востановлена');
    }

}
