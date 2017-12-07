<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Good;

class ViewGoodsWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'good_id' => 0
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        if(!session()->has('goods.view')) {
            return '';
        }
        $ids = session()->get('goods.view');

        if($this->config['good_id']) {
            $ids = array_except($ids, [$this->config['good_id']]);
        }

        $goods = Good::with('attributes')->whereIn('id', array_keys($ids))->where('status', 1)->get();

        return view("widgets.view_goods_widget", [
            'config' => $this->config, 'goods' => $goods
        ]);
    }
}