@extends('layout.principal')

@section('conteudo')

<script>

/*
canvas.onclick = function(e) {
  var activePoints = myBarChart.getBarsAtEvent(e), // returns array of bars underneath pointer
      mouse_position = chart.helpers.getRelativePosition(e), // tells us the x/y of the mouse relative to the chart

  // Now filter the array to return just a single bar chart by computing the rectangle of the bar and checking whether the mouse pointer is inside it
  activePoints = $.grep(activePoints, function(activePoint, index) {
    var halfWidth = activePoint.width / 2, 
      leftX = activePoint.x - halfWidth, 
      rightX = activePoint.x + halfWidth, 
      top = activePoint.base - (activePoint.base - activePoint.y), 
      halfStroke = activePoint.strokeWidth / 2; 

    if (activePoint.showStroke) { 
      leftX += halfStroke; 
      rightX -= halfStroke; 
      top += halfStroke; 
    }

    return mouse_position.x >= leftX && mouse_position.x <=rightX && mouse_position.y >= top && mouse_position.y <= activePoint.base;
  });

  // activePoints[0] now contains just the bar you clicked!
};*/

function dadosBanco(callback) {$.ajax({
        method: 'GET',
        url: 'chartjsData',
        success: callback,
        error: function (error) {
        }
    })
}

function dadosBanco(callback) {$.ajax({
        method: 'GET',
        url: 'chartjsData',
        success: callback,
        error: function (error) {
        }
    })
}

function filtrar(dados,argumento,argumento2){
            var data2 = new Array();
            dados.forEach(function(entry) {
                if(entry.parentID==argumento && entry.parentID2==argumento2) {
                    data2.push(entry);
                };
            });
            return { data2: data2} 
        }

$(function () {
    $('#button').hide(); 
    dadosBanco(function(data){
        var parent = new Array()
        var parent2 = new Array()
        var tempo = new Array();
        var usuarios = new Array();
        //var novaData = filtrar(data,'ricardo_vargas');
        parent.push('');
        parent2.push('');
        var novaData = filtrar(data,'','');
       // console.log(novaData);
        novaData.data2.forEach(function(entry) {
            tempo.push(entry.val);
            usuarios.push(entry.arg);
        });
////
        //console.log(usuarios);
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: usuarios,
                datasets: [{
                    label: 'Tempos',
                    data: tempo,
                    backgroundColor: '#ADFF2F',//[
                        //'rgba(255, 99, 132, 0.2)',
                        //'rgba(54, 162, 235, 0.2)',
                        //'rgba(255, 206, 86, 0.2)',
                       // 'rgba(75, 192, 192, 0.2)',
                      //  'rgba(153, 102, 255, 0.2)',
                        //'rgba(255, 159, 64, 0.2)'
                    //],
                   /* borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],*/
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                            xAxes: [{
                                stacked: false,
                                beginAtZero: true,
                                scaleLabel: {
                                    labelString: 'Month'
                                },
                                ticks: {
                                    stepSize: 1,
                                    min: 0,
                                    autoSkip: false
                                }
                            }]
                        }
                /*scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }*/
            }
        });

////
        document.getElementById("myChart").onclick = function(evt)
        {   
            var activePoints = myChart.getElementsAtEvent(evt);

            if(activePoints.length > 0) {
            //get the internal index of slice in pie chart
                var clickedElementindex = activePoints[0]["_index"];

            //get specific label by index 
                var label = myChart.data.labels[clickedElementindex];

            //get value by index      
                var value = myChart.data.datasets[0].data[clickedElementindex];
                if(parent.length==2){
                    parent.push(label);
                    if(parent.length>0){
                        $('#button').show();
                        //console.log(parent[parent.length-1]);
                    }
                    //console.log("Label-1 :"+parent[parent.length-1])
                    //console.log("Label2 :"+label)
                    var novaData = filtrar(data,parent[parent.length-2],label);
                    tempo.length=0;
                    usuarios.length=0;
                    novaData.data2.forEach(function(entry) {
                        tempo.push(entry.val);
                        usuarios.push(entry.arg);
                    });
                    myChart.update();
                    //document.getElementById("nome_usuario").innerHTML = parent[parent.length - 2];
                    document.getElementById("data").innerHTML = parent[parent.length - 1];
                }
                if(parent.length==1){
                    parent.push(label);
                    if(parent.length>0){
                        $('#button').show();
                        //console.log(parent.length);
                    }
                    //console.log("Label :"+label)
                    var novaData = filtrar(data,label,'');
                    tempo.length=0;
                    usuarios.length=0;
                    novaData.data2.forEach(function(entry) {
                        tempo.push(entry.val);
                        usuarios.push(entry.arg);
                    });
                    myChart.update();
                    document.getElementById("nome_usuario").innerHTML = parent[parent.length - 1];
                }
        }
        }
        function voltar() {
            if(parent.length==2){
            
                parent.length=parent.length-1;
                //console.log("NIV 2");
               // console.log(parent);
                var novaData = filtrar(data,parent[parent.length - 1] ,'');
                tempo.length=0;
                usuarios.length=0;
                novaData.data2.forEach(function(entry) {
                    tempo.push(entry.val);
                    usuarios.push(entry.arg);
                });
                myChart.update();
                if(parent.length<=1){
                    $('#button').hide(); 
                }
                document.getElementById("nome_usuario").innerHTML = "";
            } 
            if(parent.length==3){
                parent.length=parent.length-1;
                //console.log("NIV 3");
                //console.log(parent);
                var novaData = filtrar(data,parent[parent.length - 1] ,'');
                tempo.length=0;
                usuarios.length=0;

                novaData.data2.forEach(function(entry) {
                    tempo.push(entry.val);
                    usuarios.push(entry.arg);
                });
                myChart.update();
                document.getElementById("data").innerHTML = parent[parent.length - 2];
                }           
        };
        document.getElementById("button").onclick = function() {voltar()};
    });
});

</script>

<div id = "nome_usuario"></div>
<div id = "data"> </div>
    <div class="canvas-container">
        <canvas id="myChart"></canvas>
        <button class = "btn waves-effect light-green accent-3" id='button'>Voltar</button> 
    </div>
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

@endsection