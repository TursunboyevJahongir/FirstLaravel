<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function list()
    {
        $customers = Customer::all();
//       dump($customers);


        return view('internals.customers',
            ['customers' => $customers]
        );
    }

    public function store()
    {
        $customer = new Customer();
        $customer->name = \request('name');
        $customer->save();
        return back();
    }
}
