$( document ).ready(function() {
    graficas();
});

function graficas() {
    function generateRandomData(length, startValue) {
        let data = [];
        let value = startValue;
        for (let i = 0; i < length; i++) {
            value += Math.floor(Math.random() * 20) - 10; // Incremento aleatorio entre -10 y 10
            data.push(value);
        }
        return data;
    }

    var areaChartData = {
        labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
            {
                label               : 'Digital Goods',
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius         : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : generateRandomData(7, 50) // Datos aleatorios incrementales
            },
            {
                label               : 'Electronics',
                backgroundColor     : 'rgba(210, 214, 222, 1)',
                borderColor         : 'rgba(210, 214, 222, 1)',
                pointRadius         : false,
                pointColor          : 'rgba(210, 214, 222, 1)',
                pointStrokeColor    : '#c1c7d1',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data                : generateRandomData(7, 100) // Datos aleatorios incrementales
            },
        ]
    };

    var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines : {
                    display : false,
                }
            }],
            yAxes: [{
                gridLines : {
                    display : false,
                }
            }]
        }
    };

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0)?.getContext('2d');
    if (lineChartCanvas) {
        var lineChartOptions = $.extend(true, {}, areaChartOptions);
        var lineChartData = $.extend(true, {}, areaChartData);
        lineChartData.datasets[0].fill = false;
        lineChartData.datasets[1].fill = false;
        lineChartOptions.datasetFill = false;

        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        });

        // Actualiza los datos cada 2 segundos
        setInterval(function() {
            lineChartData.datasets.forEach(dataset => {
                dataset.data = generateRandomData(7, 50); // Genera nuevos datos aleatorios
            });
            lineChart.update(); // Actualiza el gráfico
        }, 2000);
    } else {
        console.error('El elemento canvas con id "lineChart" no se encontró.');
    }

    //-------------
    //- BAR CHART -
    //--------------
    var barChartCanvas = $('#barChart').get(0)?.getContext('2d');
    if (barChartCanvas) {
        var barChartData = $.extend(true, {}, areaChartData);
        var temp0 = areaChartData.datasets[0];
        var temp1 = areaChartData.datasets[1];
        barChartData.datasets[0] = temp1;
        barChartData.datasets[1] = temp0;

        var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        };

        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });

        // Actualiza los datos cada 2 segundos
        setInterval(function() {
            barChartData.datasets.forEach(dataset => {
                dataset.data = generateRandomData(7, 50); // Genera nuevos datos aleatorios
            });
            barChart.update(); // Actualiza el gráfico
        }, 2000);
    } else {
        console.error('El elemento canvas con id "barChart" no se encontró.');
    }
}