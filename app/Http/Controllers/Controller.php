<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Route;
use Meta;


class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function getFormFilter($input = [], $perpage = 10) {
        if(!empty($input['page'])) {
            $input['f']['page'] = $input['page'];
        }
        if(!empty($input['f'])) {
            if(empty($input['f']['perpage'])) {
                $input['f']['perpage'] = $perpage;
            }
            session()->put(Route::currentRouteName().'.filters', $input['f']);
            return $input['f'];
        } elseif(!empty($input['refresh'])) {
            session()->forget(Route::currentRouteName().'.filters');
            return ['perpage' => $perpage];
        } else {
            $sess = session()->get(Route::currentRouteName().'.filters');
            if(empty($sess) || empty($sess['perpage'])) {
                $sess['perpage'] = $perpage;
            }
            return $sess;
        }
    }

    public function setMetaTags($replacement = null, $title = null, $description = null, $keywords = null) {
        $metatags = \App\Models\Metatag::where('route',Route::currentRouteName())->first();
        $title = ($title ?: (!empty($metatags) ? $metatags->title : null));
        $description = ($description ?: (!empty($metatags) ? $metatags->description : null));
        $keywords = ($keywords ?: (!empty($metatags) ? $metatags->keywords : null));

        if($title || $description || $keywords) {
            if($replacement) {
                $title = strtr($title, $replacement);
                $description = strtr($description, $replacement);
                $keywords = strtr($keywords, $replacement);
            }

            Meta::setTitle($title)
                ->setMetaDescription($description)
                ->setMetaKeywords($keywords);
        }
    }

}
