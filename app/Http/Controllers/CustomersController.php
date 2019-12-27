<?php

namespace App\Http\Controllers;

use App\Customer;

use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{
    public function list()
    {
//        $activeCustomers = Customer::where('status', 1)->get();
        $activeCustomers = Customer::active()->get();
        $inactiveCustomers = DB::table('customers')->where('status',  0)->get();


        return view('internals.customers',compact('activeCustomers','inactiveCustomers')
        );
    }

    public function store()
    {
        /*
         * Available Validation Rules  https://laravel.com/docs/5.8/validation#available-validation-rules
         */
        $data = request()->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'status' => ''
        ]);
        Customer::create($data);

        return back();
    }
}
