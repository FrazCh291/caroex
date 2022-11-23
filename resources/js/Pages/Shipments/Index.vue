<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
                <inertia-link :href="route('shipments.create')" class="btn btn-primary" data-repeater-create="">
                    Add Shipment
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
                                    <div
                                        class="actions action-btns d-flex align-items-center flex flex-wrap filter-container pl-1">
                                        <div class="dropdown w-100 pr-2  sort-dropdown">
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
                                                            <input id="purchase_filling_ref"
                                                                v-model="query.purchase_filling_ref" name="purchase_filling_ref" v-on:click="check_one()"
                                                                type="checkbox">
                                                            <label class="pl-1 py-0 my-0"
                                                                for="purchase_filling_ref">Ref#</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input id="container_number"
                                                                v-model="query.container_number" v-on:click="check_one()" name="container_number"
                                                                type="checkbox">
                                                            <label class="pl-1 py-0 my-0"
                                                                for="container_number">Container#</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base">
                                                        <p class="tag">
                                                            <input id="name " v-model="query.name" v-on:click="check_one()" name="name"
                                                                type="checkbox">
                                                            <label class="pl-1 py-0 my-0" for="name">Contents</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base">
                                                        <p class="tag">
                                                            <input id="uk_eta" v-model="query.uk_eta" v-on:click="check_one()" name="uk_eta"
                                                                type="checkbox">
                                                            <label class="pl-1 py-0 my-0" for="uk_eta">UK ETA</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base">
                                                        <p class="tag">
                                                            <input id="actual_arrival_date" v-model="query.actual_arrival_date" v-on:click="check_one()"
                                                                name="actual_arrival_date" type="checkbox">
                                                            <label class="pl-1 py-0 my-0"
                                                                for="actual_arrival_date">Actual Arrival Date</label>
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
                                    <tr>
                                        <th>Ref #</th>
                                        <th>Container#</th>
                                        <th>Contents</th>
                                        <th>UK ETA</th>
                                        <th>Actual Arrival Date</th>
                                        <th class="text-right custom-padding-right"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(shipment, index) in shipments.data">
                                        <td class="py-0 my-0">
                                            {{ shipment.id }}-{{ shipment.purchase_order?shipment.purchase_order.purchase_filling_ref:''}}
                                        </td>
                                        <td class="text-truncate">
  
                                          <span id="login" :data-toggle="shipment.id" data-container="body" data-boundary="window"
                                                data-html="true" data-placement="bottom" href="#" type="button"
                                                @click="showTooltip(shipment.id)">
                                                <span class="underline-dotted border-gray">
                                                    {{ shipment.container_number }}
                                                </span>
                                            </span> 
                                            <div class="container">
                                                <div :id="'popover-content-'+shipment.id" class="d-none">
                                                    <div class="row custom-popover popover-max">
                                                        <div class="col-12 px-2">

                                                            <span v-if="shipment.container_number">
                                                                <p class="py-0 mb-0 small">
                                                                    <strong>Departure Port:</strong>
                                                                    {{ shipment.departure_port }}
                                                                </p>
                                                                <p class="py-0 mb-0 small">
                                                                    <strong>Shipping Line:</strong>
                                                                    {{ shipment.shipping_line }}
                                                                </p>
                                                                <p class="py-0 mb-0 small">
                                                                    <strong>booking Number:</strong>
                                                                    {{ shipment.booking_number }}
                                                                </p>

                                                                <p class="py-0 mb-0 small">
                                                                    <strong>Container Number:</strong>
                                                                    {{ shipment.container_number }}
                                                                </p>
                                                                <p class="py-0 mb-0 small">
                                                                    <strong>Bill of lading:</strong>
                                                                    {{ shipment.bill_of_lading_number }}
                                                                </p>
                                                                <p class="py-0 mb-0 small">
                                                                    <strong>Seal Number:</strong>
                                                                    {{ shipment.container_seal_number }}
                                                                </p>
                                                                <p class="py-0 mb-0 small">
                                                                    <strong>Load Date:</strong>
                                                                    {{ shipment.load_date }}
                                                                </p>
                                                                <p class="py-0 mb-0 small">
                                                                    <strong>Vessel Etd:</strong>
                                                                    {{ shipment.vessel_etd }}
                                                                </p>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-truncate" @mouseout="hideTooltip(shipment.id)">
                                            <span :data-toggle="'receiver'+shipment.id" data-container="body" data-boundary="window"
                                                data-html="true" data-placement="bottom" type="button"
                                                @click="showReceiverTooltip(shipment.id)"
                                                @mouseenter="hideTooltip(shipment.id)">


                                                <span v-if="shipment.shipment_items.length>0"
                                                    class="underline-dotted border-gray">

                                                    {{
                                                    shipment.shipment_items[0].product ?
                                                    shipment.shipment_items[0].product.name : ''
                                                    +
                                                    shipment.shipment_items[0] ?
                                                    shipment.shipment_items[0].quantity_ordered : ''
                                                    }}

                                                </span>

                                            </span>
                                            <div class="container">
                                                <div :id="'popover-receiver-content-'+shipment.id" class="d-none">
                                                    <div class="row custom-popover popover-max">
                                                        <div class="col-12 px-2">
                                                            <span v-for="item in shipment.shipment_items">
                                                                <span class="font-weight-bold h5 mb-1 small">
                                                                    Products Name and Quantity Orders
                                                                </span>

                                                                <p class="py-0 mb-0 small">
                                                                    {{
                                                                      item.product ?   
                                                                    item.product.name + " x " + item.quantity_ordered: ''
                                                                    }}
                                                                </p>


                                                            </span>

                                                            <span>
                                                                <span class="font-weight-bold h5 mb-1 small">
                                                                    Total Quantity
                                                                </span>

                                                                <p class="py-0 mb-0 small">
                                                                    {{ sum(index) }}
                                                                </p>


                                                            </span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>

                                        <td class="py-0 my-0" @click="hideTooltip(shipment.id)">
                                            {{ formatDate(shipment.uk_eta) }}
                                        </td>
                                        <td @click="hideTooltip(shipment.id)">
                                            {{formatDate(shipment.actual_arrival_date)}}
                                        </td>
                                        <td class="text-right py-0 my-0" @click="hideTooltip(shipment.id)">
                                            <div class="dropdown">
                                                <span
                                                    class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    role="menu" data-boundary="window">
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        :href="route('shipments.show', shipment.id)"><i
                                                            class="bx bxs-show  mr-1"></i>Show</a>
                                                    <a class="dropdown-item"
                                                        :href="route('shipments.edit', shipment.id)"><i
                                                            class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                    <a class="dropdown-item" v-on:click="confirmDelete(shipment.id)"><i
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
            <div class="col-12">
                <pagination :links="shipments.links" class="float-right"></pagination>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import moment from 'moment';
    import AdminLayout from "../../Layouts/AdminLayout";
    import Button from "../../Jetstream/Button";
    import Pagination from "../../admin/Pagination";
    import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

    export default {
        name: "index",
        props: [
            "shipments",
            "companies",
            "params",
            "shipmentItem",
        ],
        components: {
            Button,
            AdminLayout,
            Pagination,
            ConfirmatiomModal,
        },
        data() {
            return {
                query: {
                    query: "",
                    id: false,
                    container_number: false,
                    name: false,
                    purchase_filling_ref: false,
                    product_id: false,
                    uk_eta: false,
                    actual_arrival_date: false,
                },
                sweetAlert: false,
                itemId: "",
                searchItem: false,
                receiver_id: null,
                id: null,
            };
        },
        beforeMount() {
            document.title = process.env.MIX_APP_NAME + " - shipments";
            console.log(this.shipments, 'faraz')
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
            sum(index) {
                let sum = 0;
                for (
                    let i = 0;
                    i < this.shipments.data[index].shipment_items.length;
                    i++
                ) {
                    sum =
                        sum + this.shipments.data[index].shipment_items[i].quantity_ordered;
                }
                return sum;
            },

            resetQuery() {
                this.query = {};
                this.loadData();
            },
            Clicked() {
                this.sweetAlert = false;
            },
            deleteItem() {
                this.sweetAlert = false;
                this.$inertia.delete(`/erp/shipments/${this.itemId}`);
            },
            confirmDelete(id) {
                this.sweetAlert = true;
                this.itemId = id;
            },
            stopPropagation(e) {
                e.stopPropagation();
            },

            resetSort(e) {
                this.query.direction = "";
                this.query.id = "";
                this.query.container_number = false;
                this.query.name = false;
                this.query.product_id = false;
                this.query.uk_eta = false;
                this.query.purchase_filling_ref = false;
                this.query.shipment_status = false;
                this.query.enable = "";
                this.query.disable = "";
                this.loadData();
            },
            resetFilter() {
                this.query.id = "";
                this.query.product_id = "";
                this.query.uk_eta = "";
                this.query.actual_arrival_date = "";

                this.query.enable = "";
                this.query.disable = "";
                this.loadData();
            },
            search() {
                this.searchItem = true;
                this.loadData();
            },
            filter() {
                this.loadData();
            },
            sort(direction) {
                this.query.direction = direction;
                this.loadData();
            },
            formatDate(date) {
                if (date) {
                    return moment(date).format('DD/MM/YYYY');
                } else {
                    return '...';
                }
            },
            check_one: function(){
                if (this.query.container_number  = false){
                    this.query.container_number = true;
                    this.query.name = [];
                    this.query.uk_eta = [];
                    this.query.actual_arrival_date = [];
                    this.purchase_filling_ref = [];
                }
                if (this.query.name = false){
                    this.query.name = true;
                    this.query.uk_eta = [];
                    this.query.actual_arrival_date = [];
                    this.query.type = [];
                    this.purchase_filling_ref = []
                }
                if (this.query.actual_arrival_date  = false){
                    this.query.actual_arrival_date = true;
                    this.query.name = [];
                    this.query.type = [];
                    this.query.uk_eta = [];
                    this.purchase_filling_ref = []
                }
                if (this.query.uk_eta  = false){
                    this.query.uk_eta = true;
                    this.query.name = [];
                    this.query.name = [];
                    this.query.uk_eta = [];
                    this.query.actual_arrival_date = [];
                    this.purchase_filling_ref = []
                }
                if (this.query.purchase_filling_ref  = false){
                    this.purchase_filling_ref =true;
                    this.query.uk_eta = [];
                    this.query.name = [];
                    this.query.type = [];
                    this.query.actual_arrival_date = [];
                }

                },
            loadData() {
                let query = {};
                for (let item in this.query) {
                    if (this.query[item]) {
                        Object.assign(query, { [item]: this.query[item] });
                    }
                }
                this.$inertia.visit(route("shipments.index"), {
                    method: "get",
                    data: {
                        ...query,
                    },
                });
            },

            showReceiverTooltip(id) {
                if (this.receiver_id == null) {
                    this.receiver_id = id;

                    $("[data-toggle=receiver" + id + "]").popover({
                        html: true,

                        content: function () {
                            return $("#popover-receiver-content-" + id).html();
                        },
                    });

                    $("[data-toggle=receiver" + id + "]").popover("show");
                } else if (this.receiver_id == id) {
                    $("[data-toggle=receiver" + this.receiver_id + "]").popover("dispose");

                    this.receiver_id = null;
                } else {
                    $("[data-toggle=receiver" + this.receiver_id + "]").popover("dispose");

                    this.receiver_id = id;

                    $("[data-toggle=receiver" + id + "]").popover({
                        html: true,

                        content: function () {
                            return $("#popover-receiver-content-" + id).html();
                        },
                    });

                    $("[data-toggle=receiver" + id + "]").popover("show");
                }
            },

            hideTooltip(id) {
                $("[data-toggle=" + this.id + "]").popover("dispose");

                $("[data-toggle=receiver" + this.receiver_id + "]").popover("dispose");

                this.receiver_id = null;

                this.id = null;
            },

            showTooltip(id) {
                if (this.id == null) {
                    this.id = id;
                    $("[data-toggle=" + id + "]").popover({
                        html: true,
                        content: function () {
                            return $("#popover-content-" + id).html();
                        },
                    });
                    $("[data-toggle=" + id + "]").popover("show");
                } else if (this.id == id) {
                    $("[data-toggle=" + this.id + "]").popover("dispose");
                    this.id = null;
                } else {
                    $("[data-toggle=" + this.id + "]").popover("dispose");
                    this.id = id;
                    $("[data-toggle=" + id + "]").popover({
                        html: true,
                        content: function () {
                            return $("#popover-content-" + id).html();
                        },
                    });
                    $("[data-toggle=" + id + "]").popover("show");
                }
            },
            showTooltip1(id) {
                if (this.id == null) {
                    this.id = id;
                    $("[data-toggle=" + id + "]").popover({
                        html: true,
                        content: function () {
                            return $("#popover-content-" + id).html();
                        },
                    });
                    $("[data-toggle=" + id + "]").popover("show");
                } else if (this.id == id) {
                    $("[data-toggle=" + this.id + "]").popover("dispose");
                    this.id = null;
                } else {
                    $("[data-toggle=" + this.id + "]").popover("dispose");
                    this.id = id;
                    $("[data-toggle=" + id + "]").popover({
                        html: true,
                        content: function () {
                            return $("#popover-content-" + id).html();
                        },
                    });
                    $("[data-toggle=" + id + "]").popover("show");
                }
            },
        },
    };
</script>

<style scoped>
    .custom-padding {
        padding-left: 24px;
    }

    .custom-padding-right {
        padding-right: 24px;
    }

    .d-flex2 {
        display: flex;
        margin-bottom: -15px;
    }

    .action {
        margin-right: 4px !important;
        margin-bottom: 10px !important;
        margin-top: 10px !important;
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

    .product-image {
        margin-top: 5px;
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