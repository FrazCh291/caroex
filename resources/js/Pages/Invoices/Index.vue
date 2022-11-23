<template>
  <admin-layout>
    <div class="col-12 px-0">
      <div class="col form-group p-0">
        <inertia-link
          :href="route('invoices.create')"
          class="btn btn-primary"
          data-repeater-create=""
        >
          Add Invoices
        </inertia-link>
      </div>
    </div>
    <div id="table-hover-row" class="row pb-3">
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
                          v-model="query.query"
                          aria-describedby="basic-addon2"
                          aria-label="Search"
                          class="form-control border-light-gray btn-height"
                          placeholder="Search..."
                          type="text"
                          @change="search"
                        />
                        <div class="input-group-append">
                          <button
                            class="input-group-text search-btn"
                            @change="search"
                          >
                            <svg
                              class="
                                feather feather-search feather-16
                                pb-0
                                mb-0
                                mt-0
                              "
                              fill="none"
                              height="23"
                              stroke="currentColor"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              viewBox="0 0 24 24"
                              width="23"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <circle cx="11" cy="11" r="8"></circle>
                              <line
                                x1="21"
                                x2="16.65"
                                y1="21"
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
                      sort-dropdown
                      pl-1
                    "
                  >
                    <div class="dropdown md:w-1/2 sm:w-1 pr-1 filter-dropdown">
                      <button
                        aria-expanded="false"
                        aria-haspopup="true"
                        class="btn border dropdown-toggle w-100"
                        data-toggle="dropdown"
                        type="button"
                      >
                        Filter
                      </button>
                      <div
                        aria-labelledby=""
                        class="
                          dropdown-menu dropdown-menu-right
                          py-0
                          my-0
                          custom-dropdown
                        "
                        @click="stopPropagation"
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
                                id="paid"
                                v-model="query.paid"
                                name="paid"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" for="paid"
                                >Paid</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                id="un_paid"
                                v-model="query.un_paid"
                                name="un_paid"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" for="un_paid"
                                >Un Paid</label
                              >
                            </p>
                          </div>
                        </div>
                        <div class="dropdown-divider py-0 my-0"></div>
                        <div class="col-12 pl-2">
                          <p class="pt-1">
                            <button
                              id="asc"
                              class="
                                btn btn-sm btn-primary
                                font-small font-weight-normal
                                stock-order
                              "
                              type="button"
                              @click="filter"
                            >
                              Filter
                            </button>
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="dropdown w-100 pr-2 sort-dropdown2">
                      <button
                        aria-expanded="false"
                        aria-haspopup="true"
                        class="btn border dropdown-toggle w-100"
                        data-toggle="dropdown"
                        type="button"
                      >
                        Sort
                      </button>
                      <div
                        aria-labelledby=""
                        class="
                          dropdown-menu dropdown-menu-right
                          py-0
                          my-0
                          custom-dropdown
                        "
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
                          <div class="align-items-center text-base pt-1">
                            <p class="tag">
                              <input
                                id="invoice_number"
                                v-model="query.invoice_number"
                                name="invoice_number"
                                type="checkbox"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="invoice_number"
                                >Invoice#</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                id="currency"
                                v-model="query.currency"
                                name="currency"
                                type="checkbox"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="currency"
                                >Currency</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                id="total"
                                v-model="query.total"
                                name="total"
                                type="checkbox"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="total"
                                >Total</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                id="invoice_date"
                                v-model="query.invoice_date"
                                name="invoice_date"
                                type="checkbox"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="invoice_date"
                                >Date</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                id="status"
                                v-model="query.status"
                                name="status"
                                type="checkbox"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="status"
                                >Status</label
                              >
                            </p>
                          </div>
                          <div class="dropdown-divider py-0 my-0"></div>
                          <div class="col-12 pl-2 d-inline-flex">
                            <p class="pt-1">
                              <button
                                id="asce"
                                class="
                                  btn btn-sm btn-primary
                                  font-small font-weight-normal
                                  stock-order
                                "
                                type="button"
                                @click="sort('asc')"
                              >
                                Asc
                              </button>
                            </p>
                            <p class="pt-1 pl-3">
                              <button
                                id="desc"
                                class="
                                  btn btn-sm btn-light-secondary
                                  font-small font-weight-normal
                                  stock-order
                                "
                                type="button"
                                @click="sort('desc')"
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
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="table-responsive">
              <table class="table table-hover truncate mb-0">
                <thead>
                  <tr>
                    <th class="invoice-name text-left">Invoice#</th>
                    <th class="invoice-name">Type</th>
                    <th class="text-center">Total</th>
                    <!--                                    <th class="text-right">Total</th>-->
                    <th class="text-center">Date</th>
                    <th class="text-center invoice-name">Status</th>
                    <th class="text-right"></th>
                  </tr>
                </thead>
                <tbody v-for="invoice in invoices.data">
                  <tr @mouseout="hideTooltip(invoice.id)">
                    <td class="text-truncate py-0.5 my-0">
                      <span
                        data-placement="bottom"
                        :data-toggle="invoice.id"
                        data-boundary="window"
                        data-container="body"
                        type="button"
                        data-html="true"
                        href="#"
                        id="login"
                      >
                        <span
                          class="underline-dotted border-gray"
                          @click="showTooltip(invoice.id)"
                        >
                          {{ invoice.invoice_number }}
                        </span>
                      </span>
                      <div
                        class="container"
                        @mouseover="showTooltip(invoice.id)"
                      >
                        <div
                          :id="'popover-content-' + invoice.id"
                          class="d-none"
                        >
                          <div class="row custom-popover popover-max">
                            <div class="col-12 px-2">
                              <span
                                v-if="invoice.invoice_number && invoice.is_sale"
                              >
                                <span class="font-weight-bold h5 mb-1 small">
                                  Invoice
                                </span>
                                <p class="py-0 mb-0 small">
                                  <strong>Supplier:</strong>
                                  {{
                                    invoice.suppliers
                                      ? invoice.suppliers.name
                                      : ""
                                  }}
                                </p>
                                <p class="py-0 mb-0 small">
                                  <strong>Customer:</strong>
                                  {{
                                    invoice.customers
                                      ? invoice.customers.name
                                      : ""
                                  }}
                                </p>
                              </span>
                              <span
                                v-if="
                                  invoice.invoice_number &&
                                  invoice.is_sale == null
                                "
                              >
                                <span class="font-weight-bold h5 mb-1 small">
                                  Invoice
                                </span>
                                <p class="py-0 mb-0 small">
                                  <strong>Supplier:</strong>
                                  {{
                                    invoice.supplier
                                      ? invoice.supplier.name
                                      : ""
                                  }}
                                </p>
                                <p class="py-0 mb-0 small">
                                  <strong>Customer:</strong>
                                  {{
                                    invoice.customer
                                      ? invoice.customer.name
                                      : ""
                                  }}
                                </p>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="truncate py-0.5 my-0">
                      <span v-if="invoice.is_sale">Sale</span>
                      <span v-else>Purchase</span>
                    </td>
                    <td class="truncate text-center py-0.5 my-0">
                      {{
                        invoice.currency
                          ? invoice.currency.substr(
                              invoice.currency.length - 3,
                              invoice.currency.length
                            ) +
                            " " +
                            invoice.total
                          : ""
                      }}
                    </td>
                    <!--                                    <td class="text-right py-0.5 my-0">-->
                    <!--                                        {{ invoice.total?invoice.total:'' }}-->
                    <!--                                    </td>-->
                    <td class="text-center py-0.5 my-0">
                      {{ formatDate(invoice.invoice_date) }}
                    </td>
                    <td class="text-center truncate py-0.5 my-0">
                      <span
                        v-if="invoice.status == 'un_paid'"
                        class="badge badge-light-danger badge-pill"
                        >{{
                          invoice.statuss ? invoice.statuss.value : ""
                        }}</span
                      >
                      <span
                        v-else
                        class="badge badge-light-success badge-pill"
                        >{{ invoice.status }}</span
                      >
                    </td>
                    <td class="text-right py-1 my-0 d-flex justify-content-end">
                      <div class="d-inline-block">
                        <span
                          v-if="invoice.payments.length > 0"
                          aria-expanded="false"
                          class="collapse-icon clap"
                          data-toggle="collapse"
                          role="button"
                          v-bind:data-target="'#collapse1' + invoice.id"
                          v-on:click="rotateIcon(invoice.id)"
                        >
                          <img
                            :id="'collaspe-icon' + invoice.id"
                            alt="icon"
                            src="/img/collaspe.svg"
                          />
                        </span>
                      </div>
                      <div class="dropdown d-inline-block">
                        <span
                          class="
                            bx bx-dots-vertical-rounded
                            font-medium-3
                            dropdown-toggle
                            nav-hide-arrow
                            cursor-pointer
                          "
                          data-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                          role="menu"
                          data-boundary="window"
                        >
                        </span>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a
                            :href="route('invoices.edit', invoice.id)"
                            class="dropdown-item"
                            ><i class="bx bx-edit-alt mr-1"></i>Edit Invoice</a
                          >
                          <a
                            class="dropdown-item"
                            v-on:click="confirmDelete(invoice.id)"
                            ><i class="bx bx-trash mr-1"></i>Delete Invoice</a
                          >
                          <a
                            :href="
                              route('payments.create', {
                                invoice_id: invoice.id,
                              })
                            "
                            class="dropdown-item"
                            ><i class="bx bx-plus mr-1"></i>Add Payment</a
                          >
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr
                    v-for="payment in invoice.payments"
                    v-bind:id="'collapse1' + invoice.id"
                    aria-labelledby="headingCollapse8"
                    class="collapse"
                    role="tabpanel"
                  >
                    <td class="text-right mr-5 ml-0">
                      <strong>Payment</strong>
                    </td>
                    <td class="text-truncate"></td>
                    <td class="text-truncate text-center">
                      {{
                        payment.payee_currency_id
                          ? payment.payee_currency_id
                              .toUpperCase()
                              .substr(
                                payment.payee_currency_id.length - 3,
                                payment.payee_currency_id.length
                              ) +
                            " " +
                            payment.payee_total
                          : ""
                      }}
                    </td>
                    <td class="text-center">
                      {{ formatDate(payment.payment_date) }}
                    </td>
                    <td class="text-truncate"></td>
                    <td class="text-right">
                      <div class="dropdown">
                        <span
                          class="
                            bx bx-dots-vertical-rounded
                            font-medium-3
                            dropdown-toggle
                            nav-hide-arrow
                            cursor-pointer
                          "
                          data-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                          role="menu"
                        >
                        </span>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a
                            :href="route('payments.edit', payment.id)"
                            class="dropdown-item"
                            ><i class="bx bx-edit-alt mr-1"></i>Edit Payment</a
                          >
                          <a
                            class="dropdown-item"
                            v-on:click="deletePayment(payment.id)"
                            ><i class="bx bx-trash mr-1"></i>Delete Payment</a
                          >
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
      <ConfirmatiomModal
        v-if="sweetAlert"
        :sweetAlert="sweetAlert"
        @clicked="Clicked"
        @deleteitem="deleteItem"
      >
      </ConfirmatiomModal>
      <div class="col-12">
        <pagination :links="invoices.links" class="float-right"></pagination>
      </div>
    </div>
  </admin-layout>
</template>

<script>
import moment from "moment";
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button";
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import DeletedModal from "../SweetAlert/DeletedModal";

export default {
  name: "index",
  props: ["invoices", "params"],
  components: {
    Button,
    AdminLayout,
    Pagination,
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
      },
      sweetAlert: false,
      itemId: "",
      searchItem: false,
      rotate: false,
    };
  },
  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Invoices";
    console.log(this.invoices, "junaid");
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
    formatDate(date) {
      return moment(date).format("DD/MM/YYYY");
    },
    Clicked() {
      this.sweetAlert = false;
    },
    deleteItem() {
      this.sweetAlert = false;
      if (this.payId) {
        this.$inertia.delete(`/erp/payments/${this.payId}`);
      }
      if (this.itemId) {
        this.$inertia.delete(`/erp/invoices/${this.itemId}`);
      }
    },
    confirmDelete(id) {
      this.sweetAlert = true;
      this.itemId = id;
    },
    deletePayment(id) {
      this.sweetAlert = true;
      this.payId = id;
    },
    rotateIcon(id) {
      let element = "collaspe-icon" + id;
      if (this.rotate == false) {
        document.getElementById(element).style.transform = "rotate(180deg)";
        document.getElementById(element).style.transition = "transform 1s";
        this.rotate = true;
      } else {
        document.getElementById(element).style.transform = "rotate(0deg)";
        document.getElementById(element).style.transition = "transform 1s";
        this.rotate = false;
      }
    },
    stopPropagation(e) {
      e.stopPropagation();
    },
    // hideTooltip(id) {
    //     $("[data-toggle=" + this.id + "]").popover("dispose");
    //     this.id = null;
    // },
    resetSort(e) {
      this.query.direction = "";
      this.query.invoice_number = "";
      this.query.invoice_date = "";
      this.query.currency = "";
      this.query.total = "";
      this.loadData();
    },
    resetFilter() {
      this.query.direction = "";
      this.query.paid = "";
      this.query.un_paid = "";
      this.loadData();
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
    check_one: function () {
      if ((this.query.invoice_number = false)) {
        this.query.invoice_number = true;
        this.query.invoice_date = [];
        this.query.currency = [];
        this.query.total = [];
      }
      if ((this.query.invoice_date = false)) {
        this.query.invoice_date = true;
        this.query.invoice_number = [];
        this.query.deal_type = [];
        this.query.currency = [];
        this.query.total = [];
      }
      if ((this.query.currency = false)) {
        this.query.currency = true;
        this.query.invoice_number = [];
        this.query.deal_type = [];
        this.query.invoice_date = [];
        this.query.total = [];
      }
      if ((this.query.total = false)) {
        this.query.total = true;
        this.query.invoice_date = [];
        this.query.currency = [];
        this.query.invoice_number = [];
      }
    },
    loadData() {
      let query = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
        }
      }
      this.$inertia.visit(route("invoices.index"), {
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
  },
};
</script>

<style scoped>
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

#bi-three-dots {
  transform: rotate(90deg);
}

#delete_icon {
  margin-top: 7px;
}

.clap {
  padding-top: 8px;
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