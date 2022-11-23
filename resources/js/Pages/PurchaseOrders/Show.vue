<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title">Purchase Order Details</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-7">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Purchaser:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ purchaseOrder.customer?purchaseOrder.customer.name:'' }}
                                        </div>
                                    </div>
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-7">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Contact:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ purchaseOrder.customer?purchaseOrder.customer.contact_name:'' }}
                                        </div>
                                    </div>
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-7">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Address:</label>
                                        </div>
                                        <div class="col-md-3 form-group"
                                             v-if="purchaseOrder.customer.addresses.length>0">
                                            {{
                                                purchaseOrder.customer.addresses[0].address_1 + " " +
                                                purchaseOrder.customer.addresses[0].town + " " +
                                                purchaseOrder.customer.addresses[0].city + ", " +
                                                purchaseOrder.customer.addresses[0].postcode + " " +
                                                purchaseOrder.customer.addresses[0].country
                                            }}
                                        </div>
                                        <div class="col-md-3 form-group" v-else>

                                        </div>
                                    </div>
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-7">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Phone:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ purchaseOrder.customer?purchaseOrder.customer.phone:'' }}
                                        </div>
                                    </div>
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-7">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Email:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ purchaseOrder.customer?purchaseOrder.customer.email:'' }}
                                        </div>
                                    </div>
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-2">
                                            <label>Supplier:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ purchaseOrder.supplier?purchaseOrder.supplier.name:'' }}
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Purchase Order#:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ purchaseOrder?purchaseOrder.purchase_order_number:'' }}
                                        </div>
                                    </div>
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-2">
                                            <label>Contact:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ purchaseOrder.supplier?purchaseOrder.supplier.contact_name:'' }}
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Purchase Date:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ formatDate(purchaseOrder.order_date) }}
                                        </div>
                                    </div>
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-2">
                                            <label>Address:</label>
                                        </div>
                                        <div class="col-md-3 form-group"
                                             v-if="purchaseOrder.supplier.addresses.length>0">
                                            {{
                                                purchaseOrder.supplier.addresses[0].address_1 + " " +
                                                purchaseOrder.supplier.addresses[0].town + " " +
                                                purchaseOrder.supplier.addresses[0].city + ", " +
                                                purchaseOrder.supplier.addresses[0].postcode + " " +
                                                purchaseOrder.supplier.addresses[0].country
                                            }}
                                        </div>
                                        <div class="col-md-3 form-group" v-else>

                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Currency:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ purchaseOrder.currency ? purchaseOrder.currency.from_to : '' }}
                                        </div>
                                    </div>
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-2">
                                            <label>Phone:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ purchaseOrder.supplier?purchaseOrder.supplier.phone:'' }}
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Conversion Rate:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ purchaseOrder?purchaseOrder.conversion_rate:'' }}
                                        </div>
                                    </div>
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-2">
                                            <label>Email:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {{ purchaseOrder.supplier?purchaseOrder.supplier.email:'' }}
                                        </div>
                                        <div class="col-md-7">
                                        </div>
                                    </div>
                                    <div class="row py-0 my-0">
                                        <div id="table-hover-row" class="row col-12 pr-0 ng-repeat-start">
                                            <div class="col-12 pr-0">
                                                <div class="card pr-0 pb-0 mb-1">
                                                    <div class="card-content">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover truncate mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th>Item Type</th>
                                                                    <th>Product</th>
                                                                    <th class="text-center">Currency</th>
                                                                    <th class="text-center">Unit Price</th>
                                                                    <th class="text-center">Quantity</th>
                                                                    <th class="text-right">Total</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="purchaseOrderItem in
                                                                        purchaseOrder.purchase_order_item">
                                                                    <td>{{ purchaseOrderItem.lookup ? purchaseOrderItem.lookup.value:'' }}</td>
                                                                    <td>{{ purchaseOrderItem.product ? purchaseOrderItem.product.name:'' }}</td>
                                                                    <td class="text-center">
                                                                        {{
                                                                            purchaseOrderItem.currencies ? purchaseOrderItem.currencies.from_to : ''
                                                                        }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ purchaseOrderItem ? "£" + purchaseOrderItem.unit_price: '' }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ purchaseOrderItem ? purchaseOrderItem.quantity:'' }}
                                                                    </td>
                                                                    <td class="text-right">
                                                                        {{ purchaseOrderItem ? "£" + purchaseOrderItem.total:'' }}
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
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>SubTotal:</label>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            {{ "£" + purchaseOrder.sub_total }}
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                    </div>
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Vat:</label>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            {{ "£" + purchaseOrder.vat }}
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                    </div>
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-2">
                                            <label>Status:</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                                    <span v-if="purchaseOrder.status === 'new'"
                                                          class="badge badge-light-primary badge-pill">New</span>
                                            <span v-else-if="purchaseOrder.status === 'released'"
                                                  class="badge badge-light-warning badge-pill">Released</span>
                                            <span v-else-if="purchaseOrder.status === 'received'"
                                                  class="badge badge-light-success badge-pill">Received</span>
                                            <span v-else-if="purchaseOrder.status === 'canceled'"
                                                  class="badge badge-light-danger badge-pill">Canceled</span>
                                            <span v-else
                                                  class="badge badge-light-seceondary badge-pill">Closed</span>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Total:</label>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            {{ "£" + purchaseOrder.total }}
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                    </div>
                                    <div class="row form-group pb-0 mb-0 py-0 my-0">
                                        <div class="col-md-11 pb-0 py-0 my-0">
                                            <label>Invoices*</label>
                                        </div>
                                        <div v-if="invoices"
                                             class="col-md-1 pb-0 form-group py-0 my-0">
                                            <div class="col form-group pr-0 pb-0.5">
                                                <span class="d-inline-flex align-items-center">
                                                    <span
                                                        class="d-inline-flex align-items-center"
                                                        data-target="#addItem"
                                                        data-toggle="modal">
                                                        <span
                                                            class="badge-circle badge-circle-light-secondary bg-white"
                                                            v-if="purchaseOrderInvoices.length>0">
                                                            <i class="bx bxs-plus-circle pt-0 primary float-right add-btn font-large-1"></i>
                                                        </span>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="purchaseOrderInvoices.length>0" class="row py-0 my-0">
                                        <div id="table-hover-row" class="row col-12 pr-0 ng-repeat-start">
                                            <div class="col-12 pr-0">
                                                <div class="card pr-0 pb-0 mb-1">
                                                    <div class="card-content">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover truncate mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th>Invoice#</th>
                                                                    <th>Date</th>
                                                                    <th>Currency</th>
                                                                    <th class="text-center">Total</th>
                                                                    <th class="text-center">Status</th>
                                                                    <th class="text-right"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="py-0 my-0"
                                                                       v-for="purchaseOrderInvoice in purchaseOrderInvoices">
                                                                <tr>
                                                                    <td>{{
                                                                            purchaseOrderInvoice.invoice.invoice_number
                                                                        }}
                                                                    </td>
                                                                    <td>{{
                                                                            formatDate(purchaseOrderInvoice.invoice.invoice_date)
                                                                        }}
                                                                    </td>
                                                                    <td>{{
                                                                            purchaseOrderInvoice.invoice.exchang ? purchaseOrderInvoice.invoice.exchang.from_to : ''
                                                                        }}
                                                                    </td>
                                                                    <td class="text-center">{{
                                                                            "£" +
                                                                            purchaseOrderInvoice.invoice.total
                                                                        }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                            <span
                                                                                v-if="purchaseOrderInvoice.invoice.status === 'paid'"
                                                                                class="badge badge-light-success badge-pill">
                                                                                Paid</span>
                                                                        <span v-else
                                                                              class="badge badge-light-danger badge-pill">
                                                                                Unpaid</span>
                                                                    </td>
                                                                    <td class="text-right py-1 my-0 d-flex justify-content-end">
                                                                <div class="dropdown">
                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                <a  :href="route('purchase.order.create.payment',['purchase-orders',purchaseOrder.id,'invoices',purchaseOrderInvoice.invoice.id] )" class="dropdown-item"><i class="bx bx-plus mr-1"></i>Add Payment</a>
                                                                <a  :href="route('purchase.order.edit.invoice',['purchase-orders',purchaseOrder.id,purchaseOrderInvoice.invoice.id])" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                                <a  v-on:click="deleteInvoice(purchaseOrder.id, purchaseOrderInvoice.invoice.id)" class="dropdown-item"><i class="bx bx-trash mr-1"></i>Delete</a>
                                                                </div>
                                                                </div>
                                                                    </td>
                                                                </tr>
                                                                <tr v-for="invoicePayment in purchaseOrderInvoice.invoice.payments"
                                                                    v-bind:id='"collapse"+purchaseOrderInvoice.invoice.id'
                                                                    aria-labelledby="headingCollapse8"
                                                                    class="collapse">
                                                                    <td class="text-right mr-5 ml-0">
                                                                        <strong>Payment</strong></td>
                                                                    <td class="text-center">
                                                                        {{ formatDate(invoicePayment.payment_date) }}
                                                                    </td>
                                                                    <td class="text-truncate">
                                                                        {{
                                                                            invoicePayment.currencies ? invoicePayment.currencies.from_to : ''
                                                                        }}
                                                                    </td>
                                                                    <td class="text-right">
                                                                        {{ "£" + invoicePayment.payee_total }}
                                                                    </td>
                                                                    <td class="text-truncate"></td>
                                                                    <td class="text-right"
                                                                        @click="hideTooltip(invoicePayment.id)"> 
                                                                        <div class="dropdown">
                                                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                                                </span>
                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                <a :href="route('purchase.order.edit.payment', ['purchase-orders',purchaseOrder.id,'invoices',purchaseOrderInvoice.invoice.id,invoicePayment.id])" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                                                                <a class="dropdown-item"  v-on:click="deletePayment(invoicePayment.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                    <div class="row py-0 my-0" v-else>
                                        <div class="row col-12 pr-0 ng-repeat-start">
                                            <div class="col-12 pr-0">
                                                <div class="pr-0 pb-0 mb-1">
                                                    <div>
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr class="text-center">
                                                                        <img class="img" alt="icon"
                                                                             src="/img/empty-icon.png"><br>
                                                                        You don't have any invoice yet;<br>
                                                                        <span class="btn btn-primary ml-1 mt-1"
                                                                              data-target="#addItem"
                                                                              data-toggle="modal"
                                                                              @click="editPurchaseOrderItem()">
                                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                                            <span class="d-none d-sm-block">Add</span>
                                                                        </span>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-11 d-flex justify-content-start px-0">
                                        <inertia-link :href="route('purchase-orders.index')"
                                                      class="btn btn-light-secondary mr-1 mb-1"
                                                      type="button">
                                            Back
                                        </inertia-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="addItem"
                     aria-hidden="true" aria-labelledby="myModalLabel33"
                     class="modal fade text-left"
                     role="dialog"
                     tabindex="-1">
                    <div
                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                        role="document">
                        <div class="modal-content">
                            <div class="modal-header border-bottom-0 pb-0">
                                <h4 id="myModalLabel33"
                                    class="modal-title font-weight-bold"></h4>
                                <button aria-label="Close"
                                        class="close"
                                        data-dismiss="modal"
                                        type="button">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                            <div class="modal-body mb-1 pt-0">
                                <div
                                    class="input-group form-group d-flex position-relative mt-1 px-2
                                           pr-md-0 pl-md-0">
                                    <input type="text" class="form-control border-light-gray btn-height"
                                           placeholder="Search..."
                                           aria-label="Search"
                                           aria-describedby="basic-addon2" v-model="form.searchWord" @change="search">
                                    <div class="input-group-append">
                                        <button class="input-group-text search-btn" @click="search">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 class="feather feather-search feather-16 pb-0 mb-0 mt-0">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div id="searchdiv1">
                                    <span class="badge-circle badge-circle-light-secondary action ml-auto mr-auto">
                                        <i class="bx bx-search-alt-2 font-medium-1 align-items-center mx-1">
                                        </i>
                                    </span>
                                    <p class="text-center">Search for invoice</p>
                                </div>
                                <div id="searchdiv2">
                                    <span class="badge-circle badge-circle-light-secondary action ml-auto mr-auto">
                                        <i class="bx bx-sad font-medium-1 align-items-center mx-1">
                                        </i>
                                    </span>
                                    <p class="text-center">No invoice found</p>
                                </div>
                                <div v-if="searchInvoices.length > 0">
                                    <table class="table table-hover mb-0">
                                        <tr v-for="searchInvoice in searchInvoices">
                                            <td class="border-0"><input type="checkbox" name="invoiceId"
                                                                        :value="searchInvoice.id"></td>
                                            <td class="border-0">{{ searchInvoice.invoice_number }}</td>
                                            <td class="border-0">{{ formatDate(searchInvoice.invoice_date) }}</td>
                                            <td class="border-0">{{ "£" + searchInvoice.total }}</td>
                                            <td class="border-0" v-if="searchInvoice.purchase_orders.length>0">
                                                <table class="table truncate mb-0 d-flex">
                                                    <tr v-for="purchaseOrder in searchInvoice.purchase_orders">
                                                        <td class="border-0 pl-0">
                                                            <span data-placement="bottom"
                                                                  :data-toggle="purchaseOrder.id"
                                                                  @click="showTooltip(purchaseOrder.id)"
                                                                  data-container="body"
                                                                  type="button" data-html="true" href="#" id="login">
                                                                <span class="underline-dotted border-gray">
                                                                    {{
                                                                        "Purchase Order# " + purchaseOrder.purchase_order_number
                                                                    }}</span>
                                                            </span>
                                                            <div class="container">
                                                                <div :id="'popover-content-'+purchaseOrder.id"
                                                                     class="d-none">
                                                                    <div class="row custom-popover popover-max">
                                                                        <div class="col-12">
                                                                            <span
                                                                                class="font-weight-bold h5 mb-1 small">
                                                                                {{
                                                                                    "Purchase Order#: " + purchaseOrder.purchase_order_number
                                                                                }}
                                                                            </span><br>
                                                                            <span
                                                                                class="font-weight-bold h5 mb-1 small">
                                                                                {{
                                                                                    "Purchaser: " + purchaseOrder.customer.name
                                                                                }}
                                                                            </span><br>
                                                                            <span
                                                                                class="font-weight-bold h5 mb-1 small">
                                                                                {{
                                                                                    "Supplier: " + purchaseOrder.supplier.name
                                                                                }}
                                                                            </span><br>
                                                                            <span
                                                                                class="font-weight-bold h5 mb-1 small">
                                                                                {{
                                                                                    "Currency: " + purchaseOrder.currency ? purchaseOrder.currency.from_to : ''
                                                                                }}
                                                                            </span><br>
                                                                            <span
                                                                                class="font-weight-bold h5 mb-1 small">
                                                                                {{
                                                                                    "Currency Rate: £" + purchaseOrder.conversion_rate
                                                                                }}
                                                                            </span><br>
                                                                            <span
                                                                                class="font-weight-bold h5 mb-1 small">
                                                                                {{
                                                                                    "Subtotal: £" + purchaseOrder.sub_total
                                                                                }}
                                                                            </span><br>
                                                                            <span
                                                                                class="font-weight-bold h5 mb-1 small">
                                                                                {{ "Vat: £" + purchaseOrder.vat }}
                                                                            </span><br>
                                                                            <span
                                                                                class="font-weight-bold h5 mb-1 small">
                                                                                {{ "Tota: £" + purchaseOrder.total }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="border-0" v-else></td>
                                        </tr>
                                    </table>
                                    <button class="btn btn-primary mt-1" @click="saveInvoices">Add</button>
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
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import AdminLayout from "../../Layouts/AdminLayout";
import ErrorComponent from "../../components/ErrorComponent";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import DialogModal from "@/Jetstream/DialogModal";

export default {
    name: "Show",
    props: ['purchaseOrder', 'invoices', 'purchaseOrderInvoices'],
    components: {
        DialogModal,
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
        ErrorComponent,
    },
    data() {
        return {
            form: this.$inertia.form({
                searchWord: ''
            }),
            sweetAlert: false,
            update: false,
            itemId: '',
            total: 0,
            rotate: false,
            searchInvoices: []
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Purchase Order View";
    },
    mounted() {
        document.getElementById("searchdiv2").style.display = "none";
        this.purchaseOrder.purchase_order_item.forEach((index) => {
            this.total += parseFloat(index.total);
        })
        this.total = parseFloat(this.total).toFixed(2)
    },
    methods: {
        stopPropagation(e) {
            e.stopPropagation();
            this.submit();
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY');
        },
        search() {
            axios.get("/search-invoices-purchase-orders", {
                params: {
                    word: this.form.searchWord,
                },
            })
                .then((response) => {
                    if (response.data.invoices) {
                        document.getElementById("searchdiv1").style.display = "none";
                        document.getElementById("searchdiv2").style.display = "none";
                        this.searchInvoices = response.data.invoices
                    } else {
                        document.getElementById("searchdiv1").style.display = "none";
                        document.getElementById("searchdiv2").style.display = "block";
                    }
                });
        },
        saveInvoices() {
            var invoicesId = [];
            $.each($("input[name='invoiceId']:checked"), function () {
                invoicesId.push($(this).val());
            });
            this.$inertia.visit(route('purchase.order.save.invoices'), {
                method: 'post',
                data: {
                    invoicesId: invoicesId,
                    id: this.purchaseOrder.id
                }
            })
            $('#addItem').modal('hide')
        },
        deleteInvoice(purchaseOrderId, purchaseOrderInvoiceId) {
            this.$inertia.visit(route('purchase.order.delete.invoice'), {
                method: 'post',
                data: {
                    purchaseOrderId: purchaseOrderId,
                    purchaseOrderInvoiceId: purchaseOrderInvoiceId
                }
            })
        },
        rotateIcon(id) {
            let element = 'collaspe-icon' + id;
            if (this.rotate == false) {
                document.getElementById(element).style.transform = 'rotate(180deg)';
                document.getElementById(element).style.transition = 'transform 1s';
                this.rotate = true;
            } else {
                document.getElementById(element).style.transform = 'rotate(0deg)';
                document.getElementById(element).style.transition = 'transform 1s';
                this.rotate = false;
            }
        },
        deletePayment(id) {
            this.$inertia.visit(route('purchase.order.delete.payment'), {
                method: 'post',
                data: {
                    purchaseOrderId: this.purchaseOrder.id,
                    paymentId: id
                }
            })
        },
        showTooltip(id) {
            if (this.id == null) {
                this.id = id;
                $("[data-toggle=" + id + "]").popover({
                    html: true,
                    container: '.modal',
                    content: function () {
                        return $('#popover-content-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "]").popover('show')
            } else if (this.id == id) {
                $("[data-toggle=" + this.id + "]").popover('dispose');
                this.id = null;
            } else {
                $("[data-toggle=" + this.id + "]").popover('dispose');
                this.id = id;
                $("[data-toggle=" + id + "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "]").popover('show')
            }
        },
        hideTooltip(id) {
            $("[data-toggle=" + this.id + "]").popover('dispose');
            this.id = null;
        },
        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('purchase-orders.index'), {
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
.t-header {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

.action {
    padding-top: 8px !important;
    padding-bottom: 8px !important;
}

.text-small {
    font-size: 14px !important;
}

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
    height: auto !important;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.text-title-icon {
    vertical-align: super;
}

#active, #comment {
    margin-top: 10px;
}

#activeLabel {
    margin-top: 15px;
}

#url, #date {
    color: white;
}

.hide {
    display: none;
}

.show {
    display: block;
}

.clap {
    padding-top: 8px;
}

#editIcon {
    margin-top: 12px;
}

#deleteWord {
    margin-top: 7px;
}

#paymentHr {
    margin-top: 10px;
}

#bi-three-dots {
    transform: rotate(90deg);
}

.img {
    height: 100px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

</style>
