<?php

namespace gv\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use gv\Processo;
use gv\Conclusao;
use gv\Http\Requests\AtividadeRequest;
use Request;
use Auth;
use gv\Atividade;
use gv\User;
use Carbon\Carbon;

class AtividadeController extends Controller
{
    public function home(){
       
        //echo date ( 'Y-m-j' , strtotime ( '4 weekdays' ) );
        
        //$responsavels = Responsavel::all();
        $aberta = DB::table('atividades')
        ->where('atividades.usuario','=',Auth::user()->id)
        ->where('atividades.hora_fim','=',null)
        ->get();

        $usuario_id= Auth::user()->id;
        
        $atividades = DB::table('responsavels')
        ->join('processos', 'responsavels.id_processo', '=', 'processos.id')
        ->join('periodicidades', 'periodicidades.id', '=', 'processos.periodicidade')
        ->join('users', 'users.id', '=', 'responsavels.usuario')
        ->join('tipos', 'tipos.id', '=', 'processos.tipo')
        ->leftjoin(DB::raw('(select id_processo, data_conciliada from atividades where hora_fim is null) atividades'), function($join) {$join->on('atividades.id_processo', '=', 'processos.id'); })
        ->leftjoin(DB::raw('(select id_processo, max(data_conciliada) ultima_data from conclusoes group by id_processo) conclusoes'), function($join) {$join->on('conclusoes.id_processo', '=', 'processos.id'); })
        ->where('users.id','=',$usuario_id)
        ->select(DB::raw("distinct processos.id as processoId, processos.nome as processoNome, tipos.id as tipoId, tipos.nome as tipoNome, atividades.data_conciliada,FLOAT_DIAS_UTEIS(now(),periodicidades.dias) data_meta, (CASE WHEN atividades.id_processo is not null then 'aberta' else '' end) as hora_fim, conclusoes.ultima_data"))
        ->get();
        //dd($atividades);
        return view('atividade.telaAtividades',compact('atividades','usuario_id','aberta'));

    }


    public function iniciar(AtividadeRequest $request){
        Atividade::create(['id_processo'=>$request->id_processo[$request->submit],
                            'usuario'=> Auth::user()->id,
                            //'data_conciliacao'=>$request->data_conciliacao[$request->submit],
                            'data_conciliacao'=>date('Y-m-d H:i:s'),
                            'hora_inicio'=>date('Y-m-d H:i:s'),
                            'data_meta'=>$request->data_meta[$request->submit],
                            'data_conciliada'=>$request->data_conciliada[$request->submit],
                            'ultima_data'=>$request->ultima_data[$request->submit]]);
        return redirect()->action('AtividadeController@home');
    }
            
    public function parar(AtividadeRequest $request){
        $aberta = DB::table('atividades')
        ->where('atividades.usuario','=',Auth::user()->id)
        ->where('atividades.hora_fim','=',null)
        ->where('atividades.id_processo','=',$request->id_processo[substr($request->submit,1,10)])
        ->first();
        $opcao = substr($request->submit,0,1);
        //dd($opcao);
        if( ! empty($request['tolerancia'])){
            $data_conciliacao = DB::table(DB::raw('DUAL'))->select(DB::raw("FLOAT_DIAS_UTEIS(now(),-1) data"))->first([DB::raw(1)]);
            $data_conciliacao = $data_conciliacao->data;
        }else{
            $data_conciliacao = date('Y-m-d H:i:s');
        }
        //dd($data_conciliacao);
        if($opcao =='C'){
            Conclusao::create(['id_processo'=>$request->id_processo[substr($request->submit,1,10)],
                               'data_conciliada'=>$request->data_conciliada[substr($request->submit,1,10)],
                               'data_conciliacao'=>$data_conciliacao]);
                               //date('Y-m-d',strtotime($data_conciliacao))
                               //'data_conciliacao'=>date('Y-m-d H:i:s')]);
        }
        $atividade = Atividade::find($aberta->id);
        
        $atividade->hora_fim = date('Y-m-d H:i:s');
        
        $atividade->save();
        
        return redirect()->action('AtividadeController@home');
    }
    public function lista(){
        $filtro = null;
        return  view('atividade.listagem',compact('filtro'));
    }
    public function filtro(AtividadeRequest $request,$data=null){
        //dd($request->data_inicial);
        if(!is_null($request->data_inicial)){
            $data_inicial = $request->data_inicial;
            $data_final = $request->data_final;
            $usuario =  Auth::user()->id;
            $processos = Processo::all();
            $users = User::all();
            $atividades = DB::table('atividades')
            ->join('processos', 'processos.id', '=', 'atividades.id_processo')
            ->join('users', 'users.id', '=', 'atividades.usuario')
            ->select(DB::raw("atividades.id as id, processos.id as processo_ID, processos.nome as processo_Nome, 
                            users.id as user_Id, users.email as user_Email,atividades.data_conciliacao, atividades.hora_inicio,
                            atividades.hora_fim, atividades.data_meta,data_conciliada,ultima_data" ))
           // ->where('users.id','=',$usuario)
            ->where('atividades.hora_inicio','>=',$request->data_inicial)
            ->where('atividades.hora_fim','<=',$request->data_final)
            ->orderBy('hora_inicio', 'ASC')
            ->paginate(15);
            $atividades->appends(Input::except('page'));
            $filtro = count($atividades);
            return  view('atividade.listagem',compact('atividades','users','processos','usuario','filtro','data_inicial','data_final'));
        }
        else{
            $filtro = null;
            return  view('atividade.listagem',compact('filtro'));
        }
        /*view('atividade.listagem')->with('atividades', $atividades);*/
    }
    
    public function remove($id,$data_inicial=null,$data_final=null){
        $atividade = Atividade::find($id);
        $atividade->delete();
        $filtro = null;
        $data=['data_inicial' =>$data_inicial,
        'data_final' => $data_final];
        //return  view('atividade.listagem',compact('filtro'));
        return redirect()->route('atividade.filtro',$data);   
    }
    
   /* public function altera($id){
        $atividade = Atividade::find($id);
        $processos = Processo::all();
        $users = User::all();
        return view('atividade.formulario_alteracao',compact('atividade','users','processos'));
    }
    */
    public function salvaAlt(AtividadeRequest $request){
        
        $id = $request->id;
        Atividade::whereId($id)->update($request->except('_token','data_inicial','data_final'));
        //return redirect()->action('AtividadeController@lista')->withInput(Request::only('nome'));
        $filtro = null;
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        //return  view('atividade.listagem',compact('filtro','data_inicial','data_final')); 
        $data=['data_inicial' =>$data_inicial,
               'data_final' => $data_final];
        return redirect()->route('atividade.filtro',$data);  
    }
    /*
    public function novo(){
        $processos = Processo::all();
        $users = User::all();

        return view('atividade.formulario',compact('processos','users'));
    }   
    */
    public function adiciona(AtividadeRequest $request){

        Atividade::create($request->all());
        $filtro = null;
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        //return  view('atividade.listagem',compact('filtro','data_inicial','data_final')); 
        $data=['data_inicial' =>$data_inicial,
               'data_final' => $data_final];
        return redirect()->route('atividade.filtro',$data);  
        //return redirect()->action('AtividadeController@lista')->withInput(Request::only('nome'));
    }    
}
