<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 v-if="invoice" class="card-title">Invoice# {{invoice.id}}</h4>
                                <h4 v-else class="card-title">Add Invoice</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-horizontal" @submit.prevent="send">
                                        <div class="form-body">
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Supplier *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <select v-model="form.supplier_id" class="form-select"
                                                            name="supplier_id">
                                                        <option value=""></option>
                                                        <option v-for="supplier in suppliers" :value="supplier.id">
                                                            {{ supplier.channel.name }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="supplier_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Order# *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <select v-model="form.order_id" class="form-select"
                                                            name="order_id">
                                                        <option value=""></option>
                                                        <option v-for="order in orders" :value="order.id">
                                                            {{ order.order_number }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="order_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Invoice# *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="invoice_number" v-model="form.invoice_number"
                                                           class="form-control"
                                                           name="invoice_number"
                                                           type="text">
                                                    <ErrorComponent input="invoice_number"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Reference *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="reference_number" v-model="form.reference_number"
                                                           class="form-control"
                                                           name="reference_number"
                                                           type="text">
                                                    <ErrorComponent input="reference_number"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Date *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input id="invoice_date" v-model="form.invoice_date"
                                                           class="form-control"
                                                           name="invoice_date" type="date">
                                                    <ErrorComponent input="invoice_date"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Currency *</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <select v-model="form.currency" class="form-select"
                                                            name="payer_currency_id" @change="getExchangeRate()">
                                                        <option value="">Select</option>
                                                        <option v-for="currency in currencys"
                                                                :value="currency.slug">
                                                            {{ currency.value }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="currency"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <!-- <label>Customer *</label> -->
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <!-- <select v-model="form.customer_id" class="form-select"
                                                            name="customer_id">
                                                        <option value="">Select</option>
                                                        <option v-for="customer in customers" :value="customer.id">
                                                            {{ customer.name }}
                                                        </option>
                                                    </select> -->
                                                    <!-- <ErrorComponent input="currency"></ErrorComponent> -->
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-7">
                                                </div>
                                            </div>
                                            <div class="row form-group pb-0 mb-0 py-0 my-0">
                                                <div class="col-md-11 pb-0 py-0 my-0">
                                                    <label>Invoice Item *</label>
                                                </div>
                                                <div v-if="invoiceItems.length>0"
                                                     class="col-md-1 pb-0 form-group py-0 my-0">
                                                    <div class="col form-group pr-0 pb-0.5">
                                                        <span class="d-inline-flex align-items-center">
                                                            <span
                                                                class="d-inline-flex align-items-center"
                                                                data-target="#addItem"
                                                                data-toggle="modal"
                                                                @click="addInvoiceItem()">
                                                               <span
                                                                   class="badge-circle badge-circle-light-secondary bg-white">
                                                                 <i class="bx bxs-plus-circle pt-0 primary float-right add-btn font-large-1"></i>
                                                               </span>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="invoiceItems.length>0" class="row py-0 my-0">
                                                <div id="table-hover-row" class="row col-12 pr-0 ng-repeat-start">
                                                    <div class="col-12 pr-0">
                                                        <div class="card pr-0 pb-0 mb-1">
                                                            <div class="card-content">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover truncate mb-0">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Product</th>
                                                                            <th class="text-center">Currency</th>
                                                                            <th class="text-right">Unit Price</th>
                                                                            <th class="text-right">Quantity</th>
                                                                            <th class="text-right">Total</th>
                                                                            <th class="text-right"></th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr v-for="invoiceItem in this.invoiceItems"
                                                                            class="py-0 my-0">
                                                                            <td>{{
                                                                                    invoiceItem.product ?
                                                                                        invoiceItem.product.id ==
                                                                                        invoiceItem.product_id ?
                                                                                            invoiceItem.product.name : '' :
                                                                                        invoiceItem.product_name
                                                                                }}
                                                                            </td>
                                                                            <td class="text-center">{{
                                                                                    invoiceItem.conversion ?
                                                                                        invoiceItem.conversion.id ==
                                                                                        invoiceItem.currency ?
                                                                                            invoiceItem.conversion.from_to : '' :
                                                                                        invoiceItem.currency_from_to
                                                                                }}
                                                                            </td>
                                                                            <td class="text-right">
                                                                                £{{ invoiceItem.unit_price }}
                                                                            </td>
                                                                            <td class="text-right">
                                                                                {{ invoiceItem.quantity }}
                                                                            </td>
                                                                            <td class="text-right">£{{
                                                                                    invoiceItem.total
                                                                                }}
                                                                            </td>
                                                                            <td class="text-right">
                                                                                    <span
                                                                                        v-if="invoiceItem.id"
                                                                                        class="d-inline-flex align-items-center"
                                                                                        data-target="#addItem"
                                                                                        data-toggle="modal"
                                                                                        v-on:click="editInvoiceItem(invoiceItem.id)">
                                                                                        <span
                                                                                            class="badge-circle badge-circle-light-secondary">
                                                                                        <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                                                                        </span>
                                                                                    </span>
                                                                                <span
                                                                                    class="d-inline-flex align-items-center ml-0.5"
                                                                                    v-on:click="deleteInvoiceItem(invoiceItem.id)">
                                                                                        <span
                                                                                            class="badge-circle badge-circle-light-secondary">
                                                                                            <i class="bx bx-trash font-medium-1 text-center"></i>
                                                                                        </span>
                                                                                </span>
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
                                                                                You don't have any invoice item yet!<br>
                                                                                <span class="btn btn-primary ml-1 mt-1"
                                                                                      data-target="#addItem"
                                                                                      data-toggle="modal"
                                                                                      @click="addInvoiceItem()">
                                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                                    <span
                                                                                        class="d-none d-sm-block">Add</span>
                                                                                </span>
                                                                                <br>
                                                                                <ErrorComponent input="invoiceItems"></ErrorComponent>
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
                                            <div class="row form-group py-0 my-0" v-if="invoiceItems.length>0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>SubTotal *</label>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <input id="sub_total" v-model="form.sub_total"
                                                           class="form-control"
                                                           name="sub_total" readonly type="text"/>
                                                    <ErrorComponent input="sub_total"></ErrorComponent>
                                                </div>
                                                <div class="col-md-1">
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0" v-if="invoiceItems.length>0">
                                                <div class="col-md-7">
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
                                                <div class="col-md-1">
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0" v-if="invoiceItems.length>0">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>Total *</label>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <input id="total" v-model="form.total"
                                                           class="form-control"
                                                              name="total" readonly type="text"/>
                                                    <ErrorComponent input="total"></ErrorComponent>
                                                </div>
                                                <div class="col-md-1">
                                                </div>
                                            </div>
                                            <div class="row form-group pb-0 mb-0 py-0 my-0">
                                                <div class="col-md-11 pb-0 py-0 my-0">
                                                    <label>Invoice Docs *</label>
                                                </div>
                                                <div v-if="invoiceDocs.length>0"
                                                     class="col-md-1 pb-0 form-group py-0 my-0">
                                                    <div class="col form-group pr-0 pb-0.5">
                                                        <span class="d-inline-flex align-items-center">
                                                            <span
                                                                class="d-inline-flex align-items-center"
                                                                data-target="#addDocs"
                                                                data-toggle="modal"
                                                                @click="addInvoiceDocs()">
                                                               <span
                                                                   class="badge-circle badge-circle-light-secondary bg-white">
                                                                 <i class="bx bxs-plus-circle pt-0 primary float-right add-btn font-large-1"></i>
                                                               </span>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="invoiceDocs.length>0" class="row py-0 my-0">
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
                                                                        <tr v-for="invoiceDoc in this.invoiceDocs"
                                                                            class="py-0 my-0">
                                                                            <td>{{ invoiceDoc.title }}
                                                                            </td>
                                                                            <td class="text-center">{{invoiceDoc.file }}
                                                                            </td>
                                                                            <td class="text-right">{{invoiceDoc.description}}
                                                                            </td>
                                                                            <td class="text-right">
                                                                                    <span
                                                                                        class="d-inline-flex align-items-center"
                                                                                        data-target="#addDocs"
                                                                                        data-toggle="modal"
                                                                                        v-on:click="editInvoiceDocs(invoiceDoc.id)">
                                                                                        <span
                                                                                            class="badge-circle badge-circle-light-secondary">
                                                                                        <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                                                                        </span>
                                                                                    </span>
                                                                                <span
                                                                                    class="d-inline-flex align-items-center ml-0.5"
                                                                                    v-on:click="deleteInvoiceDoc(invoiceDoc.id)">
                                                                                        <span
                                                                                            class="badge-circle badge-circle-light-secondary">
                                                                                            <i class="bx bx-trash font-medium-1 text-center"></i>
                                                                                        </span>
                                                                                </span>
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
                                                                                     src="/img/empty-icon2.png"><br>
                                                                                You don't have any invoice Documents
                                                                                yet!<br>
                                                                                <span class="btn btn-primary ml-1 mt-1"
                                                                                      data-target="#addDocs"
                                                                                      data-toggle="modal"
                                                                                      @click="addInvoiceDocs()">
                                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                                        <span
                                                                            class="d-none d-sm-block">Add</span>
                                                                    </span>
                                                                    <br>
                                                                        <ErrorComponent input="invoiceDocs"></ErrorComponent>
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
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2 form-group">
                                                    <label>Status</label>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <select v-model="form.status" class="form-select"
                                                            name="status">
                                                        <option value="">Select</option>
                                                        <option v-for="status in statuses" :value="status.slug">
                                                            {{ status.value }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="status"></ErrorComponent>
                                                </div>
                                                <div class="col-md-8">
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0" v-if="invoiceItems.length>0">
                                                <div class="col-md-2 form-group">
                                                    <label>Balance</label>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <input id="balance" v-model="form.balance"
                                                           class="form-control"
                                                           name="balance" readonly type="text"/>
                                                    <ErrorComponent input="balance"></ErrorComponent>
                                                </div>
                                                <div class="col-md-8">
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button class="btn btn-primary mr-1 mb-1" type="label">
                                                    Save
                                                </button>
                                                <!-- <inertia-link :href="route('invoices.index')"
                                                              class="btn btn-light-secondary mr-1 mb-1"
                                                              type="button">
                                                    Back
                                                </inertia-link> -->
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
                                                        Invoice Items </h4>
                                                    <button aria-label="Close"
                                                            class="close"
                                                            data-dismiss="modal"
                                                            type="button">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <form
                                                    class="form form-horizontal">
                                                    <li v-for="error in errors" class="error">{{ error }}</li>
                                                    <div class="modal-body mb-1">
                                                        <div class="form-group py-0 my-0 mb-1">
                                                            <label>Product</label>
                                                            <select id="product_id" v-model="form1.product_id"
                                                                    class="form-control"
                                                                    name="product_id">
                                                                <option value="">Select</option>
                                                                <option
                                                                    v-for="product in products"
                                                                    :value="product.id" required>
                                                                    {{ product.name }}
                                                                </option>
                                                            </select>
                                                             <ErrorComponent input="product_id"></ErrorComponent>
                                                        </div>
                                                        <div class="form-group my-0 mb-1">
                                                            <label>Currency *</label>
                                                            <select v-model.lazy="form1.currency" class="form-control">
                                                                <option value="">Select</option>
                                                                <option v-for="currency in currencys"
                                                                        :value="currency.id">
                                                                    {{ currency.value }}
                                                                </option>
                                                            </select>
                                                          
                                                        </div>
                                                        <div class="form-group py-0 my-0 mb-1">
                                                            <label>Unit Price *</label>
                                                            <input id="unit_price"
                                                                   v-model="form1.unit_price"
                                                                   class="form-control"
                                                                   name="unit_price"
                                                                   placeholder="Unit Price" min="1" max="15"
                                                                   type="number"
                                                                   @change="Amount()" required>
                                                        </div>
                                                        <div class="form-group py-0 my-0 mb-1">
                                                            <label>Quantity *</label>
                                                            <input id="quantity"
                                                                   v-model="form1.quantity"
                                                                   class="form-control"
                                                                   name="quantity"
                                                                   placeholder="Quantity" min="1" max="15"
                                                                   type="number"
                                                                   @change="totalAmount()" required>
                                                        </div>
                                                        <div class="form-group py-0 my-0">
                                                            <label>Total *</label>
                                                            <input id="total"
                                                                   v-model="form1.total"
                                                                   class="form-control"
                                                                   name="unit_price"
                                                                   placeholder="Total" required
                                                                   readonly type="text"/>
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
                                                                type="button"
                                                                @click="create(form1.id)">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span
                                                                class="d-none d-sm-block">Add</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="addDocs"
                                         aria-hidden="true" aria-labelledby="myModalLabel22"
                                         class="modal fade text-left"
                                         role="dialog"
                                         tabindex="-1">
                                        <div
                                            class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 id="myModalLabel22"
                                                        class="modal-title font-weight-bold">
                                                        Document </h4>
                                                    <button aria-label="Close"
                                                            class="close"
                                                            data-dismiss="modal"
                                                            type="button">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <form
                                                    class="form form-horizontal">
                                                    <li v-for="errorse in errorses" class="error">{{ errorse }}</li>
                                                    <div class="modal-body mb-1">
                                                        <div class="form-group py-0 my-0 mb-1">
                                                            <label>Title *</label>
                                                            <input id="title" v-model="form2.title"
                                                                   class="form-control" name="title" type="text">
                                                        </div>
                                                        <div class="form-group py-0 my-0 mb-1">
                                                            <label>File *</label>
                                                            <div class="custom-file">
                                                                <input id="file" class="custom-file-input" multiple
                                                                       name="file"
                                                                       type="file"
                                                                       @input="form2.file = $event.target.files"/>
                                                                <label class="custom-file-label" for="file">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group py-0 my-0">
                                                            <label>Description</label>
                                                            <textarea id="description" v-model="form2.description"
                                                                      class="form-control"
                                                                      name="description" placeholder="Textarea" rows="2"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="modal-hides"
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
                                                                type="button"
                                                                @click="docnew(form2.id)">
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
    props: ['orders', 'customers', 'errors', 'currencys', 'suppliers', 'products', 'statuses', 'invoiceItem', 'invoice', 'documents', 'routeName', 'routeId'],

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
            order_id: '',
            invoice_number: '',
            reference_number: '',
            invoice_date: '',
            customer_id: '',
            currency: '',
            sub_total: '',
            vat: '',
            total: '',
            status: '',
            balance: '',
            conversion_rate: '',
            invoiceItems: [],
            invoiceDocs: [],
            files: [],
        })
        return {form}
    },

    data() {
        return {
            form1: this.$inertia.form({
                id: '',
                invoice_id: '',
                product_id: '',
                currency: '',
                unit_price: '',
                quantity: '',
                total: '',
                invoiceItems: [],
                invoiceDocs:[]
            }),
            form2: this.$inertia.form({
                id: '',
                documentable_id: '',
                title: '',
                file: null,
                description: ''
            }),
            invoiceItems: this.invoiceItem ? this.invoiceItem : [],
            invoiceDocs: this.documents ? this.documents : [],
            files: [],
            errors: [],
            errorses:[],
            conversion_rate: false,
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Invoice";
        
        this.form.invoiceItems = this.invoiceItem
        this.form.invoiceDocs = this.documents
        if (this.invoice) {
            this.update = true;
            let data = this.invoice;
            Object.assign(data, {
                'invoiceItems': [],
                'invoiceDocs': [],
                route_name: '',
                route_id: '',
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        send() {
            if (this.update) {
               this.form.invoiceItems = this.invoiceItems
                this.form.invoiceDocs = this.invoiceDocs
                if(this.routeName) {
                    this.form.route_name = this.routeName
                    this.form.route_id = this.routeId
                }
                this.form.post(route('customer.invoices.update', this.invoice.id))
            } else {
                this.form.invoiceItems = this.invoiceItems
                this.form.invoiceDocs = this.invoiceDocs
                this.form.files = this.files
                this.form.post('/erp/invoices')
            }
        },

        create(id) {
            if (!this.form1.product_id) {
                this.errors = [],
                this.errors.push('Product required.');
                 event.stopPropagation();
            } 
             else if (!this.form1.currency) {
                 this.errors = [],
                this.errors.push('currency required.');
                 event.stopPropagation();
            } else if (!this.form1.unit_price) {
                this.errors = [],
                this.errors.push('Unit Price required.');
                event.stopPropagation();
            }
             else if (!this.form1.quantity) {
                 this.errors = [],
                this.errors.push('Quantity required.');
                 event.stopPropagation();
            } else if (!this.form1.total) {
                this.errors = [],
                this.errors.push('Total required.');
                event.stopPropagation();
            } else {
            var product_name = this.products.find(product => product.id === this.form1.product_id);
            var currency = this.currencys.find(currency => currency.id === this.form1.currency);
            if (id) {
                let index = 0;
                this.invoiceItems.find((invoiceItem, ind) => {
                        index = ind;
                        return invoiceItem.id === id
                    }
                );
                this.invoiceItems[index].product_id = this.form1.product_id;
                this.invoiceItems[index].product_name = product_name.name;
                this.invoiceItems[index].currency = this.form1.currency;
                this.invoiceItems[index].currency_from_to = currency.from_to;
                this.invoiceItems[index].unit_price = this.form1.unit_price;
                this.invoiceItems[index].quantity = this.form1.quantity;
                this.invoiceItems[index].total = this.form1.total;
            } else {
                let obj = {};
                obj.id = Math.random().toString(36).substr(2, 9);
                obj.product_id = this.form1.product_id;
                obj.product_name = product_name.name;
                obj.currency = this.form1.currency;
                obj.currency_from_to = currency.from_to;
                obj.unit_price = this.form1.unit_price;
                obj.quantity = this.form1.quantity;
                obj.total = this.form1.total;
                this.invoiceItems.push(obj);
            }

            var total = 0;
            this.invoiceItems.forEach(element => {
                total += parseFloat(element.total);
            });
            this.form.sub_total = total
            if (this.form.vat) {
                this.form.total = (parseFloat(this.form.sub_total) + parseFloat(this.form.vat)).toFixed(2);
                this.form.balance = this.form.total;
            }
            }
        },
        docnew(id) {
             if (!this.form2.title) {
                this.errorses = [],
                this.errorses.push('Title required.');
                 event.stopPropagation();
            } 
             else if (!this.form2.file) {
                 this.errorses = [],
                this.errorses.push('file required.');
                 event.stopPropagation();
            } else {
            if (id) {
                let invoice_docs = this.invoiceDocs.find(invoiceDoc => invoiceDoc.id == id);
                let file = {};
                file = this.form2.file
                this.files = file
                invoice_docs.title = this.form2.title;
                invoice_docs.files = this.files?this.files:invoice_docs.files;
                invoice_docs.file = this.files?this.files:invoice_docs.files;
                invoice_docs.description = this.form2.description;
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
                this.invoiceDocs.push(doc)
            }
          }
        },
        totalAmount() {
            this.form1.total = this.form1.unit_price * this.form1.quantity
        },

        Amount() {
            if (this.form1.quantity) {
                this.form1.total = this.form1.unit_price * this.form1.quantity
            }
        },
        total() {
            this.form.total = (parseFloat(this.form.sub_total) + parseFloat(this.form.vat)).toFixed(2);
            this.form.balance = this.form.total;
        },
        getExchangeRate() {
            var currency = this.currencys.find(currency => currency.id == this.form.currency);
            this.form.conversion_rate = currency.amount;
        },
        addInvoiceItem() {
            this.form1 = this.$inertia.form({
                id: '',
                product_id: '',
                currency: '',
                unit_price: '',
                quantity: '',
                total: '',
            });
        },
        addInvoiceDocs() {
            this.form2 = this.$inertia.form({
                title: '',
                file: null,
                description: '',
            });
        },
        deleteInvoiceItem(id) {
            let invoice_item = this.invoiceItems.find(invoiceItem => invoiceItem.id == id);
            if (!invoice_item.invoice_id) {
                this.invoiceItems = this.invoiceItems.filter(function (item) {
                    return item.id != id;
                });
            } else {
                this.invoiceItems = this.invoiceItems.filter(function (item) {
                    return item.id != id;
                });
                this.form.delete(route('invoice.item.delete', invoice_item.id))
            }

            var total = 0;
            this.invoiceItems.forEach(element => {
                total += parseFloat(element.total);
            });
            this.form.sub_total = total
            if (this.form.vat) {
                this.form.total = (parseFloat(this.form.sub_total) + parseFloat(this.form.vat)).toFixed(2);
                this.form.balance = this.form.total;
            }
        },
        deleteInvoiceDoc(id) {
            let invoice_doc = this.invoiceDocs.find(invoice_doc => invoice_doc.id == id);
            if (!invoice_doc.documentable_id) {
                this.invoiceDocs = this.invoiceDocs.filter(function (item) {
                    return item.id !== id;
                });
            } else {
                this.invoiceDocs = this.invoiceDocs.filter(function (item) {
                    return item.id !== id;
                });
                this.form.delete(route('invoice.doc.delete', invoice_doc.id))
            }
        },
        editInvoiceDocs(id) {
            let invoice_docs = this.invoiceDocs.find(invoiceDoc => invoiceDoc.id == id);
            this.form2 = this.$inertia.form({
                id: invoice_docs.id,
                title: invoice_docs.title,
                file: invoice_docs.file,
                description: invoice_docs.description,
            });
        },
        editInvoiceItem(id) {
            let invoice_item = this.invoiceItems.find(invoiceItem => invoiceItem.id === id);
            this.form1 = this.$inertia.form({
                id: invoice_item.id,
                product_id: invoice_item.product_id,
                currency: invoice_item.currency,
                unit_price: invoice_item.unit_price,
                quantity: invoice_item.quantity,
                total: invoice_item.total,
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

.img {
    height: 100px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.error {
    margin-left: 20px;
    color: red  !important;
}


</style>
