<template>
  <admin-layout>
    <div class="col-12 px-0">
      <div class="col form-group p-0">
        <inertia-link
          :href="route('reviews.create')"
          class="btn btn-primary"
          data-repeater-create=""
        >
          Add Review
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
                      flex flex-wrap
                      pl-md-1
                      sm:pl-2
                      filter-dropdown
                    "
                  >
                    <div class="dropdown md:w-1/3 sm:w-1 pr-1 filter-dropdown">
                      <button
                        class="btn border dropdown-toggle w-100"
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
                            <div
                              v-for="(reviews, index) in review1"
                              class="tag"
                              :key="index"
                            >
                              <input
                                :id="reviews"
                                v-model="query[reviews]"
                                :name="reviews"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" :for="reviews">{{
                                reviews === "review_approved"
                                  ? "Approved"
                                  : "Unapproved"
                              }}</label>
                            </div>
                          </div>
                          <div class="w-100">
                            <h6 class="py-0 my-0">Rating</h6>
                          </div>
                          <div class="align-items-center text-base pt-1">
                            <div
                              v-for="(reviews, index) in review2"
                              class="tag"
                              :key="index"
                            >
                              <input
                                :id="reviews"
                                v-model="query[reviews]"
                                :name="reviews"
                                type="checkbox"
                              />
                              <label class="pl-1 py-0 my-0" :for="reviews">{{
                                reviews
                              }}</label>
                            </div>
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
                    <div class="dropdown md:w-1/3 sm:w-1 pr-1 filter-dropdown">
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
                            >
                              Reset</span
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
                                >Name</label
                              >
                            </p>
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
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="comment"
                                id="comment"
                                v-model="query.comment"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="comment"
                                >Comment</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="rating"
                                id="rating"
                                v-model="query.rating"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="rating"
                                >Rating</label
                              >
                            </p>
                            <p class="tag">
                              <input
                                type="checkbox"
                                name="status"
                                id="status"
                                v-model="query.status"
                                v-on:click="check_one()"
                              />
                              <label class="pl-1 py-0 my-0" for="status"
                                >Status</label
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

                    <div class="dropdown md:w-1/3 sm:w-1 pr-1 filter-dropdown">
                      <a :href="route('reviews.export')">
                        <button
                          class="
                            btn
                            border
                            px-1
                            line-height
                            font-small font-weight-normal
                          "
                          type="button"
                        >
                          <i class="bx bx-xs bx-upload pr-0.5 pb-0.5"></i
                          ><span class="pl-0.5 pt-3">Export</span>
                        </button>
                      </a>
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
                    <th>Channel</th>
                    <th class="text-center pr-5">Rating</th>
                    <th>Comment</th>
                    <th class="pl-4">Status</th>
                    <th class="text-right"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="review in reviews.data">
                    <td class="py-0 my-0" @click="hideTooltip(review.id)">
                      {{ review.name }}
                    </td>
                    <td class="py-0 my-0" @click="hideTooltip(review.id)">
                      {{ review.email }}
                    </td>
                    <td class="py-0 my-0" @click="hideTooltip(review.id)">
                      {{ review.channels.name }}
                    </td>
                    <td
                      class="text-center pr-5"
                      @click="hideTooltip(review.id)"
                    >
                      {{ review.rating }}
                    </td>
                    <td class="text-truncate" v-if="review.comment.length > 30">
                      <span
                        data-placement="bottom"
                        :data-toggle="review.id"
                        @click="showTooltip(review.id)"
                        data-container="body"
                        type="button"
                        data-html="true"
                        href="#"
                        id="login"
                      >
                        <span class="underline-dotted border-gray">
                          {{ review.comment.substring(0, 30) }}
                        </span>
                      </span>
                      <div class="container">
                        <div
                          :id="'popover-content-' + review.id"
                          class="d-none"
                        >
                          <div class="row custom-popover popover-max">
                            <div class="col-12 px-2">
                              <span v-if="review.comment">
                                <span class="font-weight-bold h5 mb-1 small">
                                  Comment
                                </span>
                                <p class="py-0 mb-0 small">
                                  {{ review.comment }}
                                </p>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="text-truncate" v-else>{{ review.comment }}</td>
                    <td class="text-left py-0 my-0">
                      <span
                        v-if="review.status === 'review_approved'"
                        class="badge badge-light-success badge-pill"
                        @click="hideTooltip(review.id)"
                        >Approved</span
                      >
                      <span
                        v-else
                        class="badge badge-light-danger badge-pill"
                        @click="hideTooltip(review.id)"
                        >Unapproved</span
                      >
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
                            :href="route('reviews.show', review.id)"
                            class="dropdown-item"
                            ><i class="bx bxs-show mr-1"></i>Show</a
                          >
                          <a
                            :href="route('reviews.edit', review.id)"
                            class="dropdown-item"
                            ><i class="bx bx-edit-alt mr-1"></i>Edit</a
                          >
                          <a
                            class="dropdown-item"
                            v-on:click="confirmDelete(review.id)"
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
        <pagination :links="reviews.links" class="float-right"></pagination>
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
// import DeletedModal from "../SweetAlert/DeletedModal";

export default {
  name: "index",
  props: ["reviews", "params", "review1", "review2"],
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
        email: false,
        channel_id: false,
        rating: false,
        comment: false,
        status: false,
        unapproved: false,
        approved: false,
        rating1: false,
        rating2: false,
        rating3: false,
        rating4: false,
        rating5: false,
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
    document.title = process.env.MIX_APP_NAME + " - Reviews";
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
      this.$inertia.delete(`/erp/reviews/${this.itemId}`);
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
      this.query.name = "";
      this.query.email = "";
      this.query.channel_id = "";
      this.query.rating = "";
      this.query.comment = "";
      this.query.status = "";
      this.query.sku = "";
      this.query.disable = "";
      this.loadData();
    },
    resetFilter() {
      this.query.direction = "";
      this.query.review_unapproved = false;
      this.query.review_approved = false;
      this.query.rating1 = false;
      this.query.rating2 = false;
      this.query.rating3 = false;
      this.query.rating4 = false;
      this.query.rating5 = false;
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
      if ((this.query.name = false)) {
        this.query.name = true;
        this.query.email = [];
        this.query.channel_id = [];
        this.query.comment = [];
        this.query.rating = [];
        this.query.status = [];
      }
      if ((this.query.email = false)) {
        this.query.email = true;
        this.query.name = [];
        this.query.channel_id = [];
        this.query.comment = [];
        this.query.rating = [];
        this.query.status = [];
      }
      if ((this.query.channel_id = false)) {
        this.query.channel_id = true;
        this.query.name = [];
        this.query.email = [];
        this.query.comment = [];
        this.query.rating = [];
        this.query.status = [];
      }
      if ((this.query.comment = false)) {
        this.query.comment = true;
        this.query.name = [];
        this.query.channel_id = [];
        this.query.rating = [];
        this.query.email = [];
        this.query.status = [];
      }
      if ((this.query.rating = false)) {
        this.query.rating = true;
        this.query.name = [];
        this.query.channel_id = [];
        this.query.comment = [];
        this.query.email = [];
        this.query.status = [];
      }
      if ((this.query.status = false)) {
        this.query.status = true;
        this.query.name = [];
        this.query.comment = true;
        this.query.channel_id = [];
        this.query.email = [];
        this.query.rating = [];
      }
    },

    loadData() {
      let query = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
        }
      }
      this.$inertia.visit(route("reviews.index"), {
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
