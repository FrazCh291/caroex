<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
                <inertia-link :href="route('payments.create')" class="btn btn-primary" data-repeater-create="">
                    Add Payment
                </inertia-link>
            </div>
        </div>
        <div id="table-hover-row" class="row pb-3">
            <div class="col-12">
                <div class="card-one py-0 my-0 bg-white">
                    <div class="card-content">
                        <div data-repeater-list="group-a">
                            <div>
                                <div class="top d-flex flex-wrap">
                                    <div class="action-filters flex-grow-1">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                            <div
                                                class="input-group form-group d-flex position-relative mt-1 px-2 pr-md-0">
                                                <input v-model="query.query" aria-describedby="basic-addon2"
                                                    aria-label="Search"
                                                    class="form-control border-light-gray btn-height"
                                                    placeholder="Search..." type="text" @change="search">
                                                <div class="input-group-append">
                                                    <button class="input-group-text search-btn" @change="search">
                                                        <svg class="feather feather-search feather-16 pb-0 mb-0 mt-0"
                                                            fill="none" height="23" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" viewBox="0 0 24 24" width="23"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="11" cy="11" r="8"></circle>
                                                            <line x1="21" x2="16.65" y1="21" y2="16.65"></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="actions action-btns d-flex align-items-center sort-dropdown pl-1">
                                        <div class="dropdown w-100 pr-2 sort-dropdown2">
                                            <button aria-expanded="false" aria-haspopup="true"
                                                class="btn border dropdown-toggle w-100" data-toggle="dropdown"
                                                type="button">
                                                Sort
                                            </button>
                                            <div aria-labelledby=""
                                                class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"
                                                @click="stopPropagation">
                                                <div class="col-12 pl-2 pt-1">
                                                    <div class="d-inline-flex w-100">
                                                        <h6 class="py-0 my-0">Sort</h6>
                                                        <span class="primary pl-20 ml-2 pointer"
                                                            @click="resetSort">Reset</span>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input id="invoice_id" v-model="query.invoice_id" v-on:click="check_one()"
                                                                name="invoice_id" type="checkbox">
                                                            <label class="pl-1 py-0 my-0"
                                                                for="invoice_id">Invoice</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input id="supplier_id" v-model="query.supplier_id" v-on:click="check_one()"
                                                                name="supplier_id" type="checkbox">
                                                            <label class="pl-1 py-0 my-0"
                                                                for="supplier_id">Supplier</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input id="date" v-model="query.date" v-on:click="check_one()" name="date"
                                                                type="checkbox">
                                                            <label class="pl-1 py-0 my-0" for="date">Date</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input id="currency" v-model="query.currency" v-on:click="check_one()"
                                                                name="currency" type="checkbox">
                                                            <label class="pl-1 py-0 my-0"
                                                                for="currency">Currency</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input id="amount" v-model="query.total_gbp" v-on:click="check_one()" name="amount"
                                                                type="checkbox">
                                                            <label class="pl-1 py-0 my-0" for="amount">Amount</label>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider py-0 my-0"></div>
                                                <div class="col-12 pl-2 d-inline-flex">
                                                    <p class="pt-1">
                                                        <button id="asce"
                                                            class=" btn btn-sm btn-primary font-small font-weight-normal stock-order"
                                                            type="button" @click="sort('asc')">
                                                            Asc
                                                        </button>
                                                    </p>
                                                    <p class="pt-1 pl-3">
                                                        <button id="desc"
                                                            class=" btn btn-sm btn-light-secondary font-small font-weight-normal stock-order"
                                                            type="button" @click="sort('desc')">
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
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr class="truncate">
                                        <th class="text-left">Invoice</th>
                                        <th class="text-left">Supplier</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-left"></th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center"></th>
                                        <th class=""></th>
                                    </tr>
                                </thead>
                                <tbody class="truncate">
                                    <tr v-for="payment in payments.data">
                                        <td class="text-left">{{ payment.invoice?payment.invoice.invoice_number:'' }}
                                        </td>
                                        <td class="text-left">{{ payment.supplier.name }}</td>
                                        <td class="text-center">{{
                                            payment.payee_currency_id?payment.payee_currency_id.toUpperCase().substr(payment.payee_currency_id.length
                                            -3 , payment.payee_currency_id.length) + ' ' + payment.payee_total:''}}</td>
                                        <td class="text-truncate"></td>
                                        <td class="text-center">{{ formatDate(payment.payment_date) }}</td>
                                        <!--                                    <td class="text-right">{{ payment.payee_total }}</td>-->
                                        <td class="text-truncate"></td>
                                        <td class="text-right">

                                            <div class="dropdown">
                                                <span
                                                    class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    role="menu" data-boundary="window">
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a :href="route('payments.edit',payment.id)"
                                                        class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit
                                                        Payment</a>
                                                    <a class="dropdown-item" v-on:click="confirmDelete(payment.id)"><i
                                                            class="bx bx-trash mr-1"></i>Delete Payment</a>
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
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked" @deleteitem="deleteItem">
            </ConfirmatiomModal>
            <div class="col-12 ">
                <pagination :links="payments.links" class="float-right"></pagination>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import moment from 'moment';
    import AdminLayout from "../../Layouts/AdminLayout";
    import Button from "../../Jetstream/Button"
    import Pagination from "../../admin/Pagination";
    import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

    export default {

        name: "index",
        props: ['errors', 'payments', 'params', 'totalpayment', 'totalamount', 'totalsupplier'],
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
                    Object.assign(this.query, { [i]: this.params[i] });
                }
            }
        },
        methods: {
            formatDate(date) {
                return moment(date).format('DD/MM/YYYY')
            },
            resetQuery() {
                this.query = {}
                this.loadData()
            },
            Clicked() {
                this.sweetAlert = false
            },
            deleteItem() {
                this.sweetAlert = false
                this.$inertia.delete(`/erp/payments/${this.itemId}`)
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
                this.query.invoice_id = '';
                this.query.supplier_id = '';
                this.query.date = '';
                this.query.currency = '';
                this.query.total_gbp = '';
                this.loadData();
            },
            resetFilter() {
                this.query.id = '';
                this.query.company_id = '';
                this.query.customer_id = '';
                this.query.account_id = '';
                this.query.payment_method = '';
                this.query.transaction_id = '';
                this.query.amonut = '';
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
      if ((this.query.invoice_id = false)) {
        this.query.invoice_id = true;
        this.query.supplier_id = [];
        this.query.date = [];
         this.query.currency = [];
          this.query.total_gbp = [];
      }
      if ((this.query.supplier_id = false)) {
        this.query.supplier_id = true;
        this.query.invoice_id = [];
       this.query.date = [];
         this.query.currency = [];
          this.query.total_gbp = [];
      }
    if ((this.query.date = false)) {
        this.query.date = true;
        this.query.invoice_id = [];
         this.query.currency = [];
          this.query.total_gbp = [];
            this.query.supplier_id = [];
    }
    if ((this.query.currency = false)) {
        this.query.currency = true;
        this.query.invoice_id = [];
       this.query.date = [];
         this.query.supplier_id = [];
          this.query.total_gbp = [];
    }
    if ((this.query.total_gbp = false)) {
        this.query.total_gbp = true;
        this.query.invoice_id = [];
       this.query.date = [];
         this.query.currency = [];
          this.query.total_gbp = [];
    }
},
            loadData() {
                let query = {};
                for (let item in this.query) {
                    if (this.query[item]) {
                        Object.assign(query, { [item]: this.query[item] })
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

    #bi-three-dots {
        transform: rotate(90deg);
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