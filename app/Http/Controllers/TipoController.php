<?php namespace gv\Http\Controllers;

use Illuminate\Support\Facades\DB;
use gv\Http\Requests\ProcessosRequest;
use gv\Http\Requests\TipoRequest;
use Request;
use gv\Tipo;

class TipoController extends Controller {

    public function lista(){
        //$tipos = Tipo::all()->paginate(15);
        $tipos = DB::table('tipos')->paginate(15);
        return view('tipo.listagem')->with('tipos', $tipos);
    }

    public function remove($id){
        $tipo = Tipo::find($id);
        $tipo->delete();
        return redirect()->action('TipoController@lista');
    }

    public function altera($id){
        $tipo = Tipo::find($id);
        return view('tipo.formulario_alteracao',compact('tipo'));
    }
    public function salvaAlt(TipoRequest $request){
        
        $id = $request->id;
        Tipo::whereId($id)->update($request->except('_token'));
        return redirect()->action('TipoController@lista')->withInput(Request::only('nome'));
    }


    public function novo(){
        return view('tipo.formulario');
    }   

    public function adiciona(TipoRequest $request){

        Tipo::create($request->all());
        return redirect()->action('TipoController@lista')->withInput(Request::only('nome'));
    }

}
