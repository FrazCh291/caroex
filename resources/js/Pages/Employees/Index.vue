<template>
  <admin-layout>
    <div class="row">
      <div class="col-md-10 col-lg-10 col-sm-10 px-1 pb-0 mb-0">
        <div class="col form-group p-0">
          <a :href="route('employees.create')" class="btn btn-primary  mr-1" data-repeater-create="">
            <span class="px-0.5">Add Employee</span>
          </a>
        </div>
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
                                    <div class="actions action-btns d-flex align-items-center sort-dropdown pl-1">
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
                                                                class="pl-1 py-0 my-0" for="disable">InActive</label>
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
                  <div class="dropdown w-100 pr-2 sort-dropdown2">
                      <button class="btn border dropdown-toggle w-100" type="button"
                              data-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false">
                          Sort
                      </button>
                      <div class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"
                            aria-labelledby="" @click="stopPropagation">
                          <div class="col-12 pl-2 pt-2">
                              <div class="d-inline-flex w-100">
                                  <h6 class="py-0 my-0">Sort</h6>
                                  <span class="primary pl-20 ml-2 pointer" @click="resetSort">Reset</span>
                              </div>
                                <div class="align-items-center text-base pt-1">
                                  <p class="tag">
                                      <input type="checkbox" name="name" id="name"
                                              v-model="query.name" v-on:click="check_one()" >
                                      <label class="pl-1 py-0 my-0" for="label">Name</label>
                                  </p>
                                    <p class="tag">
                                      <input type="checkbox" name="email" id="email"
                                              v-model="query.email" v-on:click="check_one()">
                                      <label class="pl-1 py-0 my-0" for="label">Email</label>
                                  </p>
                                    <p class="tag">
                                      <input type="checkbox" name="phone" id="phone"
                                              v-model="query.phone" v-on:click="check_one()" >
                                      <label class="pl-1 py-0 my-0" for="Phone">Phone</label>
                                  </p>
                                    <p class="tag">
                                      <input type="checkbox" name="status" id="is_status"
                                              v-model="query.is_status" v-on:click="check_one()">
                                      <label class="pl-1 py-0 my-0" for="is_status">Status</label>
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
                    <th class="text-left text-truncate name-header">Name</th>
                    <th class="text-left text-truncate">Email</th>
                    <th class="text-center text-truncate">Phone</th>
                    <th class="text-center text-truncate">Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="employee in employees.data" :key="employee.id">
                    <td class="py-1 my-0 text-left text-truncate">
                      <img :src="employee.image" class="rounded-circle d-inline-block mr-1"
                        style="height: 40px; width: 40px" v-if="employee.image" />
                      <img :src="'/img/avator.jpg'" class="rounded-circle d-inline-block mr-1"
                        style="height: 40px; width: 40px" v-else />{{employee.name}}
                    </td>
                    <td class="py-0 my-0 text-left text-truncate">
                      {{employee.email}}
                    </td>
                    <td class="py-0 my-0 text-center text-truncate">
                      {{employee.phone}}
                    </td>
                    <td class="py-0 my-0 text-center text-truncate">
                      <span class="badge badge-light-success badge-pill" v-if="employee.is_status == '1'">Active</span>
                      <span class="badge badge-light-danger badge-pill" v-else>Inactive</span>
                    </td>
                    <td class="text-right py-0 my-0 custom-padding-right">
                      <div class="dropdown">
                        <span
                          class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"
                          data-boundary="window">
                        </span>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a :href="route('employees.show', employee.id)" class="dropdown-item"><i
                              class="bx bx-show mr-1"></i>Show</a>
                          <a :href="route('employees.edit', employee.id)" class="dropdown-item"><i
                              class="bx bx-edit-alt mr-1"></i>Edit</a>
                          <a v-on:click="confirmDelete(employee.id)" class="dropdown-item"><i
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
        <pagination :links="employees.links" class="float-right"></pagination>
      </div>
    </div>
  </admin-layout>
</template>

<script>
  import moment from 'moment';
  import Button from "../../Jetstream/Button";
  import Pagination from "../../admin/Pagination";
  import AdminLayout from "../../Layouts/AdminLayout";
  import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
  export default {
    name: "index",
    props: ["employees", "params"],

    components: {
      Button,
      Pagination,
      AdminLayout,
      ConfirmatiomModal,
    },

    data() {
      return {
        query: {
          query: "",
          id: false,
          name: false,
          enable: false,
          disable: false,
          direction: null,
          employee_id: false,
        },
        itemId: "",
        sweetAlert: false,
        searchItem: false,
      };
    },
    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - Employees";
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
      resetQuery() {
        this.query = {};
        this.loadData();
      },

      Clicked() {
        this.sweetAlert = false;
      },
      deleteItem() {
        this.sweetAlert = false;
        this.$inertia.delete(`/erp/employees/${this.itemId}`);
      },
      confirmDelete(id) {
        this.sweetAlert = true;
        this.itemId = id;
      },
      stopPropagation(e) {
        e.stopPropagation();
      },
      resetSort(e) {
        this.query.name = "";
        this.query.email = "";
        this.query.phone = "";
        this.query.is_status = "";
        this.loadData();
      },
      resetFilter() {
        this.query.disable = "";
        this.query.enable = "";
        this.loadData();
      },
      check_one: function () {
      if ((this.query.name = false)) {
        this.query.name = true;
        this.query.email = [];
        this.query.phone = [];
        this.query.is_status = [];
      }
      if ((this.query.email = false)) {
        this.query.email = true;
        this.query.name = [];
        this.query.phone = [];
        this.query.is_status = [];
      }
      if ((this.query.phone = false)) {
        this.query.phone = true;
        this.query.email = [];
        this.query.name = [];
        this.query.is_status = [];
      }
      if ((this.query.is_status = false)) {
        this.query.is_status = true;
        this.query.email = [];
        this.query.phone = [];
        this.query.name = [];
      }
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
      loadData() {
        let query = {};
        for (let item in this.query) {
          if (this.query[item]) {
            Object.assign(query, { [item]: this.query[item] });
          }
        }
        this.$inertia.visit(route("employees.index"), {
          method: "get",
          data: {
            ...query,
          },
        });
      },
      formatDate(date) {
        return moment(date).format("DD/MM/YYYY");
      },
    },
  };
</script>

<style scoped>
  .action {
    margin-right: 4px !important;
    margin-top: 10px !important;
    margin-bottom: 10px !important;
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

  .name-header {
    padding-left: 90px;
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