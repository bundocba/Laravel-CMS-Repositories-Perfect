<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Modules\Backend\Repositories\PostRepository;
use Modules\Backend\Repositories\TermRepository;
use Modules\Backend\Repositories\AdminUserRepository;


class DashboardController extends BaseController
{
    protected $termRepository;
    protected $postRepository;
    protected $adminUserRepository;

    public function __construct()
    {
        parent::__construct();

        $this->termRepository = new TermRepository();
        $this->postRepository = new PostRepository();
        $this->adminUserRepository = new AdminUserRepository();
    }

    public function getIndex()
    {
        $categoryCount = $this->termRepository->countBy('taxonomy_id', '=', 1);

        $pageCount = $this->postRepository->countBy('content_type_id', '=', 1);

        $articleCount = $this->postRepository->countBy('content_type_id', '=', 2);

        $adminUserCount = $this->adminUserRepository->count();

        return $this->view('dashboard.index', compact('termCount', 'categoryCount', 'pageCount', 'articleCount', 'adminUserCount'));
    }
}
