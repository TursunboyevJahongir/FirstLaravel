<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class mailController extends Controller
{
    public function send()
    {
        Mail:send(['text' => 'mail'], ['name','Jahongir'], function ($message){
            $message->to('jah6332@gmail.com','to Jahongir')->subject('test');
            $message->form('jah6332@gmail.com','web test');
        });
    }
}
