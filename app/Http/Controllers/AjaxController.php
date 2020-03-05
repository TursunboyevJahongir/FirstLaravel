<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function ajaxPagination(Request $request)
    {
        $data = User::paginate(5);

        if ($request->ajax()) {
            return view('presult', compact('data'));
        }

        return view('ajaxPagination', compact('data'));
    }
}
