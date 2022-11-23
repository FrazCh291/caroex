<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-lg-9 col-xl-9 col-12">
                        <div class="card invoice-print-area">
                            <div class="card-header pb-0 mb-0">
                                <h1 class="card-title">
                                    {{ company.name }}
                                </h1>
                            </div>
                            <div class="px-2">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body pb-1 mx-25">
                                    
                                     <div class="col-lg-4">
                      <small class="text-muted lg:font-bold"> Owner:</small>
                      <small class="text-muted ml-1"> {{ company.company_owner ? company.company_owner.name : '' }}</small>
                    </div>
                                   
                                         <div class="col-lg-4">
                      <small class="text-muted lg:font-bold"> Email:</small>
                      <small class="text-muted ml-1">   {{ company.company_owner ? company.company_owner.email : '' }}</small>
                    </div>
                                    

                                    <div>
                                        <div class="row pb-0.5">
                                            <div class="col-10">
                                                <h2 class="card-title mb-0 pt-1">Company Users</h2>
                                            </div>
                                            <div class="col-2" >
                                                <div class="col form-group pr-0 pb-0.5">
                                                    <inertia-link :href="route('company.users',company.id)"
                                                                  class="px-0">
                                                        <i class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1"></i>
                                                    </inertia-link>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="row col-12 pr-0" id="table-hover-row">
                                                <div class="col-12 pr-0">
                                                    <div class="card-one py-0 my-0 bg-white">
                                                        <div class="card-content">
                                                            <div data-repeater-list="group-a">
                                                                <div>
                                                                    <div class="top d-flex flex-wrap">
                                                                        <div class="action-filters flex-grow-1">
                                                                            <div id="DataTables_Table_0_filter"
                                                                                 class="dataTables_filter">
                                                                                <fieldset
                                                                                    class="form-group position-relative mt-1 pl-1">
                                                                                    <input type="text"
                                                                                           class="form-control float-left search-input"
                                                                                           id="iconLeft2"
                                                                                           placeholder="Search..."
                                                                                           v-model="query.query"
                                                                                           @change="search">
                                                                                    <div class="form-control-position"
                                                                                         @click="resetQuery"
                                                                                         v-if="query.query">
                                                                                        <i class="bx bx-x"></i>
                                                                                    </div>
                                                                                </fieldset>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="actions action-btns d-flex align-items-center flex flex-wrap pr-1">
                                                                            <div class="input-group-append ">
                                                                                <button
                                                                                    class="input-group-text search-btn"
                                                                                    @change="search">
                                                                                    <svg
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        width="23" height="37"
                                                                                        viewBox="0 0 24 24"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="2"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        class="feather feather-search feather-16 pb-0 mb-0 mt-0">
                                                                                        <circle cx="11" cy="11"
                                                                                                r="8"></circle>
                                                                                        <line x1="21" y1="21" x2="16.65"
                                                                                              y2="16.65"></line>
                                                                                    </svg>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="actions action-btns d-flex align-items-center flex flex-wrap" >
                                                                            <div class="dropdown md:w-1/2 sm:w-1 pr-1">
                                                                                <button
                                                                                    class="btn border dropdown-toggle w-100"
                                                                                    type="button"
                                                                                    id="invoice-filter-btn"
                                                                                    data-toggle="dropdown"
                                                                                    aria-haspopup="true"
                                                                                    aria-expanded="false" disabled>
                                                                                    Filter
                                                                                </button>
                                                                                <div
                                                                                    class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"
                                                                                    aria-labelledby="invoice-filter-btn"
                                                                                    @click="stopPropagation">
                                                                                    <div class="col-12 pl-2 pt-1">
                                                                                        <div
                                                                                            class="d-inline-flex w-100">
                                                                                            <h6 class="py-0 my-0">
                                                                                                Filter</h6>
                                                                                            <span
                                                                                                class="primary pl-20 ml-2 pointer"
                                                                                                @click="resetFilter">Reset</span>
                                                                                        </div>
                                                                                        <div
                                                                                            class="align-items-center text-base pt-1">
                                                                                            <p class="tag">
                                                                                                <input type="checkbox"
                                                                                                       name="id"
                                                                                                       id="paid"><label
                                                                                                class="pl-1"
                                                                                                for="paid">Paid</label>
                                                                                            </p>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="dropdown-divider py-0 my-0"></div>
                                                                                    <div class="col-12 pl-2">
                                                                                        <p class="pt-1">
                                                                                            <button type="button"
                                                                                                    id="asc"
                                                                                                    @click="filter"
                                                                                                    class=" btn btn-sm btn-primary font-small font-weight-normal stock-order">
                                                                                                Filter
                                                                                            </button>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="dropdown md:w-1/2 sm:w-1 pr-1">
                                                                                <button
                                                                                    class="btn border dropdown-toggle w-100"
                                                                                    type="button"
                                                                                    id="invoice-options-btn"
                                                                                    data-toggle="dropdown"
                                                                                    aria-haspopup="true"
                                                                                    aria-expanded="false" disabled>
                                                                                    Sort
                                                                                </button>
                                                                                <div
                                                                                    class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"
                                                                                    aria-labelledby="invoice-options-btn"
                                                                                    @click="stopPropagation">
                                                                                    <div class="col-12 pl-2 pt-1">
                                                                                        <div
                                                                                            class="d-inline-flex w-100">
                                                                                            <h6 class="py-0 my-0">
                                                                                                Sort</h6>
                                                                                            <span
                                                                                                class="primary pl-20 ml-2 pointer"
                                                                                                @click="resetSort">Reset</span>
                                                                                        </div>
                                                                                        <div
                                                                                            class="align-items-center text-base pt-1">
                                                                                            <p class="tag">
                                                                                                <input type="checkbox"
                                                                                                       name="first_name"
                                                                                                       id="first_name"><label
                                                                                                class="pl-1"
                                                                                                for="first_name">Receiver
                                                                                                Name</label>
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="dropdown-divider py-0 my-0"></div>
                                                                                    <div
                                                                                        class="col-12 pl-2 d-inline-flex">
                                                                                        <p class="pt-1">
                                                                                            <button type="button"
                                                                                                    id="asce"
                                                                                                    @click="sort('asc')"
                                                                                                    class=" btn btn-sm btn-primary font-small font-weight-normal stock-order">
                                                                                                Asc
                                                                                            </button>
                                                                                        </p>
                                                                                        <p class="pt-1 pl-3">
                                                                                            <button type="button"
                                                                                                    id="desc"
                                                                                                    @click="sort('desc')"
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
                                                <div class="col-12 pr-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover mb-0">
                                                                    <thead v-if="company.users.length >0">
                                                                    <tr>
                                                                        <th class="px-2 text-left py-0 my-0 text-truncate t-header">
                                                                            Name
                                                                        </th>
                                                                        <th class="py-0 my-0 text-truncate t-header">
                                                                            Email
                                                                        </th>
                                                                        <th class="py-0 my-0 text-truncate t-header text-center">
                                                                            Role
                                                                        </th>
                                                                        <th class="text-right py-0 my-0 text-truncate t-header px-0 mx-0"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr v-for="userr in company.users"
                                                                        class="py-0 my-0 px-0 mx-0">
                                                                        <td class="px-2 small cursor-pointer py-0 my-0 text-truncate action">
                                                                            {{ userr.name }}
                                                                        </td>
                                                                        <td class="small cursor-pointer py-0 my-0 text-truncate">
                                                                            {{ userr.email }}
                                                                        </td>
                                                                        <td class="small cursor-pointer py-0 my-0 text-truncate text-center">
                                                                            {{ userr.role.role }}
                                                                        </td>
                                                                        <td class="text-right action">
                                                                                <span class="d-inline-flex align-items-center ">
                                                                                    <button v-on:click="confirmDelete(userr.id)">
                                                                                        <span class="badge-circle badge-circle-light-secondary ml-1/6">
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
                                            </div>
                                            <div class="col-12 ">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--                <Toastr v-if="success" :message="message" :type="type"></Toastr>-->
                    <div class="col-lg-3 col-xl-3 col-md-6 col-12" v-if="company.subscription || is_super || is_admin">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body px-2 py-2">
                                    <div class="row py-0">
                                        <div class="col-md-12 form-group py-0 my-0">
                                            <div class="position-relative has-icon-left">
                                                <inertia-link :href="route('companies.roles',company.id)">
                                                    <span
                                                        class="btn btn-primary btn-lg btn-block text-small">Roles & Permissions </span>
                                                </inertia-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </admin-layout>
    <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                       @deleteitem="deleteItem"></ConfirmatiomModal>
</template>

<script>

import AdminLayout from "../../../Layouts/AdminLayout";
import Button from "../../../Jetstream/Button"
import Pagination from "../../../admin/Pagination";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";

export default {

    name: "Show",
    props: ['company'],

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
                first_name: false,
                date: false,
                amount_sent: false,
                direction: null,
                paid: false,
                un_paid: false,
                partially_paid: false,
                page: 1,
                transfer_request: true
            },
            sweetAlert: false,
            itemId: '',
            is_super: false,
            is_admin: false,
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Company show";

    },
    mounted() {
        if (this.$page.props.auth.user.is_super == 1) {
            this.is_super = true
        }
        if (this.$page.props.auth.user.is_admin == 1) {
            this.is_admin = true
        }
    },
    methods: {
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            this.sweetAlert = false
            this.$inertia.delete(`/erp/admin/company/user/delete/${this.itemId}`)
        },
        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
        },
        stopPropagation(e) {
            e.stopPropagation();
        },
        resetSort(e) {
            this.query.id = '';
            this.query.rel_first_name = '';
            this.query.date = '';
            this.query.amount_sent = '';
            this.query.direction = '';
            this.query.page = '';
            this.loadData();
        },
        resetFilter(e) {
            this.query.paid = '';
            this.query.un_paid = '';
            this.query.partially_paid = '';
            this.query.direction = '';
            this.query.page = '';
        },
        resetQuery() {
            this.query = {}
            this.loadData()
        },
    }
}
</script>

<style scoped>
.t-header{
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

.action {
    padding-top: 4px !important;
    padding-bottom: 4px !important;
}


.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
    height: auto !important;
}

.card-one {
    border: 1px solid #d2d6dc;
    border-bottom: 0px;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.popover-content h4 {
    color: #00A1FF;
}

.popover-content h4 small {
    color: black;
}

.popover-content button.btn-primary {
    color: #00A1FF;
    border-color: #00A1FF;
    background: white;
}

.popover-content button.btn-default {
    color: gray;
    border-color: gray;
}

.custom-dropdown {
    margin-top: 0.5rem !important;
}

.input-group-text {
    padding: 0px !important;
    padding-left: 10px !important;
    padding-right: 10px !important;
}

.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}


tr.spaceUnder > td {
    padding-bottom: 1em;
}

@media (max-width: 1199px) {
    .text-small {
        font-size: 11px !important;
    }

    .text-document {
        font-size: 8px !important;
    }

    .contact-info {
        padding-left: 14px !important;
    }
}

@media (min-width: 1200px) {
    .text-small {
        font-size: 14px !important;
    }
}
</style>
