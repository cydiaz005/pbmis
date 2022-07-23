class ChartBuilder{
   
    title;
    canvas;
    type;
    data;
    chart;
    scales;


    
    constructor(config){
        this.canvas =  ('canvas' in config)? config.canvas:null;
        this.type = ('type' in config)?  config.type:'bar';
        this.title = ('title' in config)?  config.title: '';
        this.data = ('data' in config)? 
        config.data: {labels: [],datasets: []};

        this.scales = ('scales' in config)?  config.scales: {};

        // this.data = {labels: [],datasets: []}

        console.log(config);
        this.render();
    }
  
    render(){
        this.chart = new Chart(this.canvas, {
            type: this.type,
            data: this.data,
            options: {
                title:{
                    display:true,
                    text: this.title
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                responsive: true,
                scales: this.scales
            }
        });
    }

    refresh(){
        this.chart.update();
    }
    color(index){
        let schemes = ['rgb(189 139 192 / 80%)', 'rgb(243 173 184 / 80%)', 'rgb(133 74 168 / 80%)', 'rgb(250 195 175 / 80%) ', 'rgb(65 50 126 / 80%) ', 'rgb(243 133 164 / 80%)', 'rgb(82 63 158 / 80%)', 'rgb(223 183 252 / 80%)', 'rgb(100 64 136 / 80%)', 'rgb(255 166 172 / 80%) ', 'rgb(116 101 177 / 80%)', ' rgb(243 149 167 / 80%)', 'rgb(147 127 190 / 80%)', 'rgb(109 91 151 / 80%)', ' rgb(235 154 185 / 80%)', 'rgb(199 132 235 / 80%)', 'rgb(151 139 196 / 80%)', 'rgb(221 118 158 / 80%) '];
        return schemes[index];
    }
    reset(){
        this.chart.update();
    }


}