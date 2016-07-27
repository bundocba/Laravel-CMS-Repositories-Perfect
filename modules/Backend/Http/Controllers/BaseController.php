<?php

namespace Modules\Backend\Http\Controllers;

use Pingpong\Modules\Routing\Controller as PingpongController;

use Modules\Backend\Repositories\SettingRepository;
use Modules\Backend\Repositories\AdminMenuLinkRepository;

use Modules\Backend\Helpers\Hierarchical;
use Modules\Backend\Collections\AdminMenuLinkCollection;

use Modules\Frontend\Collections\SlugCollection;

use Modules\Backend\Repositories\TermRepository;
use Modules\Backend\Repositories\SlugRepository;

use Modules\Backend\Repositories\AdminUserRepository;
use Modules\Backend\Repositories\AdminUserTokenRepository;

use App\Entities\Role;

class BaseController extends PingpongController
{
    protected $loggedInAdmin;

    protected $data = [];

    protected $settingRepository;
    protected $adminMenuLinkRepository;
    protected $termRepository;
    protected $slugRepository;

    protected $adminUserRepository;
    protected $adminUserTokenRepository;
    

    public function __construct()
    {
        $this->settingRepository = new SettingRepository();
        $this->adminMenuLinkRepository = new AdminMenuLinkRepository();

        $this->adminUserRepository = new AdminUserRepository();
        $this->adminUserTokenRepository = new AdminUserTokenRepository();

        $settings = $this->settingRepository->findAll();
        foreach ($settings as $setting) {
            $this->data['settings'][$setting->name] = $setting['value'];
        }

        $loggedInAdmin = \Session::get('logged_in_admin');
        $this->loggedInAdmin = $loggedInAdmin;
        \View::share('loggedInAdmin', $this->loggedInAdmin);

        $this->resolveRoute();

        $menuLinks = $this->getMenuLinks();
        $this->data['menu_links'] = $menuLinks;

        $controllerName = $this->data['controller_name'];
        //echo $controllerName;
        $breadcrumbLinks = $this->getBreadcrumbs($controllerName);
        $this->data['breadcrumbs'] = $breadcrumbLinks;
        \View::share('data', $this->data);

//        foreach ($breadcrumbLinks as $breadcrumbLink) {
//            echo $breadcrumbLink->id . '<br />';
//        }


        foreach ($menuLinks as $menuLink) {
            //echo $menuLink->id . ',';
            //var_dump(array_key_exists($menuLink->id, $arr));
            $link = $menuLink->url;
//            echo $link . '<br />';
            $linkId = $menuLink->id;
            $item = '';
            if ($breadcrumbLinks) {
                $filtered = $breadcrumbLinks->filter(function ($item) use ($linkId) {
                    return $item->id == $linkId;
                });
                $item = $filtered->first();
            }

            //var_dump($item);

            if ($item) {
                $menuLink->selected = true;
                //echo $menuLink->name . '<br />';
            } else {
                $menuLink->selected = false;
            }
        }

        //echo $controllerName;

        //print_r($menuLinks);

        //var_dump($this->data['breadcrumbs']);

        //$this->data['base_url'] = \App::make('url')->to('/');
        $this->data['base_url'] = $this->data['settings']['base_url'];
        $this->data['url'] = \Request::url();
        $this->data['lang'] = \Request::query('lang', \App::getLocale());
        $this->data['back_url'] = '';

        $this->resolveBackUrl();

        $statusList = $this->getStatusList();
        \View::share('statusList', $statusList);

        $languageList = $this->getLanguageList();
        \View::share('languageList', $languageList);

        $weightList = $this->getWeightList();
        \View::share('weightList', $weightList);

        \View::share('data', $this->data);
    }

    public function redirect($route)
    {
        return redirect($this->data['prefix'] . '/' . $route);
    }

    public function redirectBackUrl($url)
    {
        return $this->data['back_url'] ? redirect($this->data['back_url']) : $this->redirect($url);
    }

    public function view($view, $data = [])
    {
        return \View::make($this->data['module_name'] . '::' . $view, $data);
    }

    public function resolveBackUrl()
    {
        //$referer = \Request::server('HTTP_REFERER');

        //$this->data['back_url'] = \Session::get('backend_back_url');
        $backUrl = \Session::get('backend_back_url');
        $previous = \Request::server('HTTP_REFERER');

        //\Debugbar::addMessage('#', $this->data['back_url'] . '#' . $previous . '#' . \Request::fullUrl());

        if ($backUrl != $previous
            && $previous != \Request::fullUrl()) {
            $this->data['back_url'] = $previous;
            \Session::put('backend_back_url', $previous);
        } else {
            $this->data['back_url'] = $backUrl;
            \Session::put('backend_back_url', $backUrl);
        }

        \View::share('back_url', $backUrl);

        //\Debugbar::addMessage('Back Url', $this->data['back_url']);
    }

    protected function getMenuLinks()
    {
        $menuId = 1;

        if ($this->loggedInAdmin->role_id == Role::SUPER_ADMINISTRATOR) {
            $menuLinks = $this->adminMenuLinkRepository->findActivatedByMenuId($menuId);
        } else {
            $menuLinks = $this->adminMenuLinkRepository->findActivatedByMenuIdAndRoleId($menuId, $this->loggedInAdmin->role_id);
        }

        //var_dump($menuLinks->toArray());

        $hierarchical = new Hierarchical($menuLinks);
        $hierarchical->build();
        $menuLinks = $hierarchical->collection;

        return $menuLinks;
    }

    public function resolveRoute()
    {
        $routeName = \Route::getCurrentRoute()->getActionName();

        $segments = explode('\\', $routeName);

        $this->data['module_name'] = strtolower($segments[1]);

        $lastSegment = $segments[count($segments) - 1];
        $pos = strpos($lastSegment, '@');
        $this->data['controller_name'] = strtolower(str_replace('Controller', '', substr($lastSegment, 0, $pos)));
        //echo '<br />';
        //echo \Route::getCurrentRoute()->getPath();

        if (strpos($routeName, '@') >= 0) {
            $actionName = substr($routeName, strpos($routeName, '@') + 1);
            $this->data['action_name']= strtolower($actionName);
        }

        $this->data['prefix'] = \Request::route()->getPrefix();
    }

    public function getStatusList()
    {
        $statusList = ['' => trans('backend::global.select'), '0' => trans('backend::global.inactive'), '1' => trans('backend::global.active')];
        return $statusList;
    }

    public function getLanguageList()
    {
        $statusList = ['vi' => trans('backend::global.vietnamese'), 'en' => trans('backend::global.english')];
        return $statusList;
    }

    public function getWeightList()
    {
        $weightList = '';

        for ($i = 1; $i <= 20; $i++) {
            $weightList[$i] = $i;
        }

        return $weightList;
    }

    protected function getSlugPath($term)
    {
        $this->termRepository = new TermRepository();
        $this->slugRepository = new SlugRepository();

        $slugs = $this->slugRepository->findAll();
        $terms = $this->termRepository->findAll();

        $path = '';

        $breadcrumb = new SlugCollection($terms, $slugs);
        $breadcrumb->findAncestors($term);
        $breadcrumbTerms = $breadcrumb->collection;

        foreach ($breadcrumbTerms as $term) {
            $path = $term->slug . '/' . $path;
        }

        if ($path) {
            $path = '/' . $path;

            $pos = strrpos($path, '/');

            if ($pos == strlen($path) - 1) {
                $path = substr($path, 0, strlen($path) - 1);
            }
        }

        return $path;
    }

    protected function getBreadcrumbs($controllerName)
    {
        $menuLinks = $this->adminMenuLinkRepository->findAll();

        $breadcrumb = new AdminMenuLinkCollection($menuLinks);

        $menuLink = $breadcrumb->findByControllerName($controllerName);

        if ($menuLink != null) {
            $breadcrumb->findAncestors($menuLink);
            $breadcrumbLinks = $breadcrumb->collection;
        } else {
            $breadcrumbLinks = [];
        }
        return $breadcrumbLinks;
    }
}
