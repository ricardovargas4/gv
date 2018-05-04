@extends('layout.principal')

@section('conteudo')
<div class="container">
@if (count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<h1>Atividades</h1>
  @if ($aberta->isEmpty())
    <form name='TabAtividades' action="/atividade/iniciar" method="post"> 
  @else
    <form name='TabAtividades' action="/atividade/parar" method="post">
  @endif
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <input type="hidden" name="usuario" value="{{{ $usuario_id }}}" />      
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <td> Tipo </td>
          <td> Nome Processo </td>
          <td> Data Meta </td>
          <td> Data Ultima Atualização </td>
          <td> Data Conciliada </td>
          <td> Ação </td>               
        <tr>
      </thead>
      <tbody>
        @foreach ($atividades as $index => $a)
          <tr>
              <td> {{$a->tipoNome}} <input type="hidden" name="tipoId[]" value="{{{ $a->tipoId }}}" /> </td>
              <td> {{$a->processoNome}} <input type="hidden" name="id_processo[]" value="{{{ $a->processoId }}}" /> </td>
              <td> <input type="date" name="data_meta[]" value="{{{ $a->data_meta }}}" readonly/> </td>
              <td> <input type=date name="ultima_data[]" value="{{{ $a->ultima_data }}}" readonly/> </td>
              <td> <input type=date name="data_conciliada[]" value="{{{ $a->data_conciliada }}}" <?php if (!$aberta->isEmpty()){ ?> readonly <?php   } ?>/> </td>
              @if (($a->hora_fim)=="aberta")
                <td>  
                  <button id='P{{{ $a->processoId }}}' type="submit" class="waves-effect waves-light btn" name="submit" value="P{{{ $index }}}">
                    <i class="fa fa-pause" aria-hidden="true"></i>
                  </button>
                  <button id='C{{{ $a->processoId }}}' type="submit" class="waves-effect waves-light btn" name="submit" value="C{{{ $index }}}">
                    <i class="fa fa-stop" aria-hidden="true"></i>
                  </button>   
                  <div>
                    <input type="checkbox" name = "tolerancia[]" id="checkTolerancia" />
                    <label for="checkTolerancia">Atividade Concluída na Tolerância</label>
                  </div>
                </td>
              @else
                <td>  <button id='{{{ $a->processoId }}}' type="submit" class="waves-effect waves-light btn" <?php if (!$aberta->isEmpty()){ ?> disabled <?php   } ?>  name="submit" value="{{{ $index }}}"> 
                        <i class="fa fa-play" aria-hidden="true"></i>
                      </button> </td>
              @endif
            </tr>
        @endforeach
      </tbody>
    </table>
  </form>
</div>  
@stop
