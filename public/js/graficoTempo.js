
function dadosBanco(callback) {$.ajax({
        method: 'GET',
        url: '/dados/tempo',
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
        parent.push('');
        parent2.push('');
        var novaData = filtrar(data,'','');
        novaData.data2.forEach(function(entry) {
            tempo.push(entry.val);
            usuarios.push(entry.arg);
        });

        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: usuarios,
                datasets: [{
                    label: 'Tempos',
                    data: tempo,
                    backgroundColor: '#ADFF2F',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                            xAxes: [{
                                stacked: false,
                                beginAtZero: true, 
                                suggestedMin: 0,
                                scaleLabel: {
                                    labelString: 'Month'
                                },
                                ticks: {
                                    stepSize: 1,
                                    min: 0,
                                    autoSkip: false
                                }
                            }],
                            yAxes: [{
                                beginAtZero: true, 
                                suggestedMin: 0,
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
            }
        });

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
                    document.getElementById("data").innerHTML = parent[parent.length - 1];
                }
                if(parent.length==1){
                    parent.push(label);
                    if(parent.length>0){
                        $('#button').show();
                      }
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
