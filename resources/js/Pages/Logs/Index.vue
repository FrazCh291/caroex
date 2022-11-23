<template>
  <admin-layout>
    <div class="col-12 px-0">
      <div class="col form-group p-0">
        <h5>Log History</h5>
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
                        class="input-group form-group d-flex position-relative mt-1 px-2 pr-md-0 ">
                        <input
                          type="text"
                          class="form-control border-light-gray btn-height"
                          placeholder="Search..."
                          aria-label="Search"
                          aria-describedby="basic-addon2"
                          v-model="query.query"
                          @change="search" />
                        <div class="input-group-append">
                          <button
                            class="input-group-text search-btn"
                            @change="search">
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
                              class="feather feather-search feather-16 pb-0 mb-0 mt-0 " >
                              <circle cx="11" cy="11" r="8"></circle>
                              <line
                                x1="21"
                                y1="21"
                                x2="16.65"
                                y2="16.65">
                                </line>
                            </svg>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="actions action-btns d-flex align-items-center flex flex-wrap filter-container pl-1 " >
                    <div class="dropdown md:w-1/2 sm:w-1 pr-1 filter-dropdown">
                      <button
                        class="btn border dropdown-toggle w-150"
                        type="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        Filter
                      </button>
                      <div
                        class="
                          dropdown-menu dropdown-menu-right
                          py-0
                          my-0
                          custom-dropdown
                        "
                        @click="stopPropagation"
                        aria-labelledby=""
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
                                type="checkbox"
                                name="view"
                                id="view"
                                v-model="query.view"
                              />
                              <label class="pl-1 py-0 my-0" for="enable"
                                >View</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="create"
                                id="create"
                                v-model="query.create"
                              />
                              <label class="pl-1 py-0 my-0" for="disable"
                                >Create</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="store"
                                id="store"
                                v-model="query.store"
                              />
                              <label class="pl-1 py-0 my-0" for="disable"
                                >Store</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="edit"
                                id="edit"
                                v-model="query.edit"
                              />
                              <label class="pl-1 py-0 my-0" for="disable"
                                >Edit</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="update"
                                id="update"
                                v-model="query.update"
                              />
                              <label class="pl-1 py-0 my-0" for="disable"
                                >Update</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="show"
                                id="show"
                                v-model="query.show"
                              />
                              <label class="pl-1 py-0 my-0" for="disable"
                                >Show</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="delete"
                                id="delete"
                                v-model="query.delete"
                              />
                              <label class="pl-1 py-0 my-0" for="disable"
                                >Delete</label
                              >
                            </p>
                          </div>
                        </div>
                        <div class="dropdown-divider py-0 my-0"></div>
                        <div class="col-12 pl-2">
                          <p class="pt-1">
                            <button
                              type="button"
                              id="asc"
                              @click="filter"
                              class="
                                btn btn-sm btn-primary
                                font-small font-weight-normal
                                stock-order
                              "
                            >
                              Filter
                            </button>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="actions action-btns d-flex align-items-center sort-dropdown pl-1 " >
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
                                name="user_id"
                                id="user_id"
                                v-model="query.user_id"
                              />
                              <label class="pl-1 py-0 my-0" for="user_id"
                                >User
                              </label>
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="activity"
                                id="activity"
                                v-model="query.activity"
                              />
                              <label class="pl-1 py-0 my-0" for="activity"
                                >Activity</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="logable_type"
                                id="logable_type"
                                v-model="query.logable_type"
                              />
                              <label class="pl-1 py-0 my-0" for="logable_type"
                                >Module</label
                              >
                            </p>
                          </div>
                          <div class="align-items-center text-base">
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="created_at"
                                id="created_at"
                                v-model="query.created_at"
                              />
                              <label class="pl-1 py-0 my-0" for="created_at"
                                >Time/Date</label
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
                    <th class="text-left">User</th>
                    <th class="text-left text-truncate">Activity</th>
                    <th class="text-left text-truncate">Module</th>
                    <th class="text-center text-truncate">Time/Date</th>
                    <th class="text-right"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(logData, index) in logs.data" :key="index">
                    <td class="text-left">
                      {{ logData.user ? logData.user.name : "" }}
                    </td>
                    <td
                      class="text-left text-truncate"
                      :data-toggle="logData.activity == 'Update' ? 'modal' : ''"
                      :data-target="
                        logData.activity == 'Update' ? '#ab' + index : ''
                      "
                    >
                      <span
                        class="underline-dotted"
                        v-if="logData.activity === 'Update'" 
                        >{{ logData.activity }}</span>
                      <span v-else>{{ logData.activity }}</span>
                    </td>
                    <td
                      class="text-left text-truncate"
                      v-if="logData.path != null">
                      <inertia-link :href="logData.path">
                        <span v-if="logData.logable_id != null">
                          {{ "/" + logData.logable_type.substring(11) + "/"
                          }}{{ logData ? logData.logable_id : "" }}
                        </span>
                        <span v-else>
                          {{ logData.logable_type.substring(11)
                          }}{{ logData ? logData.logable_id : "" }}
                        </span>
                      </inertia-link>
                    </td>
                    <td v-else>
                      {{ "/" + logData.logable_type.substring(11) + "/"
                      }}{{ logData ? logData.logable_id : "" }}
                    </td>
                    <td class="text-center text-truncate">
                      {{ formatDate(logData.created_at) }}
                    </td>
                    <td class="text-right text-truncate"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12" v-for="(logData, index) in logs.data" :key="index">
        <div class="modal fade"
          :id="'ab' + index"
          tabindex="-1"
          v-if="logData.activity == 'Update'  && logData.activity_log_detail"
          role="dialog"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                  Activity Log details
                </h5>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close" >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-truncate">

                <span  v-for="(logDetail,index1) in logData.activity_log_detail" :key="index1">
                  <h4 v-if="logDetail.is_old">Old</h4>
                  <h4 class="mt-1" v-else>Updated</h4>
                  <span class="text-truncate" v-for="[key,value] in Object.entries(JSON.parse(logDetail ? logDetail.details: '{}'))" :key="key">
                    {{ key + " : " + value }}<br/>
                  </span>
                </span>
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>
      </div>
      <ConfirmatiomModal
        v-if="sweetAlert" :sweetAlert="sweetAlert"  @clicked="Clicked" @deleteitem="deleteItem">
      </ConfirmatiomModal>
      <div class="col-12">
        <pagination :links="logs.links" class="float-right"></pagination>
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
  props: ["logs", "params"],
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
    }
  },

  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Logs";
   console.log(this.logs,'console');
  },

  mounted() {
    if (this.params) {
      Object.assign(this.query, this.params);
    }

    this.logs.data.forEach((log)=>{
      log.activity_log_detail.forEach((logDetail)=>{
           console.log(logDetail.details);
      });

    })
  },

  methods: {
    updatePhone(phone) {
      if (!phone.startsWith("0")) {
        return "0" + phone;
      }
    },
    formatDate(date) {
      return moment(date).format("hh:mm:ss DD/MM/YYYY");
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
      this.$inertia.delete(`/logs/${this.itemId}`);
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
      this.query.name = "";
      this.query.enable = "";
      this.query.disable = "";
      this.loadData();
    },
    resetFilter() {
      this.query = {};
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
    viewLog(id, moduleName) {
      this.$inertia.visit(route("logs.show", id), {
        method: "get",
        data: {
          moduleName: moduleName,
        },
      });
    },

    showPayroll(id) {
      var detailData = this.Activitydetail.find(
        (detail) => detail.activity_log_id === id
      );
      activity.detail = detailData;
      console.log(detailData, "safasfsadfsafsdaf");
      this.form1;
      $("#logDetailModal").modal("show");
    },
    loadData() {
      let query = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
        }
      }
      this.$inertia.visit(route("logs.index"), {
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

  .modal-body-sec {
    height: 400px;
    overflow-y: auto !important;
  }
}
</style>