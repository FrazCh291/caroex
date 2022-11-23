<template>
        <div class="container-fluid px-2 bg-white">
            <div class="flex flex-wrap">
                <div class="w-full">
                    <ul class="flex mb-0 list-none flex-wrap py-1 flex-row">
                        <li class="-mb-px mr-2 last:mr-0 mt-1 mb-1">
                            <a class="text-xs font-bold uppercase px-5 py-1 w-64 shadow-lg rounded  leading-normal"
                               v-bind:class="{'text-pink-600 bg-white': openTab !== 3, 'text-white bg-blue1': openTab === 3}"
                               v-on:click="toggleTabs(3, 'tuffnelsDeliveries')">
                                Ready ({{ tuffnellCount }})
                            </a>
                        </li>
                        <li  class="-mb-px mr-2 last:mr-0 mt-1 mb-1">
                            <a class="text-xs font-bold uppercase px-5 py-1 w-64  shadow-lg rounded  leading-normal"
                               v-bind:class="{'text-pink-600 bg-white': openTab !== 2, 'text-white bg-blue1': openTab === 2}"
                               v-on:click="toggleTabs(2, 'pending_delivery')">
                                Pending ({{ tuffnellPendingCount}})
                            </a>
                        </li>
                        <li class="-mb-px mr-2 last:mr-0 mt-1 mb-1">
                            <a class="text-xs font-bold uppercase px-5 py-1 w-44  shadow-lg rounded  leading-normal"
                               v-bind:class="{'text-pink-600 bg-white': openTab !== 4, 'text-white bg-blue1': openTab === 4}"
                               v-on:click="toggleTabs(4,'cancelled_delivery')">
                                Cancelled
                            </a>
                        </li>
                        <li class="-mb-px mr-2 last:mr-0 mt-1 mb-1">
                            <a class="text-xs font-bold uppercase px-5 py-1 w-44  shadow-lg rounded leading-normal"
                               v-bind:class="{'text-pink-600 bg-white': openTab !== 1, 'text-white bg-blue1': openTab === 1}"
                               v-on:click="toggleTabs(1,'ready_delivery')">
                                Tuffnells
                            </a>
                        </li>
                        <li class="-mb-px mr-2 last:mr-0 mt-1 mb-1">
                            <a class="text-xs font-bold uppercase px-5 py-1 w-44  shadow-lg rounded leading-normal text-truncate"
                               v-bind:class="{'text-pink-600 bg-white': openTab !== 6, 'text-white bg-blue1': openTab === 6}"
                               v-on:click="toggleTabs(6,'pickinglist')">
                                Picking List
                            </a>
                        </li>
                        <li class="-mb-px mr-2 last:mr-0 mt-1 mb-1">
                            <a class="text-xs font-bold uppercase px-5 py-1 w-44  shadow-lg rounded  leading-normal text-truncate"
                               v-bind:class="{'text-pink-600 bg-white': openTab !== 5, 'text-white bg-blue1': openTab === 5}"
                               v-on:click="toggleTabs(5,'inspection')">
                                Delivery Inspection
                            </a>
                        </li>
                    </ul>

                    <div class="relative  min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                        <div class="px-0 py-0 flex-auto bg-white">
                            <div class="tab-content tab-space bg-white">
                                <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                                    <div v-if="deliveries.ready?.data?.length>0" class="px-1">

                                        <div id="table-hover-row" class="row pb-1">
                                            <div class="col-12 pt-3">
                                                <div class="card">
                                                    <div class="card-content">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                        TUFFNELL TXT
                                                                    </th>
                                                                    <th class="text-right pl-1 py-0 my-0 text-truncate t-header"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="tuffnell in deliveries.ready?.data">

                                                                    <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                        {{

                                                                            (tuffnell.filename ? tuffnell.filename.slice(17)
                                                                                : '')

                                                                        }}
                                                                    </td>

                                                                    <td class="text-right text-small py-0 my-0 action pr-1">
                                                                        <button class="tufnells">
                                                                            <!-- manifest.view -->
                                                                            <a :href="route('delivery.show',tuffnell.id)">
                                                                                <span
                                                                                    class="badge-circle  badge-circle-light-secondary mr-1/4 ml-1/6 mt-1">
                                                                                    <i class="bx bx-show font-medium-1 text-center"></i>
                                                                                </span>
                                                                            </a>
                                                                        </button>
                                                                        <span
                                                                            class="d-inline-flex align-items-center action">
                                                                            <a :href="route('export.tuffnell.file',tuffnell.id)">
                                                                                  <span
                                                                                      class="badge-circle badge-circle-light-secondary  action mb-1 ">
                                                                                      <i class="bx bx-download font-medium-1 align-items-center text-center"></i>
                                                                                  </span>
                                                                            </a>

                                                                         </span>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <pagination :links="deliveries.ready?.links"
                                                            class="float-right"></pagination>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
                                    <div id="table-hover-row" class="row pb-1 pt-3 px-1">
                                        <div class="col-12">
                                            <div class="card ">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                    Customer
                                                                </th>
                                                                <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                    Order#
                                                                </th>
                                                                <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                    Product
                                                                </th>
                                                                <th class="pl-1 py-0 text-truncate t-header">
                                                                    Reason
                                                                </th>
                                                                <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                    Shipping Address
                                                                </th>
                                                                <th class="pl-1 py-0  text-center text-truncate t-header">
                                                                    Order Date
                                                                </th>
                                                                <th class="text-right pl-1 py-0 my-0 text-truncate t-header"></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody v-if="deliveries?.tuffnell_pending_orders?.data.length>0">
                                                            <tr v-for="tuffnell_pending_order in deliveries.tuffnell_pending_orders?.data">

                                                                <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                    <!--                                                                    {{-->
                                                                    <!--                                                                    tuffnell_pending_order.order.shipping_customer_name-->
                                                                    <!--                                                                    }}-->
                                                                </td>
                                                                <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                    <!--                                                                    {{-->
                                                                    <!--                                                                    tuffnell_pending_order.order.order_number-->
                                                                    <!--                                                                    }}-->
                                                                </td>
                                                                <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                    <!--       {{-->
                                                                    <!--       tuffnell_pending_order.order.product_name-->
                                                                    <!--       }}-->
                                                                </td>
                                                                <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                    {{
                                                                        tuffnell_pending_order.note
                                                                    }}
                                                                </td>
                                                                <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                    {{
                                                                        (tuffnell_pending_order.order ?
                                                                            tuffnell_pending_order.order.shipping_address_1 ?
                                                                                tuffnell_pending_order.order.shipping_address_1 : ''
                                                                            : '')
                                                                        +
                                                                        (tuffnell_pending_order.order ?
                                                                            tuffnell_pending_order.order.shipping_address_2 ?
                                                                                "," +
                                                                                tuffnell_pending_order.order.shipping_address_2 : ''
                                                                            : '')
                                                                        +
                                                                        (tuffnell_pending_order.order ?
                                                                            tuffnell_pending_order.order.shipping_address_town ?
                                                                                ", "
                                                                                + tuffnell_pending_order.order.shipping_address_town
                                                                                : ''
                                                                            : '') +
                                                                        (tuffnell_pending_order.order ?
                                                                            tuffnell_pending_order.order.shipping_address_postcode
                                                                                ?
                                                                                ", " +
                                                                                tuffnell_pending_order.order.shipping_address_postcode
                                                                                :
                                                                                '' : '') +
                                                                        (tuffnell_pending_order.order ?
                                                                            tuffnell_pending_order.order.shipping_country ?
                                                                                tuffnell_pending_order.order.shipping_country : '' :
                                                                            '')
                                                                    }}
                                                                </td>

                                                                <td class="small cursor-pointer text-center py-1 pl-1 text-truncate">
                                                                    {{
                                                                        tuffnell_pending_order.order ? formatDate(tuffnell_pending_order.order.order_date) : ''
                                                                    }}
                                                                </td>
                                                                <td class="text-right text-small py-0 my-0 action pr-1">
                                                                    <span
                                                                        class="d-inline-flex align-items-center action">
                                                                        <button data-target="#order-modal"
                                                                                data-toggle="modal"
                                                                                @click="changeStatus(tuffnell_pending_order.id)">
                                                                            <span
                                                                                class="badge-circle badge-circle-light-secondary ml-1/6">
                                                                                <i class="bx bx-edit font-medium-1 text-center"></i>
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
                                        <div class="col-12 ">
                                            <pagination :links="deliveries.tuffnell_pending_orders?.links"
                                                        class="float-right"></pagination>
                                        </div>
                                    </div>
                                </div>
                                <div v-bind:class="{'hidden': openTab !== 3, 'block': openTab === 3}">
                                    <div v-if="tuffnelDeliveryItems?.data?.length>0" class="px-1">
                                        <div class="px-1">
                                            <div class="pt-2 text-right">
                                                <inertia-link :href="route('tuffnell.file')" class="btn btn-primary"
                                                              data-repeater-create="">
                                                    Generate Txt
                                                </inertia-link>

                                            </div>
                                            <div class="col-12 px-0">
                                                <div class="col form-group p-0"></div>
                                            </div>
                                            <div id="table-hover-row" class="row pb-1">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                            Customer
                                                                        </th>
                                                                        <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                            Order#
                                                                        </th>
                                                                        <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                            Product
                                                                        </th>
                                                                        <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                            Shipping Address
                                                                        </th>
                                                                        <th class="pl-1 py-0  text-left text-truncate t-header">
                                                                            Shipping Email
                                                                        </th>
                                                                        <th class="pl-1 py-0  text-center text-truncate t-header">
                                                                            Order Date
                                                                        </th>
                                                                        <th class="text-right pl-1 py-0 my-0 text-truncate t-header">
                                                                            Action
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody v-if="tuffnelDeliveryItems?.data?.length>0">
                                                                    <tr v-for="deliveryItem in tuffnelDeliveryItems?.data">

                                                                        <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                            {{
                                                                                deliveryItem.order ? deliveryItem.order.shipping_customer_name : ''
                                                                            }}
                                                                        </td>
                                                                        <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                            {{
                                                                                deliveryItem.order ? deliveryItem.order.order_number : ''
                                                                            }}
                                                                        </td>
                                                                        <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                            {{
                                                                                deliveryItem.order ? deliveryItem.order.product_name : ''
                                                                            }}
                                                                        </td>
                                                                        <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                            {{
                                                                                (deliveryItem.order ?
                                                                                    deliveryItem.order.shipping_address_1 ?
                                                                                        deliveryItem.order.shipping_address_1 : '' : '')
                                                                                +
                                                                                (deliveryItem.order ?
                                                                                    deliveryItem.order.shipping_address_2 ? ", " +
                                                                                        deliveryItem.order.shipping_address_2 : '' : '')
                                                                                +
                                                                                (deliveryItem.order ?
                                                                                    deliveryItem.order.shipping_address_town ? ", "
                                                                                        + deliveryItem.order.shipping_address_town : ''
                                                                                    : '') +
                                                                                (deliveryItem.order ?
                                                                                    deliveryItem.order.shipping_address_postcode ?
                                                                                        ", " +
                                                                                        deliveryItem.order.shipping_address_postcode :
                                                                                        '' : '') +
                                                                                (deliveryItem.order ?
                                                                                    deliveryItem.order.shipping_country ?
                                                                                        deliveryItem.order.shipping_country : '' : '')
                                                                            }}
                                                                        </td>
                                                                        <td class="small cursor-pointer text-left px-1 py-1 my-0   text-truncate">
                                                                            {{
                                                                                deliveryItem.order ? deliveryItem.order.shipping_email : ''

                                                                            }}
                                                                        </td>
                                                                        <td class="small cursor-pointer text-center py-1 pl-1 text-truncate">
                                                                            {{
                                                                                formatDate(deliveryItem.order ? deliveryItem.order.order_date : '')

                                                                            }}
                                                                        </td>
                                                                        <td class="text-right text-small py-0 my-0 action pr-1">
                                                                            <div>
                                                                            <span
                                                                                class="d-inline-flex align-items-center action">
                                                                            <button data-target="#order-modal-ini"
                                                                                    data-toggle="modal"
                                                                                    @click="changeStatusIni(deliveryItem.id)">
                                                                                <span
                                                                                    class="badge-circle badge-circle-light-secondary ml-1/6">
                                                                                    <i class="bx bx-edit font-medium-1 text-center"></i>
                                                                                </span>
                                                                            </button>
                                                                         </span>
                                                                            </div>
                                                                        </td>
                                                                        <!--                                                                    <td class="text-right text-small py-0 my-0 action pr-1">-->
                                                                        <!--                                                                        <span-->
                                                                        <!--                                                                            class="d-inline-flex align-items-center action">-->
                                                                        <!--                                                                            <inertia :href="route('export.ready.file',deliveryItem.id)">-->
                                                                        <!--                                                                                            <span-->
                                                                        <!--                                                                                                                                                                  class="badge-circle badge-circle-light-secondary  action">-->
                                                                        <!--                                                                                                                                                                                <i class="bx bx-xs bx-upload font-medium-1 align-items-center text-center"></i>-->
                                                                        <!--                                                                                                                                                              </span>-->
                                                                        <!--                                                                                                                                                        </inertia>-->

                                                                        <!--                                                                                                                                                        <a :href="route('export.ready.file',deliveryItem.id)">-->
                                                                        <!--                                                                                                                                                              <span class="badge-circle badge-circle-light-secondary  action">-->
                                                                        <!--                                                                                                                                                                                <i class="bx bx-xs bx-upload font-medium-1 align-items-center text-center"></i>-->
                                                                        <!--                                                                                                                                                              </span>-->
                                                                        <!--                                                                                                                                                        </a>-->

                                                                        <!--                                                                                                                                                            <button v-on:click="confirmDelete(deliveryItem.id)">-->
                                                                        <!--                                                                                                                                                                <span class="badge-circle badge-circle-light-secondary ml-1/6">-->
                                                                        <!--                                                                                                                                                                    <i class="bx bxs-send font-medium-1 text-center"></i>-->
                                                                        <!--                                                                                                                                                                </span>-->
                                                                        <!--                                                                                                                                                            </button>-->
                                                                        <!--                                                                         </span>-->
                                                                        <!--                                                                    </td>-->
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 ">
                                                    <pagination :links="tuffnelDeliveryItems?.links"
                                                                class="float-right"></pagination>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="row pt-1 pl-3">
                                        <p>Seems you do not have any ready file to send tuffnell.</p>
                                    </div>
                                </div>

                                <div v-bind:class="{'hidden': openTab !== 4, 'block': openTab === 4}">
                                    <div v-if="deliveries?.tuffnell_cancelled_orders?.data?.length>0" class="px-1">
                                        <div class="col-12 px-0">
                                            <div class="col form-group p-0"></div>
                                        </div>
                                        <div id="table-hover-row" class="row pb-1 pt-3 px-1">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-content">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                        Customer
                                                                    </th>

                                                                    <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                        Order#
                                                                    </th>

                                                                    <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                        Product
                                                                    </th>
                                                                    <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                        Shipping Address
                                                                    </th>
                                                                    <th class="pl-1 py-0  text-left text-truncate t-header">
                                                                        Shipping Email
                                                                    </th>
                                                                    <th class="pl-1 py-0  text-center text-truncate t-header">
                                                                        Order Date
                                                                    </th>
                                                                    <th class="text-right pl-1 py-0 my-0 text-truncate t-header"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="deliveryItem in deliveries.tuffnell_cancelled_orders?.data">

                                                                    <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                        {{
                                                                            deliveryItem.order.shipping_customer_name ? deliveryItem.order.shipping_customer_name : ''
                                                                        }}
                                                                    </td>
                                                                    <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                        {{
                                                                            deliveryItem.order ? deliveryItem.order.order_number : ''
                                                                        }}
                                                                    </td>
                                                                    <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                        {{
                                                                            deliveryItem.order ? deliveryItem.order.product_name : ''
                                                                        }}
                                                                    </td>
                                                                    <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                        {{
                                                                            (deliveryItem.order ?
                                                                                deliveryItem.order.shipping_address_1 ?
                                                                                    deliveryItem.order.shipping_address_1 : '' : '')
                                                                            +
                                                                            (deliveryItem.order ?
                                                                                deliveryItem.order.shipping_address_2 ? ", " +
                                                                                    deliveryItem.order.shipping_address_2 : '' : '')
                                                                            +
                                                                            (deliveryItem.order ?
                                                                                deliveryItem.order.shipping_address_town ? ", "
                                                                                    + deliveryItem.order.shipping_address_town : ''
                                                                                : '') +
                                                                            (deliveryItem.order ?
                                                                                deliveryItem.order.shipping_address_postcode ?
                                                                                    ", " +
                                                                                    deliveryItem.order.shipping_address_postcode :
                                                                                    '' : '') +
                                                                            (deliveryItem.order ?
                                                                                deliveryItem.order.shipping_country ?
                                                                                    deliveryItem.order.shipping_country : '' : '')
                                                                        }}
                                                                    </td>
                                                                    <td class="small cursor-pointer text-left px-1 py-1 my-0   text-truncate">
                                                                        {{
                                                                            deliveryItem.order ? deliveryItem.order.shipping_email : ''
                                                                        }}
                                                                    </td>
                                                                    <td class="small cursor-pointer text-center py-1 pl-1 text-truncate">
                                                                        {{
                                                                            deliveryItem.order ? formatDate(deliveryItem.order.order_date) : ''
                                                                        }}
                                                                    </td>
                                                                    <td class="text-right text-small py-0 my-0 action pr-1">
                                                                        <span
                                                                            class="d-inline-flex align-items-center action">
<!--                                                                            <inertia-->
                                                                            <!--                                                                                :href="route('export.ready.file',deliveryItem.id)">-->
                                                                            <!--                                                                                  <span-->
                                                                            <!--                                                                                      class="badge-circle badge-circle-light-secondary  action">-->
                                                                            <!--                                                                                                    <i class="bx bx-xs bx-upload font-medium-1 align-items-center text-center"></i>-->
                                                                            <!--                                                                                  </span>-->
                                                                            <!--                                                                            </inertia>-->

                                                                            <!--                                                                            <a :href="route('export.ready.file',deliveryItem.id)">-->
                                                                            <!--                                                                                  <span class="badge-circle badge-circle-light-secondary  action">-->
                                                                            <!--                                                                                                    <i class="bx bx-xs bx-upload font-medium-1 align-items-center text-center"></i>-->
                                                                            <!--                                                                                  </span>-->
                                                                            <!--                                                                            </a>-->

                                                                            <!--                                                                                <button v-on:click="confirmDelete(deliveryItem.id)">-->
                                                                            <!--                                                                                    <span class="badge-circle badge-circle-light-secondary ml-1/6">-->
                                                                            <!--                                                                                        <i class="bx bxs-send font-medium-1 text-center"></i>-->
                                                                            <!--                                                                                    </span>-->
                                                                            <!--                                                                                </button>-->
                                                                         </span>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <pagination :links="deliveries.tuffnell_cancelled_orders?.links"
                                                            class="float-right"></pagination>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="row pt-1 pl-3">
                                        <p>Seems you do not have any Cancelled Delivery.</p>
                                    </div>
                                </div>

                                <div v-bind:class="{'hidden': openTab !== 5, 'block': openTab === 5}">
                                    <div id="table-hover-row" class="row pb-1 pt-3 px-1">
                                        <div class="col-12">
                                            <div class="card ">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="pl-1 px-2 py-0 my-0 text-truncate t-header">
                                                                    Date
                                                                </th>
                                                                <th class="pl-2  py-0 my-0 text-center text-truncate t-header">
                                                                    Method
                                                                </th>
                                                                <th class="pl-2 text-center py-0 my-0 text-truncate t-header">
                                                                    Consignment
                                                                </th>
                                                                <th class="pl-1 py-0  text-center text-truncate t-header">
                                                                    Packages
                                                                </th>
                                                                <th class="text-center pl-1 py-0 my-0 text-truncate t-header">
                                                                    Weight(Kg)
                                                                </th>
                                                                <th class="text-center ml-2 text-truncate t-header">
                                                                    Collected
                                                                </th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            <tr v-for="inspection in inspections?.data">
                                                                <td class=" px-2 py-1 my-0 text-truncate">
                                                                    {{ inspection.date }}
                                                                </td>
                                                                <td class="text-center  px-2 py-0 my-0 text-truncate">
                                                                    {{
                                                                        inspection.delivery_items?.length > 0 ? inspection.delivery_items[0].delivery_method : ''
                                                                    }}
                                                                </td>
                                                                <td class=" text-center py-0 my-0">
                                                                    {{ inspection.No_items }}
                                                                </td>

                                                                <td class="small cursor-pointer text-center py-1 pl-1 text-truncate">
                                                                    {{ inspection.No_items }}
                                                                </td>
                                                                <td class="small cursor-pointer text-center py-1 pl-1 text-truncate">
                                                                    {{ inspection.weight }}
                                                                </td>
                                                                <td class="px-2 text-left text-truncate">
                                                                    <div
                                                                        v-if="!inspection.delivery_items.some(item => item.is_collected === false)"
                                                                        class="d-flex align-items-center">
                                                                        <div>
                                                                        </div>
                                                                        <div>
                                                                            <span
                                                                                class="badge badge-pill badge-success">Collected</span>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        v-else-if="!inspection.delivery_items.some(item => item.is_collected ===true)"
                                                                        class="d-flex align-items-center">
                                                                        <div>
                                                                        </div>
                                                                        <div>
                                                                            <span class="badge badge-pill badge-danger">Not Collected</span>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        v-else-if="inspection.delivery_items.some(item => item.is_collected === false) && inspection.delivery_items.some(item => item.is_collected ===true) "
                                                                        class="d-flex align-items-center">
                                                                        <div>
                                                                        </div>
                                                                        <div>
                                                                            <span
                                                                                class="badge badge-pill badge-warning">Partially Collected</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-right text-small py-0 my-0 action pr-1">
                                                                        <span
                                                                            class="d-inline-flex align-items-center action">
                                                                            <button>
                                                                                <a :href="route('delivery.inspection' ,inspection.id)">
                                                                                <span
                                                                                    class="badge-circle badge-circle-light-secondary mr-1/4 ml-1/6">
                                                                                    <i class="bx bx-edit font-medium-1 text-center"></i>
                                                                                </span>
                                                                                </a>
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
                                    </div>
                                </div>
                                <div v-bind:class="{'hidden': openTab !== 6, 'block': openTab === 6}">
                                    <div id="table-hover-row" class="row pb-1 pt-3 px-1">
                                        <div class="col-12">
                                            <div class="card ">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="pl-1 px-2 py-0 my-0 text-truncate t-header">
                                                                    Date
                                                                </th>
                                                                <th class="pl-1 mb-1 py-0 my-0 text-center text-truncate t-header">
                                                                    Items
                                                                </th>
                                                                <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                </th>
                                                                <th class="py-0 text-center text-truncate t-header">
                                                                </th>
                                                                <th class="text-right pl-1 py-0 my-0 text-truncate t-header"></th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            <tr v-for="pickingList in pickingLists?.data">

                                                                <td class="px-2 py-1 my-0 text-truncate">
                                                                    {{ pickingList.date }}
                                                                </td>
                                                                <td class="text-center py-0 my-0 text-truncate">
                                                                    {{ pickingList.No_items }}
                                                                </td>
                                                                <td class=" px-2 py-0 my-0"></td>
                                                                <td class="small cursor-pointer text-center py-1 pl-1 text-truncate">
                                                                </td>
                                                                <td class="text-right text-small py-0 my-0 action pr-1">
                                                                        <span
                                                                            class="d-inline-flex align-items-center action">
                                                                            <button>
                                                                                <a :href="route('picking.list' , pickingList.id)">
                                                                                <span
                                                                                    class="badge-circle badge-circle-light-secondary mr-1/4 ml-1/6">
                                                                                    <i class="bx bx-show font-medium-1 text-center"></i>
                                                                                </span>
                                                                                </a>
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
                                        <div class="col-12 ">
                                            <pagination :links="pickingLists?.links" class="float-right"></pagination>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div id="order-modal"
             aria-hidden="true" aria-labelledby="myModalLabel33"
             class="modal fade text-left"
             role="dialog"
             tabindex="-1">
            <div
                class="modal-dialog modal-dialog-centered"
                role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="myModalLabel33"
                            class="modal-title font-weight-bold text-center">
                            Update Order Status</h4>
                        <button aria-label="Close"
                                class="close"
                                data-dismiss="modal"
                                type="button">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form class="form form-horizontal"
                          @submit.prevent="submit">
                        <div class="modal-body">

                            <label class="">Status Update</label>
                            <div class="form-group">
                                <select id="status"
                                        v-model="form.status"
                                        class="form-control">
                                    <option></option>
                                    <option value="processing">Processing</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button id="modal-hide"
                                    class="btn btn-light-secondary"
                                    data-dismiss="modal"
                                    type="button">
                                <i ref="closeModall"
                                   class="bx bx-x d-block d-sm-none"></i>
                                <span
                                    class="d-none d-sm-block">Close</span>
                            </button>
                            <button class="btn btn-primary ml-1"
                                    data-dismiss="modal"
                                    type="submit"
                                    @click="stopPropagation">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span
                                    class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="order-modal-ini"
             aria-hidden="true" aria-labelledby="myModalLabel124"
             class="modal fade text-left"
             role="dialog"
             tabindex="-1">
            <div
                class="modal-dialog modal-dialog-centered"
                role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="myModalLabel124"
                            class="modal-title font-weight-bold text-center">
                            Update Order Status </h4>
                        <button aria-label="Close"
                                class="close"
                                data-dismiss="modal"
                                type="button">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form class="form form-horizontal"
                          @submit.prevent="formSubmit">
                        <div class="modal-body">
                            <label class="">Status Update</label>
                            <div class="form-group">
                                <select id="deliveryStatus"
                                        v-model="form1.order_status"
                                        class="form-control">
                                    <option></option>
                                    <option value="pending">Pending</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button id="deliveryModal"
                                    class="btn btn-light-secondary"
                                    data-dismiss="modal"
                                    type="button">
                                <i ref="closeModall"
                                   class="bx bx-x d-block d-sm-none"></i>
                                <span
                                    class="d-none d-sm-block">Close</span>
                            </button>
                            <button class="btn btn-primary ml-1"
                                    data-dismiss="modal"
                                    type="submit"
                                    @click="stopPropagation">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span
                                    class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</template>

<script>

import moment from 'moment';
import Button from "../../Jetstream/Button";
import AdminLayout from "../../Layouts/AdminLayout";
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {
    name: "Index",
    props: ['tuffnelDeliveryItems','tabopen' ,'sparePartDeliveries', 'sparePartCount', 'tuffnellPendingCount', 'deliveries', 'tuffnellCount', 'pickingLists', 'inspections'],
    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
    },
    layout:AdminLayout,

    data() {
        return {
            form: this.$inertia.form({
                status: ''
            }),
            form1: this.$inertia.form({
                order_status: '',
            }),
            showMenu: true,
            openTab: '',
            orderID: '',
            deliveryOrderID: ''
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Deliveries"
        if (this.tabopen) {
            this.openTab = this.tabopen;
        }
        console.log(this.deliveries)
    },

    watch: {},
    methods: {
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        // checkId()
        // {
        //     inspect
        // },
        changeStatusIni(id) {
            this.deliveryOrderID = id;
        },
        changeStatus(id) {
            this.orderID = id;
        },
        formSubmit() {
            this.deliveryItem = this.tuffnelDeliveryItems?.find(deliveryItem => deliveryItem.id === this.deliveryOrderID);

            let data = this.deliveryItem;
            console.log(Object.assign(data, {
                '_method': 'PUT',
                'status': this.form1.order_status,
            }));
            this.form1 = this.$inertia.form(data);

            this.form1.post(route('deliveries.update', this.deliveryOrderID),
                {
                    onSuccess: () => {
                        $('#deliveryModal').trigger('click');
                        this.form1 = this.$inertia.form({
                            order_status: '',
                        });
                    },
                });
        },

        submit() {
            this.order = this.deliveries.tuffnell_pending_orders.data.find(order => order.id === this.orderID);

            let data = this.order;
            Object.assign(data, {
                '_method': 'PUT',
                'status': this.form.status,

            });
            this.form = this.$inertia.form(data);
            this.form.post(route('deliveries.update', this.orderID),
                {
                    onSuccess: () => {
                        $('#modal-hide').trigger('click');
                        this.form = this.$inertia.form({
                            status: '',

                        });
                    },
                });
        },
        confirmDelete(id) {
            this.$inertia.get('export/ready/file/' + id)
        },
        toggleTabs: function (tabNumber, tabType) {
            this.openTab = tabNumber
            this.loadData(tabType)
        },
        stopPropagation(e) {
            e.stopPropagation();
        },
        loadData(tabType) {
            let query = {};
            query.type = '';
            query.type = tabType;
            // if (!query.type) {
            //     if (this.openTab === 2) {
            //         query.type = 'type_spare_part'
            //     } else {
            //         query.type = 'type_product'
            //     }
            // }
            this.$inertia.visit(route('deliveries.index'), {
                method: 'get',
                data: {
                    ...query
                }
            })
        },

    }
}
</script>
<style scoped>
.bg-blue1 {
    background-color: #5A8DEE !important;
}

.t-header {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

.action {
    margin-right: 4px !important;
    padding-top: 4px !important;
    padding-bottom: 4px !important;
}

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.tufnells {
    /* margin-top: 0px; */
    margin-bottom: 14px;
    margin-right: 8px;
    /* margin-bottom: 0px; */

}
</style>
