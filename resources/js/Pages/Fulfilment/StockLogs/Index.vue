<template>
  <admin-layout>
    <div class="col-12 px-0">
      <div class="col form-group p-0">
        <inertia-link
          :href="route('stock-log.create')"
          class="btn btn-primary"
          data-repeater-create=""
        >
          Add Stock Log
        </inertia-link>
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
                          px-1 px-auto
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
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="warehouse_id"
                                id="warehouse_id"
                                v-model="query.warehouse_id"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="warehouse_id"
                                >WareHouse</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="supplier_id"
                                id="supplier_id"
                                v-model="query.supplier_id"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="supplier_id"
                                >Supplier</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="quantity"
                                id="quantity"
                                v-model="query.quantity"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="quantity"
                                >Quantity</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="created_at"
                                id="created_at"
                                v-model="query.created_at"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="created_at"
                                >Stock Date</label
                              >
                            </p>
                          </div>
                        </div>
                        <div class="dropdown-divider py-0 my-0"></div>
                        <div class="col-12 pl-2 d-inline-flex">
                          <p class="pt-1">
                            <button
                              type="button"
                              id="asc"
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
                    <th class="warehouse-name text-truncate text-left">
                      Product
                    </th>
                    <th class="text-truncate text-left">Warehouse</th>
                    <th class="text-truncate warehouse-name text-left">
                      Supplier
                    </th>
                    <th class="text-truncate warehouse-name text-left">
                      Order Item
                    </th>
                    <th class="text-truncate text-center">Quantity</th>
                    <th class="text-truncate text-left">Stock Date</th>
                    <th class="text-truncate text-right"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="stockItem in stockLogs.data">
                    <td class="text-left py-0 my-0">
                      {{ stockItem.product ? stockItem.product.name : "" }}
                    </td>
                    <td class="text-left py-0 my-0">
                      {{
                        stockItem.ware_house ? stockItem.ware_house.name : ""
                      }}
                    </td>
                    <td class="text-left py-0 my-0">
                      {{ stockItem.company ? stockItem.company.name : "" }}
                    </td>
                    <td class="text-left py-0 my-0">
                      {{ stockItem.order_item ? stockItem.order_item.id : "" }}
                    </td>
                    <td class="text-center py-0 my-0">
                      <span v-if="stockItem.quantity > 0"
                        ><i class="font bx bxs-up-arrow text-success"> </i
                        >{{ stockItem.quantity }}</span
                      >
                      <span v-else
                        ><i class="font bx bxs-down-arrow text-danger"> </i
                        >{{ stockItem.quantity }}</span
                      >
                    </td>
                    <td class="text-left py-0 my-0">
                      {{
                        stockItem.updated_at
                          ? formatDate(stockItem.updated_at)
                          : ""
                      }}
                    </td>
                    <td class="text-right stock-tab">
                      <span class="d-inline-flex align-items-center">
                        <!--                                                <inertia-link :href="route('stock-log.edit',stockItem.id)">-->
                        <!--                                                    <span class="badge-circle badge-circle-light-secondary  action">-->
                        <!--                                                        <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>-->
                        <!--                                                    </span>-->
                        <!--                                                </inertia-link>-->
                        <button v-on:click="confirmDelete(stockItem.id)">
                          <span
                            class="
                              badge-circle badge-circle-light-secondary
                              ml-1/6
                            "
                          >
                            <i class="bx bx-trash font-medium-1 text-left"></i>
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
      <ConfirmatiomModal
        v-if="sweetAlert"
        :sweetAlert="sweetAlert"
        @clicked="Clicked"
        @deleteitem="deleteItem"
      >
      </ConfirmatiomModal>
      <div class="col-12">
        <pagination :links="stockLogs.links" class="float-right"></pagination>
      </div>
    </div>
  </admin-layout>
</template>

<script>
import moment from "moment";
import AdminLayout from "../../../Layouts/AdminLayout";
import Button from "../../../Jetstream/Button";
import Pagination from "../../../admin/Pagination";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";

export default {
  name: "Index",
  props: ["stockLogs", "params"],
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
    };
  },
  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - stockLogs";
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
    deleteItem() {
      this.sweetAlert = false;
      this.$inertia.delete(`/fulfilment/stock-log/${this.itemId}`);
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
      this.query.product_id = false;
      this.query.warehouse_id = false;
      this.query.supplier_id = false;
      this.query.quantity = false;
      this.query.created_at = false;
      this.loadData();
    },
    resetFilter() {
      this.query = {};
      this.query.id = "";
      this.query.name = "";
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
      if ((this.query.product_id = false)) {
        this.query.product_id = true;
        this.query.warehouse_id = [];
        this.query.supplier_id = [];
        this.query.quantity = [];
        this.query.created_at = [];
      }
      if ((this.query.warehouse_id = false)) {
        this.query.warehouse_id = true;
        this.query.product_id = [];
        this.query.created_at = [];
        this.query.supplier_id = [];
        this.query.quantity = [];
      }
      if ((this.query.supplier_id = false)) {
        this.query.supplier_id = true;
        this.query.product_id = [];
        this.query.created_at = [];
        this.query.warehouse_id = [];
        this.query.quantity = [];
      }
      if ((this.query.quantity = false)) {
        this.query.quantity = true;
        this.query.created_at = [];
        this.query.warehouse_id = [];
        this.query.supplier_id = [];
        this.query.product_id = [];
      }
      if ((this.query.created_at = false)) {
        this.query.created_at = true;
        this.query.warehouse_id = [];
        this.query.supplier_id = [];
        this.query.created_at = [];
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
      this.$inertia.visit(route("stock-log.index"), {
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
.tag {
  line-height: 1rem;
  margin-bottom: 0px !important;
  margin-top: 0px !important;
  padding-bottom: 11px !important;
  padding-top: 0px !important;
}

.action {
  margin-right: 4px !important;
  margin-top: 10px !important;
  margin-bottom: 10px !important;
}

.card {
  border: 1px solid #d2d6dc;
  border-radius: 0px !important;
}
.stock-tab {
  padding-top: 10px;
  padding-bottom: 10px;
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

.font {
  font-size: 12px;
  padding-right: 10px;
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
