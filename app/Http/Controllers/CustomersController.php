<?php

namespace App\Http\Controllers;

use App\Company;
use App\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;

class CustomersController extends Controller
{
    public $color = [1 => 'primary',
        2 => 'secondary',
        3 => 'success',
        4 => 'danger',
        5 => 'warning',
        6 => 'info',
        7 => 'light',
        8 => 'dark ',];

    public function index()
    {
//        $customers = Customer::pagination(5);

//        $color = new $this->$color;
        $activeCustomers = Customer::active()->get();
        $inactiveCustomers = Customer::where('status', 0)->get();
        $companies = Company::all();

        return view('customers.index', compact('activeCustomers', 'inactiveCustomers', 'companies', 'customers')
        );
    }

    public function create()
    {
        $companies = Company::all();
        $customer = new Customer();
        return view('customers.create', compact('companies', 'customer'));
    }

    public function store()
    {
        if ($token = session()->get('inputToken')) {
            if ($token === \request()->post('antiDoubleSave')) {
                session()->flash('inputToken', '');
                echo "cKRFp9znDLdAwiOacmKB8b10zIfdt2Lr<br/>";
                echo $token;
                exit;
            } else {
                echo "xaxax";
                exit;
//                return redirect('/customers');
            }
        }

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

    public function show(Customer $customer)
    {
//        $customer = Customer::where('id',$customer)->firstOrFail();

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $companies = Company::all();
        return view('customers.edit', compact('customer', 'companies'));
    }

    public function update(Customer $customer)
    {
        $data = request()->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'status' => 'required',
            'company_id' => 'required'
        ]);
        $customer->update($data);

        return redirect('/customers/' . $customer->id);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect('/customers');
    }
}
