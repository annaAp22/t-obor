<?php

namespace App\Http\Controllers\admin;

use App\Models\GoodComment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Good;
use App\Models\GoodPhoto;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Attribute;
use Validator;

class GoodController extends Controller
{
    public function __construct() {
        $this->authorize('index', new Good());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFormFilter($request->input());

        $goods = Good::orderBy('id', 'desc');
        if (!empty($filters) && !empty($filters['name'])) {
            $goods->where('name', 'LIKE', '%'.$filters['name'].'%');
        }
        if (!empty($filters) && !empty($filters['sysname'])) {
            $goods->where('sysname', 'LIKE', '%'.$filters['sysname'].'%');
        }
        if (!empty($filters) && !empty($filters['id_category'])) {
            $goods->whereHas('categories', function ($query) use ($filters) {
                $query->where('category_id', $filters['id_category']);
            });
        }
        if (!empty($filters) && !empty($filters['brand_id'])) {
            $goods->where('brand_id', $filters['brand_id']);
        }
        if (!empty($filters) && !empty($filters['tag'])) {
            $goods->whereHas('tags', function ($query) use ($filters) {
                $query->where('tag_id', $filters['tag']);
            });
        }
        if (!empty($filters) && !empty($filters['attributes'])) {
            foreach($filters['attributes'] as $attribute_id => $value) {
                if($value) {
                    $goods->whereHas('attributes', function ($query) use ($value, $attribute_id) {
                        $query->where('attribute_id', $attribute_id)->where('value', $value);
                    });
                }
            }
        }


        if (!empty($filters) && isset($filters['status']) && $filters['status']!='') {
            $goods->where('status', $filters['status']);
        }
        if (!empty($filters) && isset($filters['deleted']) && $filters['deleted']) {
            $goods->withTrashed();
        }
        $goods = $goods->paginate($filters['perpage'], null, 'page', !empty($filters['page']) ? $filters['page'] : null);

        $categories = Category::where('id_parent', 0)->orderBy('sort')->get();
        $tags = Tag::orderBy('views', 'desc')->orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $attributes = Attribute::where('is_filter', 1)->orderBy('name')->get();

        return view('admin.goods.index', ['goods' => $goods, 'categories' => $categories, 'tags' => $tags,
                        'brands' => $brands, 'filters' => $filters, 'attributes' => $attributes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::orderBy('views', 'desc')->orderBy('name')->get();
        $categories = Category::where('id_parent', 0)->orderBy('sort')->get();
        $brands = Brand::orderBy('name')->get();
        $attributes = Attribute::orderBy('name')->get();

        $buyalso = [];
        if(old()) {
            if(old('buyalso') && !empty(old('buyalso'))) {
                $buyalso = Good::whereIn('id', old('buyalso'))->get();
            }
        }

        return view('admin.goods.create', ['categories' => $categories, 'tags' => $tags, 'brands' => $brands,
                                           'attributes' => $attributes, 'buyalso' => $buyalso]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\admin\GoodRequest $request)
    {
        $data = $request->all();
        $data['img'] = Good::saveImg($request);
        $data['brand_id'] = ($data['brand_id'] ?: null);
        $data['id_category'] = $request->has('categories') ? $request->input('categories')[0] : 1;
        $good = Good::create($data);

        //связь с категориями
        if($request->has('categories')) {
            foreach($request->input('categories') as $key => $id_category) {
                $good->categories()->attach($id_category);
            }
        }

        if($request->file('photos')) {
            foreach($request->file('photos') as $key => $photo) {
                $validator = Validator::make(['img' => $photo], GoodPhoto::$rules);
                if ($validator->passes()) {
                    if($photo = GoodPhoto::saveImg($photo)) {
                        $good->photos()->create(['img' => $photo]);
                    }
                }
            }
        }
        if($request->has('tags')) {
            foreach($request->input('tags') as $key => $id_tag) {
                $good->tags()->attach($id_tag);
            }
        }
        //связь с "покупают также"
        if($request->has('buyalso')) {
            $good->buyalso()->sync(array_diff($request->input('buyalso'), ['']));
        }
        //связь с атрибутами
        if($request->has('attributes.ids')) {
            foreach(array_unique($request->input('attributes.ids')) as $key => $id) {
                $data = ['id' => $id, 'value' => ($request->has('attributes.values.'.$key) ? $request->input('attributes.values.'.$key) : $request->input('attributes.value.'.$key))];
                $validator = Validator::make($data, ['id' => 'required|exists:attributes,id', 'value' => 'required']);
                if ($validator->passes()) {
                    $good->attributes()->attach($data['id'], ['value' => $data['value']]);
                }
            }
        }

        return redirect()->route('admin.goods.index')->withMessage('Товар добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $good = Good::findOrFail($id);
        $good->price_old = $good->priceOld();
        $categories = Category::where('id_parent', 0)->orderBy('sort')->get();
        $tags = Tag::orderBy('views', 'desc')->orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $attributes = Attribute::orderBy('name')->get();

        $buyalso = [];
        if(old()) {
            if(old('buyalso') && !empty(old('buyalso'))) {
                $buyalso = Good::whereIn('id', old('buyalso'))->get();
            }
        } else {
            $buyalso = $good->buyalso;
        }

        return view('admin.goods.edit', ['good' => $good, 'categories' => $categories, 'tags' => $tags,
                                    'brands' => $brands, 'buyalso' => $buyalso, 'attributes' => $attributes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\admin\GoodRequest $request, $id)
    {
        $good = Good::findOrFail($id);
        $data = $request->all();
        if($img = Good::saveImg($request)) {
            $data['img'] = $img;
            $good->deleteImg();
        }
        $data['brand_id'] = ($data['brand_id'] ?: null);
        $good->update($data);
        //связь с категориями
        $good->categories()->sync($request->input('categories'));


        //delete photos
        if($request->has('p_ids')) {
            foreach($data['p_ids'] as $key => $id_photo) {
                $photo = $good->photos()->find($id_photo);
                if(!empty($photo)) {
                    //delete
                    if (!empty($data['p_delete'][$key])) {
                        $photo->deleteImg();
                        $photo->delete();
                    }
                }
            }
        }
        //добавление изображений
        if($request->file('photos')) {
            foreach($request->file('photos') as $key => $photo) {
                $validator = Validator::make(['img' => $photo], GoodPhoto::$rules);
                if ($validator->passes()) {
                    if($photo = GoodPhoto::saveImg($photo)) {
                        $good->photos()->create(['img' => $photo]);
                    }
                }
            }
        }
        //связь с тегами
        if($request->has('tags')) {
            $good->tags()->sync($request->input('tags'));
        }elseif($good->tags()->count()) {
            foreach($good->tags as $tag) {
                $good->tags()->detach($tag->id);
            }
        }
        //связь с "покупают также"
        if($request->has('buyalso')) {
            $good->buyalso()->sync(array_diff($request->input('buyalso'), ['']));
        }elseif($good->buyalso()->count()) {
            foreach($good->buyalso as $good) {
                $good->buyalso()->detach($good->id);
            }
        }
        //связь с атрибутами
        if($request->has('attributes.ids')) {
            foreach(array_unique($request->input('attributes.ids')) as $key => $id) {
                $data = ['id' => $id, 'value' => ($request->has('attributes.values.'.$key) ? $request->input('attributes.values.'.$key) : $request->input('attributes.value.'.$key))];
                $validator = Validator::make($data, ['id' => 'required|exists:attributes,id', 'value' => 'required']);
                if ($validator->passes()) {
                    $attributes[$id] = ['value' => $data['value']];
                }
            }
            if(!empty($attributes)) {
                $good->attributes()->sync($attributes);
            }
        }
        return redirect()->route('admin.goods.index')->withMessage('Товар изменен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Good::destroy($id);
        return redirect()->route('admin.goods.index')->withMessage('Товар удален');
    }


    /**
     * Востановление мягко удаленного товара
     * @param $id
     * @return mixed
     */
    public function restore($id) {
        Good::withTrashed()->find($id)->restore();
        return redirect()->route('admin.goods.index')->withMessage('Товар востановлена');
    }

    /**
     * Поиск по товарам в автоподстановке
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request) {
        $data =[];
        if($request->has('search_param') && $request->input('search_param')) {
            $goods = Good::where('name', 'LIKE', $request->input('search_param') . '%')->orderBy('id', 'desc')->take(10)->get();
            foreach ($goods as $good) {
                $data[] = ['id' => $good->id, 'name' => $good->name];
            }
        }

        return response()->json($data);
    }

    /**
     * Сортировка товаров внутри категории
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sortCategory($id) {
        $category = Category::find($id);
        $goods = $category->goods()->get();
        return view('admin.goods.sort.category', ['category' => $category, 'goods' => $goods]);
    }

    /**
     * Сохранение сортировки внутри категории
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function sortCategorySave($id, Request $request) {
        $category = Category::find($id);

        //сохранение сортировки
        if($request->has('ids') && $request->has('ids.0')) {
            $data = [];
            foreach($request->input('ids.0') as $sort => $good_id) {
                $data[$good_id] = ['sort' => $sort];
            }
            $category->goods()->sync($data);
        }
        //сохранение наличия и цен
        if($request->has('prices')) {
            foreach($request->input('prices') as $id => $price) {
                Good::findOrFail($id)->update(['price' => $price, 'stock' => ($request->has('stocks.'.$id) ? 1 : 0)]);
            }
        }
        return redirect()->back()->withMessage('Сортировка сохранена');
    }

    /**
     * Сортировка товаров внутри тэга
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sortTag($id) {
        $tag = Tag::find($id);
        $goods = $tag->goods()->get();
        return view('admin.goods.sort.tag', ['tag' => $tag, 'goods' => $goods]);
    }

    /**
     * Сохранение сортировки внутри тэга
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function sortTagSave($id, Request $request) {
        $tag = Tag::find($id);
        if($request->has('ids') && $request->has('ids.0')) {
            $data = [];
            foreach($request->input('ids.0') as $sort => $good_id) {
                $data[$good_id] = ['sort' => $sort];
            }
            $tag->goods()->sync($data);
        }
        //сохранение наличия и цен
        if($request->has('prices')) {
            foreach($request->input('prices') as $id => $price) {
                Good::findOrFail($id)->update(['price' => $price, 'stock' => ($request->has('stocks.'.$id) ? 1 : 0)]);
            }
        }
        return redirect()->back()->withMessage('Сортировка сохранена');
    }



}
