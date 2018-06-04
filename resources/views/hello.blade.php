<html>
  <head>
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">-->
    <link href="/lib/materialize/dist/css/materialize.css" rel="stylesheet">
    <!--<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
    <script type="text/javascript" src="\lib\jquery\dist\jquery.min.js"></script>    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>-->
    <script src="\lib\materialize\dist\js\materialize.min.js"></script> 
  </head>
  <body>
      <a class='dropdown-button btn' href='#' data-activates='dropdown1'>Drop Me!</a>

      <!-- Dropdown Structure -->
      <ul id='dropdown1' class='dropdown-content'>
        <li><a href="#!">one</a></li>
        <li><a href="#!">two</a></li>
        <li class="divider"></li>
        <li><a href="#!">three</a></li>
      </ul>

      <script>
        $(document).ready(function() {
          $('.dropdown-button').dropdown({
              hover: true
            }
          );    
        });
      </script>
  </body>
</html>