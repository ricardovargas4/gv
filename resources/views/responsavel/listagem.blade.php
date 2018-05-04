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
                                <form action="/responsavel/adiciona" method="post">
                                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                    
                                    <div class="form-group col s6">
                                        <label for="id_processo">Nome Processo</label>
                                        <select name="id_processo" class="form-control">
                                            <option value="" disabled selected>Selecione o Processo</option>
                                            @foreach($processos as $p)
                                                <option value="{{$p->id}}">{{$p->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col s6">
                                        <label for="usuario">Usuários</label>
                                        <select name="usuario" class="form-control">
                                            <option value="" disabled selected>Selecione o usuário</option>
                                            @foreach($users as $u)
                                                <option value="{{$u->id}}">{{$u->email}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn waves-effect light-green accent-3"> Salvar</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                    <table class="bordered">
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Processo </th>
                                <th> Usuário </th>
                                <td> Alterar/Excluir </td>
                            </tr>
                        </thead>
                          <tbody>
                          @foreach ($resp as $r)
                            <tr>
                                <td scope="row">{{$r->id}}</td>
                                <td> {{$r->nome}} </td>
                                <td> {{$r->email}} </td>
                                <td>
                                    <div class="row">
                                        <a class="waves-effect waves-light btn green accent-3  modal-trigger" href="#modal1{{$r->id}}">Editar</a>
                                        <div id="modal1{{$r->id}}" class="modal">
                                            <div class="modal-content">
                                                <form action="/responsavel/salvaAlt" method="post">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="id" value="{{{ $r->id }}}" />
                                                    <!--<input type="hidden" name="_method" value="put">-->
                                                    <div class="form-group col s6">
                                                        <label for="id_processo">Nome Processo</label>
                                                        <select name="id_processo" class="form-control" value="{{{ $r->nome }}}">
                                                              @foreach($processos as $p)
                                                                <option value="{{$p->id}}">{{$p->nome}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group col s6">
                                                        <label for="usuario">Usuários</label>
                                                        <select name="usuario" class="form-control" value="{{{ $r->email }}}">
                                                            @foreach($users as $u)
                                                                <option value="{{$u->id}}">{{$u->email}}</opt ion>
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
                                        <a class="waves-effect waves-light btn red accent-4" href="javascript:(confirm('Deletar esse registro?') ? window.location.href='{{action('ResponsavelController@remove', $r->id)}}' : false)">Deletar</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            {{ $resp->links() }}
                        </tbody>
                    </table>
                </div>   
            </div>
        </div>
    </div>
</div>

@stop
