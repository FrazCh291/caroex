<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 v-if="purchaseOrder" class="card-title">Edit Purchase Order</h4>
                                <h4 v-else class="card-title">Add Purchase Order</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-horizontal" @submit.prevent="submit">
                                        <div class="form-body">
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Purchaser *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <select v-model="form.customer_id" class="form-select"
                                                            name="purchaser_id" @change="getCustomerDetail()">
                                                        <option value="">select</option>
                                                        <option v-for="customer in customers" :value="customer.id">
                                                            {{ customer.name }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="purchaser_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Contact </label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="purchaser_contact" v-model="form.customer_contact"
                                                           class="form-control"
                                                           name="purchaser_contact" readonly type="text"/>
                                                    <ErrorComponent input="purchaser_contact"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Address </label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="purchaser_address" v-model="form.customer_address"
                                                           class="form-control"
                                                           name="purchaser_address" readonly type="text"/>
                                                    <ErrorComponent input="purchaser_address"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Phone </label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="purchaser_phone" v-model="form.customer_phone"
                                                           class="form-control"
                                                           name="purchaser_phone" readonly type="text"/>
                                                    <ErrorComponent input="purchaser_phone"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Email </label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="purchaser_email" v-model="form.customer_email"
                                                           class="form-control"
                                                           name="purchaser_email" readonly type="text"/>
                                                    <ErrorComponent input="purchaser_email"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Supplier *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <select v-model="form.supplier_id" class="form-select"
                                                            name="supplier_id" @change="getSupplierDetail()">
                                                        <option value="">Select</option>
                                                        <option v-for="supplier in suppliers" :value="supplier.id">
                                                            {{ supplier.name }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="supplier_id"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Purchase Order# *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="purchase_order_number"
                                                           v-model="form.purchase_order_number"
                                                           class="form-control"
                                                           name="purchase_order_number" type="text"/>
                                                    <ErrorComponent input="purchase_order_number"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Contact </label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="supplier_contact" v-model="form.supplier_contact"
                                                           class="form-control"
                                                           name="supplier_contact" readonly type="text"/>
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Purchase Date *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="order_date" v-model="form.order_date"
                                                           class="form-control"
                                                           name="order_date" type="date"/>
                                                    <ErrorComponent input="order_date"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Address </label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="supplier_address" v-model="form.supplier_address"
                                                           class="form-control"
                                                           name="supplier_address" readonly type="text"/>
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Currency* </label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <select v-model="form.currency" class="form-select"
                                                            name="payer_currency_id">
                                                        <option value="">Select</option>
                                                        <option v-for="currency in currencies"
                                                                :value="currency.slug">
                                                            {{ currency.value }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="currency"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Phone </label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="supplier_phone" v-model="form.supplier_phone"
                                                           class="form-control"
                                                           name="supplier_phone" readonly type="text"/>
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Email </label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="supplier_email" v-model="form.supplier_email"
                                                           class="form-control"
                                                           name="supplier_email" readonly type="text"/>
                                                </div>
                                                <div class="col-md-7">
                                                </div>
                                            </div>
                                            <div class="row form-group pb-0 mb-0 py-0 my-0">
                                                <div class="col-lg-11 col-sm-6 col-md-6 pb-0 py-0 my-0">
                                                    <label>Purchase Order Item *</label>
                                                </div>
                                                <div v-if="purchaseOrderItems.length>0"
                                                     class="col-lg-1 col-sm-6 col-md-6 pb-0 form-group py-0 my-0">
                                                    <div class="col form-group pr-0 pb-0.5">
                                                        <span class="d-inline-flex align-items-center">
                                                            <span
                                                                class="d-inline-flex align-items-center"
                                                                data-target="#addItem"
                                                                data-toggle="modal"
                                                                @click="editPurchaseOrderItem()">
                                                               <span
                                                                   class="badge-circle badge-circle-light-secondary bg-white">
                                                                 <i class="bx bxs-plus-circle pt-0 primary float-right add-btn font-large-1"></i>
                                                               </span>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="purchaseOrderItems.length > 0" class="row py-0 my-0">
                                                <div id="table-hover-row" class="row col-12 pr-0 ng-repeat-start">
                                                    <div class="col-12 pr-0">
                                                        <div class="card pr-0 pb-0 mb-1">
                                                            <div class="card-content">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover truncate mb-0">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Product</th>
                                                                            <th>Unit Price</th>
                                                                            <th>Quantity</th>
                                                                            <th class="text-center">Total</th>
                                                                            <th class="text-right"></th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr v-for="purchaseOrderItem in purchaseOrderItems"
                                                                            class="py-0 my-0">
                                                                            <td>{{
                                                                                    purchaseOrderItem.product ? purchaseOrderItem.product.id == purchaseOrderItem.product_id ? purchaseOrderItem.product.name : '' : purchaseOrderItem.product_name
                                                                                }}
                                                                            </td>

                                                                            <td>{{
                                                                                    purchaseOrderItem.unit_price ? "£" + purchaseOrderItem.unit_price : ''
                                                                                }}
                                                                            </td>
                                                                            <td>{{ purchaseOrderItem.quantity }}</td>
                                                                            <td class="text-center">
                                                                                {{
                                                                                    purchaseOrderItem.currency?purchaseOrderItem.currency.toUpperCase().substr(purchaseOrderItem.currency.length -3 , purchaseOrderItem.currency.length) +' '+ purchaseOrderItem.total: ''
                                                                                }}
                                                                            </td>
                                                                            <td class="text-right">
                                                                                <div class="dropdown">
                                                                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                            </span>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a  data-target="#addItem" data-toggle="modal" v-on:click="editPurchaseOrderItem(purchaseOrderItem.id)" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                                                                            <a v-on:click="deleteReturnItem(purchaseOrderItem.id)" class="dropdown-item"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                            <div v-else class="row py-0 my-0">
                                                <div class="row col-12 pr-0 ng-repeat-start">
                                                    <div class="col-12 pr-0">
                                                        <div class="pr-0 pb-0 mb-1">
                                                            <div>
                                                                <div class="card-content">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover truncate mb-0">
                                                                            <thead>
                                                                            <tr class="text-center">
                                                                                <img alt="icon" class="img"
                                                                                     src="/img/empty-icon.png"><br>
                                                                                You don't have any purchase order item
                                                                                yet!<br>
                                                                                <span class="btn btn-primary ml-1 mt-1"
                                                                                      data-target="#addItem"
                                                                                      data-toggle="modal"
                                                                                      @click="editPurchaseOrderItem()">
                                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                                    <span
                                                                                        class="d-none d-sm-block">Add</span>
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
                                            <div v-if="purchaseOrderItems.length>0" class="row form-group py-0 my-0">
                                                <div class="col-md-6">
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>SubTotal *</label>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <input id="sub_total" v-model="form.sub_total"
                                                           class="form-control"
                                                           disabled name="sub_total" type="text"/>
                                                    <ErrorComponent input="sub_total"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                            </div>
                                            <div v-if="purchaseOrderItems.length>0" class="row form-group py-0 my-0">
                                                <div class="col-md-6">
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>Vat *</label>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <input id="vat" v-model="form.vat"
                                                           class="form-control"
                                                           name="vat"
                                                           type="text" @change="total()">
                                                    <ErrorComponent input="vat"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                            </div>
                                            <div v-if="purchaseOrderItems.length > 0" class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Status *</label>
                                                </div>
                                                <div v-if="purchaseOrder" class="col-md-3 form-group">
                                                    <select v-model="form.status" class="form-select"
                                                            name="status">
                                                        <option value="">Select</option>
                                                        <option v-for="purchase_order_status in purchase_order_statuses"
                                                                :value="purchase_order_status.slug">
                                                            {{ purchase_order_status.value }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="status"></ErrorComponent>
                                                </div>
                                                <div v-else class="col-md-3 form-group">
                                                    <input id="sub_total" class="form-control" readonly type="text"
                                                           value="New"/>
                                                </div>
                                                <div class="col-md-1">
                                                </div>
                                                <div v-if="purchaseOrderItems.length>0" class="col-md-2 form-group">
                                                    <label>Total *</label>
                                                </div>
                                                <div v-if="purchaseOrderItems.length>0" class="col-md-2 form-group">
                                                    <input id="total" v-model="form.total"
                                                           class="form-control"
                                                           disabled name="total" type="text"/>
                                                    <ErrorComponent input="total"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <!--                                                <button class="btn btn-primary mr-1 mb-1" type="submit">-->
                                                <!--                                                    Save-->
                                                <!--                                                </button>-->
                                                <button v-if="purchaseOrderItems.length>0"
                                                        class="btn btn-primary mr-1 mb-1"
                                                        type="submit">
                                                    Save
                                                </button>
                                                <button v-else class="btn btn-primary mr-1 mb-1" disabled type="submit">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('purchase-orders.index')"
                                                              class="btn btn-light-secondary mr-1 mb-1"
                                                              type="button">Back
                                                </inertia-link>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="addItem"
                                         aria-hidden="true" aria-labelledby="myModalLabel33"
                                         class="modal fade text-left"
                                         role="dialog"
                                         tabindex="-1">
                                        <div
                                            class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 id="myModalLabel33"
                                                        class="modal-title font-weight-bold">
                                                        Purchase Order Item Detail </h4>
                                                    <button aria-label="Close"
                                                            class="close"
                                                            data-dismiss="modal"
                                                            type="button">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <form
                                                    class="form form-horizontal">
                                                    <div class="modal-body mb-1">
                                                        <div class="form-group py-0 my-0 mb-1">
                                                            <label>Item Type</label>
                                                            <select id="item_type" v-model="form1.item_type"
                                                                    class="form-control"
                                                                    name="item_type" required>
                                                                <option value="">Select</option>
                                                                <option
                                                                    v-for="item_type in item_types"
                                                                    :value="item_type.slug">
                                                                    {{ item_type.value }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div v-if="form1.item_type==='item_type_product'"
                                                             class="form-group py-0 my-0 mb-1">
                                                            <label>Product</label>
                                                            <select id="product_id" v-model="form1.product_id"
                                                                    class="form-control"
                                                                    name="product_id" required>
                                                                <option value="">Select</option>
                                                                <option
                                                                    v-for="product in products"
                                                                    :value="product.id">
                                                                    {{ product.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div v-if="form1.item_type==='item_type_product' || form1.item_type==='item_type_aditional_cost'"
                                                             class="form-group my-0 mb-1">
                                                            <label>Currency *</label>
                                                            <select v-model="form1.currency" class="form-control"
                                                                    required>
                                                                <option value="">Select</option>
                                                                <option v-for="currency in currencies"
                                                                        :value="currency.slug">
                                                                    {{ currency.value }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div v-if="form1.item_type==='item_type_product'"
                                                             class="form-group py-0 my-0 mb-1">
                                                            <label>Unit Price *</label>
                                                            <input id="unit_price"
                                                                   v-model="form1.unit_price"
                                                                   class="form-control"
                                                                   max="15"
                                                                   min="1" name="unit_price" placeholder="Unit Price"
                                                                   required type="number">
                                                        </div>
                                                        <div v-if="form1.item_type==='item_type_product'"
                                                             class="form-group py-0 my-0 mb-1">
                                                            <label>Quantity *</label>
                                                            <input id="quantity"
                                                                   v-model="form1.quantity"
                                                                   class="form-control"
                                                                   max="15"
                                                                   min="1"
                                                                   name="quantity" placeholder="Quantity"
                                                                   required type="number" @change="totalAmount()">
                                                        </div>
                                                        <div v-if="form1.item_type==='item_type_product'"
                                                             class="form-group py-0 my-0">
                                                            <label>Total *</label>
                                                            <input id="total"
                                                                   v-model="form1.total"
                                                                   class="form-control"
                                                                   disabled
                                                                   name="unit_price"
                                                                   placeholder="Total" required type="text">
                                                        </div>
                                                        <div v-if="form1.item_type==='item_type_aditional_cost'"
                                                             class="form-group py-0 my-0">
                                                            <label>Aditional Cost *</label>
                                                            <input id="aditional_cost"
                                                                   v-model="form1.total"
                                                                   class="form-control"
                                                                   name="total"
                                                                   placeholder="Additional Cost" required type="text">
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
                                                        <button
                                                            class="btn btn-primary ml-1"
                                                            data-dismiss="modal"
                                                            type="submitt"
                                                            @click="submitt(form1.id)">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span
                                                                class="d-none d-sm-block">Add</span>
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

import AdminLayout from "../../Layouts/AdminLayout";
import Label from "../../Jetstream/Label";
import JetInputError from './../../Jetstream/InputError'
import {useForm} from '@inertiajs/inertia-vue3'
import ErrorComponent from '../../components/ErrorComponent'
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {
    name: "Create",
    props: ['suppliers', 'customers', 'errors', 'currencies', 'products', 'purchase_order_statuses', 'purchaseOrder', 'purchaseOrderItem', 'item_types'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ConfirmatiomModal,
        ErrorComponent,
    },

    setup() {
        const form = useForm({
            supplier_id: '',
            supplier_contact: '',
            supplier_address: '',
            supplier_phone: '',
            supplier_email: '',
            customer_id: '',
            customer_contact: '',
            customer_address: '',
            customer_phone: '',
            customer_email: '',
            purchase_order_number: '',
            order_date: '',
            currency: '',
            status: '',
            sub_total: 0.00,
            vat: 0.00,
            total: 0.00,
            // conversion_rate: '',
            purchaseOrderItems: [],
        })
        return {form}
    },
    data() {
        return {
            form1: this.$inertia.form({
                aditional_cost: '',
                id: '',
                product_id: '',
                currency: '',
                unit_price: 0.00,
                quantity: 0,
                total: '',
                item_type: ''
            }),

            purchaseOrderItems: this.purchaseOrderItem ? this.purchaseOrderItem : [],
            conversion_rate: false,
        }
    },

    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Purchase Order";
        this.form.purchaseOrderItems = this.purchaseOrderItem
        if (this.purchaseOrder) {
            this.update = true;
            let data = this.purchaseOrder;
            Object.assign(data, {
                'purchaseOrderItems': [],
                '_method': 'PUT'
            })
            this.form = this.$inertia.form(data);
            this.form.currency =  this.purchaseOrder.currency?this.purchaseOrder.currency.toLowerCase():''
            this.form.supplier_contact = this.purchaseOrder.supplier.contact_name;
            this.form.supplier_address = this.purchaseOrder.supplier.addresses[0]?this.purchaseOrder.supplier.addresses[0].address_1 :'' + ' ' +
                this.purchaseOrder.supplier.addresses[0]?this.purchaseOrder.supplier.addresses[0].town:'' + ' ' + this.purchaseOrder.supplier.addresses[0]?this.purchaseOrder.supplier.addresses[0].city:''
                + ', ' + this.purchaseOrder.supplier.addresses[0]?this.purchaseOrder.supplier.addresses[0].postcode:'' + ' ' +
                this.purchaseOrder.supplier.addresses[0]?this.purchaseOrder.supplier.addresses[0].country:'';
            this.form.supplier_phone = this.purchaseOrder.supplier.phone;
            this.form.supplier_email = this.purchaseOrder.supplier.email;
            this.form.customer_contact = this.purchaseOrder.customer.contact_name;
            this.form.customer_address = this.purchaseOrder.customer.addresses[0]?this.purchaseOrder.customer.addresses[0].address_1:'' + ' ' +
                this.purchaseOrder.customer.addresses[0]?this.purchaseOrder.customer.addresses[0].town: '' + ' ' + this.purchaseOrder.customer.addresses[0].city
                + ', ' + this.purchaseOrder.customer.addresses[0]?this.purchaseOrder.customer.addresses[0].postcode:'' + ' ' +
                this.purchaseOrder.customer.addresses[0]?this.purchaseOrder.customer.addresses[0].country:'';
            this.form.customer_phone = this.purchaseOrder.customer.phone;
            this.form.customer_email = this.purchaseOrder.customer.email;
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.purchaseOrderItems = this.purchaseOrderItems;
                this.form.post(route('purchase-orders.update', this.purchaseOrder.id))
            } else {
                this.form.purchaseOrderItems = this.purchaseOrderItems
                this.form.post('/erp/purchase-orders')
            }
        },
        submitt(id) {
            var product_name = this.products.find(product => product.id == this.form1.product_id);
            if (!this.form1.item_type) {
                event.stopPropagation();
            } else if (this.form1.item_type === 'item_type_aditional_cost') {
                if (this.form1.total==0) {
                    event.stopPropagation();
                } else {
                    if (this.form1.id) {
                        let index = 0;
                        this.purchaseOrderItems.find((purchaseOrderItem, ind) => {
                                index = ind;
                                return purchaseOrderItem.id === id
                            }
                        );
                        this.purchaseOrderItem[index].product_id = this.form1.product_id;
                        this.purchaseOrderItem[index].product_name = product_name.name;
                        this.purchaseOrderItem[index].currency = this.form1.currency;
                        this.purchaseOrderItem[index].currency_from_to = this.form1.currency;
                        this.purchaseOrderItem[index].unit_price = this.form1.unit_price;
                        this.purchaseOrderItem[index].quantity = this.form1.quantity;
                        this.purchaseOrderItem[index].total = this.form1.total;
                    } else {
                        let obj = {};
                        obj.total = this.form1.total;
                        obj.currency = this.form1.currency;
                        obj.currency_from_to = this.form1.currency;
                        obj.item_type = this.form1.item_type;
                        this.purchaseOrderItems.push(obj);
                        console.log(this.purchaseOrderItems,"this.purchaseOrderItems");
                    }
                }
            } else if (this.form1.item_type === 'item_type_product') {
                if (!this.form1.product_id) {
                    event.stopPropagation();
                } else if (!this.form1.currency) {
                    event.stopPropagation();
                } else if (!this.form1.unit_price) {
                    event.stopPropagation();
                } else if (!this.form1.quantity) {
                    event.stopPropagation();
                } else if (this.form1.total==='0') {
                    event.stopPropagation();
                } else {
                    if (this.form1.id) {
                        let index = 0;
                        this.purchaseOrderItems.find((purchaseOrderItem, ind) => {
                                index = ind;
                                return purchaseOrderItem.id === id
                            }
                        );
                        this.purchaseOrderItem[index].product_id = this.form1.product_id;
                        this.purchaseOrderItem[index].product_name = product_name.name;
                        this.purchaseOrderItem[index].currency = this.form1.currency;
                        this.purchaseOrderItem[index].currency_from_to = this.form1.currency;
                        this.purchaseOrderItem[index].unit_price = this.form1.unit_price;
                        this.purchaseOrderItem[index].quantity = this.form1.quantity;
                        this.purchaseOrderItem[index].total = this.form1.total;
                    } else {
                        let obj = {};
                        obj.id = this.form1.product_id
                        obj.product_id = this.form1.product_id;
                        obj.product_name = product_name.name;
                        obj.currency = this.form1.currency;
                        obj.currency_from_to = this.form1.currency;
                        obj.unit_price = parseFloat(this.form1.unit_price).toFixed(2);
                        obj.quantity = parseInt(this.form1.quantity);
                        obj.total = parseFloat(this.form1.total).toFixed(2);
                        obj.item_type = this.form1.item_type;
                        this.purchaseOrderItems.push(obj);
                    }
                }
            } else {
                event.stopPropagation();
            }
            var total = 0;
            this.purchaseOrderItems.forEach(element => {
                total += parseFloat(element.total);

            });
            this.form.sub_total = total
        },

        totalAmount() {
            this.form1.total = (parseFloat(this.form1.unit_price) * parseInt(this.form1.quantity)).toFixed(2)
        }
        ,
        total() {
            this.form.total = (parseFloat(this.form.sub_total) + parseFloat(this.form.vat)).toFixed(2);
        }
        ,
        getExchangeRate() {
            axios.get("/super/admin/search-rate", {
                params: {
                    id: this.form.currency,
                },
            })
                .then((response) => {
                    this.form.conversion_rate = response.data.exchange.amount;
                });
        },
        getSupplierDetail() {
            axios.get("/erp/search-supplier-purchase-orders", {
                params: {
                    id: this.form.supplier_id,
                },
            })
                .then((response) => {
                    this.form.supplier_contact = response.data.supplier.name;
                    this.form.supplier_address = response.data.address.address_1 + '' + response.data.address?response.data.address.town : ''
                        + ' ' + response.data.address.city + ', ' + response.data.address.postcode + ' ' +
                        response.data.address.country;
                    this.form.supplier_phone = response.data.supplier.phone;
                    this.form.supplier_email = response.data.supplier.email;
                });
        }
        ,
        editPurchaseOrderItem(id) {
            let purchase_order_item = this.purchaseOrderItems.find(purchaseOrderItem => purchaseOrderItem.id == id);
            this.form1 = this.$inertia.form({
                id: purchase_order_item.id,
                product_id: purchase_order_item.product_id,
                currency: purchase_order_item.currency,
                unit_price: purchase_order_item.unit_price,
                quantity: purchase_order_item.quantity,
                total: purchase_order_item.total,
            });
        }
        ,
        getCustomerDetail() {
            axios.get("/erp/search-customer-purchase-orders", {
                params: {
                    id: this.form.customer_id,
                },
            })
                .then((response) => {
                    this.form.customer_contact = response.data.customer.name;
                    this.form.customer_address = response.data.address.address_1 + ' ' + response.data.address?response.data.address.town: ''
                        + ' ' + response.data.address.city + ', ' + response.data.address.postcode + ' ' +
                        response.data.address.country;
                    this.form.customer_phone = response.data.customer.phone;
                    this.form.customer_email = response.data.customer.email;
                });
        }
        ,
        editOrder(id) {
            this.form1 = this.$inertia.form({
                product_id: '',
                currency: '',
                unit_price: '',
                quantity: '',
                total: '',
            });
        }
        ,
        deleteReturnItem(id) {
            this.purchaseOrderItems = this.purchaseOrderItems.filter(function (item) {
                if (item.id === id) {
                    if (item.purchase_order_id) {
                        axios.get("/erp/delete-purchase-order-item", {
                            params: {
                                id: id,
                            },
                        })
                            .then((response) => {
                            });
                    }
                }
                return item.id != id;
            });
            var total = 0;
            this.purchaseOrderItems.forEach(element => {
                total += parseFloat(element.total);
            });
            this.form.sub_total = total
            if (this.form.vat) {
                this.form.total = (parseFloat(this.form.sub_total) + parseFloat(this.form.vat)).toFixed(2);
            }
        }
        ,
    },
}
</script>

<style scoped>

.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}

.img {
    height: 100px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.error {
    margin-top: 0px !important;
}


</style>
