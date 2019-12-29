<?php

namespace App\Http\Controllers;

use App\Company;
use App\Customer;

use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{
    public function index()
    {
//        $activeCustomers = Customer::where('status', 1)->get();
        $activeCustomers = Customer::active()->get();
        $inactiveCustomers = Customer::where('status', 0)->get();
        $companies = Company::all();

        return view('customers.index',compact('activeCustomers','inactiveCustomers','companies')
        );
    }

    public function create()
    {
        $companies = Company::all();
        return view('customers.create',compact('companies'));
    }

    public function store()
    {
        /*
         * Available Validation Rules  https://laravel.com/docs/5.8/validation#available-validation-rules
         */
        $data = request()->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'status' => 'required',
            'company_id' => 'required'
        ]);
        Customer::create($data);

        return redirect('/customers');
    }

    public function show(Customer $customer){
//        $customer = Customer::where('id',$customer)->firstOrFail();

        return view('customers.show', compact('customer'));
    }
}
