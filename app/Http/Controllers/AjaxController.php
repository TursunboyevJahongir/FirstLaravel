<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxPagination(Request $request)
    {
        $data = Customer::paginate(5);

        if ($request->ajax()) {
            return view('presult', compact('data'));
        }

        return view('ajaxPagination', compact('data'));
    }
}
