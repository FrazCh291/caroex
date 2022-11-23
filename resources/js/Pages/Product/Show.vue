<template>
    <admin-layout>
        <section class="invoice-view-wrapper pb-3" style="background-color:#F2F4F4; height: auto">
            <div>
                <h4 class="card-title report-title pt-2">Quantity Report</h4>


            </div>
            <div class="row">
                <div class="col-xl-9 col-md-8 col-12 pl-3 my-0">
                    <div class="card invoice-print-area h-100 chart">
                        <div class="card-body pb-0 mx-25 chart-body">
                            <div id="chart_div"></div>
                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                <inertia-link :href="route('products.index')" class="btn btn-light-secondary mr-1 "
                                              type="button">
                                    Back
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                <div class="col-xl-3 col-md-4 col-12">-->
                <!--                    <div class="row">-->
                <!--                        <div class="col-xl-12 col-md-12 col-12">-->
                <!--                            <div class="card invoice-action-wrapper shadow-none border mr-2 sales-detail">-->
                <!--                                <div class="card-body my-0">-->
                <!--                                    <div class="invoice-action-btn text mt-2">-->
                <!--                                        <div class="table-responsive">-->
                <!--                                            <table cellpadding="10" cellspacing="30">-->
                <!--                                                <thead>-->
                <!--                                                <tr>-->
                <!--                                                    <th scope="col" class="small text-truncate font-weight-bolder">-->
                <!--                                                        Per Month-->
                <!--                                                    </th>-->
                <!--                                                    <th scope="col" class="small text-truncate font-weight-bolder">Per-->
                <!--                                                        Day Avg-->
                <!--                                                    </th>-->
                <!--                                                    <th scope="col" class="small text-truncate font-weight-bolder">Per-->
                <!--                                                        Month sold-->
                <!--                                                    </th>-->
                <!--                                                </tr>-->
                <!--                                                </thead>-->
                <!--                                                <tbody>-->
                <!--                                                <tr>-->
                <!--                                                    <th scope="row" class="small text-truncate">Sales Last 1M</th>-->
                <!--                                                    <td class="small text-center">{{-->
                <!--                                                            (products.last_month_count / 30).toFixed(1)-->
                <!--                                                        }}-->
                <!--                                                    </td>-->
                <!--                                                    <td class="small text-center">{{-->
                <!--                                                            '(' + (products.last_month_count) + ')'-->
                <!--                                                        }}-->
                <!--                                                    </td>-->
                <!--                                                </tr>-->
                <!--                                                <tr>-->
                <!--                                                    <th scope="row" class="small text-truncate">Sales Last 2M</th>-->
                <!--                                                    <td class="small text-center">{{-->
                <!--                                                            (products.last_two_month_count / 60).toFixed(1)-->
                <!--                                                        }}-->
                <!--                                                    </td>-->
                <!--                                                    <td class="small text-center">{{-->
                <!--                                                            '(' + products.last_two_month_count + ')'-->
                <!--                                                        }}-->
                <!--                                                    </td>-->
                <!--                                                </tr>-->
                <!--                                                <tr>-->
                <!--                                                    <th scope="row" class="small text-truncate">Sales Last 3M</th>-->
                <!--                                                    <td class="small text-center">{{-->
                <!--                                                            (products.last_three_month_count / 90).toFixed(1)-->
                <!--                                                        }}-->
                <!--                                                    </td>-->
                <!--                                                    <td class="small text-center">-->
                <!--                                                        {{-->
                <!--                                                            '(' + products.last_three_month_count + ')'-->
                <!--                                                        }}-->
                <!--                                                    </td>-->
                <!--                                                </tr>-->
                <!--                                                </tbody>-->
                <!--                                            </table>-->
                <!--                                        </div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="col-xl-12 col-md-12 col-12">-->
                <!--                            <div class="card invoice-action-wrapper shadow-none border mr-2 stock-detail">-->
                <!--                                <div class="card-body my-1">-->
                <!--                                    <div class="invoice-action-btn text mt-1">-->
                <!--                                        <div class="table-responsive">-->
                <!--                                            <table cellpadding="">-->
                <!--                                                <tbody>-->
                <!--                                                <tr class="badge badge-light-success mb-1">-->
                <!--                                                    <div class="d-flex justify-content-between">-->
                <!--                                                        <div class="">-->
                <!--                                                            <small class="small text-truncate font-weight-bolder">-->
                <!--                                                                Opening Stock</small>-->
                <!--                                                        </div>-->
                <!--                                                        <div class="">-->
                <!--                                                            <small class="stock small" v-if="totalStock[0]">-->
                <!--                                                                {{-->
                <!--                                                                    totalStock[0] + '(' +-->
                <!--                                                                    formatDate(stockDate.created_at) + ')'-->
                <!--                                                                }}-->
                <!--                                                            </small>-->
                <!--                                                            <small class="stock-items" v-else>-->
                <!--                                                                {{ 0 + '(' + 0 + ')' }}-->
                <!--                                                            </small>-->
                <!--                                                        </div>-->
                <!--                                                    </div>-->
                <!--                                                </tr>-->
                <!--                                                <tr class="badge badge-light-warning mb-1">-->
                <!--                                                    <div class="d-flex justify-content-between"-->
                <!--                                                         id="color">-->
                <!--                                                        <div class="">-->
                <!--                                                            <small class="small text-truncate font-weight-bolder">-->
                <!--                                                                Closing Stock</small>-->
                <!--                                                        </div>-->
                <!--                                                        <div class="">-->
                <!--                                                            <small class=" closing-stock small mr-0"-->
                <!--                                                                   v-if="closingStock">{{-->
                <!--                                                                    closingStock + '(' + closingStockDate + ')'-->
                <!--                                                                }}</small>-->
                <!--                                                            <small class="closing-stock-item" v-else>-->
                <!--                                                                {{ 0 + '(' + 0 + ')' }}-->
                <!--                                                            </small>-->
                <!--                                                        </div>-->
                <!--                                                    </div>-->
                <!--                                                </tr>-->
                <!--                                                <tr class="badge badge-light-danger mb-1">-->
                <!--                                                    <div class="d-flex justify-content-between">-->
                <!--                                                        <div>-->
                <!--                                                            <small class="small text-truncate font-weight-bolder">-->
                <!--                                                                Predictive Stock</small>-->
                <!--                                                        </div>-->
                <!--                                                        <div class="">-->
                <!--                                                            <small class="predictive-stock small mr-0" >-->
                <!--                                                                {{-->
                <!--                                                                    0 + '(' + date + ')'-->
                <!--                                                                }}-->
                <!--                                                            </small>-->
                <!--                                                        </div>-->
                <!--                                                    </div>-->
                <!--                                                </tr>-->
                <!--                                                </tbody>-->
                <!--                                            </table>-->
                <!--                                        </div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
        </section>
    </admin-layout>
</template>

<script>

import Chart from "../Chart";
import AdminLayout from "../../Layouts/AdminLayout";
import moment from 'moment';

export default {
    name: "Show.vue",
    // props: {
    //     chart: Object,
    //     products: Array,
    //     totalStock: Array,
    //     params: Object,
    //     closingStock: Array,
    //     closingStockDate: '',
    //     date: '',
    //     sum: '',
    //     stockDate: Object
    // },
    props: [
        "chartData"
    ],

    components: {
        AdminLayout,
        Chart,
    },
    data() {
        return {
            // query: {
            //     query: '',
            //     lastmonth: false,
            //     lastTwoMonth: false,
            //     lastThreeMont: false,
            //     chart: false,
            //     totalStock: false,
            //     direction: null
            // },
            // chart: '',
            chartDataArray: []
        }
    },
    beforeMount() {
        this.chartData.forEach((value) => {
            this.chartDataArray.push([new Date(value[0], value[1], value[2]), value[3]]);
        });
        document.title = process.env.MIX_APP_NAME + " - Product Show";
    },
    mounted() {
        google.charts.load('current', {'packages': ['line', 'corechart']});
        google.charts.setOnLoadCallback(this.drawChart);
        if (this.params) {
            let params = Object.keys(this.params);
            for (let i of params) {
                Object.assign(this.query, {[i]: this.params[i]});
            }
        }
    },
    methods: {
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Dates');
            data.addColumn('number', "Quantity");
            data.addRows(this.chartDataArray);

            var classicOptions = {
                chart: {
                    title: 'Average Temperatures and Daylight in Iceland Throughout the Year'
                },
                width: 900,
                height: 500,
                series: {
                    // Gives each series an axis name that matches the Y-axis below.
                    0: {axis: 'Dates'},
                    1: {axis: 'Quantity'}
                },
                axes: {
                    // Adds labels to each axis; they don't have to match the axis names.
                    y: {
                        Sales: {label: 'Quantity'},
                        Daylight: {label: 'Daylight'}
                    }
                },
                hAxis: {
                    title: 'Dates',
                    format: 'd MMM'
                },
                vAxis: {
                    title: 'Quantity',
                }
            };

            var classicChart = new google.visualization.LineChart(document.getElementById('chart_div'));
            classicChart.draw(data, classicOptions);
        }
    }
}
</script>

<style scoped>

.stock {
    margin-left: 105px;
}

.closing-stock {
    margin-left: 112px;
}

.predictive-stock {
    margin-left: 95px;
}

.closing-stock-item {
    margin-left: 110px;
}

.stock-items {
    margin-left: 110px;
}

.report-title {
    margin-left: 30px !important;
}

@media (max-width: 766px) {
    .sales-detail {
        width: 350px !important;
        height: auto !important;
        margin-left: 160px;
        margin-top: 30px;
    }

    .stock-detail {
        width: 350px !important;
        height: 240px !important;
        margin-left: 160px;
    }

    .chart {
        margin-right: 30px;
    }
}

@media (max-width: 700px) {
    .sales-detail {
        width: 355px !important;
        height: auto !important;
        margin-left: 130px;
        margin-top: 30px;
    }

    .stock-detail {
        width: 355px !important;
        height: auto !important;
        margin-left: 130px;
    }
}

@media (max-width: 650px) {
    .sales-detail {
        width: 350px !important;
        height: auto !important;
        margin-left: 115px;
        margin-top: 30px;
    }

    .stock-detail {
        width: 350px !important;
        height: auto !important;
        margin-left: 115px;
    }
}

@media (max-width: 600px) {
    .sales-detail {
        width: 350px !important;
        height: auto !important;
        margin-left: 80px;
        margin-top: 30px;
    }

    .stock-detail {
        width: 350px !important;
        height: auto !important;
        margin-left: 80px;
    }
}

@media (max-width: 550px) {
    .sales-detail {
        width: 350px !important;
        height: auto !important;
        margin-left: 55px;
        margin-top: 30px;
    }

    .stock-detail {
        width: 350px !important;
        height: auto !important;
        margin-left: 55px;
    }
}

@media (max-width: 500px) {
    .sales-detail {
        width: 350px !important;
        height: auto !important;
        margin-left: 43px;
        margin-top: 30px;
    }

    .stock-detail {
        width: 350px !important;
        height: auto !important;
        margin-left: 43px;
    }
}

@media (max-width: 480px) {
    .sales-detail {
        width: 350px !important;
        height: auto !important;
        margin-left: 34px;
        margin-top: 30px;
    }

    .stock-detail {
        width: 350px !important;
        height: auto !important;
        margin-left: 34px;
    }
}

@media (max-width: 425px) {
    .sales-detail {
        width: 300px !important;
        height: auto !important;
        margin-left: 31px;
        margin-top: 30px;
    }

    .stock-detail {
        width: 300px !important;
        height: auto !important;
        margin-left: 31px;
    }

    .chart-body {
        width: 320px !important;
    }
}
</style>
