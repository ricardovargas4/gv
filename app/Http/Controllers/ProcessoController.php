<?php namespace gv\Http\Controllers;

use Illuminate\Support\Facades\DB;
use gv\Processo;
use gv\Http\Requests\ProcessosRequest;
use Request;
use gv\Tipo;
use gv\Periodicidade;
use gv\Coordenacao;

class ProcessoController extends Controller {

    public function lista(){

        $tipos = Tipo::all();
        $periodicidades = Periodicidade::all();
        $coordenacaos =  Coordenacao::all();
        $processos = DB::table('processos')
        ->join('tipos', 'tipos.id', '=', 'processos.tipo')
        ->join('periodicidades', 'periodicidades.id', '=', 'processos.periodicidade')
        ->join('coordenacaos', 'coordenacaos.id', '=', 'processos.coordenacao')        
        ->select(DB::raw("processos.id as id, processos.nome as nome, tipos.nome as tipo, 
                          periodicidades.nome as periodicidade, processos.pasta, 
                          coordenacaos.nome as coordenacao" ))
        ->paginate(15);
        //return($atividades);
        //return view('atividade.telaAtividades',compact('atividades','usuario_id'));
        
        //$processos = Processo::all();
        return view('processo.listagem',compact('processos','tipos','periodicidades','coordenacaos'));
        //return view('processo.listagem')->with('processos', $processos);
    }

    public function remove($id){
        $processo = Processo::find($id);
        $processo->delete();
        return redirect()->action('ProcessoController@lista');
    }

    public function altera($id){
        $processo = Processo::find($id);
        $tipos = Tipo::all();
        $periodicidades = Periodicidade::all();
        $coordenacaos =  Coordenacao::all();
        return view('processo.formulario_alteracao',compact('processo','tipos','periodicidades','coordenacaos'));
    }
    public function salvaAlt(ProcessosRequest $request){
        
        $id = $request->id;
        Processo::whereId($id)->update($request->except('_token'));
        return redirect()->action('ProcessoController@lista')->withInput(Request::only('nome'));
    }


    public function novo(){

        $tipos = Tipo::all();
        $periodicidades = Periodicidade::all();
        $coordenacaos =  Coordenacao::all();

        return view('processo.formulario',compact('tipos','periodicidades','coordenacaos'));
    }   

    public function adiciona(ProcessosRequest $request){

        Processo::create($request->all());
        return redirect()->action('ProcessoController@lista')->withInput(Request::only('nome'));
    }

}
