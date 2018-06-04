<!DOCTYPE html>
<html>
<head>
    <link href="/lib/materialize/dist/css/materialize.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <script src="/js/Chart.js"></script>
    <!--<script src="/js/moment.min.js"></script>
    <script src="/js/moment-with-locales.js"></script>-->
    <script src="/js/Chart.min.js"></script>
    <script type="text/javascript" src="\lib\jquery\dist\jquery.min.js"></script>           
    <script src="\lib\materialize\dist\js\materialize.min.js"></script> 
    <script src="\js\init.js"></script>
    <script src="/js/validacao.js"></script>  


    <title>Gestão à Vista</title>
</head>
<body>
  <div class="navBar">

    <nav>
      <div class="nav-wrapper blue-grey darken-3">
        <div class="container">
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
            <ul id="dropdown1" class="dropdown-content">
              <li><a href="/processo/">Processos</a></li>
              <li><a href="/atividade/">Atividades</a></li>
              <li><a href="/tipo/">Tipos</a></li>
              <li><a href="/periodicidade/">Periodicidades</a></li>
              <li><a href="/responsavel/">Responsaveis</a></li>
              <li><a href="/coordenacao/">Coordenações</a></li>
              <li><a href="/historico_indic/">Histórico Indicadores</a></li>
              <!--<li class="divider"></li>-->
            </ul>

            <!-- Dropdown Trigger -->
            <li><a class='dropdown-button' href='#' data-activates='dropdown1'>Manutenção<i class="material-icons right">arrow_drop_down</i></a></li>
          </ul>
        </div>
      </div>
    </nav>
</div>
  <div id="container">
    @yield('conteudo')
  </div>

</body>
<!--
<div class = "footerteste">
      <footer class="page-footer light-green <accent-2></accent-2>" >
        <div class="container">
          <div class="row">
            <div class="col l6 s12">
              <h5 class="white-text">Confederação Sicredi</h5>
              <p class="grey-text text-lighten-4">Gestão à Vista.</p>
              <p>
                <a href="#"><i class="white-text mdi mdi-facebook mdi-24px"></i></a>
                <a href="#"><i class="white-text mdi mdi-twitter mdi-24px"></i></a>
                <a href="#"><i class="white-text mdi mdi-youtube-play mdi-24px"></i></a>
              </p>
            </div>
            <div class="col l4 offset-l2 s12">
              <h5 class="white-text">Links</h5>
              <ul>
                <li><a class="grey-text text-lighten-3" href="{{ url('/home') }}">Home</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="footer-copyright">
          <div class="container">
          © 2017 Copyright Text
          <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
-->



</html>
