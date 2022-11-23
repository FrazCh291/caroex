<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
                <inertia-link :href="route('currencyexchanges.create')" class="btn btn-primary" data-repeater-create="">
                    Add Sample
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
                                    <div
                                        class="actions action-btns d-flex align-items-center flex flex-wrap filter-container pl-1">
                                        <div class="dropdown md:w-1/2 sm:w-1 pr-1 filter-dropdown">
                                            <button class="btn border dropdown-toggle w-100" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Filter
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"
                                                 @click="stopPropagation"
                                                 aria-labelledby="">
                                                <div class="col-12 pl-2 pt-1">
                                                    <div class="d-inline-flex w-100">
                                                        <h6 class="py-0 my-0">Status</h6>
                                                        <span class="primary pl-20 ml-2 pointer"
                                                              @click="resetFilter">Reset</span>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="enable" id="enable"
                                                                   v-model="query.enable">
                                                            <label class="pl-1 py-0 my-0" for="enable">Active</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="disable" id="disable"
                                                                   v-model="query.disable">
                                                            <label
                                                                class="pl-1 py-0 my-0" for="disable">Inactive</label>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider py-0 my-0"></div>
                                                <div class="col-12 pl-2">
                                                    <p class="pt-1">
                                                        <button type="button" id="asc" @click="filter"
                                                                class=" btn btn-sm btn-primary font-small font-weight-normal stock-order">
                                                            Filter
                                                        </button>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown md:w-1/2 sm:w-1 pr-2 sort-dropdown">
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
                                                    <div class="text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="name" id="name"
                                                                   v-model="query.name">
                                                            <label class="pl-1 py-0 my-0" for="name">Name</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="address" id="address"
                                                                   v-model="query.address">
                                                            <label
                                                                class="pl-1 py-0 my-0" for="address">Address</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="phone_1" id="phone_1"
                                                                   v-model="query.phone_1">
                                                            <label class="pl-1 py-0 my-0" for="phone_1">phone</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="email" id="email"
                                                                   v-model="query.email">
                                                            <label class="pl-1 py-0 my-0" for="email">email</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="country" id="country"
                                                                   v-model="query.country">
                                                            <label class="pl-1 py-0 my-0"
                                                                   for="country">Country</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="state" id="state"
                                                                   v-model="query.state">
                                                            <label class="pl-1 py-0 my-0"
                                                                   for="state">State</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="city" id="city"
                                                                   v-model="query.city">
                                                            <label class="pl-1 py-0 my-0"
                                                                   for="city">City</label>
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
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="custom-padding">Name</th>
                                    <th>Name</th>
                                    <th>Name</th>
                                    <th>Name</th>
                                    <th>Name</th>
                                    <th>Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-right custom-padding-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="py-0 my-0 custom-padding">Khurram</td>
                                    <td class="py-0 my-0">Khurram</td>
                                    <td class="py-0 my-0">Khurram</td>
                                    <td class="py-0 my-0">Khurram</td>
                                    <td class="py-0 my-0">Khurram</td>
                                    <td class="py-0 my-0">Khurram</td>
                                    <td class="text-center py-0 my-0">03184126659</td>
                                    <td class="text-right py-0 my-0">5000$</td>
                                    <td class="text-right py-0 my-0 custom-padding-right">
                                            <span class="d-inline-flex align-items-center">
                                                <inertia-link :href="route('sample.show',1)">
                                                <span class="badge-circle badge-circle-light-secondary action">
                                                    <i class="bx bxs-show font-medium-1 align-items-center text-center"></i>
                                                </span>
                                               </inertia-link>
                                                <inertia-link>
                                                    <span class="badge-circle badge-circle-light-secondary  action">
                                                        <i class="bx bx-edit font-medium-1 align-items-center text-center"></i>
                                                    </span>
                                                </inertia-link>
                                                <button v-on:click="confirmDelete(sample.id)">
                                                    <span class="badge-circle badge-circle-light-secondary">
                                                        <i class="bx bx-trash font-medium-1 text-center"></i>
                                                    </span>
                                                </button>
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
                               @deleteitem="deleteItem"></ConfirmatiomModal>
            <!--            <div class="col-12 ">-->
            <!--                <pagination :links="companies.links" class="float-right"></pagination>-->
            <!--            </div>-->
        </div>
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
    props: [],
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
        document.title = process.env.MIX_APP_NAME + " - Settings";
    },
    mounted() {
        if (this.params) {
            Object.assign(this.query, this.params);
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
            this.$inertia.delete(`/samples/${this.itemId}`)
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
            this.$inertia.visit(route('samples.index'), {
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
}.custom-padding-right {
    padding-right: 24px;
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
