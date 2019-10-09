<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
//Importante importar la clase EmailMessage y Mail
use App\Mail\EmailMessage; 
use Mail;

class EmailController extends Controller
{
  
    public function contact(Request $request){
        $name = $request->name;
        $message = $request->message;

        $for = 'dcalvocasanova@gmail.com';
        Mail::to($for)->send(new EmailMessage($name, $message));

        return redirect()->back();
    }
}