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
        /*
         * Available Validation Rules  https://laravel.com/docs/5.8/validation#available-validation-rules
         */
        $data = request()->validate([
            'name'=>'required|min:3',
            'email'=>'required|email'
        ]);
        $customer = new Customer();
        $customer->name = \request('name');
        $customer->email = \request('email');
        $customer->save();
        return back();
    }
}
