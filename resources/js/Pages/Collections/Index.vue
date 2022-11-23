<template>
    <admin-layout>
        <div class="col-12 px-0">
            <h5>Collections</h5>
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
                                                            <input type="checkbox" name="customer_id" id="customer_id"
                                                                   v-model="query.customer_id">
                                                            <label class="pl-1 py-0 my-0"
                                                                   for="customer_id">Customer</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="request_type" id="request_type"
                                                                   v-model="query.request_type">
                                                            <label class="pl-1 py-0 my-0"
                                                                   for="request_type">Case Type</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="return_status"
                                                                   id="return_status"
                                                                   v-model="query.return_status">
                                                            <label class="pl-1 py-0 my-0"
                                                                   for="return_status">Return Status</label>
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
                                    <th class="warehouse-name text-left custom-padding">Order#</th>
                                    <th class="text-center">Customer</th>
                                    <th class="text-center">Case Type</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Return Date</th>
                                    <th class="text-center">Recieved Date</th>
                                    <th class="text-center">Refund Date</th>
                                    <th class="text-right custom-padding-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="collection in collections.data">
                                    <td class="text-left truncate py-0 my-0 custom-padding">
                                        {{ collection?.case.order.order_number }}
                                    </td>
                                    <td class="text-center truncate py-0 my-0 custom-padding">
                                        {{ collection?.customer.name }}
                                    </td>
                                    <td class="text-center py-0.5 my-0">{{ collection?.lookup.value }}</td>
                                    <td class="text-center py-0.5 my-0">{{ collection.return_status }}</td>
                                    <td class="text-center py-0.5 my-0" v-if="collection.return_at"> {{
                                        formatDate(collection.return_at)}}
                                    </td>
                                    <td class="text-center py-0.5 my-0" v-else></td>
                                    <td class="text-center py-0.5 my-0" v-if="collection.received_at"> {{
                                        formatDate(collection.received_at) }}
                                    </td>
                                    <td class="text-center py-0.5 my-0" v-else></td>
                                    <td class="text-center py-0.5 my-0" v-if="collection.refunded_at"> {{
                                        formatDate(collection.refunded_at)}}
                                    </td>
                                    <td class="text-center py-0.5 my-0" v-else></td>
                                    <td class="text-right py-0 my-0 truncate custom-padding-right">
                                        <span class="d-inline-flex align-items-center">
                                              <inertia-link :href="route('collections.show',collection.id)">
                                                <span class="badge-circle badge-circle-light-secondary action">
                                                   <i class="bx bxs-show font-medium-1 align-items-center text-center">
                                                   </i>
                                                </span>
                                               </inertia-link>
                                        </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                               @deleteitem="deleteItem">
            </ConfirmatiomModal>
            <div class="col-12 ">
                <pagination :links="collections.links" class="float-right"></pagination>
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
    props: ['collections', 'params'],
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
        document.title = process.env.MIX_APP_NAME + " - collections"
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
            this.$inertia.delete(`/collections/${this.itemId}`)
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
            this.$inertia.visit(route('collections.index'), {
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
.custom-padding {
    padding-left: 24px;
}

.custom-padding-right {
    padding-right: 24px;
}

.tag {
    line-height: 1rem;
    margin-bottom: 0px !important;
    margin-top: 0px !important;
    padding-bottom: 11px !important;
    padding-top: 0px !important;
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
