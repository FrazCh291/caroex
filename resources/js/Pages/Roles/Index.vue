<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
                <inertia-link :href="route('roles.create')" class="btn btn-primary" data-repeater-create="">
                    Add Role
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
                                        <div class="dropdown  md:w-1/2 sm:w-1 pr-1 filter-dropdown">
                                            <button class="btn border dropdown-toggle w-100" type="button"
                                                    id="" data-toggle="dropdown" aria-haspopup="true"
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
                                                            <label class="pl-1 py-0 my-0" for="enable">Enable</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="disable" id="disable"
                                                                   v-model="query.disable">
                                                            <label
                                                                    class="pl-1 py-0 my-0" for="disable">Disable</label>
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
                                                        <h6 class="py-0 my-0 ">Sort</h6>
                                                        <span class="primary pl-20 ml-2 pointer" @click="resetSort">Reset</span>
                                                    </div>
                                                    <div class="text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="id" id="id"
                                                                   v-model="query.id"  v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0" for="id">id</label>
                                                        </p>
                                                         
                                                        <p class="tag">
                                                            <input type="checkbox" name="company_id" id="company_id"
                                                                   v-model="query.company_id"  v-on:click="check_one()">
                                                                   
                                                            <label class="pl-1 py-0 my-0" for="company_id">Company</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="role" id="role"
                                                                   v-model="query.role"  v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0" for="role">Name</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="slug" id="slug"
                                                                   v-model="query.slug"  v-on:click="check_one()">
                                                            <label
                                                                    class="pl-1 py-0 my-0" for="slug">Slug</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="order" id="order"
                                                                   v-model="query.order"  v-on:click="check_one()">
                                                            <label
                                                                    class="pl-1 py-0 my-0" for="order">Order</label>
                                                        </p>
                                                          <p class="tag">
                                                            <input type="checkbox" name="status" id="status"
                                                                   v-model="query.status"  v-on:click="check_one()">
                                                            <label
                                                                    class="pl-1 py-0 my-0" for="status">Status</label>
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
                                    <th class="pl-2">Id</th>
                                    <th class="text-left">Company</th>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Slug</th>
                                    <th class="text-center">order</th>
                                    <th class="text-center">Status</th>
<!--                                    <th class="text-right"></th>-->
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="role in roles.data">
                                    <td class="pl-2">{{role.id}}</td>
                                    <td class="text-left">{{role.company?role.company.name:''}}</td>
                                    <td class="text-left">{{role.role}}</td>
                                    <td class="text-left">{{role.slug}}</td>
                                    <td class="text-center">{{role.order}}</td>
                                    <td class="text-center">
                                        <span v-if="role.status == 1" class="badge badge-light-success badge-pill">Enable</span>
                                        <span v-else class="badge badge-light-danger badge-pill">Disable</span>
                                    </td>
<!--                                    <td class="text-right">-->
<!--                                            <span class="d-inline-flex align-items-center">-->
<!--                                                <inertia-link :href="route('roles.edit',role.id)">-->
<!--                                                    <span class="badge-circle badge-circle-light-secondary  action">-->
<!--                                                        <i class="bx bx-edit font-medium-1 align-items-center text-center"></i>-->
<!--                                                    </span>-->
<!--                                                </inertia-link>-->
<!--                                                <button v-on:click="confirmDelete(role.id)">-->
<!--                                                    <span class="badge-circle badge-circle-light-secondary ml-1/6">-->
<!--                                                        <i class="bx bx-trash font-medium-1 text-center"></i>-->
<!--                                                    </span>-->
<!--                                                </button>-->
<!--                                            </span>-->
<!--                                    </td>-->
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                               @deleteitem="deleteItem"></ConfirmatiomModal>
                       <div class="col-12 ">
                           <pagination :links="roles.links" class="float-right"></pagination>
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
        props: ["roles", 'params'],
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
                    type: false,
                    name: false,
                    enable: false,
                    disable: false,
                    value: false,
                    direction: null
                },
                sweetAlert: false,
                itemId: '',
                searchItem: false
            }
        },
        beforeMount() {
            document.title = process.env.MIX_APP_NAME + " - Roles";
        },
        // mounted() {
        //     if (this.params) {
        //         Object.assign(this.query, this.params);
        //     }
        // },
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
                this.$inertia.delete(`/super/admin/roles/${this.itemId}`)
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
                this.query.id = false;
                this.query.company_id = false;
                this.query.name = false;
                this.query.role = false;
                this.query.slug = false;
                this.query.type = false;
                this.query.status = false;
                this.query.order = false;
                this.loadData();
            },
            resetFilter() {
                this.query.direction = '';
                this.query.disable = false;
                this.query.enable = false;
                
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
            // loadData() {
            //     let query = {};

            //     if (this.query.query) {
            //         Object.assign(query, {'query': this.query.query})
            //     }
            //     if (this.query.id) {
            //         Object.assign(query, {'id': this.query.id})
            //     }
            //     if (this.query.type) {
            //         Object.assign(query, {'type': this.query.type})
            //     }
            //     if (this.query.enable) {
            //         Object.assign(query, {'enable': this.query.enable})
            //     }
            //     if (this.query.name) {
            //         Object.assign(query, {'name': this.query.name})
            //     }
            //     if (this.query.disable) {
            //         Object.assign(query, {'disable': this.query.disable})
            //     }
            //     if (this.query.value) {
            //         Object.assign(query, {'value': this.query.value})
            //     }
            //     if (this.query.direction) {
            //         Object.assign(query, {'direction': this.query.direction})
            //     }
            //     this.$inertia.visit(route('roles.index'), {
            //         method: 'get',
            //         data: {
            //             ...query
            //         }
            //     })
            // },
             check_one: function () {
                if ((this.query.id = false)) {
                    this.query.id = true;
                    this.query.company_id = [];
                    this.query.slug = [];
                    this.query.role = [];
                    this.query.order = [];
                    this.query.status = [];
                }
                if ((this.query.company_id = false)) {
                    this.query.company_id = true;
                    this.query.id = [];
                    this.query.slug = [];
                    this.query.role = [];
                    this.query.order = [];
                    this.query.status = [];
                }
                if ((this.query.slug = false)) {
                    this.query.slug = true;
                    this.query.id = [];
                    this.query.company_id = [];
                    this.query.role = [];
                    this.query.order = [];
                    this.query.status = [];
                }
                if ((this.query.role = false)) {
                    this.query.role = true;
                    this.query.id = [];
                    this.query.slug = [];
                    this.query.order = [];
                    this.query.company_id = [];
                    this.query.status = [];
                }
                if ((this.query.order = false)) {
                    this.query.order = true;
                    this.query.id = [];
                    this.query.slug = [];
                    this.query.role = [];
                    this.query.company_id = [];
                    this.query.status = [];
                }
                if ((this.query.status = false)) {
                    this.query.status = true;
                    this.query.id = [];
                    this.query.slug = [];
                    this.query.role = [];
                    this.query.company_id = [];
                    this.query.status = [];
      }
    },
            loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('roles.index'), {
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
