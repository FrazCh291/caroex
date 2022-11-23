<template>
 <div id="chart">
   <apexchart type="donut" width="90" :options="DonutchartOptionsone" :series="Donutseriesone"></apexchart>
</div>
    
</template>
<script>

export default {
    name: "DonutChart",
    props: ['donatChartType'],
    
        data() {
          var $info = this.donatChartType;
          if(this.donatChartType === 'estimatedArrivalDateDonutData') {
            $warning = '#FDAC41';
          }
            if(this.donatChartType === 'actualArrivalDateDonutData') {
               $secondary = '#009A17';
            }
            
            return {
              
            Donutseriesone: [70],
            labels: ["Installation", "Page Views", "Active Users"],
            DonutchartOptionsone: {
              chart: {
                width: 380,
                type: 'donut',
                
              },
              dataLabels: {
                enabled: false
              },
              responsive: [{
                breakpoint: 480,
                
                options: {
                  chart: {
                    width: 200
                  },
                  legend: {
                    show: false
                  }
                }
              }],
              legend: {
                position: 'right',
                offsetY: 0,
                height: 230,
              
                },
                  stroke: {
                    width: 0
                  },
                  colors: [$info],
                  plotOptions: {
                    pie: {
                      donut: {
                        size: '80%',
                      }
                    }
                  },
                  legend: {
                    show: false
                  }
                },
          }
          
        },
        beforeMount() {
            document.title = process.env.MIX_APP_NAME + " - shipments";
        },

 
}
</script>