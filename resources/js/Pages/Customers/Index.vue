<template>
  <admin-layout>
    <div class="row">
      <div class="col-11">
        <h5>ERP/Customers</h5>
      </div>
      <div class="col-1">
        <div class="dropdown float-right">
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
            <a :href="route('customers.create')" class="dropdown-item"
              ><i class="bx bx-plus mr-1"></i> Add</a
            >
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
                            <h6 class="py-0 my-0">Channel</h6>
                            <span
                              class="primary pl-20 ml-2 pointer"
                              @click="resetFilter"
                              >Reset</span
                            >
                          </div>
                          <div class="align-items-center text-base pt-1">
                            <div
                              v-for="(channel, index) in salesChannel"
                              class="tag"
                              :key="index"
                            >
                              <input
                                :id="channel.slug"
                                v-model="query[channel.slug]"
                                :name="channel.slug"
                                type="checkbox"
                              />
                              <label
                                class="pl-1 py-0 my-0"
                                :for="channel.slug"
                                >{{ channel.name }}</label
                              >
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
                              @click="resetSort(e)"
                              >Reset</span
                            >
                          </div>
                          <div class="align-items-center text-base pt-1">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="name"
                                id="name"
                                v-model="query.name"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="name"
                                >NAME</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="address1_2"
                                id="address1_2"
                                v-model="query.address1_2"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="address1_2"
                                >ADDRESS</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="email"
                                id="email"
                                v-model="query.email"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="email"
                                >EMAIL</label
                              >
                            </p>
                          </div>

                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="phone"
                                id="phone"
                                v-model="query.phone"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="phone"
                                >PHONE</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="channel_id"
                                id="channel_id"
                                v-model="query.channel_id"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="channel_id"
                                >Channel</label
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
                    <th class="">Address</th>
                    <th class="">Email</th>
                    <th class="">Phone</th>
                    <th class="text-center">Channel</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="customer in customers.data">
                    <td class="text-truncate">
                      {{ customer ? customer.name : "" }}
                    </td>
                    <!-- <td >
                      <span class="" v-for="order in customer.order">
                      <u class="dotted cursor-pointer d-inline-block text-truncate w-75" data-toggle="popover" data-placement="bottom"
                       :data-content="order.shipping_address_1_2 ? order.shipping_address_1_2:'' + ','+
                                    order.shipping_address_1?order.shipping_address_1:''  +  ','+
                                    order.shipping_address_2?order.shipping_address_2:''  +  ','+
                                    order.shipping_address_city?order.shipping_address_city:''  +  ','+
                                    order.shipping_address_county?order.shipping_address_county:''  +  ','+
                                    order.shipping_address_postcode?order.shipping_address_postcode:''"  data-html="true" data-trigger="click">
                              {{customer.address1_2 ? customer.address1_2 :''  + customer.house_number?customer.house_number:''  +  customer.phone?customer.phone:''  + customer.city?customer.city:''  + customer.postcode +  customer.country?customer.country:'' }}
                  </u>
                  </span>
                    </td> -->
                     <td class="text-truncate">
                      {{customer.address1_2 ? customer.address1_2 :''  + customer.house_number?customer.house_number:''  +  customer.phone?customer.phone:''  + customer.city?customer.city:''  + customer.postcode +  customer.country?customer.country:''}}
                    </td>
                    <td>
                      <span class="row" v-if="customer.email">
                        <i class="bx bx-envelope"></i>{{ customer.email }}
                      </span>
                    </td>
                    <td>
                      <span class="row" v-if="customer.phone">
                        <i class="bx bx-phone"></i>&nbsp; {{ customer.phone }}
                      </span>
                    </td>
                    <td class="text-center">
                      <span
                        v-if="customer.channel"
                        class="
                          badge badge-light-success badge-pill
                          text-right
                          ml-1
                        "
                      >
                        {{ customer.channel ? customer.channel : "" }}
                        <!-- {{ order.order_status }} -->
                      </span>
                    </td>
                    <td class="text-right pr-5">
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
                          <a  :href="route('customers.show',customer.id)"
                            class="dropdown-item"
                            ><i class="bx bx-show mr-1"></i>Show</a
                          >
                          <a
                            :href="route('customers.edit', customer.id)"
                            class="dropdown-item"
                            ><i class="bx bx-edit-alt mr-1"></i>Edit</a
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
        <pagination :links="customers.links" class="float-right"></pagination>
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

export default {
  name: "index",
  props: ["customers", "params", "salesChannel"],
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
        ejogga: false,
        wowchar: false,
        gogroopie: false,
        xstreamgym: false,
        groupon: false,
        amazon: false,
        address1_2: false,
        phone: false,
        email: false,
        channel_id: false,
        disable: false,
        direction: null,
      },
      sweetAlert: false,
      itemId: "",
      searchItem: false,
    };
  },

  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Customer";
  },
  mounted() {
    if (this.params) {
      Object.assign(this.query, this.params);
    }
  },

  methods: {
    updatePhone(phone) {
      if (!phone.startsWith("0")) {
        return "0" + phone;
      }
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
    deleteItem() {
      this.sweetAlert = false;
      this.$inertia.delete(`/customers/${this.itemId}`);
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
      this.query.name = "";
      this.query.address1_2 = "";
      this.query.email = "";
      this.query.phone = "";
      this.query.channel_id = "";
      this.loadData();
    },
    resetFilter() {
      this.query.id = "";
      this.query.name = "";
      this.query.direction = "";
      this.query.enable = "";
      this.query.disable = "";
      this.query.ejogga = false;
      this.query.wowcher = false;
      this.query.gogroopie = false;
      this.query.xstreamgym = false;
      this.query.groupon = false;
      this.query.amazon = false;
      this.query.boomtekk = false;
      this.query.tracking = false;
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
        this.query.phone = [];
        this.query.address1_2 = [];
        this.query.email = [];
        this.query.channel_id = [];
      }
      if ((this.query.phone = false)) {
        this.query.phone = true;
        this.query.name = [];
        this.query.address1_2 = [];
        this.query.email = [];
        this.query.channel_id = [];
      }
      if ((this.query.address1_2 = false)) {
        this.query.address1_2 = true;
        this.query.name = [];
        this.query.phone = [];
        this.query.email = [];
        this.query.channel_id = [];
      }
      if ((this.query.channel_id = false)) {
        this.query.address1_2 = true;
        this.query.name = [];
        this.query.phone = [];
        this.query.email = [];
        this.query.channel_id = [];
      }
      if ((this.query.email = false)) {
        this.query.address1_2 = true;
        this.query.name = [];
        this.query.phone = [];
        this.query.email = [];
        this.query.channel_id = [];
      }
    },
    loadData() {
      let query = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
        }
      }
      this.$inertia.visit(route("customers.index"), {
        method: "get",
        data: {
          ...query,
        },
      });
    },
    showTooltipaddress(id) {
      if (this.id == null) {
        this.id = id;
        $("[data-toggle=address" + id + "]").popover({
          html: true,
          content: function () {
            return $("#popover-content-address" + id).html();
          },
        });
        $("[data-toggle=address" + id + "]").popover("show");
      } else if (this.id == id) {
        $("[data-toggle=address" + this.id + "]").popover("dispose");
        this.id = null;
      } else {
        $("[data-toggle=address" + this.id + "]").popover("dispose");
        this.id = id;
        $("[data-toggle=address" + id + "]").popover({
          html: true,
          content: function () {
            return $("#popover-content-address" + id).html();
          },
        });
        $("[data-toggle=address" + id + "]").popover("show");
      }
    },
    hideTooltipaddress(id) {
      $("[data-toggle=address" + this.id + "]").popover("dispose");
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

.bx-plus:before {
  content: "\eb21";
  color: #525151;
}
.font-size-bx {
  font-size: 29px;
}

.circle-color {
  background-color: white;
}

.bx-envelope {
  margin-right: 9px;
}

.view {
  margin-top: -19px;
  margin-left: 36px;
}

.view1 {
  margin-top: 9px;
  margin-left: -27px;
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