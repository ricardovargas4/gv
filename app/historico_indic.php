<?php

namespace gv;

use Illuminate\Database\Eloquent\Model;

class historico_indic extends Model
{
    protected $table = 'historico_indic';
    public $timestamps = true;
    protected $fillable = array('processo_id','data_informada','user_id','ultima_data','data_meta', 'periodicidade_id','status');

    public function periodiciade_id(){
        return $this->belongsTo('gv\Periodicidade');
    }
    public function processo_id(){
        return $this->belongsTo('gv\processo');
    }
    public function user_id(){
        return $this->belongsTo('gv\User');
    }
}


