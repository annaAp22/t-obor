<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class CatalogArticlesWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'category_id' => 0,
        'tag_id' => 0
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        if(!$this->config['category_id'] && !$this->config['tag_id']) {
            return '';
        }

        //статьи в категории
        if($this->config['category_id']) {
            $articles = \App\Models\Article::whereHas('categories', function ($query) {
                $query->where('category_id', $this->config['category_id']);
            })->where('status', 1)->take(9)->get();
        //статьи у тега
        } else {
            $articles = \App\Models\Article::whereHas('tags', function ($query) {
                $query->where('tag_id', $this->config['tag_id']);
            })->where('status', 1)->take(9)->get();
        }

        if(!$articles->count()) {
            return '';
        }

        return view("widgets.catalog_articles_widget", [
            'config' => $this->config, 'articles' => $articles
        ]);
    }
}