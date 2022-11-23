<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
                <inertia-link :href="route('payment-gateways.create')" class="btn btn-primary" data-repeater-create="">
                    Add Payment Gateways
                </inertia-link>
            </div>
        </div>
        <div class="row pb-3" id="table-hover-row">
            <div class="col-12">
                <div class="card-one py-0 my-0 bg-white">
                    <div class="card-content">
                        <div data-repeater-list="group-a">
                            <div>
                                <div class="top d-flex flex-wrap">
                                    <div class="action-filters flex-grow-1">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                            <div class="input-group form-group d-flex position-relative mt-1 px-1 pr-md-0">
                                                <input type="text" class="form-control border-light-gray btn-height"
                                                       placeholder="Search..."
                                                       aria-label="Search"
                                                       aria-describedby="basic-addon2" v-model="query.query"
                                                       @change="search">
                                                <div class="input-group-append">
                                                    <button class="input-group-text search-btn" @change="search">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="2" stroke-linecap="round"
                                                             stroke-linejoin="round"
                                                             class="feather feather-search feather-16 pb-0 mb-0 mt-0">
                                                            <circle cx="11" cy="11" r="8"></circle>
                                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="actions action-btns d-flex align-items-center sort-dropdown pl-1">
                                        <div class="dropdown w-100 pr-2 sort-dropdown2">
                                            <button class="btn border dropdown-toggle w-100" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Sort
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"
                                                 aria-labelledby="" @click="stopPropagation">
                                                <div class="col-12 pl-2 pt-1">
                                                    <div class="d-inline-flex w-100">
                                                        <h6 class="py-0 my-0">Sort</h6>
                                                        <span class="primary pl-20 ml-2 pointer" @click="resetSort">Reset</span>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="name" id="name"
                                                                   v-model="query.name" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0"
                                                                   for="name">name</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base">
                                                        <p class="tag">
                                                            <input type="checkbox" name="private_key" id="private_key"
                                                                   v-model="query.private_key" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0"
                                                                   for="private_key">Private Key</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base ">
                                                        <p class="tag">
                                                            <input type="checkbox" name="secret_key" id="secret_key"
                                                                   v-model="query.secret_key" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0"
                                                                   for="secret_key">Secret Key</label>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider py-0 my-0"></div>
                                                <div class="col-12 pl-2 d-inline-flex">
                                                    <p class="pt-1">
                                                        <button type="button" id="asce" @click="sort('asc')"
                                                                class=" btn btn-sm btn-primary font-small font-weight-normal stock-order">
                                                            Asc
                                                        </button>
                                                    </p>
                                                    <p class="pt-1 pl-3">
                                                        <button type="button" id="desc" @click="sort('desc')"
                                                                class=" btn btn-sm btn-light-secondary font-small font-weight-normal stock-order">
                                                            Desc
                                                        </button>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover truncate mb-0">
                                <thead>
                                <tr>
                                    <th class="text-left">Gateway Name</th>
                                    <th class="text-left">Private Key</th>
                                    <th class="">Secret Key</th>
                                    <th class="text-right pl-0">Action</th>
                                </tr>
                                </thead>
                                <tbody class="truncate">
                                    <tr v-for="paymentgateway in paymentgateways.data">
                                        <td class="text-left ">
                                            {{paymentgateway.name}}
                                        </td>
                                        <td class="text-left ">
                                            {{paymentgateway.private_key}}
                                        </td>
                                        <td class="">
                                            {{paymentgateway.secret_key}}
                                        </td>
                                        <td class="text-right ">
                                        <div class="dropdown">
                                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" :href="route('payment-gateways.show',paymentgateway.id)"><i class="bx bx-show mr-1"></i>Show</a>
                                        <a :href="route('payment-gateways.edit', paymentgateway.id)" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                        <a class="dropdown-item" v-on:click="confirmDelete(paymentgateway.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
                                        </div>
                                        </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked" @deleteitem="deleteItem"></ConfirmatiomModal>
        </div>
    </admin-layout>
</template>

<script>

import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
export default {

    name: "index",
    props: ['paymentgateways', 'params'],
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
        document.title = process.env.MIX_APP_NAME + " - Payment Gateway";

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
            this.$inertia.delete(`/erp/admin/payment-gateways/${this.itemId}`)
        },
        confirmDelete(id) {

            this.sweetAlert = true;
            this.itemId = id;
        },
        stopPropagation(e) {
            e.stopPropagation();
        },

        resetSort(e) {
            this.query.direction = '';
            this.query.name = '';
            this.query.private_key = '';
            this.query.secret_key = '';
            this.loadData();
        },
        resetFilter() {
            this.query.id = '';
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


     check_one: function () {

      if ((this.query.name = false)) {
        this.query.name = true;
        this.query.private_key = [];
        this.query.secret_key = [];
      }
      if ((this.query.private_key = false)) {
        this.query.private_key = true;
        this.query.name = [];
        this.query.created_at = [];
      }
      if ((this.query.secret_key = false)) {
        this.query.secret_key = true;
        this.query.name = [];
        this.query.created_at = [];
      }
},

        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) { Object.assign(query, {[item]: this.query[item]}) }
            }
            this.$inertia.visit(route('payment-gateways.index'), {
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
    margin-top: 10px !important;
    margin-bottom: 10px !important;
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

@media (max-width: 575.98px) {

    .sort-dropdown {
        width: 100% !important;
        padding-left: 11px !important;
        padding-right: 0px !important;
        padding-top: 15px !important;
    }
}
</style>
