<template>
 <div id="chart">
    <apexchart type="radialBar" height="220" :options="RedialchartOptions" :series="Redialseries"></apexchart>
</div>
    
</template>
<script>

export default {
    name: "RadialBars",
    
        data() {
            var $primary = '#5A8DEE';
            var $danger = '#FF5B5C';
            var $warning = '#FDAC41';
            var $info = '#00CFDD';
            var $secondary = '#828D99';
            var $secondary_light = '#e7edf3';
            var $light_primary = "#E2ECFF";
            return {

           Redialseries: [75, 80, 85],
           RedialchartOptions: {
            chart: {
                height: 210,
                type: "radialBar",
            },
             colors: [$primary, $danger, $warning],
              series: [30, 20, 10],
              plotOptions: {
                radialBar: {
                  offsetY: -10,
                  hollow: {
                    size: "40%"
                  },
                  track: {
                    margin: 10,
                    background: '#fff',
                  },
                  dataLabels: {
                    name: {
                      fontSize: '15px',
                      colors: [$secondary],
                      fontFamily: "IBM Plex Sans",
                      offsetY: 25,
                    },
                    value: {
                      fontSize: '30px',
                      fontFamily: "Rubik",
                      offsetY: -15,
                    },
                    total: {
                      show: true,
                      label: 'Total',
                      fontSize: '15px',
                      fontWeight: 400,
                      fontFamily: "IBM Plex Sans",
                      color: $secondary,
                      formatter: function (w) {
                      // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                      return 249
                    }
                    }
                  }
                }
              },
                  
                    labels: ['Target', 'Mart', 'Ebay']
                    
            },
          }
          
        },

 
}
</script>