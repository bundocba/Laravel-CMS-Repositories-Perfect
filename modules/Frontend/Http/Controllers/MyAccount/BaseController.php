<?php

namespace Modules\Frontend\Http\Controllers\MyAccount;

use Pingpong\Modules\Routing\Controller as PingpongController;

class BaseController extends PingpongController
{
    protected $data = [];

    public function __construct()
    {
        $this->data['url'] = \Request::url();
        
        $this->data['lang'] = \App::getLocale();
        
        $this->data['module_name'] = 'frontend';

        $this->data['sub_module_name'] = 'myaccount';

        \View::share('data', $this->data);
    }

}
