<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
                <!-- <inertia-link :href="route('questionnaires.create')" class="btn btn-primary" data-repeater-create="">
                 Add Questionnaire
                </inertia-link> -->
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
                                                       placeholder="Search"
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
                                  <div class="actions action-btns d-flex align-items-center flex flex-wrap filter-container pl-1">
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
                                                        <h6 class="py-0 my-0">Sort</h6>
                                                        <span class="primary pl-20 ml-2 pointer" @click="resetSort">Reset</span>
                                                    </div>
                                                      <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="label" id="label"
                                                                   v-model="query.label" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0" for="label">Label</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base">
                                                        <p class="tag">
                                                            <input type="checkbox" name="value" id="value"
                                                                   v-model="query.value" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0" for="value">Value</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base">
                                                        <p class="tag">
                                                            <input type="checkbox" name="type" id="type"
                                                                   v-model="query.type" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0" for="type">Type</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base">
                                                        <p class="tag">
                                                            <input type="checkbox" name="description" id="description"
                                                                   v-model="query.description" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0" for="description">Description</label>
                                                        </p>
                                                    </div>
                                                     <div class="align-items-center text-base">
                                                        <p class="tag">
                                                            <input type="checkbox" name="is_enable" id="is_enable"
                                                                   v-model="query.is_enable" v-on:click="check_one()">
                                                            <label class="pl-1 py-0 my-0" for="is_enable">Status</label>
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
                                    <th>Label</th>
                                    <th>value</th>
                                    <th>type</th>
                                    <th>Description</th>
                                    <th class="text-center">Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="questionnaire in questionnaires.data">
                                    <td class="text-left pr-5 my-0" @click="hideTooltip(questionnaire.id)">{{questionnaire.label}}</td>
                                    <td class="text-left py-0 my-0" @click="hideTooltip(questionnaire.id)">{{questionnaire.value}}</td>
                                    <td class="text-left py-0 my-0" @click="hideTooltip(questionnaire.id)">{{questionnaire.type}}</td>
                                    <td class="text-truncate" v-if="questionnaire.description.length >30">
                                    <span data-placement="bottom" :data-toggle="questionnaire.id"
                                        @click="showTooltip(questionnaire.id)" data-container="body"
                                        type="button" data-html="true" href="#" id="login">
                                    <span class="underline-dotted border-gray">
                                        {{ questionnaire.description.substring(0, 30)  }}
                                    </span>
                                    </span>
                                    <div class="container">
                                        <div :id="'popover-content-'+questionnaire.id" class="d-none">
                                            <div class="row custom-popover popover-max">
                                                <div class="col-12 px-2">

                                                    <span v-if="questionnaire.description">
                                                    <span class="font-weight-bold h5 mb-1 small">
                                                        Description
                                                    </span>
                                                    <p class="py-0 mb-0 small">
                                                        {{ questionnaire.description }}
                                                    </p>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-truncate" v-else>{{questionnaire.description}}</td>
                                    <td class="text-center" @click="hideTooltip(questionnaire.id)">
                                        <span v-if="questionnaire.is_enable == 1" class="badge badge-light-success badge-pill">Enable</span>
                                        <span v-else class="badge badge-light-danger badge-pill">Disable</span>
                                    </td>
                                    <td class="text-right py-0 my-0">
                                        <div class="dropdown">
                                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right">
                                    <a :href="route('questionnaires.edit',questionnaire.id)" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                    <a class="dropdown-item" v-on:click="confirmDelete(questionnaire.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked" @deleteitem="deleteItem"></ConfirmatiomModal>
            <div class="col-12 ">
                <pagination :links="questionnaires.links" class="float-right"></pagination>
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
    props: ['questionnaires', 'params'],
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
                label: false,
                value: false,
                type: false,
                description: false,
                is_enable: false,
                enable: false,
                disable: false,
                direction: null,
                product_id : false
            },
            sweetAlert: false,
            itemId: '',
            searchItem: false
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Questionnaires";
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
        resetQuery() {
            this.query = {}
            this.loadData()
        },
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {

            this.sweetAlert = false
            this.$inertia.delete(`/fulfilment/admin/questionnaires/${this.itemId}`)
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
            this.query.label = '';
            this.query.type = '';
            this.query.value = '';
            this.query.description ='';
            this.query.is_enable ='';
            this.loadData();
        },
        resetFilter() {
            this.query.direction = '';
            this.query.is_enable ='';
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

 check_one: function () {
      if ((this.query.label = false)) {
        this.query.label = true;
        this.query.type = [];
        this.query.value = [];
        this.query.description = [];
        this.query.message = [];
        this.query.is_enable = [];
      }
      if ((this.query.type = false)) {
        this.query.type = true;
        this.query.label = [];
        this.query.value = [];
        this.query.description = [];
        this.query.is_enable = [];
      }
      if ((this.query.value = false)) {
        this.query.value = true;
        this.query.label = [];
        this.query.type = [];
        this.query.description = [];
        this.query.is_enable = [];
      }
      if ((this.query.description = false)) {
        this.query.description = true;
        this.query.label = [];
        this.query.value = [];
        this.query.type = [];
        this.query.is_enable = [];
      }
      if ((this.query.is_enable = false)) {
        this.query.is_enable = true;
        this.query.label = [];
        this.query.type = [];
        this.query.value = [];
        this.query.description = [];
        this.query.is_enable = [];
      }
 },

        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('questionnaires.index'), {
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
.table-responsive {
    max-height:600px;
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
