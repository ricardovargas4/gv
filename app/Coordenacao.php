<?php

namespace gv;

use Illuminate\Database\Eloquent\Model;

class Coordenacao extends Model
{
    protected $table = 'coordenacaos';
    public $timestamps = true;
    protected $fillable = array('nome');

    public function processos(){
        return $this->hasMany('gv\Processo');
    }

}
