<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Good;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Setting;
use Validator;
use DB;
use Lang;

class CatalogController extends Controller
{
    /**
     * Кол-во товаров на первом скрине, на страницах с фильтрацией
     * @var int
     */
    private $perpage = 1;

    public function catalogRoot() {
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        $categories = Category::with([
            'goods' => function($query) {
                $query->where('status', 1);
            },
            'categories'
        ])
            ->where('status', 1)
            ->where('id_parent', 0)
            ->orderBy('sort', 'desc')
            ->get();

        $count = 0;
        foreach($categories as $cat) $count += $cat->goodsCount;

        return view('catalog.categories', [
            'category'       => 'root',
            'categories'     => $categories,
            'products_count' => $count,
            'banner_left'    => $banner_left,           
        ]);
    }

    /**
     * Страница каталога - товары из каталога | категории из каталога
     * @param $sysname
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function catalog($sysname) {
        $category = Category::with(['goods.attributes' => function($query) {
            $query->where('attributes.is_filter', 1);
        }])->where('sysname', $sysname)
            ->where('status', 1)
            ->firstOrFail();
        $this->setMetaTags(null, $category->title, $category->description, $category->keywords);

        // Если категория родительская, то выводим листинг подкатегорий
        if($category->hasChildren) {
            $categories = Category::where('id_parent', $category->id)->where('status', 1)->with('goods')->get();
            $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
            return view('catalog.categories', ['category' => $category, 'categories' => $categories, 'banner_left' => $banner_left]);
        } else {
            $banners = Banner::where('type', 'content')->where('status', 1)->get();
            $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
            $goods = $category->goods()->where('status', 1)->orderBy('updated_at', 'desc')->paginate(Setting::getVar('perpage') ?: $this->perpage);
            $goods->min_price = $category->goods->where('status', '1')->min('price');
            $goods->max_price = $category->goods->where('status', '1')->max('price');
            return view('catalog.catalog', [
                'category' => $category,
                'goods'    => $goods,
                'banners'  => $banners,
                'banner_left'  => $banner_left,
            ]);
        }
    }

    /**
     * Страница тэгов - товары с этим тегом
     * @param $sysname
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tags($sysname) {
        $tag = Tag::where('sysname', $sysname)->where('status', 1)->firstOrFail();
        $goods = $tag->goods()->where('status', 1)->paginate(Setting::getVar('perpage') ?: $this->perpage);
        $goods->min_price = $tag->goods->where('status', 1)->min('price');
        $goods->max_price = $tag->goods->where('status', 1)->max('price');
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();

        $this->setMetaTags(null, $tag->title, $tag->description, $tag->keywords);
        return view('catalog.tag', ['tag' => $tag, 'goods' => $goods, 'banner_left' => $banner_left]);
    }

    /**
     * Страница бренда - товары этого бренда
     * @param $sysname
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brands($sysname) {
        $brand = Brand::where('sysname', $sysname)->where('status', 1)->firstOrFail();
        $goods = Good::where('brand_id', $brand->id)->where('status', 1)->orderBy('name')->paginate(Setting::getVar('perpage') ?: $this->perpage);
        $goods->min_price = Good::where('brand_id', $brand->id)->where('status', 1)->min('price');
        $goods->max_price = Good::where('brand_id', $brand->id)->where('status', 1)->max('price');
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();

        $this->setMetaTags(null, $brand->title, $brand->description, $brand->keywords);
        return view('catalog.brand', ['brand' => $brand, 'goods' => $goods, 'banner_left' => $banner_left]);
    }

    /**
     * Страница акции - товары с ярлыком "Акция"
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actions() {
        $goods = Good::where('act', 1)->where('status', 1)->orderBy('name')->paginate(Setting::getVar('perpage') ?: $this->perpage);
        $goods->min_price = Good::where('act', 1)->where('status', 1)->min('price');
        $goods->max_price = Good::where('act', 1)->where('status', 1)->max('price');
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();

        $this->setMetaTags();
        return view('catalog.actions', ['goods' => $goods, 'banner_left' => $banner_left]);
    }

    /**
     * Страница новинки - товары с ярлыком "Новинка"
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newGoods() {
        $goods = Good::where('new', 1)->where('status', 1)->orderBy('name')->paginate(Setting::getVar('perpage') ?: $this->perpage);
        $goods->min_price = Good::where('new', 1)->where('status', 1)->min('price');
        $goods->max_price = Good::where('new', 1)->where('status', 1)->max('price');
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();

        $this->setMetaTags();
        return view('catalog.new', ['goods' => $goods, 'banner_left' => $banner_left]);
    }

    /**
     * Страница выбор покупателей - товары с ярлыком "Хит"
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hits() {
        $goods = Good::where('hit', 1)->where('status', 1)->orderBy('name')->paginate(Setting::getVar('perpage') ?: $this->perpage);
        $goods->min_price = Good::where('hit', 1)->where('status', 1)->min('price');
        $goods->max_price = Good::where('hit', 1)->where('status', 1)->max('price');
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();

        $this->setMetaTags();
        return view('catalog.hits', ['goods' => $goods, 'banner_left' => $banner_left]);
    }

    /**
     * Результаты поиска
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request) {
        //TODO: переделать на полнотекстовой через эластиксеарч
        if($request->has('text') && $request->input('text') !='') {
            $goods = Good::where('name','LIKE' , '%'.$request->input('text').'%')->where('status', 1)->orderBy('name')->paginate();
        }

        if($request->isXmlHttpRequest()) {
            $nextPage = ($goods->currentPage() == $goods->lastPage()) ? false : $goods->currentPage() + 1;
            return response()->json([
                'html' => view('catalog.products.goods_res', [
                    'products' => $goods,
                ])->render(),
                'nextPage' => $nextPage
            ]);
        } else {
            $this->setMetaTags();
            return view('catalog.search', [
                'goods' => !empty($goods) ? $goods : null,
                'text' => $request->input('text'),
            ]);
        }
    }

    public function goodssearch(Request $request)
    {
        $term=$request->term;
        $goods = Good::where('name','LIKE' , '%'.$term.'%')->where('status', 1)->orderBy('name')->take(10)->get();
        $data = $goods;
        $item=array();
        foreach ($data as $key => $v){
            $item[]=['img' =>'/assets/imgs/goods/main/'.$v->img,'name' =>$v->name, 'price' =>$v->price.' руб.', 'url' =>'/good/'.$v->sysname.'.html' ];
        }
        return response()->json($item);
    }

    /**
     * AJAX - подгрузка товаров
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function getGoods(Request $request) {
        //фильтр категории - получаем связанные товары из категории
        if($request->has('category_id') && $request->input('category_id')) {
            $goods = Category::findOrFail($request->input('category_id'))
                ->goodsWithoutSort()
                ->where('status', 1)
                ->with('attributes');
        //фильтр по тегу - получаем связанные товары с тэгом
        }else if($request->has('tag_id') && $request->input('tag_id')) {
            $goods = Tag::findOrFail($request->input('tag_id'))
                ->goodsWithoutSort()
                ->where('status', 1)
                ->with('attributes');
        //по умолчанию просто фильтруем товары
        } else {
            $goods = Good::with('attributes')->where('status', 1);
        }
        //фильтр по бренду
        if($request->has('brand_id') && $request->input('brand_id')) {
            $goods->where('brand_id', intval($request->input('brand_id')));
        }
        //фильтр по акции
        if($request->has('act') && $request->input('act')) {
            $goods->where('act', 1);
        }
        //фильтр по Новинкам
        if($request->has('new') && $request->input('new')) {
            $goods->where('new', 1);
        }
        //фильтр по Хитам
        if($request->has('hit') && $request->input('hit')) {
            $goods->where('hit', 1);
        }
        //фильтр по ценам от - до
        if($request->has('price_from') && $request->input('price_from')) {
            $goods->where('price', '>=', intval($request->input('price_from')));
        }
        if($request->has('price_to') && $request->input('price_to')) {
            $goods->where('price', '<=', intval($request->input('price_to')));
        }
        //фильтры по атрибутам
        if ($request->has('attribute')) {
            foreach($request->input('attribute') as $attribute_id => $value) {
                if($value) {
                    $goods->whereHas('attributes', function ($query) use ($value, $attribute_id) {
                        $query->where('attribute_id', $attribute_id)->where('value', $value);
                    });
                }
            }
        }

        //сортировка - дороже
        if($request->has('sort') && $request->input('sort') == 'expensive') {
            $goods->orderBy('price', 'desc');
        //сортировка - дешевле
        } elseif($request->has('sort') && $request->input('sort') == 'cheaper') {
            $goods->orderBy('price');
        //сортировка - хиты продаж
        } elseif($request->has('sort') && $request->input('sort') == 'hit') {
            $goods->orderBy('hit', 'desc')->orderBy('name');
        //сортировка - акции
        } elseif($request->has('sort') && $request->input('sort') == 'act') {
            $goods->orderBy('act', 'desc')->orderBy('name');
        //сортировка - имя
        } elseif($request->has('sort') && $request->input('sort') == 'name') {
            $goods->orderBy('name');
        //сортировка - внутри категории по полю Сортировка
        } elseif($request->has('sort') && $request->input('sort') == 'good_category.sort') {
            $goods->orderBy('good_category.sort');
        //сортировка - внутри тэга по полю Сортировка
        } elseif($request->has('sort') && $request->input('sort') == 'good_tag.sort') {
            $goods->orderBy('good_tag.sort');
        //сортировка - по умолчанию, по имени
        } else {
            $goods->orderBy('name');
        }
        $goods = $goods->paginate(Setting::getVar('perpage') ?: $this->perpage, ['*'], 'page', $request->has('page') ? intval($request->input('page')) : null);

        $response['result'] = 'ok';
        //если запросили 1 страницу, то перед выводом отчищаем предыдущие результаты
        if($request->has('page') && $request->input('page') == 1) {
            $response['clear'] = true;
        }

        $response['goods'] = $goods; // TODO: REALLY NEED THIS????
        $response['next_page'] = ($goods->lastPage() > $goods->currentPage() ? ($goods->currentPage() + 1) : null);
        $response['view'] = view('catalog.products.goods_res', ['products' => $goods])->render();
        $response['count'] = '<span>'.$goods->total().'</span> '.
            \App\Helpers\inflectByCount($goods->total(), ['one' => 'товар', 'many' => 'товара', 'others' => 'товаров']);

        return response()->json($response);
    }

    /**
     * Страница отложенных товаров
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bookmarks() {
        if(session()->has('goods.defer') && $defers = session()->get('goods.defer')) {
            //выводим последние 48 товара
            arsort($defers);
            $defers = array_slice(array_keys($defers), 0, 48);
            $goods = Good::whereIn('id', $defers)->where('status', 1)->orderByRaw('FIELD(id, '.implode(',', $defers).')')->take(48)->get();
        }
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        $this->setMetaTags();
        return view('catalog.bookmarks', ['goods' => !empty($goods) ? $goods : null, 'banner_left' => $banner_left]);
    }

    /**
     * Страница просмотренных товаров
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function views() {

        if(session()->has('goods.view')) {
            //выводим последние 48 товара
            $views = session()->get('goods.view');
            arsort($views);
            $views = array_slice(array_keys($views), 0, 48);
            $goods = Good::whereIn('id', $views)->where('status', 1)->orderByRaw('FIELD(id, '.implode(',', $views).')')->take(48)->get();
        }
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        $this->setMetaTags();
        return view('catalog.views', ['goods' => !empty($goods) ? $goods : null, 'banner_left' => $banner_left]);
    }


    /**
     * Карточка товара
     * @param $sysname
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function good($sysname) {
        $good = Good::with([
            'comments' => function($query) {
                $query->where('status', 1);
            },
            'photos',
            'categories',
            'attributes',
            'buyalso' => function($query) {
                $query->with('attributes');
            }
        ])->where('sysname', $sysname)->where('status', 1)->firstOrFail();
        $this->setMetaTags(null, $good->title, $good->description, $good->keywords);
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();

        //добавляем товар в просмотренные
        if(!session()->has('goods.view.'.$good->id)) {
            session()->put('goods.view.' . $good->id, 1);
        }
        //аналоги
        $analogues = Good::where('id', '!=', $good->id)->whereHas('categories', function ($query) use ($good) {
            $query->whereIn('category_id', $good->categories->pluck('id')->toArray());
        })->inRandomOrder()->take(10)->get();

        return view('catalog.products.details', [
            'good' => $good,
            'analogues' => $analogues,
            'banner_left' => $banner_left
        ]);
    }


    /**
     * Метод отложить товар
     * @param $id
     */
    public function defer($id) {
        if(session()->has('goods.defer.'.$id)) {
            session()->forget('goods.defer.'.$id);
        } else {
            session()->put('goods.defer.'.$id, 1);
        }

        $defer = session()->get('goods.defer');
        return count($defer);
    }

    /**
     * Положить товар в корзину
     * @param $id
     * @param int $cnt
     * @return \Illuminate\Http\JsonResponse
     */
    public function cart($id, $cnt = 1) {
        $response = [];

        if(session()->has('goods.cart.'.$id)) {
            session()->put('goods.cart.'.$id.'.cnt', session()->get('goods.cart.'.$id.'.cnt') + $cnt);
        } else {
            $good = Good::where('id', $id)->where('status', 1)->first();
            session()->put('goods.cart.'.$id, ['cnt' => $cnt, 'price' => $good->price]);
            //рендерим элемент корзины
            $response['element'] = view('blocks.header.cart_item', ['good' => $good, 'cnt' => $cnt])->render();
        }
        $cart = session()->get('goods.cart');
        $response['amount'] = 0;
        foreach($cart as $key => $item) {
            $response['amount'] += $item['price']*$cart[$key]['cnt'];
        }
        $response['id'] = $id;
        $response['count'] = count($cart);
        $response['unit_count'] = $cart[$id]['cnt'];
        $response['count_name'] = Lang::choice('товар|товара|товаров', count($cart), [], 'ru');
        return response()->json($response);
    }
    /**
     * Убрать товар из корзины
     * @param $id - id товара
     */
    public function removeFromCart($id) {
        $response = [];
        session()->forget('goods.cart.'.$id);
        $cart = session()->get('goods.cart');
        $response['amount'] = 0;
        foreach($cart as $key => $item) {
            $response['amount'] += $item['price']*$cart[$key]['cnt'];
        }
        if(count($cart) == 0) {
            session()->forget('goods.cart');
        }
        $response['count'] = count($cart);
        $response['removed'] = $id;
        $response['count_name'] = Lang::choice('товар|товара|товаров', count($cart), [], 'ru');
        return response()->json($response);
    }

    public function cartdelete($id) {
        $response = [];
        session()->forget('goods.cart.'.$id);
        $cart = session()->get('goods.cart');
        $response['amount'] = 0;
        foreach($cart as $key => $item) {
            $response['amount'] += $item['price']*$cart[$key]['cnt'];
        }
        if(count($cart) == 0) {
            session()->forget('goods.cart');
        }
        $response['count'] = count($cart);
        $response['removed'] = $id;
        $response['count_name'] = Lang::choice('товар|товара|товаров', count($cart), [], 'ru');
        return response()->json($response);
    }

    /**
     * Добавление коментария к товару
     * @param $id
     * @param Request $request
     * @return string|\Illuminate\Http\JsonResponse
     */
    public function comment($id, Request $request) {
        $data = $request->input();
        $data['good_id'] = $id;
        $data['date'] = date('Y-m-d');
        //Статус - На модерации
        $data['status'] = 0;
        $data['text'] = $data['message'];
        $validatorOptions = $data['good_id'] == 0 ?
            [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
            ] : [
                'good_id' => 'required|exists:goods,id',
                'date' => 'required|date',
                'name' => 'required',
                'email' => 'required|email',
                'text' => 'required',
            ];
        $validator = Validator::make($data, $validatorOptions);

        if ($validator->fails()) {
            return response()->json(['message' => 'При добавлении комментария произошла ошибка. Попробуйте снова.']);
        }

        if($data['good_id'] == 0)
            \App\Models\Review::create($data);
        else
            \App\Models\GoodComment::create($data);

        return response()->json(['result' => 'ok']);
    }

}
