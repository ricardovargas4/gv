<?php

namespace gv;

use Illuminate\Database\Eloquent\Model;

class processo extends Model
{
    protected $table = 'processos';
    public $timestamps = true;
    protected $fillable = array('nome', 'tipo', 'periodicidade', 'pasta', 'coordenacao');

    public function tipo(){
        return $this->belongsTo('gv\Tipo');
    }
    public function periodicidade(){
        return $this->belongsTo('gv\Periodicidade');
    }
    public function coordenacao(){
        return $this->belongsTo('gv\Coordenacao');
    }
    public function responsavel(){
        return $this->hasMany('gv\responsavel');
    }
    public function atividades(){
        return $this->hasMany('gv\Atividade');
    }
    public function historico_indic(){
        return $this->hasMany('gv\historico_indic');
    }
}
