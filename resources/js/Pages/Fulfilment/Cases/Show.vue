<template>
    <div>
        <admin-layout>
            <section class="invoice-view-wrapper">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-12 mt-1">
                        <div class="col-12 px-0">
                            <h5 class="card-title mb-0 pt-0">Case# {{ cases.case_number }}</h5>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-12 mt-1">
                                <div class="card invoice-print-area mb-0">
                                    <div class="card-body mx-25 pb-1">
                                        <div class="row invoice-info pr-0 mr-0">
                                            <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                                <div class="mb-0 title-col ">
                                                    <p class="padding-change">Name</p>
                                                </div>
                                                <div class="mb-0 title-col ">
                                                    <p class="padding-change">Email</p>
                                                </div>
                                                <div class="mb-0 title-col ">
                                                    <p class="padding-change">Phone</p>
                                                </div>
                                                <div class="mb-0">
                                                    <p class="padding-change">Shipping Address</p>
                                                </div>
                                                <div class="mb-0">
                                                    <p class="padding-change"
                                                       v-if="cases.order.billing_address_1_2">Billing
                                                        Address</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-md-6 col-6">
                                                <div>
                                                    <div class="mb-0">
                                                        <p class="padding-change">{{
                                                                cases.order.customer.name
                                                            }}</p>
                                                    </div>
                                                    <div class="mb-0">
                                                        <p class="padding-change">{{
                                                                cases.order.customer.email
                                                            }}</p>
                                                    </div>
                                                    <div class="mb-0">
                                                        <p class="padding-change">{{
                                                                cases.order.customer.phone
                                                            }}</p>
                                                    </div>
                                                    <div class="mb-0">
                                                        <p class="padding-change">
                                                            {{ cases.order.shipping_address_1 }}</p>
                                                    </div>
                                                    <div class="mb-0">
                                                        <p class="padding-change">
                                                            {{ cases.order.billing_address_1_2 }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                                <p class="padding-change">Order#</p>
                                                <div class="mb-0">
                                                    <p class="padding-change">Product Name</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-md-6 col-6">
                                                <div>
                                                    <div class="mb-0">
                                                        <p class="padding-change">{{
                                                                cases.order.order_number
                                                            }}</p>
                                                    </div>
                                                    <div class="mb-0">
                                                        <p class="padding-change" v-for="caseItem in cases.case_item">{{
                                                                caseItem.product ? caseItem.product.name : 'P1 T600'
                                                            }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 pt-2 pl-1">
                        <h5 class="card-title mb-0 pt-0">Case Details</h5>
                    </div>

                    <div class="col-xl-12 col-md-12 col-12 mt-1">
                        <div>
                            <form class="form" @submit.prevent="submit">
                                <div class="row px-1">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-12 px-0 pr-2">
                                                    <div class="collapsible  email-detail-head" id="collapsible">
                                                        <div class="card collapse-header ml-1 "
                                                             role="tablist"
                                                             v-for="email in cases.emails">
                                                            <div id="headingCollapse5"
                                                                 class="px-1 pt-1 pb-0 card-header d-flex justify-content-between align-items-center"
                                                                 data-toggle="collapse" role="tab"
                                                                 v-bind:data-target='"#collapse6" + email.id'
                                                                 aria-expanded="false" aria-controls="collapse5">
                                                                <div
                                                                    class="collapse-title media custom-class d-flex justify-content-between w-100">
                                                                    <!--                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #A2AAB3;transform: ;msFilter:;"><path d="M20 4H6c-1.103 0-2 .897-2 2v5h2V8l6.4 4.8a1.001 1.001 0 0 0 1.2 0L20 8v9h-8v2h8c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm-7 6.75L6.666 6h12.668L13 10.75z"></path><path d="M2 12h7v2H2zm2 3h6v2H4zm3 3h4v2H7z"></path></svg>-->
                                                                    <i class="bx bx-mail-send"
                                                                       style="font-size: 16px; margin-top: 11px"></i>
                                                                    <div class="media-body px-0">
                                                                        <div
                                                                            class="row">
                                                                            <div class="col-4">
                                                                                <span class=""
                                                                                      style="padding-right: 25px">
                                                                                    <div class="collapse-title media">
                                                                                        <div class="media-body mt-50">
                                                                                            <span class=""
                                                                                                  style="font-size: 16px;">{{
                                                                                                    email.from_name
                                                                                                }}  &lt;{{
                                                                                                    email.from_email
                                                                                                }}&gt;</span><br>
                                                                                        </div>
                                                                                    </div>
                                                                                </span>
                                                                            </div>
                                                                            <div class="text-center col-4"
                                                                                 style="margin-top: 5px">
                                                                                <span class=""
                                                                                      style="padding-right: 25px;font-size: 16px;"> {{
                                                                                        email.subject
                                                                                    }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div
                                                                                    class="information d-sm-flex justify-content-end d-none date text-right mt-30">
                                                                                    <small class=""
                                                                                           style="font-size: 14px; margin-top: 5px; margin-left: 30px">
                                                                                        {{ formatDate(email.date) }}
                                                                                        <span class="favorite"
                                                                                              style="margin-top: 15px;">
                                                                                           <i class="bx bx-star"></i>
                                                                                         </span>
                                                                                    </small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div v-bind:id='"collapse6" +email.id' role="tabpanel"
                                                                 aria-labelledby="headingCollapse5"
                                                                 class="collapse">
                                                                <div>
                                                                    <div class="card-content custom-class">
                                                                        <div class="card-body py-0">
                                                                            <div
                                                                                class="media-body email-space d-flex justify-content-between py-0">
                                                                                <div>
                                                                                    <span class="d-sm-inline">
                                                                                        From:  {{ email.from_name }}
                                                                                    </span>
                                                                                    <span class="d-sm-inline">
                                                                                        &lt;{{
                                                                                            email.from_email
                                                                                        }}&gt;
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="media-body email-space">
                                                                                <span class="d-sm-inline">
                                                                                    To: {{ email.to_name }}
                                                                                </span>
                                                                                <span class="d-sm-inline">
                                                                                     &lt;{{ email.to_email }}&gt;
                                                                                </span>
                                                                            </div>
                                                                            <div class="media-body email-space">
                                                                                <span
                                                                                    class="d-sm-inline">
                                                                                     <span
                                                                                         class=""> Subject:</span>
                                                                                    {{ email.subject }}
                                                                                </span>
                                                                            </div>
                                                                            <p class="text-bold-500"></p>
                                                                            <div class="image ">
                                                                                <p>
                                                                                    <span v-html="email.body"></span>
                                                                                </p>
                                                                            </div>
                                                                            <p class="mb-0">Sincerely yours,</p>
                                                                            <p class="text-bold-500">Attached File
                                                                            </p>
                                                                            <span
                                                                                v-for="attachment in email.attachments"
                                                                                class="d-flex">
                                                                                <div class="file d-inline mr-1">
                                                                                    <i class="bx bxs-file-blank"
                                                                                       type='solid'></i>
                                                                                </div>
                                                                                <label class="sidebar-label">
                                                                                    <p
                                                                                        class="mr-1">
                                                                                        {{
                                                                                            attachment.name + '(' + attachment.size + ')'
                                                                                        }}
                                                                                    </p>
                                                                                </label>
                                                                                <span
                                                                                    class="mr-1 show">
                                                                                    <a :href="attachment.url"
                                                                                       class="">
                                                                                        <i class="bx bxs-show font-medium-1"></i>
                                                                                    </a>
                                                                                </span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ps__rail-x"
                                                                         style="left: 0px; bottom: -254px;">
                                                                        <div class="ps__thumb-x" tabindex="0"
                                                                             style="left: 0px; width: 0px;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="ps__rail-y"
                                                                         style="top: 254px; height: 767px; right: 0px;">
                                                                        <div class="ps__thumb-y" tabindex="0"
                                                                             style="top: 191px; height: 576px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                        <div class="form-group pt-1 my-0">
                                                            <label>Source*</label>
                                                            <select class="form-select" id="source"
                                                                    @change="otherSource"
                                                                    name="source"
                                                                    v-model="form.source">
                                                                <option value="" disabled>Select Source</option>
                                                                <option v-for="source in sources"
                                                                        :value="source.value">
                                                                    {{ source.value }}
                                                                </option>
                                                                <ErrorComponent
                                                                    input="case_types"></ErrorComponent>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                        <div class="form-group pt-1 my-0" v-if="sourceField">
                                                            <label for="order-number">Other's</label>
                                                            <input type="text" v-model="form.source_other"
                                                                   id="source_other"
                                                                   class="form-control"
                                                                   name="source_other">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                        <div class="form-group pt-1 my-0">
                                                            <label>Priority*</label>
                                                            <select id="priority" name="priority"
                                                                    v-model="form.priority"
                                                                    class="form-select">
                                                                <option value="" disabled>Select Priority</option>
                                                                <option v-for="prioritys in priorities"
                                                                        :value="prioritys.value">
                                                                    {{ prioritys.value }}
                                                                </option>
                                                                <ErrorComponent
                                                                    input="priority"></ErrorComponent>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                        <div class="form-group pt-1 my-0">
                                                            <label>Case type*</label>
                                                            <select class="form-select" id="type"
                                                                    @change="otherType"
                                                                    name="type"
                                                                    v-model="form.type">
                                                                <option value="" disabled>Select Case Type</option>
                                                                <option v-for="case_type in case_types"
                                                                        :value="case_type.value">
                                                                    {{ case_type.value }}
                                                                </option>
                                                                <ErrorComponent
                                                                    input="case_types"></ErrorComponent>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                        <div class="form-group pt-1 my-0" v-if="typeField">
                                                            <label for="order-number">Other's</label>
                                                            <input type="text" v-model="form.type_other"
                                                                   id="typeField"
                                                                   class="form-control"
                                                                   name="type_other">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                        <div class="form-group pt-1 my-0">
                                                            <label>Customer Note</label>
                                                            <textarea class="form-control no-resize"
                                                                      v-model="form.description"
                                                                      rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                        <div class="form-group pt-1 my-0">
                                                            <label>Order status</label>
                                                            <select class="form-select" id="case_status"
                                                                    name="case_status"
                                                                    v-model="form.status">
                                                                <option value=""></option>
                                                                <option v-for="status in case_statuses"
                                                                        :value="status.value">
                                                                    {{ status.value }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-11 d-flex justify-content-start px-0 pt-3 pl-1">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('case.create',cases.id)"
                                                              type="button"
                                                              class="btn btn-light-secondary mr-1 mb-1">
                                                    Back
                                                </inertia-link>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="col-12">
                                            <div data-v-3b708b6e="" class="row pb-0.5">
                                                <div class="col-10">
                                                    <h5 class="card-title mb-0 pt-1">
                                                        Documents</h5></div>
                                                <div class="col-2">
                                                    <div class="col form-group pr-0 pb-1">
                                                        <a :href="route('case.document.create',cases.id)"
                                                           class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card" v-if="cases.documents.length > 0">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <div>
                                                            <table class="table table-hover mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th class="text-left pl-1 py-0 my-0 text-truncate t-header">
                                                                        Title
                                                                    </th>
                                                                    <th class="text-center py-0 my-0 text-truncate t-header">
                                                                        File
                                                                    </th>
                                                                    <th class="text-center py-0 my-0 text-truncate t-header">
                                                                        Description
                                                                    </th>
                                                                    <th class="text-right r py-0 my-0 text-truncate t-header"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="document in cases.documents"
                                                                    class="py-0 my-0">
                                                                    <td class="text-left cursor-pointer px-1 py-0 my-0 text-truncate">
                                                                        <div v-if="document.file_type === 'pdf'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'csv'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file success font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'docx'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file-doc primary font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'txt'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file-txt font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'jpg'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file-jpg font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'png'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file-png font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'TXT'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file-txt font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>

                                                                        <div
                                                                            v-else-if="document.file_type === 'PDF'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'CSV'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file success font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'DOCX'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file-doc primary font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'JPG'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file-jpg font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'PNG'">
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file-png font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div v-else>
                                                                            <a :href="route('view.case.document',document.id)">
                                                                                <i class="bx bxs-file-image font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ document.file.substring(22) }}
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ document.description }}
                                                                    </td>
                                                                    <td class="text-right text-small action pr-1">

                                                                        <div class="dropdown">
                                                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                                                </span>
                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                <a :href="route('export.case.document',document.id)" class="dropdown-item"><i class="bx bx-download mr-1"></i>Download</a>
                                                                                                <a :href="route('case.document.edit', document.id)" class="dropdown-item"><i class="bx bx-edit-alt  mr-1"></i>Edit</a>
                                                                                                  <a class="dropdown-item" v-on:click="confirmDelete(document.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="col-12">
                                            <div data-v-3b708b6e="" class="row pb-0.5">
                                                <div class="col-10">
                                                    <h5 class="card-title mb-0 pt-1">Notes</h5>
                                                </div>
                                                <div class="col-2">
                                                    <div class="col form-group pr-0 pb-1">
                                                        <a :href="route('case.notes.create',cases.id)"
                                                           class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1">
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card" v-if="cases.notes.length > 0">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <div>
                                                            <table class="table table-hover mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th class="text-left pl-1 py-0 my-0 text-truncate t-header">
                                                                        User
                                                                    </th>
                                                                    <th class="text-center py-0 my-0 text-truncate t-header">
                                                                        Date
                                                                    </th>
                                                                    <th class="text-center py-0 my-0 text-truncate t-header">
                                                                        Comments
                                                                    </th>
                                                                    <th class="text-right r py-0 my-0 text-truncate t-header"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="note in cases.notes"
                                                                    class="py-0 my-0">
                                                                    <td class="text-left cursor-pointer px-1 py-0 my-0 text-truncate">
                                                                        {{ note.user.name }}
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ formatDate(note.created_at) }}
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ note.comment }}
                                                                    </td>
                                                                    <td class="text-right text-small action pr-1">
                                                                        <div class="dropdown">
                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                <a  :href="route('case.notes.edit', note.id)" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                                <a class="dropdown-item" v-on:click="confirmNotesDelete(note.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                               @deleteitem="deleteItem">
            </ConfirmatiomModal>
        </admin-layout>
    </div>
</template>

<script>
import moment from 'moment';
import Button from "../../../Jetstream/Button"
import Pagination from "../../../admin/Pagination";
import AdminLayout from "../../../Layouts/AdminLayout";
import ErrorComponent from '../../../components/ErrorComponent'
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";

export default {

    name: "Show",
    props: ['cases', 'sources', 'priorities', 'case_types', 'case_statuses', 'typeField'],

    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
        ErrorComponent
    },

    data() {
        return {
            query: {
                query: '',
                id: false,
                name: false,
                enable: false,
                disable: false,
                direction: null
            },
            ErrorComponent: false,
            sweetAlert: false,
            sourceField: false,
            typeField: false,
            itemId: '',
            notesId: '',
        }
    },

    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Show Details";
        if (this.cases) {
            this.update = true;
            let data = this.cases;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },

    mounted() {
        if (this.params) {
            Object.assign(this.query, this.params);
        }
    },

    methods: {
        submit() {
            this.form.id = this.cases.id ? this.cases.id : '';
            this.form.post(route('case.update', this.cases.id))
        },
        otherSource: function () {
            if (this.form.source == 'Others') {
                this.form.source = this.form.source;
                this.sourceField = true;
            } else {
                this.sourceField = false;
            }
        },

        otherType: function () {
            if (this.form.type == 'Others') {
                this.form.type = this.form.type;
                this.typeField = true;
            } else {
                this.typeField = false;
            }
        },

        Clicked() {
            this.sweetAlert = false
        },

        deleteItem() {
            if (this.itemId) {
                this.sweetAlert = false
                this.$inertia.delete(`/fulfilment/cases/document/delete/${this.itemId}`)
            }
            if (this.notesId) {
                this.sweetAlert = false
                this.$inertia.delete(`/fulfilment/cases/notes/${this.notesId}/delete`)
            }
        },

        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
            this.submit = false;
        },

        confirmNotesDelete(id) {
            this.sweetAlert = true;
            this.notesId = id;
            this.submit = false;
        },

        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
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
    width: 100%;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.text-title-icon {
    vertical-align: super;
}
</style>
