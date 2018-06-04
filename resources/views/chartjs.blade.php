@extends('layout.principal')

@section('conteudo')
<script src="/js/graficoTempo.js"></script>  

<div class = "container">
    <div class="form-group col s6">
    <form action="/relatorio/tempo" method="post">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <label>Data Inicial</label>
        <input type="date"  name="data_inicial" class="form-control" @if(isset($data_inicial)) value="{{{$data_inicial}}}" @else value = "{{{date('Y-m-d', strtotime('-15 day', strtotime(date('Y-m-d'))))}}}" @endif placeholder="dd/mm/aaaa"/>
        <label>Data Final</label>
        <input type="date" name="data_final" class="form-control" @if(isset($data_final)) value="{{{$data_final}}}" @else value = "{{{date('Y-m-d')}}}" @endif placeholder="dd/mm/aaaa"/>
        <button type="submit" class="btn waves-effect light-green accent-3"> Filtrar</button>
    </form>
 </div>   
</div>

<div id = "nome_usuario"></div>
<div id = "data"> </div>
    <div class="canvas-container">
        <canvas id="myChart"></canvas>
        <button class = "btn waves-effect light-green accent-3" id='button'>Voltar</button> 
    </div>


@endsection