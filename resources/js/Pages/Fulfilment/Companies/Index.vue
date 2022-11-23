<template>
  <admin-layout>
    <div class="col-12 px-0">
      <div class="col form-group p-0">
        <inertia-link
          :href="route('company.create')"
          class="btn btn-primary"
          data-repeater-create=""
        >
          Add Company
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
                      action-btn
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
                        <div class="col-12 pl-2 pt-1" id="sortmenue">
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
                                >Company</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base pt-0">
                            <p class="tag">
                              <input
                                id="contact_name"
                                v-model="query.contact_name"
                                v-on:click="check_one()"
                                name="contact_name"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" for="name"
                                >Contact Name</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base pt-0">
                            <p class="tag">
                              <input
                                id="email"
                                v-model="query.email"
                                v-on:click="check_one()"
                                name="email"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" for="name"
                                >Email</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base pt-0">
                            <p class="tag">
                              <input
                                id="phone"
                                v-model="query.phone"
                                v-on:click="check_one()"
                                name="phone"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" for="phone"
                                >Phone</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base pt-0">
                            <p class="tag">
                              <input
                                id="type"
                                v-model="query.type"
                                v-on:click="check_one()"
                                name="type"
                                type="checkbox"
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
                    <td class="text-left pl-2">{{ company.type }}</td>
                    <td class="text-right">
                        <div class="dropdown">
                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                        </span>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a :href="route('company.show', company.id)" class="dropdown-item"><i class=" bx bx-show mr-1"></i>Show</a>
                        <a :href="route('company.edit', company.id)" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                        <a class="dropdown-item" v-on:click="confirmDelete(company.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
        value: false,
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
      this.$inertia.delete(`/fulfilment/admin/company/${this.itemId}`);
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
      this.query.contact_name = false;
      this.query.email = false;
      this.query.phone = false;
      this.query.type = false;
      this.query.name = false;
      this.query.value = false;
      this.query.enable = "";
      this.query.disable = "";
      this.loadData();
    },
    resetFilter() {
      this.query.id = "";
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

   check_one: function(){
       if (this.query.name  = false){
                this.query.name = true;
                this.query.contact_name = [];
                this.query.email = [];
                 this.query.phone = [];
                this.query.type = [];
            }
            if (this.query.contact_name = false){
                this.query.contact_name = true;
                this.query.name = [];
                this.query.email = [];
                 this.query.phone = [];
                this.query.type = [];
            }
            if (this.query.phone  = false){
                this.query.phone = true;
                this.query.name = [];
                this.query.contact_name = [];
                 this.query.type = [];
                this.query.email = [];
            }
              if (this.query.type  = false){
                this.query.type = true;
                this.query.name = [];
                this.query.contact_name = [];
                 this.query.email = [];
                this.query.phone = [];
            }
              if (this.query.email  = false){
                this.query.email = true;
                this.query.name = [];
                this.query.contact_name = [];
                this.query.type = [];
                this.query.phone = [];
            }
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
        Object.assign(query, { phone: this.query.phone });
      }
      if (this.query.email) {
        Object.assign(query, { email: this.query.email });
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
      this.$inertia.visit(route("company.index"), {
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

  #sortmenue {
    margin-top: 50px;
  }
}
</style>