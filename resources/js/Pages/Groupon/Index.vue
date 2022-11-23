<template>
    <admin-layout>
        <div class="row">
            <div class="col-10 px-1 pb-0 mb-0">
                <div class="col form-group p-0">
                    <h4>Groupon</h4>
                </div>
            </div>
            <div class="col-1 px-0">
                <div class="col form-group p-0" v-if="hasPermission('imports.index')">
                    <inertia-link :href="route('imports.index')" class="btn btn-primary" data-repeater-create="">
                        <i class="bx bx-xs bx-download pr-0.5 pb-0.5"></i>
                        Import
                    </inertia-link>
                </div>
            </div>
            <div class="col-1 px-0">
                <div class="col form-group p-0">
                    <inertia-link :href="route('export.orders')" class="btn btn-outline-secondary"
                                  data-repeater-create="">
                        <i class="bx bx-xs bx-upload pr-0.5 pb-0.5"></i>
                        Export
                    </inertia-link>
                </div>
            </div>
        </div>
        <div class="row pb-3" id="table-hover-row">
            <div class="col-12">
                <div class="card-one py-0 my-0 bg-white">
                    <div class="card-content">
                        <div data-repeater-list="group-a">
                            <div>
                                <div class="tabbable-responsive">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <inertia-link :href="route('orders.index')" aria-selected="false" class="nav-item nav-link" v-if="hasPermission('orders.index')">
                                                All Orders
                                            </inertia-link>
                                            <inertia-link :href="route('wowchers.index')" aria-selected="false" class="nav-item nav-link" v-if="hasPermission('wowchers.index')">
                                                Wowcher
                                            </inertia-link>
                                            <inertia-link :href="route('ejoggas.index')" aria-selected="false" class="nav-item nav-link" v-if="hasPermission('ejoggas.index')">
                                                Ejogga
                                            </inertia-link>
                                            <li class="nav-item" v-if="hasPermission('groupon.index')">
                                                <a class="nav-link active" aria-selected="true" id="first-tab"
                                                   aria-controls="first"
                                                   data-toggle="tab" href="#first" role="tab">Groupon</a>
                                            </li>
                                            <inertia-link :href="route('xstreamgyms.index')" aria-selected="false" class="nav-item nav-link" v-if="hasPermission('xstreamgyms.index')">
                                                Xstreamgym
                                            </inertia-link>
                                            <inertia-link :href="route('gogroopies.index')" aria-selected="false" class="nav-item nav-link" v-if="hasPermission('gogroopie.index')">
                                                Gogroopie
                                            </inertia-link>
                                            <inertia-link :href="route('amazons.index')" aria-selected="false" class="nav-item nav-link" v-if="hasPermission('amazons.index')">
                                                Amazon
                                            </inertia-link>
                                            <!--                                            <inertia-link :href="route('wowchers.index')" aria-selected="false" class="nav-item nav-link" data-repeater-create="">-->
                                            <!--                                                Boomtekk-->
                                            <!--                                            </inertia-link>-->
                                        </ul>
                                    </div>
                                </div>
                                <div class="top d-flex flex-wrap">
                                    <div class="action-filters flex-grow-1">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                            <div
                                                class="input-group form-group d-flex position-relative mt-1 px-2 pr-md-0">
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
                                                            <input type="checkbox" name="groupon_number"
                                                                   id="groupon_number"
                                                                   v-model="query.groupon_number">
                                                            <label class="pl-1 py-0 my-0" for="groupon_number">GROUPON
                                                                NUMBER</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="merchant_sku_item"
                                                                   id="merchant_sku_item"
                                                                   v-model="query.merchant_sku_item">
                                                            <label class="pl-1 py-0 my-0" for="merchant_sku_item">MERCHANT
                                                                SKU ITEM</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="quantity_requested"
                                                                   id="quantity_requested"
                                                                   v-model="query.quantity_requested">
                                                            <label class="pl-1 py-0 my-0" for="quantity_requested">QUANTITY
                                                                REQUESTED</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="shipment_method_requested"
                                                                   id="shipment_method_requested"
                                                                   v-model="query.shipment_method_requested">
                                                            <label class="pl-1 py-0 my-0"
                                                                   for="shipment_method_requested">SHIPMENT
                                                                REQUEST</label>
                                                        </p>
                                                    </div>

                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="shipment_address_name"
                                                                   id="shipment_address_name"
                                                                   v-model="query.shipment_address_name">
                                                            <label class="pl-1 py-0 my-0" for="shipment_address_name">SHIPMENT
                                                                ADDRESS</label>
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
                <div class="card" >
                    <div class="card-content">
                        <div class="table-responsive" v-if="groupons.data.length>0" >
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="text-truncate">Groupon number</th>
                                    <th class="text-truncate">Merchant sku item</th>
                                    <th class="text-truncate text-center">Quantity requested</th>
                                    <th class="text-truncate text-center">Shipment method requested</th>
                                    <th class="text-truncate">Billing address</th>
                                    <th class="text-truncate">Shipment address</th>
                                    <th class="text-truncate text-center">Quantity shipped</th>
                                    <th class="text-truncate">Shipment carrier</th>
                                    <th class="text-truncate text-center">Shipment method</th>
                                    <th class="text-truncate">Shipment tracking number</th>
                                    <th class="text-truncate">Groupon sku</th>
                                    <th class="text-truncate">Custom field value</th>
                                    <th class="text-truncate">Permalink</th>
                                    <th class="text-truncate">Vendor id</th>
                                    <th class="text-truncate">Salesforce deal option#</th>
                                    <th class="text-truncate text-right">Groupon cost</th>

                                    <th class="text-truncate">Purchase order number</th>
                                    <th class="text-truncate">Product weight</th>
                                    <th class="text-truncate text-center">Product weight unit</th>
                                    <th class="text-truncate">Product length</th>
                                    <th class="text-truncate">Product height</th>
                                    <th class="text-truncate">Item name</th>
                                    <th class="text-truncate text-center">Product dimension unit</th>
                                    <th class="text-truncate text-center">Customer phone</th>
                                    <th class="text-truncate">Incoterms</th>
                                    <th class="text-truncate">Hts code</th>
                                    <th class="text-truncate">Pl name</th>
                                    <th class="text-truncate">Pl warehouse location</th>
                                    <th class="text-truncate">Kitting details</th>
                                    <th class="text-truncate text-right">Sell price</th>
                                    <th class="text-truncate">Deal opportunity id#</th>
                                    <th class="text-truncate">Shipment strategy</th>
                                    <th class="text-truncate text-center">Fulfillment method</th>
                                    <th class="text-truncate text-center">Country of origin</th>
                                    <th class="text-truncate">Merchant permalink</th>
                                    <th class="text-truncate ">Bom sku</th>
                                    <th class="text-truncate text-center">Feature start date</th>
                                    <th class="text-truncate text-center">Feature end date</th>
                                    <th class="text-truncate text-center">Shipping date</th>
                                    <th class="text-truncate text-center">Order date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="groupon in groupons.data">
                                    <td class="text-truncate">{{ groupon.groupon_number }}</td>
                                    <td class="text-truncate">{{ groupon.merchant_sku_item }}</td>
                                    <td class="text-truncate text-center">{{ groupon.quantity_requested }}</td>
                                    <td class="text-truncate text-center">{{ groupon.shipment_method_requested }}</td>
                                    <td class="text-truncate">{{
                                            (groupon.billing_address_street ? " " + groupon.billing_address_street : '') +
                                            (groupon.billing_address_city ? ", " + groupon.billing_address_city : '') +
                                            (groupon.billing_address_stat ? ", " + groupon.billing_address_stat : '') +
                                            (groupon.billing_address_postal_code ? ", " +
                                                groupon.billing_address_postal_code : '') +
                                            (groupon.billing_address_country ? ", " + groupon.billing_address_country : '')

                                        }}
                                    </td>
                                    <td class="text-truncate">
                                        {{
                                            (groupon.shipment_address_street ? " " + groupon.shipment_address_street : '') +
                                            (groupon.shipment_address_street_2 ? ", " + groupon.shipment_address_street_2 :
                                                '') +
                                            (groupon.shipment_address_city ? ", " + groupon.shipment_address_city : '') +
                                            (groupon.shipment_address_stat ? ", " + groupon.shipment_address_stat : '') +
                                            (groupon.shipment_address_postal_code ? ", " +
                                                groupon.shipment_address_postal_code : '') +
                                            (groupon.shipment_address_country ? ", " + groupon.shipment_address_country :
                                                '')
                                        }}
                                    </td>
                                    <td class="text-truncate">{{ groupon.quantity_shipped }}</td>
                                    <td class="text-truncate">{{ groupon.shipment_carrier }}</td>
                                    <td class="text-truncate text-center">{{ groupon.shipment_method }}</td>
                                    <td class="text-truncate">{{ groupon.shipment_tracking_number }}</td>
                                    <td class="text-truncate">{{ groupon.groupon_sku }}</td>
                                    <td class="text-truncate">{{ groupon.custom_field_value }}</td>
                                    <td class="text-truncate">{{ groupon.permalink }}</td>
                                    <td class="text-truncate">{{ groupon.vendor_id }}</td>
                                    <td class="text-truncate">{{ groupon.salesforce_deal_option_id }}</td>
                                    <td class="text-truncate text-right">
                                        {{ groupon.groupon_cost ? groupon.groupon_cost + "$" : '' }}
                                    </td>
                                    <td class="text-truncate">{{
                                            (groupon.billing_address_name ? groupon.billing_address_name : '') +
                                            (groupon.billing_address_street ? " " + groupon.billing_address_street : '') +
                                            (groupon.billing_address_city ? ", " + groupon.billing_address_city : '') +
                                            (groupon.billing_address_stat ? ", " + groupon.billing_address_stat : '') +
                                            (groupon.billing_address_postal_code ? ", " +
                                                groupon.billing_address_postal_code : '') +
                                            (groupon.billing_address_country ? ", " + groupon.billing_address_country : '')
                                        }}
                                    </td>
                                    <td class="text-truncate">{{ groupon.purchase_order_number }}</td>
                                    <td class="text-truncate">{{ groupon.product_weight }}</td>
                                    <td class="text-truncate text-center">{{ groupon.product_weight_unit }}</td>
                                    <td class="text-truncate">{{ groupon.product_length }}</td>
                                    <td class="text-truncate">{{ groupon.product_height }}</td>

                                    <td class="text-truncate">{{ groupon.item_name }}</td>
                                    <td class="text-truncate text-center">{{ groupon.product_dimension_unit }}</td>
                                    <td class="text-truncate text-center">{{ groupon.customer_phone }}</td>
                                    <td class="text-truncate">{{ groupon.incoterms }}</td>
                                    <td class="text-truncate">{{ groupon.hts_code }}</td>
                                    <td class="text-truncate">{{ groupon.pl_name }}</td>
                                    <td class="text-truncate">{{ groupon.pl_warehouse_location }}</td>
                                    <td class="text-truncate">{{ groupon.kitting_details }}</td>
                                    <td class="text-truncate text-right">
                                        {{ groupon.sell_price ? groupon.sell_price + "$" : '' }}
                                    </td>
                                    <td class="text-truncate">{{ groupon.deal_opportunity_id }}</td>
                                    <td class="text-truncate">{{ groupon.shipment_strategy }}</td>
                                    <td class="text-truncate text-center">{{ groupon.fulfillment_method }}</td>
                                    <td class="text-truncate">{{ groupon.country_of_origin }}</td>
                                    <td class="text-truncate text-center">{{ groupon.merchant_permalink }}</td>
                                    <!--                                    <td class="text-truncate">{{ groupon.bom_sku }}</td>-->
                                    <td class="text-truncate text-center">{{
                                            formatDate(groupon.feature_start_date)
                                        }}
                                    </td>
                                    <td class="text-truncate text-center">{{
                                            formatDate(groupon.feature_end_date)
                                        }}
                                    </td>
                                    <td class="text-truncate text-center">{{ formatDate(groupon.ship_date) }}</td>
                                    <td class="text-truncate text-center">{{
                                            groupon.order_date ? formatDate(groupon.order_date) : ''
                                        }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive" v-else>
                            <table class="table table-hover truncate mb-0">
                                <thead class="mb-5 pb-5">
                                <tr class="text-center mb-5 pb-5">
                                    <h4 class="pt-3">
                                        It's seems like you don't have any Groupon Order!</h4>
                                    <img alt="icon" class="img"
                                         src="/img/channelorder.png">
                                    <div class="px-0 pb-3" v-if="hasPermission('imports.index')">
                                        <div class="form-group p-0">
                                            <inertia-link :href="route('imports.index')" class="btn btn-primary" data-repeater-create="">
                                                <i class="bx bx-xs bx-download pr-0.5 pb-0.5 text-white"></i>
                                                Import Groupon Order
                                            </inertia-link>
                                        </div>
                                    </div>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                               @deleteitem="deleteItem"></ConfirmatiomModal>
            <div class="col-12 ">
                <pagination :links="groupons.links" class="float-right"></pagination>
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
import DeletedModal from "../SweetAlert/DeletedModal";

export default {

    name: "index",
    props: ['groupons', 'params'],
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
        document.title = process.env.MIX_APP_NAME + " - Groupons";
    },
    mounted() {
        if (this.params) {
            Object.assign(this.query, this.params);
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
            this.$inertia.delete(`/groupons/${this.itemId}`)
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
            this.query.enable = '';
            this.query.disable = '';
            this.loadData();
        },
        resetFilter() {
            this.query = {};
            this.query.id = '';
            this.query.name = '';
            this.query.direction = '';
            this.query.enable = '';
            this.query.disable = '';
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
            this.$inertia.visit(route('groupons.index'), {
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

.nav-link {
    border-bottom: 1px solid #dee2e6 !important;
    padding: 20px;
}

.nav.nav-tabs .nav-item {
    padding-bottom: 0 !important;
}

.nav-item {
    padding-bottom: 10px !important;
}

.nav.nav-tabs .nav-item, .nav.nav-pills .nav-item {
    margin-right: 0 !important;
}

.nav.nav-tabs .nav-item .nav-link, .nav.nav-pills .nav-item .nav-link {
    border-radius: 0 !important;
}

.nav.nav-tabs .nav-item .nav-link.active, .nav.nav-pills .nav-item .nav-link.active {
    box-shadow: none;
    border-bottom: 0 !important;
    /*border-bottom: 1px solid #dee2e6 !important;*/
    /* border-top: 1px solid #dee2e6 !important; */
    border-right: 1px solid #dee2e6 !important;
    border-left: 1px solid #dee2e6 !important;
}

.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    background-color: #FFFFFF !important;
    color: black !important;
    font-weight: 900;
}

.img {
    height: 480px;
    display: block;
    margin-left: auto;
    margin-top: auto;
    margin-right: auto;
}

.tabbable {
    background-color: #F2F4F4;
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
