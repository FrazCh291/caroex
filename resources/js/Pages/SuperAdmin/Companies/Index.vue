<template>
  <admin-layout>
    <div class="col-12 px-0">
      <div class="col form-group p-0">
        <inertia-link
          :href="route('companys.create')"
          class="btn btn-primary"
          data-repeater-create="">
          Add Company
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
                      action-btn
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
                                name="name"
                                id="name"
                                v-model="query.name"
                              />
                              <label class="pl-1 py-0 my-0" for="name"
                                >Company</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base pt-0">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="contact_name"
                                id="contact_name"
                                v-model="query.contact_name"
                              />
                              <label class="pl-1 py-0 my-0" for="name"
                                >Contact Name</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base pt-0">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="email"
                                id="email"
                                v-model="query.email"
                              />
                              <label class="pl-1 py-0 my-0" for="name"
                                >Email</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base pt-0">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="phone"
                                id="phone"
                                v-model="query.phone"
                              />
                              <label class="pl-1 py-0 my-0" for="phone"
                                >Phone</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base pt-0">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="type"
                                id="type"
                                v-model="query.type"
                              />
                              <label class="pl-1 py-0 my-0" for="type"
                                >Type</label
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
                    <th class="text-left pl-2">Company</th>
                    <th class="text-left pl-2">Contact Name</th>
                    <th class="text-left pl-2">Email</th>
                    <th class="text-left pl-2">Phone</th>
                    <th class="text-left pl-2">Type</th>
                    <th class="text-right"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="company in companies.data">
                    <td class="text-left pl-2">{{ company.name }}</td>
                     <td class="text-left pl-2">{{ company.contact_name }}</td>
                      <td class="text-left pl-2">{{ company.email }}</td>
                       <td class="text-left pl-2">{{ company.phone }}</td>
                    <td class="text-left pl-2">{{ company.type}}</td>
                    <td class="text-right">
                      <span class="d-inline-flex align-items-center">
                        <inertia-link
                          :href="route('companys.show', company.id)"
                        >
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
                        <inertia-link
                          :href="route('companys.edit', company.id)"
                        >
                          <span
                            class="
                              badge-circle badge-circle-light-secondary
                              action
                            "
                          >
                            <i
                              class="
                                bx bx-edit
                                font-medium-1
                                align-items-center
                                text-left
                              "
                            ></i>
                          </span>
                        </inertia-link>
                        <button v-on:click="confirmDelete(company.id)">
                          <span
                            class="
                              badge-circle badge-circle-light-secondary
                              ml-1/6
                            "
                          >
                            <i
                              class="bx bx-trash font-medium-1 text-center"
                            ></i>
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
        <pagination :links="companies.links" class="float-right"></pagination>
      </div>
    </div>
  </admin-layout>
</template>

<script>
import AdminLayout from "../../../Layouts/AdminLayout";
import Button from "../../../Jetstream/Button";
import Pagination from "../../../admin/Pagination";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";
import DeletedModal from "../../SweetAlert/DeletedModal";

export default {
  name: "index",
  props: ["companies", "params"],
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
        type: false,
        name: false,
        contact_name: false,
        email: false,
        phone: false,
        enable: false,
        disable: false,
        value: false,
        direction: null,
      },
      sweetAlert: false,
      itemId: "",
      searchItem: false,
    };
  },
  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Companies";
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
      this.$inertia.delete(`/super/admin/companys/${this.itemId}`);
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
      this.query.contact_name = "";
      this.query.email = "";
      this.query.phone= "";
      this.query.type = "";
      this.query.name = "";
      this.query.value = "";
      this.query.enable = "";
      this.query.disable = "";
      this.loadData();
    },
    resetFilter() {
      this.query = {};
      this.query.id = "";
      this.query.type = "";
      this.query.name = "";
      this.query.contact_name = "";
      this.query.email = "";
      this.query.phone= "";
      this.query.value = "";
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
    loadData() {
      let query = {};

      if (this.query.query) {
        Object.assign(query, { query: this.query.query });
      }
      if (this.query.id) {
        Object.assign(query, { id: this.query.id });
      }
      if (this.query.type) {
        Object.assign(query, { type: this.query.type });
      }
      if (this.query.enable) {
        Object.assign(query, { enable: this.query.enable });
      }
      if (this.query.name) {
        Object.assign(query, { name: this.query.name });
      }
      if (this.query.phone) {
        Object.assign(query, {phone: this.query.phone});
      }
      if (this.query.email) {
        Object.assign(query, {email: this.query.email});
      }
      if (this.query.contact_name) {
        Object.assign(query, { contact_name: this.query.contact_name });
      }
      if (this.query.disable) {
        Object.assign(query, { disable: this.query.disable });
      }
      if (this.query.value) {
        Object.assign(query, { value: this.query.value });
      }
      if (this.query.direction) {
        Object.assign(query, { direction: this.query.direction });
      }
      this.$inertia.visit(route("companies.index"), {
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
