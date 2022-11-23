<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
            </div>
        </div>
        <div class="row pb-3" id="table-hover-row">
            <div class="col-12">
                <div class="card-one py-0 my-0 bg-white">
                    <div class="row pt-1 w-1/8 px-2">
                        <div class="col-12 col-md-3 form-group">
                            <label>Product *</label>
                            <select class="form-select" v-model="filter.product_id"
                                    placeholder="Name">
                                <option value="all">All</option>
                                <option v-for="product in products"
                                        :value="product.id">
                                    {{ product.name + ' (' + product.sku + ')' }}
                                </option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 form-group pl-md-1">
                            <label>Date From *</label>
                            <input type="date" class="form-control" :max="maxDate"
                                   placeholder="from" v-model="filter.date_from"
                                   v-if="filter.duration === 'custom_date'">
                            <input type="date" class="form-control"
                                   placeholder="from" v-model="filter.date_from" readonly v-else>
                        </div>
                        <div class="col-12 col-md-3 form-group pl-md-1">
                            <label>Date To *</label>
                            <input type="date" class="form-control" :min="this.filter.date_from" :max="maxDate"
                                   placeholder="To" v-model="filter.date_to" v-if="filter.duration==='custom_date'"
                                   id="dateTo">
                            <input type="date" class="form-control"
                                   placeholder="To" v-model="filter.date_to" v-else readonly>
                            <span class="hide" id="dateToError">The date_to field must be maximum 1 year.</span>
                        </div>
                        <div class="col-12 col-md-3 form-group">
                            <label>Duration *</label>
                            <select class="form-select" id="meny_sent_to" name="meny_sent_to"
                                    v-model="filter.duration" placeholder="Select" @change="getDate">
                                <option value="today">
                                    Today Date
                                </option>
                                <option value="last_week">Last Week</option>
                                <option value="last_month">
                                    Last Month
                                </option>
                                <option value="last_quarter">
                                    Last Quarter
                                </option>
                                <option value="last_year">
                                    Last Year
                                </option>
                                <option value="custom_date">
                                    Custom Date
                                </option>
                            </select>
                        </div>
                        <div class="col-12 col-md-12 form-group mt-1 mt-md-2 pl-0">
                            <div class="row report-action d-flex justify-content-end">
                                <button type="button" id="asc" @click="getData"
                                        v-if="filter.date_from && filter.date_to"
                                        class="btn btn-primary font-small font-weight-normal report-btn mr-1">
                                    Run Report
                                </button>
                                <button type="button" id="asc" v-else class="btn btn-primary font-small
                                        font-weight-normal report-btn mr-1" disabled="disabled">
                                    Run Report
                                </button>
                                <div class="btn-group pr-1" v-if="this.productStocks.data.length>0">
                                    <label class="btn btn-outline-secondary mb-0 pl-1 pr-1 active" id="tableButton"
                                           @click="highlightButton('tableButton')"><a id="option1">
                                        <i class="bx bx-table" title="table"></i></a>
                                    </label>
                                    <label class="btn btn-outline-secondary mb-0 pl-1 pr-1" id="graphButton"
                                           @click="highlightButton('graphButton')"><a id="option2">
                                        <i class="bx bx-line-chart-down" title="Graph"></i></a>
                                    </label>
                                    <label class="btn btn-outline-secondary mb-0 pl-1 pr-1" id="csvButton"
                                           @click="highlightButton('csvButton')"><a
                                        :href="route('stock.report.export.csv',filter)" id="option3">
                                        <i class="bx bxs-file" title="Csv"></i></a>
                                    </label>
                                    <label class="btn btn-outline-secondary mb-0 pl-1 pr-1" id="pdfButton"
                                           @click="highlightButton('pdfButton')"><a
                                        :href="route('stock.report.export.pdf',filter)" id="option4">
                                        <i class="bx bxs-file-pdf" title="PDF"></i></a>
                                    </label>
                                </div>
                                <div class="btn-group pr-1" v-else>
                                    <label class="btn btn-outline-secondary mb-0 pl-1 pr-1"><a disabled="disabled">
                                        <i class="bx bx-table"></i></a>
                                    </label>
                                    <label class="btn btn-outline-secondary mb-0 pl-1 pr-1"><a disabled="disabled">
                                        <i class="bx bx-line-chart-down"></i></a>
                                    </label>
                                    <label class="btn btn-outline-secondary mb-0 pl-1 pr-1"><a disabled="disabled">
                                        <i class="bx bxs-file"></i></a>
                                    </label>
                                    <label class="btn btn-outline-secondary mb-0 pl-1 pr-1"><a disabled="disabled">
                                        <i class="bx bxs-file-pdf"></i></a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" v-if="this.switchButton==='table'">
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive" v-if="this.productStocks.data.length > 0">
                            <table class="table table-borderless mb-0 small">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th class="text-right pr-3">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="productStock in productStocks.data">
                                    <td>
                                        <div class="row">
<!--                                            <div class="col-1 pr-0 mr-1">-->
                                                <!-- <img v-if="productStock.product.image !== null"
                                                     :src="'/'+productStock.product.image"
                                                     class="rounded-circle product-image" width="45" height="40">
                                                <img v-else src="products/empty.jpg" class="rounded-circle empty-image"
                                                     width="45" height="40"> -->
<!--                                            </div>-->
                                            <div class="col-9 py-1 px-1 mx-0">
                                                 {{ productStock.product?productStock.product.name:'' + ' ('+productStock.product?productStock.product.sku:'' +')' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pl-3">{{ productStock ? productStock.quantity : '' }}</td>
                                    <td class="text-right">{{ formatDate(productStock ? productStock.date : '') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-1" v-else>No Records.</div>
                    </div>
                </div>
            </div>
            <div class="col-12" v-if="this.productStocks.data.length > 0 && this.switchButton==='graph'">
                <div class="card">
                    <div class="card-content d-flex justify-content-center">
                        <div id="chart_div"></div>
                    </div>
                </div>
            </div>
            <div class="col-12" v-if="this.productStocks.data.length > 0 && this.switchButton==='table'">
                <pagination :links="productStocks.links" class="float-right"></pagination>
            </div>
        </div>
    </admin-layout>
</template>

<script>

import moment from 'moment';
import Button from "../../Jetstream/Button";
import Pagination from "../../admin/Pagination";
import AdminLayout from "../../Layouts/AdminLayout";
import DialogModal from "../../Jetstream/DialogModal";
import ErrorComponent from '../../components/ErrorComponent';

export default {
    props: [
        "params",
        "products",
        "productStocks",
        "dates",
        "chartData",
        "errors"
    ],
    name: "index",
    components: {
        DialogModal,
        Button,
        AdminLayout,
        Pagination,
        ErrorComponent
    },
    data() {
        return {
            grid_type: '',
            query: {
                query: '',
                id: false,
                supplier_name: false,
                address1: false,
                tel1: false,
                direction: null,
            },
            filter: {
                product_id: '',
                date_from: '',
                date_to: '',
                duration: '',
            },
            maxDate: this.dates.currentDate,
            switchButton: 'table',
            chartDataArray: []
        }
    },
    beforeMount() {
        console.log(this.productStocks, 'productS');
        document.title = process.env.MIX_APP_NAME + " - Reports";
        this.chartData.forEach((value) => {
            this.chartDataArray.push([new Date(value[0], value[1], value[2]), value[3]]);
        });

        if (this.params.length === 0) {
            this.filter.date_from = this.dates.lastWeekDate;
            this.filter.date_to = this.dates.currentDate;
            this.filter.duration = "last_week";
            this.filter.product_id = "all";
        }

    },
    mounted() {
        if (this.params) {
            if (this.params.product_id) {
                this.filter.product_id = this.params.product_id;
            }
            if (this.params.date_from) {
                this.filter.date_from = this.params.date_from;
            }
            if (this.params.date_to) {
                this.filter.date_to = this.params.date_to;
            }
            if (this.params.duration) {
                this.filter.duration = this.params.duration;
            }
        }
        return this.params;
    },
    methods: {
        resetQuery() {
            this.query = {}
            this.loadData()
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY');
        },
        yearCheck() {
            const [fromYear, fromMonth, fromDay] = this.filter.date_from.split('-');
            const [todayYear, todayMonth, todayDay] = this.filter.date_to.split('-')
            var datesDifference = moment([todayYear, todayMonth, todayDay]).diff(moment([fromYear, fromMonth,
                fromDay]), 'years', true);
            if (datesDifference <= 1) {
                return true;
            } else {
                return false;
            }
        },
        highlightButton(id) {
            if (id === 'tableButton') {
                document.getElementById("tableButton").classList.add("active");
                document.getElementById("graphButton").classList.remove("active");
                document.getElementById("csvButton").classList.remove("active");
                document.getElementById("pdfButton").classList.remove("active");
                this.switchButton = 'table';
            } else if (id === 'graphButton') {
                document.getElementById("tableButton").classList.remove("active");
                document.getElementById("graphButton").classList.add("active");
                document.getElementById("csvButton").classList.remove("active");
                document.getElementById("pdfButton").classList.remove("active");
                this.switchButton = 'graph';
                google.charts.load('current', {'packages': ['line', 'corechart']});
                google.charts.setOnLoadCallback(this.drawChart);
            } else if (id === 'csvButton') {
                document.getElementById("csvButton").classList.add("active");
                document.getElementById("pdfButton").classList.remove("active");
            } else {
                document.getElementById("csvButton").classList.remove("active");
                document.getElementById("pdfButton").classList.add("active");
            }
        },
        getDate() {
            var x = document.getElementById("meny_sent_to").value
            if (x === 'custom_date') {
                this.filter.date_from = this.dates.currentDate;
                this.filter.date_to = this.dates.currentDate;
            } else if (x === 'last_month') {
                this.filter.date_from = this.dates.lastMonthDate;
                this.filter.date_to = this.dates.currentDate;
            } else if (x === 'last_quarter') {
                this.filter.date_from = this.dates.lastQuarterDate;
                this.filter.date_to = this.dates.currentDate;
            } else if (x === 'last_year') {
                this.filter.date_from = this.dates.lastYearDate;
                this.filter.date_to = this.dates.currentDate;
            } else if (x === 'today') {
                this.filter.date_from = this.dates.currentDate;
                this.filter.date_to = this.dates.currentDate;
            } else {
                this.filter.date_from = this.dates.lastWeekDate;
                this.filter.date_to = this.dates.currentDate;
            }
        },
        getData() {
            if (this.yearCheck()) {
                document.getElementById("dateToError").classList.add("hide");
                document.getElementById("dateToError").classList.remove("show");
                let filter = {};
                if (this.filter.product_id) {
                    Object.assign(filter, {'product_id': this.filter.product_id})
                }
                if (this.filter.date_from) {
                    Object.assign(filter, {'date_from': this.filter.date_from})
                }
                if (this.filter.date_to) {
                    Object.assign(filter, {'date_to': this.filter.date_to})
                }
                if (this.filter.duration) {
                    Object.assign(filter, {'duration': this.filter.duration})
                }
                this.$inertia.visit(route('stock.report.create'), {
                    method: 'get',
                    data: {
                        ...filter
                    }
                });
            } else {
                document.getElementById("dateToError").classList.remove("hide");
                document.getElementById("dateToError").classList.add("show");
            }
        },
        drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Dates');
            data.addColumn('number', "Stocks");
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
                    1: {axis: 'Stocks'}
                },
                axes: {
                    // Adds labels to each axis; they don't have to match the axis names.
                    y: {
                        Sales: {label: 'Stocks'},
                        Daylight: {label: 'Daylight'}
                    }
                },
                hAxis: {
                    title: 'Dates',
                    format: 'd MMM'
                },
                vAxis: {
                    title: 'Stocks',
                }
            };

            var classicChart = new google.visualization.LineChart(document.getElementById('chart_div'));
            classicChart.draw(data, classicOptions);
        }
    },
}

</script>

<style scoped>

.bx-download:before {
    content: "\ea86";
}

.download-btn {
    font-size: 15px !important;
}

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
}

.card-one {
    border: 1px solid #d2d6dc;
    border-bottom: 0px;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

a[disabled="disabled"] {
    pointer-events: none;
    background-color: #F2F4F4;
    opacity: 1;
    color: #828D99 !important;
}

.active {
    background-color: #475F7B;
    color: #FFFFFF;
}

#option3, #option4 {
    color: #475F7B;
}

#option3:hover, #option4:hover {
    color: #FFFFFF;
}

#option3:focus, #option4:focus {
    color: #FFFFFF;
}

.hide {
    display: none;
}

.show {
    display: block;
    color: #DC2626;
}

@media (max-width: 575.98px) {

    .report-btn {
        font-size: smaller !important;
        padding-left: 22px !important;

    }

    .report-action {
        padding-left: 15px !important;
    }
}

</style>
