<template>
  <admin-layout>
    <div class="col-12 px-0">
      <div class="col form-group p-0">
        <inertia-link
          :href="route('quotation-requests.create')"
          class="btn btn-primary"
          data-repeater-create=""
        >
          Add
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
                            <h6 class="py-0 my-0">Industry</h6>
                            <span
                              class="primary pl-20 ml-2 pointer"
                              @click="resetFilter"
                              >Reset</span
                            >
                          </div>
                          <div class="align-items-center text-base pt-1">
                            <div
                              v-for="(quotationRequests, index) in quotationIndustry"
                              class="tag"
                              :key="index"
                            >
                              <input
                                :id="quotationRequests"
                                v-model="query[quotationRequests]"
                                :name="quotationRequests"
                                type="checkbox"
                              />
                              <label
                                class="pl-1 py-0 my-0"
                                :for="quotationRequests"
                                >{{ quotationRequests }}</label
                              >
                            </div>
                          </div>
                           <div class="w-100">
                            <h6 class="py-0 my-0">platform</h6>
                          </div>
                          <div class="align-items-center text-base pt-1">
                            <div
                              v-for="(quotationRequests, index) in quotationPlatform"
                              class="tag"
                              :key="index"
                            >
                              <input
                                :id="quotationRequests"
                                v-model="query[quotationRequests]"
                                :name="quotationRequests"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" :for="quotationRequests">{{
                                quotationRequests
                              }}</label>
                            </div>
                          </div>
                           <div class="w-100">
                            <h6 class="py-0 my-0">shipment_month</h6>
                          </div>
                          <div class="align-items-center text-base pt-1">
                            <div
                              v-for="(quotationRequests, index) in quotationShipment"
                              class="tag"
                              :key="index"
                            >
                              <input
                                :id="quotationRequests"
                                v-model="query[quotationRequests]"
                                :name="quotationRequests"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" :for="quotationRequests">{{
                                quotationRequests
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
                                name="first_name"
                                id="first_name"
                                v-model="query.first_name"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="first_name"
                                >Name</label
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
                                >Email</label
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
                                >Phone</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="company"
                                id="company"
                                v-model="query.company"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="company"
                                >Company</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="industry"
                                id="industry"
                                v-model="query.industry"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="industry"
                                >Industry</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="platform"
                                id="platform"
                                v-model="query.platform"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="platform"
                                >Platform</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="shipment_month"
                                id="shipment_month"
                                v-model="query.shipment_month"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="shipment_month"
                                >Shipment/Month</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="message"
                                id="message"
                                v-model="query.message"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="message"
                                >Message</label
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>Industry</th>
                    <th>Platform</th>
                    <th>Shipment Month</th>
                    <th>Message</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="quotation_request in quotation_requests.data">
                    <td
                      class="text-left pr-0 my-0"
                      @click="hideTooltip(quotation_request.id)"
                    >
                      {{
                        (quotation_request.first_name
                          ? quotation_request.first_name
                          : "") +
                        " " +
                        (quotation_request.last_name
                          ? quotation_request.last_name
                          : "")
                      }}
                    </td>
                    <td class="text-left py-0 my-0">
                      {{ quotation_request.email }}
                    </td>
                    <td class="text-left py-0 my-0">
                      {{ quotation_request.phone }}
                    </td>
                    <td class="text-left py-0 my-0">
                      {{ quotation_request.company }}
                    </td>
                    <td class="text-left py-0 my-0">
                      {{ quotation_request.industry }}
                    </td>
                    <td class="text-left py-0 my-0">
                      {{ quotation_request.platform }}
                    </td>
                    <td class="text-left py-0 my-0">
                      {{ quotation_request.shipment_month }}
                    </td>
                    <td
                      class="text-truncate"
                      v-if="quotation_request.message.length > 30"
                    >
                      <span
                        data-placement="bottom"
                        :data-toggle="quotation_request.id"
                        @click="showTooltip(quotation_request.id)"
                        data-container="body"
                        type="button"
                        data-html="true"
                        href="#"
                        id="login"
                      >
                        <span class="underline-dotted border-gray">
                          {{ quotation_request.message.substring(0, 30) }}
                        </span>
                      </span>
                      <div class="container">
                        <div
                          :id="'popover-content-' + quotation_request.id"
                          class="d-none"
                        >
                          <div class="row custom-popover popover-max">
                            <div class="col-12 px-2">
                              <span v-if="quotation_request.message">
                                <span class="font-weight-bold h5 mb-1 small">
                                  Message
                                </span>
                                <p class="py-0 mb-0 small">
                                  {{ quotation_request.message }}
                                </p>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="text-truncate" v-else>
                      {{ quotation_request.message }}
                    </td>
                    <td class="text-right py-0 my-0">
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
                            :href="
                              route(
                                'quotation-requests.edit',
                                quotation_request.id
                              )
                            "
                            class="dropdown-item"
                            ><i class="bx bx-edit-alt mr-1"></i>Edit</a
                          >
                          <a
                            class="dropdown-item"
                            v-on:click="confirmDelete(quotation_request.id)"
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
      >
      </ConfirmatiomModal>
      <div class="col-12">
        <pagination
          :links="quotation_requests.links"
          class="float-right"
        ></pagination>
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
  props: ["quotation_requests", "params","quotationIndustry","quotationPlatform","quotationShipment"],
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
        label: false,
        value: false,
        type: false,
        description: false,
        email: false,
        phone: false,
        company: false,
        industry: false,
        message: false,
        platform: false,
        shipment_month: false,
        enable: false,
        disable: false,
        direction: null,
        product_id: false,
      },
      sweetAlert: false,
      itemId: "",
      searchItem: false,
    };
  },
  beforeMount() {
    console.log(this.quotationRequests1, 'asdf');
    document.title = process.env.MIX_APP_NAME + " - quotation_request";
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
    Clicked() {
      this.sweetAlert = false;
    },
    deleteItem() {
      this.sweetAlert = false;
      this.$inertia.delete(
        `/fulfilment/admin/quotation-requests/${this.itemId}`
      );
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
      this.query.first_name = "";
      this.query.email = "";
      this.query.phone = "";
      this.query.company = "";
      this.query.industry = "";
      this.query.message = "";
      this.query.platform = "";
      this.query.shipment_month = "";
      this.loadData();
    },
    resetFilter() {
      this.query = '';
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
      if ((this.query.first_name = false)) {
        this.query.first_name = true;
        this.query.email = [];
        this.query.phone = [];
        this.query.company = [];
        this.query.message = [];
        this.query.industry = [];
        this.query.platform = [];
        this.query.shipment_month = [];
      }
      if ((this.query.email = false)) {
        this.query.email = true;
        this.query.first_name = [];
        this.query.phone = [];
        this.query.company = [];
        this.query.industry = [];
        this.query.message = [];
        this.query.platform = [];
        this.query.shipment_month = [];
      }
      if ((this.query.phone = false)) {
        this.query.phone = true;
        this.query.first_name = [];
        this.query.email = [];
        this.query.company = [];
        this.query.industry = [];
        this.query.message = [];
        this.query.platform = [];
        this.query.shipment_month = [];
      }
      if ((this.query.company = false)) {
        this.query.company = true;
        this.query.first_name = [];
        this.query.phone = [];
        this.query.email = [];
        this.query.industry = [];
        this.query.message = [];
        this.query.platform = [];
        this.query.shipment_month = [];
      }
      if ((this.query.industry = false)) {
        this.query.industry = true;
        this.query.first_name = [];
        this.query.email = [];
        this.query.phone = [];
        this.query.company = [];
        this.query.industry = [];
        this.query.platform = [];
        this.query.shipment_month = [];
      }
      if ((this.query.message = false)) {
        this.query.message = true;
        this.query.first_name = [];
        this.query.email = [];
        this.query.phone = [];
        this.query.company = [];
        this.query.industry = [];
        this.query.platform = [];
        this.query.shipment_month = [];
      }
      if ((this.query.platform = false)) {
        this.query.platform = true;
        this.query.first_name = [];
        this.query.email = [];
        this.query.phone = [];
        this.query.company = [];
        this.query.industry = [];
        this.query.message = [];
        this.query.shipment_month = [];
      }
      if ((this.query.shipment_month = false)) {
        this.query.shipment_month = true;
        this.query.first_name = [];
        this.query.email = [];
        this.query.phone = [];
        this.query.company = [];
        this.query.industry = [];
        this.query.message = [];
        this.query.platform = [];
      }
    },

    loadData() {
      let query = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
        }
      }
      this.$inertia.visit(route("quotation-requests.index"), {
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

.dropdown-menu.dropdown-menu-right.py-0.my-0.custom-dropdown.show{
  width: 260px !important;
}
.tag {
  line-height: 1rem;
  margin-bottom: 0px !important;
  margin-top: 0px !important;
  padding-bottom: 11px !important;
  padding-top: 0px !important;
}

.product-name {
  width: 30% !important;
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
  margin-top: 5px;
}

img.rounded-circle.empty-image {
  height: 40px;
  margin-bottom: 3px;
  width: 45px;
  margin-top: 5px;
}

@media (max-width: 575.98px) {
  .sort-dropdown {
    width: 100% !important;
    padding-left: 11px !important;
    padding-right: 0px !important;
    padding-top: 15px !important;
  }
}
</style>