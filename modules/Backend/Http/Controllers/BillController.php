<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Modules\Backend\Repositories\UserRepository;
use Modules\Backend\Repositories\BillRepository;
class BillController extends BaseController {

    protected $billRepository;

    public function __construct() {
        parent::__construct();
        $this->billRepository = new BillRepository();
    }

    public function getList(Request $request) {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', $this->data['settings']['per_page']);
        $sortBy = $request->query('sort_by', 'payment_id');
        $sortDirection = $request->query('sort_direction', 'asc');
        $models = $this->billRepository->paginate($perPage, $sortBy, $sortDirection);
        return $this->view('bill.list', compact('models'));
    }

}
