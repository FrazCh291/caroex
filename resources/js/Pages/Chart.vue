<template>
    <div class="py-0 chart">
        <div class="py-12">
            <div class="max-w-7xl my-auto mx-auto sm:px-0 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="vue-apexcharts">
                            <apexchart :width="$page.props.chart.original.options.chart.width"
                                       :height="$page.props.chart.original.options.chart.height"
                                       :type="$page.props.chart.original.options.chart.type"
                                       :options="$page.props.chart.original.options"
                                       :series="$page.props.chart.original.options.series">

                            </apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Chart",
    components: {},
    beforeMount() {

    },
    mounted() {

    }
}

</script>
<style>
/*.chart {*/
/*    background-color: #F2F4F4;*/
/*}*/
</style>
