<template>
  <admin-layout>
     <div class="row">
        <div class="col-12  offset-1">
          <h5><button @click="toggleWeekends">Show weekends</button></h5>
        </div>
      </div>
    <div class="container-fluid">
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
                            background-color: rgb(0, 207, 221);
                          "
                        >
                        </span
                        ><span style="font-size: 11px;">All</span>
                      </a>
                    </label>
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
                        <span
                          style="
                            border-color: rgb(71, 95, 123);
                            background-color: rgb(71, 95, 123);
                          "
                        >
                        </span>
                        <span style="font-size: 11px;">Order </span>
                      </a>
                    </label>
                  </div>
                  <br />
                  <div class="sidebar-calendars-item">
                    <label class="">
                      <a :href="route('delivery-events')">
                        <input
                          type="checkbox"
                          class="tui-full-calendar-checkbox-round"
                          value="4"
                          checked=""
                        />
                        <span
                          style="
                            border-color: rgb(57, 218, 138);
                            background-color: rgb(57, 218, 138);
                          "
                        >
                        </span>
                        <span style="font-size: 10px;">Deliveries</span>
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
                            border-color: #5a8dee;
                            background-color: #5a8dee;
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
                          value="6"
                          checked=""
                        />
                        <span
                          style="
                            border-color: #ff5b5c;
                            background-color: #ff5b5c;
                          "
                        >
                        </span>
                        <span style="font-size: 11px;">shipment</span>
                      </a>
                    </label>
                  </div>
                  <br />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-11 col-sm-6 mb-5 p-1 bg-white border">
          <FullCalendar :options="calendarOptions"> </FullCalendar>

          <button
            type="button"
            id="modal"
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
                    Orders Detail
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
                        <div class="table-response" v-if="orders.length>=3">
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th class="text-truncate">Order#</th>

                                <th class="text-truncate">Customer name</th>

                                <th class="text-truncate">Delivery Address</th>

                                <th class="text-truncate text-left">
                                  Product
                                </th>

                                <th class="text-truncate text-center">
                                  Order Status
                                </th>

                                <th class="text-truncate text-center">
                                  Action
                                </th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="order in orders">
                                <td
                                  class="text-truncate"
                                  @mouseout="order.id;"
                                  @click="order.id;"
                                >
                                  {{ order.order_number }}
                                </td>
                                <td
                                  class="text-truncate"
                                  v-if="order.shipping_customer_name"
                                >
                                  <span
                                    id="dropdownMenuButton1"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                  >
                                    <span
                                      class="
                                        border-gray
                                        buildingName
                                        text-truncate
                                      "
                                      ><span class="underline-dotted">
                                        {{ order.shipping_customer_name }}
                                      </span></span
                                    ></span
                                  >
                                  <div class="container">
                                    <div
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <div
                                        class="row custom-popover popover-max"
                                      >
                                        <div class="col-12 px-2">
                                          <span>
                                            <span
                                              class="
                                                font-weight-bold
                                                h5
                                                mb-1
                                                small
                                              "
                                            >
                                              Email: </span
                                            >{{ order.shipping_email }}
                                          </span>
                                          <br />
                                          <span>
                                            <span
                                              class="
                                                font-weight-bold
                                                h5
                                                mb-1
                                                small
                                              "
                                            >
                                              Phone: </span
                                            >{{ order.shipping_address_phone }}
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                                <td
                                class="text-truncate"
                                v-if="order.shipping_address_1"
                                >
                                  <span
                                    id="dropdownMenuButton2"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                  >
                                    <span
                                      class="
                                        border-gray
                                        buildingName
                                        text-truncate
                                      "
                                      ><span class="underline-dotted">
                                        {{ order.shipping_address_1 }}
                                      </span></span
                                    ></span
                                  >
                                  <div class="container">
                                    <div
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton2"
                                    >
                                      <div
                                        class="row custom-popover popover-max"
                                      >
                                        <div class="col-12 px-2">
                                          <span>
                                            <span
                                              class="
                                                font-weight-bold
                                                h5
                                                mb-1
                                                small
                                              "
                                            >
                                              Billing Address: </span
                                            >{{ order.billing_address_1_2 }}
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </td>

                                <td
                                  class="text-truncate text-left"
                                  @mouseout="order.id;"
                                  @click="orderDetail(order.id)"
                                >
                                  {{ order.product.name }}
                                </td>

                                <td
                                  class="text-truncate text-center"
                                  @mouseout="hideTooltip(order.id)"
                                  @click="orderDetail(order.id)"
                                >
                                  <span
                                    class="
                                      badge badge-light-success badge-pill
                                      text-right
                                      ml-1
                                    "
                                    v-if="
                                      order.order_status == 'Processing' ||
                                      order.order_status == 'processing'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-warning ml-1"
                                    v-if="
                                      order.order_status == 'pending' ||
                                      order.order_status == 'Pending'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-danger ml-1"
                                    v-if="
                                      order.order_status == 'cancelled' ||
                                      order.order_status == 'Cancelled'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-success ml-1"
                                    v-if="
                                      order.order_status == 'completed' ||
                                      order.order_status == 'Completed'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-success ml-1"
                                    v-if="
                                      order.order_status == 'shipped' ||
                                      order.order_status == 'shipped'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-success ml-1"
                                    v-if="
                                      order.order_status == 'collection' ||
                                      order.order_status == 'Collection'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-success ml-1"
                                    v-if="
                                      order.order_status == 'replacement' ||
                                      order.order_status == 'Replacement'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-success ml-1"
                                    v-if="
                                      order.order_status == 'redispatch' ||
                                      order.order_status == 'Redispatch'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                </td>
                                <td>
                                  <a
                                    :href="
                                      route('order.show', order.id)
                                    "
                                  >
                                    <span
                                      class="
                                        badge-circle
                                        badge-circle-light-secondary
                                        edit
                                      "
                                      @click="orderDetail(order.id)"
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
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="table-responsive" v-else>
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th class="text-truncate">Order#</th>

                                <th class="text-truncate">Customer name</th>

                                <th class="text-truncate">Delivery Address</th>

                                <th class="text-truncate text-left">
                                  Product
                                </th>

                                <th class="text-truncate text-center">
                                  Order Status
                                </th>

                                <th class="text-truncate text-center">
                                  Action
                                </th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="order in orders">
                                <td
                                  class="text-truncate"
                                  @mouseout="order.id;"
                                  @click="order.id;"
                                >
                                  {{ order.order_number }}
                                </td>
                                <td
                                  class="text-truncate"
                                  v-if="order.shipping_customer_name"
                                >
                                  <span
                                    id="dropdownMenuButton1"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                  >
                                    <span
                                      class="
                                        border-gray
                                        buildingName
                                        text-truncate
                                      "
                                      ><span class="underline-dotted">
                                        {{ order.shipping_customer_name }}
                                      </span></span
                                    ></span
                                  >
                                  <div class="container">
                                    <div
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <div
                                        class="row custom-popover popover-max"
                                      >
                                        <div class="col-12 px-2">
                                          <span>
                                            <span
                                              class="
                                                font-weight-bold
                                                h5
                                                mb-1
                                                small
                                              "
                                            >
                                              Email: </span
                                            >{{ order.shipping_email }}
                                          </span>
                                          <br />
                                          <span>
                                            <span
                                              class="
                                                font-weight-bold
                                                h5
                                                mb-1
                                                small
                                              "
                                            >
                                              Phone: </span
                                            >{{ order.shipping_address_phone }}
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                                <td
                                class="text-truncate"
                                v-if="order.shipping_address_1"
                                >
                                  <span
                                    id="dropdownMenuButton2"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                  >
                                    <span
                                      class="
                                        border-gray
                                        buildingName
                                        text-truncate
                                      "
                                      ><span class="underline-dotted">
                                        {{ order.shipping_address_1 }}
                                      </span></span
                                    ></span
                                  >
                                  <div class="container">
                                    <div
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton2"
                                    >
                                      <div
                                        class="row custom-popover popover-max"
                                      >
                                        <div class="col-12 px-2">
                                          <span>
                                            <span
                                              class="
                                                font-weight-bold
                                                h5
                                                mb-1
                                                small
                                              "
                                            >
                                              Billing Address: </span
                                            >{{ order.billing_address_1_2 }}
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </td>

                                <td
                                  class="text-truncate text-center"
                                  @mouseout="order.id;"
                                  @click="orderDetail(order.id)"
                                >
                                  {{ order.product.name }}
                                </td>

                                <td
                                  class="text-truncate text-center"
                                  @mouseout="hideTooltip(order.id)"
                                  @click="orderDetail(order.id)"
                                >
                                  <span
                                    class="
                                      badge badge-light-success badge-pill
                                      text-right
                                      ml-1
                                    "
                                    v-if="
                                      order.order_status == 'Processing' ||
                                      order.order_status == 'processing'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-warning ml-1"
                                    v-if="
                                      order.order_status == 'pending' ||
                                      order.order_status == 'Pending'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-danger ml-1"
                                    v-if="
                                      order.order_status == 'cancelled' ||
                                      order.order_status == 'Cancelled'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-success ml-1"
                                    v-if="
                                      order.order_status == 'completed' ||
                                      order.order_status == 'Completed'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-success ml-1"
                                    v-if="
                                      order.order_status == 'shipped' ||
                                      order.order_status == 'shipped'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-success ml-1"
                                    v-if="
                                      order.order_status == 'collection' ||
                                      order.order_status == 'Collection'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-success ml-1"
                                    v-if="
                                      order.order_status == 'replacement' ||
                                      order.order_status == 'Replacement'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                  <span
                                    class="badge badge-pill badge-success ml-1"
                                    v-if="
                                      order.order_status == 'redispatch' ||
                                      order.order_status == 'Redispatch'
                                    "
                                  >
                                    {{ order.order_status }}
                                  </span>
                                </td>
                                <td>
                                  <a
                                    :href="
                                      route('order.show', order.id)
                                    "
                                  >
                                    <span
                                      class="
                                        badge-circle
                                        badge-circle-light-secondary
                                        edit
                                      "
                                      @click="orderDetail(order.id)"
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
                                <td></td>
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
          <button
            type="button"
            id="collectionModal"
            class="btn btn-primary d-none"
            data-toggle="modal"
            data-target="#collection"
          ></button>
          <div
            class="modal sfade"
            id="collection"
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

          <button
            type="button"
            id="deliveryModal"
            class="btn btn-primary d-none"
            data-toggle="modal"
            data-target="#delivery"
          ></button>
          <div
            class="modal sfade"
            id="delivery"
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
                         <div class="table-response" v-if="deliveryItems.length>=3">
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

                                        <i class="bx bx-check text-light-success text-right"

                                           v-if="deliveryItem.status == 'Active'"></i>
                                           <i class=" bx bx-cancel text-light-success text-right"

                                           v-else></i>

                                    </td> -->


                                <td><p class="
                                      badge badge-light-success badge-pill
                                      text-right
                                      ml-1
                                    ">
                                  {{ deliveryItem.status}}

                                  </p></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                          <div class="table-responsive" v-else>
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th class="text-truncate">Product</th>

                               <th class="text-truncate">order#</th>

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

                                        <i class="bx bx-check text-light-success text-right"

                                           v-if="deliveryItem.status == 'Active'"></i>
                                           <i class="bx bx-cancel text-light-success text-right"

                                           v-else></i>

                                    </td> -->
                                <td><p class="
                                      badge badge-light-success badge-pill
                                      text-right
                                      ml-1
                                    ">
                                  {{ deliveryItem.status}}

                                  </p></td>
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

          <button
            type="button"
            id="containerModal"
            class="btn btn-primary d-none"
            data-toggle="modal"
            data-target="#container"
          ></button>
          <div
            class="modal sfade"
            id="container"
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
                    Shipment Detail
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
                        <div class="table-response" v-if="shipments.length>=3">
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th class="text-truncate">container#</th>
                                <th class="text-truncate">total cartons</th>
                                 <th class="text-truncate">uk eta</th>
                                <th class="text-truncate">shipment status</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                               <tr v-for="shipment in shipments">

                                  <td
                                  class="text-truncate"
                                >
                                  {{ shipment.container_number  }}
                                </td>
                                 <td
                                  class="text-center"
                                >
                                  {{ shipment.total_cartons }}
                                </td>
                                 <td
                                  class="text-truncate"
                                >
                                  {{ shipment.uk_eta }}
                                </td>
                                 <td>
                                   <p
                                    class="
                                     badge badge-light-success badge-pill text-right ml-1">
                                  {{shipment.shipment_status}}

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
                                <th class="text-truncate">container#</th>
                                <th class="text-truncate">total cartons</th>
                                 <th class="text-truncate">uk eta</th>
                                <th class="text-truncate">shipment status</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                               <tr v-for="shipment in shipments">

                                  <td
                                  class="text-truncate"
                                >
                                  {{ shipment.container_number  }}
                                </td>
                                 <td
                                  class="text-center"
                                >
                                  {{ shipment.total_cartons }}
                                </td>
                                 <td
                                  class="text-truncate"
                                >
                                  {{ shipment.uk_eta }}
                                </td>
                                 <td>
                                   <p
                                    class="
                                     badge badge-light-success badge-pill text-right ml-1">
                                  {{shipment.shipment_status}}

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
  name: "Index",
  props: ["events", "order_date"],
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
      container_number: '',
        expected_container_delivery_date: '',
        orderDate: "",
        shipments: [],
      warehouseContainers: [],
       delivery_type: '',
       delivery_date: '',
      orderDate: "",
      deliveryItems: [],
      container_no: "",
      deliverydate: "",
      container_ordered_at: "",
      return_at: "",
      orderDate: "",
      collections: [],
      orderDate: "",
      orderDate: [],
      orders: [],
      deliveries: [],
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
    handleDateClick: function (arg) {},

    handleEventClick(Info) {
      var StringCheck = Info.event.title.includes("Order");
      var stringcheck1 = Info.event.title.includes("Collection");
      var StringCheck2 = Info.event.title.includes("shipment");
      var StringCheck3 = Info.event.title.includes("Delivery");
      if (StringCheck) {
        axios
          .get("/fulfilment/search-order-events", {
            params: {
              order_date: Info.event.start,
            },
          })
          .then((response) => {
            this.orders = response.data;
            $("#modal").click();
          });
      }
      if (StringCheck3) {
        axios
          .get("/fulfilment/search-delivery-events", {
               params: {
               delivery_date: Info.event.start,
            },
          })
          .then((response) => {
            this.deliveryItems = response.data;
            $("#deliveryModal").click();
          });
      }
      if (stringcheck1) {
        axios
          .get("/fulfilment/search-collection-events", {
            params: {
              return_at: Info.event.start,
            },
          })
          .then((response) => {
            this.collections = response.data;
            $("#collectionModal").click();
          });
      }
      if (StringCheck2) {
        axios
         .get("/fulfilment/search-shipment-events", {
              params: {
                expected_container_delivery_date: Info.event.start,
              },
            })
            .then((response) => {
              this.shipments = response.data;
            $("#containerModal").click();
          });
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
      alert("Go");
      this.addingMode = true;
      const { id } = this.events.find((event) => event.id === +arg.event.id);
      this.indexToUpdate = id;
    },

    updateEvent() {},
  },
};
</script>

<style scoped>
:root {
  --fc-small-font-size: 0.85em;
  --fc-page-bg-color: rgb(194, 31, 31);
  --fc-neutral-bg-color: rgba(25, 146, 194, 0.3);
  --fc-neutral-text-color: #808080;
  --fc-border-color: #ddd;

  --fc-button-text-color: #fff;
  --fc-button-bg-color: #247ed8;
  --fc-button-border-color: #3c5166;
  --fc-button-hover-bg-color: #90a2b3;
  --fc-button-hover-border-color: #1a252f;
  --fc-button-active-bg-color: #1a252f;
  --fc-button-active-border-color: #151e27;

  --fc-event-bg-color: #37d83f;
  --fc-event-border-color: #d8375a;
  --fc-event-text-color: rgb(182, 57, 57);
  --fc-event-selected-overlay-color: rgba(0, 0, 0, 0.25);

  --fc-more-link-bg-color: #d0d0d0;
  --fc-more-link-text-color: inherit;

  --fc-event-resizer-thickness: 8px;
  --fc-event-resizer-dot-total-width: 8px;
  --fc-event-resizer-dot-border-width: 1px;

  --fc-non-business-color: rgba(215, 215, 215, 0.3);
  --fc-bg-event-color: rgb(143, 223, 130);
  --fc-bg-event-opacity: 0.3;
  --fc-highlight-color: rgba(188, 232, 241, 0.3);
  --fc-today-bg-color: rgba(255, 220, 40, 0.15);
  --fc-now-indicator-color: red;
}

.fc table {
  border-collapse: collapse;
  border-spacing: 0;
  font-size: 1em;
  background-color: lawngreen;
}
.fc .fc-col-header-cell-cushion {
  display: inline-block;
  padding: 100px 100px;
  background-color: lawngreen !important;
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
