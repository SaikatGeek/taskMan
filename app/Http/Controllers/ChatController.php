<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller
{
    public function myChat(){
		return view('myChat');    	
    }

    public function contacts(){
    	$UserList = User::orderBy('type', 'ASC')->orderBy('designation', 'ASC')->orderBy('name', 'ASC')->get();
    	return view('contacts', compact('UserList'));
    }
}
