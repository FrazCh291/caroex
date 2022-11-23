<template>
    <div>
        <admin-layout>
            <section class="invoice-view-wrapper">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-12 mt-1">
                        <div class="col-12 px-0">
                            <h6 class="card-title mb-0 pt-0">Case# {{ cases.case_number }}</h6>
                        </div>
                        <div class="row">
                            <div v-if="cases.order" class="col-xl-12 col-md-12 col-12 mt-1">
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
                                                    <p v-if="cases.order.billing_address_1_2"
                                                       class="padding-change">Billing
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
                                                        <p v-for="caseItem in cases.case_item" class="padding-change">{{
                                                                caseItem.product ? caseItem.product.name : 'P1 T600'
                                                            }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="col-xl-12 col-md-12 col-12 mt-1">
                                <p>No Order Exist</p>
                            </div>
                        </div>
                    </div>
                    <div v-if="cases.emails.length>0" class="col-12 pt-1 pl-1 d-flex justify-content-between">
                        <h6 class="card-title mb-0 pt-1">Emails</h6>
                        <span class="btn btn-primary" data-repeater-create="" @click="chennalEmail">
                      Fetch Emails
                 </span>
                    </div>
                    <div v-if="cases.emails.length>0" class="col-12 pt-1 pl-1">
                        <div class="card mb-0">
                            <div class="card-body email-card">
                                <div class="row">
                                    <div class="col-12 px-0 pr-2">
                                        <div id="collapsible" class="collapsible  email-detail-head">
                                            <div v-for="email in cases.emails"
                                                 class="card collapse-header ml-1 "
                                                 role="tablist"
                                                 @click="changeStatus($event)">
                                                <div id="headingCollapse5"
                                                     aria-controls="collapse5"
                                                     aria-expanded="false"
                                                     class="px-1 pt-0 pb-0 card-header d-flex justify-content-between align-items-center border-0"
                                                     data-toggle="collapse"
                                                     role="tab" v-bind:data-target='"#collapse6" + email.id'>
                                                    <div
                                                        class="collapse-title media custom-class d-flex justify-content-between w-100 custom-collapse">
                                                        <i class="bx bx-mail-send"
                                                           style="font-size: 16px; margin-top: 5px"></i>
                                                        <div class="media-body px-0">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <span class="" style="padding-right: 25px">
                                                                        <div class="collapse-title media">
                                                                            <div class="media-body mt-0">
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
                                                                <div class="col-3">
                                                                    <div class="d-flex">
                                                                        <small
                                                                            class="d-sm-inline d-none">
                                                                            to:{{
                                                                                email.to_email
                                                                            }}
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="text-center col-3">
                                                                    <span class=""
                                                                          style="padding-right: 25px;font-size: 16px;"> {{
                                                                            email.subject
                                                                        }}
                                                                    </span>
                                                                </div>
                                                                <div class="col-2">
                                                                    <div
                                                                        class="information d-sm-flex justify-content-end d-none date text-right mt-30">
                                                                        <small class=""
                                                                               style="font-size: 14px; margin-top: 0px; margin-left: 30px">
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
                                                <div v-bind:id='"collapse6" +email.id'
                                                     aria-labelledby="headingCollapse5"
                                                     class="collapse"
                                                     role="tabpanel">
                                                    <div>
                                                        <div class="card-content custom-class">
                                                            <div class="card-body py-1">
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
                                                                    <div>
                                                                        <button title="Reply" type="button">
                                                                            <svg aria-controls="collapseReply"
                                                                                 aria-expanded="false"
                                                                                 class="d-inline-block mr-1"
                                                                                 data-target="#collapseReply"
                                                                                 data-toggle="collapse"
                                                                                 height="20"
                                                                                 style="fill: #CACACA;transform: ;msFilter:;"
                                                                                 viewBox="0 0 24 24"
                                                                                 width="20"
                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M10 11h6v7h2v-8a1 1 0 0 0-1-1h-7V6l-5 4 5 4v-3z"></path>
                                                                            </svg>
                                                                        </button>
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
                                                                    <span class="d-sm-inline">
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
                                                                        <p class="mr-1">
                                                                            {{
                                                                                attachment.name + '(' + attachment.size + ')'
                                                                            }}
                                                                        </p>
                                                                    </label>
                                                                    <span class="mr-1 show">
                                                                        <a :href="attachment.url"
                                                                           class="">
                                                                            <i class="bx bxs-show font-medium-1"></i>
                                                                        </a>
                                                                    </span>
                                                                    <td class="text-small py-0 my-0 action pr-1">
                                                                        <span
                                                                            class="d-inline-flex align-items-center action">
                                                                            <a :href="route('export.attachment',attachment.id)">
                                                                                <span class="">
                                                                                    <i class="bx bx-download font-medium-1 align-items-center text-center show1"></i>
                                                                                </span>
                                                                            </a>
                                                                        </span>
                                                                    </td>
                                                                </span>
                                                            </div>
                                                            <div class="card-footer pt-0 border-top">
                                                            </div>
                                                            <div v-for="childEmail in email.child_emails">
                                                                <div class="card-body py-1">
                                                                    <div class="media-body  email-space">
                                                                        <span class="d-sm-inline">
                                                                            From:  {{ email.to_name }}
                                                                        </span>
                                                                        <span class="d-sm-inline">
                                                                            &lt;{{ email.to_email }}&gt;
                                                                        </span>
                                                                    </div>
                                                                    <div class="media-body email-space">
                                                                        <span class="d-sm-inline">
                                                                            To:  {{ email.from_name }}
                                                                        </span>
                                                                        <span class="d-sm-inline">
                                                                            &lt;{{ email.from_email }}&gt;
                                                                        </span>
                                                                    </div>
                                                                    <div class="media-body email-space">
                                                                        <span class="d-sm-inline">
                                                                            <span class=""> Subject RE:</span>
                                                                            {{ email.subject }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="image">
                                                                        <p>
                                                                            <span
                                                                                v-html="childEmail.body">
                                                                            </span>
                                                                        </p>
                                                                    </div>
                                                                    <p class="mb-0">Sincerely yours,</p>
                                                                    <p class="text-bold-500">Envato Design
                                                                        Team
                                                                    </p>
                                                                    <span
                                                                        v-for="attachment in childEmail.attachments"
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
                                                                        <span class="show mr-1">
                                                                            <a :href="attachment.url"
                                                                               class="">
                                                                                <i class="bx bxs-show font-medium-1"></i>
                                                                            </a>
                                                                        </span>
                                                                        <td class="text-small py-0 my-0 action pr-1">
                                                                            <span
                                                                                class="d-inline-flex align-items-center action">
                                                                                <a :href="route('export.attachment',attachment.id)">
                                                                                    <span
                                                                                        class="">
                                                                                        <i class="bx bx-download font-medium-1 align-items-center text-center show1"></i>
                                                                                    </span>
                                                                                </a>
                                                                            </span>
                                                                        </td>
                                                                    </span>
                                                                    <div
                                                                        class="card-footer pt-0 border-bottom "></div>
                                                                </div>
                                                            </div>
                                                            <div class="row px-2 mb-4">
                                                                <!-- quill editor for reply message -->
                                                                <div id="collapseReply"
                                                                     class="col-12 px-0 collapse">
                                                                    <EmailForm :email="email"></EmailForm>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ps__rail-x"
                                                             style="left: 0px; bottom: -254px;">
                                                            <div class="ps__thumb-x" style="left: 0px; width: 0px;"
                                                                 tabindex="0">
                                                            </div>
                                                        </div>
                                                        <div class="ps__rail-y"
                                                             style="top: 254px; height: 767px; right: 0px;">
                                                            <div class="ps__thumb-y" style="top: 191px; height: 576px;"
                                                                 tabindex="0">
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
                    <div class="col-12 pt-1 pl-1">
                        <h6 class="card-title mb-0 pt-0">Case Details</h6>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12 mt-1">
                        <div>
                            <form class="form" @submit.prevent="submit">
                                <div class="row px-1">
                                    <div class="card py-o">
                                        <div class="card-body py-0">
                                            <div class="row">
                                                <div class="col-12 px-0">
                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                        <div class="form-group pt-1 my-0">
                                                            <label>Source*</label>
                                                            <select id="source" v-model="form.source"
                                                                    class="form-select"
                                                                    name="source"
                                                                    @change="otherSource">
                                                                <option disabled value="">Select Source</option>
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
                                                        <div v-if="sourceField" class="form-group pt-1 my-0">
                                                            <label for="order-number">Other's</label>
                                                            <input id="source_other" v-model="form.source_other"
                                                                   class="form-control"
                                                                   name="source_other"
                                                                   type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                        <div class="form-group pt-1 my-0">
                                                            <label>Priority*</label>
                                                            <select id="priority" v-model="form.priority"
                                                                    class="form-select"
                                                                    name="priority">
                                                                <option disabled value="">Select Priority</option>
                                                                <option v-for="prioritys in priorities"
                                                                        :value="prioritys.value">
                                                                    {{ prioritys.value }}
                                                                </option>
                                                                <ErrorComponent
                                                                    input="priority"></ErrorComponent>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">-->
                                                    <!--                                                        <div class="form-group pt-1 my-0">-->
                                                    <!--                                                            <label>Case type*</label>-->
                                                    <!--                                                            <select class="form-select" id="type"-->
                                                    <!--                                                                    @change="otherType"-->
                                                    <!--                                                                    name="type"-->
                                                    <!--                                                                    v-model="form.type">-->
                                                    <!--                                                                <option value="" disabled>Select Case Type</option>-->
                                                    <!--                                                                <option v-for="case_type in case_types"-->
                                                    <!--                                                                        :value="case_type.value">-->
                                                    <!--                                                                    {{ case_type.value }}-->
                                                    <!--                                                                </option>-->
                                                    <!--                                                                <ErrorComponent-->
                                                    <!--                                                                    input="case_types"></ErrorComponent>-->
                                                    <!--                                                            </select>-->
                                                    <!--                                                        </div>-->
                                                    <!--                                                    </div>-->
                                                    <!--                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">-->
                                                    <!--                                                        <div v-if="typeField" class="form-group pt-1 my-0">-->
                                                    <!--                                                            <label for="order-number">Other's</label>-->
                                                    <!--                                                            <input id="typeField" v-model="form.type_other"-->
                                                    <!--                                                                   class="form-control"-->
                                                    <!--                                                                   name="type_other"-->
                                                    <!--                                                                   type="text">-->
                                                    <!--                                                        </div>-->
                                                    <!--                                                    </div>-->
                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                        <div class="form-group pt-1 my-0">
                                                            <label>Customer Note</label>
                                                            <textarea v-model="form.description"
                                                                      class="form-control no-resize"
                                                                      rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                        <div class="form-group pt-1 my-0">
                                                            <label>Order status</label>
                                                            <select id="case_status" v-model="form.status"
                                                                    class="form-select"
                                                                    name="case_status">
                                                                <option value=""></option>
                                                                <option v-for="status in case_statuses"
                                                                        :value="status.value">
                                                                    {{ status.value }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-11 d-flex justify-content-start px-0 pt-1 pl-1">
                                                    <button class="btn btn-primary mr-1 mb-1" type="submit">
                                                        Save
                                                    </button>
                                                    <inertia-link :href="route('cases.index',cases.id)"
                                                                  class="btn btn-light-secondary mr-1 mb-1"
                                                                  type="button">
                                                        Back
                                                    </inertia-link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card document-card">
                                        <div class="col-12 px-2">
                                            <div class="row pb-0.5" data-v-3b708b6e="">
                                                <div class="col-11">
                                                    <h5 class="card-title mb-0 pt-1">
                                                        Case Task</h5></div>
                                                <div class="col-1 document-add">
                                                    <span
                                                        class="bx bxs-plus-circle primary float-right add-btn font-large-1"
                                                        data-target="#addDocs"
                                                        data-toggle="modal"
                                                        @click="addCaseTypes()">
                                                    </span>
                                                </div>
                                            </div>
                                            <div v-if="cases.case_task?cases.case_task.length>0:''" class="card">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <div>
                                                            <table class="table table-hover mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th>User</th>
                                                                    <th>Type</th>
                                                                    <th>Description</th>
                                                                    <th class="text-center">Date & Time</th>
                                                                    <th class="text-right"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="casetype in cases.case_task"
                                                                    class="py-0 my-0">
                                                                    <td>{{
                                                                            casetype.usertask ? casetype.usertask.name : ''
                                                                        }}
                                                                    </td>
                                                                    <td>{{
                                                                            casetype.case_types ? casetype.case_types.value : ''
                                                                        }}
                                                                    </td>
                                                                    <td>{{
                                                                            casetype.description
                                                                        }}
                                                                    </td>
                                                                    <td class="text-center">{{
                                                                            formatDate(casetype.updated_at)
                                                                        }}
                                                                    </td>
                                                                 <td class="text-right">
                                                                <div class="dropdown">
                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item"  data-target="#addDocs" data-toggle="modal" v-on:click="editCaseType(casetype.id)"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                                <a class="dropdown-item"  v-on:click="deleteCaseType(casetype.id)"><i class="bx bx-trash mr-1"></i> delete</a>
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
                                    <div class="card document-card" v-if="cases.case_spare_part_item?cases.case_spare_part_item.length>0:''">
                                        <div class="col-12 px-2">
                                            <div class="row pb-1" data-v-3b708b6e="">
                                                <div class="col-11">
                                                    <h5 class="card-title mb-0 pt-1">
                                                        Case Spare Part</h5>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <div>
                                                            <table class="table table-hover mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th>Spare Part</th>
                                                                    <th class="text-center">Shipping Date</th>
                                                                    <th class="text-center">Status</th>
                                                                    <th class="text-center">Date & Time</th>
                                                                    <th class="text-right"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="caseSparePart in cases.case_spare_part_item"
                                                                    class="py-0 my-0">
                                                                    <td>{{
                                                                            caseSparePart.spare_part ? caseSparePart.spare_part.name : ''
                                                                        }}
                                                                    </td>
                                                                    <td>{{
                                                                            caseSparePart.shipping_date ? formatDate(caseSparePart.shipping_date) : ''
                                                                        }}
                                                                    </td>
                                                                    <td class="text-truncate text-center">
                                                                        <span
                                                                            v-if="caseSparePart.status == 'case_sparepart_pending'"
                                                                            class="badge badge-light-danger badge-pill ">
                                                                             {{
                                                                                caseSparePart.statuss ? caseSparePart.statuss.value : ''
                                                                            }}
                                                                        </span>
                                                                        <span
                                                                            v-if="caseSparePart.status == 'case_sparepart_autherize'"
                                                                            class="badge badge-pill badge-light-warning ">
                                                                             {{
                                                                                caseSparePart.statuss ? caseSparePart.statuss.value : ''
                                                                            }}
                                                                         </span>
                                                                        <span
                                                                            v-if="caseSparePart.status == 'case_sparepart_shipped'"
                                                                            class="badge badge-pill badge-light-secondary ">
                                                                              {{
                                                                                caseSparePart.statuss ? caseSparePart.statuss.value : ''
                                                                            }}
                                                                        </span>
                                                                        <span
                                                                            v-if="caseSparePart.status == 'case_sparepart_delivered'"
                                                                            class="badge badge-pill badge-light-success ">
                                                                             {{
                                                                                caseSparePart.statuss ? caseSparePart.statuss.value : ''
                                                                            }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">{{
                                                                            formatDate(caseSparePart.updated_at)
                                                                        }}
                                                                    </td>
                                                                    <td class="text-right">
                                                                                                                                        <div class="dropdown">
                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" data-target="#updateStatus" data-toggle="modal" v-on:click="updateSparePartStatus(caseSparePart.id)"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                                <a class="dropdown-item" v-on:click="deleteSparePartStatus(caseSparePart.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                    <div class="card document-card">
                                        <div class="col-12 px-2">
                                            <div class="row pb-0.5" data-v-3b708b6e="">
                                                <div class="col-10">
                                                    <h5 class="card-title mb-0 pt-1">
                                                        Documents</h5></div>
                                                <div class="col-2 document-add">
                                                    <a :href="route('cases.document.create',cases.id)"
                                                       class="bx bxs-plus-circle primary float-right add-btn font-large-1">
                                                    </a>
                                                </div>
                                            </div>
                                            <div v-if="cases.documents.length > 0" class="card">
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
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'csv'">
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file success font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'docx'">
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file-doc primary font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'txt'">
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file-txt font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'jpg'">
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file-jpg font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'png'">
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file-png font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'TXT'">
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file-txt font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>

                                                                        <div
                                                                            v-else-if="document.file_type === 'PDF'">
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'CSV'">
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file success font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'DOCX'">
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file-doc primary font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'JPG'">
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file-jpg font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div
                                                                            v-else-if="document.file_type === 'PNG'">
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file-png font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                        <div v-else>
                                                                            <a :href="route('view.cases.document',document.id)">
                                                                                <i class="bx bxs-file-image font-large-1"></i>
                                                                            </a>
                                                                            <span class="text-title-icon pl-0.5">{{
                                                                                    document.title
                                                                                }}</span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ document.file.substring(18) }}
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ document.description }}
                                                                    </td>
                                                                    <td class="text-right text-small action pr-1">
                                                                        <a :href="route('export.cases.document', document.id)">
                                                                                    <span
                                                                                        class="badge-circle badge-circle-light-secondary action">
                                                                                        <i class="bx bx-download font-medium-1 align-items-center text-center"></i>
                                                                                    </span>
                                                                        </a>
                                                                        <inertia-link
                                                                            :href="route('cases.document.edit', document.id)">
                                                                                    <span
                                                                                        class="badge-circle badge-circle-light-secondary  action">
                                                                                        <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                                                                    </span>
                                                                        </inertia-link>
                                                                        <button
                                                                            v-on:click="confirmDelete(document.id)">
                                                                            <span
                                                                                class="badge-circle badge-circle-light-secondary ml-1/6">
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
                                    </div>
                                    <div class="card document-card">
                                        <div class="col-12 px-2">
                                            <div class="row pb-0.5" data-v-3b708b6e="">
                                                <div class="col-10">
                                                    <h5 class="card-title mb-0 pt-1">Notes</h5>
                                                </div>
                                                <div class="col-2 document-add">
                                                    <div class="col form-group pr-0 pb-1">
                                                        <a :href="route('cases.notes.create',cases.id)"
                                                           class="bx bxs-plus-circle primary float-right add-btn font-large-1">
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                            <div v-if="cases.notes.length > 0" class="card">
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
                                                                        {{ note.user ? note.user.name : '' }}
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ formatDate(note.updated_at) }}
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ note.comment }}
                                                                    </td>
                                                                    <td class="text-right text-small action pr-1">
                                                                        <inertia-link
                                                                            :href="route('cases.notes.edit', note.id)">
                                                                                <span
                                                                                    class="badge-circle badge-circle-light-secondary  action">
                                                                                    <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                                                                </span>
                                                                        </inertia-link>
                                                                        <button
                                                                            v-on:click="confirmNotesDelete(note.id)">
                                                                                <span
                                                                                    class="badge-circle badge-circle-light-secondary ml-1/6">
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
                                    </div>
                                </div>
                            </form>
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
                                            Case Task </h4>
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
                                            <li v-for="error in errors" class="error">{{ error }}</li>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <label>Case Type *</label>
                                                <select id="type" v-model="form2.case_type"
                                                        class="form-select"
                                                        name="type"
                                                        @change="otherType">
                                                    <option value="">Select Case Type</option>
                                                    <option v-for="case_type in case_types"
                                                            :value="case_type.slug">
                                                        {{ case_type.value }}
                                                    </option>
                                                    <ErrorComponent
                                                        input="case_types"></ErrorComponent>
                                                </select>
                                            </div>
                                            <div
                                                v-if="spare_part ||  this.cases.case_spare_part_item  && this.form2.case_type == 'spareparts'"
                                                class="form-group py-0 my-0 mb-1">
                                                <label>Spare Part *</label>
                                                <div>
                                                    <Multiselect123 v-model="form2.value"
                                                                    :createTag="true"
                                                                    :options="options"
                                                                    :searchable="true"
                                                                    class="form-group"
                                                                    mode="tags"/>
                                                </div>

                                                <!--                                                <select id="type" v-model="form2.sparepart_id"-->
                                                <!--                                                        class="form-select"-->
                                                <!--                                                        name="type">-->
                                                <!--                                                    <option value="">Select Case Type</option>-->
                                                <!--                                                    <option v-for="spareParts in spareParts"-->
                                                <!--                                                            :value="spareParts.id">-->
                                                <!--                                                        {{ spareParts.name + ' ' + '(' + spareParts.code + ')'   }}-->
                                                <!--                                                    </option>-->
                                                <!--                                                    <ErrorComponent-->
                                                <!--                                                        input="case_types"></ErrorComponent>-->
                                                <!--                                                </select>-->
                                            </div>
                                            <div class="form-group py-0 my-0">
                                                <label>Description</label>
                                                <textarea id="description" v-model="form2.description"
                                                          class="form-control"
                                                          name="description" placeholder="Textarea"
                                                          rows="2"></textarea>
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
                                                    @click="typenew(form2.id)">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span
                                                    class="d-none d-sm-block">Add</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="updateStatus"
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
                                            Case Task </h4>
                                        <button aria-label="Close"
                                                class="close"
                                                data-dismiss="modal"
                                                type="button">
                                            <i class="bx bx-x"></i>
                                        </button>
                                    </div>
                                    <form class="form form-horizontal">
                                        <div class="modal-body">
                                            <div v-if="spare_part ||  this.cases.case_spare_part_item"
                                                 class="form-group py-0 my-0 mb-1">
                                                <label>Spare Part *</label>
                                                <div>
                                                    <Multiselect123 v-model="form3.value"
                                                                    :createTag="true"
                                                                    :options="options"
                                                                    :searchable="true"
                                                                    class="form-group"
                                                                    disabled mode="tags"/>
                                                </div>
                                            </div>
                                            <div class="form-group py-0 my-0 mb-1">
                                                <label>Spare Part Status *</label>
                                                <select id="type" v-model="form3.spare_part_status"
                                                        class="form-select"
                                                        name="type">
                                                    <option value="">Select Case Type</option>
                                                    <option v-for="sparePartStatus in sparePartStatuss"
                                                            :value="sparePartStatus.slug">
                                                        {{ sparePartStatus.value }}
                                                    </option>
                                                    <ErrorComponent
                                                        input="case_types"></ErrorComponent>
                                                </select>
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
                                                    @click="statusUpdate(form3.id)">
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
            </section>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                               @deleteitem="deleteItem">
            </ConfirmatiomModal>
        </admin-layout>
    </div>
</template>

<script>
import moment from 'moment';
import Button from "../../Jetstream/Button"
import EmailForm from "@/components/EmailForm";
import Pagination from "../../admin/Pagination";
import Multiselect123 from '@vueform/multiselect'
import AdminLayout from "../../Layouts/AdminLayout";
import ErrorComponent from '../../components/ErrorComponent'
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {

    name: "Show",
    props: ['cases', 'sources', 'priorities', 'case_types', 'case_statuses', 'spareParts', 'sparePartStatuss'],

    components: {
        EmailForm,
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
        ErrorComponent,
        Multiselect123
    },

    data() {
        return {
            query: {
                query: '',
                id: false,
                name: false,
                enable: false,
                disable: false,
                updated: false,
                direction: null,
            },
            ErrorComponent: false,
            spare_part: false,
            sweetAlert: false,
            sourceField: false,
            itemId: '',
            notesId: '',
            form2: this.$inertia.form({
                id: '',
                case_id: this.cases.id,
                case_type: '',
                description: '',
                value: []
            }),
            form3: this.$inertia.form({
                id: '',
                id2: '',
                case_id: this.cases.id,
                spare_part_status: '',
                value: []
            }),
            options: [],
            errors: [],
            sparepart_item: []
        }
    },

    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Show Details";
        if(this.spareParts){
            this.spareParts.forEach((value, index) => {
            var obj = {"value": value.id, "label": value.name};
            this.options.push(obj);
        });
        }
        console.log(this.cases.case_spare_part_item, 'khurram');
        if (this.cases) {
            this.update = true;
            let data = this.cases;
            Object.assign(data, {
                '_method': 'PUT',
            })
            // this.form2.value = this.cases.case_spare_part_item
            this.form = this.$inertia.form(data);
        }
    },

    mounted() {
        if (this.params) {
            Object.assign(this.query, this.params);
        }
        if (this.values) {
            this.values.forEach((value, index) => {
                this.form2.value.push(value.id);
            });
        }
    },

    methods: {
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY hh:mm')
        },
        submit() {
            this.form.id = this.cases.id ? this.cases.id : '',
                this.form.post(route('cases.update', this.cases.id))
        },

        typenew(id) {
            console.log(this.form2)
            this.errors = [];
            if (!this.form2.case_type) {
                this.errors.push('Type required.');
                event.stopPropagation();
            } else if (this.form2.case_type == 'spareparts' && !this.form2.value.length > 0) {
                this.errors.push('Spare Part required.');
                event.stopPropagation();
            } else {
                if (this.updated) {
                    this.form2.put(route('cases.type.update', id))
                } else {
                    this.form2.post(route('cases.type.store', {case_id: this.cases.id}))
                }
            }
        },
        statusUpdate(id) {
            this.form3.id2 = this.cases.id
            this.form3.put(route('cases.type.update', id))
        },

        addCaseTypes() {
            this.errors = [];
            this.updated = false
            this.form2 = this.$inertia.form({
                case_type: '',
                value: [],
                description: '',
            });
        },
        editCaseType(id) {
            let case_type = this.cases.case_task.find(case_task => case_task.id == id);
            this.updated = true
            let parts = [];
            this.form2.value = [];
            if (case_type.case_type == 'spareparts') {
                this.cases.case_spare_part_item.forEach((value, index) => {
                    var sparepart_itemss = this.cases.case_spare_part_item.find(spare_Part_items => spare_Part_items.id == value.id);
                    if (sparepart_itemss.case_task_id === case_type.id && sparepart_itemss.id == value.id) {
                        var spareparts = this.spareParts.find(spare_Part => spare_Part.id == sparepart_itemss.sparepart_id);
                        var obj = {"value": spareparts.id, "label": spareparts.name};
                        parts.push(obj.value)
                    }
                });

            }
            this.form2.value = parts
            let data = [];
            Object.assign(data, {
                'id': case_type.id,
                'value': this.form2.value,
                'case_type': case_type.case_type,
                'description': case_type.description,
            })
            this.form2 = this.$inertia.form(data);
        },

        updateSparePartStatus(id) {
            this.updated = true
            let parts = [];
            this.form2.value = [];
            var sparepart_itemss = this.cases.case_spare_part_item.find(spare_Part_items => spare_Part_items.id == id);
            var spareparts = this.spareParts.find(spare_Part => spare_Part.id == sparepart_itemss.sparepart_id);
            var obj = {"value": spareparts.id, "label": spareparts.name};
            parts.push(obj.value)
            this.form3.value = parts
            let data = [];
            Object.assign(data, {
                'id': sparepart_itemss.id,
                'id2': this.cases.id,
                'value': this.form3.value,
                'spare_part_status': sparepart_itemss.status,
            })
            this.form3 = this.$inertia.form(data);
        },

        deleteCaseType(id) {
            this.form.delete(route('cases.type.delete', id))
        },
        deleteSparePartStatus(id) {
            this.form.delete(route('cases.sparepart.delete', id))
        },
        otherType: function () {
            if (this.form2.case_type == 'spareparts') {
                this.form2.case_type = this.form2.case_type;
                this.spare_part = true;
            } else {
                this.spare_part = false;
            }
        },
        changeStatus(e) {
            let target = e.target;
            $('.collapse-header').on('shown.bs.collapse', function () {
                if (!$(target).hasClass('.card-header')) {
                    $(target).closest('.card-header').addClass('back');
                } else {
                    $(target).addClass('back');
                }

                target = null;
            });
            $('.collapse-header').on('hidden.bs.collapse', function () {
                if (!$(target).hasClass('.card-header')) {
                    $(target).closest('.card-header').removeClass('back');
                } else {
                    $(target).removeClass('back');
                }
                target = null;
            });
        },

        chennalEmail() {
            this.$inertia.visit(route('fetch-email.create'), {
                method: 'get',
                data: {
                    email: this.cases.emails[0].from_email,
                    case_id: this.cases.id
                }
            })
        },

        otherSource: function () {
            if (this.form.source == 'Others') {
                this.form.source = this.form.source;
                this.sourceField = true;
            } else {
                this.sourceField = false;
            }
        },

        Clicked() {
            this.sweetAlert = false
        },

        deleteItem() {
            if (this.itemId) {
                this.sweetAlert = false
                this.$inertia.delete(`/erp/document/delete/${this.itemId}`)
            }
            if (this.notesId) {
                this.sweetAlert = false
                this.$inertia.delete(`/erp/cases/notes/${this.notesId}/delete`)
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
    }
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>

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
    border-radius: 6px !important;
    box-shadow: 0 2px 14px rgb(38 60 85/16%);
    border: 1px solid #d2d6dc;
    height: auto !important;
    width: 100%;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.error {
    color: red !important;
    font-weight: lighter;
    margin-bottom: 10px;
}

.img {
    height: 100px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.text-title-icon {
    vertical-align: super;
}

.back {
    background-color: red !important;
    color: #FFFFFF !important;
}

.custom-collapse {
    margin-bottom: -14px;
    margin-top: 9px;
}

.document-card {
    padding-bottom: 5px;
}

.document-add {
    padding-top: 10px;
    padding-bottom: 5px;
}

.email-card {
    padding-top: 26px;
    padding-bottom: 15px;
}
</style>
