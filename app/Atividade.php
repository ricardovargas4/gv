<?php

namespace gv;

use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    protected $table = 'atividades';
    public $timestamps = true;
    protected $fillable = array('id_processo','usuario','data_conciliacao','hora_fim','data_meta',
                                'data_conciliada','ultima_data','coop','assunto','solicitante',
                                'obs','created_at','updated_at','hora_inicio');

    
    public function usuario(){
        return $this->belongsTo('gv\user');
    }
    public function id_processo(){
        return $this->belongsTo('gv\Processo');
    }
}


