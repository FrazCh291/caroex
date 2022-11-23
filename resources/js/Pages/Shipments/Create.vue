<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-sm-12 col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="shipment">Edit Shipment</h4>
                                <h4 class="card-title" v-else>Add Shipment </h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-horizontal" @submit.prevent="submit">
                                        <div class="form-body">
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Purchase Order *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <select class="form-select" v-model="form.purchase_order_id"
                                                            name="purchase_order_id" required>
                                                        <option value="">select</option>
                                                        <option v-for="purchaseOrder in purchaseOrders"
                                                                :value="purchaseOrder.id">{{
                                                                purchaseOrder.purchase_order_number
                                                            }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="purchase_order_id"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Departure Port *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="text" id="departure_port" v-model="form.departure_port"
                                                           class="form-control" name="departure_port">
                                                    <ErrorComponent input="departure_port"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                    <label>Supplier *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <select class="form-select" v-model="form.supplier_id"
                                                            name="supplier_id" required>
                                                        <option value="">select</option>
                                                        <option v-for="supplier in suppliers" :value="supplier.id">{{
                                                                supplier.name
                                                            }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="supplier_id"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Shipping Line *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="text" id="shipping_line" v-model="form.shipping_line"
                                                           class="form-control" name="shipping_line">
                                                    <ErrorComponent input="shipping_line"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                    <label>Shipping Agent *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <select class="form-select" v-model="form.shipment_agent"
                                                            name="shipment_agent" required>
                                                        <option value="">select</option>
                                                        <option v-for="shipmentAgent in shipment_agent"
                                                                :value="shipmentAgent.value">{{
                                                                shipmentAgent.value
                                                            }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="shipmentAgent"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Booking Number *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="text" id="booking_number" v-model="form.booking_number"
                                                           class="form-control" name="booking_number">
                                                    <ErrorComponent input="booking_number"></ErrorComponent>
                                                </div>

                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                    <label>Freight Forwarder Sender *</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-select"
                                                            v-model="form.supplier_freight_forwarder_id"
                                                            name="freight_forwarder_id">
                                                        <option value="">select</option>
                                                        <option v-for="freightSender in freightSenders"
                                                                :value="freightSender.id">{{ freightSender.name }}
                                                        </option>
                                                    </select>
                                             
                                                    <ErrorComponent input="supplier_freight_forwarder_id"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Container Number *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="text" id="container_number"
                                                           v-model="form.container_number" class="form-control"
                                                           name="container_number">
                                                    <ErrorComponent input="container_number"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Bill Of Lading# *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="text" id="bill_of_lading_number"
                                                           v-model="form.bill_of_lading_number" class="form-control"
                                                           name="bill_of_lading_number">
                                                    <ErrorComponent input="bill_of_lading_number"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Container Seal Number *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="text" id="container_seal_number"
                                                           v-model="form.container_seal_number" class="form-control"
                                                           name="container_seal_number">
                                                    <ErrorComponent input="container_seal_number"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Load Date *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="date" id="load_date" v-model="form.load_date"
                                                           class="form-control" name="load_date">
                                                    <ErrorComponent input="load_date"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Vessel Etd *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="date" id="vessel_etd" v-model="form.vessel_etd"
                                                           class="form-control" name="vessel_etd">
                                                    <ErrorComponent input="vessel_etd"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Expected Delivery Date *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="date" id="expected_container_delivery_date"
                                                           v-model="form.expected_container_delivery_date"
                                                           class="form-control" name="expected_container_delivery_date">
                                                    <ErrorComponent
                                                        input="expected_container_delivery_date"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Uk Eta </label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="date" id="uk_eta" v-model="form.uk_eta"
                                                           class="form-control" name="uk_eta">
                                                    <ErrorComponent input="uk_eta"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Shipped Date *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="date" id="shipment_date" v-model="form.shipment_date"
                                                           class="form-control" name="shipment_date">
                                                    <ErrorComponent input="shipment_date"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>
                                             <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Actual Arrival Date *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="date" id="actual_arrival_date" v-model="form.actual_arrival_date"
                                                           class="form-control" name="actual_arrival_date">
                                                    <ErrorComponent input="actual_arrival_date"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Delivery warehouse *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <select class="form-select" v-model="form.warehouse_id"
                                                            name="warehouse_id">
                                                        <option></option>
                                                        <option v-for="warehouse in warehouses" :key="warehouse.id" :value="warehouse.id">{{
                                                                warehouse.name
                                                            }}
                                                        </option>s
                                                    </select>
                                                    <ErrorComponent input="warehouse_id"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Freight Forwarder Receiver *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <select class="form-select"
                                                            v-model="form.purchaser_freight_forwarder_id"
                                                            name="freight_forwarder_id">
                                                        <option value="">select</option>
                                                        <option v-for="freightReceiver in freightReceivers"
                                                                :value="freightReceiver.id">{{ freightReceiver.name }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="purchaser_freight_forwarder_id"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row form-group pb-0 mb-0 py-0 my-0">
                                                <div class="col-lg-11 col-md-11 col-sm-11 pb-0 pt-1 my-0">
                                                    <label>Shipment Item *</label>
                                                </div>
                                                <div class="col-lg-1 col-sm-1 col-md-1 pb-0 form-group py-0 my-0 px-0">
                                                    <div class="col form-group pr-0 pb-0.5">
                                                        <span class="d-inline-flex align-items-center">
                                                            <span class="d-inline-flex align-items-center"
                                                                  data-target="#addItem" data-toggle="modal"
                                                                  @click="addShipmentItem()">
                                                                <span
                                                                    class="badge-circle badge-circle-light-secondary bg-white">
                                                                    <i class="bx bxs-plus-circle pt-0 primary float-right add-btn font-large-1"></i>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div v-if="shipmentItems.length>0" class="row py-0 my-0">
                                                <div id="table-hover-row" class="row col-12 pr-0 ng-repeat-start">
                                                    <div class="col-12 pr-0">
                                                        <div class="card pr-0 pb-0 mb-1">
                                                            <div class="card-content">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover truncate mb-0">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="text-left custom-padding">
                                                                                Product
                                                                            </th>
                                                                            <th class="">Price</th>
                                                                            <th class="">Qty</th>
                                                                            <th class="">Total</th>
                                                                            <th
                                                                                class="text-right custom-padding-right">
                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr v-for="shipmentItem in this.shipmentItems"
                                                                            class="py-0 my-0">
                                                                            <td class="">{{
                                                                                    shipmentItem.product ? shipmentItem.product.id
                                                                                        == shipmentItem.product_id ?
                                                                                            shipmentItem.product.name
                                                                                            : shipmentItem.product_name :
                                                                                        shipmentItem.product_name
                                                                                }}
                                                                            </td>
                                                                            <td class="">{{
                                                                                    shipmentItem.unit_price
                                                                                }}
                                                                            </td>
                                                                            <td class="">{{
                                                                                    shipmentItem.quantity_ordered
                                                                                }}
                                                                            </td>
                                                                            <td class="">{{
                                                                                    shipmentItem.total_price
                                                                                }}
                                                                            </td>
                                                                            <td class="text-right">
                                                                       <div class="dropdown">
                                                                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                        </span>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" data-target="#addItem" data-toggle="modal" v-on:click="editShipmentItem(shipmentItem.id)"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                                        <a class="dropdown-item" v-on:click="deleteShipmentItem(shipmentItem.id)"><i class="bx bx-trash mr-1"></i> delete</a>
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
                                                    <div class="col-12"></div>
                                                </div>
                                            </div>
                                            <!-- 2nd -->
                                            <div class="row form-group pb-0 mb-0 py-0 my-0">
                                                <div class="col-lg-11 col-sm-11 col-md-11 pb-0 pt-1 my-0">
                                                    <label>Document *</label>
                                                </div>
                                                <div class="col-lg-1 col-sm-1 col-md-1 pb-0 form-group py-0 my-0 px-0">
                                                    <div class=" col form-group pr-0 pb-0.5">
                                                        <span class="d-inline-flex align-items-right">
                                                            <span class="d-inline-flex align-items-right"
                                                                  data-target="#addDocs" data-toggle="modal"
                                                                  @click="addShipmentDocs()">
                                                                <span
                                                                    class="badge-circle badge-circle-light-secondary bg-white">
                                                                    <i
                                                                        class="bx bxs-plus-circle pt-0 primary float-right add-btn font-large-1"></i>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="shipmentDocs.length>0" class="row py-0 my-0">
                                                <div id="table-hover-rows" class="row col-12 pr-0 ng-repeat-start">
                                                    <div class="col-12 pr-0">
                                                        <div class="card pr-0 pb-0 mb-1">
                                                            <div class="card-content">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover truncate mb-0">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Title</th>
                                                                            <th class="text-center">File</th>
                                                                            <th class="text-right">Description</th>
                                                                            <th class="text-right"></th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr v-for="shipmentDoc in this.shipmentDocs"
                                                                            class="py-0 my-0">
                                                                            <td>{{ shipmentDoc.title }}
                                                                            </td>
                                                                            <td class="text-center">{{
                                                                                    shipmentDoc.file
                                                                                }}
                                                                            </td>
                                                                            <td class="text-right">{{
                                                                                    shipmentDoc.description
                                                                                }}
                                                                            </td>
                                                                            <td class="text-right">

                                                                                <div class="dropdown">
                                                                                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                                        </span>
                                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                                        <a class="dropdown-item" v-on:click="editShipmentDocs(shipmentDoc.id)" data-toggle="modal"  data-target="#addDocs"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                                                        <a class="dropdown-item" v-on:click="deleteShipmentDoc(shipmentDoc.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                                    <div class="col-12"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button class="btn btn-primary mr-1 mb-1" type="submit"
                                                        v-if="shipmentItems.length>0">
                                                    Save
                                                </button>
                                                <button class="btn btn-primary mr-1 mb-1" type="submit" v-else disabled>
                                                    Save
                                                </button>
                                                <inertia-link :href="route('shipments.index')"
                                                              class="btn btn-light-secondary mr-1 mb-1" type="button">
                                                    Back
                                                </inertia-link>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="addItem" aria-hidden="true" aria-labelledby="myModalLabel33"
                                         class="modal fade text-left" role="dialog" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                             role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 id="myModalLabel33" class="modal-title font-weight-bold">
                                                        Add Shipment Item </h4>
                                                    <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <form class="form form-horizontal">
                                                    <div class="modal-body mb-1">
                                                        <div class="form-group py-0 my-0">
                                                            <label>Product</label>
                                                            <select class="form-select" v-model="form1.product_id"
                                                                    name="purchase_order_id" required>
                                                                <option value="">select</option>
                                                                <option v-for="product in products" :value="product.id">
                                                                    {{
                                                                        product.name
                                                                    }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group py-0 my-0 pt-1">
                                                            <label>Unit Price *</label>
                                                            <input type="number" id="unit_price"
                                                                   v-model="form1.unit_price"
                                                                   class="form-control" name="unit_price" min="1"
                                                                   max="15"
                                                                   @change="Amount()" required>
                                                        </div>
                                                        <div class="form-group py-0 my-0 pt-1">
                                                            <label>Quantity *</label>
                                                            <input id="quantity_ordered"
                                                                   v-model="form1.quantity_ordered" class="form-control"
                                                                   name="quantity_ordered"
                                                                   type="number" min="1" max="5"
                                                                   @change="totalAmount()" required>
                                                        </div>
                                                        <div class="form-group py-0 my-0 pt-1">
                                                            <label>Total *</label>
                                                            <input id="total_price" v-model="form1.total_price"
                                                                   class="form-control" readonly name="total_price"
                                                                   type="text" required/>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="modal-hide" class="btn btn-light-secondary"
                                                                data-dismiss="modal" type="button">
                                                            <i ref="closeModall" class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <button class="btn btn-primary ml-1" data-dismiss="modal"
                                                                type="shipmentItemnew" @click="shipmentItemnew(form1.id)">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Add</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="addDocs" aria-hidden="true" aria-labelledby="myModalLabel22"
                                         class="modal fade text-left" role="dialog" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                             role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 id="myModalLabel22" class="modal-title font-weight-bold">
                                                        Add Document </h4>
                                                    <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <form class="form form-horizontal">
                                                    <div class="modal-body mb-1">
                                                        <li v-for="error in errors" class="error mt-1">{{ error }}</li>
                                                        <div class="form-group py-0 my-0">
                                                            <label>Title *</label>
                                                            <input id="title" v-model="form2.title" class="form-control"
                                                                   name="title" type="text" required>
                                                        </div>
                                                        <div class="form-group py-0 my-0 pt-1">
                                                            <label>File *</label>
                                                            <div class="custom-file">
                                                                <input id="file" class="custom-file-input" multiple
                                                                       name="file" type="file"
                                                                       @input="form2.file = $event.target.files" required/>
                                                                <label class="custom-file-label" for="file">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group py-0 my-0 pt-1">
                                                            <label>Description</label>
                                                            <textarea id="description" v-model="form2.description"
                                                                      class="form-control" name="description"
                                                                      rows="2"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="modal-hides" class="btn btn-light-secondary"
                                                                data-dismiss="modal" type="button">
                                                            <i ref="closeModall" class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <button class="btn btn-primary ml-1" data-dismiss="modal"
                                                                type="button" @click="docnew(form2.id)">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Add</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </admin-layout>
</template>

<script>
import moment from 'moment';
import AdminLayout from "../../Layouts/AdminLayout";
import Label from "../../Jetstream/Label";
import JetInputError from './../../Jetstream/InputError'
import {useForm} from '@inertiajs/inertia-vue3'
import ErrorComponent from '../../components/ErrorComponent'
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {
    name: "Create",
    props: ['suppliers', 'companyId', 'errors', 'shipment', 'companies', 'freightSenders', 'freightReceivers', 'parentId', 'warehouses', 'purchaseOrders', 'products', 'documents', 'shipmentItem', 'shipment_agent'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ConfirmatiomModal,
        ErrorComponent,
    },

    setup() {
        const form = useForm({
            purchase_order_id: '',
            departure_port: '',
            supplier_id: '',
            shipping_line: '',
            booking_number: '',
            purchaser_freight_forwarder_id: '',
            supplier_freight_forwarder_id: '',
            container_number: '',
            bill_of_lading_number: '',
            container_seal_number: '',
            vessel_etd: '',
            uk_eta: '',
            expected_container_delivery_date: '',
            load_date: '',
            shipment_date: '',
            actual_arrival_date:'',
            warehouse_id: '',
            product_id: '',
            unit_price: '',
            quantity_ordered: '',
            total_price: '',
            title: '',
            file: '',
            description: '',
            shipmentItems: [],
            shipmentDocs: [],
            shipment_agent: ''
        })
        return {form}
    },
    data() {
        return {
            form1: this.$inertia.form({
                id: '',
                product_id: '',
                unit_price: '',
                quantity_ordered: '',
                total_price: '',
            }),
            form2: this.$inertia.form({
                id: '',
                documentable_id: '',
                title: '',
                files: '',
                file: '',
                description: ''
            }),
            files: [],
            errors: [],
            conversion_rate: false,
            shipmentItems: this.shipmentItem ? this.shipmentItem : [],
            shipmentDocs: this.documents ? this.documents : [],
        }

    },

    beforeMount() {
        console.log(this.shipment,'shipment');
        document.title = process.env.MIX_APP_NAME + " - Create Shipment";
        this.form.ShipmentItems = this.shipmentinvoiceItem
        this.form.shipmentDocs = this.documents
        if (this.shipment) {
            this.update = true;
            let data = this.shipment;
            Object.assign(data, {
                'shipmentItems': [],
                'shipmentDocs': [],
                '_method': 'PUT',
            })
            data.vessel_etd = data.vessel_etd ? moment(data.vessel_etd).format('YYYY-MM-DD') : null;
            data.uk_eta = data.uk_eta ? moment(data.uk_eta).format('YYYY-MM-DD') : null;
            data.warehouse_id = this.shipment.warehouse ? this.shipment.warehouse_id : '';
            this.form = this.$inertia.form(data);
            console.log(this.form, 'form')
        }
    },
    methods: {
        submit() {
            if (this.update) {
                console.log(this.form.warehouse_id, 'test');
                this.form.shipmentItems = this.shipmentItem
                this.form.shipmentDocs = this.shipmentDocs
                this.form.warehouse_id = this.form.warehouse_id

                this.form.post(route('shipments.update', this.shipment.id))
            } else {
                this.form.shipmentItems = this.shipmentItems
                this.form.shipmentDocs = this.shipmentDocs
                this.form.post('/erp/shipments')
            }
        },

        shipmentItemnew(id) {
            var product_name = this.products.find(product => product.id == this.form1.product_id);
            if (!this.form1.product_id) {
                event.stopPropagation();
            } else if (!this.form1.unit_price) {
                event.stopPropagation();
            } else if (!this.form1.quantity_ordered) {
                event.stopPropagation();
            } else if (!this.form1.total_price) {
                event.stopPropagation();
            } else {
                if (id) {
                    let index = 0;
                    this.shipmentItems.find((shipmentItem, ind) => {
                            index = ind;
                            return shipmentItem.id === id
                        }
                    );
                    this.shipmentItems[index].product_id = this.form1.product_id;
                    this.shipmentItems[index].product_name = product_name.name;
                    this.shipmentItems[index].unit_price = this.form1.unit_price;
                    this.shipmentItems[index].quantity_ordered = this.form1.quantity_ordered;
                    this.shipmentItems[index].total_price = this.form1.total_price;

                } else {
                    let obj = {};
                    obj.id = this.form1.product_id
                    obj.product_id = this.form1.product_id;
                    obj.product_name = product_name.name;
                    obj.unit_price = this.form1.unit_price;
                    obj.quantity_ordered = this.form1.quantity_ordered;
                    obj.total_price = this.form1.total_price;
                    this.shipmentItems.push(obj);
                }
            }
        },

        docnew(id) {
              this.errors = [];
            if (!this.form2.title) {
                  this.errors.push('Title Required');
                event.stopPropagation();
            } else if (!this.form2.file) {
                this.errors.push('File Required');
                event.stopPropagation();
            } else {
                if (id) {
                    let shipmentDocs = this.shipmentDocs.find(shipmentDoc => shipmentDoc.id == id);
                    let file = {};
                    file = this.form2.file
                    this.files = file
                    shipmentDocs.title = this.form2.title;
                    shipmentDocs.files = this.files ? this.files : shipmentDocs.files;
                    shipmentDocs.file = this.files ? this.files : shipmentDocs.files;
                    shipmentDocs.description = this.form2.description;
                } else {
                    let doc = {};
                    let file = {};
                    doc.id = Math.random().toString(36).substr(2, 9)
                    doc.title = this.form2.title
                    file = this.form2.file
                    this.files = file
                    doc.files = this.files
                    doc.file = this.files[0].name
                    doc.description = this.form2.description
                    this.shipmentDocs.push(doc)
                }
            }
        },

        totalAmount() {
            this.form1.total_price = parseFloat(this.form1.unit_price) * parseInt(this.form1.quantity_ordered)
        },

        Amount() {
            if (this.form1.quantity_ordered) {
                this.form1.total_price = this.form1.unit_price * this.form1.quantity_ordered
            }
        },
        addShipmentItem(id) {
            this.form1 = this.$inertia.form({
                id: '',
                product_id: '',
                currency: '',
                unit_price: '',
                quantity_ordered: '',
                total_price: '',
            });
        },
        addShipmentDocs() {
            this.form2 = this.$inertia.form({
                id: '',
                title: '',
                file: '',
                description: '',
            });
        },
        deleteShipmentItem(id) {
            let shipment_item = this.shipmentItems.find(shipmentItem => shipmentItem.id == id);
            if (!shipment_item.shipment_id) {
                this.shipmentItems = this.shipmentItems.filter(function (item) {
                    return item.id != id;
                });
            } else {
                this.shipmentItems = this.shipmentItems.filter(function (item) {
                    return item.id != id;
                });
                this.form.delete(route('shipment.item.delete', shipment_item.id))
            }

            var total = 0;
            this.shipmentItems.forEach(element => {
                total += parseFloat(element.total);
            });
            this.form.sub_total = total
            if (this.form.vat) {
                this.form.total = (parseFloat(this.form.sub_total) + parseFloat(this.form.vat)).toFixed(2);
                this.form.balance = this.form.total;
            }
        },
        deleteShipmentDoc(id) {
            let shipment_doc = this.shipmentDocs.find(shipment_doc => shipment_doc.id == id);
            if (!shipment_doc.documentable_id) {
                this.shipmentDocs = this.shipmentDocs.filter(function (item) {
                    return item.id != id;
                });
            } else {
                this.shipmentDocs = this.shipmentDocs.filter(function (item) {
                    return item.id != id;
                });
                this.form.delete(route('shipment.doc.delete', shipment_doc.id))
            }
        },

        editShipmentDocs(id) {
            let shipmentDocs = this.shipmentDocs.find(shipmentDoc => shipmentDoc.id == id);
            this.form2 = this.$inertia.form({
                id: shipmentDocs.id,
                title: shipmentDocs.title,
                file: shipmentDocs.file,
                description: shipmentDocs.description,
            });

        },
        editShipmentItem(id) {
            let shipment_item = this.shipmentItems.find(shipmentItem => shipmentItem.id == id);
            this.form1 = this.$inertia.form({
                id: shipment_item.id,
                product_id: shipment_item.product_id,
                unit_price: shipment_item.unit_price,
                quantity_ordered: shipment_item.quantity_ordered,
                total_price: shipment_item.total_price,
            });
            
        },
    },
}
</script>

<style scoped>
.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}

.error {
    margin-top: 0px !important;
}
</style>
