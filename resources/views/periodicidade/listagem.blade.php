@extends('layout.principal')

@section('conteudo')
<br>

<div class="card demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid cad_card">
        <div class="card-content">
            <div class="row">
                <div class="container">
                    <ul class="collapsible" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header">
                                <i class="fa fa-plus-square-o fa-sm"></i>Adicionar
                            </div>
                            <div class="collapsible-body">
                                <form action="/periodicidade/adiciona" method="post">
                                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

                                    <div class="form-group col s6">
                                        <label for="nome">Nome</label>
                                        <input name="nome" class="form-control"/>
                                    </div>
                                    <div class="form-group col s6">
                                        <label for="dias">Nº Dias</label>
                                        <input type = "number" name="dias" class="form-control"/>
                                    </div>
                                    <label>Úteis</label> 
                                    <select name="uteis"  class="form-control">
                                      <option value="S">Sim</option>
                                      <option value="N">Não</option>
                                    </select>

                                    <button type="submit" class="btn waves-effect light-green accent-3"> Salvar</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                    <table class="bordered">
                        <thead>
                            <tr>
                                <th>ID </th>
                                <th>Nome </th>
                                <td> Alterar/Excluir </td>
                            </tr>
                        </thead>
                          <tbody>
                          @foreach ($periodicidades as $p)
                            <tr>
                                <td scope="row">{{$p->id}}</td>
                                <td> {{$p->nome}} </td>
                                <td>
                                    <div class="row">
                                        <a class="waves-effect waves-light btn green accent-3  modal-trigger" href="#modal1{{$p->id}}">Editar</a>
                                        <div id="modal1{{$p->id}}" class="modal">
                                            <div class="modal-content">
                                                <form action="/periodicidade/salvaAlt" method="post">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="id" value="{{{ $p->id }}}" />
                                                    <!--<input type="hidden" name="_method" value="put">-->
                                                    <div class="form-group col s6">
                                                      <label for="nome">Nome</label>
                                                      <input name="nome" class="form-control" value="{{$p->nome}}"/>
                                                    </div>
                                                    <div class="form-group col s6">
                                                      <label for="dias">Nº Dias</label>
                                                      <input type = "number" name="dias" class="form-control"  value="{{$p->dias}}"/>
                                                    </div>
                                                    <label>Úteis</label> 
                                                    <select name="uteis"  class="form-control" value="{{$p->uteis}}">
                                                      <option value="S">Sim</option>
                                                      <option value="N">Não</option>
                                                    </select>
                                                    <button type="submit" class="waves-effect waves-light btn green accent-3 ">Atualizar</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
                                            </div>
                                        </div>
                                        <a class="waves-effect waves-light btn red accent-4" href="javascript:(confirm('Deletar esse registro?') ? window.location.href='{{action('PeriodicidadeController@remove', $p->id)}}' : false)">Deletar</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
            
                        </tbody>
                    </table>
                    {{ $periodicidades->links() }}
                </div>   
            </div>
        </div>
    </div>
</div>

@stop
