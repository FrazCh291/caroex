<template>
  <admin-layout>
    <div class="container-fluid">
      <div class="row">
        <div class="col-2 offset-1">
          <h5><button @click="toggleWeekends">Show weekends</button></h5>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-1 col-sm-6 mb-5 border">
          <div id="sidebar" class="sidebar ps">
            <div class="sidebar-new-schedule">
              <div id="sidebar-calendars" class="sidebar-calendars">
                <div>
                  <div class="mt-1 sidebar-calendars-item"></div>
                </div>
                <div id="calendarList" class="sidebar-calendars-d1">
                  <div class="sidebar-calendars-item">
                    <label style="">
                      <a :href="route('calendar.index')">
                        <input
                          type="checkbox"
                          class="tui-full-calendar-checkbox-round"
                          value="1"
                          checked=""
                        />
                        <span
                          style="
                            border-color: rgb(0, 207, 221);
                            background-color: transparent;
                          "
                        >
                        </span
                        ><span style="font-size: 11px;">All</span>
                      </a></label
                    >
                  </div>
                  <br />
                  <div class="sidebar-calendars-item">
                    <label style="">
                      <a :href="route('order-events')">
                        <input
                          type="checkbox"
                          class="tui-full-calendar-checkbox-round"
                          value="3"
                          checked=""
                        />
                        <span style="border-color: rgb(71, 95, 123)"> </span>
                        <span style="font-size: 11px;">Order</span>
                      </a>
                    </label>
                  </div>
                  <br />
                  <div class="sidebar-calendars-item">
                    <label style="">
                      <a :href="route('delivery-events')">
                        <input
                          type="checkbox"
                          class="tui-full-calendar-checkbox-round"
                          value="4"
                          checked=""
                        />
                        <span style="border-color: rgb(57, 218, 138)"> </span>
                        <span style="font-size: 10px;">Deliveries</span>
                      </a>
                    </label>
                  </div>
                  <br />
                  <div class="sidebar-calendars-item">
                    <label style="">
                      <a :href="route('collection-events')">
                        <input
                          type="checkbox"
                          class="tui-full-calendar-checkbox-round"
                          value="3"
                          checked=""
                        />
                        <span
                          style="
                            border-color: rgb(57, 218, 138);
                            background-color: rgb(57, 218, 138);
                          "
                        >
                        </span>
                        <span style="font-size: 10px;">Collection</span>
                      </a>
                    </label>
                  </div>
                  <br />
                  <div class="sidebar-calendars-item">
                    <label style="">
                      <a :href="route('shipment-events')">
                        <input
                          type="checkbox"
                          class="tui-full-calendar-checkbox-round"
                          value="6"
                          checked=""
                        />
                        <span style="border-color: rgb(255, 91, 92)"> </span>
                        <span style="font-size: 11px;">shipment</span>
                      </a>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-11 col-sm-6 mb-5 p-2 bg-white border">
          <FullCalendar :options="calendarOptions"> </FullCalendar>
          <button
            type="button"
            id="modall"
            class="btn btn-primary d-none"
            data-toggle="modal"
            data-target="#centralModalSm"
          ></button>
          <div
            class="modal sfade"
            id="centralModalSm"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myModalLabel"
            aria-hidden="true"
          >
            <div
              class="
                modal-dialog
                modal-dialog-centered
                modal-dialog-scrollable
                modal-lg
              "
              role="document"
            >
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="card-title pb-0 mb-0" id="title">
                    Collection details
                  </h4>
                  <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body px-2 h-100 overflow-hidden">
                  <div class="col-12 px-0 h-100">
                    <div class="card">
                      <div class="card-content">
                        <div class="table-response" v-if="collections.length>=3">
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th class="text-truncate">Collection#</th>

                                <th class="text-truncate">Request Type</th>

                                <th class="text-truncate">Tracking number</th>

                                

                                <th class="text-truncate">View</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="collection in collections">
                                <td
                                  class="text-truncate"
                                  @mouseout="hideTooltip(customer_id)"
                                  @click="collectionDetail(customer_id)"
                                >
                                  {{ collection.customer_id }}
                                </td>

                                <td class="text-truncate text-center">
                                  {{
                                    collection.request_type
                                      ? collection.request_type
                                      : ""
                                  }}
                                </td>
                                <td class="text-truncate text-center">
                                  {{ collection.tracking_number }}
                                </td>
                                <td>
                                  <a
                                    :href="
                                      route('collections.show', collection.id)
                                    "
                                  >
                                    <span
                                      class="
                                        badge-circle
                                        badge-circle-light-secondary
                                        edit
                                      "
                                    >
                                      <i
                                        class="
                                          bx
                                          bxs-show
                                          font-medium-1
                                          text-center
                                        "
                                      ></i>
                                    </span>
                                  </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="table-responsive" v-else>
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th class="text-truncate">Collection#</th>

                                <th class="text-truncate">Request Type</th>

                                <th class="text-truncate">Tracking number</th>

                                <th class="text-truncate">View</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="collection in collections">
                                <td
                                  class="text-truncate"
                                  @mouseout="hideTooltip(customer_id)"
                                  @click="collectionDetail(customer_id)"
                                >
                                  {{ collection.customer_id }}
                                </td>

                                <td class="text-truncate text-center">
                                  {{
                                    collection.request_type
                                      ? collection.request_type
                                      : ""
                                  }}
                                </td>
                                <td class="text-truncate text-center">
                                  {{ collection.tracking_number }}
                                </td>
                                <td>
                                    <span
                                      class="
                                        badge-circle
                                        badge-circle-light-secondary
                                        edit
                                      "
                                    >
                                      <i
                                        class="
                                          bx
                                          bxs-show
                                          font-medium-1
                                          text-center
                                        "
                                      ></i>
                                    </span>
                                </td>
                              </tr>
                            </tbody>
                          </table>
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
    </div>
    <ConfirmatiomModal
      v-if="sweetAlert"
      :sweetAlert="sweetAlert"
      @clicked="Clicked"
      @deleteitem="deleteItem"
    ></ConfirmatiomModal>
  </admin-layout>
</template> 
<script>
import "@fullcalendar/core/vdom";
import { formatDate } from "@fullcalendar/vue3";
import AdminLayout from "../../Layouts/AdminLayout";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import interactionPlugin from "@fullcalendar/interaction";

export default {
  name: "CollectionEvents",
  props: ["events"],
  components: {
    FullCalendar,
    dayGridPlugin,
    interactionPlugin,
    AdminLayout,
    ConfirmatiomModal,
    formatDate,
  },
  data() {
    return {
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: "dayGridMonth",
        dateClick: this.handleDateClick,
        eventClick: this.handleEventClick,
        events: this.events,
        weekends: false,
        indexToUpdate: "",
      },
      return_at: "",
      orderDate: "",
      collections: [],
      id: 0,
      sweetAlert: false,
    };
  },
  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Calendar";
    let str = formatDate(new Date(), {
      month: "long",
      year: "numeric",
      day: "numeric",
    });
  },
  methods: {
    handleEventClick: function (Info) {
      var StringCheck = Info.event.title.includes("Collection");
      if (StringCheck) {
        axios
          .get("/fulfilment/search-collection-events", {
            params: {
              return_at: Info.event.start,
            },
          })
          .then((response) => {
            this.collections = response.data;
            $("#modall").click();
          });
      } else {
      }
    },

    toggleWeekends: function () {
      this.calendarOptions.weekends = !this.calendarOptions.weekends;
    },
    addNewEvent() {
      axios
        .post("/calendar", {
          ...this.newEvent,
        })
        .then((data) => {
          this.getEvents();
          this.resetForm();
        })
    },
    formatDate(date) {
      return moment(date).format("DD/MM/YYYY");
    },
    Clicked() {
      this.sweetAlert = false;
    },
    deleteItem() {
      this.sweetAlert = false;
      this.$inertia.delete(`/calendar/${this.itemId}`);
    },
    confirmDelete(id) {
      this.sweetAlert = true;
      this.itemId = id;
    },
    showEvent(arg) {
      this.addingMode = true;
      const { id } = this.events.find((event) => event.id === +arg.event.id);
      this.indexToUpdate = id;
    },

    updateEvent() {},
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
  text-align: center;
}

.action {
  margin-right: 4px !important;
}

.card {
  border: 1px solid #d2d6dc;
  border-radius: 0px !important;
}

.table-response {
    display: block;
    width: 100%;
    height: 300px;
    overflow-x: auto;
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
  .calendar {
    width: 100% !important;
    padding-left: 11px !important;
    padding-right: 0px !important;
    padding-top: 15px !important;
  }
}
</style>
