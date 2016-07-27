<?php

namespace Modules\Backend\Http\Controllers;

use Pingpong\Modules\Routing\Controller as PingpongController;

use Modules\Backend\Repositories\SettingRepository;
use Modules\Backend\Repositories\AdminMenuLinkRepository;

class PopupController extends PingpongController
{
    protected $loggedInAdmin;

    protected $data = [];

    protected $settingRepository;
    protected $adminMenuLinkRepository;

    public function __construct()
    {
        $this->settingRepository = new SettingRepository();
        $this->adminMenuLinkRepository = new AdminMenuLinkRepository();

        $settings = $this->settingRepository->findAll();
        foreach ($settings as $setting) {
            $this->data['settings'][$setting->name] = $setting['value'];
        }

        $loggedInAdmin = \Session::get('logged_in_admin');
        $this->loggedInAdmin = $loggedInAdmin;
        \View::share('loggedInAdmin', $this->loggedInAdmin);

        $this->data['url'] = \Request::url();
        $this->data['lang'] = \Request::query('lang', \App::getLocale());

        $this->resolveRoute();

        \View::share('data', $this->data);
    }

    public function redirect($route)
    {
        return redirect($this->data['prefix'] . '/' . $route);
    }

    public function view($view, $data = [])
    {
        return \View::make('backend::' . $view, $data);
    }

    public function resolveRoute()
    {
        $routeName = \Route::getCurrentRoute()->getActionName();

        $segments = explode('\\', $routeName);

        $this->data['module_name'] = strtolower($segments[1]);

        $lastSegment = $segments[count($segments) - 1];
        $pos = strpos($lastSegment, '@');
        $this->data['controller'] = substr($lastSegment, 0, $pos);

        if (strpos($routeName, '@') >= 0) {
            $actionName = substr($routeName, strpos($routeName, '@') + 1);
            $this->data['action_name']= strtolower($actionName);
        }

        $this->data['prefix'] = \Request::route()->getPrefix();
    }
}
