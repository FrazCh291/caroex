<template>
  <div class="row nav-product px-0">
    <div class="col-10 px-0">
      <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
          <a
            v-bind:class="{
              'nav-link': openTab !== 1,
              'nav-link active': openTab === 1,
            }"
            @click="loadData('type_product')"
            v-on:click="toggleTabs(1)"
            ><i class="bx bxs-purchase-tag me-1"></i>Products</a
          >
        </li>
        <li class="nav-item">
          <a
            v-bind:class="{
              'nav-link': openTab !== 2,
              'nav-link active': openTab === 2,
            }"
            @click="loadData('type_spare_part')"
            v-on:click="toggleTabs(2)"
            ><i class="bx bx-wrench me-1"></i>Spare Parts</a
          >
        </li>
      </ul>
    </div>
    <div class="col-2 px-0">
      <ul class="nav nav-pills flex-column flex-md-row mb-3 add-product">
        <li class="nav-item">
          <a :href="route('product-details.create')" class="nav-link active"
            ><i class="bx bx-plus me-1"></i>Add Products</a
          >
        </li>
      </ul>
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
                  <div id="DataTables_Table_0_filter" class="dataTables_filter">
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
                            <line x1="21" x2="16.65" y1="21" y2="16.65"></line>
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
                              id="name"
                              v-model="query.name"
                              v-on:click="check_one()"
                              name="name"
                              type="checkbox"
                            />
                            <label class="pl-1 py-0 my-0" for="name"
                              >Product</label
                            >
                          </p>
                        </div>
                        <div class="align-items-center text-base">
                          <p class="tag">
                            <input
                              id="sku"
                              v-model="query.sku"
                              v-on:click="check_one()"
                              name="sku"
                              type="checkbox"
                            />
                            <label class="pl-1 py-0 my-0" for="sku">Sku</label>
                          </p>
                        </div>
                        <div class="align-items-center text-base">
                          <p class="tag">
                            <input
                              id="quantity"
                              v-model="query.quantity"
                              v-on:click="check_one()"
                              name="quantity"
                              type="checkbox"
                            />
                            <label class="pl-1 py-0 my-0" for="quantity"
                              >Quantity</label
                            >
                          </p>
                        </div>
                        <div class="align-items-center text-base">
                          <p class="tag">
                            <input
                              id="sales_report"
                              v-model="query.sales_report"
                              v-on:click="check_one()"
                              name="sales_report"
                              type="checkbox"
                            />
                            <label class="pl-1 py-0 my-0" for="sales_report"
                              >Sales Report</label
                            >
                          </p>
                        </div>
                        <div class="align-items-center text-base">
                          <p class="tag">
                            <input
                              id="rating"
                              v-model="query.rating"
                              v-on:click="check_one()"
                              name="rating"
                              type="checkbox"
                            />
                            <label class="pl-1 py-0 my-0" for="rating"
                              >Rating</label
                            >
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
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th></th>
                  <th class="text-left pl-0 ml-0">Product</th>
                  <th>SKU</th>
                  <th class="text-center">Quantity</th>
                  <th class="text-center">Sales Report</th>
                  <th class="text-center">Rating</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="product in products.data">
                  <td
                    class="text-right product-image py-o pt-0 pb-0"
                    @mouseout="hideTooltip(product.id)"
                  >
                    <img
                      v-if="product.image !== null"
                      :src="'/' + product.image"
                      class="rounded-circle text-right"
                      height="40"
                      width="45"
                      loading="lazy"
                    />
                    <img
                      v-else
                      class="rounded-circle text-right"
                      height="40"
                      src="/products/empty.jpg"
                      width="40"
                      loading="lazy"
                    />
                  </td>
                  <td class="text-left pl-0 ml-0">
                    {{ product.name ? product.name : "" }}
                  </td>
                  <td class="py-0 my-0" @mouseout="hideTooltip(product.id)">
                    {{ product.sku }}
                  </td>
                  <td class="text-truncate text-center">
                    <div v-if="product.warehouse_stocks.length > 0">
                      <span
                        id="login"
                        :data-toggle="product.id"
                        data-container="body"
                        data-html="true"
                        data-placement="bottom"
                        href="#"
                        type="button"
                        @click="showTooltip(product.id)"
                      >
                        <span class="underline-dotted border-gray">
                          {{
                            product.prodcut_stock
                              ? product.prodcut_stock.quantity
                              : 0
                          }}
                        </span>
                      </span>
                      <div class="container">
                        <div
                          :id="'popover-content-' + product.id"
                          class="d-none"
                        >
                          <div class="custom-popover popover-max">
                            <div class="d-flex justify-content-around">
                              <div>
                                <b class="font-size-small">Warehouse</b>
                              </div>
                              <div class="pl-5">
                                <b class="font-size-small">Quantity</b>
                              </div>
                            </div>
                            <hr class="line" />
                            <div
                              v-for="warehouse_stock in product.warehouse_stocks"
                              v-if="product.warehouse_stocks.length > 0"
                              class="row d-flex justify-content-around"
                            >
                              <p class="pr-3 font-size-small">
                                {{
                                  warehouse_stock
                                    ? ware_house
                                      ? ware_house.name
                                      : ""
                                    : ""
                                }}
                              </p>
                              <p class="font-size-small">
                                {{ warehouse_stock.quantity }}
                              </p>
                            </div>

                            <div
                              v-else
                              class="row d-flex justify-content-around"
                            >
                              <div class="pr-3">...</div>
                              <div>...</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-else>0</div>
                  </td>
                  <td class="text-truncate text-center">
                    <div v-if="product.last_month_count">
                      <span
                        id="login"
                        :data-toggle="product.id + 'report'"
                        data-container="body"
                        data-html="true"
                        data-placement="bottom"
                        href="#"
                        type="button"
                        @click="showTooltipReport(product.id + 'report')"
                      >
                        <span
                          class="underline-dotted border-gray"
                          v-if="product.last_month_count"
                        >
                          {{
                            product.last_month_count
                              ? product.last_month_count
                              : 0
                          }}
                        </span>
                      </span>
                      <div class="container">
                        <div
                          :id="'popover-content-' + product.id + 'report'"
                          class="d-none"
                          style="width: 500px"
                        >
                          <div class="custom-popover popover-max ml-2 mt-1">
                            <div class="row d-flex justify-content-between">
                              <p class="pr-3 font-size-small ml-1">
                                Sales 1M:
                                {{
                                  (product.last_month_count / 30).toFixed(1) +
                                  "(" +
                                  product.last_month_count +
                                  ")"
                                }}
                              </p>
                            </div>
                            <div class="row d-flex justify-content-between">
                              <p class="pr-3 font-size-small ml-1">
                                Sales 2M:
                                {{
                                  (product.last_two_month_count / 60).toFixed(
                                    1
                                  ) +
                                  "(" +
                                  product.last_two_month_count +
                                  ")"
                                }}
                              </p>
                            </div>
                            <div class="row d-flex justify-content-between">
                              <p class="pr-3 font-size-small ml-1">
                                Sales 3M:
                                {{
                                  (product.last_three_month_count / 90).toFixed(
                                    1
                                  ) +
                                  "(" +
                                  product.last_three_month_count +
                                  ")"
                                }}
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-else>0</div>
                  </td>
                  <td class="py-0 my-0 text-center">
                    <span v-if="product.reviews.length > 0">
                      {{ avgRating(product.reviews) }}
                    </span>
                  </td>
                  <td
                    class="text-right py-0 my-0"
                    @mouseout="hideTooltip(product.id)"
                  >
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
                          :href="route('product-details.show', product.id)"
                          class="dropdown-item"
                          ><i class="bx bx-show mr-1"></i>Show</a
                        >
                        <a
                          :href="route('product-details.edit', product.id)"
                          class="dropdown-item"
                          ><i class="bx bx-edit-alt mr-1"></i>Edit</a
                        >
                        <a
                          class="dropdown-item"
                          v-on:click="confirmDelete(product.id)"
                          ><i class="bx bx-trash mr-1"></i>Delete</a
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
    ></ConfirmatiomModal>
    <div class="col-12">
      <pagination :links="products.links" class="float-right"></pagination>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button";
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import DeletedModal from "../SweetAlert/DeletedModal";
import Chart from "./../Chart";

export default {
  name: "index",
  props: ["products", "params", "sparePart"],
  layout: AdminLayout,
  components: {
    Chart,
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
        sku: false,
        shipping_method: false,
        quantity: false,
        rating: false,
        enable: false,
        disable: false,
        lastmonth: false,
        lastTwoMonth: false,
        lastThreeMont: false,
        chart: false,
        direction: null,
      },
      sweetAlert: false,
      itemId: "",
      chart: "",
      openTab: "",
      searchItem: false,
      id: null,
      ids: null,
    };
  },
  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Products";
  },
  mounted() {
    if (this.sparePart) {
      this.openTab = 2;
    } else {
      this.openTab = 1;
    }
    if (this.params) {
      let params = Object.keys(this.params);
      for (let i of params) {
        Object.assign(this.query, { [i]: this.params[i] });
      }
    }
  },
  methods: {
    avgRating(items) {
      let sum = 0;
      items.forEach(function (item) {
        let calculation = item.rating;
        sum += calculation;
      });
      return parseFloat(sum / items.length).toFixed(1);
    },
    // SumQty(items) {
    //     let sum = 0;
    //     items.forEach(function (item) {
    //         let calculation = item.quantity;
    //         sum += calculation;
    //     })
    //     return sum;
    // },

    resetQuery() {
      this.query = {};
      this.loadData();
    },
    Clicked() {
      this.sweetAlert = false;
    },
    toggleTabs: function (tabNumber) {
      this.openTab = tabNumber;
    },
    deleteItem() {
      this.sweetAlert = false;
      this.$inertia.delete(`/erp/product-details/${this.itemId}`);
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
      this.query.id = false;
      this.query.name = false;
      this.query.sku = false;
      this.query.shipping_method = false;
      this.query.quantity = false;
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
      if ((this.query.name = false)) {
        this.query.name = true;
        this.query.sku = [];
        this.query.shipping_method = [];
        this.query.quantity = [];
        this.query.rating = [];
      }
      if ((this.query.sku = false)) {
        this.query.sku = true;
        this.query.name = [];
        this.query.shipping_method = [];
        this.query.quantity = [];
        this.query.rating = [];
      }
      if ((this.query.quantity = false)) {
        this.query.quantity = true;
        this.query.name = [];
        this.query.sku = [];
        this.query.rating = [];
        this.query.shipping_method = [];
      }
      if ((this.query.rating = false)) {
        this.query.rating = true;
        this.query.name = [];
        this.query.sku = [];
        this.query.shipping_method = [];
        this.query.quantity = [];
      }
      if ((this.query.shipping_method = false)) {
        this.query.shipping_method = true;
        this.query.name = [];
        this.query.sku = [];
        this.query.rating = [];
        this.query.quantity = [];
      }
    },
    loadData(product_type) {
      let query = {};
      query.type = "";
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, {
            [item]: this.query[item],
          });
        }
      }
      query.type = product_type;
      if (!query.type) {
        if (this.openTab === 2) {
          query.type = "type_spare_part";
        } else {
          query.type = "type_product";
        }
      }
      this.$inertia.visit(route("product-details.index"), {
        method: "get",
        data: {
          ...query,
        },
      });
    },

    showTooltipReport(id) {
      if (this.ids == null) {
        this.ids = id;
        $("[data-toggle=" + id + "]").popover({
          html: true,
          content: function () {
            return $("#popover-content-" + id).html();
          },
        });
        $("[data-toggle=" + id + "]").popover("show");
      } else if (this.ids == id) {
        $("[data-toggle=" + this.ids + "]").popover("dispose");
        this.id = null;
      } else {
        $("[data-toggle=" + this.ids + "]").popover("dispose");
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
      $("[data-toggle=" + this.ids + "]").popover("dispose");
      this.id = null;
      this.ids = null;
    },
  },
};
</script>

<style scoped>
.popover-max {
  width: 400px !important;
}

.popover-body {
  width: 400px !important;
}

.tag {
  line-height: 1rem;
  margin-bottom: 0px !important;
  margin-top: 0px !important;
  padding-bottom: 11px !important;
  padding-top: 0px !important;
}

.star-rating {
  color: rgba(241, 166, 25, 0.993);
  display: inline-block;
  font-size: 1.5em;
  position: relative;
  transform: translate(-6px);
}
.add-product {
  padding-left: 6rem;
}
.nav-product {
  margin-left: 2px;
  margin-right: -14px;
  margin-bottom: -3rem;
}
.star-rating__current {
  position: absolute;
  top: 0;
}

.star-rating__current {
  overflow: hidden;
  white-space: nowrap;
}

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

.product-image {
  padding-right: 0px;
  margin-right: 0px;
}

img.rounded-circle.empty-image {
  height: 40px;
  margin-bottom: 3px;
  width: 45px;
  margin-top: 5px;
}

.line {
  border-top: 1px dashed #c7cfd6;
  width: 100%;
}

.popover-body {
  padding-bottom: 0px !important;
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
