<?php

namespace gv;

use Illuminate\Database\Eloquent\Model;

class responsavel extends Model
{
    protected $table = 'responsavels';
    public $timestamps = true;
    protected $fillable = array('id', 'id_processo', 'usuario');

    public function id_processo(){
        return $this->belongsTo('gv\processo');
    }
    public function usuario(){
        return $this->belongsTo('gv\User');
    }
    
}