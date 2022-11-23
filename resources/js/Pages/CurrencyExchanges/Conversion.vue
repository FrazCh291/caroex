<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title">CURRENCY CONVERTER</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line"/>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>From-To *</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <select class="form-select" v-model="query.from_to"
                                                    @click="getExchangeRate()" name="from_to">
                                                    <option value="">Select Exchange</option>
                                                    <option v-for="exchange in exchanges"
                                                        :value="exchange.id">
                                                        {{ exchange.from_to }}
                                                    </option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Amount *</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input
                                                    type="decimal"
                                                    @change="calculateRate"
                                                    id="amount"
                                                    v-model="query.amount"
                                                    class="form-control"
                                                    name="amount"
                                                />
                                            </div>
                                        </div>
                                        <div class="row form-group" v-if="conversion">
                                            <div class="col-md-3">
                                                <label>Converted Amount *</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input
                                                    v-model="conversion"
                                                    class="form-control"
                                                    disabled
                                                />
                                            </div>
                                        </div>
<!--                                        <div class="col-sm-11 d-flex justify-content-start px-0">-->
<!--                                            <inertia-link-->
<!--                                                :href="route('exchanges-rates.index')"-->
<!--                                                type="button"-->
<!--                                                class="btn btn-light-secondary mr-1 mb-1"-->
<!--                                            >-->
<!--                                                Back-->
<!--                                            </inertia-link>-->
<!--                                        </div>-->
                                        <div class="col-12 px-0" v-if="chart">
                                            <div class="px-0 pb-1 pt-2">
                                                <hr class="line"/>
                                            </div>
                                            <apexchart
                                                :width="chart.original.options.chart.width"
                                                :height="chart.original.options.chart.height"
                                                :type="chart.original.options.chart.type"
                                                :options="chart.original.options"
                                                :series="chart.original.options.series"
                                            ></apexchart>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from "../../Layouts/AdminLayout";
import Label from "../../Jetstream/Label";
import JetInputError from "./../../Jetstream/InputError";
import ErrorComponent from "../../components/ErrorComponent";
import Chart from "../Chart";
import moment from 'moment';


export default {
    name: "Create",
    props: {
        exchanges: Array,
        chart: Object,
    },
    components: {
        Label,
        Chart,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    data() {
        return {
            query: {
                query: "",
                amount: "",
            },
            exchnage: {},
            chart: {},
            conversion: false,
        };
    },
    beforeMount() {

        this.chart = this.$page.props.chart;
        document.title = process.env.MIX_APP_NAME + " - Create Currency";
        if (this.currencyExchanges) {
            Object.assign(this.query, this.params);
        }
    },

    methods: {

        getExchangeRate() {
            axios
                .get("/super/admin/search-rate", {
                    params: {
                        id: this.query.from_to,
                    },
                })
                .then((response) => {
                    this.exchange = response.data.exchange;
                    this.chart = response.data.chart;
                });
        },
        calculateRate() {
            for (this.exchang in this.exchanges) {
                this.conversion = (this.query.amount * this.exchange.amount).toFixed(2);
            }
        },
    },
};
</script>

<style scoped>
.line {
    border-top: 1px dashed #c7cfd6;
    width: 100%;
}

.error {
    margin-top: 0px !important;
}
</style>
