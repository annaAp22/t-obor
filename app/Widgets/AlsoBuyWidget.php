<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Good;

class AlsoBuyWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'product' => null,
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        if(is_null($this->config['product'])) return '';

        $buyAlso = $this->config['product']->buyalso;

        return view("widgets.also_buy_widget", [
            'config' => $this->config, 'goods' => $buyAlso
        ]);
    }
}