<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
                <inertia-link :href="route('purchase-orders.create')" class="btn btn-primary" data-repeater-create="">
                    Add Purchase Order
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
                                            <div class="input-group form-group d-flex position-relative mt-1 px-2
                                                pr-md-0">
                                                <input type="text" class="form-control border-light-gray btn-height"
                                                    placeholder="Search..." aria-label="Search"
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
                                    <div class="actions action-btns d-flex align-items-center flex flex-wrap pl-md-1
                                        sm:pl-2 filter-dropdown">
                                        <div class="dropdown md:w-1/2 sm:w-1 pr-1 filter-dropdown">
                                            <button class="btn border dropdown-toggle w-100" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Filter
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"
                                                @click="stopPropagation" aria-labelledby="">
                                                <div class="col-12 pl-2 pt-1">
                                                    <div class="w-100">
                                                        <span class="primary pl-20 ml-2 pointer"
                                                            @click="resetFilter">Reset</span>
                                                    </div>
                                                    <div class="w-100">
                                                        <h6 class="py-0 my-0">Status</h6>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="new" id="new"
                                                                v-model="query.new">
                                                            <label class="pl-1 py-0 my-0" for="new">New</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="released" id="released"
                                                                v-model="query.released">
                                                            <label class="pl-1 py-0 my-0"
                                                                for="released">Released</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="received" id="received"
                                                                v-model="query.received">
                                                            <label class="pl-1 py-0 my-0"
                                                                for="received">Received</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="canceled" id="canceled"
                                                                v-model="query.canceled">
                                                            <label class="pl-1 py-0 my-0"
                                                                for="received">Canceled</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="closed" id="closed"
                                                                v-model="query.closed">
                                                            <label class="pl-1 py-0 my-0" for="closed">Closed</label>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider py-0 my-0"></div>
                                                <div class="col-12 pl-2">
                                                    <p class="pt-1">
                                                        <button type="button" id="asc" @click="filter" class=" btn btn-sm btn-primary font-small
                                                                font-weight-normal stock-order">
                                                            Filter
                                                        </button>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown  md:w-1/2 sm:w-1 pr-1 export-btn sort-dropdown">
                                            <button class="btn border dropdown-toggle w-100" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Sort
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"
                                                aria-labelledby="" @click="stopPropagation">
                                                <div class="col-12 pl-2 pt-1">
                                                    <div class="d-inline-flex w-100">
                                                        <h6 class="py-0 my-0">Sort</h6>
                                                        <span class="primary pl-20 ml-2 pointer" @click="resetSort">
                                                            Reset</span>
                                                    </div>

                                                    <div class="align-items-center text-base pt-1">

                                                        <p class="tag">
                                                            <input type="checkbox" name="purchase_order_number"
                                                                id="purchase_order_number"
                                                                v-model="query.purchase_order_number" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0"
                                                                for="purchase_order_number">Purchase Order#</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="name" id="name"
                                                                v-model="query.name" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0" for="name">Goods</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="total" id="total"
                                                                v-model="query.total" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0" for="total">Cost</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="order_date" id="order_date"
                                                                v-model="query.order_date" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0" for="order_date">Purchase
                                                                Date</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="status" id="status"
                                                                v-model="query.status" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0"
                                                                for="order_date">Status</label>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider py-0 my-0"></div>
                                                <div class="col-12 pl-2 d-inline-flex">
                                                    <p class="pt-1">
                                                        <button type="button" id="asce" @click="sort('asc')" class=" btn btn-sm btn-primary font-small
                                                                font-weight-normal stock-order">
                                                            Asc
                                                        </button>
                                                    </p>
                                                    <p class="pt-1 pl-3">
                                                        <button type="button" id="desc" @click="sort('desc')" class=" btn btn-sm btn-light-secondary font-small
                                                                font-weight-normal stock-order">
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
                                    <tr>
                                        <th>Purchase Order#</th>
                                        <th>Goods</th>
                                        <th class="text-center">Cost</th>
                                        <th class="text-center">Purchase Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-right"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="purchaseOrder in purchaseOrders.data">
                                        <td class="py-1 my-0" @click="hideTooltip(purchaseOrder.id)">
                                            {{purchaseOrder.purchase_order_number}}
                                        </td>
                                        <td class="text-truncate" v-if="purchaseOrder.purchase_order_item.length > 1">
                                            <span data-placement="bottom" :data-toggle="purchaseOrder.id"
                                                @click="showTooltip(purchaseOrder.id)" data-container="body"
                                                type="button" data-html="true" href="#" id="login">
                                                <span class="underline-dotted border-gray">
                                                    {{(purchaseOrder.purchase_order_item?
                                                    purchaseOrder.purchase_order_item[0].product.name:'' + " x " +
                                                    purchaseOrder.purchase_order_item ?
                                                    purchaseOrder.purchase_order_item[0].quantity : '').substring(0, 30)
                                                    }}</span>
                                            </span>
                                            <div class="container">
                                                <div :id="'popover-content-'+purchaseOrder.id" class="d-none">
                                                    <div class="row custom-popover popover-max">
                                                        <div class="col-12 px-2">
                                                            <span class="font-weight-bold h5 mb-1 small">
                                                                Goods
                                                            </span>
                                                            <div
                                                                v-for="purchaseOrderItem in purchaseOrder.purchase_order_item">
                                                                <p class="py-0 mb-0 small">
                                                                    {{ purchaseOrderItem.product ?
                                                                    purchaseOrderItem.product.name + " x " : ''}}
                                                                    {{ purchaseOrderItem ? purchaseOrderItem.quantity :
                                                                    '' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-truncate"
                                            v-else-if="purchaseOrder.purchase_order_item.length > 0">
                                            {{ purchaseOrder.purchase_order_item?
                                            purchaseOrder.purchase_order_item[0].product.name + " x " : '' }}
                                            {{purchaseOrder.purchase_order_item ?
                                            purchaseOrder.purchase_order_item[0].quantity:'' }}
                                        </td>
                                        <td class="text-truncate" v-else></td>
                                        <td class="py-1 my-0 text-center" @click="hideTooltip(purchaseOrder.id)">
                                            {{ purchaseOrder.currency }} {{ purchaseOrder.total }}</td>
                                        <td class="py-1 my-0 text-center" @click="hideTooltip(purchaseOrder.id)">
                                            {{formatDate(purchaseOrder.order_date)}}</td>
                                        <td class="py-1 my-0 text-center" @click="hideTooltip(purchaseOrder.id)">
                                            <span v-if="purchaseOrder.status === 'new'"
                                                class="badge badge-light-primary badge-pill">New</span>
                                            <span v-else-if="purchaseOrder.status === 'released'"
                                                class="badge badge-light-warning badge-pill">Released</span>
                                            <span v-else-if="purchaseOrder.status === 'received'"
                                                class="badge badge-light-success badge-pill">Received</span>
                                            <span v-else-if="purchaseOrder.status === 'canceled'"
                                                class="badge badge-light-danger badge-pill">Canceled</span>
                                            <span v-else class="badge badge-light-seceondary badge-pill">Closed</span>
                                        </td>
                                        <td class="text-right py-1 my-0" @click="hideTooltip(purchaseOrder.id)">

                                            <div class="dropdown">
                                                <span
                                                    class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    role="menu" data-boundary="window">
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        :href="route('purchase-orders.show',purchaseOrder.id)"><i
                                                            class="bx bx-show  mr-1"></i>Show</a>
                                                    <a class="dropdown-item"
                                                        :href="route('purchase-orders.edit',purchaseOrder.id)"><i
                                                            class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                    <a class="dropdown-item"
                                                        v-on:click="confirmDelete(purchaseOrder.id)"><i
                                                            class="bx bx-trash mr-1"></i>Delete</a>
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
                <pagination :links="purchaseOrders.links" class="float-right"></pagination>
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
    // import DeletedModal from "../SweetAlert/DeletedModal";

    export default {

        name: "index",
        props: ['purchaseOrders', 'params'],
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
                    purchase_order_number: false,
                    name: false,
                    total: false,
                    order_date: false,
                    status: false,
                    new: false,
                    released: false,
                    received: false,
                    canceled: false,
                    closed: false,
                    direction: null
                },
                sweetAlert: false,
                itemId: '',
                searchItem: false
            }
        },
        beforeMount() {
            document.title = process.env.MIX_APP_NAME + " - Purchase Orders";
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
                return moment(date).format('DD/MM/YYYY');
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
                this.$inertia.delete(`/erp/purchase-orders/${this.itemId}`)
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
                this.query.id = '';
                this.query.purchase_order_number = false;
                this.query.name = false;
                this.query.total = false;
                this.query.order_date = false;
                this.query.status = false;
                this.loadData();
            },
            resetFilter() {
                this.query.id = '';
                this.query.new = false;
                this.query.released = false;
                this.query.received = false;
                this.query.canceled = false;
                this.query.closed = false;
                this.query.direction = '';
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
            check_one: function(){
                if (this.query.purchase_order_number  = false){
                            this.query.purchase_order_number = true;
                            this.query.total = [];
                            this.query.order_date = [];
                            this.query.name = [];
                            this.query.status = [];
                        }
                        if (this.query.total = false){
                            this.query.total = true;
                            this.query.purchase_order_number = [];
                            this.query.order_date = [];
                            this.query.name = [];
                            this.query.status = [];
                        }
                        if (this.query.order_date  = false){
                            this.query.order_date = true;
                            this.query.purchase_order_number = [];
                            this.query.name = [];
                            this.query.total = [];
                            this.query.status = [];
                        }
                        if (this.query.status  = false){
                            this.query.status = true;
                            this.query.purchase_order_number = [];
                            this.query.name = [];
                            this.query.total = [];
                            this.query.status = [];
                        }
                         if (this.query.name  = false){
                            this.query.name = true;
                            this.query.purchase_order_number = [];
                            this.query.total = [];
                            this.query.status = [];
                        }

                        },

            loadData() {
                let query = {};
                for (let item in this.query) {
                    if (this.query[item]) {
                        Object.assign(query, { [item]: this.query[item] })
                    }
                }
                this.$inertia.visit(route('purchase-orders.index'), {
                    method: 'get',
                    data: {
                        ...query
                    }
                })
            },
            showTooltip(id) {
                if (this.id == null) {
                    this.id = id;
                    $("[data-toggle=" + id + "]").popover({
                        html: true,
                        content: function () {
                            return $('#popover-content-' + id).html();
                        }
                    });
                    $("[data-toggle=" + id + "]").popover('show')
                } else if (this.id == id) {
                    $("[data-toggle=" + this.id + "]").popover('dispose');
                    this.id = null;
                } else {
                    $("[data-toggle=" + this.id + "]").popover('dispose');
                    this.id = id;
                    $("[data-toggle=" + id + "]").popover({
                        html: true,
                        content: function () {
                            return $('#popover-content-' + id).html();
                        }
                    });
                    $("[data-toggle=" + id + "]").popover('show')
                }
            },
            hideTooltip(id) {
                $("[data-toggle=" + this.id + "]").popover('dispose');
                this.id = null;
            }
        }
    }

</script>

<style scoped>
    .tag {
        line-height: 1rem;
        margin-bottom: 0px !important;
        margin-top: 0px !important;
        padding-bottom: 11px !important;
        padding-top: 0px !important;
    }

    .product-name {
        width: 30% !important;
    }

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

    img.rounded-circle.empty-image {
        height: 40px;
        margin-bottom: 3px;
        width: 45px;
        margin-top: 5px;
    }

    #bi-three-dots {
        transform: rotate(90deg);
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