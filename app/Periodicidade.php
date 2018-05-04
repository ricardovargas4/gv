<?php

namespace gv;

use Illuminate\Database\Eloquent\Model;

class Periodicidade extends Model
{
    
    protected $table = 'periodicidades';
    public $timestamps = true;
    protected $fillable = array('nome','dias','uteis');

    public function processos(){
        return $this->hasMany('gv\Processo');
    }

}
