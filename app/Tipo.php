<?php

namespace gv;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipos';
    public $timestamps = true;
    protected $fillable = array('nome');

    public function processos(){
        return $this->hasMany('gv\Processo');
    }

}
