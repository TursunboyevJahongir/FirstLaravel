<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function list()
    {
        $customers = [
            'John Doe1',
            'John Doe2',
            'John Doe3'
        ];


        return view('internals.customers',
            ['customers' => $customers]
        );
    }
}
