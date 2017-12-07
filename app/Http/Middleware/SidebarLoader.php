<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Article;
use App\Models\News;
use App\Models\Banner;
use Illuminate\Support\Facades\View;

class SidebarLoader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sidebar_articles = Article::where('status', 1)
            ->orderBy('date', 'desc')
            ->take(3)
            ->get();
        View::share('sidebar_articles', $sidebar_articles);

        $sidebar_news = News::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        View::share('sidebar_news', $sidebar_news);

        $banner_left = Banner::where('type', 'left')->where('status', 1)->get();
        View::share('banner_left', $banner_left);
        return $next($request);
    }


}
