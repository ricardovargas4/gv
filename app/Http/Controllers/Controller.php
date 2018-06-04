<?php

namespace gv\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   
    public function tempo(){
    
        return view('relatorios/tempo');
       // $coordenacaos = null;
       // return view('coordenacao.listagem')->with('coordenacaos', $coordenacaos);
    }



}
