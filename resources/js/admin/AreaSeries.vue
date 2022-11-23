<template>
 <div id="chart">
    <apexchart type="area" height="250" :options="AreachartOptions" :series="Areaseries"></apexchart>
</div>
    
</template>
<script>

export default {
    name: "AreaSeries",
    props: ["dateRange","chartData","month"],
    
        data() {
            var $primary = '#5A8DEE';
            var $light_primary = "#E2ECFF";
            return {
                
        Areaseries: [{
        name: this.month,
        data: this.chartData,
        type: 'area',
      }],
      
      tooltip: {
        x: { show: false }
      },
     AreachartOptions: {
       chart: {
              type: 'area',
              height: 270,
             stacked: false,
              zoom: {
                enabled: false
              },
                toolbar: {
                show: false,
              }, 
              sparkline: {
              enabled: true
              },
        },
         dataLabels: {
              enabled: false
            },
            xaxis: {
            offsetY: -40,
            categories: this.dateRange,
            axisBorder: {
              show: false,
            },
            axisTicks: {
              show: false,
            },
          
            labels: {
              show: true,
              
            }
          },

           stroke: {
            curve: 'smooth',
            width: 2.5,
            dashArray: [0, 8]
          },
          fill: {
            type: 'gradient',
            gradient: {
              inverseColors: false,
              shade: 'light',
              type: "vertical",
              gradientToColors: [$light_primary, $primary],
              opacityFrom: 0.7,
              opacityTo: 0.55,
              stops: [0, 80, 100]
            }
          },  
      },
      colors: [$primary, $primary],
      dataLabels: {
        enabled: false
      },
       }
          
        },

 
}
</script>
