<?php

namespace Modules\Backend\Http\Controllers;

class IndexController extends BaseController
{
    public function getIndex()
    {
        return view('backend::index.index');
    }
}
