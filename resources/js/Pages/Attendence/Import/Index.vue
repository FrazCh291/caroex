<template>
  <admin-layout>
    <section id="basic-horizontal-layouts">
      <div class="col-12 px-0">
        <div class="col form-group p-0">
          <a :href="route('attendence.import.create')" class="btn btn-primary" data-repeater-create="">
            Add Import
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="row mt-0" id="table-hover-row">
              <div class="col-12">
                <div class="card py-0 my-0 bg-white ml-0 border-top-0 border-right-0 border-left-0">
                  <div class="card-content">
                    <div data-repeater-list="group-a">
                      <div>
                        <div class="top d-flex flex-wrap">
                          <div class="action-filters flex-grow-1">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter mr-1.5">
                              <div class="input-group form-group d-flex position-relative mt-1 px-2 pr-md-0">
                                <input type="text" class=" form-control border-light-gray btn-height"
                                  placeholder="Search..." aria-label="Search" aria-describedby="basic-addon2"
                                  v-model="query.query" @change="search" />
                                <div class="input-group-append">
                                  <button class="input-group-text search-btn" @change="search">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"
                                      fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round" class="
                                          feather feather-search feather-16
                                          pb-0
                                          mb-0
                                          mt-0
                                        ">
                                      <circle cx="11" cy="11" r="8"></circle>
                                      <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="
                                actions
                                action-btns
                                d-flex
                                align-items-center
                                sort-dropdown
                                pl-1
                              ">
                            <div class="dropdown w-100 pr-2 sort-dropdown2">
                              <button class="btn border dropdown-toggle w-100" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Sort
                              </button>
                              <div class="
                                    dropdown-menu dropdown-menu-right
                                    py-0
                                    my-0
                                    custom-dropdown
                                  " aria-labelledby="" @click="stopPropagation">
                                <div class="col-12 pl-2 pt-1">
                                  <div class="d-inline-flex w-100">
                                    <h6 class="py-0 my-0">Sort</h6>
                                    <span class="primary pl-20 ml-2 pointer" @click="resetSort">Reset</span>
                                  </div>
                                  <div class="align-items-center text-base pt-1">
                                    <p class="tag">
                                      <input type="checkbox" name="created_at" id="created_at"
                                        v-model="query.created_at" v-on:click="check_one()" />
                                      <label class="pl-1 py-0 my-0" for="created_at">Date</label>
                                    </p>
                                    <p class="tag">
                                      <input type="checkbox" name="starting_date" id="starting_date"
                                        v-model="query.starting_date" v-on:click="check_one()"/>
                                      <label class="pl-1 py-0 my-0" for="starting_date">Starting Date</label>
                                    </p>
                                    <p class="tag">
                                      <input type="checkbox" name="ending_date" id="ending_date"
                                        v-model="query.ending_date" v-on:click="check_one()"/>
                                      <label class="pl-1 py-0 my-0" for="ending_date">Ending Date</label>
                                    </p>
                                    <p class="tag">
                                      <input type="checkbox" name="updated_at" id="updated_at"
                                        v-model="query.updated_at" v-on:click="check_one()" />
                                      <label class="pl-1 py-0 my-0" for="updated_at">Import By</label>
                                    </p>
                                  </div>
                                </div>
                                <div class="dropdown-divider py-0 my-0"></div>
                                <div class="col-12 pl-2 d-inline-flex">
                                  <p class="pt-1">
                                    <button type="button" id="asce" @click="sort('asc')" class="
                                          btn btn-sm btn-primary
                                          font-small font-weight-normal
                                          stock-order
                                        ">
                                      Asc
                                    </button>
                                  </p>
                                  <p class="pt-1 pl-3">
                                    <button type="button" id="desc" @click="sort('desc')" class="
                                          btn btn-sm btn-light-secondary
                                          font-small font-weight-normal
                                          stock-order
                                        ">
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
            </div>
            <div class="col-12 border-0 p-0">
              <div class="card py-0 border-0 my-0 bg-white ml-0">
                <div class="card-content">
                  <div class="table-responsive">
                    <table class="table table-hover mb-0">
                      <thead>
                        <tr>
                          <th class="">Date</th>
                          <th class="text-truncate">Starting Date</th>
                          <th class="text-truncate">Ending Date</th>
                          <th class="text-truncate">Import By</th>
                          <th class="text-truncate"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="date in datetimes.data">
                          <td class="text-truncate">
                            {{
                            formatDate(
                            date.created_at ? date.created_at : ""
                            )
                            }}
                          </td>
                          <td class="text-truncate">
                            {{
                            format_date(
                            date.starting_date ? date.starting_date : ""
                            )
                            }}
                          </td>
                          <td class="text-truncate">
                            {{
                            format_date(
                            date.ending_date ? date.ending_date : ""
                            )
                            }}
                          </td>
                          <td class="text-truncate">
                            {{ date.user_name ? date.user_name : "" }}
                          </td>
                          <td class="text-right py-0 my-0">

                            <div class="dropdown">
                              <span
                                class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                              </span>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a :href=" route('attendence.file.export', date.documents[0].id)"
                                  class="dropdown-item"><i class=" bx bx-download mr-1"></i>Download</a>
                                <a class="dropdown-item" v-on:click="confirmDelete(date.id)"><i
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
          </div>
        </div>
      </div>
      <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked" @deleteitem="deleteItem">
      </ConfirmatiomModal>
      <div class="col-sm-12 px-0">
        <div>
          <pagination :links="datetimes.links" class="float-right"></pagination>
        </div>
      </div>

    </section>
  </admin-layout>
</template>
<script>
  import moment from "moment";
  import { useForm } from "@inertiajs/inertia-vue3";
  import Pagination from "../../../admin/Pagination";
  import AdminLayout from "../../../Layouts/AdminLayout";
  import ErrorComponent from "../../../components/ErrorComponent";
  import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";

  export default {
    name: "Index",
    props: ["datetimes", "errors", "params"],

    components: {
      AdminLayout,
      ErrorComponent,
      Pagination,
      ConfirmatiomModal,
    },

    setup() {
      const form = useForm({
        file: "",
      });
      return { form };
    },
    data() {
      return {
        query: {
          query: "",
          id: false,
          enable: false,
          disable: false,
          direction: null,
          user_name: false,
          created_at: false,
          ending_date: false,
          starting_date: false,
        },
        sweetAlert: false,
        itemId: "",
      };
    },
    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - Attendence Import";
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
      format_date(date) {
        if (date) {
          return moment(String(date)).format("DD/MM/YYYY");
        }
      },
      formatDate(date) {
        return moment(date).format('h:mm a DD MMM YY')
      },

      submit() {
        this.form.post("/erp/attendence-store");
      },

      onFileChange(event) {
        this.form.file = event.target.files[0];
      },

      stopPropagation(e) {
        e.stopPropagation();
      },

      Clicked() {
        this.sweetAlert = false;
      },
      deleteItem() {
        this.sweetAlert = false;
        this.$inertia.delete(`/erp/attendence-file-delete/${this.itemId}`);
      },
      confirmDelete(id) {
        this.sweetAlert = true;
        this.itemId = id;
      },
      resetSort(e) {
        this.query.direction = "";
        this.query.updated_at = "";
        this.query.created_at = "";
        this.query.ending_date = "";
        this.query.starting_date = "";
        this.loadData();
      },
      check_one: function () {
      if ((this.query.created_at = false)) {
        this.query.created_at = true;
        this.query.starting_date = [];
        this.query.ending_date = [];
        this.query.updated_at = [];
      }
      if ((this.query.starting_date = false)) {
        this.query.starting_date = true;
        this.query.created_at = [];
        this.query.ending_date = [];
        this.query.updated_at = [];
      }
      if ((this.query.ending_date = false)) {
        this.query.ending_date = true;
        this.query.starting_date = [];
        this.query.created_at = [];
        this.query.updated_at = [];
      }
      if ((this.query.updated_at = false)) {
        this.query.updated_at = true;
        this.query.starting_date = [];
        this.query.created_at = [];
        this.query.ending_date = [];
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
        this.$inertia.visit(route("attendence.import"), {
          method: "get",
          data: {
            ...query,
          },
        });
      },
    },
  };
</script>

<style scoped>
  .line {
    border-top: 1px dashed #c7cfd6;
    width: 100%;
  }

  .error {
    margin-top: 0px !important;
  }

  .custom-padding {
    padding: 7px;
  }

  @media screen and (max-width: 600px) {
    #import-button {
      padding-left: 0px;
    }
  }

  @media screen and (min-width: 1200px) {
    #file {
      margin-left: 5px;
    }

    #import-button {
      padding-left: 32px;
    }
  }
</style>