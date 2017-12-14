<?php
    /*
     * Страницы с sidebar'ом
     */
    Route::group(['middleware' => 'settings'], function() {
        Route::group(['middleware' => 'with_sidebar'], function() {
            // Страницы
            Route::get('/', ['as' => 'index', 'uses' => 'MainController@index']);
            Route::get('/about/', ['as' => 'about', 'uses' => 'MainController@content']);
            Route::get('/delivery/', ['as' => 'delivery', 'uses' => 'MainController@delivery']);
            Route::get('/warranty/', ['as' => 'warranty', 'uses' => 'MainController@warranty']);
            Route::get('/contacts/', ['as' => 'contacts', 'uses' => 'MainController@contacts']);
            Route::get('/order_payment/', ['as' => 'order_payment', 'uses' => 'MainController@content']);
            Route::get('/diler/', ['as' => 'diler', 'uses' => 'MainController@content']);
            // Нет в верстке
            Route::get('/sertificates/', ['as' => 'sertificates', 'uses' => 'MainController@sertificates']);
            Route::get('/samovyvoz/', ['as' => 'pickup', 'uses' => 'MainController@pickup']);

            // Статьи
            Route::get('/articles/', ['as' => 'articles', 'uses' => 'MainController@articles']);
            Route::get('/articles/{sysname}/', ['as' => 'article', 'uses' => 'MainController@article']);

            // Поиск
            Route::match(['get', 'post'], '/search/', ['as' => 'search', 'uses' => 'CatalogController@search']);
            Route::match(['get', 'post'], '/goods/search/', ['as' => 'goods.search', 'uses' => 'CatalogController@goodssearch']);

            // Каталог
            Route::get('/catalog/', ['as' => 'catalog.root', 'uses' => 'CatalogController@catalogRoot'])->where(['sysname' => '[a-zA-Z0-9_-]+']);
            Route::get('/catalog/{sysname}/', ['as' => 'catalog', 'uses' => 'CatalogController@catalog'])->where(['sysname' => '[a-zA-Z0-9_-]+']);
            Route::get('/brand/{sysname}/', ['as' => 'brands', 'uses' => 'CatalogController@brands'])->where(['sysname' => '[a-zA-Z0-9_-]+']);
            Route::get('/tag/{sysname}/', ['as' => 'tags', 'uses' => 'CatalogController@tags'])->where(['sysname' => '[a-zA-Z0-9_-]+']);
            Route::get('/views/', ['as' => 'views', 'uses' => 'CatalogController@views']);
            Route::get('/bookmarks/', ['as' => 'bookmarks', 'uses' => 'CatalogController@bookmarks']);

            // Товары
            Route::get('/gds/{sysname}/', ['as' => 'good', 'uses' => 'CatalogController@good'])->where(['sysname' => '[a-zA-Z0-9_-]+']);
            Route::get('/actions/', ['as' => 'actions', 'uses' => 'CatalogController@actions']);
            Route::get('/nova/', ['as' => 'new', 'uses' => 'CatalogController@newGoods']);
            Route::get('/hits/', ['as' => 'hits', 'uses' => 'CatalogController@hits']);

            // Отзывы
            Route::get('/reviews/', ['as' => 'reviews', 'uses' => 'MainController@reviews']);

            // Новости
            Route::get('/news/', ['as' => 'news', 'uses' => 'MainController@news']);
            Route::get('/news/{sysname}/', ['as' => 'news.record', 'uses' => 'MainController@newsSingle']);
        });

        Route::get('/cart/', ['as' => 'cart', 'uses' => 'OrderController@cart']);
        Route::get('/order/', ['as' => 'order', 'uses' => 'OrderController@order']);
        Route::get('/order/confirm/', ['as' => 'order.confirm', 'uses' => 'OrderController@confirm']);

    });

Route::post('/cart/', ['as' => 'cart.edit', 'uses' => 'OrderController@cartEdit']);
Route::post('/goods/get', ['as' => 'goods.get', 'uses' => 'CatalogController@getGoods']);
Route::post('/good/comment/{id}', ['as' => 'good.comment', 'uses' => 'CatalogController@comment'])->where(['id' => '[0-9]+']);

//    Route::get('/gds/defer/{id}', ['as' => 'good.defer', 'uses' => 'CatalogController@defer'])->where(['id' => '[0-9]+']);
//    Route::get('/gds/cart/add/{id}/{cnt}', ['as' => 'good.cart', 'uses' => 'CatalogController@cart'])->where(['id' => '[0-9]+', 'cnt' => '[0-9]+']);
//    Route::get('/gds/cart/remove/{id}', ['as' => 'good.removeFromCart', 'uses' => 'CatalogController@removeFromCart'])->where('id', '[0-9]+');
    //


  Route::get('/good/defer/{id}', ['as' => 'good.defer', 'uses' => 'CatalogController@defer'])->where(['id' => '[0-9]+']);
  Route::get('/good/cart/add/{id}/{cnt}', ['as' => 'good.cart', 'uses' => 'CatalogController@cart'])->where(['id' => '[0-9]+', 'cnt' => '[0-9]+']);
  Route::get('/good/cart/remove/{id}', ['as' => 'good.removeFromCart', 'uses' => 'CatalogController@removeFromCart'])->where('id', '[0-9]+');
    //delete good from cart and session
    Route::post('/cart/delete/{id}', ['as' => 'delete', 'uses' => 'CatalogController@cartdelete'])->where('id', '[0-9]+');



    Route::post('/order/delivery/', ['as' => 'order.delivery', 'uses' => 'OrderController@delivery']);
    Route::post('/order/fast/', ['as' => 'order.fast', 'uses' => 'OrderController@fast']);

    Route::post('/subscribe', ['as' => 'subscribe', 'uses' => 'MainController@subscribe']);
    Route::post('/letter', ['as' => 'letter', 'uses' => 'MainController@letter']);
    Route::post('/callback/', ['as' => 'callback', 'uses' => 'MainController@callback']);


    Route::get('/offer/', ['as' => 'offer', function(){
        return 'Страница публичной офферты';
    }]);
    /*
    * Админка
    */
    Route::group(['prefix'=>'admin', 'middleware' => 'auth'], function()
    {
        Route::resource('categories', 'admin\CategoryController', ['except' => ['show']]);
        Route::get('/categories/sort', ['as' => 'admin.categories.sort', 'uses' => 'admin\CategoryController@sort']);
        Route::post('/categories/sort/save', ['as' => 'admin.categories.sort.save', 'uses' => 'admin\CategoryController@sortSave']);
        Route::put('/categories/restore/{id}', ['as' => 'admin.categories.restore', 'uses' => 'admin\CategoryController@restore'])->where(['id' => '[0-9]+']);

        Route::resource('tags', 'admin\TagController', ['except' => ['show']]);
        Route::put('/tags/restore/{id}', ['as' => 'admin.tags.restore', 'uses' => 'admin\TagController@restore'])->where(['id' => '[0-9]+']);

        Route::resource('goods', 'admin\GoodController', ['except' => ['show']]);
        Route::put('/goods/restore/{id}', ['as' => 'admin.goods.restore', 'uses' => 'admin\GoodController@restore'])->where(['id' => '[0-9]+']);
        Route::post('/goods/search', ['as' => 'admin.goods.search', 'uses' => 'admin\GoodController@search']);
        Route::get('/goods/category/{id}/sort', ['as' => 'admin.goods.category.sort', 'uses' => 'admin\GoodController@sortCategory'])->where(['id' => '[0-9]+']);
        Route::post('/goods/category/{id}/sort/save', ['as' => 'admin.goods.category.sort.save', 'uses' => 'admin\GoodController@sortCategorySave'])->where(['id' => '[0-9]+']);
        Route::get('/goods/tag/{id}/sort', ['as' => 'admin.goods.tag.sort', 'uses' => 'admin\GoodController@sortTag'])->where(['id' => '[0-9]+']);
        Route::post('/goods/tag/{id}/sort/save', ['as' => 'admin.goods.tag.sort.save', 'uses' => 'admin\GoodController@sortTagSave'])->where(['id' => '[0-9]+']);

        Route::resource('reviews', 'admin\ReviewController', ['except' => ['show']]);
        Route::resource('news', 'admin\NewsController', ['except' => ['show']]);

        Route::resource('articles', 'admin\ArticleController', ['except' => ['show']]);
        Route::put('/articles/restore/{id}', ['as' => 'admin.articles.restore', 'uses' => 'admin\ArticleController@restore'])->where(['id' => '[0-9]+']);

        Route::resource('brands', 'admin\BrandController', ['except' => ['show']]);
        Route::put('/brands/restore/{id}', ['as' => 'admin.brands.restore', 'uses' => 'admin\BrandController@restore'])->where(['id' => '[0-9]+']);

        Route::resource('users', 'admin\UserController', ['except' => ['show']]);
        Route::put('/users/restore/{id}', ['as' => 'admin.users.restore', 'uses' => 'admin\UserController@restore'])->where(['id' => '[0-9]+']);

        Route::resource('sertificates', 'admin\SertificateController', ['except' => ['show', 'edit', 'update']]);

        Route::resource('banners', 'admin\BannerController', ['except' => ['show']]);
        Route::put('/banners/restore/{id}', ['as' => 'admin.banners.restore', 'uses' => 'admin\BannerController@restore'])->where(['id' => '[0-9]+']);

        Route::resource('deliveries', 'admin\DeliveryController', ['except' => ['show']]);
        Route::put('/deliveries/restore/{id}', ['as' => 'admin.deliveries.restore', 'uses' => 'admin\DeliveryController@restore'])->where(['id' => '[0-9]+']);

        Route::resource('payments', 'admin\PaymentController', ['except' => ['show']]);
        Route::put('/payments/restore/{id}', ['as' => 'admin.payments.restore', 'uses' => 'admin\PaymentController@restore'])->where(['id' => '[0-9]+']);

        Route::resource('orders', 'admin\OrderController', ['except' => ['show', 'create', 'store']]);
        Route::put('/orders/restore/{id}', ['as' => 'admin.orders.restore', 'uses' => 'admin\OrderController@restore'])->where(['id' => '[0-9]+']);

        Route::resource('attributes', 'admin\AttributeController', ['except' => ['show']]);
        Route::put('/attributes/restore/{id}', ['as' => 'admin.attributes.restore', 'uses' => 'admin\AttributeController@restore'])->where(['id' => '[0-9]+']);



        Route::resource('comments', 'admin\GoodCommentController', ['except' => ['show']]);


        Route::get('/main', ['as' => 'admin.main', 'uses' => 'admin\MainController@index']);

        Route::resource('pages', 'admin\PageController', ['except' => ['show']]);
        Route::get('/pages/{sysname}/edit_sysname', ['as' => 'admin.pages.edit_sysname', 'uses' => 'admin\PageController@editSysname'])->where(['sysname' => '[a-zA-Z0-9_-]+']);
        Route::put('/pages/{sysname}/content', ['as' => 'admin.pages.update_content', 'uses' => 'admin\PageController@updateContent'])->where(['sysname' => '[a-zA-Z0-9_-]+']);

        Route::resource('metatags', 'admin\MetatagsController', ['except' => ['show']]);
        Route::get('/metatags/{route}/edit_route', ['as' => 'admin.metatags.edit_route', 'uses' => 'admin\MetatagsController@editRoute'])->where(['route' => '[\.a-zA-Z0-9_-]+']);

        Route::resource('settings', 'admin\SettingController', ['except' => ['show']]);

        Route::get('/image/crop', ['as' => 'admin.image.crop', 'uses' => 'admin\MainController@crop']);
        Route::post('/image/crop', ['as' => 'admin.image.crop.save', 'uses' => 'admin\MainController@cropUpdate']);

        Route::post('/editor/upload', ['as' => 'editor.upload', 'uses' => 'admin\MainController@uploadFileCKeditor'] );
    });

    // auth
    Route::auth();
    Route::match(['get', 'head'], '/login', ['middleware' => 'guest', 'uses' => 'Auth\AuthController@showLoginForm']);
