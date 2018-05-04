@extends('layout.principal')

@section('conteudo')
<br>
<div class="container">
    <div class="form-group col s6">
    <form action="/historico_indic/filtro" method="post">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <label>Data Inicial</label>
        <input type="date"  name="data_inicial" class="form-control" @if(isset($data_inicial)) value="{{{$data_inicial}}}" @else value = "{{{date('Y-m-d', strtotime('-15 day', strtotime(date('Y-m-d'))))}}}" @endif placeholder="dd/mm/aaaa"/>
        <label>Data Final</label>
        <input type="date" name="data_final" class="form-control" @if(isset($data_final)) value="{{{$data_final}}}" @else value = "{{{date('Y-m-d')}}}" @endif placeholder="dd/mm/aaaa"/>
        <button type="submit" class="btn waves-effect light-green accent-3"> Filtrar</button>
    </form>
    </div>
</div>
@if (!isset($filtro))
<div class="container">
    Selecione uma range de datas.
</div>    
@elseif($filtro==0)
<div class="container">
    Sem dados para o período selecionado.
</div>
@else
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
                                <form action="/historico_indic/adiciona" method="post">
                                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                    <input type="hidden" name="data_inicial" value="{{{$data_inicial}}}" />
                                    <input type="hidden" name="data_final" value="{{{$data_final}}}" />
                                    <div class="form-group col s6">
                                        <label for="data_informada">Data Informada</label>
                                        <input type = "date" name="data_informada" class="form-control"/>
                                    </div>
                                    <button type="submit" class="btn waves-effect light-green accent-3"> Salvar</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                    <table class="bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Processo</th>
                                <th>Data</th>
                                <th>Usuário</th>
                                <th>Última Data</th>
                                <th>Data Meta</th>
                                <th>Periodicidade</th>
                                <th>Status</th>
                                <th> Excluir </th>
                            </tr>
                        </thead>
                          <tbody>
                          @foreach ($historicos as $h)
                            <tr>
                                <td scope="row">{{$h->id}}</td>
                                <td> {{$h->processo_nome}} </td>
                                <td> {{$h->data_informada}} </td>
                                <td> {{$h->user_id}} </td>
                                <td> {{$h->ultima_data}} </td>
                                <td> {{$h->data_meta}} </td>
                                <td> {{$h->periodicidade_id}} </td>
                                <td> {{$h->status}} </td>
                                <td>
                                    <div class="row">
                                        <a class="waves-effect waves-light btn green accent-3  modal-trigger" href="#modal1{{$h->id}}">Editar</a>
                                        <div id="modal1{{$h->id}}" class="modal">
                                            <div class="modal-content">
                                                <form action="/historico_indic/salvaAlt" method="post">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="id" value="{{{ $h->id }}}" />
                                                
                                                <input type="hidden" name="data_inicial" value="{{{$data_inicial}}}" />
                                                <input type="hidden" name="data_final" value="{{{$data_final}}}" />
                                                <div class="form-group col s6">
                                                    <label for="processo_id">Nome Processo</label>
                                                    <select name="processo_id" class="form-control">
                                                        <option value="{{{ $h->processo_id }}}" disabled selected>{{{$h->processo_nome}}}</option>
                                                            @foreach($processos as $p)
                                                                <option value="{{$p->id}}">{{$p->nome}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col s6">
                                                    <label>Data Informada</label>
                                                    <input type="date" name="data_informada" class="form-control" placeholder="dd/mm/aaaa" value="{{$h->data_informada}}"/>
                                                </div>
                                                <div class="form-group col s6">
                                                    <label for="user_id">Usuários</label>
                                                    <select name="user_id" class="form-control" value="{{{ $h->user_id }}}">
                                                        @foreach($users as $u)
                                                            <option value="{{$u->id}}">{{$u->email}}</opt ion>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group col s6">
                                                    <label>Última Data</label>
                                                    <input name="ultima_data" class="form-control" placeholder="Última Data" value="{{$h->ultima_data}}"/>
                                                </div>       

                                                <div class="form-group col s6">
                                                    <label>Data Meta</label>
                                                    <input name="data_meta" class="form-control" placeholder="Data Meta" value="{{$h->data_meta}}"/>
                                                </div>       

                                                <div class="form-group col s6">
                                                        <label for="periodicidade_id">Tipo</label>
                                                        <select name="periodicidade_id" class="form-control" value="{{{ $h->periodicidade_id }}}">
                                                        @foreach($periodicidades as $p)
                                                            <option value="{{$p->id}}">{{$p->nome}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                    <button type="submit" class="waves-effect waves-light btn green accent-3 ">Atualizar</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
                                            </div>
                                        </div>
                                        <a class="waves-effect waves-light btn red accent-4" href="javascript:(confirm('Deletar esse registro?') ? window.location.href='{{action('Historico_indicController@remove', [$h->id,$data_inicial, $data_final])}}' : false)">Deletar</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
            
                        </tbody>
                    </table>
                    {{ $historicos->links() }}
                </div>   
            </div>
        </div>
    </div>
</div>
@endif
@stop
