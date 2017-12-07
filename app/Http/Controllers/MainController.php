<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

use Illuminate\Contracts\Mail\Mailer;
use App\Http\Requests;
use App\Models\Page;
use \App\Models\Good;
use \App\Models\Banner;
use Validator;
use Carbon\Carbon;
use DB;
use Mail;

class MainController extends Controller
{
    /**
     * Главная страница
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        //кол-во товаров на сайте
        $cnt_goods = Good::count();
        //банер в тексте
        $banner_content = \App\Models\Banner::where('type', 'content')->where('status', 1)->first();
        $banner_left = \App\Models\Banner::where('type', 'left')->where('status', 1)->get();
        //бренды
        $brands = \App\Models\Brand::where('status', 1)->get();
        //статьи

        //товары - выбор покупателей
//        $hit_goods = Good::where('hit', 1)->where('status', 1)->orderBy('id', 'desc')->take(10)->get();

        //самый покупаемый товар за последнюю неделю
        $order_good = DB::table('order_good as og')
            ->select('*', DB::raw('COUNT(*) as total_good'))
            ->join('goods as g', 'og.good_id', '=', 'g.id')
            ->where('og.created_at', '>=', Carbon::now()->subWeek())
            ->whereNull('g.deleted_at')
            ->where('g.status', 1)
            ->groupBy('good_id')->orderBy('total_good', 'desc')->first();
        if($order_good) {
            $good_week = Good::find($order_good->id);
        }

        //банеры в слайдере
        $banners = \App\Models\Banner::where('type', 'main')->where('status', 1)->get();

        // Товары
        $hit_goods = Good::with('attributes')->published()->hit()->recentlyAdded()->take(10)->get();
        $new_goods = Good::with('attributes')->published()->new()->recentlyAdded()->take(10)->get();
        $act_goods = Good::with('attributes')->published()->act()->recentlyAdded()->take(10)->get();

        //родительские категории
        $categories = \App\Models\Category::with(['categories', 'goods'])->where('id_parent', 0)->where('status', 1)->orderBy('sort')->get();

        $news = \App\Models\News::where('status', 1)->orderBy('created_at', 'desc')->take(4)->get();

        $this->setMetaTags();
        return view('content.index', [
            'banner_content' => $banner_content,
            'banner_left' => $banner_left,
            'cnt_goods' => $cnt_goods,

            'banners' => $banners,

            'hit_goods' => $hit_goods,
            'new_goods' => $new_goods,
            'act_goods' => $act_goods,

            'categories' => $categories,

            'news' => $news,

            'brands' => $brands,
            'good_week' => !empty($good_week) ? $good_week : null
        ]);
    }

    /**
     * Статичная html - страница
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function content(Request $request) {
        $sysname = substr($request->path(), 0, (strpos($request->path(), '.') ?: 1000));
        $page = Page::where('sysname', $sysname)->with('vars')->firstOrFail();
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        $this->setMetaTags();

        return view('content.content', ['page' => $page, 'banner_left' => $banner_left]);
    }

    /**
     * Страница сертификатов
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sertificates() {
        $sertificates = \App\Models\Sertificate::orderBy('id','desc')->get();
        $page = Page::where('sysname', 'sertificates')->with('vars')->firstOrFail();
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        $this->setMetaTags();

        return view('content.sertificates', ['page' => $page, 'sertificates' => $sertificates, 'banner_left' => $banner_left]);
    }

    /**
     * Страница Доставки и оплаты
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delivery() {
        $page = Page::where('sysname', 'delivery')->with('vars')->firstOrFail();
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        $this->setMetaTags();
        return view('content.content', ['page' => $page, 'banner_left' => $banner_left]);
    }

    /**
     * Страница Гарантия и возврат
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function warranty() {
        $page = Page::where('sysname', 'warranty')->with('vars')->firstOrFail();
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        $this->setMetaTags();
        return view('content.content', ['page' => $page, 'banner_left' => $banner_left]);
    }

    /**
     * Страница Самовывоз
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pickup() {
        $page = Page::where('sysname', 'pickup')->with('vars')->firstOrFail();
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        $this->setMetaTags();
        return view('content.content', ['page' => $page, 'banner_left' => $banner_left]);
    }

    /**
     * Страница контактов
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contacts() {
        $page = Page::where('sysname', 'contacts')->with('vars')->firstOrFail();
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        $this->setMetaTags();
        return view('content.contacts', ['page' => $page, 'banner_left' => $banner_left]);
    }

    /**
     * Страница Полезно знать
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articles() {
        $articles = \App\Models\Article::where('status', 1)->orderBy('date', 'desc')->paginate(10);
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        $this->setMetaTags();
        return view('articles.index', ['articles' => $articles, 'banner_left' => $banner_left]);
    }

    /**
     * Страница Статьи
     * @param $sysname
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function article($sysname) {
        $article = \App\Models\Article::where('sysname', $sysname)->where('status', 1)->firstOrFail();
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        $this->setMetaTags(null, $article->title, $article->description, $article->keywords);

        //товары по теме, исходя из тэгов статьи
        if($article->tags()->count()) {
            // REALLY NEED THIS?????????????????????
            //$goods = \App\Models\Good::whereHas('tags', function ($query) use ($article) {
            //    $query->whereIn('tag_id', [$article->tags->implode('id', ', ')]);
            //})->where('status', 1)->orderBy('id', 'desc')->take(100)->get();
            $relatedArticles = \App\Models\Article::whereHas('tags', function($query) use ($article) {
                $query->whereIn('tag_id', [$article->tags->implode('id', ', ')]);
            })
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->take(25)
                ->paginate(3);
        }

        return view('articles.inner', [
            'article'         => $article,
            'relatedArticles' => isset($relatedArticles) ? $relatedArticles : null,
            'banner_left' => $banner_left,
            //'goods' => !empty($goods) ? $goods : null
        ]);
    }

    /**
     * Метод подписки на рассылку
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(Request $request) {
        $validator = Validator::make($request->input(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'При оформлении подписки произошла ошибка. Попробуйте снова.']);
        }
        $subscribe = \App\Models\Subscriber::firstOrCreate(['email' => $request->input('email')]);
        if($request->has('act') && $request->input('act') && !$subscribe->act) {
            $subscribe->update(['act' => 1]);
        }

        return response()->json(['result' => 'ok']);
    }

    /**
     * Отправка письма администратору
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function letter(Request $request) {
        $validator = Validator::make($request->input(), [
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
            'text' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'При отправке письма произошла ошибка. Попробуйте снова.']);
        }

        Mail::send('emails.support.question',
                ['name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'text' => $request->input('text'),
                'email' => $request->input('email')], function ($message) use ($request){
                $message->from($request->input('email'), $request->input('name'));
                $message->to(\App\Models\Setting::getVar('email_support'))->subject('Вопрос с сайта '.$request->root());
            });

        return response()->json(['result' => 'ok']);
    }

    /**
     * Заказ обратного звонка
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(Request $request) {
        $validator = Validator::make($request->input(), [
            'phone' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'При запросе произошла ошибка. Попробуйте снова. from controller']);
            //return redirect()->back()->withErrors($validator);
        }

        Mail::send('emails.support.callback',
               ['name' => $request->input('name'),
                'phone' => $request->input('phone')], function ($message) use ($request){
                $message->to(\App\Models\Setting::getVar('email_support'))->subject('Запрос обратного звонка '.$request->root());
            });

        return response()->json(['result' => 'ok']);
        //return redirect()->back()->withMessage('Ваша заявка оформлена, пожалуйста дождитесь пока наш менеджер свяжется с Вами!');
    }

    /**
     * Отзывы
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reviews(Request $request) {
        $reviews = \App\Models\Review::published()->recent()->paginate(10);
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();

        return view('reviews.list', compact('reviews'));
    }

    /**
     * Листинг новостей
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function news(Request $request) {
        $news = News::published()->recent()->paginate(14);
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        return view('news.index', ['news' => $news, 'banner_left' => $banner_left]);
    }

    /**
     * Новость
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newsSingle(Request $request, $sysname) {
        $newsRecord = News::published()->bySysname($sysname)->first();
        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        if(!$newsRecord) abort(404);
        $newsCount = News::published()->count();
        return view('news.details', compact('newsRecord', 'newsCount', 'banner_left'));
    }
}
