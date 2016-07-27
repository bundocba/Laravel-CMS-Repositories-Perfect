<?php

Route::group(['middleware' => ['backend'], 'prefix' => 'admin', 'namespace' => 'Modules\Backend\Http\Controllers'], function() {

    Route::group(['middleware' => 'admin'], function () {

        Route::controller('dashboard', 'DashboardController');

        Route::controller('account', 'AccountController');

        Route::controller('term', 'TermController');

        Route::controller('post', 'PostController');

        Route::controller('page', 'PageController');

        Route::controller('article', 'ArticleController');

        Route::controller('slug', 'SlugController');

        Route::controller('menu', 'MenuController');

        Route::controller('menu_link', 'MenuLinkController');

        Route::controller('admin_user', 'AdminUserController');

        Route::controller('role', 'RoleController');

        Route::controller('selector', 'SelectorController');

        Route::controller('bill', 'BillController');

    });

    Route::controller('auth', 'AuthController');

    Route::get('/', function () {
        return redirect('admin/auth/login');
    });
});
