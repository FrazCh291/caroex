<template>
  <admin-layout>
    <div class="col-12 px-0"></div>
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
                      sort-dropdown
                      pl-1
                    "
                  >
                    <div class="dropdown md:w-1/2 sm:w-1 pr-1 filter-dropdown">
                      <button
                        aria-expanded="false"
                        aria-haspopup="true"
                        class="btn border dropdown-toggle w-200"
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
                          <div class="d-inline-flex w-200">
                            <h6 class="py-0 my-0">Status</h6>
                            <span
                              class="primary pl-20 ml-2 pointer"
                              @click="resetFilter"
                              >Reset</span
                            >
                          </div>
                          <div class="align-items-center text-base pt-1">
                            <div
                              v-for="(orders, index) in order1"
                              class="tag"
                              :key="index"
                            >
                              <input
                                :id="orders"
                                v-model="query[orders]"
                                :name="orders"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" :for="orders">{{
                                orders
                              }}</label>
                            </div>
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
                    <div class="dropdown w-100 pr-2 sort-dropdown2">
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
                                name="customer_id"
                                id="customer_id"
                                v-model="query.customer_id"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="customer_id"
                                >Customer</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="address"
                                id="address"
                                v-model="query.address"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="address">
                                Delivery Address</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="product_id"
                                id="product_id"
                                v-model="query.product_id"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="product_id"
                                >Product</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="order_status"
                                id="order_status"
                                v-model="query.order_status"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="order_status"
                                >Status</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="order_date"
                                id="order_date"
                                v-model="query.order_date"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="order_date"
                                >Date</label
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
                    <th>Customer</th>
                    <th>Delivery Address</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Tracking ID#</th>
                    <th>Date</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="order in orders.data">
                    <td class="text-truncate">
                      <div class="text-md-left">
                        <span
                          data-placement="bottom"
                          :data-toggle="order.id"
                          @click="orderDetail(order.id)"
                          @mouseout="hideTooltip12(order.id)"
                          data-container="body"
                          type="button"
                          data-html="true"
                          href="#"
                          id="login"
                          ><span
                            class="
                              underline-dotted
                              border-gray
                              buildingName
                              text-truncate
                            "
                            >{{
                              order.customer ? order.customer.name : ""
                            }}</span
                          ></span
                        >
                        <div class="container">
                          <div
                            :id="'popover-content-' + order.id"
                            class="d-none"
                          >
                            <div class="row custom-popover popover-max">
                              <div class="col-12 px-2">
                                <span v-if="order.shipping_email">
                                  <span class="font-weight-bold h5 mb-1 small">
                                    Email
                                  </span>
                                  <p class="py-0 mb-0 small">
                                    {{ order.shipping_email }}
                                  </p>
                                </span>
                                <span v-if="order.shipping_address_phone">
                                  <span class="font-weight-bold h5 mb-1 small">
                                    Phone
                                  </span>
                                  <p class="py-0 mb-0 small">
                                    {{ order.shipping_address_phone }}
                                  </p>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="text-truncate">
                      <div class="text-md-left">
                        <span
                          data-placement="bottom"
                          :data-toggle="order.id + 'delivery'"
                          @click="addressDetail(order.id)"
                          @mouseout="hideTooltip(order.id)"
                          data-container="body"
                          type="button"
                          data-html="true"
                          href="#"
                          id="login"
                          ><span
                            class="
                              underline-dotted
                              border-gray
                              buildingName
                              text-truncate
                            "
                            >{{
                              (order.shipping_address_1_2
                                ? order.shipping_address_1_2
                                : "") +
                              (order.shipping_address_1
                                ? order.shipping_address_1
                                : "") +
                              (order.shipping_address_2
                                ? order.shipping_address_2
                                : "") +
                              (order.shipping_city
                                ? ", " + order.shipping_city
                                : "") +
                              (order.shipping_postcode
                                ? ", " + order.shipping_postcode
                                : "") +
                              (order.shipping_country
                                ? ", " + order.shipping_country
                                : "")
                            }}
                          </span>
                        </span>
                        <div class="container" v-if="order.billing_address_1_2">
                          <div
                            :id="'popover-delivery-content-' + order.id"
                            class="d-none"
                          >
                            <div class="custom-popover popover-max">
                              <div class="d-flex justify-content-center">
                                <tr>
                                  <span>
                                    <span
                                      class="font-weight-bold h5 mb-1 small"
                                    >
                                      Billing Address
                                    </span>
                                    <br />
                                    <p class="py-0 mb-0 small">
                                      {{
                                        (order.billing_address_1_2
                                          ? order.billing_address_1_2
                                          : "") +
                                        (order.billing_address_1
                                          ? order.billing_address_1
                                          : "") +
                                        (order.billing_address_2
                                          ? order.billing_address_2
                                          : "") +
                                        (order.billing_city
                                          ? ", " + order.billing_city
                                          : "") +
                                        (order.billing_postcode
                                          ? ", " + order.billing_postcode
                                          : "") +
                                        (order.billing_country
                                          ? ", " + order.billing_country
                                          : "")
                                      }}
                                    </p>
                                  </span>
                                </tr>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>{{ order.product ? order.product.name : "" }}</td>
                    <td>{{ order.order_status }}</td>
                    <td>{{ order.shipment_tracking_number }}</td>
                    <td>{{ formatDate(order.order_date) }}</td>
                    <td class="text-center py-0 my-0 custom-padding-right">
                      <span class="d-inline-flex align-items-center">
                        <inertia-link :href="route('order.show', order.id)">
                          <span
                            class="
                              badge-circle badge-circle-light-secondary
                              action
                            "
                          >
                            <i
                              class="
                                bx
                                bxs-show
                                font-medium-1
                                align-items-center
                                text-center
                              "
                            ></i>
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
      <ConfirmatiomModal
        v-if="sweetAlert"
        :sweetAlert="sweetAlert"
        @clicked="Clicked"
        @deleteitem="deleteItem"
      ></ConfirmatiomModal>
      <div class="col-12">
        <pagination :links="orders.links" class="float-right"></pagination>
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
  props: ["orders", "params", "order1"],
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
      id: null,
    };
  },
  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Orders";
  },
  mounted() {
    if (this.params) {
      Object.assign(this.query, this.params);
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
      this.$inertia.delete(`/fulfilment/order/${this.itemId}`);
    },
    confirmDelete(id) {
      this.sweetAlert = true;
      this.itemId = id;
    },
    stopPropagation(e) {
      e.stopPropagation();
    },
    formatDate(date) {
      return moment(String(date)).format("DD/MM/YYYY");
    },
    resetSort(e) {
      this.query.direction = "";
      this.query.customer_id = "";
      this.query.address = "";
      this.query.order_status = "";
      this.query.order_date = "";
      this.query.product_id = "";
      this.query.enable = "";
      this.query.disable = "";
      this.loadData();
    },
    resetFilter() {
      this.query.id = "";
      this.query.name = "";
      this.query.direction = "";
      this.query.enable = "";
      this.query.disable = "";
      this.query.pending = false;
      this.query.shipped = false;
      this.query.processing = false;
      this.query.cancelled = false;
      this.query.completed = false;
      this.query.collection = false;
      this.query.replacement = false;
      this.query.redispatch = false;
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
    orderDetail(id) {
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
    hideTooltip1st(id) {
      $("[data-toggle=" + this.id + "]").popover("dispose");
      this.id = null;
    },

    addressDetail(id) {
      if (this.id == null) {
        this.id = id;
        $("[data-toggle=" + id + "delivery" + "]").popover({
          html: true,
          content: function () {
            return $("#popover-delivery-content-" + id).html();
          },
        });
        $("[data-toggle=" + id + "delivery" + "]").popover("show");
      } else if (this.id == id) {
        $("[data-toggle=" + this.id + "delivery" + "]").popover("dispose");
        this.id = null;
      } else {
        $("[data-toggle=" + this.id + "delivery" + "]").popover("dispose");
        this.id = id;
        $("[data-toggle=" + id + "delivery" + "]").popover({
          html: true,
          content: function () {
            return $("#popover-delivery-content-" + id).html();
          },
        });
        $("[data-toggle=" + id + "delivery" + "]").popover("show");
      }
    },
    hideTooltip(id) {
      $("[data-toggle=" + this.id + "delivery" + "]").popover("dispose");
      this.id = null;
    },
    hideTooltip12(id) {
      $("[data-toggle=" + this.id + "]").popover("dispose");
      this.id = null;
    },

    check_one: function () {
      if ((this.query.customer_id = false)) {
        this.query.customer_id = true;
        this.query.address = [];
        this.query.order_status = [];
        this.query.order_date = [];
        this.query.product_id = [];
      }
      if ((this.query.address = false)) {
        this.query.address = true;
        this.query.customer_id = [];
        this.query.order_status = [];
        this.query.order_date = [];
        this.query.product_id = [];
      }
      if ((this.query.order_status = false)) {
        this.query.order_status = true;
        this.query.customer_id = [];
        this.query.address = [];
        this.query.product_id = [];
        this.query.product_id = [];
      }
      if ((this.query.order_date = false)) {
        this.query.order_date = true;
        this.query.customer_id = [];
        this.query.address = [];
        this.query.product_id = [];
        this.query.order_status = [];
        this.query.order_date = [];
      }
      if ((this.query.product_id = false)) {
        this.query.product_id = true;
        this.query.customer_id = [];
        this.query.address = [];
        this.query.order_status = [];
        this.query.product_id = [];
      }
    },

    loadData() {
      let query = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
        }
      }
      this.$inertia.visit(route("order.index"), {
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
