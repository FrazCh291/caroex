<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card-header p-0">
                            <h4 class="card-title" v-if="deals">Edit Deal</h4>
                            <h4 class="card-title" v-else>Add Deal</h4>
                        </div>
                        <form @submit.prevent="submit" class="form form-horizontal">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body pb-0">
                                        <div class="form-body">
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Channel Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select
                                                        class="form-select"
                                                        v-model="form.channel_name"
                                                        name="channel_name"
                                                        v-if="channelTitles?.length > 0"
                                                    >
                                                        <option></option>
                                                        <option
                                                            v-for="channelTitle in channelTitles"
                                                            :value="channelTitle.name"
                                                        >
                                                            {{ channelTitle.name }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="channel_name"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Deal# *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="deal_number"
                                                        v-model="form.deal_number"
                                                        class="form-control"
                                                        name="deal_number"
                                                    />
                                                    <ErrorComponent input="deal_number"></ErrorComponent>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Contract Signed Date *</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input
                                                    type="date"
                                                    id="contract_signed_at"
                                                    v-model="form.contract_signed_at"
                                                    class="form-control"
                                                    name="contract_signed_at"
                                                />
                                                <ErrorComponent
                                                    input="contract_signed_at"
                                                ></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <li v-for="(error, key) in errors" class="error">
                                                {{ error }}
                                            </li>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body p-0">
                                        <div class="row py-0 my-0">
                                            <div id="table-hover-row" class="row col-12 pr-0 ng-repeat-start">
                                                <div class="col-12 pr-0">
                                                    <div class="card pr-0 pb-0 mb-1 border-0"
                                                         style="margin-bottom: 0!important;">
                                                        <div
                                                            class="card-header border-bottom font-weight-bold text-dark">
                                                            Items
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="product-name">Product</th>
                                                                        <th class="text-left">Product Title</th>
                                                                        <th class="">Product Code</th>
                                                                        <th class="text-center">Link</th>
                                                                        <th class="text-right actionTd">
                                                                            <span
                                                                                class="d-inline-flex align-items-center bg-white"
                                                                                data-target="#addItem"
                                                                                data-toggle="modal"
                                                                                @click="addDealItem()">
                                                                              <span
                                                                                  class="badge-circle-others badge-circle-light-secondary bg-white">
                                                                                <i class="bx bx-plus pt-0 default float-right add-btn font-large-1"></i>
                                                                              </span>
                                                                            </span>
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr v-for="item in this.dealItems"
                                                                        class="py-0 my-0">
                                                                        <td class="py-0 my-0">
                                                                            <div class="row">
                                                                                <div class="col-9 py-1 pl-1 px-0 mx-0">
                                                                                    {{
                                                                                        item.product_name
                                                                                            ? item.product_name
                                                                                            : item.product
                                                                                            ? item.product.name : ""
                                                                                    }}
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-left">
                                                                            {{ item.product_title }}
                                                                        </td>
                                                                        <td class="">
                                                                            {{ item.product_code }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ item.link }}
                                                                        </td>
                                                                        <td class="text-right">
                                                                        <div class="dropdown">
                                                                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                        </span>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" data-target="#addItem" data-toggle="modal" v-on:click="editDealItem(item.id)"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                                                                        <a class="dropdown-item" v-on:click="deleteDealProduct(item.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body p-0">
                                        <div class="custom-spacing">
                                            <div class="alert alert-danger" role="alert" v-if="this.stop == false">
                                                Product Rate is missing
                                            </div>
                                            <div class="row py-0 my-0">
                                                <div class="row col-12 pr-0 ng-repeat-start">
                                                    <div class="col-12 pr-0">
                                                        <div class="card pr-0 pb-0 mb-1 border-0"
                                                             style="margin-bottom: 0!important;">
                                                            <div
                                                                class="card-header border-bottom font-weight-bold text-dark">
                                                                Rates
                                                            </div>
                                                            <div class="card-content">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover truncate mb-0">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="product-name">Product</th>
                                                                            <th class="">Deal Price</th>
                                                                            <th class="text-left">
                                                                                Plateform Fee%
                                                                            </th>
                                                                            <th class="">Deal Cap</th>
                                                                            <th class="">Start Date</th>
                                                                            <th class="text-right actionTd">
                                                                                <span
                                                                                    class="d-inline-flex align-items-center bg-white"
                                                                                    data-target="#addItemRates"
                                                                                    data-toggle="modal"
                                                                                    @click="addDealItemRate()">
                                                                                  <span
                                                                                      class="badge-circle-others badge-circle-light-secondary bg-white">
                                                                                    <i class="bx bx-plus pt-0 default float-right add-btn font-large-1"></i>
                                                                                  </span>
                                                                                </span>
                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr v-for="rate in this.dealItemsRate"
                                                                            class="py-0 my-0">
                                                                            <td class="py-0 my-0"
                                                                                @mouseout="hideTooltip(rate.id)">
                                                                                <div class="row">
                                                                                    <div class="col-9 py-1">
                                                                                        {{
                                                                                            rate.dealProduct
                                                                                                ? rate.dealProduct
                                                                                                : rate.product_name
                                                                                                ? rate.product_name.name
                                                                                                : ""
                                                                                        }}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>{{
                                                                                    rate.deal_price
                                                                                }}
                                                                            </td>
                                                                            <td class="text-truncate">
                                                                                {{ rate.plateform_fee }}
                                                                            </td>
                                                                            <td class="text-truncate">
                                                                                {{ rate.deal_cap }}
                                                                            </td>
                                                                            <td>{{
                                                                                    formatDate(rate.start_date)
                                                                                }}
                                                                            </td>
                                                                            <td class="text-right">
                                                                            <span
                                                                                class="
                                                                                d-inline-flex
                                                                                align-items-center"
                                                                                data-target="#addItemRates"
                                                                                data-toggle="modal"
                                                                                v-on:click="editDealItemRate(rate.id)">
                                                                              <span
                                                                                  class="
                                                                                  badge-circle
                                                                                  badge-circle-light-secondary">
                                                                                <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                                                              </span>
                                                                            </span>
                                                                                <span
                                                                                    class="d-inline-flex align-items-center ml-0.5"
                                                                                    v-on:click="deleteDealItemRate(rate.id)">
                                                                              <span
                                                                                  class="badge-circle badge-circle-light-secondary">
                                                                                <i class="
                                                                                    bx bx-trash
                                                                                    font-medium-1
                                                                                    text-center">
                                                                                </i>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body p-0">
                                        <div class="row py-0 my-0">
                                            <div id="table-hover-row" class="row col-12 pr-0 ng-repeat-start">
                                                <div class="col-12 pr-0">
                                                    <div class="card pr-0 pb-0 mb-1 border-0"
                                                         style="margin-bottom: 0!important;">
                                                        <div
                                                            class="card-header border-bottom font-weight-bold text-dark">
                                                            Documents
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="product-name">Title</th>
                                                                        <th class="text-left">Name</th>
                                                                        <th class="text-right actionTd">
                                                                            <span
                                                                                class="d-inline-flex align-items-center"
                                                                                data-target="#addDocuments"
                                                                                data-toggle="modal"
                                                                                @click="addDealDocument()">
                                                                              <span
                                                                                  class="badge-circle-others badge-circle-light-secondary bg-white">
                                                                                <i class="bx bx-plus pt-0 default float-right add-btn font-large-1"></i>
                                                                              </span>
                                                                            </span>
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr v-for="doc in this.dealDocs"
                                                                        class="py-0 my-0">
                                                                        <td class="py-0 my-0">
                                                                            <div class="row">
                                                                                <div class="col-9">
                                                                                    {{ doc.title }}
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-left">
                                                                            {{ doc.file }}
                                                                        </td>
                                                                        <td class="text-right">
                                                                    <div class="dropdown">
                                                                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                    </span>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item"  data-target="#addDocuments" data-toggle="modal" v-on:click="editDealDoc(doc.id)"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                                    <a class="dropdown-item" v-on:click="deleteDealDoc(doc.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-11 d-flex justify-content-start px-0 mt-2">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                    Save
                                </button>
                                <inertia-link
                                    :href="route('deals.index')"
                                    type="button"
                                    class="btn btn-light-secondary mr-1 mb-1">
                                    Back
                                </inertia-link>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <!-- Deal Products Modal -->
        <div
            id="addItem"
            aria-hidden="true"
            aria-labelledby="myModalLabel33"
            class="modal fade text-left"
            role="dialog"
            tabindex="-1">
            <div
                class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Deal Product Items</h4>
                        <button
                            aria-label="Close"
                            class="close"
                            data-dismiss="modal"
                            type="button">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form class="form form-horizontal">
                        <div class="modal-body mb-1">
                            <li v-for="errorse in errorses" class="error">{{ errorse }}</li>
                            <div class="form-group py-0 my-0 mb-1">
                                <label>Product</label>
                                <div class="col-md-12 form-group ml-0 pl-0">
                                    <select
                                        class="form-select"
                                        v-model="form1.product_id"
                                        name="product_id"
                                        required="required">
                                        <option value="">Select Item Name</option>
                                        <option v-for="product in products" :value="product.id">
                                            {{ product.name + " " + "(" + product.sku + ")" }}
                                        </option>
                                    </select>
                                    <ErrorComponent input="product_id"></ErrorComponent>
                                </div>
                            </div>
                            <div class="form-group py-0 my-0">
                                <label>Product Title *</label>
                                <input
                                    id="product_title"
                                    v-model="form1.product_title"
                                    class="form-control"
                                    name="product_title"
                                    placeholder="Enter product title"
                                    type="text"
                                    required="required"
                                />
                            </div>
                            <div class="form-group py-0 my-0 pt-1">
                                <label>Product Code</label>
                                <input
                                    id="product_code"
                                    v-model="form1.product_code"
                                    class="form-control"
                                    name="product_code"
                                    type="text"
                                    required="required"/>
                            </div>
                            <div class="form-group py-0 my-0 pt-1">
                                <label>Link</label>
                                <input
                                    id="link"
                                    v-model="form1.link"
                                    class="form-control"
                                    name="link"
                                    type="url"
                                    placeholder="www.xyz.com"
                                    @input="urlChange($event)"
                                    @change="urlChange($event)"
                                    required="required"
                                />
                            </div>
                            <div class="error" v-if="!isValidUrl">
                                Use @ in the link
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                id="modal-hide"
                                class="btn btn-light-secondary"
                                data-dismiss="modal"
                                type="button">
                                <i ref="closeModall" class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button
                                class="btn btn-primary ml-1"
                                data-dismiss="modal"
                                type="button"
                                @click="create(form1.id)">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Add</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Deal Products Rate Modal -->
        <div id="addItemRates" aria-hidden="true" aria-labelledby="myModalLabel33" class="modal fade text-left"
             role="dialog" tabindex="-1">
            <div
                class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="myModalLabel33" class="modal-title font-weight-bold">
                            Deal Product Items
                        </h4>
                        <button
                            aria-label="Close"
                            class="close"
                            data-dismiss="modal"
                            type="button">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form class="form form-horizontal">
                        <div class="modal-body mb-1" id="modal-body-sec">
                            <li v-for="rate in errorItem" class="error">{{ rate }}</li>
                            <div class="form-group py-0 my-0 mb-1">
                                <label>Product</label>
                                <div class="col-md-12 form-group ml-0 pl-0">
                                    <select
                                        class="form-select"
                                        v-model="form2.product_id"
                                        name="product_id">
                                        <option value="">Select Item Name</option>
                                        <option
                                            v-for="dealItem in this.dealItems"
                                            :value="dealItem.product_id">
                                            {{ dealItem.product_name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group py-0 my-0 mb-1">
                                <label>Deal Price*</label>
                                <div class="col-md-12 form-group p-0">
                                    <div class="col-md-12 form-group pl-0">
                                        <input
                                            type="text"
                                            id="deal_price"
                                            v-model="form2.deal_price"
                                            class="form-control"
                                            name="deal_price"
                                            required
                                            @input="change($event)"
                                            @change="change($event)"
                                        />
                                        <div class="error" v-if="!isValidDealPrice">
                                            Invalid Deal Price
                                        </div>
                                    </div>
                                    <ErrorComponent input="deal_price"></ErrorComponent>
                                </div>
                            </div>
                            <div class="form-group py-0 my-0 mb-1">
                                <label>Deal Cap</label>
                                <div class="col-md-12 form-group p-0">
                                    <div class="col-md-12 form-group pl-0">
                                        <input
                                            type="text"
                                            id="deal_cap"
                                            v-model="form2.deal_cap"
                                            class="form-control"
                                            name="deal_cap"
                                            required
                                        />
                                    </div>
                                    <ErrorComponent input="deal_cap"></ErrorComponent>
                                </div>
                            </div>
                            <div class="form-group py-0 my-0">
                                <label>Plateform Fee *</label>
                                <div class="col-md-12 form-group ml-0 pl-0">
                                    <input
                                        type="text"
                                        id="plateform_fee"
                                        v-model="form2.plateform_fee"
                                        class="form-control"
                                        name="plateform_fee"
                                        @input="changeFee($event)"
                                        @change="changeFee($event)"
                                        required
                                    />
                                    <div class="error" v-if="!isValidDealFee">
                                        Invalid Plateform Fee
                                    </div>
                                    <ErrorComponent input="plateform_fee"></ErrorComponent>
                                </div>
                            </div>
                            <div class="form-group py-0 my-0">
                                <label>Standard Postage *</label>
                                <div class="col-md-12 form-group ml-0 pl-0">
                                    <input
                                        type="text"
                                        id="standard_postage"
                                        v-model="form2.standard_postage"
                                        class="form-control"
                                        name="standard_postage"
                                        @input="changeVat($event)"
                                        @change="changeVat($event)"
                                        required
                                    />
                                    <div class="error" v-if="!isValidDealVat">
                                        Invalid Deal VAT
                                    </div>
                                    <ErrorComponent input="standard_postage"></ErrorComponent>
                                </div>
                            </div>
                            <div class="form-group py-0 my-0">
                                <label>Highlands Postage</label>
                                <div class="col-md-12 form-group ml-0 pl-0">
                                    <input
                                        type="text"
                                        id="highlands_postage"
                                        v-model="form2.highlands_postage"
                                        class="form-control"
                                        name="highlands_postage"
                                        required
                                    />
                                    <ErrorComponent input="highlands_postage"></ErrorComponent>
                                </div>
                            </div>
                            <div class="form-group py-0 my-0">
                                <label>Market Fee Percentage Rate</label>
                                <div class="col-md-12 form-group ml-0 pl-0">
                                    <input
                                        type="text"
                                        id="market_fee_percentage_rate"
                                        v-model="form2.market_fee_percentage_rate"
                                        class="form-control"
                                        name="market_fee_percentage_rate"
                                        required
                                    />
                                    <ErrorComponent input="market_fee_percentage_rate"></ErrorComponent>
                                </div>
                            </div>
                            <div class="form-group py-0 my-0">
                                <label>Standard Incremental Unit Fee</label>
                                <div class="col-md-12 form-group ml-0 pl-0">
                                    <input
                                        type="text"
                                        id="standard_incremental_unit_fee"
                                        v-model="form2.standard_incremental_unit_fee"
                                        class="form-control"
                                        name="standard_incremental_unit_fee"
                                        required
                                    />
                                    <ErrorComponent input="market_fee_percentage_rate"></ErrorComponent>
                                </div>
                            </div>
                            <div class="form-group py-0 my-0">
                                <label>Start Date*</label>
                                <div class="col-md-12 form-group ml-0 pl-0">
                                    <input
                                        type="date"
                                        id="start_date"
                                        v-model="form2.start_date"
                                        class="form-control"
                                        name="start_date"
                                        required
                                    />
                                    <ErrorComponent input="start_date"></ErrorComponent>
                                </div>
                            </div>
                            <div class="form-group py-0 my-0">
                                <label>End Date</label>
                                <div class="col-md-12 form-group ml-0 pl-0">
                                    <input
                                        type="date"
                                        id="end_date"
                                        v-model="form2.end_date"
                                        class="form-control"
                                        name="end_date"
                                        required
                                    />
                                    <ErrorComponent input="end_date"></ErrorComponent>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                id="modal-hide"
                                class="btn btn-light-secondary"
                                data-dismiss="modal"
                                type="button">
                                <i ref="closeModall" class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button
                                class="btn btn-primary ml-1"
                                data-dismiss="modal"
                                type="button"
                                @click="createRate(form2.id)">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Add</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Deal Documents Modal -->
        <div
            id="addDocuments"
            aria-hidden="true"
            aria-labelledby="myModalLabel313"
            class="modal fade text-left"
            role="dialog"
            tabindex="-1">
            <div
                class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Deal Documents</h4>
                        <button
                            aria-label="Close"
                            class="close"
                            data-dismiss="modal"
                            type="button"
                        >
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form class="form form-horizontal">
                        <div class="modal-body mb-1">
                            <li v-for="docErro in docError" class="error">{{ docErro }}</li>
                            <div class="form-group py-0 my-0">
                                <label>Title*</label>
                                <div class="col-md-12 form-group pl-0 ml-0">
                                    <input
                                        type="text"
                                        id="title"
                                        class="form-control"
                                        name="title"
                                        v-model="form3.title"
                                    />
                                    <ErrorComponent input="title"></ErrorComponent>
                                </div>
                            </div>

                            <div class="form-group py-0 my-0">
                                <label>Upload File*</label>
                                <div class="col-md-12 form-group pl-0 ml-0">
                                    <input type="file" id="file" name="file" multiple
                                           @input="form3.file = $event.target.files">
                                    <ErrorComponent input="file"></ErrorComponent>
                                </div>
                            </div>

                            <div class="form-group py-0 my-0">
                                <label>Description</label>
                                <div class="col-md-12 form-group pl-0 ml-0 mr-0 pr-0">
                                  <textarea
                                      class="form-control"
                                      id="description"
                                      name="description"
                                      v-model="form3.description"
                                      rows="3"
                                      placeholder="Add Description"
                                  >
                                  </textarea>
                                    <ErrorComponent input="description"></ErrorComponent>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                id="modal-hide"
                                class="btn btn-light-secondary"
                                data-dismiss="modal"
                                type="button"
                            >
                                <i ref="closeModall" class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button
                                class="btn btn-primary ml-1"
                                data-dismiss="modal"
                                type="button"
                                @click="createDocuments(form3.id)"
                            >
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Add</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </admin-layout>
</template>
<script>
import AdminLayout from "../../Layouts/AdminLayout";
import Label from "../../Jetstream/Label";
import JetInputError from "./../../Jetstream/InputError";
import {useForm} from "@inertiajs/inertia-vue3";
import ErrorComponent from "../../components/ErrorComponent";
import moment from "moment";

export default {
    name: "Create",
    props: ["deals", "errors", "productTitles", "channelTitles", "products"],

    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            deal_type: "",
            contract_signed_at: "",
            deal_number: "",
            channel_name: "",
            highlands_postage: "",
            email: "",
            plateform_fee: "",
            address: "",
            account_manager: "",
            category: "",
            subcategory: "",
            gross_revenue: "",
            redeemed_units: "",
            refunded_units: "",
            refund_rate: "",
            auv: "",
            signed_by_supplier_name: "",
            signed_by_customer_name: "",
            start_date: "",
            end_date: "",
            deal_title: "",
            dealItems: [],
            dealItemsRate: [],
            dealDocs: [],
            file: null,
            validatare: "",
        });
        return {form};
    },
    data() {
        return {
            form1: this.$inertia.form({
                id: "",
                product_id: "",
                product_title: "",
                product_code: "",
                sku: "",
            }),
            form2: this.$inertia.form({
                id: "",
                deal_price: "",
                plateform_fee: "",
                highlands_postage: "",
                standard_postage: "",
                standard_incremental_unit_fee: "",
                market_fee_percentage_rate: "",
                deal_cap: "",
                start_date: "",
                end_date: "",
            }),
            form3: this.$inertia.form({
                id: "",
                title: "",
                description: "",
                file: null,
            }),
            errorses: [],
            errorItem: [],
            dealDocs: this.documents ? this.documents : [],
            dealItems: this.deals ? this.deals.deal_products : [],
            dealItemsRate: this.deals ? this.deals.deal_product_rates : [],
            required: false,
            validatare: "",
            stop: true,
            isValidDealPrice: true,
            isValidUrl: true,
            isValidDealCap: true,
            isValidDealFee: true,
            isValidDealVat: true,
            isValidMarketFee: true,
            isValidHightlandPostage: true,
            isValidStandardIncrementalUnitFee: true,
            hasError: false,
            regexForNum: /^[0-9]*$/,
            regex: /^(\d+(\.\d+)?)$/,
            urlRegex: /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/,
        };
    },

    beforeMount() {
        if (this.deals) {
            document.title = process.env.MIX_APP_NAME + " - Edit Deal";
            // this.form.deal_cap = this.dealItemsRate.deal_cap;
        } else {
            document.title = process.env.MIX_APP_NAME + " - Add Deal";
        }
        if (this.deals) {
            this.update = true;
            let data = this.deals;
            Object.assign(data, {
                _method: "PUT",
            });
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        create(id) {
            if (!this.form1.product_id) {
                this.errorses = [];
                event.stopPropagation();
                this.errorses.push("Product Name is required.");
            } else if (!this.form1.product_title) {
                this.errorses = [];
                this.errorses.push("Title is required.");
                event.stopPropagation();
            } else {
                var product_name = this.products.find(
                    (product) => product.id === this.form1.product_id
                );
                if (id) {
                    var deal_item = this.dealItems.find((dealItem) => dealItem.id === id);
                    deal_item.product_id = this.form1.product_id;
                    deal_item.product_name = product_name.name;
                    deal_item.product_title = this.form1.product_title;
                    deal_item.product_code = this.form1.product_code;
                    deal_item.link = this.form1.link;
                } else {
                    let obj = {};
                    obj.id = Math.random().toString(36).substr(2, 9);
                    obj.product_id = this.form1.product_id;
                    obj.product_name = product_name.name;
                    obj.product_title = this.form1.product_title;
                    obj.product_code = this.form1.product_code;
                    obj.link = this.form1.link;
                    this.dealItems.push(obj);
                }
            }
        },

        createDocuments(id) {
            if (!this.form3.title) {
                this.docError = [];
                this.docError.push("Title is required.");
                event.stopPropagation();
            } else if (!this.form3.file) {
                this.docError = [];
                this.docError.push("Document is required.");
                event.stopPropagation();
            } else {
                if (id) {
                    let deal_docs = this.dealDocs.find(dealDoc => dealDoc.id == id);
                    let file = {};
                    file = this.form3.file
                    this.files = file
                    deal_docs.title = this.form3.title;
                    deal_docs.files = this.files ? this.files : deal_docs.files;
                    deal_docs.file = this.files ? this.files : deal_docs.files;
                    deal_docs.description = this.form3.description;
                } else {
                    let doc = {};
                    let file = {};
                    doc.id = Math.random().toString(36).substr(2, 9)
                    doc.title = this.form3.title
                    file = this.form3.file
                    this.files = file
                    doc.files = this.files
                    doc.file = this.files[0].name
                    doc.description = this.form3.description
                    this.dealDocs.push(doc);
                }
            }
        },

        addDealItem() {
            this.errorses = [];
            this.errorItem = [];
            this.form1 = this.$inertia.form({
                product_id: "",
                product_title: "",
                link: "",
                product_code: "",
                sku: "",
            });
        },

        addDealDocument() {
            this.errorses = [];
            this.errorItem = [];
            this.form3 = this.$inertia.form({
                title: "",
                file: "",
                description: "",
            });
        },

        editDealItem(id) {
            this.errorses = [];
            this.errorItem = [];
            var deal_item = this.dealItems.find((dealItem) => dealItem.id === id);
            this.form1 = this.$inertia.form({
                id: deal_item.id,
                product_id: deal_item.product_id,
                product_title: deal_item.product_title,
                product_code: deal_item.product_code,
            });
        },

        editDealDoc(id) {
            let deal_docs = this.dealDocs.find(dealDoc => dealDoc.id == id);
            this.form3 = this.$inertia.form({
                id: deal_docs.id,
                title: deal_docs.title,
                file: deal_docs.files,
                description: deal_docs.description,
            });
        },

        deleteDealProduct(id) {
            let deal_item = this.dealItems.find((deal_item) => deal_item.id == id);
            if (!deal_item.deal_id) {
                this.dealItems = this.dealItems.filter(function (item) {
                    return item.id !== id;
                });
            } else {
                this.dealItems = this.dealItems.filter(function (item) {
                    return item.id !== id;
                });
                this.form.delete(route("deal.product.delete", deal_item.id));
            }
        },

        deleteDealDoc(id) {
            let deal_docs = this.dealDocs.find(deal_docs => deal_docs.id == id);
            if (!deal_docs.documentable_id) {
                this.dealDocs = this.dealDocs.filter(function (item) {
                    return item.id !== id;
                });
            } else {
                this.dealDocs = this.dealDocs.filter(function (item) {
                    return item.id !== id;
                });
                this.form.delete(route('invoice.doc.delete', deal_docs.id))
            }
        },
        createRate(id) {
            this.errorses = [];
            this.errorItem = [];
            if (!this.form2.product_id || this.isValidDealPrice == false) {
                this.errorItem.push("Deal Product is required.");
                event.stopPropagation();
            } else if (!this.form2.deal_price || this.isValidDealPrice == false) {
                this.errorItem.push("Deal Price is required.");
                event.stopPropagation();
            } else if (!this.form2.plateform_fee || this.isValidDealFee == false) {
                this.errorItem.push("Plateform Fee is required.");
                event.stopPropagation();
            } else if (!this.form2.start_date) {
                this.errorItem.push("Deal Start Date is required.");
                event.stopPropagation();
            } else {
                var product_name = this.products.find(
                    (product) => product.id === this.form2.product_id
                );
                if (id) {
                    var deal_item_rate = this.dealItemsRate.find(
                        (dealItemRate) => dealItemRate.id === id
                    );
                    deal_item_rate.deal_price = this.form2.deal_price;
                    deal_item_rate.deal_product_id = this.form2.product_id;
                    deal_item_rate.product_name = product_name.name;
                    deal_item_rate.plateform_fee = this.form2.plateform_fee;
                    deal_item_rate.standard_postage = this.form2.standard_postage;
                    deal_item_rate.highlands_postage = this.form2.highlands_postage;
                    deal_item_rate.market_fee_percentage_rate = this.form2.market_fee_percentage_rate;
                    deal_item_rate.standard_incremental_unit_fee = this.form2.standard_incremental_unit_fee;
                    deal_item_rate.deal_cap = this.form2.deal_cap;
                    deal_item_rate.start_date = this.form2.start_date;
                    deal_item_rate.end_date = this.form2.end_date;
                } else {
                    let obj = {};
                    obj.id = Math.random().toString(36).substr(2, 9);
                    obj.deal_price = this.form2.deal_price;
                    obj.deal_product_id = this.form2.product_id;
                    obj.product_id = this.form2.product_id;
                    obj.dealProduct = product_name.name;
                    obj.plateform_fee = this.form2.plateform_fee;
                    obj.standard_postage = this.form2.standard_postage;
                    obj.highlands_postage = this.form2.highlands_postage;
                    obj.market_fee_percentage_rate = this.form2.market_fee_percentage_rate;
                    obj.standard_incremental_unit_fee = this.form2.standard_incremental_unit_fee;
                    obj.deal_cap = this.form2.deal_cap;
                    obj.start_date = this.form2.start_date;
                    obj.end_date = this.form2.end_date;
                    this.dealItemsRate.push(obj);
                }
            }
        },
        urlChange: function (e) {
            this.isValidUrl = this.urlRegex.test(e.target.value);
        },
        change: function (e) {
            this.isValidDealPrice = this.regex.test(e.target.value);
        },
        changeFee: function (e) {
            this.isValidDealFee = this.regex.test(e.target.value);
        },
        changeVat: function (e) {
            this.isValidDealVat = this.regex.test(e.target.value);
        },
        addDealItemRate() {
            this.errorses = [];
            this.errorItem = [];
            this.form2 = this.$inertia.form({
                deal_price: "",
                plateform_fee: "",
                highlands_postage: "",
                standard_postage: "",
                product_id: "",
                start_date: "",
                end_date: "",
            });
        },

        editDealItemRate(id) {
            this.errorses = [];
            this.errorItem = [];
            var deal_item_rate = this.dealItemsRate.find(
                (dealItemRate) => dealItemRate.id === id
            );
            this.form2 = this.$inertia.form({
                id: deal_item_rate.id,
                deal_price: deal_item_rate.deal_price,
                plateform_fee: deal_item_rate.plateform_fee,
                product_id: deal_item_rate.product_id,
                standard_postage: deal_item_rate.standard_postage,
                highlands_postage: deal_item_rate.highlands_postage,
                market_fee_percentage_rate: deal_item_rate.market_fee_percentage_rate,
                standard_incremental_unit_fee: deal_item_rate.standard_incremental_unit_fee,
                start_date: deal_item_rate.start_date,
                end_date: deal_item_rate.end_date,
            });
        },

        deleteDealItemRate(id) {
            let deal_item_rate = this.dealItemsRate.find(
                (deal_item) => deal_item.id == id
            );
            if (!deal_item_rate.deal_id) {
                this.dealItemsRate = this.dealItemsRate.filter(function (rate) {
                    return rate.id !== id;
                });
            } else {
                this.dealItemsRate = this.dealItemsRate.filter(function (rate) {
                    return rate.id !== id;
                });
                this.form.delete(route("invoice.doc.delete", deal_item.id));
            }
        },
        formatDate(date) {
            if (date) {
                return moment(date).format('DD/MM/YYYY')
            } else {
                return ''
            }
        },
        submit() {
            if (this.update) {
                this.form.post(route("deals.update", this.deals.id));
            } else {
                let validatare = false;
                this.dealItems.forEach((item) => {
                    validatare = false;
                    this.dealItemsRate.forEach((itemRate) => {
                        if (item["product_id"] == itemRate["product_id"]) {
                            validatare = true;
                        }
                    });
                    if (validatare) {
                        item.rate = true;
                    } else {
                        validatare = true;
                    }
                });
                this.dealItems.forEach((item) => {
                    if (!item.rate) {
                        this.stop = false;
                    } else {
                        this.stop = true;
                    }
                });

                if (this.stop == true) {
                    this.form.dealItems = this.dealItems;
                    this.form.dealItemsRate = this.dealItemsRate;
                    this.form.dealDocs = this.dealDocs;
                    this.form.post("/erp/deals", {
                        onSuccess: (page) => {
                            if (Object.keys(page.errors).length === 0) {
                                this.hasError = false;
                            }
                        },
                    });
                }
            }
            setTimeout(() => {
                this.stop = true;
            }, 2000);
        },

        selectFromParentComponent1() {
            this.item = this.options[0];
        },
    },
};
</script>

<style scoped>

.line {
    border-top: 1px dashed #c7cfd6;
    width: 100%;
}

.error {
    color: #dc2626;
    font-size: 11.5px;
    margin-bottom: 10px;
}

#modal-body-sec {
    height: 400px;
    overflow-y: auto !important;
}

</style>
