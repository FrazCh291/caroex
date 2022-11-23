<template>
  <admin-layout>
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
                          px-1
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
                                name="container_number"
                                id="container_number"
                                v-model="query.container_number"
                                v-on:click="check_one()"
                              />
                              <label
                                class="pl-1 py-0 my-0"
                                for="container_number"
                                >Container#</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="shipment_date"
                                id="shipment_date"
                                v-model="query.uk_eta"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="shipment_date"
                                >UK ETA</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="delivery_date"
                                id="delivery_date"
                                v-model="query.actual_arrival_date"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="rating"
                                >Arrival Date</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="comment"
                                id="comment"
                                v-model="query.product"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="rating"
                                >Product</label
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
                    <th class="custom-padding">Container</th>
                    <th>Uk Eta</th>
                    <th class="text-center">Arrival Date</th>
                    <th>Contents</th>
                    <th class="text-right custom-padding-right"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(shipment, index) in warehouseShipment.data">
                    <td class="text-truncate">
                      <span
                        data-placement="bottom"
                        :data-toggle="shipment.id"
                        @click="showTooltip(shipment.id)"
                        data-container="body"
                        type="button"
                        data-html="true"
                        href="#"
                        id="login"
                      >
                        <span class="underline-dotted border-gray">
                          {{ shipment.container_number }}
                        </span>
                      </span>
                      <div class="container">
                        <div
                          :id="'popover-content-' + shipment.id"
                          class="d-none"
                        >
                          <div class="row custom-popover popover-max">
                            <div class="col-12 px-2">
                              <span v-if="shipment.container_number">
                                <p class="py-0 mb-0 small">
                                  <strong>Departure Port:</strong> &nbsp;&nbsp;
                                  {{ shipment.departure_port }}
                                </p>
                                <p class="py-0 mb-0 small">
                                  <strong>Shipping Line:</strong> &nbsp;&nbsp;
                                  {{ shipment.shipping_line }}
                                </p>
                                <p class="py-0 mb-0 small">
                                  <strong>booking Number:</strong> &nbsp;&nbsp;
                                  {{ shipment.booking_number }}
                                </p>

                                <p class="py-0 mb-0 small">
                                  <strong>Container Number:</strong>
                                  &nbsp;&nbsp;
                                  {{ shipment.container_number }}
                                </p>
                                <p class="py-0 mb-0 small">
                                  <strong>Bill of lading:</strong> &nbsp;&nbsp;
                                  {{ shipment.bill_of_lading_number }}
                                </p>
                                <p class="py-0 mb-0 small">
                                  <strong>Seal Number:</strong> &nbsp;&nbsp;
                                  {{ shipment.container_seal_number }}
                                </p>
                                <p class="py-0 mb-0 small">
                                  <strong>Load Date:</strong> &nbsp;&nbsp;
                                  {{ shipment.goods_load_date }}
                                </p>
                                <p class="py-0 mb-0 small">
                                  <strong>Vessel Etd:</strong> &nbsp;&nbsp;
                                  {{ shipment.vessel_etd }}
                                </p>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>

                    <td
                      class="py-0 my-0"
                      @mouseenter="hideTooltip(shipment.id)"
                    >
                      {{ formatDate(shipment.uk_eta) }}
                    </td>
                    <td class="text-center">
                      {{ formatDate(shipment.actual_arrival_date) }}
                    </td>
                    <td class="text-truncate">
                      <span
                        data-placement="bottom"
                        @click="showReceiverTooltip(shipment.id)"
                        :data-toggle="'receiver' + shipment.id"
                        data-container="body"
                        type="button"
                        data-html="true"
                      >
                        <span class="underline-dotted border-gray">
                          <!-- {{ shipment.shipment_items[0]?shipment.shipment_items[0].product.name:'' + " x " + shipment.shipment_items[0]?shipment.shipment_items[0].quantity_ordered:''}} -->
                          {{
                            shipment.shipment_items[0]
                              ? shipment.shipment_items[0].product.name
                              : ""
                          }}
                          (
                          {{
                            shipment.shipment_items[0]
                              ? shipment.shipment_items[0].product.sku
                              : ""
                          }}
                          )
                        </span>
                      </span>
                      <div class="container">
                        <div
                          :id="'popover-receiver-content-' + shipment.id"
                          class="d-none"
                        >
                          <div class="row custom-popover popover-max">
                            <div class="col-12 px-2">
                              <h6 class="font-weight-bold h5 mb-1 small">
                                Product Name And Quantity Ordered
                              </h6>
                              <span v-for="item in shipment.shipment_items">
                                <p class="py-0 mb-0 small">
                                  {{
                                    item.product.name +
                                    " x " +
                                    item.quantity_ordered
                                  }}
                                </p>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <inertia-link
                        :href="route('warehouse-shipments.show', shipment.id)"
                      >
                        <span
                          class="
                            badge-circle badge-circle-light-secondary
                            mr-n5
                          "
                        >
                          <i class="bx bxs-show font-medium-1 text-right"></i>
                        </span>
                      </inertia-link>
                    </td>
                  </tr>
                  <tr>
                    <span>
                      <span class="font-weight-bold h5 mb-1 small mt-2">
                        Total Quantity
                      </span>

                      <p class="py-0 mb-0 small">
                        {{ sum(index) }}
                      </p>
                    </span>
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
    </div>
    <div class="col-12">
      <pagination
        :links="warehouseShipment.links"
        class="float-right"
      ></pagination>
    </div>
  </admin-layout>
</template>

<script>
import moment from "moment";
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button";
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {
  name: "index",
  props: ["warehouseShipment", "params", "shipment_statuses"],
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
        supplier_id: false,
        warehouse_id: false,
        freight_forwarder_id: false,
        container_number: false,
        shipment_date: false,
        delivery_date: false,
        comment: false,
        enable: false,
        disable: false,
        direction: null,
      },
      sweetAlert: false,
      itemId: "",
      searchItem: false,
      receiver_id: null,
      id: null,
    };
  },
  beforeMount() {
    console.log(this.warehouseShipment[0], "warehouseShipment")
    document.title = process.env.MIX_APP_NAME + " - warehouse shipments";
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
    sum(index) {
      let sum = 0;
      for (let i = 0; i <this.warehouseShipment.data[index].shipment_items[i].length; i++ ) {
        sum = sum + this.warehouseShipment.data[index].shipment_items[i].quantity_ordered;
      }
      return sum;
    },
    resetQuery() {
      this.query = {};
      this.loadData();
    },
    Clicked() {
      this.sweetAlert = false;
    },
    deleteItem() {
      this.sweetAlert = false;
      this.$inertia.delete(`/warehouse-shipments/${this.itemId}`);
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
      this.query.container_number = "";
      this.query.uk_eta = "";
      this.query.actual_arrival_date = "";
      this.query.product = "";
      this.loadData();
    },
    resetFilter() {
      this.query.id = "";
      this.query.supplier_id = "";
      this.query.warehouse_id = "";
      this.query.freight_forwarder_id = "";
      this.query.container_number = "";
      this.query.shipment_date = "";
      this.query.delivery_date = "";
      this.query.comment = "";
      this.query.direction = "";
      this.query.enable = "";
      this.query.disable = "";
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
      if ((this.query.container_number = false)) {
        this.query.container_number = true;
        this.query.uk_eta = [];
        this.query.actual_arrival_date = [];
        this.query.product = [];
      }
      if ((this.query.uk_eta = false)) {
        this.query.uk_eta = true;
        this.query.container_number = [];
        this.query.deal_type = [];
        this.query.actual_arrival_date = [];
        this.query.product = [];
      }
      if ((this.query.actual_arrival_date = false)) {
        this.query.actual_arrival_date = true;
        this.query.container_number = [];
        this.query.deal_type = [];
        this.query.uk_eta = [];
        this.query.product = [];
      }
      if ((this.query.product = false)) {
        this.query.product = true;
        this.query.uk_eta = [];
        this.query.actual_arrival_date = [];
        this.query.container_number = [];
      }
    },
    formatDate(date) {
      if (date) {
        return moment(date).format("DD/MM/YYYY");
      } else {
        return "";
      }
    },

    loadData() {
      let query = {};
      if (this.query.supplier_id) {
        Object.assign(query, { supplier_id: this.query.supplier_id });
      }
      if (this.query.warehouse_id) {
        Object.assign(query, { warehouse_id: this.query.warehouse_id });
      }
      if (this.query.freight_forwarder_id) {
        Object.assign(query, {
          freight_forwarder_id: this.query.freight_forwarder_id,
        });
      }
      if (this.query.container_number) {
        Object.assign(query, { container_number: this.query.container_number });
      }
      if (this.query.shipment_date) {
        Object.assign(query, { shipment_date: this.query.shipment_date });
      }
      if (this.query.delivery_date) {
        Object.assign(query, { delivery_date: this.query.delivery_date });
      }
      if (this.query.value) {
        Object.assign(query, { value: this.query.valuevalue });
      }
      if (this.query.comment) {
        Object.assign(query, { direction: this.query.comment });
      }
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, {
            [item]: this.query[item],
          });
        }
      }
      this.$inertia.visit(route("warehouse-shipments.index"), {
        method: "get",
        data: {
          ...query,
        },
      });
    },

    showReceiverTooltip(id) {
      if (this.receiver_id == null) {
        this.receiver_id = id;

        $("[data-toggle=receiver" + id + "]").popover({
          html: true,

          content: function () {
            return $("#popover-receiver-content-" + id).html();
          },
        });

        $("[data-toggle=receiver" + id + "]").popover("show");
      } else if (this.receiver_id == id) {
        $("[data-toggle=receiver" + this.receiver_id + "]").popover("dispose");

        this.receiver_id = null;
      } else {
        $("[data-toggle=receiver" + this.receiver_id + "]").popover("dispose");

        this.receiver_id = id;

        $("[data-toggle=receiver" + id + "]").popover({
          html: true,

          content: function () {
            return $("#popover-receiver-content-" + id).html();
          },
        });

        $("[data-toggle=receiver" + id + "]").popover("show");
      }
    },
    hideReceiverTooltip(id) {
      $("[data-toggle=" + this.id + "]").popover("dispose");

      $("[data-toggle=receiver" + this.receiver_id + "]").popover("dispose");

      this.receiver_id = null;

      this.id = null;
    },
    hideTooltip(id) {
      $("[data-toggle=" + this.id + "]").popover("dispose");

      $("[data-toggle=receiver" + this.receiver_id + "]").popover("dispose");

      this.receiver_id = null;

      this.id = null;
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

.product-image {
  margin-top: 5px;
}

img.rounded-circle.empty-image {
  height: 40px;
  margin-bottom: 3px;
  width: 45px;
  margin-top: 5px;
}

#bi-three-dots {
  transform: rotate(90deg);
}
/* .d-flex-view{
    height: 50px;
} */
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
