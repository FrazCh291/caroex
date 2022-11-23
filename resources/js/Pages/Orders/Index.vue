<template>
  <admin-layout>
    <div class="row">
      <div class="col-md-10 col-lg-10 col-sm-10 px-1 pb-0 mb-0">
        <div class="col form-group p-0 mt-1">
          <h4>All Orders</h4>
        </div>
      </div>
      <div class="col-md-1 col-lg-1 col-sm-1 px-0">
        <div class="col form-group p-0" v-if="hasPermission('imports.index')">
          <inertia-link
            :href="route('imports.index')"
            class="btn btn-primary"
            data-repeater-create=""
          >
            <i class="bx bx-xs bx-download pr-0.5 pb-0.5"></i>
            Import
          </inertia-link>
        </div>
      </div>
      <div class="col-md-1 col-lg-1 col-sm-1 px-0">
        <div class="col form-group p-0">
          <a
            :href="route('export.orders')"
            class="btn btn-outline-secondary"
            data-repeater-create=""
          >
            <i class="bx bx-xs bx-upload pr-0.5 pb-0.5"></i>
            Export
          </a>
        </div>
      </div>
    </div>
    <div id="table-hover-row" class="row pb-3">
      <div class="col-12">
        <div class="card-one py-0 my-0 bg-white">
          <div class="card-content">
            <div data-repeater-list="group-a">
              <div>
                <div class="tabbable-responsive table-responsive">
                  <div class="tabbable">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" v-if="hasPermission('orders.index')">
                        <a
                          class="nav-link active"
                          aria-selected="true"
                          id="first-tab"
                          aria-controls="first"
                          data-toggle="tab"
                          href="#first"
                          role="tab"
                          >All Orders</a
                        >
                      </li>
                      <inertia-link
                        :href="route('wowchers.index')"
                        aria-selected="false"
                        class="nav-item nav-link"
                        v-if="hasPermission('wowchers.index')"
                      >
                        Wowcher
                      </inertia-link>
                      <inertia-link
                        :href="route('ejoggas.index')"
                        aria-selected="false"
                        class="nav-item nav-link"
                        v-if="hasPermission('ejoggas.index')"
                      >
                        Ejogga
                      </inertia-link>
                      <inertia-link
                        :href="route('groupons.index')"
                        aria-selected="false"
                        class="nav-item nav-link"
                        v-if="hasPermission('groupon.index')"
                      >
                        Groupon
                      </inertia-link>
                      <inertia-link
                        :href="route('xstreamgyms.index')"
                        aria-selected="false"
                        class="nav-item nav-link"
                        v-if="hasPermission('xstreamgyms.index')"
                      >
                        Xstreamgym
                      </inertia-link>
                      <inertia-link
                        :href="route('gogroopies.index')"
                        aria-selected="false"
                        class="nav-item nav-link"
                        v-if="hasPermission('gogroopie.index')"
                      >
                        Gogroopie
                      </inertia-link>
                      <inertia-link
                        :href="route('amazons.index')"
                        aria-selected="false"
                        class="nav-item nav-link"
                        v-if="hasPermission('amazons.index')"
                      >
                        Amazon
                      </inertia-link>
                      <!--                                            <inertia-link :href="route('wowchers.index')" aria-selected="false" class="nav-item nav-link" data-repeater-create="">-->
                      <!--                                                Boomtekk-->
                      <!--                                            </inertia-link>-->
                    </ul>
                  </div>
                </div>
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
                    <div class="dropdown w-100 pr-2 sort-dropdown2">
                      <button
                        aria-expanded="false"
                        aria-haspopup="true"
                        class="btn border dropdown-toggle w-100"
                        data-toggle="dropdown"
                        type="button"
                      >
                        Sorting
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
                                id="order_number"
                                v-model="query.order_number"
                                v-on:click="check_one()"
                                name="order_number"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" for="order_number"
                                >Order</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                id="channel"
                                v-model="query.channel_id"
                                v-on:click="check_one()"
                                name="channel"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" for="channel"
                                >Channel Name</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                id="shipping_customer_name"
                                v-model="query.shipping_customer_name"
                                v-on:click="check_one()"
                                name="shipping_customer_name"
                                type="checkbox"
                              />
                              <label
                                class="pl-1 py-0 my-0"
                                for="shipping_customer_name"
                                >Customer Name
                              </label>
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                id="order_total_amount"
                                v-model="query.order_total_amount"
                                v-on:click="check_one()"
                                name="order_total_amount"
                                type="checkbox"
                              />
                              <label
                                class="pl-1 py-0 my-0"
                                for="order_total_amount"
                                >Order Total
                              </label>
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                id="order_status"
                                v-model="query.order_status"
                                v-on:click="check_one()"
                                name="order_status"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" for="order_status"
                                >Order Status
                              </label>
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                id="order_date"
                                v-model="query.order_date"
                                v-on:click="check_one()"
                                name="order_date"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" for="order_date"
                                >Order Date
                              </label>
                            </p>
                          </div>
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
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="table-md-responsive">
              <table
                class="table table-hover mb-0"
                v-if="orders.data.length > 0"
              >
                <thead>
                  <tr>
                    <th class="text-truncate">Order</th>
                    <th class="text-truncate">Channel Name</th>
                    <th class="text-truncate">Customer name</th>
                    <th class="text-truncate text-center">Order Total</th>
                    <th class="text-truncate text-center">Order Status</th>
                    <th class="text-truncate text-center">Order Date</th>
                    <th class="text-truncate text-right pr-3"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="order in orders.data">
                    <td class="text-truncate" @mouseout="hideTooltip(order.id)">
                      {{ order.order_number }}
                    </td>
                    <td class="text-truncate" @mouseout="hideTooltip(order.id)">
                      {{ order.channel ? order.channel.name : "" }}
                    </td>
                    <td
                      v-if="order.shipping_customer_name"
                      class="text-truncate"
                    >
                      <span
                        id="login"
                        :data-toggle="order.id"
                        data-container="body"
                        data-html="true"
                        data-placement="bottom"
                        href="#"
                        type="button"
                        @click="showTooltip(order.id)"
                      >
                        <span class="underline-dotted border-gray">
                          {{ order.shipping_customer_name }}
                        </span>
                      </span>
                      <div class="container">
                        <div :id="'popover-content-' + order.id" class="d-none">
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
                              <span v-if="order.shipping_address_1">
                                <span class="font-weight-bold h5 mb-1 small">
                                  Shipping Address
                                </span>
                                <p class="py-0 mb-0 small">
                                  {{
                                    (order.shipping_address_1
                                      ? order.shipping_address_1
                                      : "") +
                                    (order.shipping_address_2
                                      ? ", " + order.shipping_address_2
                                      : "") +
                                    (order.shipping_address_town
                                      ? ", " + order.shipping_address_town
                                      : "") +
                                    (order.shipping_address_postcode
                                      ? ", " + order.shipping_address_postcode
                                      : "") +
                                    (order.shipping_country
                                      ? ", " + order.shipping_country
                                      : "")
                                  }}
                                </p>
                              </span>
                              <span v-if="order.billing_address_1">
                                <span class="font-weight-bold h5 mb-1 small">
                                  Billing Address
                                </span>
                                <p class="py-0 mb-0 small">
                                  {{
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
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td
                      class="text-truncate text-center"
                      @mouseout="hideTooltip(order.id)"
                    >
                      {{
                        order.order_total_amount
                          ? "£" + order.order_total_amount
                          : ""
                      }}
                    </td>
                    <td
                      class="text-truncate text-center"
                      @mouseout="hideTooltip(order.id)"
                    >
                      <span
                        v-if="
                          order.order_status == 'Processing' ||
                          order.order_status == 'processing'
                        "
                        class="
                          badge badge-light-success badge-pill
                          text-right
                          ml-1
                        "
                      >
                        {{ order.order_status }}
                      </span>
                      <span
                        v-if="
                          order.order_status == 'pending' ||
                          order.order_status == 'Pending'
                        "
                        class="badge badge-pill badge-warning ml-1"
                      >
                        {{ order.order_status }}
                      </span>
                      <span
                        v-if="
                          order.order_status == 'cancelled' ||
                          order.order_status == 'Cancelled'
                        "
                        class="badge badge-pill badge-danger ml-1"
                      >
                        {{ order.order_status }}
                      </span>
                      <span
                        v-if="
                          order.order_status == 'completed' ||
                          order.order_status == 'Completed'
                        "
                        class="badge badge-pill badge-success ml-1"
                      >
                        {{ order.order_status }}
                      </span>
                      <span
                        v-if="
                          order.order_status == 'shipped' ||
                          order.order_status == 'shipped'
                        "
                        class="badge badge-pill badge-success ml-1"
                      >
                        {{ order.order_status }}
                      </span>
                      <span
                        v-if="
                          order.order_status == 'collection' ||
                          order.order_status == 'Collection'
                        "
                        class="badge badge-pill badge-success ml-1"
                      >
                        {{ order.order_status }}
                      </span>
                      <span
                        v-if="
                          order.order_status == 'replacement' ||
                          order.order_status == 'Replacement'
                        "
                        class="badge badge-pill badge-success ml-1"
                      >
                        {{ order.order_status }}
                      </span>
                      <span
                        v-if="
                          order.order_status == 'redispatch' ||
                          order.order_status == 'Redispatch'
                        "
                        class="badge badge-pill badge-success ml-1"
                      >
                        {{ order.order_status }}
                      </span>
                    </td>
                    <td class="text-center">
                      {{ order.order_date ? formatDate(order.order_date) : "" }}
                    </td>
                    <td class="text-right" @mouseout="hideTooltip(order.id)">
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
                          data-boundary="window"
                        >
                        </span>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a
                                :href="route('orders.show', order.id)"
                                class="dropdown-item"
                            ><i class="bx bx-show-alt mr-1"></i>Show</a
                            >

                          <a
                            :href="route('orders.edit', order.id)"
                            class="dropdown-item"
                            ><i class="bx bx-edit-alt mr-1"></i>Edit</a
                          >
                          <a
                            @click="orderDetail(order.id)"
                            class="dropdown-item"
                            ><i class="bx bx-trash mr-1"></i>Delete</a
                          >
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-hover truncate mb-0" v-else>
                <thead>
                  <tr class="text-center">
                    <h4 class="pt-3">
                      It's seems like you don't have any Order!
                    </h4>
                    <img alt="icon" class="img" src="/img/channelorder.png" />
                    <div
                      class="px-0 pb-3"
                      v-if="hasPermission('imports.index')"
                    >
                      <div class="form-group p-0">
                        <inertia-link
                          :href="route('imports.index')"
                          class="btn btn-primary"
                          data-repeater-create=""
                        >
                          <i
                            class="
                              bx bx-xs bx-download
                              pr-0.5
                              pb-0.5
                              text-white
                            "
                          ></i>
                          Import Any Order
                        </inertia-link>
                      </div>
                    </div>
                  </tr>
                </thead>
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
  props: [
    "orders",
    "params",
    "gogroopies",
    "groupons",
    "wowchers",
    "xstreamgyms",
    "amazons",
    "ejoggas",
    "boomtekks",
    "order1",
  ],
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
        order_number: false,
        channel_id: false,
        shipping_customer_name: false,
        order_total_amount: false,
        order_status: false,
        order_date: false,
        name: false,
        pending: false,
        shipped: false,
        processing: false,
        cancelled: false,
        completed: false,
        collection: false,
        replacement: false,
        redispatch: false,
        enable: false,
        disable: false,
        direction: null,
      },
      sweetAlert: false,
      itemId: "",
      searchItem: false,
      id: 6987,
    };
  },

  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Orders";
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
    updatePhone(phone) {
      if (!phone.startsWith("0")) {
        return "0" + phone;
      }
    },
    orderDetail(id) {
      // this.$inertia.get(route('orders.show', id));
      this.$inertia.visit(route("orders.show", id));
    },
    formatDate(date) {
      return moment(date).format("DD/MM/YYYY");
    },
    resetQuery() {
      this.query = {};
      this.loadData();
    },
    Clicked() {
      this.sweetAlert = false;
    },
    indexx(routes) {
      this.$inertia.post(route(routes));
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
      this.query.direction = "";
      this.query.id = "";
      this.query.order_number = "";
      this.query.channel_id = "";
      this.query.shipping_customer_name = "";
      this.query.order_total_amount = "";
      this.query.order_date = "";
      this.query.name = "";
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

    check_one: function () {
      if ((this.query.order_number = false)) {
        this.query.order_number = true;
        this.query.channel_id = [];
        this.query.shipping_customer_name = [];
        this.query.order_total_amount = [];
        this.query.order_status = [];
        this.query.order_date = [];
      }
      if ((this.query.channel_id = false)) {
        this.query.channel_id = true;
        this.query.order_number = [];
        this.query.shipping_customer_name = [];
        this.query.order_total_amount = [];
        this.query.order_status = [];
        this.query.order_date = [];
      }
      if ((this.query.shipping_customer_name = false)) {
        this.query.shipping_customer_name = true;
        this.query.order_number = [];
        this.query.channel_id = [];
        this.query.order_status = [];
        this.query.order_total_amount = [];
        this.query.order_date = [];
      }
      if ((this.query.order_total_amount = false)) {
        this.query.order_total_amount = true;
        this.query.order_number = [];
        this.query.channel_id = [];
        this.query.order_status = [];
        this.query.shipping_customer_name = [];
        this.query.order_date = [];
      }
      if ((this.query.order_status = false)) {
        this.query.order_status = true;
        this.query.order_number = [];
        this.query.channel_id = [];
        this.query.shipping_customer_name = [];
        this.query.order_total_amount = [];
        this.query.order_date = [];
      }
      if ((this.query.order_date = false)) {
        this.query.order_date = true;
        this.query.order_number = [];
        this.query.shipping_customer_name = true;
        this.query.channel_id = [];
        this.query.order_status = [];
        this.query.order_total_amount = [];
      }
    },

    loadData() {
      let query = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
        }
      }
      this.$inertia.visit(route("orders.index"), {
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
    hideTooltip(id) {
      $("[data-toggle=" + this.id + "]").popover("dispose");
      this.id = null;
    },
  },
};
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

.bxs-show {
  cursor: pointer;
}

.nav-link {
  border-bottom: 1px solid #dee2e6 !important;
  padding: 20px;
}

.nav.nav-tabs .nav-item {
  padding-bottom: 0 !important;
}

.nav-item {
  padding-bottom: 10px !important;
}

.nav.nav-tabs .nav-item,
.nav.nav-pills .nav-item {
  margin-right: 0 !important;
}

.nav.nav-tabs .nav-item .nav-link,
.nav.nav-pills .nav-item .nav-link {
  border-radius: 0 !important;
}

.nav.nav-tabs .nav-item .nav-link.active,
.nav.nav-pills .nav-item .nav-link.active {
  box-shadow: none;
  border-bottom: 0 !important;
  border-right: 1px solid #dee2e6 !important;
  border-left: 1px solid #dee2e6 !important;
}

.nav-tabs .nav-link.active,
.nav-tabs .nav-item.show .nav-link {
  background-color: #ffffff !important;
  color: black !important;
  font-weight: 900;
}

.img {
  height: 480px;
  display: block;
  margin-left: auto;
  margin-top: auto;
  margin-right: auto;
}

.tabbable {
  background-color: #f2f4f4;
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
