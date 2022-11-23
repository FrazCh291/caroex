<template>
    <admin-layout>
        <!-- BEGIN: modal to create case -->
        <div id="addItem" aria-hidden="true" aria-labelledby="myModalLabel33" class="modal fade text-left" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content modal1">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h4 id="myModalLabel33" class="modal-title font-weight-bold"></h4>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <div class="modal-body mb-1 pt-0">
                        <div class="input-group form-group d-flex position-relative mt-1 px-2 pr-md-0 pl-md-0">
                            <input type="text" class="form-control border-light-gray btn-height" placeholder="Search..."
                                   aria-label="Search" aria-describedby="basic-addon2" v-model="form.searchWord"
                                   @change="searchCase">
                            <div class="input-group-append">
                                <button class="input-group-text search-btn" @click="searchCase">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="feather feather-search feather-16 pb-0 mb-0 mt-0">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div id="searchdiv2" v-if="this.searchCases.length<1">
                            <span class="badge-circle badge-circle-light-secondary action ml-auto mr-auto">
                                <i class="bx bx-sad font-medium-1 align-items-center mx-1"></i>
                            </span>
                            <p class="text-center">Email does not exist in our system!</p>
                        </div>
                        <button class="btn btn-primary mt-1 ml-2 mb-1" @click="saveCaseWithOutOrder"
                                v-if="this.searchCases.length<1">
                            Add case without order
                        </button>
                        <div class="card mt-2 mb-1" v-if="this.searchCases.length>0">
                            <div class="col-12 px-0">
                                <div class="col-12 px-0">
                                    <div class="card-content">
                                        <ul class="categories-list" v-for="order in searchCases">
                                            <li class="category">
                                                <h6>
                                                    {{ (order.customer.name ? order.customer.name : '') }},
                                                    <b>Email:</b>
                                                    {{ (order.customer.email ? order.customer.email : '') }},
                                                    <b>Phone:</b>
                                                    {{ (order.customer.phone ? order.customer.phone : '') }}
                                                </h6>
                                                <ul>
                                                    <li class="category">
                                                        <label>
                                                            <b>Adderess:</b>
                                                            {{
                                                                (order.shipping_address_1 ? ", " + order.shipping_address_1 : '') + (order.shipping_address_2 ? " , " + order.shipping_address_2 : '') + (order.billing_address_1_2 ? ", " + order.billing_address_1_2 : '') + (order.shipping_address_2 ? " , " + order.shipping_address_2 : '')
                                                            }}
                                                        </label>
                                                    </li>
                                                    <li class="category ml-5">
                                                        <label class="form-check-label" :for="order.id">
                                                            <b>Order: </b>{{ order.order_number }}
                                                        </label>
                                                        <input type="checkbox" @click='check_single(order.id)'
                                                               v-model="orderId" :id="order.id" :value="order.id">
                                                        <ul class="">
                                                            <li class="category" v-for="item in order.order_items">
                                                                <label class="form-check-label"
                                                                       :for="item.product.id"><b>Product
                                                                    Name: </b>{{ item.product.name }}</label>
                                                                <input type="checkbox" v-if="order.order_items.length>1"
                                                                       @click='check_prod(order.id, item.product.id)'
                                                                       v-model="productId" :id="item.product.id"
                                                                       :value="item.product.id">
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <button class="btn btn-primary mt-1 ml-2 mb-1" @click="saveCase"
                                            v-if="this.orderId.length>0">
                                        Add
                                    </button>
                                    <button class="btn btn-primary mt-1 ml-2 mb-1" v-else disabled>Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: modal to create case -->
        <!-- BEGIN: Fetch row -->
        <div class="col-12 px-0">
            <div class="col form-group p-0 text-right">
                <div class="card-header pb-0 mb-0 px-0">
                    <div class="header  mt-1" v-if="Object.keys(errors).length > 0">
                        <div class="alert bg-rgba-danger alert-dismissible mb-2 message" role="alert">
                            <div class="d-flex align-items-center" v-for="error in errors">
                                <i class="bx bx-error"></i>
                                <span><jet-input-error :message="error" class="mt-0 error "/></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <span class="btn btn-primary" data-repeater-create="" v-if="fetchActive" disabled="disabled">Fetch Emails</span>
                <span @click="chennalEmail" class="btn btn-primary" data-repeater-create="" v-else>Fetch Emails</span> -->
            </div>
        </div>
        <!-- END: Fetch row -->

        <!-- BEGIN: Content-->
        <div class="row pb-3 main-content" id="table-hover-row ">
            <div class="col-12">
                <div class="content-area-wrapper h-100 py-0 my-0 mx-0 px-0" style="overflow: scroll">
                    <!-- BEGIN: sidebar menu  -->
                    <div class="sidebar-left">
                        <div class="sidebar">
                            <div class="sidebar-content email-app-sidebar d-flex">
                                <div class="email-app-menu">
                                    <div class="form-group form-group-compose">
                                        <!-- compose button  -->
                                        <button type="button" class="btn btn-primary btn-block my-2 compose-btn"
                                                data-target="#emailComposeModal" data-toggle="modal">
                                            <i class="bx bx-plus"></i>
                                            Compose
                                        </button>
                                    </div>
                                    <div class="sidebar-menu-list mt-2">
                                        <div class="list-group list-group-messages">
                                            <span v-for="folder in folders" @click="loadEmail(folder['name'])"
                                                  class="list-group-item pt-0 nav-item cursor-pointer"
                                                  :class="folder['name'] === type ?'active':''"
                                                  id="inbox-menu">
                                                {{folder['name']}}
                                                <span v-if="folder['unseen_messages_count']>0" :class="folder['name'] === type ?'badge badge-light-primary badge-pill badge-round float-right mt-50':'badge badge-light-secondary badge-pill badge-round float-right mt-50'">
                                                    {{folder['unseen_messages_count']}}
                                                </span>
                                            </span>
                                        </div>
                                        <span class="btn btn-primary btn-block mb-0" @click="loadEmail('all')">
                                             <span style="color: white"> All Emails</span>
                                        </span>
                                        <label class="sidebar-label">Emails</label>
                                        <div class="list-group list-group-labels" v-for="emailSetting in emailSettings">
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center cursor-pointer badge badge-light-primary active"
                                                v-if="emailSetting.id == this.activeEmailId">
                                                <span
                                                    @click="EmailType(emailSetting.username, emailSetting.id, emailSetting.email_account_id)">
                                                    <span style="text-transform: lowercase; font-size: 15px">{{
                                                            emailSetting.username
                                                        }} </span>
                                                </span>
                                                <div
                                                    v-bind:style="{ 'background-color': colors[emailSetting.username] }"
                                                    class="circle"></div>
                                            </div>

                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center cursor-pointer"
                                                v-else>
                                                <span
                                                    @click="EmailType(emailSetting.username, emailSetting.id, emailSetting.email_account_id)">
                                                    <span style="text-transform: lowercase; font-size: 15px"> {{
                                                            emailSetting.username
                                                        }} </span>
                                                </span>
                                                <div
                                                    v-bind:style="{ 'background-color': colors[emailSetting.username] }"
                                                    class="circle"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: sidebar menu -->

                    <!-- BEGIN: Email Compose Modal  -->
                    <EmailComposeForm :emailSettings="emailSettings"></EmailComposeForm>
                    <!-- END: Email Compose Modal -->

                    <!-- BEGIN: Reply All Modal  -->
                    <ReplyAllForm @formStatus="emitFormStatus" v-if="Object.keys(replyAllModalEmail).length > 0"
                                  :email="replyAllModalEmail" :to="activeEmail" :replyType="replyType"></ReplyAllForm>
                    <!-- END: Reply All Modal -->

                    <!-- BEGIN: Forward Modal  -->
                    <ForwardForm @formStatus="emitFormStatus" v-if="Object.keys(replyAllModalEmail).length > 0"
                                  :email="replyAllModalEmail" :to="activeEmail"></ForwardForm>
                    <!-- END: Forward Modal -->

                    <!-- BEGIN: Email area  -->
                    <div class="content-right">
                        <div class="content-wrapper main-content1">
                            <div class="content-body">
                                <div class="email-app-area bg-primary">
                                    <!-- Email list Area -->
                                    <div class="email-app-list-wrapper">
                                        <div class="email-app-list">
                                            <div class="email-action card-onepl-1 pr-1">
                                                <div class=" col-12 p-0 m-0 bg-white">
                                                    <div class="card-content">
                                                        <div data-repeater-list="group-a">
                                                            <div>
                                                                <div class="top d-flex flex-wrap">
                                                                    <div class="action-filters flex-grow-1">
                                                                        <div id="DataTables_Table_0_filter"
                                                                             class="dataTables_filter">
                                                                            <div
                                                                                class="input-group form-group d-flex position-relative mt-1 px-2 pr-md-0">
                                                                                <input type="text"
                                                                                       class="form-control border-light-gray btn-height"
                                                                                       placeholder="Search..."
                                                                                       aria-label="Search"
                                                                                       aria-describedby="basic-addon2"
                                                                                       v-model="query.query"
                                                                                       @change="search">
                                                                                <div class="input-group-append">
                                                                                    <button
                                                                                        class="input-group-text search-btn"
                                                                                        @change="search">
                                                                                        <svg
                                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                                            width="23" height="23"
                                                                                            viewBox="0 0 24 24"
                                                                                            fill="none"
                                                                                            stroke="currentColor"
                                                                                            stroke-width="2"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            class="feather feather-search feather-16 pb-0 mb-0 mt-0">
                                                                                            <circle cx="11" cy="11"
                                                                                                    r="8"></circle>
                                                                                            <line x1="21" y1="21"
                                                                                                  x2="16.65"
                                                                                                  y2="16.65"></line>
                                                                                        </svg>
                                                                                    </button>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="actions action-btns d-flex align-items-center flex flex-wrap filter-container pl-1">
                                                                        <div
                                                                            class="dropdown md:w-1/2 sm:w-1 pr-1 filter-dropdown">
                                                                            <button
                                                                                class="btn border dropdown-toggle w-100"
                                                                                type="button"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                Filter
                                                                            </button>
                                                                            <div
                                                                                class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"
                                                                                @click="stopPropagation"
                                                                                aria-labelledby="">
                                                                                <div class="col-12 pl-2 pt-1">
                                                                                    <div class="d-inline-flex w-100">
                                                                                        <h6 class="py-0 my-0">
                                                                                            Status</h6>
                                                                                        <span
                                                                                            class="primary pl-20 ml-2 pointer"
                                                                                            @click="resetFilter">Reset</span>
                                                                                    </div>
                                                                                    <div
                                                                                        class="align-items-center text-base pt-1">
                                                                                        <p class="tag">
                                                                                            <input type="checkbox"
                                                                                                   name="read" id="read"
                                                                                                   v-model="query.read"
                                                                                                   v-on:click="check_one()">
                                                                                            <label
                                                                                                class="pl-1 py-0 my-0"
                                                                                                for="read">Read</label>
                                                                                        </p>
                                                                                        <p class="tag">
                                                                                            <input type="checkbox"
                                                                                                   name="unread"
                                                                                                   id="unread"
                                                                                                   v-model="query.unread"
                                                                                                   v-on:click="check_one()">
                                                                                            <label
                                                                                                class="pl-1 py-0 my-0"
                                                                                                for="unread">Unread</label>
                                                                                        </p>
                                                                                        <p class="tag">
                                                                                            <input type="checkbox"
                                                                                                   name="star"
                                                                                                   id="star"
                                                                                                   v-model="query.star"
                                                                                                   v-on:click="check_one()">
                                                                                            <label
                                                                                                class="pl-1 py-0 my-0"
                                                                                                for="star">Star</label>
                                                                                        </p>
                                                                                        <!-- <p class="tag">
                                                                                            <input type="checkbox"
                                                                                                   name="attachments"
                                                                                                   id="attachments"
                                                                                                   v-model="query.attachments">
                                                                                            <label
                                                                                                class="pl-1 py-0 my-0"
                                                                                                for="attachments">Attachments</label>
                                                                                        </p> -->
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="dropdown-divider py-0 my-0"></div>
                                                                                <div class="col-12 pl-2">
                                                                                    <p class="pt-1 pb-1">
                                                                                        <button type="button" id="asc"
                                                                                                @click="filter"
                                                                                                class=" btn btn-sm btn-primary font-small font-weight-normal stock-order">
                                                                                            Filter
                                                                                        </button>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="dropdown md:w-1/2 sm:w-1 pr-2 sort-dropdown">
                                                                            <button
                                                                                class="btn border dropdown-toggle w-100"
                                                                                type="button"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                Sort
                                                                            </button>
                                                                            <div
                                                                                class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"
                                                                                aria-labelledby=""
                                                                                @click="stopPropagation">
                                                                                <div class="col-12 pl-2 pt-2">
                                                                                    <div
                                                                                        class="d-inline-flex w-100">
                                                                                        <h6 class="py-0 my-0">
                                                                                            Sort</h6>
                                                                                        <span
                                                                                            class="primary pl-20 ml-2 pointer"
                                                                                            @click="resetSort">Reset</span>
                                                                                    </div>
                                                                                    <!-- <div
                                                                                        class="align-items-center text-base pt-1">
                                                                                        <p class="tag">
                                                                                            <input type="checkbox"
                                                                                                   name="from"
                                                                                                   id="from"
                                                                                                   v-model="query.from"
                                                                                                   v-on:click="check_one()">
                                                                                            <label
                                                                                                class="pl-1 py-0 my-0"
                                                                                                for="from">From
                                                                                                </label>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div
                                                                                        class="align-items-center text-base">
                                                                                        <p class="tag">
                                                                                            <input type="checkbox"
                                                                                                   name="to"
                                                                                                   id="to"
                                                                                                   v-model="query.to"
                                                                                                   v-on:click="check_one()">
                                                                                            <label
                                                                                                class="pl-1 py-0 my-0"
                                                                                                for="to">To
                                                                                                </label>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div
                                                                                        class="align-items-center text-base">
                                                                                        <p class="tag">
                                                                                            <input type="checkbox"
                                                                                                   name="subject"
                                                                                                   id="subject"
                                                                                                   v-model="query.subject"
                                                                                                   v-on:click="check_one()">
                                                                                            <label
                                                                                                class="pl-1 py-0 my-0"
                                                                                                for="subject">Subject</label>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div
                                                                                        class="align-items-center text-base">
                                                                                        <p class="tag">
                                                                                            <input type="checkbox"
                                                                                                   name="case_id"
                                                                                                   id="case_id"
                                                                                                   v-model="query.case_id"
                                                                                                   v-on:click="check_one()">
                                                                                            <label
                                                                                                class="pl-1 py-0 my-0"
                                                                                                for="case_id">Case#
                                                                                            </label>
                                                                                        </p>
                                                                                    </div> -->
                                                                                    <div
                                                                                        class="align-items-center text-base pt-1">
                                                                                        <p class="tag">
                                                                                            <input type="checkbox"
                                                                                                   name="date"
                                                                                                   id="date"
                                                                                                   v-model="query.date"
                                                                                                   v-on:click="check_one()">
                                                                                            <label
                                                                                                class="pl-1 py-0 my-0"
                                                                                                for="date">Date
                                                                                            </label>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="dropdown-divider py-0 my-0"></div>
                                                                                <div
                                                                                    class="col-12 pl-2 pb-1 d-inline-flex">
                                                                                    <p class="pt-1">
                                                                                        <button type="button"
                                                                                                id="asce"
                                                                                                @click="sort('asc')"
                                                                                                class=" btn btn-sm btn-primary font-small font-weight-normal stock-order">
                                                                                            Asc
                                                                                        </button>
                                                                                    </p>
                                                                                    <p class="pt-1 pl-3">
                                                                                        <button type="button"
                                                                                                id="desc"
                                                                                                @click="sort('desc')"
                                                                                                class=" btn btn-sm btn-light-secondary font-small font-weight-normal stock-order">
                                                                                            Desc
                                                                                        </button>
                                                                                    </p>
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
                                            <!-- email user list start -->
                                            <div class="email-action pl-0 pr-1">
                                                <div class="col-12 px-0">
                                                    <div class="collapsible email-detail-head" id="collapsible">
                                                        <div class="card collapse-header  ml-1"
                                                             @click="changeStatus($event,email.id, email.is_seen,index)"
                                                             role="tablist" :id="'collapseCard'+email.id"
                                                             v-for="(email,index) in emails.data">
                                                            <div id="headingCollapse5" v-if="email.is_seen"
                                                                 class="px-1 pt-1 pb-0 card-header d-flex justify-content-between align-items-center"
                                                                 data-toggle="collapse" role="tab"
                                                                 v-bind:data-target='"#collapse6" + email.id'
                                                                 aria-expanded="false" aria-controls="collapse5">
                                                                <div
                                                                    class="collapse-title media custom-class d-flex justify-content-between w-100">
                                                                    <i class="bx bx-mail-send"
                                                                       style="font-size: small; margin-top: 15px"></i>
                                                                    <div class="media-body px-0">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <span class=""
                                                                                      style="padding-right: 25px">
                                                                                    <div class="collapse-title media">
                                                                                        <div
                                                                                            class="media-body small mt-25">
                                                                                            <span class="">{{
                                                                                                    email.from['mail']
                                                                                                }}

                                                                                            </span>
                                                                                               <br>
                                                                                           <div class="d-flex">
                                                                                                <div
                                                                                                    v-bind:style="{ 'background-color': colors[ email.to_email] }"
                                                                                                    class="circle"
                                                                                                    style="margin-top: 3px; margin-right: 5px;">
                                                                                                </div>
                                                                                                <small v-if="email['to'].length>1">
                                                                                                    <span data-placement="bottom" :data-toggle="email.id" @mouseover="showTooltip(email.id)" @mouseout="hideTooltip(email.id)" data-container="body" type="button" data-html="true" href="#" id="login">
                                                                                                    <span>
                                                                                                        to: &lt;{{ email['to'] ? email['to'][0]['mail'] : '' }}&gt;...</span>
                                                                                                    </span>
                                                                                                    <div class="container" >
                                                                                                        <div :id="'popover-content-'+email.id" class="d-none">
                                                                                                            <div class="row custom-popover popover-max">
                                                                                                                <div class="col-12 px-2">
                                                                                                                    <span class="h5 mb-1 small">
                                                                                                                        To:
                                                                                                                    </span>
                                                                                                                    <div v-for="to in email['to']">
                                                                                                                        <p class="py-0 mb-0 small">&lt;{{ to['mail'] }}&gt;</p>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </small>
                                                                                                <small v-else
                                                                                                    :id='"to" + email.id'
                                                                                                    class="d-sm-inline d-none">
                                                                                                       to: &lt;{{ email['to'] ? email['to'][0]['mail'] : '' }}&gt;
                                                                                                </small>
                                                                                           </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </span>
                                                                            </div>
                                                                            <div
                                                                                class="text-left  col-sm-2 small"
                                                                                style="margin-top: 10px; position:relative;">
                                                                                <span class="header-subject"
                                                                                      style="padding-right: 25px"> {{
                                                                                        email.subject
                                                                                    }}</span>
                                                                            </div>
                                                                            <div
                                                                                class="text-left col-sm-2 small"
                                                                                style="margin-top: 10px">
                                                                                <span class="" v-if="email.case_id"
                                                                                      style="background-color: #ffcccb;padding: 5px 5px;border-radius: 15px;"> {{
                                                                                        email.case ? email.case.case_number : ''
                                                                                    }}</span>
                                                                            </div>
                                                                            <div id="date-section"
                                                                                 class="col-sm-4 d-flex">
                                                                                <div
                                                                                    class="information d-sm-flex justify-content-end d-none date text-right mt-30">
                                                                                    <p class="header-date">
                                                                                        {{
                                                                                            formatDate(email.date) ? formatDate(email.date) : formatDate(email.created_at)
                                                                                        }}
                                                                                        <span :id="'star'+email.id"
                                                                                              class="favorite warning"
                                                                                              v-if="email.is_flagged===1 || email.is_flagged===true"
                                                                                              v-on:click="starStatus($event, email.id, activeEmail, type, index)"
                                                                                              style="margin-top: 10px;">
                                                                                           <i :id="'starIcon'+email.id"
                                                                                              class="bx bxs-star"></i>
                                                                                         </span>
                                                                                        <span :id="'star'+email.id"
                                                                                              class="favorite" v-else
                                                                                              v-on:click="starStatus($event, email.id, activeEmail, type, index)"
                                                                                              style="margin-top: 10px;">
                                                                                           <i :id="'starIcon'+email.id"
                                                                                              class="bx bx-star"></i>
                                                                                         </span>
                                                                                        <span v-if="email.has_attachment" style="margin-top: 10px;">
                                                                                           <i class="bx bx-link"></i>
                                                                                         </span>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="dropdown"
                                                                                     style="margin-top: 10px;">
                                                                                    <div
                                                                                        class=""
                                                                                        id="third-open-menu"
                                                                                        data-toggle="dropdown"
                                                                                        aria-haspopup="true"
                                                                                        aria-expanded="false">
                                                                                        <i class="bx bx-dots-vertical-rounded mr-0"></i>
                                                                                    </div>
                                                                                    <div
                                                                                        class="dropdown-menu dropdown-menu-right mt-1"
                                                                                        aria-labelledby="second-open-submenu">
                                                                                        <button v-if="(type==='INBOX' || type==='inbox' || type==='Inbox') && email['to']" @click="replyAllModalEmailSet(index, 'reply')" class="dropdown-item text-light" data-target="#replyAllModal" data-toggle="modal">
                                                                                            <i class="bx bx-reply text-light"></i>
                                                                                            Reply
                                                                                        </button>
                                                                                        <button v-else disabled class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bx-reply text-light-secondary"></i>
                                                                                            Reply
                                                                                        </button>
                                                                                        <button v-if="(type==='INBOX' || type==='inbox' || type==='Inbox') && (email['cc'] || email['bcc'])" @click="replyAllModalEmailSet(index, 'replyAll')" class="dropdown-item text-light" data-target="#replyAllModal" data-toggle="modal">
                                                                                            <i class="bx bx-reply-all text-light"></i>
                                                                                            Reply All
                                                                                        </button>
                                                                                        <button v-else disabled class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bx-reply-all text-light-secondary" id="bx-reply-all"></i>
                                                                                            Reply All
                                                                                        </button>
                                                                                        <button class="dropdown-item text-light" @click="replyAllModalEmailSet(index, 'forward')" data-target="#forwardModal" data-toggle="modal">
                                                                                            <i class="bx bx-redo text-light" id="bx-redo"></i>
                                                                                            Forward
                                                                                        </button>
                                                                                        <hr class="m-0">
                                                                                        <button v-if="type==='INBOX' || type==='inbox' || type==='Inbox'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-inbox text-light-secondary"></i>
                                                                                            Inbox
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'inbox')" class="dropdown-item text-light">
                                                                                        <i class="bx bxs-inbox text-light"></i>
                                                                                            Inbox
                                                                                        </button>
                                                                                        <button v-if="type==='Sent' || type==='Sent Items' || type==='Sent Messages'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-send text-light-secondary"></i>
                                                                                            Sent
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'sent')" class="dropdown-item text-light">
                                                                                            <i class="bx bxs-send text-light"></i>
                                                                                            Sent
                                                                                        </button>
                                                                                        <button v-if="type==='Drafts'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-pen text-light-secondary"></i>
                                                                                            Drafts
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'drafts')" class="dropdown-item text-light">
                                                                                            <i class="bx bxs-pen text-light"></i>
                                                                                            Drafts
                                                                                        </button>
                                                                                        <button v-if="type==='Junk' || type==='Junk Email'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-error-alt text-light-secondary"></i>
                                                                                            Junk
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'junk')" class="dropdown-item text-light">
                                                                                            <i class="bx bxs-error-alt text-light"></i>
                                                                                            Junk
                                                                                        </button>
                                                                                        <button v-if="type==='Trash' || type==='Deleted Items'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-trash text-light-secondary"></i>
                                                                                            Trash
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'trash')" class="dropdown-item text-light">
                                                                                            <i class="bx bxs-trash text-light"></i>
                                                                                            Trash
                                                                                        </button>
                                                                                        <button v-if="type==='Archive'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-box text-light-secondary"></i>
                                                                                            Archive
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'archive')" class="dropdown-item text-light">
                                                                                            <i class="bx bxs-box text-light"></i>
                                                                                            Archive
                                                                                        </button>
                                                                                        <hr class="m-0">
                                                                                        <button class="dropdown-item text-light"  v-if="email.is_seen===1 || email.is_seen===true" v-on:click="emailMark($event, email.id, activeEmail, type, index, 'read/unread')">
                                                                                            <i class="bx bxs-envelope text-light"></i>
                                                                                            Unread
                                                                                        </button>
                                                                                        <button class="dropdown-item text-light" v-else v-on:click="emailMark($event, email.id, activeEmail, type, index, 'read/unread')">
                                                                                            <i class="bx bxs-envelope-open text-light"></i>
                                                                                            Read
                                                                                        </button>
                                                                                        <button :id="'DropdownStarButton'+email.id" class="dropdown-item text-light" v-if="email.is_flagged===0 || email.is_flagged===false" v-on:click="starStatus($event, email.id, activeEmail, type, index)">
                                                                                            <i :id="'DropdownStarIcon'+email.id" class="bx bxs-star text-light"></i>
                                                                                            Star
                                                                                        </button>
                                                                                        <button :id="'DropdownStarButton'+email.id" class="dropdown-item text-light" v-else v-on:click="starStatus($event, email.id, activeEmail, type, index)">
                                                                                            <i :id="'DropdownStarIcon'+email.id" class="bx bx-star text-light"></i>
                                                                                            Unstar
                                                                                        </button>
                                                                                        <hr class="m-0">
                                                                                        <button class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bx-briefcase text-light-secondary"></i>
                                                                                            Generate Case
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="headingCollapse5" v-else
                                                                 class="px-1 pt-1 pb-0 card-header d-flex justify-content-between align-items-center"
                                                                 style="background-color: #F2F4F4"
                                                                 data-toggle="collapse" role="tab"
                                                                 v-bind:data-target='"#collapse6" + email.id'
                                                                 aria-expanded="false" aria-controls="collapse5">
                                                                <div
                                                                    class="collapse-title media custom-class d-flex justify-content-between w-100">
                                                                    <i class="bx bx-mail-send"
                                                                       style="font-size: larger; margin-top: 15px"></i>
                                                                    <div class="media-body px-0">
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-sm-4">
                                                                                <span class=""
                                                                                      style="padding-right: 25px">
                                                                                    <div class="collapse-title media">
                                                                                        <div :id='"from" + email.id'
                                                                                             class="media-body mt-25 small"
                                                                                             style="font-weight: bold">
                                                                                            <span class="">{{
                                                                                                    email.from['mail']
                                                                                                }} </span><br>

                                                                                           <div
                                                                                               class="d-flex">
                                                                                                <div
                                                                                                    v-bind:style="{ 'background-color': colors[ email.to] }"
                                                                                                    class="circle"
                                                                                                    style="margin-top: 3px; margin-right: 5px;">
                                                                                                </div>
                                                                                                <small v-if="email['to'].length>1">
                                                                                                    <span data-placement="bottom" :data-toggle="email.id" @mouseover="showTooltip(email.id)" @mouseout="hideTooltip(email.id)" data-container="body" type="button" data-html="true" href="#" id="login">
                                                                                                    <span style="font-weight: bold">
                                                                                                        to: &lt;{{ email['to'] ? email['to'][0]['mail'] : '' }}&gt;...</span>
                                                                                                    </span>
                                                                                                    <div class="container" >
                                                                                                        <div :id="'popover-content-'+email.id" class="d-none">
                                                                                                            <div class="row custom-popover popover-max">
                                                                                                                <div class="col-12 px-2">
                                                                                                                    <span class="font-weight-bold h5 mb-1 small">
                                                                                                                        To:
                                                                                                                    </span>
                                                                                                                    <div v-for="to in email['to']">
                                                                                                                        <p class="py-0 mb-0 small">&lt;{{ to['mail'] }}&gt;</p>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </small>
                                                                                                <small v-else
                                                                                                    :id='"to" + email.id'
                                                                                                    class="d-sm-inline d-none"
                                                                                                    style="font-weight: bold">
                                                                                                       to: &lt;{{ email['to'] ? email['to'][0]['mail'] : '' }}&gt;
                                                                                                </small>
                                                                                           </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </span>
                                                                            </div>
                                                                            <div
                                                                                class="text-left col-sm-2 small"
                                                                                style="margin-top: 10px; position: relative">
                                                                                <span :id='"subject" + email.id'
                                                                                      class="header-subject"
                                                                                      style="padding-right: 25px; font-weight: bold"> {{
                                                                                        email.subject
                                                                                    }}
                                                                                </span>
                                                                            </div>
                                                                            <div :id='"case-number" + email.id'
                                                                                 class="text-left col-sm-2 small"
                                                                                 style="margin-top: 10px; font-weight: bold;">
                                                                                <span
                                                                                    class="" v-if="email.case_id"
                                                                                    style="background-color: #ffcccb;padding: 5px 5px;border-radius: 15px;"> {{
                                                                                        email.case ? email.case.case_number : ''
                                                                                    }}
                                                                                </span>
                                                                            </div>
                                                                            <div id="date-section"
                                                                                 class="col-sm-4 d-flex">
                                                                                <div
                                                                                    class="information d-sm-flex justify-content-end d-none date text-right mt-30">
                                                                                    <p :id='"date" + email.id'
                                                                                       class="header-date"
                                                                                       style="font-weight: bold;">
                                                                                        {{
                                                                                            formatDate(email.date) ? formatDate(email.date) : formatDate(email.created_at)
                                                                                        }}
                                                                                        <span :id="'star'+email.id"
                                                                                              class="favorite warning"
                                                                                              v-if="email.is_flagged===1 || email.is_flagged===true"
                                                                                              v-on:click="starStatus($event, email.id, activeEmail, type, index)"
                                                                                              style="margin-top: 10px;">
                                                                                           <i :id="'starIcon'+email.id"
                                                                                              class="bx bxs-star"></i>
                                                                                         </span>
                                                                                        <span :id="'star'+email.id"
                                                                                              class="favorite" v-else
                                                                                              v-on:click="starStatus($event, email.id, activeEmail, type, index)"
                                                                                              style="margin-top: 10px;">
                                                                                           <i :id="'starIcon'+email.id"
                                                                                              class="bx bx-star"></i>
                                                                                         </span>
                                                                                        <span v-if="email.has_attachment" style="margin-top: 10px;">
                                                                                           <i class="bx bx-link"></i>
                                                                                         </span>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="dropdown"
                                                                                     style="margin-top: 10px;">
                                                                                    <div
                                                                                        class=""
                                                                                        id="third-open-menu"
                                                                                        data-toggle="dropdown"
                                                                                        aria-haspopup="true"
                                                                                        aria-expanded="false">
                                                                                        <i class="bx bx-dots-vertical-rounded mr-0"></i>
                                                                                    </div>
                                                                                    <div
                                                                                        class="dropdown-menu dropdown-menu-right mt-1"
                                                                                        aria-labelledby="second-open-submenu">
                                                                                        <button v-if="(type==='INBOX' || type==='inbox' || type==='Inbox') && email['to']" @click="replyAllModalEmailSet(index, 'reply')" class="dropdown-item text-light" data-target="#replyAllModal" data-toggle="modal">
                                                                                            <i class="bx bx-reply text-light"></i>
                                                                                            Reply
                                                                                        </button>
                                                                                        <button v-else disabled class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bx-reply text-light-secondary"></i>
                                                                                            Reply
                                                                                        </button>
                                                                                        <button v-if="(type==='INBOX' || type==='inbox' || type==='Inbox') && (email['cc'] || email['bcc'])" @click="replyAllModalEmailSet(index, 'replyAll')" class="dropdown-item text-light" data-target="#replyAllModal" data-toggle="modal">
                                                                                            <i class="bx bx-reply-all text-light"></i>
                                                                                            Reply All
                                                                                        </button>
                                                                                        <button v-else disabled class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bx-reply-all text-light-secondary" id="bx-reply-all"></i>
                                                                                            Reply All
                                                                                        </button>
                                                                                        <button class="dropdown-item text-light" @click="replyAllModalEmailSet(index, 'forward')" data-target="#forwardModal" data-toggle="modal">
                                                                                            <i class="bx bx-redo text-light" id="bx-redo"></i>
                                                                                            Forward
                                                                                        </button>
                                                                                        <hr class="m-0">
                                                                                        <button v-if="type==='INBOX' || type==='inbox' || type==='Inbox'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-inbox text-light-secondary"></i>
                                                                                            Inbox
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'inbox')" class="dropdown-item text-light">
                                                                                        <i class="bx bxs-inbox text-light"></i>
                                                                                            Inbox
                                                                                        </button>
                                                                                        <button v-if="type==='Sent' || type==='Sent Items' || type==='Sent Messages'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-send text-light-secondary"></i>
                                                                                            Sent
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'sent')" class="dropdown-item text-light">
                                                                                            <i class="bx bxs-send text-light"></i>
                                                                                            Sent
                                                                                        </button>
                                                                                        <button v-if="type==='Drafts'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-pen text-light-secondary"></i>
                                                                                            Drafts
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'drafts')" class="dropdown-item text-light">
                                                                                            <i class="bx bxs-pen text-light"></i>
                                                                                            Drafts
                                                                                        </button>
                                                                                        <button v-if="type==='Junk' || type==='Junk Email'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-error-alt text-light-secondary"></i>
                                                                                            Junk
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'junk')" class="dropdown-item text-light">
                                                                                            <i class="bx bxs-error-alt text-light"></i>
                                                                                            Junk
                                                                                        </button>
                                                                                        <button v-if="type==='Trash' || type==='Deleted Items'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-trash text-light-secondary"></i>
                                                                                            Trash
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'trash')" class="dropdown-item text-light">
                                                                                            <i class="bx bxs-trash text-light"></i>
                                                                                            Trash
                                                                                        </button>
                                                                                        <button v-if="type==='Archive'" class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bxs-box text-light-secondary"></i>
                                                                                            Archive
                                                                                        </button>
                                                                                        <button v-else @click="changeFolder(email.id, activeEmail, type, 'archive')" class="dropdown-item text-light">
                                                                                            <i class="bx bxs-box text-light"></i>
                                                                                            Archive
                                                                                        </button>
                                                                                        <hr class="m-0">
                                                                                        <button class="dropdown-item text-light"  v-if="email.is_seen===1 || email.is_seen===true" v-on:click="emailMark($event, email.id, activeEmail, type, index, 'read/unread')">
                                                                                            <i class="bx bxs-envelope text-light"></i>
                                                                                            Unread
                                                                                        </button>
                                                                                        <button class="dropdown-item text-light" v-else v-on:click="emailMark($event, email.id, activeEmail, type, index, 'read/unread')">
                                                                                            <i class="bx bxs-envelope-open text-light"></i>
                                                                                            Read
                                                                                        </button>
                                                                                        <button :id="'DropdownStarButton'+email.id" class="dropdown-item text-light" v-if="email.is_flagged===0 || email.is_flagged===false" v-on:click="starStatus($event, email.id, activeEmail, type, index)">
                                                                                            <i :id="'DropdownStarIcon'+email.id" class="bx bxs-star text-light"></i>
                                                                                            Star
                                                                                        </button>
                                                                                        <button :id="'DropdownStarButton'+email.id" class="dropdown-item text-light" v-else v-on:click="starStatus($event, email.id, activeEmail, type, index)">
                                                                                            <i :id="'DropdownStarIcon'+email.id" class="bx bx-star text-light"></i>
                                                                                            Unstar
                                                                                        </button>
                                                                                        <hr class="m-0">
                                                                                        <button class="dropdown-item text-light-secondary">
                                                                                            <i class="bx bx-briefcase text-light-secondary"></i>
                                                                                            Generate Case
                                                                                        </button>
                                                                                    </div>
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
                                                                                <div v-if="email['from']">
                                                                                    <span class="d-sm-inline">
                                                                                        From: {{ email['from']['full'] }}
                                                                                    </span>
                                                                                </div>
                                                                                <div>
                                                                                    <a :href="'#' + email.id" v-if="(type==='INBOX' || type==='inbox' || type==='Inbox') && email['to']">
                                                                                        <button type="button" title="Reply" @click="goto">
                                                                                            <i class="bx bx-reply text-light"></i>
                                                                                        </button>
                                                                                    </a>
                                                                                    <a v-else>
                                                                                        <button type="button" title="Reply">
                                                                                            <i class="bx bx-reply text-light-secondary"></i>
                                                                                        </button>
                                                                                    </a>
                                                                                    <a :href="'#' + email.id " v-if="(type==='INBOX' || type==='inbox' || type==='Inbox') && (email['cc'] || email['bcc'])">
                                                                                        <button type="button" @click="replyAllModalEmailSet(index, 'replyAll')" title="Reply All" data-target="#replyAllModal" data-toggle="modal">
                                                                                             <i class="bx bx-reply-all text-light"></i>
                                                                                        </button>
                                                                                    </a>
                                                                                    <a v-else>
                                                                                        <button type="button" title="Reply All" >
                                                                                             <i class="bx bx-reply-all text-light-secondary"></i>
                                                                                        </button>
                                                                                    </a>
                                                                                    <button type="button" @click="replyAllModalEmailSet(index, 'forward')" title="Forward" data-target="#forwardModal" data-toggle="modal">
                                                                                        <i class="bx bx-redo text-light" id="bx-redo"></i>
                                                                                    </button>
                                                                                    |
                                                                                    <button type="button" v-if="type==='INBOX' || type==='inbox' || type==='Inbox'" title="Inbox">
                                                                                        <i class="bx bxs-inbox text-light-secondary"></i>
                                                                                    </button>
                                                                                    <button type="button" v-else @click="changeFolder(email.id, activeEmail, type, 'inbox')" title="Inbox">
                                                                                        <i class="bx bxs-inbox text-light"></i>
                                                                                    </button>
                                                                                    <button type="button" v-if="type==='Sent' || type==='Sent Items' || type==='Sent Messages'" title="Sent">
                                                                                        <i class="bx bxs-send text-light-secondary"></i>
                                                                                    </button>
                                                                                    <button type="button" v-else @click="changeFolder(email.id, activeEmail, type, 'sent')" title="Sent">
                                                                                        <i class="bx bxs-send text-light"></i>
                                                                                    </button>
                                                                                    <button type="button" v-if="type==='Drafts'" title="Drafts">
                                                                                        <i class="bx bxs-pen text-light-secondary"></i>
                                                                                    </button>
                                                                                    <button type="button" v-else @click="changeFolder(email.id, activeEmail, type, 'drafts')" title="Drafts">
                                                                                        <i class="bx bxs-pen text-light"></i>
                                                                                    </button>    
                                                                                    <button type="button" v-if="type==='Junk' || type==='Junk Email'" title="Junk">
                                                                                        <i class="bx bxs-error-alt text-light-secondary"></i>
                                                                                    </button>
                                                                                    <button type="button" v-else @click="changeFolder(email.id, activeEmail, type, 'junk')" title="Junk">
                                                                                        <i class="bx bxs-error-alt text-light"></i>
                                                                                    </button>
                                                                                    <button type="button" v-if="type==='Trash' || type==='Deleted Items'" title="Trash">
                                                                                        <i class="bx bxs-trash text-light-secondary"></i>
                                                                                    </button>
                                                                                    <button type="button" v-else @click="changeFolder(email.id, activeEmail, type, 'trash')" title="Trash">
                                                                                        <i class="bx bxs-trash text-light"></i>
                                                                                    </button>
                                                                                    <button type="button" v-if="type==='Archive'" title="Archive">
                                                                                        <i class="bx bxs-box text-light-secondary"></i>
                                                                                    </button>
                                                                                    <button type="button" v-else @click="changeFolder(email.id, activeEmail, type, 'archive')" title="Archive">
                                                                                        <i class="bx bxs-box text-light"></i>
                                                                                    </button>
                                                                                    |
                                                                                    <button type="button" title="Mark As Unread" class="mark-as-unread" v-on:click="emailMark($event, email.id, activeEmail, type, index, 'unread')">
                                                                                        <i class="bx bxs-envelope text-light"></i>
                                                                                    </button>
                                                                                    <button :id="'collapseStarButton'+email.id" type="button" :title="'Star'" v-if="email.is_flagged===0 || email.is_flagged===false" v-on:click="starStatus($event, email.id, activeEmail, type, index)">
                                                                                       <i :id="'collapseStarIcon'+email.id" class="bx bxs-star text-light"></i>
                                                                                    </button>
                                                                                    <button :id="'collapseStarButton'+email.id" type="button" :title="'Unstar'" v-else v-on:click="starStatus($event, email.id, activeEmail, type, index)">
                                                                                       <i :id="'collapseStarIcon'+email.id" class="bx bx-star text-light"></i>
                                                                                    </button>
                                                                                    |
                                                                                    <button type="button" title="Generate Case">
                                                                                        <i class="bx bx-briefcase text-light-secondary"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="media-body email-space" v-if="email['to']">
                                                                                <span class="d-sm-inline">
                                                                                    To: {{ email['to'] ? getAddresses(email['to'],'To') : '' }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="media-body email-space" v-if="email['cc']">
                                                                                <span class="d-sm-inline">
                                                                                    Cc: {{ getAddresses(email['cc'],'Cc') }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="media-body email-space" v-if="email['bcc']">
                                                                                <span class="d-sm-inline">
                                                                                    Bcc: {{ getAddresses(email['bcc'],'Bcc') }}
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
                                                                            <div class="">
                                                                                <p>
                                                                                    <span v-html="email.body" v-if="email.has_html_body"></span>
                                                                                    <pre v-html="email.body" v-else></pre>
                                                                                </p>
                                                                            </div>
                                                                            <!--                                                                            <p class="mb-0">Sincerely yours,</p>-->
                                                                            <!--                                                                            <p class="text-bold-500">Careox Dev-->
                                                                            <!--                                                                                Teams</p>-->

                                                                                                                                                        <div v-if="email.attachments.length > 0">
                                                                                                                                                            <p class="text-bold-500">Attached File
                                                                                                                                                            </p>
                                                                                                                                                            <span v-for="attachment in email.attachments" class=" py-0">
                                                                                                                                                                <span class="mr-1">
                                                                                                                                                                    <a :href="'/storage/'+attachment.path" target="_blank" style="color: #727E8C">
                                                                                                                                                                        {{ attachment.content_id ? attachment.content_id : attachment.name + '(' + attachmentFileSize(attachment.size) + ')' }}
                                                                                                                                                                    </a>
                                                                                                                                                                    <td class="text-small py-0 my-0 action pr-1">
                                                                                                                                                                        <span class="d-inline-flex align-items-center action">
                                                                                                                                                                            <a :href="'/storage/'+attachment.path" download>
                                                                                                                                                                                <span class="" style="color: #727E8C">
                                                                                                                                                                                    <i class="bx bx-download font-medium-1 align-items-center text-center show1 ml-2"></i>
                                                                                                                                                                                </span>
                                                                                                                                                                            </a>
                                                                                                                                                                        </span>
                                                                                                                                                                    </td>
                                                                                                                                                                </span>
                                                                                                                                                            </span>
                                                                                                                                                        </div>
                                                                            <!--                                                                            <div-->
                                                                            <!--                                                                                v-if="email.inline_attachments.length>0">-->
                                                                            <!--                                                                                <p class="text-bold-500">Attached File-->
                                                                            <!--                                                                                </p>-->
                                                                            <!--                                                                                <span-->
                                                                            <!--                                                                                    v-for="attachment in email.inline_attachments"-->
                                                                            <!--                                                                                    class=" py-0">-->
                                                                            <!--&lt;!&ndash;                                                                                    <span&ndash;&gt;-->
                                                                            <!--                                                                                    &lt;!&ndash;                                                                                        v-if="!email.body.includes(attachment.content_id)">&ndash;&gt;-->
                                                                            <!--                                                                                    <span class="mr-1"-->
                                                                            <!--                                                                                          v-if="attachment.content_id && (attachment.content_type == 'jpg' || attachment.content_type == 'jpeg' || attachment.content_type == 'jfif' || attachment.content_type =='pjpeg' || attachment.content_type =='pjp' || attachment.content_type =='png' || attachment.content_type == 'svg')">-->
                                                                            <!--                                                                                           <span-->
                                                                            <!--                                                                                               v-if="attachment.content_id">-->
                                                                            <!--                                                                                                <img-->
                                                                            <!--                                                                                                    :src="'/storage/images/'+attachment.content_id">-->
                                                                            <!--                                                                                           </span>-->


                                                                            <!--                                                                                        &lt;!&ndash;                                                                                     </span>&ndash;&gt;-->
                                                                            <!--                                                                                    <span class="mr-1" v-else>-->
                                                                            <!--                                                                                    <a :href="attachment.url"-->
                                                                            <!--                                                                                       target="_blank"-->
                                                                            <!--                                                                                       style="color: #727E8C">-->
                                                                            <!--                                                                                        {{-->
                                                                            <!--                                                                                            attachment.content_id ? attachment.content_id : attachment.name + '(' + attachmentFileSize(attachment.size) + ')'-->
                                                                            <!--                                                                                        }}-->
                                                                            <!--                                                                                    </a>-->
                                                                            <!--                                                                                <td class="text-small py-0 my-0 action pr-1">-->
                                                                            <!--                                                                                    <span-->
                                                                            <!--                                                                                        class="d-inline-flex align-items-center action">-->
                                                                            <!--                                                                                        <a :href="route('export.attachment',attachment.id)">-->
                                                                            <!--                                                                                            <span class=""-->
                                                                            <!--                                                                                                  style="color: #727E8C">-->
                                                                            <!--                                                                                                <i class="bx bx-download font-medium-1 align-items-center text-center show1 ml-2"></i>-->
                                                                            <!--                                                                                            </span>-->
                                                                            <!--                                                                                        </a>-->
                                                                            <!--                                                                                    </span>-->
                                                                            <!--                                                                                </td>-->
                                                                            <!--                                                                                    </span>-->
                                                                            <!--                                                                                    </span>-->
                                                                            <!--                                                                                    &lt;!&ndash;                                                                                </span>&ndash;&gt;-->
                                                                            <!--                                                                                </span>-->
                                                                            <!--                                                                            </div>-->
                                                                        </div>
                                                                        <div class="card-footer pt-0">
                                                                        </div>
                                                                        <!--                                                                        <div v-if="email.child_emails.length>0">-->
                                                                        <!--                                                                            <div class="border-top"-->
                                                                        <!--                                                                                 v-for="childEmail in email.child_emails">-->
                                                                        <!--                                                                                <div class="card-body py-1">-->
                                                                        <!--                                                                                    <div-->
                                                                        <!--                                                                                        class="media-body  email-space">-->
                                                                        <!--                                                                                    <span class="d-sm-inline">-->
                                                                        <!--                                                                                      From:  {{ childEmail.from_name }}-->
                                                                        <!--                                                                                    </span>-->
                                                                        <!--                                                                                        <span class="d-sm-inline">-->
                                                                        <!--                                                                                        &lt;{{ childEmail.from_email }}&gt;-->
                                                                        <!--                                                                                    </span>-->
                                                                        <!--                                                                                    </div>-->
                                                                        <!--                                                                                    <div-->
                                                                        <!--                                                                                        class="media-body email-space">-->
                                                                        <!--                                                                                    <span class="d-sm-inline">-->
                                                                        <!--                                                                                      To:  {{ childEmail.to_name }}-->
                                                                        <!--                                                                                    </span>-->
                                                                        <!--                                                                                        <span class="d-sm-inline">-->
                                                                        <!--                                                                                        &lt;{{ childEmail.to_email }}&gt;-->
                                                                        <!--                                                                                    </span>-->
                                                                        <!--                                                                                    </div>-->
                                                                        <!--&lt;!&ndash;                                                                                    <div&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;                                                                                        class="media-body email-space"&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;                                                                                        v-if="childEmail.email_ccs.length>0">&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;                                                                                    <span class="d-sm-inline">&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;                                                                                      Cc:&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;                                                                                    </span>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;                                                                                        <span class="d-sm-inline">&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;                                                                                        &lt;{{
                                                                            &ndash;&gt;-- >
                                                                            < !-- &lt; ! & ndash;                                                                                                ccString(childEmail.email_ccs) & ndash;&gt;-- >
                                                                            < !-- &lt; ! & ndash;
                                                                        }}&gt;&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;                                                                                    </span>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;                                                                                    </div>&ndash;&gt;-->
                                                                        <!--                                                                                    <div-->
                                                                        <!--                                                                                        class="media-body email-space">-->
                                                                        <!--                                                                                    <span-->
                                                                        <!--                                                                                        class="d-sm-inline">-->
                                                                        <!--                                                                                         <span-->
                                                                        <!--                                                                                             class=""> Subject RE:</span>-->
                                                                        <!--                                                                                        {{ childEmail.subject }}-->
                                                                        <!--                                                                                    </span>-->
                                                                        <!--                                                                                    </div>-->

                                                                        <!--                                                                                    <div class="image">-->
                                                                        <!--                                                                                        <p>-->
                                                                        <!--                                                                                            <span-->
                                                                        <!--                                                                                                v-html="childEmail.body">-->
                                                                        <!--                                                                                        </span>-->
                                                                        <!--                                                                                        </p>-->
                                                                        <!--                                                                                    </div>-->
                                                                        <!--                                                                                    &lt;!&ndash;                                                                                    <p class="mb-0">Sincerely yours,</p>&ndash;&gt;-->
                                                                        <!--                                                                                    &lt;!&ndash;                                                                                    <p class="text-bold-500">Careox Dev&ndash;&gt;-->
                                                                        <!--                                                                                    &lt;!&ndash;                                                                                        Teams&ndash;&gt;-->
                                                                        <!--                                                                                    &lt;!&ndash;                                                                                    </p>&ndash;&gt;-->
                                                                        <!--                                                                                    <span-->
                                                                        <!--                                                                                        v-for="attachment in childEmail.attachments"-->
                                                                        <!--                                                                                        class="d-flex">-->
                                                                        <!--                                                                                <div class="file d-inline mr-1">-->

                                                                        <!--                                                                                </div>-->


                                                                        <!--                                                                                          <span class="mr-1"-->
                                                                        <!--                                                                                                v-if="attachment.content_id && (attachment.content_type == 'jpg' || attachment.content_type == 'jpeg' || attachment.content_type == 'jfif' || attachment.content_type =='pjpeg' || attachment.content_type =='pjp' || attachment.content_type =='png' || attachment.content_type == 'svg')">-->
                                                                        <!--                                                                                           <span-->
                                                                        <!--                                                                                               v-if="attachment.content_id">-->
                                                                        <!--                                                                                                <img-->
                                                                        <!--                                                                                                    :src="'/storage/images/'+attachment.content_id">-->
                                                                        <!--                                                                                           </span>-->
                                                                        <!--                                                                                          </span>-->

                                                                        <!--                                                                                        &lt;!&ndash;                                                                                     </span>&ndash;&gt;-->
                                                                        <!--                                                                                    <span class="mr-1" v-else>-->
                                                                        <!--                                                                                    <a :href="attachment.url"-->
                                                                        <!--                                                                                       target="_blank"-->
                                                                        <!--                                                                                       style="color: #727E8C">-->
                                                                        <!--                                                                                        {{-->
                                                                        <!--                                                                                            attachment.content_id ? attachment.content_id : attachment.name + '(' + attachmentFileSize(attachment.size) + ')'-->
                                                                        <!--                                                                                        }}-->
                                                                        <!--                                                                                    </a>-->
                                                                        <!--                                                                                           <td class="text-small py-0 my-0 action pr-1">-->
                                                                        <!--                                                                                    <span-->
                                                                        <!--                                                                                        class="d-inline-flex align-items-center action">-->
                                                                        <!--                                                                                            <a :href="route('export.attachment',attachment.id)">-->
                                                                        <!--                                                                                                <span-->
                                                                        <!--                                                                                                    class=""-->
                                                                        <!--                                                                                                    style="color: #727E8C">-->
                                                                        <!--                                                                                                    <i class="bx bx-download font-medium-1 align-items-center text-center show1"></i>-->
                                                                        <!--                                                                                                </span>-->
                                                                        <!--                                                                                            </a>-->
                                                                        <!--                                                                                    </span>-->
                                                                        <!--                                                                                </td>-->
                                                                        <!--                                                                                        </span>-->


                                                                        <!--                                                                            </span>-->
                                                                        <!--                                                                                </div>-->
                                                                        <!--                                                                            </div>-->
                                                                        <!--                                                                        </div>-->
                                                                        <!--</div>-->

                                                                        <div class="row px-2 mb-4"
                                                                             v-show="isShow"
                                                                             :id="email.id">
                                                                            <!-- quill editor for reply message -->
                                                                            <div class="col-12 px-0">
                                                                                <EmailForm :email="email"
                                                                                           :to="activeEmail"
                                                                                           :ref="'markdowndetails'+email.id"></EmailForm>
                                                                            </div>
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
                                                        <div class="col-12 ">
                                                            <pagination :links="emails.links"
                                                                        class="float-right">
                                                            </pagination>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ Email list Area -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>

import moment from 'moment';
import Label from "@/Jetstream/Label";
import Button from "../../Jetstream/Button";
import EmailForm from "@/components/EmailForm";
import EmailComposeForm from "@/components/EmailComposeForm";
import ReplyAllForm from "@/components/ReplyAllForm";
import ForwardForm from "@/components/ForwardForm";
import Pagination from "../../admin/Pagination";
import AdminLayout from "../../Layouts/AdminLayout";
import JetInputError from './../../Jetstream/InputError'
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {
    name: "Index",
    props: [
        'type',
        'folders',
        'errors',
        'emails',
        'colors',
        'params',
        'activeEmail',
        'current_page',
        'emailSettings',
        'activeEmailId',
        'emailAccountId',
    ],
    components: {
        Label,
        Button,
        EmailForm,
        EmailComposeForm,
        ReplyAllForm,
        ForwardForm,
        Pagination,
        AdminLayout,
        JetInputError,
        ConfirmatiomModal
    },
    data() {
        return {
            form: this.$inertia.form({
                searchWord: '',
                id: ''
            }),
            query: {
                query: '',
                id: false,
                from: false,
                to: false,
                subject: false,
                case_id: false,
                date: false,
                email_account_id: '',
                read: false,
                unread: false,
                star: false,
                attachments: false,
                direction: null,
                type: null,
                email: null
            },
            itemId: '',
            isShow: false,
            sweetAlert: false,
            searchItem: false,
            searchCases: [],
            orderId: [],
            productId: [],
            product_id: [],
            validated: true,
            successAlert: 0,
            activeChannelEmail: '',
            baseUrl: '',
            fetchActive: false,
            lastOpenCollapseId: 0,
            emailSettingsArray: [],
            replyAllModalEmail: {},
            replyType : '',
            collapseStatus: true,
        }
    },
    beforeMount() {
        this.baseUrl = window.location.origin
        document.title = process.env.MIX_APP_NAME + " - Emails";
        let arr = [];
        this.emailSettings.forEach(function (emailSettings) {
            arr.push(emailSettings.username.toLowerCase());
        });
        this.emailSettingsArray = arr;

    },
    mounted() {
        if (this.params) {
            let params = Object.keys(this.params);
            for (let i of params) {
                Object.assign(this.query, {[i]: this.params[i]});
            } 
        }
    },
    methods: {
      
        emitFormStatus(value) {
            this.replyAllModalEmail = {};
        },
        replyAllModalEmailSet(index,replyType) {
            this.replyAllModalEmail = this.emails.data[index];
            this.replyType = replyType;
        },
        ccString(ccAddresses) {
            let address = '';
            ccAddresses.forEach(function (ccAddresse, key) {
                if (key === 0) {
                    address = ccAddresse.address;
                } else {
                    address = address.concat(", ", ccAddresse.address);
                }
            })
            return address;
        },

        getTo(emailTo) {
            return emailTo ? emailTo.map((to) => '&lt;' + to['full'] + '&gt;').join(', ') : ''
        },
        getAddresses(addresses,type){
            if(type === 'To') {
                return   addresses ? addresses.map((to)=>'<'+to['mail']+'>').join(', ') : ''
            } else if(type === 'Cc') {
                return   addresses ? addresses.map((cc)=>'<'+cc['mail']+'>').join(', ') : ''
            } else {
                return   addresses ? addresses.map((bcc)=>'<'+bcc['mail']+'>').join(', ') : ''
            }

        },
        attachmentFileSize(size) {
            if (size > 1023 && size <= 1048575) {
                return (size / 1024).toFixed(1) + ' KB';
            }
            if (size > 1048575) {
                return (size / 1048576).toFixed(1) + ' MB';
            }
            return size + ' B';
        },

        EmailType(email, id, email_account_id) {
            this.activeChannelEmail = email;
            this.$inertia.visit(route('fetch-email.index'), {
                method: 'get',
                data: {
                    email: email,
                    id: id,
                    email_account_id: email_account_id
                }
            })
        },

        chennalEmail() {
            this.fetchActive = true;
            this.$inertia.visit(route('fetch-email.create'), {
                method: 'get',
                data: {
                    email: this.activeEmail
                }
            })
        },
        showSuccessAlert() {
            this.successAlert = 1;
        },
        loadEmail(type) {
            this.$inertia.visit(route('fetch-email.index'), {
                method: 'get',
                data: {
                    type: type,
                    email: this.activeEmail,
                    id: this.activeEmailId,
                }
            })
        },

        changeStatus(e, id, markAsRead,index) {
            let target = e.target;
            let self = this;
            $('.collapse-header').on('shown.bs.collapse', function () {
                self.collapseStatus = true;
                e.stopImmediatePropagation();
                $('.collapse').removeClass('show')
                $('.card-header').removeClass('back').addClass('collapsed');
                if (!$(target).hasClass('.card-header')) {
                    $(target).closest('.card-header').siblings().addClass('show')
                    $(target).closest('.card-header').addClass('back').removeClass('collapsed').removeClass('addColor');
                } else {
                    $(target).addClass('back').removeClass('collapsed');
                    $(target).siblings().addClass('show')
                }
                target = null;
            });
            $('.collapse-header').on('hidden.bs.collapse', function () {
                self.collapseStatus = false;
                self.isShow = false;
                if (!$(target).hasClass('.card-header')) {
                    $(target).closest('.card-header').removeClass('back').addClass('addColor');
                } else {
                    $('.card-header').removeClass('back');
                }
                target = null;
            });

            // if (this.lastOpenCollapseId !== 0 && this.lastOpenCollapseId !== id) {
            //     if (this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.body !== '') {
            //         let collapseId = this.lastOpenCollapseId;
            //         let previousReplyFormData = new FormData();
            //         previousReplyFormData.append('form[id]', this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.id);
            //         previousReplyFormData.append('form[message_id]', this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.message_id);
            //         previousReplyFormData.append('form[from]', this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.from);
            //         previousReplyFormData.append('form[to]', this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.to);
            //         previousReplyFormData.append('form[cc]', this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.cc);
            //         previousReplyFormData.append('form[bcc]', this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.bcc);
            //         previousReplyFormData.append('form[subject]', this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.subject);
            //         previousReplyFormData.append('form[body]', this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.body);
            //         previousReplyFormData.append('form[case_id]', this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.case_id ? this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.case_id : '');
            //         if (Object.keys(this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.attachments).length > 0) {
            //             for (let i = 0; i < this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.attachments.length; i++) {
            //                 previousReplyFormData.append('files[]', this.$refs["markdowndetails" + this.lastOpenCollapseId][0].form.attachments[i]);
            //             }
            //         }
            //         axios.post('drafts-email', previousReplyFormData)
            //             .then(response => {
            //                 if (response.data.message === 'Mail not move to drafts folder live successfully.') {
            //                     alert("Mail not saved to drafts folder.");
            //                 }
            //                 if (response.data.message === 'Mail move to drafts folder live successfully.') {
            //                     this.$refs["markdowndetails" + collapseId][0].form.cc = '';
            //                     this.$refs["markdowndetails" + collapseId][0].form.bcc = '';
            //                     this.$refs["markdowndetails" + collapseId][0].form.body = '';
            //                     alert("Mail saved to drafts folder.");
            //                 }
            //             });
            //     }
            // }
            // this.lastOpenCollapseId = id;

            if (markAsRead === 0 || markAsRead == false) {
                document.getElementById("from" + id).style.fontWeight = "400";
                document.getElementById("to" + id).style.fontWeight = "400";
                document.getElementById("subject" + id).style.fontWeight = "400";
                document.getElementById("case-number" + id).style.fontWeight = "400";
                document.getElementById("date" + id).style.fontWeight = "400";
                // axios.post('email-status', {
                //     "email_id": id,
                //     "markAsRead": markAsRead
                // })
                //     .then(responseData => {
                //         this.emails = responseData.data
                //     });
                this.emailMark(e, id, this.activeEmail, this.type, index, 'collapse open');
            }
        },
        emailBodyFirstChar(text) {
            text.charAt(0);
        },

        emailMark(e, id, activeEmail, type, index, markType) {
            if(markType === 'read/unread') {
                e.stopPropagation();
            }
            else if(markType === 'unread') {
                $('#headingCollapse5').click()
            }
            else {}
            axios.post('email-mark', {
                "emailId": id,
                "activeEmail": activeEmail,
                "folder": type,
            })
                .then((response) => {
                    if (response.data.result === 1 || response.data.result === true) {
                        this.emails.data[index].is_seen = response.data.result;
                    } else {
                        this.emails.data[index].is_seen = response.data.result;
                    }
                });
        },

        check_single: function (orderIDD) {
            this.orderId = [];
            this.validated = false;
            this.orderId.push(orderIDD);
            this.productId = [];
        },
        check_prod: function (id, item) {
            if (this.orderId[0] != id) {
                this.orderId = [];
                this.productId = [];
            }
            this.productId.push(item);
        },
        saveCase() {
            this.$inertia.visit(route('cases.store'), {
                method: 'post',
                data: {
                    order_id: this.orderId,
                    product_id: this.productId,
                    query: this.form.searchWord,
                    email_id: this.form.id
                }
            })
            $('#addItem').modal('hide')
        },
        saveCaseWithOutOrder() {
            this.$inertia.visit(route('cases.store'), {
                method: 'post',
                data: {
                    email_id: this.form.id,
                    from_email: this.form.searchWord
                }
            })
            $('#addItem').modal('hide')
        },

        viewCase(case_id) {
            this.$inertia.visit(route('cases.show', case_id), {
                method: 'get',
                data: {}
            })
            alert(id);
        },

        generateCase(from_email, id) {
            this.form.searchWord = from_email;
            this.orderId = [];
            this.productId = [];
            this.form.id = id
            axios.get("search-email-case", {
                params: {
                    word: this.form.searchWord,
                },
            })
                .then((response) => {
                    if (response.data.orders) {
                        $('#addItem').modal('show');
                        this.searchCases = response.data.orders
                        console.log(this.searchCases, '354670978654356789099');
                    } else {
                    }
                });
        },

        changeFolder(id, activeEmail, type, moveToFolder) {
            this.$inertia.visit(route('change.folder', [id, activeEmail, type, moveToFolder]), {
                method: 'get'
            })
        },

        starStatus(e, id, activeEmail, type, index) {
            e.stopPropagation();
            axios.get("email-star-status", {
                params: {
                    emailId: id,
                    activeEmail: activeEmail,
                    folder: type
                },
            })
                .then((response) => {
                    if (response.data.result === 1 || response.data.result === true) {
                        this.emails.data[index].is_flagged = response.data.result;
                    } else {
                        this.emails.data[index].is_flagged = response.data.result;
                    }
                });
        },

        modalToggle() {
            this.$emit("input", !this.value);
        },

        showFilter() {
            eventHub.$emit('show-guest-advanced-filter');
            this.filter = false;
        },

        hideFilter() {
            eventHub.$emit('hide-guest-advanced-filter');
            this.filter = true;
        },

        filtersMethod() {
            return this.filter ? this.showFilter() : this.hideFilter();
        },

        formatDate(date) {
            return moment(date).format('h:mm a DD MMM YY')
        },
        resetQuery() {
            this.query = {}
            this.loadData()
        },
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            this.sweetAlert = false
            this.$inertia.delete(`/stock-items/${this.itemId}`)
        },
        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
        },
        stopPropagation(e) {
            e.stopPropagation();
        },
        resetSort(e) {
            this.query = {};
            this.query.direction = '';
            this.query.from = '';
            this.query.to = '';
            this.query.case_id = '';
            this.query.subject = '';
            this.query.date = '';
            this.query.type = this.type;
            this.query.id = this.params['id'];
            this.query.email = this.params['email'];
            this.loadData();
        },
        resetFilter() {
            this.query = {};
            this.query.read = '';
            this.query.unread = '';
            this.query.star = '';
            this.query.attachments = '';
            this.query.type = this.type;
            this.query.id = this.params['id'];
            this.query.email = this.params['email'];
            this.loadData();
        },
        search() {
            this.searchItem = true;
            this.query.type = this.type;
            this.loadData()
        },
        filter() {
            this.query.type = this.type;
            this.loadData();
        },
        sort(direction) {
            this.query.direction = direction;
            this.query.type = this.type;
            this.loadData();
        },
        check_one() {
            if (this.query.from = false) {
                this.query.from = true;
                this.query.to = [];
                this.query.subject = [];
                this.query.case_id = [];
                this.query.date = [];
            }
            if (this.query.to = false) {
                this.query.to = true;
                this.query.from = [];
                this.query.subject = [];
                this.query.case_id = [];
                this.query.date = [];
            }
            if (this.query.case_id = false) {
                this.query.case_id = true;
                this.query.from = [];
                this.query.to = [];
                this.query.subject = [];
                this.query.date = [];
            }
            if (this.query.subject = false) {
                this.query.subject = true;
                this.query.from = [];
                this.query.to = [];
                this.query.case_id = [];
                this.query.date = [];
            }
            if (this.query.date = false) {
                this.query.date = true;
                this.query.from = [];
                this.query.to = [];
                this.query.subject = [];
                this.query.case_id = [];
            }
            if (this.query.read = false) {
                this.query.read = true;
                this.query.unread = [];
                this.query.star = [];
            }
            if (this.query.unread = false) {
                this.query.unread = true;
                this.query.read = [];
                this.query.star = [];
            }
            if (this.query.star = false) {
                this.query.star = true;
                this.query.unread = [];
                this.query.read = [];
            }
        },
            showTooltip(id) {
                if (this.id == null) {
                    this.id = id;
                    $("[data-toggle=" + id + "]").popover({
                        html: true,
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
        goto() {
            this.isShow = !this.isShow;
        },
        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('fetch-email.index'), {
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

/*@import '../../../../public/frest/css/st';*/
@import '../../../../public/frest/css/pages/app-email.css';
@import '../../../../public/frest/css/core/menu/menu-types/horizontal-menu.css';
@import '../../../../public/frest/vendors/css/editors/quill/quill.snow.css';

.email-space {
    padding-bottom: 6px;
}

/*#AppleMailSignature{*/
/*   */
/*}*/
.appMail {
    display: none !important;
}

/*.custom-class {*/
/*    */
/*    font-family: "IBM Plex Sans", Helvetica, Arial, serif;*/

/*    font-size: 13px;*/
/*}*/

.show1 {
    margin-top: 9px;
}

.file {
    margin-top: 29px;
}

.tag {
    line-height: 1rem;
    margin-bottom: 0px !important;
    margin-top: 0px !important;
    padding-bottom: 11px !important;
    padding-top: 0px !important;
}

.date {
    font-size: 13px;

}

.action {
    margin-right: 4px !important;
    margin-top: 10px !important;
    margin-bottom: 10px !important;
}

.circle {
    height: 10px;
    width: 10px;
    border-radius: 25px;
}

.back {
    background-color: red !important;
    color: #FFFFFF !important;
}

.email-action {
    background-color: #F2F4F4;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.custom-dropdown {
    margin-top: 0.5rem !important;
}

.addColor {
    background-color: #FFFFFF !important;
}

table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}

.card {
    border: none !important;
}

.modal1 {
    width: 1000px;
}

.categories-list {
    margin: 20px 0px;
}

.categories-list .category {
    font-size: 14px;
    display: flex;
    flex-direction: column;
    position: relative;
    padding: 3px 0px 3px 22px;
    font-weight: 300;
    display: flex;
}

.categories-list .category label {
    width: 100%;
}

.categories-list .category a {
    color: #95939a;
    position: absolute;
    right: 0px;
    z-index: 1000;
}

html {
    scroll-behavior: smooth;
}

.categories-list .category input[type=checkbox] {
    margin: 0px 10px 0px 0px;
    position: absolute;
    left: 0px;
    top: 7px;
}

.categories-list .category .subcategories {
    margin-left: 0px;
    display: none;
    padding: 5px;
    flex-direction: column;
}

.categories-list .category .subcategories .category {
    padding-left: 22px;
    flex-direction: column;
}

.categories-list .category .subcategories .category:last-child {
    border-bottom: none;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.form-check-label {
    margin-top: 4px;
}

span[disabled="disabled"] {
    pointer-events: none;
    opacity: 1;
    color: white !important;
    display: none;
}

.excel {
    color: forestgreen !important;
}

.main-content1 {
    background-color: #F2F4F4;
}

.header-subject {
    white-space: nowrap;
    width: 220px;
    overflow: hidden;
    text-overflow: ellipsis;
    position: absolute;
}


#date-section {
    justify-content: end;
}

.header-date {
    margin-top: 8px;
}

/* .dropdown-menu {
    max-height: 220px;
    overflow: hidden;
} */

@media (max-width: 575.98px) {
    .filter-dropdown {
        width: 100% !important;
        padding-right: 0px !important;
        padding-left: 11px !important;
    }

    .sort-dropdown {
        width: 100% !important;
        padding-left: 11px !important;
        padding-right: 0px !important;
        padding-top: 15px !important;
    }

    @media (max-width: 1243px) {
        .header-date {
            margin-right: -2px !important;
            font-size: 13px;
            margin-top: 10px;
            font-weight: bold;
        }
    }
    @media (max-width: 1440px) {
        .header-date {
            font-size: 3px;
        }
    }
}
</style>
