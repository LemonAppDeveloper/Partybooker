var ctx = document.getElementById("myChart4").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['12', '2', '3', '4', '5', '5', '7'],
        datasets: [/*{
            label: 'Total',
            backgroundColor: ["#fba6a3", "#fdc2a3", "#fae990", "#a884d3", "#82ec99", "#e3ac90", "#a884d3"],
            data: [987, 800, 700, 600, 475, 800, 450],
        },*/
        {
            label: 'New',
            backgroundColor: ["#f64d47", "#fb8547", "#f5d321", "#5108a7", "#04d833", "#c65920", "#5108a7"],
            data: [300, 250, 300, 40, 150, 120, 100],
        }],
    },


    options: {
        tooltips: {
            displayColors: true,
            callbacks:{
                mode: 'x',
            },
        },
        scales: {
            xAxes: [{
                categoryPercentage: 0.3,
                barPercentage: 0.3,
                stacked: true,
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                stacked: true,
                ticks: {
                    beginAtZero: true,
                },
                type: 'linear',
            }]
        },
        responsive: true,
        maintainAspectRatio: false,
        legend: { position: 'none' },
    }
});