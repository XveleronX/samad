<?php

namespace App\Http\Controllers;

use App\Mail\MyTestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(){
        $data = [
            'subject'=>'taha mail',
            'body'=>'this is my email'
        ];

        Mail::to('avengerbahram82@gmail.com')->send(new MyTestEmail($data));
        return response()->json([
            'status'=>'check your mail'
        ],200);
    }
}
