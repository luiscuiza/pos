
window.byStep = true;

function updateChart(data) {
    const ctx = document.getElementById('line-chart').getContext('2d');

    const maxSales = Math.max(...data.valores);
    const minSales = Math.min(...data.valores);
    let stepSize = Math.ceil((maxSales-minSales) / data.valores.length);
    stepSize = stepSize == 0 ? maxSales : stepSize;
    
    if (window.saleChart) {
        window.saleChart.destroy();
    }

    if(window.byStep) {
        window.ticksOption = {
            stepSize: stepSize,
            fontColor: '#efefef',
        }
    } else {
        window.ticksOption = {
            fontColor: '#efefef',
            callback: function(value, index, values) {
                const specificTicks = data.valores;
                return specificTicks.includes(value) ? value : null;
            }
        }
    }

    window.saleChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.leyenda,
            datasets: [{
                data: data.valores,
                label: '',
                fill: false,
                spanGaps: true,
                pointRadius: 3,
                lineTension: 0,
                borderWidth: 2,
                pointHoverRadius: 7,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: '#efefef'
                    },
                    gridLines: {
                        display: false,
                        color: '#efefef',
                        drawBorder: false
                    }
                }],
                yAxes: [{
                    ticks: window.ticksOption,
                    gridLines: {
                        display: true,
                        color: '#efefef',
                        drawBorder: false
                    }
                }]
            }
        }
    });
}

function processData(range, data) {
    let valores = [];
    let leyenda = [];

    if (range) {
        let acumuladoPorDia = {};
        data.forEach(item => {
            let fechaObj = new Date(item.fecha);
            let fechaDia = fechaObj.toISOString().split('T')[0];
            if (acumuladoPorDia[fechaDia]) {
                acumuladoPorDia[fechaDia] += parseFloat(item.total);
            } else {
                acumuladoPorDia[fechaDia] = parseFloat(item.total);
            }
        });
        for (let dia in acumuladoPorDia) {
            leyenda.push(dia);
            valores.push(acumuladoPorDia[dia]);
        }
    } else {
        let acumuladoPorHora = {};
        data.forEach(item => {
            let fechaObj = new Date(item.fecha);
            let hora = fechaObj.getHours();
            if (acumuladoPorHora[hora]) {
                acumuladoPorHora[hora] += parseFloat(item.total);
            } else {
                acumuladoPorHora[hora] = parseFloat(item.total);
            }
        });
        for (let hora in acumuladoPorHora) {
            leyenda.push(hora + ":00");
            valores.push(acumuladoPorHora[hora]);
        }
    }
    return {
        'valores': valores,
        'leyenda': leyenda
    };
}

function fetchSalesData(start, end) {
    const fromDate = start.format('YYYY-MM-DD');
    const toDate = end.format('YYYY-MM-DD');
    let rangeDay = true;
    if(fromDate === toDate) {
        rangeDay = false;
        $('#reportrange span').html(start.format('DD-MM-YYYY'));
    } else {
        $('#reportrange span').html(start.format('DD-MM-YYYY') + ' &nbsp;&nbsp;&nbsp; ' + end.format('DD-MM-YYYY'));
    }
    $.ajax({
        url: '/sales/data',
        type: 'POST',
        dataType: "json",
        contentType: 'application/json',
        data: JSON.stringify({
            fromDate: fromDate, 
            toDate: toDate
        }),
        success: function(response) {
            if(response.success) {
                dataSales = processData(rangeDay, response.data)
                updateChart(dataSales);
            }
        },
        error: function(error) {
            console.error("Error al obtener los datos:", error);
        }
    });
}

$(document).ready(function() {

    const start = moment().startOf('month');
    const end = moment().endOf('month');

    fetchSalesData(start, end);

    $('#daterange-btn').daterangepicker({
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
            'Este Mes': [moment().startOf('month'), moment().endOf('month')],
            'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: start,
        endDate: end
    }, function(start, end) {
        fetchSalesData(start, end);
    });

});
