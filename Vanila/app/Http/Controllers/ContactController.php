<?php

namespace App\Http\Controllers;

use App\Mail\ContactMe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    //
    public function show ()
    {
        return view('contact');
    }

    public function store()
    {
        // request()->validate(['email' => 'required|email']);
        // Mail::raw("It works!",function($message){
        //     $message->to(request('email'))->subject("hello there");
        // });

        Mail::to(request('email'))
            ->send(new ContactMe('Laravel'));

        return redirect('/contact')
            ->with('message','Email has been sent! Relax Now');
    }
}
