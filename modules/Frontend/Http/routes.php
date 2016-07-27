<?php

use Modules\Frontend\Repositories\SlugRepository;
use Modules\Frontend\Repositories\TermRepository;

$locale = \Request::segment(1);

$locales = config('app.locales');

if ($locales) {

    if (array_key_exists($locale, $locales)) {
        $this->app->setLocale($locale);
    } else {
        $locale = config('app.fallback_locale');
        $this->app->setLocale($locale);
    }
}

$locale = $this->app->getLocale();


Route::group(['middleware' => ['frontend'], 'prefix' => $locale . '/myaccount/', 'namespace' => 'Modules\Frontend\Http\Controllers\MyAccount'], function() {
    Route::controller('index', 'IndexController');
});

Route::group(['middleware' => ['frontend'], 'prefix' => $locale . '/shop/', 'namespace' => 'Modules\Frontend\Http\Controllers\Shop'], function() {
    Route::controller('index', 'IndexController');
});


Route::group(['middleware' => ['frontend'], 'prefix' => $locale, 'namespace' => 'Modules\Frontend\Http\Controllers'], function() {

    Route::controller('post', 'PostController');

    Route::controller('term', 'TermController');

    Route::controller('user', 'UserController');

    Route::controller('account', 'AccountController');

    Route::controller('search', 'SearchController');

//    Route::controller('test', 'TestController');

    Route::get('/', 'IndexController@getIndex');

    Route::get('{slug}', function ($slug) {

        $arr = explode('/', $slug);
        $slug = $arr[count($arr) - 1];

        $locale = $this->app->getLocale();
        //echo $locale;

        $termRepository = new TermRepository();
        $taxonomyId = 1;
        $terms = $termRepository->findByTaxonomyId($locale, $taxonomyId);

        $slugRepository = new SlugRepository();
        $slug = $slugRepository->findBy($locale, 'alias', '=', $slug)->first();

        //var_dump($slug);
        //exit();

        if ($slug) {

            $arr = explode('/', $slug->url);

            if (is_array($arr) && count($arr) > 1) {

                switch ($arr[1]) {
                    case 'post':
                        $id = $arr[3];
                        echo \App::make('\Modules\Frontend\Http\Controllers\PostController')->getShow($id);
                        break;
                    case 'term':
                        $id = $arr[3];
                        echo \App::make('\Modules\Frontend\Http\Controllers\TermController')->getList($id);
                        break;
                    default:
                }
            }

        } else {
            abort(404);
        }

    })->where('slug', '([A-Za-z0-9\-\/\.]+)');

});


Route::get('/', function () use ($locale) {
    return \Redirect::to($locale);
});
