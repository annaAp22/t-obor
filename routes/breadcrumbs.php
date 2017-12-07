<?php

Breadcrumbs::register('index', function($breadcrumbs) {
    $breadcrumbs->push('Главная', route('index'));
});

Breadcrumbs::register('page', function($breadcrumbs, $page) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push($page->name, route($page->sysname));
});

Breadcrumbs::register('search', function($breadcrumbs, $query) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push('Поиск', route('index'));
    $breadcrumbs->push($query);
});

Breadcrumbs::register('reviews', function($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push('Отзывы', route('reviews'));
});

Breadcrumbs::register('news', function($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push('Новости', route('news'));
});

Breadcrumbs::register('news.record', function($breadcrumbs, $newsRecord) {
    $breadcrumbs->parent('news');
    $breadcrumbs->push($newsRecord->name, route('news.record', $newsRecord->sysname));
});

Breadcrumbs::register('articles', function($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push('Статьи', route('articles'));
});

Breadcrumbs::register('article', function($breadcrumbs, $article) {
    $breadcrumbs->parent('articles');
    $breadcrumbs->push($article->name, route('article', $article->sysname));
});

Breadcrumbs::register('catalogRoot', function($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push('Каталог', route('catalog.root'));
});

Breadcrumbs::register('catalog', function($breadcrumbs, $root) {
    $breadcrumbs->parent('catalogRoot');

    if($root instanceof App\Models\Category) {
        if($parent = $root->parent)
            $breadcrumbs->push($parent->name, route('catalog', $parent->sysname));

        $breadcrumbs->push($root->name, route('catalog', $root->sysname));

        return;
    }

    if($root instanceof App\Models\Brand) {
        $breadcrumbs->push($root->name, route('brands', $root->sysname));
        return;
    }

    if($root instanceof App\Models\Tag) {
        $breadcrumbs->push($root->name, route('tags', $root->sysname));
        return;
    }
});

Breadcrumbs::register('product', function($breadcrumbs, $product) {
    $category = $product->categories->count() ? $product->categories->first() : null;

    if(!$category) $breadcrumbs->parent('catalogRoot');
    else $breadcrumbs->parent('catalog', $category);

    $breadcrumbs->push($product->name, route('good', $product));
});

Breadcrumbs::register('views', function($breadcrumbs) {
    $breadcrumbs->parent('catalogRoot');
    $breadcrumbs->push('Недавно просмотренные', route('views'));
});

Breadcrumbs::register('new', function($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push('Новинки', route('new'));
});

Breadcrumbs::register('hits', function($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push('Хиты продаж', route('hits'));
});

Breadcrumbs::register('actions', function($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push('Акции', route('actions'));
});

Breadcrumbs::register('bookmarks', function($breadcrumbs) {
    $breadcrumbs->parent('catalogRoot');
    $breadcrumbs->push('Закладки', route('bookmarks'));
});

Breadcrumbs::register('cart', function($breadcrumbs) {
    $breadcrumbs->push('Моя корзина', route('cart'));
});

Breadcrumbs::register('delivery', function($breadcrumbs) {
    $breadcrumbs->parent('cart');
    $breadcrumbs->push('Оформление заказа', route('order'));
});

Breadcrumbs::register('confirmation', function($breadcrumbs) {
    $breadcrumbs->parent('cart');
    $breadcrumbs->push('Подтверждение заказа заказа', route('order.confirm'));
});
