<?php

namespace Modules\Frontend\Http\Controllers;

use Pingpong\Modules\Routing\Controller as PingpongController;

use App\Entities\MenuLink;

use Modules\Frontend\Repositories\SettingRepository;
use Modules\Frontend\Repositories\MenuLinkRepository;
use Modules\Frontend\Repositories\SlugRepository;
use Modules\Frontend\Repositories\TermRepository;
use Modules\Frontend\Repositories\PostRepository;

use Modules\Frontend\Repositories\UserRepository;
use Modules\Frontend\Repositories\UserTokenRepository;

use Modules\Frontend\Helpers\Hierarchical;
use Modules\Frontend\Collections\SlugCollection;


class BaseController extends PingpongController
{
    private $menuLinkRepository;
    private $slugRepository;
    private $termRepository;
    private $postRepository;
    private $settingRepository;

    protected $data = [];

    public function __construct()
    {
        $this->menuLinkRepository = new MenuLinkRepository();
        $this->slugRepository = new SlugRepository();
        $this->termRepository = new TermRepository();
        $this->postRepository = new PostRepository();

        $this->settingRepository = new SettingRepository();
        $settings = $this->settingRepository->findAll();
        foreach ($settings as $setting) {
            $this->data['settings'][$setting->name] = $setting['value'];
        }

        $loggedInUser = \Session::get('logged_in_user');

//        if (empty($loggedInUser)
//            && \Cookie::get('user_token')) {
//
//            $token = \Cookie::get('user_token');
//            //echo $token;
//            //$this->userRepository->authenticateByCookies($token);
//
//            $userToken = $this->userTokenRepository->findBy('token', '=', $token)->first();
//
//            //var_dump($userToken);
//            //exit();
//
//            if ($userToken
//                && $userToken->status ==0) {
//
//                $user = $this->userRepository->find($userToken->user_id);
//
//                //var_dump($user);
//
//               // exit();
//
//                $loggedInUser = new \stdClass();
//                $loggedInUser->id = $user->id;
//                $loggedInUser->email = $user->email;
//                $loggedInUser->first_name = $user->first_name;
//                $loggedInUser->last_name = $user->last_name;
//
//                \Session::put('logged_in_user', $user);
//
//                \Session::regenerate();
//                //echo $userToken;
//                //exit();
//
//                //$this->userTokenRepository->update($userToken->id, ['status' => 1]);
//            }
//
//        }

        $this->loggedInUser = $loggedInUser;
        \View::share('loggedInUser', $this->loggedInUser);

        //$this->data['base_url'] = \App::make('url')->to('/');
        $this->data['base_url'] = $this->data['settings']['base_url'];
        $this->data['url'] = \Request::url();
        $this->data['lang'] = \App::getLocale();
        //$this->data['menu_links'] = $this->getMenuLinks();
        $this->data['slugs'] = $this->slugRepository->findAll($this->data['lang']);
        $this->data['terms'] = $this->termRepository->findAll($this->data['lang'])->keyBy('id');
        //var_dump($this->data['terms']->toArray());
        //exit();

        $menuLinks = $this->getMenuLinks();

        foreach ($menuLinks as $menuLink) {
            //echo $menuLink->url;
            $slugPath = $this->getSlugByUrl($menuLink->url);
            if ($slugPath) {
                $menuLink->full_url = url('/') . '/' . $this->data['lang'] . $slugPath;
            } else {
                $menuLink->full_url = url('/') . '/' . $this->data['lang'] . $menuLink->url;
            }
        }

        $this->data['menu_links'] = $menuLinks;

        $this->data['module_name'] = 'frontend';

        $this->data['breadcrumbs'] = [];

        \View::share('data', $this->data);

    }

    protected function getBreadcrumbs($term)
    {
        $slugs = $this->data['slugs'];
        $terms = $this->data['terms'];

        $breadcrumb = new SlugCollection($terms, $slugs);
        $breadcrumb->findAncestors($term);
        $breadcrumbTerms = $breadcrumb->collection;

        foreach ($breadcrumbTerms as $term) {
            $slugPath = $this->getSlugPath($term);
            if ($term->slug) {
                $term->full_url = url('/') . '/' . $this->data['lang'] . $slugPath;
            } else {
                $term->full_url = url('/') . '/' . $this->data['lang'] . $term->url;
            }

//            if ($term->thumb_url) {
//                if (substr($term->thumb_url, 0, 4) != 'http') {
//                    $term->thumb_url = $this->data['base_url'] . $term->thumb_url;
//                }
//            }
        }

        $this->data['breadcrumbs'] = $breadcrumbTerms;
        \View::share('data', $this->data);
    }

    protected function getSlugByUrl($url)
    {
        $slugs = $this->data['slugs'];
        $terms = $this->data['terms'];

        $path = '';

        if ($url != '') {

            $arr = explode('/', $url);

            if (is_array($arr) && count($arr) > 1) {

                switch ($arr[1]) {
                    case 'post':
                        $id = $arr[3];

                        $post = $this->postRepository->find($this->data['lang'], $id);
                        if ($post) {

                            if ($post->alias) {
                                $path .= '/' . $post->alias;
                            }

                            $term = $this->termRepository->findByPostId($this->data['lang'], $post->id)->first();

                            if ($term) {
                                $path = $this->getSlugPath($term) . $path;
                            }
                        }

                        break;
                    case 'term':
                        $id = $arr[3];
                        //$term = $this->termRepository->find($this->data['lang'], $id);
                        if (isset($this->data['terms'][$id])) {
                            $term = $this->data['terms'][$id];
                             if ($term) {
                                $path = $this->getSlugPath($term);
                            }
                        }

                        break;
                    default:
                }
            }
        }

        return $path;
    }

    protected function getSlugPath($term)
    {
        $slugs = $this->data['slugs'];
        $terms = $this->data['terms'];

        $path = '';

        $breadcrumb = new SlugCollection($terms, $slugs);
        $breadcrumb->findAncestors($term);
        $breadcrumbTerms = $breadcrumb->collection;

        foreach ($breadcrumbTerms as $term) {
            $path = $term->slug . '/' . $path;
            //echo $term->url . ' ' . $term->slug . '<br />';
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

    protected function getMenuLinks()
    {
        //$lang = \App::getLocale();
        $menuId = 1;

        $menuLinks = $this->menuLinkRepository->findByMenuId($this->data['lang'], $menuId);
        $hierarchical = new Hierarchical($menuLinks);
        $hierarchical->build();
        $menuLinks = $hierarchical->collection;

        return $menuLinks;
    }

    protected function getSettings()
    {
        $settings = $this->settingRepository->findAll();
        return $settings;
    }

//    protected function getModuleName()
//    {
//        $routeName = \Route::getCurrentRoute()->getActionName();
//        $segments = explode('\\', $routeName);
//        return strtolower($segments[1]);
//    }
//
//    protected function getControllerName()
//    {
//        $routeName = \Route::getCurrentRoute()->getActionName();
//        $segments = explode('\\', $routeName);
//        $lastSegment = $segments[count($segments) - 1];
//        $pos = strpos($lastSegment, '@');
//        return substr($lastSegment, 0, $pos);
//    }
//
//    protected function getActionName()
//    {
//        $routeName = \Route::getCurrentRoute()->getActionName();
//        $actionName = substr($routeName, strpos($routeName, '@') + 1);
//        return strtolower($actionName);
//    }

    public function redirect($route)
    {
        return redirect($this->data['lang'] . '/' . $route);
    }

    public function view($view, $data = [])
    {
        return \View::make($this->data['module_name'] . '::' . $view, $data);
    }

}
