<template>
  <admin-layout>
    <div class="col-12 px-0">
      <h4>Employee Salary History</h4>
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
                          class="form-control border-light-gray btn-height"
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
                    <div class="dropdown w-100 pr-1 sort-dropdown2">
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
                        <div class="col-12 pl-2 pt-1">
                          <div class="d-inline-flex w-100">
                            <h6 class="py-0 my-0">Sort</h6>
                            <span
                              class="primary pl-20 ml-2 pointer"
                              @click="resetSort"
                              >Reset</span
                            >
                          </div>
                          <div class="text-base pt-1">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="name"
                                id="name"
                                v-model="query.name"
                              />
                              <label class="pl-1 py-0 my-0" for="name"
                                >Name</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="employee_id"
                                id="employee_id"
                                v-model="query.employee_id"
                              />
                              <label class="pl-1 py-0 my-0" for="employee_id"
                                >Emp #</label
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
                    <th class="">Name</th>
                    <th class="">Work Days</th>
                    <th class="text-center">Salary</th>
                    <th class="text-center">Adjustments</th>
                    <th class="text-center">Deductions</th>
                    <th class="text-center">Total Salary</th>
                    <th class=""></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="employee in employees" :key="employee.id">
                    <td class="" id="tooltip-target-3">
                      <span
                        data-placement="bottom"
                        :data-toggle="'employee' + employee.id"
                        @click="showTooltip2(employee.id)"
                        data-container="body"
                        type="button"
                        data-html="true"
                        href="#"
                        id=""
                      >
                        <span class="underline-dotted border-gray">
                          {{ employee.name }}
                        </span>
                      </span>
                      <div class="container">
                        <div
                          :id="'popover-content-employee' + employee.id"
                          class="d-none"
                        >
                          <div class="row custom-popover popover-max">
                            <div class="col-12 px-2">
                              <span>
                                <span class="ml-1 mt-1 h5 mb-1 small">{{
                                  employee.name
                                }}</span
                                ><br />
                                <span class="ml-1 h5 mb-1 small">{{
                                  employee.phone
                                }}</span
                                ><br />
                                <span class="ml-1 h5 mb-1 small">{{
                                  employee.cnic
                                }}</span
                                ><br />
                                <span class="ml-1 h5 mb-1 small">{{
                                  employee.email
                                }}</span
                                ><br />
                                <span class="ml-1 h5 mb-1 small">{{
                                  employee.total_salary
                                }}</span>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="">{{ employee.employee_id }}</td>
                    <td class="text-center" id="tooltip-target-1">
                      <span
                        data-placement="bottom"
                        :data-toggle="employee.id"
                        @click="showTooltip(employee.id)"
                        data-container="body"
                        type="button"
                        data-html="true"
                        href="#"
                        id=""
                      >
                        <span class="underline-dotted border-gray">
                          {{
                            employee.salaries[0]
                              ? employee.salaries[0].net_total
                              : "00.0"
                          }}
                        </span>
                      </span>
                      <div class="container">
                        <div
                          :id="'popover-content-' + employee.id"
                          class="d-none"
                        >
                          <div class="row custom-popover popover-max">
                            <div class="col-12 px-2">
                              <span>
                                <span class="font-weight-bold h4 mb-1 small">
                                  Salary History </span
                                ><br />
                                <div>
                                  <span
                                    class="
                                      mt-1
                                      ml-1
                                      h5
                                      mb-1
                                      small
                                      font-weight-bold
                                    "
                                    >Date</span
                                  >
                                  <span
                                    class="ml-3 h5 mb-1 small font-weight-bold"
                                    >Gross Total</span
                                  >
                                  <span
                                    class="ml-3 h5 mb-1 small font-weight-bold"
                                    >Net Total</span
                                  >
                                </div>
                                <div
                                  v-for="employeeSalary in employee.salaries"
                                >
                                  <span class="mt-1 h5 mb-1 small">{{
                                    formatDate(employeeSalary.created_at)
                                  }}</span>
                                  <span class="ml-2 h5 mb-1 small">{{
                                    employeeSalary.gross
                                  }}</span>
                                  <span class="ml-4 h5 mb-1 small">{{
                                    employeeSalary.net_total
                                  }}</span>
                                </div>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="text-center" id="tooltip-target-1">
                      <span
                        data-placement="bottom"
                        :data-toggle="'addition' + employee.id"
                        @click="showTooltip3(employee.id)"
                        data-container="body"
                        type="button"
                        data-html="true"
                        href="#"
                        id=""
                      >
                        <span class="underline-dotted border-gray">
                          {{
                            employee.adjustments[0]
                              ? employee.adjustments[0].amount
                              : "00.0"
                          }}
                        </span>
                      </span>
                      <div class="container">
                        <div
                          :id="'popover-content-addition' + employee.id"
                          class="d-none"
                        >
                          <div class="row custom-popover popover-max">
                            <div class="col-12 px-2">
                              <span>
                                <span class="font-weight-bold h4 mb-1 small">
                                  Adjustments </span
                                ><br />
                                <div>
                                  <span
                                    class="
                                      mt-1
                                      ml-1
                                      h5
                                      mb-1
                                      small
                                      font-weight-bold
                                    "
                                    >Date</span
                                  >
                                  <span
                                    class="ml-3 h5 mb-1 small font-weight-bold"
                                    >Amount</span
                                  >
                                  <span
                                    class="ml-3 h5 mb-1 small font-weight-bold"
                                    >Reason</span
                                  >
                                </div>
                                <div v-for="adustment in employee.adjustments">
                                  <span class="mt-1 h5 mb-1 small">{{
                                    formatDate(adustment.created_at)
                                  }}</span>
                                  <span class="ml-2 h5 mb-1 small">{{
                                    adustment.amount
                                  }}</span>
                                  <span class="ml-4 h5 mb-1 small">{{
                                    adustment.reason
                                  }}</span>
                                </div>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="text-center" id="tooltip-target-2">
                      <span
                        data-placement="bottom"
                        :data-toggle="'deduction' + employee.id"
                        @click="showTooltip1(employee.id)"
                        data-container="body"
                        type="button"
                        data-html="true"
                        href="#"
                        id="login"
                      >
                        <span class="underline-dotted border-gray">
                          {{
                              employee.salaries[0]
                                ? employee.salaries[0].total_detuction
                                : ""
                          }}
                        </span>
                      </span>
                      <div class="container">
                        <div
                          :id="'popover-content-deduction' + employee.id"
                          class="d-none"
                        >
                          <div class="row custom-popover popover-max">
                            <div class="col-12 px-2">
                              <div>
                                <span class="font-weight-bold h5 mb-1 small">
                                  Salary Deduction </span
                                ><br />
                                <div>
                                  <span
                                    class="
                                      mt-1
                                      ml-1
                                      h5
                                      mb-1
                                      small
                                      font-weight-bold
                                    "
                                    >Date</span
                                  >
                                  <span
                                    class="ml-3 h5 mb-1 small font-weight-bold"
                                    >Tax 5%
                                  </span>
                                  <span
                                    class="
                                      ml-2
                                      h5
                                      mb-1
                                      small
                                      font-weight-bold
                                      text-truncate
                                    "
                                    >Leaves + Tax Deduction</span
                                  > 
                                </div>
                                <div
                                  v-for="employeeSalary in employee.salaries"
                                >
                                  <span class="mt-1 h5 mb-1 small">{{
                                    formatDate(employeeSalary.created_at)
                                  }}</span>
                                  <span class="ml-2 h5 mb-1 small"
                                    >{{ employeeSalary.tax }}
                                  </span>
                                  <span class="ml-5 h5 mb-1 small">{{
                                    employeeSalary.total_detuction
                                  }}</span> 
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                       {{
                          employee.salaries_sum_net_total
                              ? employee.salaries_sum_net_total
                              : "00.0"
                          }}
                    </td>
                    <td class="text-right py-0 my-0 custom-padding-right">
                      <div class="btn-group dropright float-right mr-5">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="25"
                          height="25"
                          fill="currentColor"
                          class="
                            mt-0
                            bi bi-three-dots
                            DotsYaxis
                            dropdown-toggle
                          "
                          viewBox="0 0 16 16"
                          data-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          <path
                            d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"
                          />
                        </svg>
                        <div class="dropdown-menu">
                          <div class="col-12 p-0">
                            <span class="d-flex flex-col">
                              <a>
                                <button
                                  type="button"
                                  class="modalBtn access mt-2"
                                  data-toggle="modal"
                                  data-target="#viewModel"
                                  data-whatever="@mdo"
                                >
                                  <span class="mt-1 ml-2 mr-2">View</span>
                                </button>
                              </a>
                              <a>
                                <button
                                  type="button"
                                  class="modalBtn access mt-1"
                                  data-toggle="modal"
                                  data-target="#payslipModal"
                                  data-whatever="@mdo"
                                >
                                  <span class="mt-1 ml-2 mr-2">Payslip</span>
                                </button>
                              </a>
                              <a>
                                <button
                                  type="button"
                                  class="modalBtn access mt-1 mb-1"
                                  data-toggle="modal"
                                  @click="addition(employee.id)"
                                  data-target="#additionModel"
                                  data-whatever="@mdo"
                                >
                                  <span class="mt-2 ml-2 mr-2 mb-2"
                                    >Adjustments</span
                                  >
                                </button>
                              </a>
                            </span>
                          </div>
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
      <section id="basic-horizontal-layouts">
        <div class="card-content">
          <div>
            <div class="row mt-0 ml-1">
              <div
                class="modal fade"
                id="additionModel"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
              >
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">
                        Adjustments
                      </h5>
                      <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                      >
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form @submit.prevent="submit" class="form form-horizontal">
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="amount" class="col-form-label"
                            >Amount:</label
                          >
                          <input
                            type="text"
                            id="amount"
                            v-model="form.amount"
                            class="form-control"
                            name="from"
                          />
                        </div>
                        <div class="form-group">
                          <label for="message" class="col-form-label"
                            >Reason:</label
                          >
                          <textarea
                            class="form-control"
                            id="message"
                            v-model="form.reason"
                            placeholder="message"
                          ></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div
                          class="col-sm-11 d-flex justify-content-start px-0"
                        >
                          <button
                            type="submit"
                            class="btn btn-primary mr-1 mb-1"
                          >
                            Save
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="basic-horizontal-layouts">
        <div class="card-content" id="addItems">
          <div>
            <div class="row mt-0 ml-1">
              <div
                class="modal fade"
                id="payslipModal"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
              >
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">
                        Payslip
                      </h5>
                      <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                      >
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <span>hello</span>
                    </div>
                    <div class="modal-footer">
                      <div class="col-sm-11 d-flex justify-content-start px-0">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                          Save
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="basic-horizontal-layouts">
        <div class="card-content">
          <div>
            <div class="row mt-0 ml-1">
              <div
                class="modal fade"
                id="viewModel"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
              >
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">
                        View Salary
                      </h5>
                      <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                      >
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form
                        @submit.prevent="submit"
                        class="form form-horizontal"
                      ></form>
                    </div>
                    <div class="modal-footer">
                      <div
                        class="col-sm-11 d-flex justify-content-start px-0"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <ConfirmatiomModal
        v-if="sweetAlert"
        :sweetAlert="sweetAlert"
        @clicked="Clicked"
        @deleteitem="deleteItem"
      ></ConfirmatiomModal>
      <!--            <div class="col-12 ">-->
      <!--                <pagination :links="companies.links" class="float-right"></pagination>-->
      <!--            </div>-->
    </div>
  </admin-layout>
</template>

<script>
import moment from "moment";
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button";
import { useForm } from "@inertiajs/inertia-vue3";
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {
  name: "Index",
  props: ['employees','params'],
  components: {
    Button,
    AdminLayout,
    Pagination,
    ConfirmatiomModal,
  },
  setup() {
    const form = useForm({
      id: "",
      amount: "",
      reason: "",
    });
    return { form };
  },
  data() {
    return {
      query: {
        query: "",
        id: false,
        name: false,
        type: null,
        enable: false,
        disable: false,
        direction: null,
      },
      sweetAlert: false,
      itemId: "",
      totalSalery: [],
      searchItem: false,
    };
  },

  beforeMount() {
    console.log(this.employees, 'raiiiiiiss');
    document.title = process.env.MIX_APP_NAME + " - Create Module";
  },
  mounted() {
    if (this.params) {
      Object.assign(this.query, this.params);
    }
  },
  methods: {
    submit() {
      if (this.update) {
        this.form.post(route("salaries.update"));
      } else {
        this.form.post("/erp/salaries");
         $('#additionModel').modal('hide')
      }
    },
    resetQuery() {
      this.query = {};
      this.loadData();
    },
    addition(id) {
      this.form.id = id;
    },
    Clicked() {
      this.sweetAlert = false;
    },
    deleteItem() {
      this.sweetAlert = false;
      this.$inertia.delete(`/samples/${this.itemId}`);
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
      this.query.direction = "";
      this.query.id = "";
      this.query.name = "";
      this.query.enable = "";
      this.query.disable = "";
      this.loadData();
    },
    resetFilter() {
      this.query = {};
      this.query.id = "";
      this.query.name = "";
      this.query.direction = "";
      this.query.enable = "";
      this.query.disable = "";
      this.loadData();
    },

    search() {
      this.searchItem = true;
      this.query.type = this.type;
      this.loadData();
    },
    filter() {
      this.loadData();
    },
    sort(direction) {
      this.query.direction = direction;
      this.loadData();
    },

    formatDate(created_at) {
      return moment(created_at).format("DD/MM/YYYY");
    },
    loadData() {
      let query = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
        }
      }
      this.$inertia.visit(route("salaries.index"), {
        method: "get",
        data: {
          ...query,
        },
      });
    },

    showTooltip(id) {
      if (this.id == null) {
        this.id = id;
        $("[data-toggle=" + id + "]").popover({
          html: true,
          content: function () {
            return $("#popover-content-" + id).html();
          },
        });
        $("[data-toggle=" + id + "]").popover("show");
      } else if (this.id == id) {
        $("[data-toggle=" + this.id + "]").popover("dispose");
        this.id = null;
      } else {
        $("[data-toggle=" + this.id + "]").popover("dispose");
        this.id = id;
        $("[data-toggle=" + id + "]").popover({
          html: true,
          content: function () {
            return $("#popover-content-" + id).html();
          },
        });
        $("[data-toggle=" + id + "]").popover("show");
      }
    },
    showTooltip1(id) {
      if (this.id == null) {
        this.id = id;
        $("[data-toggle=deduction" + id + "]").popover({
          html: true,
          content: function () {
            return $("#popover-content-deduction" + id).html();
          },
        });
        $("[data-toggle=deduction" + id + "]").popover("show");
      } else if (this.id == id) {
        $("[data-toggle=deduction" + this.id + "]").popover("dispose");
        this.id = null;
      } else {
        $("[data-toggle=deduction" + this.id + "]").popover("dispose");
        this.id = id;
        $("[data-toggle=deduction" + id + "]").popover({
          html: true,
          content: function () {
            return $("#popover-content-deduction" + id).html();
          },
        });
        $("[data-toggle=deduction" + id + "]").popover("show");
      }
    },
    showTooltip2(id) {
      if (this.id == null) {
        this.id = id;
        $("[data-toggle=employee" + id + "]").popover({
          html: true,
          content: function () {
            return $("#popover-content-employee" + id).html();
          },
        });
        $("[data-toggle=employee" + id + "]").popover("show");
      } else if (this.id == id) {
        $("[data-toggle=employee" + this.id + "]").popover("dispose");
        this.id = null;
      } else {
        $("[data-toggle=employee" + this.id + "]").popover("dispose");
        this.id = id;
        $("[data-toggle=employee" + id + "]").popover({
          html: true,
          content: function () {
            return $("#popover-content-employee" + id).html();
          },
        });
        $("[data-toggle=employee" + id + "]").popover("show");
      }
    },
    showTooltip3(id) {
      if (this.id == null) {
        this.id = id;
        $("[data-toggle=addition" + id + "]").popover({
          html: true,
          content: function () {
            return $("#popover-content-addition" + id).html();
          },
        });
        $("[data-toggle=addition" + id + "]").popover("show");
      } else if (this.id == id) {
        $("[data-toggle=addition" + this.id + "]").popover("dispose");
        this.id = null;
      } else {
        $("[data-toggle=addition" + this.id + "]").popover("dispose");
        this.id = id;
        $("[data-toggle=addition" + id + "]").popover({
          html: true,
          content: function () {
            return $("#popover-content-addition" + id).html();
          },
        });
        $("[data-toggle=addition" + id + "]").popover("show");
      }
    },
    hideTooltip(id) {
      $("[data-toggle=" + this.id + "]").popover("dispose");
      this.id = null;
    },
    hideTooltip1(id) {
      $("[data-toggle=deduction" + this.id + "]").popover("dispose");
      this.id = null;
    },
    hideTooltip2(id) {
      $("[data-toggle=employee" + this.id + "]").popover("dispose");
      this.id = null;
    },
    hideTooltip3(id) {
      $("[data-toggle=addition" + this.id + "]").popover("dispose");
      this.id = null;
    },
  },
};
</script>

<style scoped>
.custom-padding {
  padding-left: 24px;
}
.custom-padding-right {
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
.DotsYaxis {
  transform: rotate(90deg);
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
