<?php

namespace gv\Http\Controllers;
use View;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Http\Request;
use gv\Http\Requests\TempoRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts\app');
    }
    public function hello()
    {
        return view('hello');
    }

    
    public function chartjs() 
    {
        return view('chartjs');
    }


    public function dadosTempos()//(TempoRequest $request)
    {
        $data = DB::table('atividades')
        ->join('processos', 'atividades.id_processo', '=', 'processos.id')
        ->join('users', 'users.id', '=', 'atividades.usuario')
        ->select(DB::raw("users.email as arg, sum(TIMESTAMPDIFF(second,hora_inicio,hora_fim)/3600) as val, '' as parentID, '' as parentID2"))
        //->whereBetween('atividades.data_conciliacao', [$request->data_inicial, $request->data_final])
        ->groupby('arg')
        ->get();
        $data2 = DB::table('atividades')
        ->join('processos', 'atividades.id_processo', '=', 'processos.id')
        ->join('users', 'users.id', '=', 'atividades.usuario')
        ->select(DB::raw("atividades.data_conciliacao as arg, sum(TIMESTAMPDIFF(second,hora_inicio,hora_fim)/3600) as val, users.email as parentID, '' as parentID2"))
        //->whereBetween('atividades.data_conciliacao', [$request->data_inicial, $request->data_final])
        ->groupby('arg', 'parentID')
        ->get();
        
        $data3 = DB::table('atividades')
        ->join('processos', 'atividades.id_processo', '=', 'processos.id')
        ->join('users', 'users.id', '=', 'atividades.usuario')
        ->select(DB::raw("processos.nome as arg, sum(TIMESTAMPDIFF(second,hora_inicio,hora_fim)/3600) as val, users.email as parentID, atividades.data_conciliacao as parentID2 "))
        //->whereBetween('atividades.data_conciliacao', [$request->data_inicial, $request->data_final])
        ->groupby('arg', 'parentID', 'parentID2')
        ->orderby('val')
        ->get();
        foreach($data2 as $value){
            $data->push($value);
        }
        foreach($data3 as $value){
            $data->push($value);
        }
        
        //dd($data[10000]);
        return $data;
    }
}
