<?php

namespace gv\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use Auth;

class LoginController extends Controller
{
    public function form(){
        return view('form_login');
    }
    public function login(){
        $credenciais = Request::only('email','password');
        
        if(Auth::attempt($credenciais)){
            return redirect('/processo');
        }
        
        return redirect('/login');
    }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
