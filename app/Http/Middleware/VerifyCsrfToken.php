<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/admin/editor/upload*',
        '/admin/services/get_groups',
        '/admin/zooshops/get_groups',
        '/admin/vetpharmacies/get_groups',
        '/good/comment/*',
        '/admin/goods/search',
        '/subscribe',
        '/order/fast.html',
        '/goods/get',
        '/cart/delete/*'
    ];
}
