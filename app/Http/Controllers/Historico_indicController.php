<?php

namespace gv\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use gv\Http\Requests\Historico_indicRequest;
use Request;
use gv\historico_indic;
use gv\Processo;
use gv\Periodicidade;
use gv\User;
use \Datetime;
use Auth;

class Historico_indicController extends Controller
{
    public function lista(){
        $filtro = null;
        return  view('historico_indic.listagem',compact('filtro'));
    }
    public function filtro(Historico_indicRequest $request,$data=null){
        //dd($request);
        if(!is_null($request->data_inicial)){
            $data_inicial = $request->data_inicial;
            $data_final = $request->data_final;
            $periodicidades = Periodicidade::all();
            $users = User::all();
            $processos = Processo::all();
            //$historicos = historico_indic::all();
            $historicos = DB::table('historico_indic')
            ->join('users', 'users.id', '=', 'historico_indic.user_id')
            ->join('periodicidades', 'periodicidades.id', '=', 'historico_indic.periodicidade_id')
            ->join('processos', 'processos.id', '=', 'historico_indic.processo_id')        
            ->select(DB::raw("historico_indic.id as id, processos.id as processo_id,processos.nome as processo_nome,historico_indic.data_informada as data_informada,
                            users.email as user_id, historico_indic.ultima_data as ultima_data, historico_indic.data_meta as data_meta,
                            periodicidades.nome as periodicidade_id, historico_indic.status as status" ))
            ->paginate(15);
            $historicos->appends(Input::except('page'));
            $filtro = count($historicos);  
            return view('historico_indic.listagem',compact('historicos','periodicidades','processos','users','filtro','data_inicial','data_final'));
        }else{
            $filtro = null;
            return  view('historico_indic.listagem',compact('filtro'));
        }    
    }

    public function remove($id,$data_inicial=null,$data_final=null){
        dd($data_inicial);
        $historico = historico_indic::find($id);
        $historico->delete();
        //return redirect()->action('Historico_indicController@filtro');
        $data=['data_inicial' =>$data_inicial,
               'data_final' => $data_final];
        return redirect()->route('hist.filtro',$data);
    }
 
    public function salvaAlt(Historico_indicRequest $request){
        $id = $request->id;
        historico_indic::whereId($id)->update($request->except('_token','data_inicial','data_final'));
        //return redirect()->action('Historico_indicController@lista')->withInput(Request::only('nome'));
        $filtro = null;
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        //return  view('historico_indic.listagem',compact('filtro','data_inicial','data_final')); 
        //return redirect()->action('Historico_indicController@lista')->withInput(Request::only('nome'));
        $data=['data_inicial' =>$data_inicial,
               'data_final' => $data_final];
        return redirect()->route('hist.filtro',$data);
        //return redirect()->action('Historico_indicController@lista')->with($data); //->withInput(Request::only('nome'/*,'filtro','data_inicial','data_final'*/));
    }

    public function adiciona(Historico_indicRequest $request){
        //dd($request->data_informada);
        $usuario_id= Auth::user()->id;
        $historicos = DB::table('responsavels') 
        ->join ('processos','responsavels.id_processo','=','processos.id')
        ->join ('periodicidades','periodicidades.id','=','processos.periodicidade')
        ->join ('users','users.id','=','responsavels.usuario')
        ->join ('tipos','tipos.id','=', 'processos.tipo')
        ->leftjoin (DB::raw('(select  id_processo, data_conciliada from atividades where hora_fim is null) atividades'),function($join){$join->on('atividades.id_processo', '=', 'processos.id');}) 
        ->leftjoin (DB::raw("(select id_processo, max(data_conciliada) ultima_data from conclusoes where data_conciliada <= '".$request->data_informada."' group by id_processo) conclusoes"),function($join){$join->on('conclusoes.id_processo','=','processos.id');})
        ->where('users.id','=',$usuario_id) 
        ->select(DB::raw("distinct processos.id as processo_id, '$request->data_informada' data_informada, users.id user_id, 
        ultima_data, FLOAT_DIAS_UTEIS('$request->data_informada',periodicidades.dias) data_meta, 
        periodicidades.id periodicidade_id, 
        (CASE WHEN ultima_data >= FLOAT_DIAS_UTEIS('$request->data_informada',periodicidades.dias) then 'No Prazo' else 'Em Atraso' end) as status
        "))
        ->get();
        //dd($historicos);
        foreach ($historicos as $historicos2) {
            historico_indic::create([
                'processo_id' => $historicos2->processo_id,
                'data_informada' => $historicos2->data_informada,
                'user_id' => $historicos2->user_id,
                'ultima_data' => $historicos2->ultima_data,
                'data_meta' => $historicos2->data_meta,
                'periodicidade_id' => $historicos2->periodicidade_id,
                'status' => $historicos2->status,
            ]);
         }
            //dd($historicos);
            //return  view('historico_indic.listagem',compact('filtro'));
            $filtro = null;
            $data_inicial = $request->data_inicial;
            $data_final = $request->data_final;
            //return  view('historico_indic.listagem',compact('filtro','data_inicial','data_final')); 
            //return redirect()->action('Historico_indicController@lista')->withInput(Request::only('nome'));
            $data=['data_inicial' =>$data_inicial,
                   'data_final' => $data_final];
            //dd($data);
            return redirect()->route('hist.filtro',$data);
        //return redirect()->action('Historico_indicController@lista');
    }

}