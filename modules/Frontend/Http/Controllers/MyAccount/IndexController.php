<?php

namespace Modules\Frontend\Http\Controllers\MyAccount;

use Pingpong\Modules\Routing\Controller as PingpongController;

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
        return view($this->data['module_name'] . '::' . $this->data['sub_module_name'] . '.index.index', compact('menuLinks', 'model'));
    }

}
