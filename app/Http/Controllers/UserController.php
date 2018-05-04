<?php

namespace gv\Http\Controllers;

use Illuminate\Support\Facades\DB;
use gv\Http\Requests\UsuarioRequest;
use Request;
use gv\User;

class UserController extends Controller
{
    public function lista(){
        $usuarios = User::all();
        return view('usuario.listagem')->with('usuarios', $usuarios);
    }

    public function remove($id){
        $usuario = User::find($id);
        $usuario->delete();
        return redirect()->action('UserController@lista');
    }

    public function altera($id){
        $usuario = User::find($id);
        return view('usuario.formulario_alteracao',compact('usuario'));
    }
    
    public function salvaAlt(UsuarioRequest $request){
        
        $id = $request->id;
        User::whereId($id)->update($request->except('_token'));
        return redirect()->action('UserController@lista')->withInput(Request::only('nome'));
    }


    public function novo(){
        return view('usuario.formulario');
    }   

    public function adiciona(UsuarioRequest $request){

        User::create($request->all());
        return redirect()->action('UserController@lista')->withInput(Request::only('nome'));
    }

}
