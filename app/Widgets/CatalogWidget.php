<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class CatalogWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'marker_down' => false
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $categories = \App\Models\Category::with('categories')->where('id_parent', 0)->where('status', 1)->orderBy('sort')->get();

        return view("widgets.catalog_widget", [
            'config' => $this->config, 'categories' => $categories
        ]);
    }
}