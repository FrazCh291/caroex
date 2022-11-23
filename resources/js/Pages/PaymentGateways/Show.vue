<template>
    <admin-layout>
        <section class="invoice-view-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-3 col-3 dashboard-users-success" >
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1 rounded-2xl">
                                        <div class="badge-circle badge-circle-lg badge-circle-primary mx-auto mb-50">
                                            <i class="bx bx-briefcase-alt font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">Total Orders</div>
                                        <h3 class="mb-0">215</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-3">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-warning mx-auto mb-50">
                                            <i class="bx bx-coin font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">Total Payment</div>
                                        <h3 class="mb-0">205.5K</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-3 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                            <i class="bx bx-money font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">Total Profit</div>
                                        <h3 class="mb-0">45.6k</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-3 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto mb-50">
                                            <i class="bx bx-user font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">New Users</div>
                                        <h3 class="mb-0 mr">45.6k</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
            <div class="col-xl-12 col-md-12 col-12 mt-1">
                <div class="card invoice-print-area">
                    <div class="card-body mx-25 pb-0">
                        <div class="row invoice-info pr-0 mr-0">
                            <div class="col-lg-3 col-md-8 col-sm-6 col-9">
                                <div class="mb-0 title-col ">
                                    <p class="">Gateways </p>
                                </div>
                                <div class="mb-0 title-col ">
                                    <p class="padding-change"> Private Key</p>
                                </div>
                                <div class="mb-0 title-col ">
                                    <p class="padding-change"> Secret Ket </p>
                                </div>
                                <div class="mb-0">
                                    <p class="padding-change">Account</p>
                                </div>
                                <div class="mb-0">
                                    <p class="padding-change">Amount</p>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-md-4 col-3">
                                <div>
                                    <div class="mb-0">
                                        <p class="padding-change">Payment</p>
                                    </div>
                                    <div class="mb-0">
                                        <p class="padding-change">Payment</p>
                                    </div>
                                    <div class="mb-0">
                                        <p class="">Payment</p>
                                    </div>
                                    <div class="mb-0">
                                        <p class="padding-change">Payment</p>
                                    </div>
                                    <div class="mb-0">
                                        <p class="padding-change">
                                            Payment
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-8 col-sm-6 col-9">
                                <p class="padding-change">Gateways</p>
                                <div class="mb-0">
                                    <p class="padding-change">Private Key</p>
                                </div>
                                <div class="mb-0">
                                    <p class="padding-change">Secret Key</p>
                                </div>
                                <div class="mb-0">
                                    <p class="padding-change"></p>
                                </div>
                                <div class="mb-0">
                                    <p class="padding-change"></p>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-md-4 col-3">
                                <div>
                                    <div class="mb-0">
                                        <p class="padding-change"></p>
                                    </div>
                                    <div class="mb-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                                 <div class="col-sm-11 d-flex justify-content-start px-0 mt-1">
                                                <inertia-link :href="route('payment-gateways.index')" type="button"
                                                              class="btn btn-light-secondary mr-1 mb-1">
                                                    Back
                                                </inertia-link>
                                 </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </admin-layout>
</template>

<script>

import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import DeletedModal from "../SweetAlert/DeletedModal";

export default {

    name: "index",
    props: ['paymentgateways'],
    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
    },
    data() {
        return {
            query: {
                query: '',
                id: false,
                name: false,
                enable: false,
                disable: false,
                direction: null
            },
            sweetAlert: false,
            itemId: '',
            searchItem: false
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - payments";

    },
    mounted() {
        if (this.params) {
            let params = Object.keys(this.params);
            for (let i of params) {
                Object.assign(this.query, {[i]: this.params[i]});
            }
        }
    },
    methods: {
        resetQuery() {
            this.query = {}
            this.loadData()
        },
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {

            this.sweetAlert = false
            this.$inertia.delete(`/payments/${this.itemId}`)
        },
        confirmDelete(id) {

            this.sweetAlert = true;
            this.itemId = id;
        },
        stopPropagation(e) {
            e.stopPropagation();
        },

        resetSort(e) {
            this.query = {};
            this.query.direction = '';
            this.query.id = '';
            this.query.name = '';
            this.query.address_1 = '';
            this.query.address_2 = '';
            this.loadData();
        },
        resetFilter() {
            this.query = {};
            this.query.id = '';
            this.query.name = '';
            this.loadData();
        },
        search() {
            this.searchItem = true;
            this.loadData()
        },
        filter() {
            this.loadData();
        },
        sort(direction) {
            this.query.direction = direction;
            this.loadData();
        },
        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('payments.index'), {
                method: 'get',
                data: {
                    ...query
                }
            })
        },
    }
}
</script>

<style scoped>

.action {
    margin-right: 4px !important;
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

.custom-dropdown {
    margin-top: 0.5rem !important;
}

@media (max-width: 575.98px) {

    .filter-container {
        width: 100% !important;
        padding-right: 22px !important;
        padding-left: 11px !important;
    }

    .filter-dropdown {
        width: 100% !important;
        padding-right: 0px !important;
        padding-left: 11px !important;
    }

    .sort-dropdown {
        width: 100% !important;
        padding-left: 11px !important;
        padding-right: 0px !important;
        padding-top: 15px !important;
    }
}
</style>
