var ctx = document.getElementById("myChart4").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    /*data: {
        labels: ["0","1","2","3","4","5","6","7","8","9"],
        datasets: [{
            label: 'Average',
            backgroundColor: "#F64D47",
            data: [350, 250, 350, 50, 700,250, 75, 800, 30, 0],
        },
        {
            label: 'Peak',
            backgroundColor: "#5108A7",
            data: [550, 700, 0, 550, 0, 0, 325, 0, 270, 900],
        }],
    },*/


    data: {
        labels: vendor_statistics_label,
        datasets: [{
            label: 'Total',
            backgroundColor: vendor_statistics_color,
            data: vendor_statistics_data,
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