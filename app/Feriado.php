<?php

namespace gv;

use Illuminate\Database\Eloquent\Model;

class Feriado extends Model
{
    protected $table = 'feriados';
    public $timestamps = true;
    protected $fillable = array('feriado_data');

}
