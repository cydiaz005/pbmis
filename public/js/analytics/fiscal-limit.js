var chartData = {
    labels: ["January", "February", "March"],
    datasets: [{
        label: 'Dataset 1',
        backgroundColor: window.chartColors.red,
        data: [
            100,1000,500
        ]
    }, {
        label: 'Dataset 2',
        backgroundColor: window.chartColors.blue,
        data: [
            100,800,300
        ]
    }, {
        label: 'Dataset 3',
        backgroundColor: window.chartColors.green,
        data: [
            100,600,300
           
        ]
    }]

    

};



var ctx = $('.canvas');
let fiscal_chart = new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: {
        title:{
            display:true,
            text:"Disagreggation of Budget"
        },
        tooltips: {
            mode: 'index',
            intersect: false
        },
        responsive: true,
        scales: {
            xAxes: [{
                stacked: true,
            }],
            yAxes: [{
                stacked: true
            }]
        }
    }
});

var ctx = $('.canvas2');
let fiscal_chart2 = new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: {
        title:{
            display:true,
            text:"Disagreggation of Budget"
        },
        tooltips: {
            mode: 'index',
            intersect: false
        },
        responsive: true,
        scales: {
            xAxes: [{
                stacked: false,
            }],
            yAxes: [{
                stacked: false
            }]
        }
    }
});

// document.getElementById('randomizeData').addEventListener('click', function() {
//     chartData.datasets.forEach(function(dataset, i) {
//         dataset.data = dataset.data.map(function() {
//             return randomScalingFactor();
//         });
//     });
//     window.myBar.update();
// });