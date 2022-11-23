<template>
  <admin-layout>
    <section id="basic-horizontal-layouts">
      <h4 class="mb-1">Attendance Report</h4>
      <form
        @submit.prevent="submit"
        class="form form-horizontal"
        enctype="multipart/form-data"
      >
        <div class="form-body">
          <div class="row pb-2" id="table-hover-row form-group">
            <div class="col-12">
              <div class="card py-0 my-0 bg-white">
                <div class="card-content">
                  <div class="row form-group ml-1 mr-1">
                    <div class="col-lg-1 col-md-1"></div>
                    <div class="col-lg-9 col-md-8 col-sm-6 mt-2 form-group">
                      <div class="form-group">
                        <input
                          class="form-control"
                          type="date"
                          name="datepicker"
                          id="datepicker"
                          v-model="form.datepicker"
                        />
                      </div>
                      <ErrorComponent input="datepicker"></ErrorComponent>
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-6 mt-2 form-group">
                      <div class="form-group">
                        <button
                          type="button"
                          class="btn btn-primary"
                          @click="refreshData"
                        >
                          Refresh
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="row my-1 mx-1">
                        <div class="col-lg-1 col-md-1"></div>
                        <div
                          class="
                            col-sm-2 col-lg-2
                            dashboard-users-success
                            text-truncate
                          "
                        >
                          <div class="card text-center">
                            <div class="card-content">
                              <div class="card-body py-1 rounded-2xl">
                                <div
                                  class="
                                    badge-circle
                                    badge-circle-lg
                                    badge-circle-primary
                                    mx-auto
                                    mb-50
                                  "
                                >
                                  <i class="bx bx-group font-medium-5"></i>
                                </div>
                                <div class="text-muted line-ellipsis">
                                  Total Employees
                                </div>
                                <h3 class="mb-0">{{ totalemployees }}</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="
                            col-sm-2 col-lg-2
                            dashboard-users-success
                            text-truncate
                          "
                        >
                          <div class="card text-center">
                            <div class="card-content">
                              <div class="card-body py-1 rounded-2xl">
                                <div
                                  class="
                                    badge-circle
                                    badge-circle-lg
                                    badge-circle-primary
                                    mx-auto
                                    mb-50
                                  "
                                >
                                  <i class="bx bx-user font-medium-5"></i>
                                </div>
                                <div class="text-muted line-ellipsis">
                                  On Time
                                </div>
                                <h3 class="mb-0">{{ ontime }}</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-2 col-lg-2 text-truncate">
                          <div class="card text-center">
                            <div class="card-content">
                              <div class="card-body py-1">
                                <div
                                  class="
                                    badge-circle
                                    badge-circle-lg
                                    badge-circle-warning
                                    mx-auto
                                    mb-50
                                  "
                                >
                                  <i class="bx bx-user font-medium-5"></i>
                                </div>
                                <div class="text-muted line-ellipsis">Late</div>
                                <h3 class="mb-0">{{ late }}</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="
                            col-sm-2 col-lg-2
                            dashboard-users-danger
                            text-truncate
                          "
                        >
                          <div class="card text-center">
                            <div class="card-content">
                              <div class="card-body py-1">
                                <div
                                  class="
                                    badge-circle
                                    badge-circle-lg
                                    badge-circle-light-danger
                                    mx-auto
                                    mb-50
                                  "
                                >
                                  <i class="bx bx-user font-medium-5"></i>
                                </div>
                                <div class="text-muted line-ellipsis">
                                  Absent
                                </div>
                                <h3 class="mb-0">{{ absent }}</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="
                            col-sm-2 col-lg-2
                            dashboard-users-danger
                            text-truncate
                          "
                        >
                          <div class="card text-center">
                            <div class="card-content">
                              <div class="card-body py-1">
                                <div
                                  class="
                                    badge-circle
                                    badge-circle-lg
                                    badge-circle-light-info
                                    mx-auto
                                    mb-50
                                  "
                                >
                                  <i class="bx bx-user font-medium-5"></i>
                                </div>
                                <div class="text-muted line-ellipsis">
                                  Present
                                </div>
                                <h3 class="mb-0 mr">{{ present }}</h3>
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
          <div class="row pb-3" id="table-hover-row">
            <div class="col-12">
              <div class="card-one py-0 my-0 bg-white">
                <div class="card-content">
                  <div data-repeater-list="group-a">
                    <div>
                      <div class="top d-flex flex-wrap">
                        <div class="action-filters flex-grow-1">
                          <div
                            id="DataTables_Table_0_filter"
                            class="dataTables_filter"
                          >
                            <div
                              class="
                                input-group
                                form-group
                                d-flex
                                position-relative
                                mt-1
                                px-2
                                pr-md-0
                              "
                            >
                              <input
                                type="text"
                                class="
                                  form-control
                                  border-light-gray
                                  btn-height
                                "
                                placeholder="Search..."
                                aria-label="Search"
                                aria-describedby="basic-addon2"
                                v-model="query.query"
                                @change="search"
                              />
                              <div class="input-group-append">
                                <button
                                  class="input-group-text search-btn"
                                  @change="search"
                                >
                                  <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="23"
                                    height="23"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="
                                      feather feather-search feather-16
                                      pb-0
                                      mb-0
                                      mt-0
                                    "
                                  >
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line
                                      x1="21"
                                      y1="21"
                                      x2="16.65"
                                      y2="16.65"
                                    ></line>
                                  </svg>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="
                            actions
                            action-btns
                            d-flex
                            align-items-center
                            flex flex-wrap
                            filter-container
                            pl-1
                          "
                        >
                          <div
                            class="
                              dropdown
                              md:w-1/2
                              sm:w-1
                              pr-1
                              filter-dropdown
                            "
                          >
                            <button
                              class="btn border dropdown-toggle w-100"
                              type="button"
                              data-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false"
                            >
                              Filter
                            </button>
                            <div
                              class="
                                dropdown-menu dropdown-menu-right
                                py-0
                                my-0
                                custom-dropdown
                              "
                              @click="stopPropagation"
                              aria-labelledby=""
                            >
                              <div class="col-12 pl-2 pt-1">
                                <div class="d-inline-flex w-100">
                                  <h6 class="py-0 my-0">Status</h6>
                                  <span
                                    class="primary pl-20 ml-2 pointer"
                                    @click="resetFilter"
                                    >Reset</span
                                  >
                                </div>
                                <div class="align-items-center text-base pt-1">
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="enable"
                                      id="enable"
                                      v-model="query.enable"
                                    />
                                    <label class="pl-1 py-0 my-0" for="enable"
                                      >Absent</label
                                    >
                                  </p>
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="disable"
                                      id="disable"
                                      v-model="query.disable"
                                    />
                                    <label class="pl-1 py-0 my-0" for="disable"
                                      >Present</label
                                    >
                                  </p>
                                </div>
                              </div>
                              <div class="dropdown-divider py-0 my-0"></div>
                              <div class="col-12 pl-2">
                                <p class="pt-1">
                                  <button
                                    type="button"
                                    id="asc"
                                    @click="filter"
                                    class="
                                      btn btn-sm btn-primary
                                      font-small font-weight-normal
                                      stock-order
                                    "
                                  >
                                    Filter
                                  </button>
                                </p>
                              </div>
                            </div>
                          </div>
                          <div
                            class="dropdown md:w-1/2 sm:w-1 pr-2 sort-dropdown"
                          >
                            <button
                              class="btn border dropdown-toggle w-100"
                              type="button"
                              data-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false"
                            >
                              Sort
                            </button>
                            <div
                              class="
                                dropdown-menu dropdown-menu-right
                                py-0
                                my-0
                                custom-dropdown
                              "
                              aria-labelledby=""
                              @click="stopPropagation"
                            >
                              <div class="col-12 pl-2 pt-2">
                                <div class="d-inline-flex w-100">
                                  <h6 class="py-0 my-0">Sort</h6>
                                  <span
                                    class="primary pl-20 ml-2 pointer"
                                    @click="resetSort"
                                    >Reset</span
                                  >
                                </div>
                                <div class="align-items-center text-base pt-1">
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="name"
                                      id="name"
                                      v-model="query.name" v-on:click="check_one()"
                                    />
                                    <label class="pl-1 py-0 my-0" for="name"
                                      >Name</label
                                    >
                                  </p>
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="clock_in_at"
                                      id="clock_in_at"
                                      v-model="query.clock_in_at" v-on:click="check_one()"
                                    />
                                    <label
                                      class="pl-1 py-0 my-0"
                                      for="clock_in_at"
                                      >Check In</label
                                    >
                                  </p>
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="clock_in_at"
                                      id="clock_in_at"
                                      v-model="query.clock_out_at" v-on:click="check_one()"
                                    />
                                    <label
                                      class="pl-1 py-0 my-0"
                                      for="clock_in_at"
                                      >Check Out</label
                                    >
                                  </p>
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="clock_in_at"
                                      id="clock_in_at"
                                      v-model="query.late_minutes" v-on:click="check_one()"
                                    />
                                    <label
                                      class="pl-1 py-0 my-0"
                                      for="clock_in_at"
                                      >Late</label
                                    >
                                  </p>
                                </div>
                              </div>
                              <div class="dropdown-divider py-0 my-0"></div>
                              <div class="col-12 pl-2 d-inline-flex">
                                <p class="pt-1">
                                  <button
                                    type="button"
                                    id="asce"
                                    @click="sort('asc')"
                                    class="
                                      btn btn-sm btn-primary
                                      font-small font-weight-normal
                                      stock-order
                                    "
                                  >
                                    Asc
                                  </button>
                                </p>
                                <p class="pt-1 pl-3">
                                  <button
                                    type="button"
                                    id="desc"
                                    @click="sort('desc')"
                                    class="
                                      btn btn-sm btn-light-secondary
                                      font-small font-weight-normal
                                      stock-order
                                    "
                                  >
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
                          <th class="text-truncate">Name</th>
                          <th class="text-center text-truncate">Check In</th>
                          <th class="text-center text-truncate">Check Out</th>
                          <th class="text-center text-truncate">Late</th>
                          <th class="text-center">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="employeeAttendence in employeeAttendences">
                          <td class="text-truncate">
                            {{
                              employeeAttendence ? employeeAttendence.name : ""
                            }}
                          </td>
                          <td class="text-center text-truncate">
                            {{ employeeAttendence.clock_in_at }}
                          </td>
                          <td class="text-center text-truncate">
                            {{ employeeAttendence.clock_out_at }}
                          </td>
                          <td
                            class="text-center text-truncate"
                            v-if="employeeAttendence.late_minutes <= 0"
                          >
                            {{ "---" }}
                          </td>
                          <td class="text-center text-truncate" v-else>
                            {{ employeeAttendence.late_minutes }} 
                          </td>
                          <td class="py-0 my-0 text-center text-truncate">
                            <span
                              class="badge badge-light-danger badge-pill"
                              v-if="employeeAttendence.is_absent == '1'"
                              >Absent</span
                            >
                            <span
                              class="badge badge-light-success badge-pill"
                              v-else
                              >Present</span
                            >
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <ConfirmatiomModal
              v-if="sweetAlert"
              :sweetAlert="sweetAlert"
              @clicked="Clicked"
              @deleteitem="deleteItem"
            ></ConfirmatiomModal>
            <!-- <div class="col-12 ">
                          <pagination :links="employeeAttendences.links" class="float-right"></pagination>
                     </div> -->
          </div>
        </div>
      </form>
    </section>
  </admin-layout>
</template>

<script>
import moment from 'moment';
import { useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "../../../Layouts/AdminLayout";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";

export default {
  name: "show",
  props: [
    "totalemployees",
    "ontime",
    "date",
    "late",
    "absent",
    "present",
    "params",
    "employeeAttendences",
  ],

  components: {
    AdminLayout,
    ConfirmatiomModal,
  },
  setup() {
    const form = useForm({
      datepicker: "",
    });
    return { form };
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
        datepicker: false,
        employee_id: false,
      },
      itemId: "",
      sweetAlert: false,
      searchItem: false,
    };
  },
  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Employees Attendence";
  },
  mounted() {
    this.form.datepicker = this.date;
    if (this.params) {
      let params = Object.keys(this.params);
      for (let i of params) {
        Object.assign(this.query, { [i]: this.params[i] });
      }
    }
  },
  methods: {
    refreshData() {
      this.$inertia.visit(route("attendence.show"), {
        method: "get",
        data: {
          date: this.form.datepicker,
        },
      });
    },
    resetQuery() {
      this.query = {};
      this.loadData();
    },

    Clicked() {
      this.sweetAlert = false;
    },
    stopPropagation(e) {
      e.stopPropagation();
    },
    resetSort(e) {
      this.query.direction = "";
      this.query.clock_in_at = "";
      this.query.clock_out_at = "";
      this.query.late_minutes = "";
      this.query.name = "";
      this.loadData();
    },
    resetFilter() {
      this.query.direction = "";
      this.query.absent = "";
      this.query.present = "";
  
      this.loadData();
    },
    check_one: function () {
      if ((this.query.name = false)) {
        this.query.name = true;
        this.query.clock_in_at = [];
        this.query.clock_out_at = [];
        this.query.late_minutes = [];
      }
      if ((this.query.clock_in_at = false)) {
        this.query.clock_in_at = true;
        this.query.name = [];
        this.query.clock_out_at = [];
        this.query.late_minutes = [];
      }
      if ((this.query.clock_out_at = false)) {
        this.query.clock_out_at = true;
        this.query.clock_in_at = [];
        this.query.name = [];
        this.query.late_minutes = [];
      }
      if ((this.query.late_minutes = false)) {
        this.query.late_minutes = true;
        this.query.clock_in_at = [];
        this.query.clock_out_at = [];
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
      let date = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
          Object.assign(date, { date: this.form.datepicker });
        }
      }
      this.$inertia.visit(route("attendence.show"), {
        method: "get",
        data: {
          ...query,
          ...date,
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

.row1 {
  margin-left: 1.3px;
  margin-right: 1.3px;
}
.ml1 {
  margin-left: 4px;
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

  #a {
    order: 1;
  }
  #b {
    order: 2;
  }
}
</style>
