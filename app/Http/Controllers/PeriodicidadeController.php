<?php namespace gv\Http\Controllers;

use Illuminate\Support\Facades\DB;
use gv\Http\Requests\PeriodicidadeRequest;
use Request;
use gv\Periodicidade;

class PeriodicidadeController extends Controller {

    public function lista(){
        //$periodicidades = Periodicidade::all();
        $periodicidades = DB::table('periodicidades')->paginate(15);
        return view('periodicidade.listagem')->with('periodicidades', $periodicidades);
    }

    public function remove($id){
        $periodicidade = Periodicidade::find($id);
        $periodicidade->delete();
        return redirect()->action('PeriodicidadeController@lista');
    }

    public function altera($id){
        $periodicidade = Periodicidade::find($id);
        return view('periodicidade.formulario_alteracao',compact('periodicidade'));
    }
    public function salvaAlt(PeriodicidadeRequest $request){
        
        $id = $request->id;
        Periodicidade::whereId($id)->update($request->except('_token'));
        return redirect()->action('PeriodicidadeController@lista')->withInput(Request::only('nome'));
    }


    public function novo(){
        return view('periodicidade.formulario');
    }   

    public function adiciona(PeriodicidadeRequest $request){

        Periodicidade::create($request->all());
        return redirect()->action('PeriodicidadeController@lista')->withInput(Request::only('nome'));
    }

}
