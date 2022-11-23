<template>
    <div>
        <admin-layout>
            <section class="invoice-view-wrapper">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-12 mt-1">
                        <div class="col form-group p-0 mt-1">
                            <h4>Deals/Show</h4>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-6 dashboard-users-success">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div
                                                class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                                <i class="bx bx-money font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Receivable</div>
                                            <h3 class="mb-0">£{{ (totalReceivable).toFixed(2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-6 dashboard-users-success">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div
                                                class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                                <i class="bx bx-receipt font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">invoiced</div>
                                            <h3 class="mb-0">{{ invoiced }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-6 dashboard-users-success">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div
                                                class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                                <i class="bx bx-money font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Paid</div>
                                            <h3 class="mb-0">£{{ (totalPaid).toFixed(2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-6 dashboard-users-danger">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div
                                                class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bx-money font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Balance</div>
                                            <h3 class="mb-0">£{{ (balance).toFixed(2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card invoice-print-area">
                            <div class="card-body pb-1">
                                <div class="row invoice-info pr-0 mr-0">
                                    <div class="col-sm-3 col-4">
                                        <div class="mb-0 title-col">Deal #: {{ (deals.deal_number) }}</div>
                                    </div>
                                    <div class="col-sm-3 col-4">
                                        <div class="mb-0">Channel: {{ deals.channel_name }}</div>
                                    </div>
                                    <div class="col-sm-3 col-4">
                                        <div class="mb-0">Contract Date: {{ deals.contract_signed_at }}</div>
                                    </div>
                                    <div class="col-sm-3 col-4">
                                        <div class="mb-0 float-right">
                                              <div class="dropdown">
                                            <span class="bx bx-dots-vertical-rounded dropdown-toggle font-medium-3 nav-hide-arrow cursor-pointer"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                            </span>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"  data-target="#addItem" data-toggle="modal" @click="addDealItem()"><i class="bx bx-plus mr-1"></i>Add Items</a>
                                                <a class="dropdown-item"  data-target="#addItemRates" data-toggle="modal" @click="addDealItemRate()"><i class="bx bx-plus mr-1"></i>Add Rates</a>
                                                <a :href="route('deal.document.create', deals.id)" class="dropdown-item"><i class="bx bx-plus mr-1"></i>Add Documents</a>
                                                <a class="dropdown-item"  data-target="#invoiceModal" data-toggle="modal"><i class="bx bx-plus mr-1"></i>Add Invoice</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-print-area">
                            <div class="card-body mx-25 pb-1">
                                <div class="row invoice-info pr-0 mr-0">
                                    <div class="col-lg-3 col-md-8 col-sm-3 col-9 ">
                                        <div class="mb-0 title-col ">

                                            <p class="text-truncate">Number of Orders </p>
                                        </div>
                                        <div class="mb-0 title-col text-truncate">
                                            <p class="padding-change text-truncate"> Total Unit Sold </p>
                                        </div>
                                        <div class="mb-0 title-col text-truncate ">
                                            <p class="padding-change text-truncate"> Sales</p>
                                        </div>
                                        <div class="mb-0 text-truncate">
                                            <p class="padding-change text-truncate">Postage</p>
                                        </div>
                                        <div class="mb-0 text-truncate">
                                            <p class="padding-change ">Commission </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-3 col-md-4 col-3 ">
                                        <div>
                                            <div class="mb-0 ">
                                                <p class="padding-change text-truncate ">{{ orderCount }}</p>
                                            </div>
                                            <div class="mb-0 ">
                                                <p class="padding-change text-truncate ">{{ orderQuantity }}</p>
                                            </div>
                                            <div class="mb-0 ">
                                                <p class="text-truncate">{{ totalCap }}</p>
                                            </div>
                                            <div class="mb-0 ">
                                                <p class="padding-change text-truncate ">£{{
                                                        (totalpostage).toFixed(2)
                                                    }}</p>
                                            </div>
                                            <div class="mb-0 ">
                                                <p class="padding-change text-truncate ">
                                                    £{{ (totalCommission).toFixed(2) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-8 col-sm-3 col-9">
                                        <p class="padding-change">Total Receivable</p>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Amount paid</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Amount due</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Uninvoiced</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-3 col-md-4 col-3">
                                        <div>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate">£{{
                                                        (totalReceivable).toFixed(2)
                                                    }}</p>
                                            </div>
                                            <div class="mb-0">
                                            </div>
                                            <p class="padding-change text-truncate">£{{ (totalPaid).toFixed(2) }}</p>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate">£{{ (balance).toFixed(2) }}</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate">{{ unInvoiced }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" v-if="this.dealItems.length>0">
                        <div class="row py-0 my-0">
                            <div id="table-hover-row" class="row col-12 pr-0 ng-repeat-start">
                                <div class="col-12 pr-0">
                                    <div class="card pr-0 pb-0 mb-1">
                                        <div class="card-header border-bottom font-weight-bold text-dark">Items</div>
                                        <div class="card-content">
                                            <div class="table-responsive">
                                                <table class="table table-hover truncate mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th class="product-name">Product</th>
                                                        <th class="text-left">Product Title</th>
                                                        <th class="text-right">Product Code</th>
                                                        <th class="text-right">Link</th>
                                                        <th class="text-right actionTd">
                                                            <span class="d-inline-flex align-items-center bg-white"
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
                                                    <tr v-for="item in this.dealItems" class="py-0 my-0">
                                                        <td class="py-0 my-0">
                                                            <div class="row">
                                                                <div class="col-2 pr-0 mr-0">
                                                                    <img class="rounded-circle product-image img-thumbnail"
                                                                         width="35" height="40" :src="item.image
                                                                    ? '/'+item.image
                                                                    : (item.product
                                                                        ? '/'+item.product.image
                                                                        : '')">
                                                                </div>
                                                                <div class="col-9 py-1 px-0 mx-0">
                                                                    {{
                                                                        item.product_name
                                                                            ? item.product_name
                                                                            : item.product
                                                                            ? item.product.name
                                                                            : ""
                                                                    }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left">
                                                            {{ item.product_title }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ item.product_code }}
                                                        </td>
                                                        <td class="text-right" v-if="item.link != null">
                                                            <a :href="'https://'+item.link" target="_blank">
                                                                <i class="bx bx-link font-medium-3 align-items-center text-center"></i>
                                                            </a>
                                                        </td>
                                                        <td v-else></td>

                                                                <td class="text-right py-0 my-0">

                                                                    <div class="dropdown">
                                                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                        </span>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"  data-target="#showItem" data-toggle="modal" v-on:click="showDealItem(item.id)"><i class="bx bx-show mr-1"></i>Show</a>
                                                        <a class="dropdown-item" data-target="#addItem" data-toggle="modal" v-on:click="editDealItem(item.id)"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                        <a class="dropdown-item" v-on:click="deleteDealProduct(item.id)"><i class="bx bx-trash mr-1"></i> delete</a>
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
                        <div class="custom-spacing" v-if="this.dealItemsRate.length>0">
                            <div class="alert alert-danger" role="alert" v-if="this.stop == false">
                                Product Rate is missing
                            </div>
                            <div class="row py-0 my-0">
                                <div class="row col-12 pr-0 ng-repeat-start">
                                    <div class="col-12 pr-0">
                                        <div class="card pr-0 pb-0 mb-1">
                                            <div class="card-header border-bottom font-weight-bold text-dark">Rates</div>
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
                                                            <th class="text-left">Deal Capacity</th>
                                                            <th class="text-center">Start Date</th>
                                                            <th class="text-center">End Date</th>
                                                            <th class="text-truncate text-center">No of Orders</th>
                                                            <th class="text-center">Primary</th>
                                                            <th class="text-center">Active</th>
                                                            <th class="text-right actionTd">
                                                            <span class="d-inline-flex align-items-center bg-white"
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
                                                        <tr
                                                            v-for="rate in this.dealItemsRate"
                                                            class="py-0 my-0">
                                                            <td class="py-0 my-0" @mouseover="hideTooltip(rate.id)">
                                                                <div class="row">
                                                                    <div class="col-3 pr-0 mr-0">
                                                                        <img class="rounded-circle product-image img-thumbnail"
                                                                             width="40"
                                                                             height="40"
                                                                             :src="'/'+rate.product_name.image">
                                                                    </div>
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

                                                            <td @mouseover="hideTooltip(rate.id)">{{
                                                                    rate.deal_price
                                                                }}
                                                            </td>
                                                            <td class="text-truncate">
                                                                <span id="login" :data-toggle="rate.id"
                                                                      data-container="body" data-html="true"
                                                                      data-placement="bottom" href="#" type="button"
                                                                      @click="showTooltip(rate.id)">
                                                                <span class="underline-dotted border-gray">
                                                                    {{ rate.plateform_fee }}
                                                                </span>
                                                                </span>
                                                                <div class="container">
                                                                    <div :id="'popover-content-'+rate.id"
                                                                         class="d-none">
                                                                        <div class="row custom-popover popover-max">
                                                                            <div class="col-12 px-2">
                                                                                <h6 class="small font-weight-bold mb-1">
                                                                                    FEE
                                                                                    SUMMARY</h6>
                                                                                <span>
                                                                                <span
                                                                                    class="col-9 mb-1 small d-inline-flex p-0">
                                                                                    Plateform Fee%
                                                                                </span>
                                                                                <div class="col-3 d-inline-flex">
                                                                                    <p class="mb-0 small d-inline-flex mr-2">{{
                                                                                            rate.plateform_fee
                                                                                        }}</p>
                                                                                </div>
                                                                            </span><br>
                                                                                <span>
                                                                                <span
                                                                                    class="col-9 mb-1 small d-inline-flex p-0">
                                                                                    Standard Postage
                                                                                </span>
                                                                                <div class="col-3 d-inline-flex">
                                                                                    <p class="py-0 mb-0 small d-inline-flex mr-2">{{
                                                                                            rate.standard_postage
                                                                                        }}</p>
                                                                                </div>
                                                                            </span><br>
                                                                                <span>
                                                                                <span
                                                                                    class="col-9 mb-1 small d-inline-flex p-0">
                                                                                    Highlands Postage
                                                                                </span>
                                                                                <div class="col-3 d-inline-flex">
                                                                                    <p class="py-0 mb-0 small d-inline-flex mr-2">{{
                                                                                            rate.highlands_postage
                                                                                        }}</p>
                                                                                </div>
                                                                            </span><br>
                                                                                <span>
                                                                                <span
                                                                                    class="col-9 mb-1 small d-inline-flex p-0">
                                                                                    Market Fee % Rate
                                                                                </span>
                                                                                <p class="col-3 py-0 mb-0 small d-inline-flex">
                                                                                    {{
                                                                                        rate.market_fee_percentage_rate
                                                                                    }}
                                                                                </p><br>
                                                                            </span>
                                                                                <span>
                                                                                <span
                                                                                    class="col-9 h5 mb-1 small d-inline-flex p-0">
                                                                                    Standard Incremental Fee
                                                                                </span>
                                                                                <div class="col-3 d-inline-flex">
                                                                                    <p class="py-0 mb-0 small d-inline-flex">{{
                                                                                            rate.standard_incremental_unit_fee
                                                                                        }}</p>
                                                                                </div>
                                                                            </span><br>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td @mouseover="hideTooltip(rate.id)">{{
                                                                    rate.deal_cap
                                                                }}
                                                            </td>
                                                            <td @mouseover="hideTooltip(rate.id)">{{
                                                                    formatDate(rate.start_date)
                                                                }}
                                                            </td>
                                                            <td @mouseover="hideTooltip(rate.id)">{{
                                                                    formatDate(rate.end_date)
                                                                }}
                                                            </td>
                                                            <td class="text-truncate text-center">{{
                                                                    rate.order_items.length
                                                                }}
                                                            </td>
                                                            <td @mouseover="hideTooltip(rate.id)"
                                                                class="text-center">
                                                                <i v-if="rate.is_primary == 1" class="bx bx-check text-primary
                                                            align-items-center
                                                            text-left"></i>
                                                            </td>
                                                            <td @mouseover="hideTooltip(rate.id)" class="float-center">
                                                            <span v-if="rate.is_active == 1"
                                                                  class="badge badge-light-success badge-pill ml-1">
                                                                Active
                                                            </span>
                                                                <span v-else>
                                                                <span class="badge badge-light-danger badge-pill ml-1">
                                                                In-active
                                                            </span>
                                                            </span>
                                                            </td>
                                                            <td class="text-right py-0 my-0">
                                                            <div class="dropdown">
                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                </span>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item"  data-target="#showItemRate" data-toggle="modal" v-on:click="showDealItemRate(rate.id)"><i class="bx bx-show mr-1"></i>Show</a>
                                                                    <a class="dropdown-item"  data-target="#addItemRates" data-toggle="modal" v-on:click="editDealItemRate(rate.id)"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                                    <a class="dropdown-item"  v-on:click="deleteDealItemRate(rate.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                    <div class="col-12 custom-spacing" v-if="deals.documents.length>0">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header border-bottom font-weight-bold text-dark">Documents</div>
                                <div class="table-responsive">
                                    <div>
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr>
                                                <th class="text-truncate">Title</th>
                                                <th class="text-truncate">File</th>
                                                <th class="text-truncate text-center button-plus">
                                                    <a :href="route('deal.document.create', deals.id)">
                                                        <i class="bx bx-plus default float-right add-btn font-large-1"></i>
                                                    </a>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="document in deals.documents"
                                                class="py-0 my-0">
                                                <td class="text-left cursor-pointer px-1 py-0 my-0 text-truncate">
                                                    <div v-if="document.file_type === 'pdf'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'csv'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file success font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'docx'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-doc primary font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'txt'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-txt font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'jpg'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-jpg font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'png'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-png font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'TXT'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-txt font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'PDF'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'CSV'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file success font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'DOCX'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-doc primary font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'JPG'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-jpg font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'PNG'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-png font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else>
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-image font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                </td>
                                                <td class="small cursor-pointer py-0 my-0 text-truncate">
                                                    {{ document.file.substring(14) }}
                                                </td>
                                                <td class="text-right text-small action pr-1">
                                                    <a :href=" route('export.deals.document' ,document.id )">
                                                    <span class="badge-circle badge-circle-light-secondary action mb-1">
                                                        <i class="bx bx-download font-medium-1 align-items-center text-center"></i>
                                                    </span>
                                                    </a>
                                                    <inertia-link :href="route('deal.document.edit', document.id)">
                                                        <span
                                                            class="badge-circle badge-circle-light-secondary  action mb-1">
                                                            <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                                        </span>
                                                    </inertia-link>
                                                    <button
                                                        v-on:click="confirmDelete('document/delete/', document.id)">
                                                        <span class="badge-circle badge-circle-light-secondary ml-1/6">
                                                            <i class="bx bx-trash font-medium-1 text-left"></i>
                                                        </span>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" v-if="invoices.length > 0">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header border-bottom font-weight-bold text-dark">Invoices</div>
                                <div class="table-responsive">
                                    <table class="table table-hover truncate mb-0 custome-table">
                                        <thead>
                                        <tr>
                                            <th class="text-truncate">Invoice Number</th>
                                            <th class="text-truncate">Product</th>
                                            <th class="text-truncate">Date</th>
                                            <th class="text-truncate">Total</th>
                                            <th class="text-truncate">Status</th>
                                            <th class="text-right actionTd">
                                                <span class="d-inline-flex align-items-center bg-white"
                                                      data-target="#invoiceModal"
                                                      data-toggle="modal">
                                                  <span
                                                      class="badge-circle-others badge-circle-light-secondary bg-white">
                                                    <i class="bx bx-plus pt-0 default float-right add-btn font-large-1"></i>
                                                  </span>
                                                </span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody v-for="invoice in invoices">
                                        <tr>
                                            <td class="text-truncate py-0.5">{{ invoice.invoice_number }}</td>
                                            <td class="text-truncate">
                                                <span id="login" :data-toggle="invoice.id"
                                                        data-container="body" data-html="true"
                                                        data-placement="bottom" href="#" type="button"
                                                        @click="showTooltip(invoice.id)">
                                                <span class="underline-dotted border-gray">
                                                    {{ invoice.invoice_items[0].product.name + ' (' + invoice.invoice_items[0].product.sku + ' )' }}
                                                </span>
                                                </span>
                                                <div class="container">
                                                    <div :id="'popover-content-'+invoice.id"
                                                            class="d-none">
                                                        <div class="row custom-popover popover-max">
                                                            <div class="col-12 px-2" v-for="item in  invoice.invoice_items">
                                                                <span>
                                                                <div class="">
                                                                    <p class="py-0 mb-0 small d-inline-flex mr-2">{{
                                                                            item.product.name +'('+ item.product.sku +') '+'QTY: '+item.product.invoice_items_sum_quantity
                                                                        }}</p>
                                                                </div>
                                                            </span><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-truncate py-0" @mouseover="hideTooltip(invoice.id)">{{ formatDate(invoice.invoice_date) }}</td>
                                            <td class="text-truncate py-0 " @mouseover="hideTooltip(invoice.id)">{{
                                                    invoices[0].invoice_items[0].total
                                                }}
                                            </td>
                                            <td class="text-truncate py-0.5 my-0" @mouseover="hideTooltip(invoice.id)">
                                                <span v-if="invoice.status == 'unpaid'"
                                                      class="badge badge-light-danger badge-pill">{{
                                                        invoice.status ? invoice.status : ''
                                                    }}
                                                </span>
                                                <span v-else
                                                      class="badge badge-light-success badge-pill">{{
                                                        invoice.status
                                                    }}</span>
                                            </td>
                                            <td class="text-right py-0 my-0">
                                                  <div class="dropdown">
                                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                                    </span>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        <a :href=" route('orders.invoice.view', invoice.invoice_number )" class="dropdown-item" ><i class="bx bx-show mr-1"></i>Show</a>
                                        <a class="dropdown-item"  v-on:click="confirmDelete('deals/invoice/delete/', invoice.id)"><i class="bx bx-trash mr-1"></i> delete</a>
                                        </div>
                                    </div>
                                                <!-- <span v-if="invoice.length > 0" aria-expanded="false"
                                                      class="collapse-icon clap"
                                                      data-toggle="collapse"
                                                      role="button"
                                                      v-bind:data-target='"#collapse1"+invoice.id'
                                                      v-on:click="rotateIcon(invoice.id)">
                                                <img :id='"collaspe-icon" + invoice.id' alt="icon"
                                                     src="/img/collaspe.svg">
                                                </span> -->
                                                <!-- <div
                                                    class="d-inline-block col-md-2 col-4 custom-padding-right mr-1"
                                                    style="z-index:2">
                                                    <div class="dropdownz dropleft ml-2">
                                                        <span id="dropdownMenuButton"
                                                              aria-expanded="false"
                                                              aria-haspopup="true"
                                                              class="badge-circle badge-circle-light-secondary circle-color ml-auto"
                                                              data-toggle="dropdown">
                                                            <i class='bx bx-dots-vertical-rounded lg:font-bold font-size-bx'></i>
                                                        </span>
                                                        <div aria-labelledby="dropdownMenuButton"
                                                             class="dropdown-menu">
                                                            <div class="container">
                                                                <div class="row custom-popover popover-max">
                                                                    <div class="col-12 p-0 m-0">
                                                                        <div
                                                                            class="d-flex flex-column px-1">
                                                                            <div class="d-flex">
                                                                                <a :href=" route('orders.invoice.view', invoice.invoice_number )">
                                                                                    <i class="bx bxs-show font-medium-1 align-items-center text-center show-invoice"></i>
                                                                                </a>
                                                                                <p class="ml-1 small action-text mb-0"
                                                                                   style="margin-top: 7px">
                                                                                    Show
                                                                                </p>
                                                                            </div>
                                                                            <div class="d-flex">
                                                                                <span
                                                                                    class="badge-circle circle-color"
                                                                                    v-on:click="confirmDelete('deals/invoice/delete/', invoice.id)">
                                                                                    <i class="bx bx-trash font-medium-1 align-items-center mx-1"></i>
                                                                                </span>
                                                                                <p class="size-change ml-1 small action-text mb-0">
                                                                                    Delete
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </td>
                                        </tr>
                                        <tr v-bind:id='"collapse1"+invoice.id' role="tabpanel"
                                            aria-labelledby="headingCollapse8" v-for="payment in invoice.payments"
                                            class="collapse">
                                            <td class="text-truncate">Payment</td>
                                            <td class="text-truncate">{{ payment.payment_date }}</td>
                                            <td class="text-truncate">{{ payment.amount }}</td>
                                            <td class="text-truncate"></td>
                                            <td class="text-right py-0 my-0 d-flex justify-content-end">
                                                <div class="dropdown dropleft check-down">
                                                        <span id="dropdownMenuButton"
                                                              aria-expanded="false" aria-haspopup="true"
                                                              class="badge-circle badge-circle-light-secondary ml-auto "
                                                              data-toggle="dropdown">
                                                          <svg id="bi-three-dots" class="bi bi-three-dots"
                                                               fill="currentColor"
                                                               height="20"
                                                               type="button" viewBox="0 0 16 16" width="20"
                                                               xmlns=http://www.w3.org/2000/svg>
                                                            <path
                                                                d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                                          </svg>
                                                        </span>
                                                    <div aria-labelledby="dropdownMenuButton" class="dropdown-menu">
                                                        <div class="container">
                                                            <div class="row custom-popover popover-max">
                                                                <div class="col-12 p-0 m-0">
                                                                    <div class="d-flex flex-column px-1">
                                                                        <div class="d-flex mb-1 mt-1">
                                                                            <inertia-link
                                                                                :href="route('payments.edit', payment.id)">
                                                                                  <span
                                                                                      class="badge-circle badge-circle-light-secondary action ">
                                                                                    <i class="bx bx-edit font-medium-1 align-items-center mx-1"></i>
                                                                                  </span>
                                                                            </inertia-link>
                                                                            <p class=" ml-1 small action-text mb-0 ">Edit Payment</p>
                                                                        </div>
                                                                        <div class="d-flex">
                                                                            <button
                                                                                v-on:click="confirmDelete('payments/', payment.id)">
                                                                                  <span
                                                                                      class="badge-circle badge-circle-light-secondary">
                                                                                    <i class="bx bx-trash font-medium-1 align-items-center mx-1"></i>
                                                                                  </span>
                                                                            </button>
                                                                            <p id=""
                                                                               class="ml-1 small action-text mb-0">
                                                                                Delete Payment</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
                    <div class="col-12 custom-spacing" v-if="orders.data.length > 0">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header border-bottom font-weight-bold text-dark">Orders</div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th class="text-truncate">Order #</th>
                                            <th class="text-truncate">Product</th>
                                            <th class="text-truncate text-center">Total</th>
                                            <th class="text-truncate text-center">Tracking Number</th>
                                            <th class="text-truncate text-center">Status</th>
                                            <th class="text-truncate text-center"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="order in orders.data">
                                            <td class="text-truncate">{{ order.order_number }}</td>
                                            <td class="py-0 my-0">
                                                <div class="row">
                                                    <div class="col-2 pr-0 mr-0">
                                                        <img class="rounded-circle product-image img-thumbnail" width="40"
                                                             height="40" :src="'/'+order.product.image">
                                                    </div>
                                                    <div class="col-9 py-1 px-0 mx-0">
                                                        {{
                                                            (order.product ? order.product.name : '') + ' (' +
                                                            (order.product ? order.product.sku : '') + ') ' + 'Qty:' +
                                                            (order.quantity)
                                                        }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-truncate text-center">{{
                                                    order.quantity * rate.deal_price
                                                }}
                                            </td>
                                            <td class="text-truncate text-center">{{
                                                    order.shipment_tracking_number
                                                }}
                                            </td>
                                            <td class="text-truncate text-center">
                                                <span
                                                    v-if="order.order_status == 'Processing' || order.order_status == 'processing'"
                                                    class="badge badge-light-success badge-pill text-right ml-1">
                                                     {{ order.order_status }}
                                                </span>
                                                <span
                                                    v-if="order.order_status == 'pending' || order.order_status == 'Pending'"
                                                    class="badge badge-pill badge-warning ml-1">
                                                     {{ order.order_status }}
                                                </span>
                                                <span
                                                    v-if="order.order_status == 'cancelled' || order.order_status == 'Cancelled'"
                                                    class="badge badge-pill badge-danger ml-1">
                                                     {{ order.order_status }}
                                                </span>
                                                <span
                                                    v-if="order.order_status == 'completed' || order.order_status == 'Completed'"
                                                    class="badge badge-light-success badge-pill  ml-1">
                                                     {{ order.order_status }}
                                                </span>
                                                <span
                                                    v-if="order.order_status == 'shipped' || order.order_status == 'shipped'"
                                                    class="badge badge-light-success badge-pill  ml-1">
                                                     {{ order.order_status }}
                                                </span>
                                                <span
                                                    v-if="order.order_status == 'collection' || order.order_status == 'Collection'"
                                                    class="badge badge-light-success badge-pill ml-1">
                                                     {{ order.order_status }}
                                                </span>
                                                <span
                                                    v-if="order.order_status == 'replacement' || order.order_status == 'Replacement'"
                                                    class="badge badge-light-success badge-pill  ml-1">
                                                     {{ order.order_status }}
                                                </span>
                                                <span
                                                    v-if="order.order_status == 'redispatch' || order.order_status == 'Redispatch'"
                                                    class="badge badge-light-success badge-pill  ml-1">
                                                     {{ order.order_status }}
                                                </span>
                                            </td>
                                            <td class="text-right py-0 my-0">
                                                <span v-if="order.length > 0" aria-expanded="false"
                                                      class="collapse-icon clap"
                                                      data-toggle="collapse"
                                                      role="button"
                                                      v-bind:data-target='"#collapse1"+order.id'
                                                      v-on:click="rotateIcon(order.id)">
                                                <img :id='"collaspe-icon" + order.id' alt="icon"
                                                     src="/img/collaspe.svg">
                                                </span>
                                                <div class="d-inline-block col-md-2 col-4 custom-padding-right mr-1"
                                                     style="z-index:2">
                                                    <div class="dropdownz dropleft">
                                                        <span id="dropdownMenuButton"
                                                              aria-expanded="false"
                                                              aria-haspopup="true"
                                                              class="badge-circle badge-circle-light-secondary circle-color ml-auto"
                                                              data-toggle="dropdown">
                                                            <i class='bx bx-dots-vertical-rounded lg:font-bold font-size-bx'></i>
                                                        </span>
                                                        <div aria-labelledby="dropdownMenuButton"
                                                             class="dropdown-menu">
                                                            <div class="container">
                                                                <div class="row custom-popover popover-max">
                                                                    <div class="col-12 p-0 m-0">
                                                                        <div
                                                                            class="d-flex flex-column px-1">
                                                                            <div class="d-flex">
                                                                                <span
                                                                                    class="d-inline-flex align-items-center"
                                                                                    data-target="#showOrderDetail"
                                                                                    data-toggle="modal"
                                                                                    v-on:click="showOrderDetail(order.id)">
                                                                                    <span
                                                                                        class="badge-circle circle-color">
                                                                                        <i class="bx bx-show font-medium-1
                                                                                            align-items-center
                                                                                            text-left"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <p id="delete_icon"
                                                                                   class="ml-1 small action-text mb-0"
                                                                                   style="margin-top: 7px">
                                                                                    Show
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
                    <div class="col-sm-11 d-flex justify-content-start pl-1 px-0">
                        <inertia-link :href="route('deals.index')" type="button"
                                      class="btn btn-light-secondary mr-1 mb-1">
                            Back
                        </inertia-link>
                    </div>
                </div>
                <div class="col-12" v-if="orders.data.length > 0">
                    <pagination :links="orders.links" class="float-right"></pagination>
                </div>
            </section>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                               @deleteitem="deleteItem">
            </ConfirmatiomModal>

            <div id="addItem" aria-hidden="true"
                 aria-labelledby="myModalLabel33"
                 class="modal fade text-left"
                 role="dialog"
                 tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="font-weight-bold mx-auto mt-3 pl-2">Add Deal Item</h4>
                            <button
                                aria-label="Close"
                                class="close"
                                data-dismiss="modal"
                                type="button">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <span class="mx-auto" v-if="form1.id == null">Add the products for this deal.</span>
                        <span class="mx-auto" v-else>Updating the products for this deal.</span>
                        <form class="form form-horizontal">
                            <div class="modal-body mb-1">
                                <li v-for="errorse in errorses" class="error">{{ errorse }}</li>
                                <div class="form-group py-0 my-0 mb-1">
                                    <label>Product *</label>
                                    <div class="col-md-12 form-group ml-0 pl-0">
                                        <select
                                            class="form-select p-0"
                                            v-model="form1.product_id"
                                            name="product_id"
                                            required="required">
                                            <option></option>
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
                                        class="form-control col-6"
                                        name="product_code"
                                        type="text"
                                        required="required"
                                    />
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
                                    class="btn btn-primary ml-1"
                                    data-dismiss="modal"
                                    type="button"
                                    @click="create(form1.id)">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                                <button
                                    id="modal-hide"
                                    class="btn btn-light-secondary"
                                    data-dismiss="modal"
                                    type="button">
                                    <i ref="closeModall" class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Cancel</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="invoiceModal" aria-hidden="true" aria-labelledby="myModalLabel33" class="modal fade text-left"
                 role="dialog" tabindex="-1">
                <div
                    class="modal-dialog modal-dialog-centered scroll modal-lg"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="font-weight-bold mx-auto mt-3 pl-2">Add Invoice</h4>
                            <button
                                aria-label="Close"
                                class="close"
                                data-dismiss="modal"
                                type="button">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <span class="mx-auto">Add the order invoice for this deal.</span>
                        <form class="form form-horizontal">
                            <div class="modal-body mb-1" id="modal-body-invoice">
                                <div class="form-group py-0 my-0 mb-1">
                                    <div class="col-md-12 form-group ml-0 pl-0">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group py-0 my-0">
                                                    <label>Invoice Number*</label>
                                                    <div class="col-md-12 form-group ml-0 pl-0">
                                                        <input
                                                            type="text"
                                                            id="invoice_number"
                                                            v-model="form.invoice_number"
                                                            class="form-control"
                                                            name="invoice_number"
                                                            required/>
                                                        <ErrorComponent input="invoice_number"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group py-0 my-0">
                                                    <label>Invoice Date*</label>
                                                    <div class="col-md-12 form-group ml-0 pl-0">
                                                        <input
                                                            type="date"
                                                            id="invoice_date"
                                                            v-model="form.invoice_date"
                                                            class="form-control"
                                                            name="invoice_date"
                                                            required/>
                                                        <ErrorComponent input="invoice_date"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group py-0 my-0">
                                                    <label>Status*</label>
                                                    <div class="col-md-12 form-group ml-0 pl-0">
                                                        <select class="form-control"
                                                                v-model="form.order_status"
                                                                name="order_status"
                                                                id="order_status">
                                                            <option></option>
                                                            <option :v-bind="paid">Paid</option>
                                                            <option :v-bind="unpaid">Unpaid</option>
                                                        </select>
                                                        <ErrorComponent input="order_status"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                <tr>
                                                    <th class="text-truncate">Product</th>
                                                    <th class="text-truncate text-center">tracking</th>
                                                    <th class="text-truncate text-center">price</th>
                                                    <th class="text-truncate text-center">Fee</th>
                                                    <th class="text-truncate text-center">Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="order in unInvoicedOrders">
                                                    <td class="text-truncate d-flex">
                                                        <input type="checkbox" class="form-check-input" v-model="checkboxes"
                                                        @click="checkBoxCheck(order.id)">&nbsp;{{
                                                            order.product.name
                                                        }}({{ order.product.sku }})
                                                    </td>
                                                    <td class="text-truncate text-center">
                                                        {{ order.order_items.tracking_nuber }}
                                                    </td>
                                                    <td class="text-truncate text-center">£{{ rate.deal_price }}</td>
                                                    <td class="text-truncate text-center">£{{ rate.commission_amount }}
                                                    </td>
                                                    <td class="text-truncate text-center">
                                                        £{{ (rate.total_receivable) }}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button v-on:click="generateInvoice()" type="button"
                                        class="btn btn-primary"> Generate Invoice
                                </button>
                                <button
                                    id="modal-hide-invoice"
                                    class="btn btn-light-secondary"
                                    data-dismiss="modal"
                                    type="button">
                                    <i ref="closeModall" class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Cancel</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div
                id="showItem"
                aria-hidden="true"
                aria-labelledby="myModalLabel33"
                class="modal fade text-left"
                role="dialog"
                tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="font-weight-bold mx-auto mt-3 pl-2">View Deal Item</h4>
                            <button
                                aria-label="Close"
                                class="close"
                                data-dismiss="modal"
                                type="button">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <span class="mx-auto">Shows the product for this deal rates.</span>
                        <form class="form form-horizontal">
                            <div class="modal-body">
                                <div class="form-group py-0 my-0">
                                    <p class="mb-0 modal-font">PRODUCT </p>
                                </div>
                                <div class="form-group py-0 my-0 mb-1">
                                    <p class="mb-0 modal-font">{{
                                            form1.product_name + '(' + form1.product_sku + ')'
                                        }}</p>
                                </div>
                                <div class="form-group py-0 my-0">
                                    <p class="mb-0 modal-font">TITLE </p>
                                </div>
                                <div class="form-group py-0 my-0 mb-1">
                                    <p class="mb-0 modal-font">{{ form1.product_title }}</p>
                                </div>
                                <div class="form-group py-0 my-0">
                                    <p class="mb-0 modal-font">PRODUCT CODE</p>
                                </div>
                                <div class="form-group py-0 my-0 mb-1">
                                    <p class="mb-0 modal-font">{{ form1.product_code }}</p>
                                </div>
                                <div class="form-group py-0 my-0">
                                    <p class="mb-0 modal-font">LINK</p>
                                </div>
                                <div class="form-group py-0 my-0 mb-1">
                                    <p class="mb-0 modal-font">{{ form1.link }}</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    id="modal-hide"
                                    class="btn btn-light-secondary"
                                    data-dismiss="modal"
                                    type="button">
                                    <i ref="closeModalmodal-body mb-1l" class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Cancel</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div
                id="showItemRate"
                aria-hidden="true"
                aria-labelledby="myModalLabel33"
                class="modal fade text-left"
                role="dialog"
                tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="font-weight-bold mx-auto mt-3 pl-2">View Deal Item Rates</h4>
                            <button
                                aria-label="Close"
                                class="close"
                                data-dismiss="modal"
                                type="button">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <span class="mx-auto">Shows the product for this deal.</span>
                        <form class="form form-horizontal">
                            <div class="modal-body">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 modal-font">PRODUCT </p>
                                            </div>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 modal-font">
                                                    {{ form2.product_name + '(' + form2.product_sku + ')' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 modal-font">DEAL CAPACITY</p>
                                            </div>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 modal-font">{{ form2.deal_cap }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 modal-font">DEAL PRICE(£)</p>
                                            </div>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 modal-font">{{ form2.deal_price }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 modal-font">PLATEFORM FEE%</p>
                                            </div>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 modal-font">{{ form2.plateform_fee }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 modal-font">MARKET FEE % RATE</p>
                                            </div>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 modal-font">{{ form2.market_fee_percentage_rate }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 modal-font">STANDARD INCREMENTAL UNIT FEE(£)</p>
                                            </div>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 modal-font">{{ form2.standard_incremental_unit_fee }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 modal-font">STANDARD POSTAGE(£)</p>
                                            </div>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 modal-font">{{ form2.standard_postage }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 modal-font">HIGHLAND POSTAGE(£)</p>
                                            </div>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 modal-font">{{ form2.highlands_postage }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 modal-font">START DATE</p>
                                            </div>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 modal-font">{{ formatDate(form2.start_date) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 modal-font">END DATE</p>
                                            </div>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 modal-font">{{ form2.end_date }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    id="modal-hide"
                                    class="btn btn-light-secondary"
                                    data-dismiss="modal"
                                    type="button">
                                    <i ref="closeModalmodal-body mb-1l" class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Cancel</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div
                id="showOrderDetail"
                aria-hidden="true"
                aria-labelledby="myModalLabel33"
                class="modal fade text-left"
                role="dialog"
                tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="font-weight-bold mx-auto mt-3 pl-2">View Order Details</h4>
                            <button
                                aria-label="Close"
                                class="close"
                                data-dismiss="modal"
                                type="button">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <span class="mx-auto">Details of the order for this deal.</span>
                        <div class="modal-body">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group py-0 my-0">
                                            <p class="mb-0 modal-font">ORDER NUMBER</p>
                                        </div>
                                        <div class="form-group py-0 my-0 mb-1">
                                            <p class="mb-0 modal-font">
                                                {{ orderDetail[0] ? orderDetail[0].order_number : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group py-0 my-0">
                                            <p class="mb-0 modal-font">ORDER DATE</p>
                                        </div>
                                        <div class="form-group py-0 my-0 mb-1">
                                            <p class="mb-0 modal-font">
                                                {{ orderDetail[0] ? orderDetail[0].order_date : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group py-0 my-0">
                                            <p class="mb-0 modal-font">CUSTOMER NAME</p>
                                        </div>
                                        <div class="form-group py-0 my-0 mb-1">
                                            <p class="mb-0 modal-font">
                                                {{ orderDetail[0] ? orderDetail[0].customer_name : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group py-0 my-0">
                                            <p class="mb-0 modal-font">STATUS</p>
                                        </div>
                                        <div class="form-group py-0 my-0 mb-1">
                                            <p class="mb-0 modal-font">
                                                {{ orderDetail[0] ? orderDetail[0].order_status : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group py-0 my-0">
                                            <p class="mb-0 modal-font">SHIPPING ADDRESS</p>
                                        </div>
                                        <div class="form-group py-0 my-0 mb-1">
                                            <p class="mb-0 modal-font">
                                                {{ orderDetail[0] ? orderDetail[0].shipping_address : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group py-0 my-0">
                                            <p class="mb-0 modal-font">BILLING ADDRESS</p>
                                        </div>
                                        <div class="form-group py-0 my-0 mb-1">
                                            <p class="mb-0 modal-font">
                                                {{ orderDetail[0] ? orderDetail[0].billing_address : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group py-0 my-0">
                                            <p class="mb-0 modal-font">SHIPPING EMAIL</p>
                                        </div>
                                        <div class="form-group py-0 my-0 mb-1">
                                            <p class="mb-0 modal-font">{{
                                                    orderDetail[0] ? orderDetail[0].email : ''
                                                }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group py-0 my-0">
                                            <p class="mb-0 modal-font">PHONE</p>
                                        </div>
                                        <div class="form-group py-0 my-0 mb-1">
                                            <p class="mb-0 modal-font">{{
                                                    orderDetail[0] ? orderDetail[0].phone : ''
                                                }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group py-0 my-0">
                                            <p class="mb-0 modal-font">CHANNEL</p>
                                        </div>
                                        <div class="form-group py-0 my-0 mb-1">
                                            <p class="mb-0 modal-font">{{
                                                    orderDetail[0] ? orderDetail[0].channel : ''
                                                }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--                            <div class="col-12">-->
                            <!--                                <div class="card">-->
                            <!--                                    <div class="card-header">-->
                            <!--                                        <h4 class="card-title">Products</h4>-->
                            <!--                                    </div>-->
                            <!--                                    <div class="card-content">-->
                            <!--                                        <div class="card-body">-->
                            <!--                                            &lt;!&ndash; Table with outer spacing &ndash;&gt;-->
                            <!--                                            <div class="table-responsive">-->
                            <!--                                                <table class="table">-->
                            <!--                                                    <thead>-->
                            <!--                                                    <tr>-->
                            <!--                                                        <th>NAME</th>-->
                            <!--                                                        <th>RATE</th>-->
                            <!--                                                        <th>SKILL</th>-->
                            <!--                                                        <th>TYPE</th>-->
                            <!--                                                        <th>LOCATION</th>-->
                            <!--                                                        <th>ACTION</th>-->
                            <!--                                                    </tr>-->
                            <!--                                                    </thead>-->
                            <!--                                                    <tbody>-->
                            <!--                                                    <tr>-->
                            <!--                                                        <td class="text-bold-500">Michael Right</td>-->
                            <!--                                                        <td>$15/hr</td>-->
                            <!--                                                        <td class="text-bold-500">UI/UX</td>-->
                            <!--                                                        <td>Remote</td>-->
                            <!--                                                        <td>Austin,Taxes</td>-->
                            <!--                                                        <td><a href="#"><i-->
                            <!--                                                            class="badge-circle badge-circle-light-secondary bx bx-envelope font-medium-1"></i></a>-->
                            <!--                                                        </td>-->
                            <!--                                                    </tr>-->
                            <!--                                                    </tbody>-->
                            <!--                                                </table>-->
                            <!--                                            </div>-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                        <div class="modal-footer">
                            <button
                                id="modal-hide"
                                class="btn btn-light-secondary"
                                data-dismiss="modal"
                                type="button">
                                <i ref="closeModalmodal-body mb-1l" class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Cancel</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="addItemRates" aria-hidden="true" aria-labelledby="myModalLabel33" class="modal fade text-left"
                 role="dialog" tabindex="-1">
                <div
                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="font-weight-bold mx-auto mt-3 pl-2">Add Deal Item Rate</h4>
                            <button
                                aria-label="Close"
                                class="close"
                                data-dismiss="modal"
                                type="button">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <span class="mx-auto" v-if="form2.id == null">Provide details of the deal rates.</span>
                        <span class="mx-auto" v-else>Updating the products for this deal.</span>
                        <form class="form form-horizontal">
                            <div class="modal-body mb-1" id="modal-body-sec">
                                <li v-for="rate in errorItem" class="error">{{ rate }}</li>
                                <div class="col-12 pr-0">
                                    <div class="row">
                                        <div class="col-12 p-0">
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 labelModal">Product</p>
                                                <div class="col-md-12 form-group ml-0 pl-0">
                                                    <select
                                                        class="form-select"
                                                        v-model="form2.product_id"
                                                        name="product_id">
                                                        <option></option>
                                                        <option
                                                            v-for="dealItem in this.dealItems"
                                                            :value="dealItem.product? dealItem.product.id: dealItem.product_id">
                                                            {{
                                                                dealItem.product
                                                                    ? dealItem.product.name
                                                                    : dealItem.product_name
                                                            }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 p-0">
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 labelModal">Deal Cap</p>
                                                <div class="col-md-12 form-group p-0">
                                                    <div class="col-md-12 form-group pl-0">
                                                        <input
                                                            type="text"
                                                            id="deal_cap"
                                                            v-model="form2.deal_cap"
                                                            class="form-control"
                                                            name="deal_cap"
                                                        />
                                                    </div>
                                                    <ErrorComponent input="deal_cap"></ErrorComponent>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 p-0">
                                            <div class="form-group py-0 my-0 mb-1">
                                                <p class="mb-0 labelModal">Deal Price *</p>
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
                                        </div>
                                        <div class="col-6 p-0">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 labelModal">Plateform Fee *</p>
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
                                        </div>

                                        <div class="col-6 p-0">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 labelModal">Market Fee Percentage Rate</p>
                                                <div class="col-md-12 form-group ml-0 pl-0">
                                                    <input
                                                        type="text"
                                                        id="market_fee_percentage_rate"
                                                        v-model="form2.market_fee_percentage_rate"
                                                        class="form-control"
                                                        name="market_fee_percentage_rate"
                                                    />
                                                    <ErrorComponent input="market_fee_percentage_rate"></ErrorComponent>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 p-0">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 labelModal">Standard Incremental Unit Fee</p>
                                                <div class="col-6 p-0 form-group ml-0 pl-0">
                                                    <input type="text" id="standard_incremental_unit_fee"
                                                           v-model="form2.standard_incremental_unit_fee"
                                                           class="form-control"
                                                           name="standard_incremental_unit_fee"
                                                           required/>
                                                    <ErrorComponent input="market_fee_percentage_rate"></ErrorComponent>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 p-0">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 labelModal">Standard Postage *</p>
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
                                        </div>
                                        <div class="col-6 p-0">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 labelModal">Highlands Postage</p>
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
                                        </div>
                                        <div class="col-6 p-0">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 labelModal">Start Date*</p>
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
                                        </div>
                                        <div class="col-6 p-0">
                                            <div class="form-group py-0 my-0">
                                                <p class="mb-0 labelModal">End Date</p>
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

                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button
                                    id="modal-hide"
                                    class="btn btn-light-secondary mr-1"
                                    data-dismiss="modal"
                                    type="button">
                                    <i ref="closeModall" class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button
                                    class="btn btn-primary mr-2"
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

        </admin-layout>
    </div>
</template>

<script>
import moment from "moment";
import Button from "../../Jetstream/Button";
import { useForm } from "@inertiajs/inertia-vue3";
import Pagination from "../../admin/Pagination";
import AdminLayout from "../../Layouts/AdminLayout";
import ErrorComponent from "../../components/ErrorComponent";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {
  name: "Show",
  props: [
    "deals",
    "quantity",
    "unInvoiced",
    "products",
    "balance",
    "totalPaid",
    "dealItemsRate",
    "dealRatesProduct",
    "rate",
    "orders",
    "orderCount",
    "totalVat",
    "totalCommission",
    "totalpostage",
    "totalReceivable",
    "orderQuantity",
    "totalPpVat",
    "dealPrice",
    "deal_id",
    "invoices",
    "totalCap",
    "invoiced",
    "unInvoicedOrders",
  ],

  components: {
    Button,
    AdminLayout,
    Pagination,
    ConfirmatiomModal,
    ErrorComponent,
  },
  data() {
    return {
      form: this.$inertia.form({
        title: "",
        description: "",
        file: null,
      }),
      form1: this.$inertia.form({
        id: "",
        deal_id: "",
        product_id: "",
        product_title: "",
        product_code: "",
        sku: "",
        link: "",
      }),
      form2: this.$inertia.form({
        id: "",
        deal_id: "",
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
      sweetAlert: false,
      update: false,
      itemId: "",
      url: null,
      rotate: false,
      errorses: [],
      errorItem: [],
      ordersData: [],
      checkboxes: [],
      required: false,
      validatare: "",
      stop: true,
      isValidUrl: true,
      isValidDealPrice: true,
      isValidDealCap: true,
      isValidDealFee: true,
      isValidDealVat: true,
      isValidMarketFee: true,
      isValidHightlandPostage: true,
      isValidStandardIncrementalUnitFee: true,
      hasError: false,
      regex: /^(\d+(\.\d+)?)$/,
      regexForNum: /^[0-9]*$/,
      urlRegex:
        /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/,
      dealItems: this.deals ? this.deals.deal_products : [],
      // dealItemsRate: this.deals ? this.deals.deal_product_rates : [],
      orderDetail: [],
    };
  },

  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Show Details";
    this.form.deal_id = this.deals.id;
    this.form2 = [];
  },

  mounted() {
    if (this.params) {
      Object.assign(this.query, this.params);
    }
  },

  setup() {
    const form = useForm({
      orders: [],
      deal_id: null,
      order_status: "",
      invoice_date: "",
      invoice_number: "",
    });
    return { form };
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
          deal_item.image = product_name.image;
          deal_item.product_title = this.form1.product_title;
          deal_item.product_code = this.form1.product_code;
          deal_item.link = this.form1.link;
          this.form1.put(route("deals.items.update", { id }));
        } else {
          let obj = {};
          obj.id = Math.random().toString(36).substr(2, 9);
          obj.product_id = this.form1.product_id;
          obj.deal_id = this.deals.id;
          obj.product_name = product_name.name;
          obj.image = product_name.image;
          obj.product_title = this.form1.product_title;
          obj.product_code = this.form1.product_code;
          obj.link = this.form1.link;
          this.dealItems.push(obj);
          this.form1.deal_id = this.deals.id;
          this.form1.post(route("deals.items.create"));
        }
      }
    },

    addDealItem() {
      this.errorses = [];
      this.errorItem = [];
      this.form1 = this.$inertia.form({
        deal_id: "",
        product_id: "",
        product_title: "",
        product_code: "",
        sku: "",
        link: "",
      });
    },

    editDealItem(id) {
      this.errorses = [];
      this.errorItem = [];
      var deal_item = this.dealItems.find((dealItem) => dealItem.id === id);
      this.form1 = this.$inertia.form({
        id: deal_item.id,
        link: deal_item.link,
        product_id: deal_item.product_id,
        product_code: deal_item.product_code,
        product_title: deal_item.product_title,
      });
    },

    showDealItem(id) {
      this.errorses = [];
      this.errorItem = [];
      var deal_item = this.dealItems.find((dealItem) => dealItem.id === id);
      this.form1 = this.$inertia.form({
        id: deal_item.id,
        link: deal_item.link,
        product_id: deal_item.product_id,
        product_name: deal_item.product.name,
        product_sku: deal_item.product.sku,
        product_code: deal_item.product_code,
        product_title: deal_item.product_title,
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
          var deal_item = this.dealItems.find(
            (dealItem) => dealItem.id === deal_item_rate.deal_product_id
          );
          deal_item_rate.deal_price = this.form2.deal_price;
          deal_item_rate.deal_product_id = this.form2.product_id;
          deal_item_rate.product_name = product_name.name;
          deal_item_rate.plateform_fee = this.form2.plateform_fee;
          deal_item_rate.standard_postage = this.form2.standard_postage;
          deal_item_rate.highlands_postage = this.form2.highlands_postage;
          deal_item_rate.market_fee_percentage_rate =
            this.form2.market_fee_percentage_rate;
          deal_item_rate.standard_incremental_unit_fee =
            this.form2.standard_incremental_unit_fee;
          deal_item_rate.deal_cap = this.form2.deal_cap;
          deal_item_rate.start_date = this.form2.start_date;
          deal_item_rate.end_date = this.form2.end_date;
          this.form2.put(route("deals.rate.update", { id }));
        } else {
          let obj = {};
          obj.id = Math.random().toString(36).substr(2, 9);
          obj.deal_price = this.form2.deal_price;
          obj.deal_product_id = this.form2.product_id;
          obj.product_id = this.form2.product_id;
          obj.dealProduct = product_name.name;
          obj.image = product_name.image;
          obj.plateform_fee = this.form2.plateform_fee;
          obj.standard_postage = this.form2.standard_postage;
          obj.highlands_postage = this.form2.highlands_postage;
          obj.market_fee_percentage_rate =
            this.form2.market_fee_percentage_rate;
          obj.standard_incremental_unit_fee =
            this.form2.standard_incremental_unit_fee;
          obj.deal_cap = this.form2.deal_cap;
          obj.start_date = this.form2.start_date;
          obj.end_date = this.form2.end_date;
          this.dealItemsRate.push(obj);
          this.form2.deal_id = this.deals.id;
          this.form2.post(route("deals.rate.create"));
        }
      }
    },
    showDealItemRate(id) {
      this.errorses = [];
      this.errorItem = [];
      var deal_item_rate = this.dealItemsRate.find(
        (dealItemRate) => dealItemRate.id === id
      );
      var deal_item = this.dealItems.find(
        (dealItem) => dealItem.id === deal_item_rate.deal_product_id
      );
      this.form2 = this.$inertia.form({
        id: deal_item_rate.id,
        deal_price: deal_item_rate.deal_price,
        product_id: deal_item.product_id,
        product_name: deal_item.product.name,
        product_sku: deal_item.product.sku,
        image: deal_item.product.image,
        plateform_fee: deal_item_rate.plateform_fee,
        standard_postage: deal_item_rate.standard_postage,
        deal_cap: deal_item_rate.deal_cap,
        highlands_postage: deal_item_rate.highlands_postage,
        market_fee_percentage_rate: deal_item_rate.market_fee_percentage_rate,
        standard_incremental_unit_fee:
          deal_item_rate.standard_incremental_unit_fee,
        start_date: deal_item_rate.start_date,
        end_date: deal_item_rate.end_date,
      });
    },
    showOrderDetail(id) {
      let ordersData = {};
      var order_data = this.orders.data.find((order) => order.id === id);
      ordersData.order_number = order_data.order_number;
      ordersData.order_date = order_data.order_date;
      ordersData.customer_name = order_data.shipping_customer_name;
      ordersData.order_status = order_data.order_status;
      ordersData.shipping_address = order_data.shipping_address_1;
      ordersData.billing_address = order_data.billing_address_1;
      ordersData.email = order_data.shipping_email;
      ordersData.phone = order_data.shipping_address_phone;
      ordersData.channel = order_data.channel.name;
      ordersData.payment_method = order_data.payment_method;
      this.orderDetail.push(ordersData);
    },
    urlChange: function (e) {
      this.isValidUrl = this.urlRegex.test(e.target.value);
    },
    change: function (e) {
      this.isValidDealPrice = this.regex.test(e.target.value);
    },
    changeCap: function (e) {
      this.isValidDealCap = this.regex.test(e.target.value);
    },
    changeFee: function (e) {
      this.isValidDealFee = this.regex.test(e.target.value);
    },
    changeVat: function (e) {
      this.isValidDealVat = this.regex.test(e.target.value);
    },
    changeMarketFee: function (e) {
      this.isValidMarketFee = this.regexForNum.test(e.target.value);
    },
    changeHightlandPostage: function (e) {
      this.isValidHightlandPostage = this.regex.test(e.target.value);
    },
    changeStandardIncrementalUnitFee: function (e) {
      this.isValidStandardIncrementalUnitFee = this.regex.test(e.target.value);
    },

    addDealItemRate() {
      this.errorses = [];
      this.errorItem = [];
      this.form2 = this.$inertia.form({
        deal_id: "",
        deal_price: "",
        deal_cap: "",
        plateform_fee: "",
        standard_postage: "",
        highlands_postage: "",
        market_fee_percentage_rate: "",
        standard_incremental_unit_fee: "",
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
      var deal_item = this.dealItems.find(
        (dealItem) => dealItem.id === deal_item_rate.deal_product_id
      );
      this.form2 = this.$inertia.form({
        id: deal_item_rate.id,
        deal_id: deal_item_rate.deal_number,
        deal_price: deal_item_rate.deal_price,
        product_id: deal_item.product_id,
        image: deal_item.product.image,
        plateform_fee: deal_item_rate.plateform_fee,
        standard_postage: deal_item_rate.standard_postage,
        deal_cap: deal_item_rate.deal_cap,
        highlands_postage: deal_item_rate.highlands_postage,
        market_fee_percentage_rate: deal_item_rate.market_fee_percentage_rate,
        standard_incremental_unit_fee:
        deal_item_rate.standard_incremental_unit_fee,
        start_date: deal_item_rate.start_date,
        end_date: deal_item_rate.end_date,
      });
    },

    deleteDealItemRate(id) {
      let deal_item_rate = this.dealItemsRate.find(
        (deal_item) => deal_item.id == id
      );
      // this.dealItemsRate = this.dealItemsRate.filter(function (rate) {
      //     return rate.id !== id;
      // });
      this.form.delete(route("deal.product.rate.delete", deal_item_rate.id));
    },

    Clicked() {
      this.sweetAlert = false;
    },
    deleteItem() {
      this.sweetAlert = false;
      this.$inertia.delete(`/erp/${this.url}${this.itemId}`);
    },
    confirmDelete(url, id) {
      this.sweetAlert = true;
      this.itemId = id;
      this.url = url;
    },
    stopPropagation(e) {
      e.stopPropagation();
      this.submit();
    },
    loadData() {
      let query = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
        }
      }
      this.$inertia.visit(route("cores.index"), {
        method: "get",
        data: {
          ...query,
        },
      });
    },
    formatDate(date) {
      if (date) {
        return moment(date).format("DD/MM/YYYY");
      } else {
        return "";
      }
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
    // totalFun(dealId, productId) {
    //         axios
    //             .get("/super/admin/search-rate", {
    //                 params: {
    //                     id: this.query.from_to,
    //                 },
    //             })
    //             .then((response) => {
    //                 this.exchange = response.data.exchange;
    //                 this.chart = response.data.chart;
    //             });
    // },
    total(data) {
      let length = data.length;
      let totalCommission = length * parseFloat(this.deals.commission_amount);
      let total = 0;
      data.forEach((element) => {
        total = total + parseFloat(element.total_price);
      });
      return total - totalCommission;
    },
    // selectAll() {
    //     var select_all = document.getElementsByClassName("selectall");
    //     var checkboxes = document.getElementsByClassName("checkbox");
    //     for (i = 0; i < checkboxes.length; i++) {
    //         checkboxes[i].checked = select_all[0].checked;
    //     }
    //     for (var i = 0; i < checkboxes.length; i++) {
    //         checkboxes[i].addEventListener('change', function (e) {
    //             if (this.checked == false) {
    //                 select_all[0].checked = false;
    //             }
    //             if (document.querySelectorAll('.checkbox:checked').length == checkboxes.length) {
    //                 select_all[0].checked = true;
    //             }
    //         });
    //     }
    // },
    checkBoxCheck(id){
        this.form.orders.push(id);
        console.log(this.form.orders, 'check');return
    },
    generateInvoice(checkboxes) {
      $("#invoiceModal").modal("hide");
      console.log(this.form.orders, 'check-order');
    //   var checkboxes = document.querySelectorAll(
    //     "input[type=checkbox]:checked"
    //   );
    //   for (var i = 0; i < checkboxes.length; i++) {
    //     if (checkboxes[i].id != 0) {
    //       this.form.orders.push(checkboxes[i].id);
    //     }
    //   }
    //   if (this.form.orders.length > 0) {
          console.log(this.form.orders, 'order invoioce');
        this.form.post(route("deals.invoice.create"));
    //   }
    },
    // rotateIcon(id) {
    //   let element = "collaspe-icon" + id;
    //   if (this.rotate == false) {
    //     document.getElementById(element).style.transform = "rotate(180deg)";
    //     this.rotate = true;
    //   } else {
    //     document.getElementById(element).style.transform = "rotate(0deg)";
    //     this.rotate = false;
    //   }
    // },
  },
};
</script>

<style scoped>
.t-header {
  padding-top: 10px !important;
  padding-bottom: 10px !important;
}

.circle-color {
  background-color: white !important;
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

#main #faq .card .card-header i:after {
  content: "\f107";
  font-family: "Font Awesome 5 Free";
  font-weight: 900;
  float: right;
}

svg {
  transform: rotate(90deg);
}

.custome-table td {
  border-bottom: none !important;
  border-top: 1px solid #dfe3e7 !important;
}

.card {
  border-radius: 6px !important;
  background-clip: padding-box;
  box-shadow: 0 2px 14px rgb(38 60 85 / 16%);
}

.check-down {
  margin-top: 10px;
  margin-right: 10px;
}

/*modal styling*/

.modal-header {
  border-bottom: none !important;
}

.bx-x {
  font-size: 27px !important;
  margin-top: 2px !important;
}

.close {
  border-radius: 5px !important;
  background-color: #62666642 !important;
  width: 30px !important;
  height: 30px !important;
}

.bx-x {
  font-size: 23px !important;
}

.modal-footer {
  justify-content: center !important;
  border-top: none !important;
}

.size-change {
  margin-top: 6px;
}

.error {
  color: #dc2626;
  font-size: 11.5px;
  margin-bottom: 10px;
  margin-top: 5px;
}

#modal-body-sec {
  height: 400px;
  overflow-y: auto !important;
}

#modal-body-invoice {
  height: 400px;
  overflow-y: auto !important;
}

.labelModal {
  font-size: 13px !important;
}

.badge-circle-others {
  height: 20px !important;
  width: 20px !important;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  background-color: #5a8dee;
  border-radius: 50%;
}

.actionTd {
  padding-top: 10px !important;
  padding-bottom: 8px !important;
}

.rounded-circle {
  border-radius: 50% !important;
  border: 4px solid #68e7e6 !important;
}

.product-image {
  margin-top: 3px;
  padding-right: 0px !important;
  margin-right: 0px !important;
}

.product-name {
  width: 30% !important;
}

.bx-check-circle {
  font-size: 30px !important;
  font-weight: 800;
}

.modal-font {
  font-size: 12px !important;
}

#standard_incremental_unit_fee {
  width: 93% !important;
}

.invoice-info {
  margin-top: 10px;
}

.color-button {
  color: #475f7b !important;
  margin-top: 1px;
}

.invoice {
  margin-top: 3px;
}

.show-invoice {
  margin-top: 10px;
  margin-left: 10px;
  padding-right: 10px;
}

.button-plus {
  padding-top: 0 !important;
  padding-bottom: 8px !important;
}
.scroll {
    overflow-scrolling: auto;
    height: 180px;
    overflow-y: auto;
}
.custom-spacing {
  margin-top: 18px;
}

.bx-check {
  font-size: 30px !important;
}


</style>
