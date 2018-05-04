
<html>
<head>
    <link href="/css/app.css" rel="stylesheet">
    <link href="/lib/materialize/dist/css/materialize.css" rel="stylesheet">
    <link href="/css/font-awesome.css" rel="stylesheet">
    <link href="/css/tabletr.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="/js/validacao.js"></script>

    <title>Gestão à Vista</title>
</head>
<body>
  <div class="container">

<!-- Dropdown Structure -->
<ul id="dropdownProcesso" class="dropdown-content">
<li><a href="/processo/novo">Novo</a></li>
<li class="divider"></li>
<li><a href="/processo/">Listagem</a></li>
</ul>

<ul id="dropdownAtividade" class="dropdown-content">
<li><a href="/atividade/novo">Novo</a></li>
<li class="divider"></li>
<li><a href="/atividade/">Listagem</a></li>
</ul>


<ul id="dropdownTipo" class="dropdown-content">
<li><a href="/tipo/novo">Novo</a></li>
<li class="divider"></li>
<li><a href="/tipo/">Listagem</a></li>
</ul>

<ul id="dropdownPeriodicidade" class="dropdown-content">
<li><a href="/periodicidade/novo">Novo</a></li>
<li class="divider"></li>
<li><a href="/periodicidade/">Listagem</a></li>
</ul>

<ul id="dropdownResponsavel" class="dropdown-content">
<li><a href="/responsavel/novo">Novo</a></li>
<li class="divider"></li>
<li><a href="/responsavel/">Listagem</a></li>
</ul>


<!-- Nav Structure -->

  <nav>
    <div class="nav-wrapper">
      <a class="brand-logo" href="/home">Gestão à Vista</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      @if (Auth::guest())
        <li><a href="/login">Login</a></li>
        <li><a href="/auth/register">Register</a></li>
      @else
        <li>{{ Auth::user()->name }} </li>
        <li><a href="/logout">Logout</a></li>
      @endif
        <!-- Dropdown Trigger -->
        <li><a class="dropdown-button" data-activates="dropdownProcesso">Processo<i class="material-icons right"><i class="fa fa-caret-down" aria-hidden="true"></i></i></a></li>
        <li><a class="dropdown-button" data-activates="dropdownAtividade">Atividade<i class="material-icons right"><i class="fa fa-caret-down" aria-hidden="true"></i></i></a></li>
        <li><a class="dropdown-button" data-activates="dropdownTipo">Tipo<i class="material-icons right"><i class="fa fa-caret-down" aria-hidden="true"></i></i></a></li>
        <li><a class="dropdown-button" data-activates="dropdownPeriodicidade">Periodicidade<i class="material-icons right"><i class="fa fa-caret-down" aria-hidden="true"></i></i></a></li>
        <li><a class="dropdown-button" data-activates="dropdownResponsavel">Responsável<i class="material-icons right"><i class="fa fa-caret-down" aria-hidden="true"></i></i></a></li>
      </ul>
    </div>
  </nav>


    @yield('conteudo')

  <footer class="footer">
      <p></p>
  </footer>

  </div>
</body>
<script type="text/javascript" src="\lib\jquery\dist\jquery.min.js"></script>           
<script src="\lib\materialize\dist\js\materialize.min.js"></script> 

</html>
