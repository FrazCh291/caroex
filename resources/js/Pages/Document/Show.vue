<template>
    <admin-layout>
        <section class="invoice-view-wrapper">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-12 mt-1">
                    <div class="card invoice-print-area">
                        <div class="card-body pb-0">
                            <div class="row invoice-info pr-0 mr-0">
                                <div class="col-sm-2">
                                    <div class="mb-0 title-col ">
                                        <p class="align-middle"> Deal# {{ deals.deal_number }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-12">
                                    <div class="mb-0">
                                        <p class="align-middle">{{ deals.channel_name }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-8 px-0">
                                    <div class="mb-1 text-right">
                                        <span class="d-inline-flex align-items-right">
                                            <a :href="route('export.deals.files',deals.id)">
                                                <span class="badge-circle badge-circle-light-secondary action">
                                                    <i class="bx bx-download font-medium-1 align-items-center text-center"></i>
                                                </span>
                                            </a>
                                            <a :href="route('view.deals.files',deals.id)">
                                                <span class="badge-circle badge-circle-light-secondary action ml-1">
                                                    <i class="bx bxs-file-pdf font-medium-1 align-items-center text-center"></i>
                                                </span>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-success">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                            <i class="bx bx-cart font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">Number Of Orders</div>
                                        <h3 class="mb-0">{{ orderCount }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-success">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div
                                            class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                            <i class="bx bx-money font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">Orders Quantity</div>
                                        <h3 class="mb-0">{{ orderQuantity }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div
                                            class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                            <i class="bx bx-user font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">Total Commission</div>
                                        <h3 class="mb-0">£{{ totalCommission.toFixed(2) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div
                                            class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                            <i class="bx bx-user font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">Total VAT</div>
                                        <h3 class="mb-0">£{{ totalVat.toFixed(2) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-success">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                            <i class="bx bx-briefcase-alt font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">Total P & P VAT</div>
                                        <h3 class="mb-0">£{{ totalPpVat.toFixed(2)  }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div
                                            class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                            <i class="bx bx-user font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">Exclusive Text Amount</div>
                                        <h3 class="mb-0">£{{ totalExclusiveTextAmount.toFixed(2)  }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-md-12 col-12 mt-1">
                    <div class="card invoice-print-area">
                        <div class="card-body mx-25 pb-1">
                            <div class="row invoice-info pr-0 mr-0">
                                <div class="col-lg-3 col-md-8 col-sm-6 col-9">
                                    <div class="mb-0 title-col ">
                                        <p class=""> Total VAT </p>
                                        </div>
                                    <div class="mb-0 title-col ">
                                        <p class="padding-change"> VAT Deduct Commission </p>
                                        </div>
                                    <div class="mb-0 title-col ">
                                        <p class="padding-change"> Commission Amount </p>
                                        </div>
                                    <div class="mb-0">
                                        <p class="padding-change">Commission Percentage</p>
                                    </div>
                                    <div class="mb-0">
                                        <p class="padding-change">Contract Date & Time</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-md-4 col-3">
                                    <div>
                                        <div class="mb-0">
                                            <p class="padding-change">£{{ deals.total_net_vat}}</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change">{{ deals.vat_deduct_commission}}%</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="">£{{ deals.commission_amount }}</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change">{{ deals.commission_percentage }}%</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change">
                                                {{ deals.contract_signed_at ? formatDate(deals.contract_signed_at) : '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-8 col-sm-6 col-9">
                                    <p class="padding-change">VAT%</p>
                                    <div class="mb-0">
                                        <p class="padding-change">Inclusive Rate Per Item</p>
                                    </div>
                                    <div class="mb-0">
                                        <p class="padding-change">P & P Rate</p>
                                    </div>
                                    <div class="mb-0">
                                        <p class="padding-change">Exclusive Text Aamount</p>
                                    </div>
                                    <div class="mb-0">
                                        <p class="padding-change">Total Receivable</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-md-4 col-3">
                                    <div>
                                        <div class="mb-0">
                                            <p class="padding-change">20%</p>
                                        </div>
                                        <div class="mb-0">
                                        </div>
                                            <p class="padding-change">£{{deals.unit_price}}</p>
                                        <div class="mb-0">
                                            <p class="padding-change">£{{deals.p_p_rate}}</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change">£{{ deals.exclusive_text_amount }}</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change">£{{deals.total_receivable}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12" v-if="orders.data.length > 0">
                    <h3 class="pb-2.5">Invoice</h3>
                    <div class="card">
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th class="text-truncate">Deal Number</th>
                                        <th class="text-truncate">Order</th>
                                        <th class="text-truncate">Product</th>
                                        <th class="text-truncate text-center">quantity</th>
                                        <th class="text-truncate text-center">price</th>
                                        <th class="text-truncate text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="order in orders.data">
                                            <td class="text-truncate">{{deals.deal_number}}</td>
                                            <td class="text-truncate">{{ order.order_number }}</td>
                                            <td class="text-truncate">Fake Text</td>
                                            <td class="text-truncate text-center">Fake Text</td>
                                            <td class="text-truncate text-center">Fake Text</td>
                                            <td class="text-truncate text-right">
                                                <inertia-link >
                                                <span class="badge-circle badge-circle-light-secondary  action">
                                                    <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                                </span>
                                                </inertia-link>
                                                <button>
                                                <span class="badge-circle badge-circle-light-secondary ml-1/6">
                                                    <i class="bx bx-trash font-medium-1 text-left"></i>
                                                </span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12" v-if="orders.data.length > 0">
                    <h3 class="pb-2.5">Orders</h3>
                    <div class="card">
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th class="text-truncate">Order</th>
                                        <th class="text-truncate">Product</th>
                                        <th class="text-truncate text-center">price</th>
                                        <th class="text-truncate text-center">quantity</th>
                                        <th class="text-truncate text-center">Total Price</th>
                                        <th class="text-truncate text-center">Total Receivable</th>
                                        <th class="text-truncate text-right">Order Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="order in orders.data">
                                            <td class="text-truncate">{{ order.order_number }}</td>
                                            <td class="text-truncate">{{ order.product.name }} ({{ order.product.sku }})</td>
                                            <td class="text-truncate text-center">£{{ deals.unit_price }}</td>
                                            <td class="text-truncate text-center">{{ order.quantity }}</td>
                                            <td class="text-truncate text-center">£{{ order.quantity * deals.unit_price }}</td>
                                            <td class="text-truncate text-center">£{{ (order.quantity * deals.total_receivable).toFixed(2) }}</td>
                                            <td class="text-truncate text-right">{{ order.order_date }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="border">
                                        <tr>
                                            <th class="total" colspan="2"><span class="float-right">Total :</span></th>
                                            <td class="text-center border-top"><strong>£{{ orderCount * deals.unit_price }}</strong></td>
                                            <td class="text-center border-top"><strong>£{{ orderQuantity }}</strong></td>
                                            <td class="text-center border-top"><strong>£{{ (orderQuantity * deals.unit_price) }}</strong></td>
                                            <td class="text-center border-top"><strong>£{{ (orderQuantity * deals.total_receivable) }}</strong></td>
                                            <td class="text-center border-top"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" v-if="orders.data.length > 0">
                <pagination :links="orders.links" class="float-right"></pagination>
            </div>
        </section>
    </admin-layout>
</template>

<script>
import moment from 'moment';
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import ErrorComponent from '../../components/ErrorComponent'

export default {

    name: "Show",
    props: ['deals', 'orders', 'orderCount', 'totalVat', 'totalCommission', 'totalExclusiveTextAmount', 'orderQuantity', 'totalPpVat', 'dealPrice'],

    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
        ErrorComponent
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
        document.title = process.env.MIX_APP_NAME + " - Show Details";
    },
    mounted() {
        if (this.params) {
            Object.assign(this.query, this.params);
        }
    },
    methods: {
        stopPropagation(e) {
            e.stopPropagation();
            this.submitStatus();
        },
        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('cores.index'), {
                method: 'get',
                data: {
                    ...query
                }
            })
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY hh:mm')
        },
    }
}
</script>
