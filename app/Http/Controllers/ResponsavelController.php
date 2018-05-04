<?php namespace gv\Http\Controllers;

use Illuminate\Support\Facades\DB;
use gv\Processo;
use gv\Http\Requests\ResponsavelRequest;
use Request;
use gv\Responsavel;
use gv\User;


class ResponsavelController extends Controller
{

    public function lista(){
        //$responsavels = Responsavel::all();
        $users = User::all();
        $processos = Processo::all();
        $resp = DB::table('responsavels')
        ->join('processos', 'responsavels.id_processo', '=', 'processos.id')
        ->join('users', 'users.id', '=', 'responsavels.usuario')
        ->select('responsavels.id','processos.nome', 'users.email')
        ->paginate(15);;
        //return view('responsavel.listagem',compact('responsavels'));
        return view('responsavel.listagem',compact('resp','users','processos'));
    }

    public function remove($id){
        $responsavel = Responsavel::find($id);
        $responsavel->delete();
        return redirect()->action('ResponsavelController@lista');
    }

    public function altera($id){
        $responsavel = Responsavel::find($id);
        $users = User::all();
        $processos = Processo::all();
        return view('responsavel.formulario_alteracao',compact('responsavel','users','processos'));
    }
    public function salvaAlt(ResponsavelRequest $request){
        $id = $request->id;
        Responsavel::whereId($id)->update($request->except('_token'));
        return redirect()->action('ResponsavelController@lista')->withInput(Request::only('usuario'));
    }


    public function novo(){
        $users = User::all();
        $processos = Processo::all();
        return view('responsavel.formulario',compact('users','processos'));
    }   

    public function adiciona(ResponsavelRequest $request){
        Responsavel::create($request->all());
        return redirect()->action('ResponsavelController@lista')->withInput(Request::only('usuario'));
    }

}
