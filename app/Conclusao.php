<?php

namespace gv;

use Illuminate\Database\Eloquent\Model;

class conclusao extends Model
{
    protected $table = 'conclusoes';
    public $timestamps = true;
    protected $fillable = array('id_processo','data_conciliada','data_conciliacao');

    public function processos(){
        return $this->hasMany('gv\Processo');
    }

}
