<template>
    <admin-layout>
        <div class="row">
            <div class="col-10 px-1 pb-0 mb-0">
                <div class="col form-group p-0">
                    <h4>Amazon</h4>
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
        <div id="table-hover-row" class="row pb-3">
            <div class="col-12">
                <div class="card-one py-0 my-0 bg-white">
                    <div class="card-content">
                        <div data-repeater-list="group-a">
                            <div>
                                <div class="tabbable-responsive">
                                    <div class="tabbable">
                                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                                            <inertia-link :href="route('orders.index')" aria-selected="false"
                                                          class="nav-item nav-link" v-if="hasPermission('orders.index')">
                                                All Orders
                                            </inertia-link>
                                            <inertia-link :href="route('wowchers.index')" aria-selected="false"
                                                          class="nav-item nav-link" v-if="hasPermission('wowchers.index')">
                                                Wowcher
                                            </inertia-link>
                                            <inertia-link :href="route('ejoggas.index')" aria-selected="false"
                                                          class="nav-item nav-link" v-if="hasPermission('ejoggas.index')">
                                                Ejogga
                                            </inertia-link>
                                            <inertia-link :href="route('groupons.index')" aria-selected="false"
                                                          class="nav-item nav-link" v-if="hasPermission('groupon.index')">
                                                Groupon
                                            </inertia-link>
                                            <inertia-link :href="route('xstreamgyms.index')" aria-selected="false"
                                                          class="nav-item nav-link" v-if="hasPermission('xstreamgyms.index')">
                                                Xstreamgym
                                            </inertia-link>
                                            <inertia-link :href="route('gogroopies.index')" aria-selected="false"
                                                          class="nav-item nav-link" v-if="hasPermission('gogroopie.index')">
                                                Gogroopie
                                            </inertia-link>
                                            <li class="nav-item" v-if="hasPermission('amazons.index')">
                                                <a id="first-tab" aria-controls="first" aria-selected="true"
                                                   class="nav-link active"
                                                   data-toggle="tab" href="#first" role="tab">Amazon</a>
                                            </li>
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
                                                <input v-model="query.query" aria-describedby="basic-addon2"
                                                       aria-label="Search"
                                                       class="form-control border-light-gray btn-height"
                                                       placeholder="Search..." type="text"
                                                       @change="search">
                                                <div class="input-group-append">
                                                    <button class="input-group-text search-btn" @change="search">
                                                        <svg class="feather feather-search feather-16 pb-0 mb-0 mt-0" fill="none" height="23"
                                                             stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                             stroke-width="2" viewBox="0 0 24 24"
                                                             width="23"
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
                                                 class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown" @click="stopPropagation">
                                                <div class="col-12 pl-2 pt-1">
                                                    <div class="d-inline-flex w-100">
                                                        <h6 class="py-0 my-0">Sort</h6>
                                                        <span class="primary pl-20 ml-2 pointer" @click="resetSort">Reset</span>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input id="customer_name" v-model="query.customer_name"
                                                                   name="customer_name"
                                                                   type="checkbox">
                                                            <label class="pl-1 py-0 my-0" for="customer_name">CUSTOMER
                                                                NAME</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input id="email" v-model="query.email" name="email"
                                                                   type="checkbox">
                                                            <label class="pl-1 py-0 my-0" for="email">EMAIL</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input id="phone" v-model="query.phone" name="phone"
                                                                   type="checkbox">
                                                            <label class="pl-1 py-0 my-0" for="phone">PHONE</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input id="item_name" v-model="query.item_name" name="item_name"
                                                                   type="checkbox">
                                                            <label class="pl-1 py-0 my-0" for="item_name">ITEM
                                                                NAME</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input id="postal_address_1" v-model="query.postal_address_1"
                                                                   name="postal_address_1"
                                                                   type="checkbox">
                                                            <label class="pl-1 py-0 my-0"
                                                                   for="postal_address_1">ADDRESS</label>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider py-0 my-0"></div>
                                                <div class="col-12 pl-2 d-inline-flex">
                                                    <p class="pt-1">
                                                        <button id="asce" class=" btn btn-sm btn-primary font-small font-weight-normal stock-order" type="button"
                                                                @click="sort('asc')">
                                                            Asc
                                                        </button>
                                                    </p>
                                                    <p class="pt-1 pl-3">
                                                        <button id="desc" class=" btn btn-sm btn-light-secondary font-small font-weight-normal stock-order" type="button"
                                                                @click="sort('desc')">
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
                        <div class="table-responsive" v-if="amazons.data.length>0">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="text-truncate">Customer Name</th>
                                    <th class="text-truncate">email</th>
                                    <th class="text-truncate">phone</th>
                                    <th class="text-truncate">Item Name</th>
                                    <th class="text-truncate text-center">Address</th>
                                    <th class="text-truncate text-center">Dispatch Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="amazon in amazons.data">
                                    <td class="text-truncate">{{ amazon.customer_name }}</td>
                                    <td class="text-truncate">{{ amazon.email }}</td>
                                    <td class="text-truncate">{{ amazon.phone }}</td>
                                    <td class="text-truncate">{{ amazon.item_name }}</td>
                                    <td class="text-truncate">{{ amazon.full_name }}</td>
                                    <td class="text-truncate">{{
                                            (amazon.postal_address_1 ? amazon.postal_address_1 : '') +
                                            (amazon.postal_address_2 ? " " + amazon.postal_address_2 : '') +
                                            (amazon.postal_address_3 ? ", " + amazon.postal_address_3 : '') +
                                            (amazon.postal_address_4 ? ", " + amazon.postal_address_4 : '') +
                                            (amazon.ship_city ? ", " + amazon.ship_city : '') +
                                            (amazon.ship_country ? ", " + amazon.ship_country : '') +
                                            (amazon.ship_state ? ", " + amazon.ship_state : '') +
                                            (amazon.post_code ? ", " + amazon.post_code : '')
                                        }}
                                    </td>
                                    <td class="text-truncate">{{ amazon.dispatch_date }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive" v-else>
                            <table class="table table-hover truncate mb-0">
                                <thead class="mb-5 pb-5">
                                <tr class="text-center mb-5 pb-5">
                                    <h4 class="pt-3">
                                       It's seems like you don't have any Amazon Order!</h4>
                                    <img alt="icon" class="img"
                                         src="/img/channelorder.png">
                                    <div class="px-0 pb-3" v-if="hasPermission('imports.index')">
                                        <div class="form-group p-0">
                                            <inertia-link :href="route('imports.index')" class="btn btn-primary"
                                                          data-repeater-create="">
                                                <i class="bx bx-xs bx-download pr-0.5 pb-0.5"></i>
                                                Import Amazon Order
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
                <pagination :links="amazons.links" class="float-right"></pagination>
            </div>
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
    props: ['amazons', 'params'],

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
        document.title = process.env.MIX_APP_NAME + " - amazon";
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
            this.$inertia.delete(`/amazons/${this.itemId}`)
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
            this.$inertia.visit(route('amazons.index'), {
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

.bx-download:before {
    content: "\ea86";
    color: white;
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
