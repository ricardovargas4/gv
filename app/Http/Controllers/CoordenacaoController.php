<?php namespace gv\Http\Controllers;

use Illuminate\Support\Facades\DB;
use gv\Http\Requests\CoordenacaoRequest;
use Request;
use gv\Coordenacao;

class CoordenacaoController extends Controller {

    public function lista(){
       // $coordenacaos = Coordenacao::all();
        $coordenacaos = DB::table('coordenacaos')->paginate(15);
        return view('coordenacao.listagem')->with('coordenacaos', $coordenacaos);
    }

    public function remove($id){
        $coordenacao = Coordenacao::find($id);
        $coordenacao->delete();
        return redirect()->action('CoordenacaoController@lista');
    }

    public function altera($id){
        $coordenacao = Coordenacao::find($id);
        return view('coordenacao.formulario_alteracao',compact('coordenacao'));
    }
    public function salvaAlt(CoordenacaoRequest $request){
        
        $id = $request->id;
        Coordenacao::whereId($id)->update($request->except('_token'));
        return redirect()->action('CoordenacaoController@lista')->withInput(Request::only('nome'));
    }


    public function novo(){
        return view('coordenacao.formulario');
    }   

    public function adiciona(CoordenacaoRequest $request){

        Coordenacao::create($request->all());
        return redirect()->action('CoordenacaoController@lista')->withInput(Request::only('nome'));
    }

}
