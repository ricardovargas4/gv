
$(function () {
    var data = teste(function(data){
        /*var data = "02/01/2015";
        var hora = "10:00:00";
        var d = new Date(hora);
        d.getTime();*/
        
        data.forEach(function(entry) {
            //console.log(moment(entry.val).format('HH:mm'));
            //console.log(moment(entry.val,"HH:mm"));
            //console.log(moment().hour(entry.val));
            //console.log(entry.val);
            entry.teste = secondsToTime(entry.val);
            console.log(entry.teste);
        });
        
       // console.log(data[1].parentID); 
         
        var isFirstLevel = true,
        chartContainer = $("#chart"),
        chart = chartContainer.dxChart({
            dataSource: filterData("",data),
            title: "Tempos",
            series: {
                type: "bar"
            },
            legend: {
                visible: true
            },
            valueAxis: {
                showZero: true
            },
            onPointClick: function (e) {
                if (isFirstLevel) {
                    isFirstLevel = false;
                    removePointerCursor(chartContainer);
                    chart.option({
                        dataSource: filterData(e.target.originalArgument,data)
                    });
                    $("#backButton")
                        .dxButton("instance")
                        .option("visible", true);
                }
            },
            customizePoint: function () {
                var pointSettings = {
                    color: colors[Number(isFirstLevel)]
                };

                if (!isFirstLevel) {
                    pointSettings.hoverStyle = {
                        hatching: "none"
                    };
                }

                return pointSettings;
            }
        }).dxChart("instance");

    $("#backButton").dxButton({
        text: "Back",
        icon: "chevronleft",
        visible: false,
        onClick: function () {
            if (!isFirstLevel) {
                isFirstLevel = true;
                addPointerCursor(chartContainer);
                chart.option("dataSource", filterData("",data));
                this.option("visible", false);
            }
        }
    });

    addPointerCursor(chartContainer);
});

function filterData(name,data) {
    //console.log(data);
    return data.filter(function (item) {
        return item.parentID === name;
    });
}

function addPointerCursor(container) {
    container.addClass("pointer-on-bars");
}

function removePointerCursor(container) {
    container.removeClass("pointer-on-bars");
}



});

   

var colors = ["#6babac", "#e55253"];


function teste(callback) {$.ajax({
        method: 'GET',
        url: 'chartjsData',
        success: callback/*function (data) {
            //console.log(data);
            return data;
            //$('#data').html(JSON.stringify(data));
        }*/,
        error: function (error) {
            //console.log($viewer);
            //$('#data').html(JSON.stringify(error.message));
        }
    })
}

/*
var data = [
    { arg: "Africa", val: 381331438, parentID: "" },
    { arg: "Nigeria", val: 181562056, parentID: "Africa" }
]
console.log(data);
*/

function secondsToTime(secs)
{
    var hours = Math.floor(secs / (60 * 60));

    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);

    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);

    var obj = {
        "h": hours,
        "m": minutes,
        "s": seconds
    };
    return obj;
}


;

