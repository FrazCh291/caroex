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
                <div class="mt-1 sidebar-calendars-item">
                  <label style="">
                    <a :href="route('order-events')">
                      <input
                        type="checkbox"
                        class="tui-full-calendar-checkbox-round"
                        value="2"
                        checked=""
                      />
                      <span
                        style="border-color: rgb(0, 207, 221); rgb(255, 91, 92);  background-color: transparent; ;"
                      >
                      </span>
                      <span style="font-size: 11px"> All </span>
                    </a>
                  </label>
                </div>

                <div id="checkbox1" class="sidebar-calendars-d1"></div>
                <div id="checkbox1" class="mt-1 sidebar-calendars-d1">
                  <div class="mt-1 sidebar-calendars-item">
                    <label style="">
                      <a :href="route('order-events')">
                        <input
                          type="checkbox"
                          class="tui-full-calendar-checkbox-round"
                          value="3"
                          checked=""
                        />
                        <span
                          style="
                            border-color: rgb(71, 95, 123);
                            background-color: transparent;
                          "
                        >
                        </span>
                        <span style="font-size: 11px"> Orders </span>
                      </a>
                    </label>
                  </div>

                  <div class="mt-1 sidebar-calendars-item">
                    <label style="">
                      <a :href="route('delivery-events')">
                        <input
                          type="checkbox"
                          class="tui-full-calendar-checkbox-round"
                          checked=""
                        />
                        <span
                          style="
                            border-color: rgb(57, 218, 138);
                            background-color: rgb(57, 218, 138);
                          "
                        >
                        </span>
                        <span style="font-size: 10px">Deliveries</span>
                      </a>
                    </label>
                  </div>
                  <br />
                  <!-- <div class="sidebar-calendars-item">
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
                            border-color: rgb(71, 95, 123);
                           
                          "
                        >
                        </span>
                        <span style="font-size: 10px;">Collection</span>
                      </a>
                    </label>
                  </div>
                  <br /> -->
                  <div class="sidebar-calendars-item">
                    <label style="">
                      <a :href="route('shipment-events')">
                        <input
                          type="checkbox"
                          class="tui-full-calendar-checkbox-round"
                          checked=""
                        />
                        <span
                          style="
                            border-color: rgb(255, 91, 92);
                            background-color: transparent; ;
                          "
                        >
                        </span>
                        <span style="font-size: 11px">shipment</span>
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
            id="modal3"
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
                    Delivery details
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
                        <div
                          class="table-response"
                          v-if="deliveryItems.length >= 3"
                        >
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th class="text-truncate">order#</th>

                                <th class="text-truncate">Product</th>

                                <th class="text-truncate">is collected</th>

                                <th class="text-truncate">delivery method</th>

                                <th class="text-truncate">delivery status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="deliveryItem in deliveryItems">
                                <td class="text-truncate">
                                  {{ deliveryItem.order_item_id }}
                                </td>
                                <td class="text-truncate">
                                  {{
                                    deliveryItem.order_item.product.name
                                  }}
                                </td>

                                <!-- <td
                                  class="text-truncate "
                                >
                                  {{ deliveryItem.delivery_id }}
                                </td> -->
                                <td class="text-truncate">
                                  {{ deliveryItem.is_collected }}
                                </td>
                                <td class="text-truncate">
                                  {{ deliveryItem.delivery_method }}
                                </td>
                                <!-- <td class="text-center">
                                  {{ deliveryItem.status }}

                                  <i
                                    class="
                                      bx bx-check
                                      text-light-success text-right
                                    "
                                    v-if="deliveryItem.status == 'Active'"
                                  ></i>

                                  <i
                                    class="
                                      bi bi-x
                                      text-light-success text-right
                                    "
                                    v-if="deliveryItem.status == 'InActive'"
                                  ></i>
                                </td> -->

                                <td>
                                  <p
                                    class="
                                      badge badge-light-success badge-pill
                                      text-right
                                      ml-1
                                    "
                                  >
                                    {{ deliveryItem.status }}
                                  </p>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="table-responsive" v-else>
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                               
                                <th class="text-truncate">order#</th>

                                 <th class="text-truncate">Product</th>

                                <th class="text-truncate">is collected</th>

                                <th class="text-truncate">delivery method</th>

                                <th class="text-truncate">delivery status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="deliveryItem in deliveryItems">
                                 <td class="text-truncate">
                                  {{ deliveryItem.order_item_id }}
                                </td>
                                <td class="text-truncate">
                                  {{
                                    deliveryItem.order_item.product.name
                                  }}
                                </td>
                                <td class="text-truncate">
                                  {{ deliveryItem.is_collected }}
                                </td>
                                <td class="text-truncate">
                                  {{ deliveryItem.delivery_method }}
                                </td>

                                <!-- <td class="text-center">
                                  {{ deliveryItem.status }}

                                  <i
                                    class="
                                      bx bx-check
                                      text-light-success text-right
                                    "
                                    v-if="deliveryItem.status == 'Active'"
                                  ></i>

                                  <i
                                    class="
                                      bi bi-box
                                      text-light-success text-right
                                    "
                                    v-if="deliveryItem.status == 'InActive'"
                                  ></i>
                                </td> -->
                                <td>
                                  <p
                                    class="
                                      text-truncate
                                      ml-n2
                                      text-center
                                      badge
                                      mt-2 badge-pill badge-success
                                    "
                                  >
                                    {{ deliveryItem.status }}
                                    <i
                                      class="
                                        bx bx-check
                                        text-light-success text-right
                                      "
                                    ></i>
                                  </p>
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
  name: "DeliveryEvents",
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
        weekends: true,
        indexToUpdate: "",
      },

      delivery_type: "",
      delivery_date: "",
      orderDate: "",
      deliveryItems: [],
      id: 0,
      sweetAlert: false,
    };
  },
  beforeMount() {
    console.log(this.events,'Junaid');
    document.title = process.env.MIX_APP_NAME + " - DeliveryEvents";
    let str = formatDate(new Date(), {
      month: "long",
      year: "numeric",
      day: "numeric",
    });
  },

  methods: {
    handleEventClick: function (Info) {
      var StringCheck = Info.event.title.includes("Delivery");
      if (StringCheck) {
        axios
          .get("/fulfilment/search-delivery-events", {
            params: {
              delivery_date: Info.event.start,
            },
          })
          .then((response) => {
            this.deliveryItems = response.data;
            console.log(this.deliveryItems);
            $("#modal3").click();
          });
      } else {
      }
    },
    toggleWeekends: function () {
      this.calendarOptions.weekends = !this.calendarOptions.weekends; // toggle the boolean!
    },
    addNewEvent() {
      axios
        .post("/calendar", {
          ...this.newEvent,
        })
        .then((data) => {
          this.getEvents();
          this.resetForm();
        });
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
      alert("Go");
      this.addingMode = true;
      const { id } = this.events.find((event) => event.id === + arg.event.id);
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
  max-height: 300px;
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
