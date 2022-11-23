<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
                <inertia-link :href="route('case.create')" class="btn btn-primary" data-repeater-create="">
                    Add Case
                </inertia-link>
            </div>
        </div>
        <div class="row pb-2" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="">
                            <div class="tabbable-responsive">
                                <div class="tabbable">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first"
                                               role="tab" aria-controls="first" aria-selected="true">Open</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="second-tab" data-toggle="tab" href="#second"
                                               role="tab" aria-controls="second" aria-selected="false">In Progress</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="third-tab" data-toggle="tab" href="#third"
                                               role="tab" aria-controls="third" aria-selected="false">Closed</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="first" role="tabpanel"
                                     aria-labelledby="first-tab">
                                    <div class="row" id="table-hover">
                                        <!--                                        <div class="col-12 px-3">-->
                                        <!--                                            <div class="card-one py-0 my-0 bg-white">-->
                                        <!--                                                <div class="card-content">-->
                                        <!--                                                    <div data-repeater-list="group-a">-->
                                        <!--                                                        <div>-->
                                        <!--                                                            <div class="top d-flex flex-wrap">-->
                                        <!--                                                                <div class="action-filters flex-grow-1">-->
                                        <!--                                                                    <div id="" class="dataTables_filter">-->
                                        <!--                                                                        <div-->
                                        <!--                                                                            class="input-group form-group d-flex position-relative mt-1 px-1 pr-md-0">-->
                                        <!--                                                                            <input type="text" class="form-control border-light-gray btn-height"-->
                                        <!--                                                                                   placeholder="Search..."-->
                                        <!--                                                                                   aria-label="Search"-->
                                        <!--                                                                                   aria-describedby="basic-addon2" v-model="query.query"-->
                                        <!--                                                                                   @change="search">-->
                                        <!--                                                                            <div class="input-group-append">-->
                                        <!--                                                                                <button class="input-group-text search-btn" @change="search">-->
                                        <!--                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"-->
                                        <!--                                                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"-->
                                        <!--                                                                                         stroke-width="2" stroke-linecap="round"-->
                                        <!--                                                                                         stroke-linejoin="round"-->
                                        <!--                                                                                         class="feather feather-search feather-16 pb-0 mb-0 mt-0">-->
                                        <!--                                                                                        <circle cx="11" cy="11" r="8"></circle>-->
                                        <!--                                                                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>-->
                                        <!--                                                                                    </svg>-->
                                        <!--                                                                                </button>-->
                                        <!--                                                                            </div>-->
                                        <!--                                                                        </div>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="actions action-btns d-flex align-items-center sort-dropdown pl-1">-->
                                        <!--                                                                    <div class="dropdown w-100 pr-1 sort-dropdown2">-->
                                        <!--                                                                        <button class="btn border dropdown-toggle w-100" type="button"-->
                                        <!--                                                                                data-toggle="dropdown" aria-haspopup="true"-->
                                        <!--                                                                                aria-expanded="false">-->
                                        <!--                                                                            Sort-->
                                        <!--                                                                        </button>-->
                                        <!--                                                                        <div class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"-->
                                        <!--                                                                             aria-labelledby="" @click="stopPropagation">-->
                                        <!--                                                                            <div class="col-12 pl-2 pt-1">-->
                                        <!--                                                                                <div class="d-inline-flex w-100">-->
                                        <!--                                                                                    <h6 class="py-0 my-0">Sort</h6>-->
                                        <!--                                                                                    <span class="primary pl-20 ml-2 pointer" @click="resetSort">Reset</span>-->
                                        <!--                                                                                </div>-->
                                        <!--                                                                                <div class="align-items-center text-base pt-1">-->
                                        <!--                                                                                    <p class="tag">-->
                                        <!--                                                                                        <input type="checkbox" name="product_id" id="product_id"-->
                                        <!--                                                                                               v-model="query.product_id">-->
                                        <!--                                                                                        <label class="pl-1 py-0 my-0" for="product_id">Product Name</label>-->
                                        <!--                                                                                    </p>-->
                                        <!--                                                                                    <p class="tag">-->
                                        <!--                                                                                        <input type="checkbox" name="channel_name" id="channel_name"-->
                                        <!--                                                                                               v-model="query.channel_name">-->
                                        <!--                                                                                        <label-->
                                        <!--                                                                                            class="pl-1 py-0 my-0" for="channel_name">Channel Name</label>-->
                                        <!--                                                                                    </p>-->
                                        <!--                                                                                    <p class="tag">-->
                                        <!--                                                                                        <input type="checkbox" name="phone"-->
                                        <!--                                                                                               id="phone"-->
                                        <!--                                                                                               v-model="query.phone">-->
                                        <!--                                                                                        <label class="pl-1 py-0 my-0" for="phone">Phone</label>-->
                                        <!--                                                                                    </p>-->
                                        <!--                                                                                </div>-->
                                        <!--                                                                            </div>-->
                                        <!--                                                                            <div class="dropdown-divider py-0 my-0"></div>-->
                                        <!--                                                                            <div class="col-12 pl-2 d-inline-flex">-->
                                        <!--                                                                                <p class="pt-1">-->
                                        <!--                                                                                    <button type="button" id="asce" @click="sort('asc')"-->
                                        <!--                                                                                            class=" btn btn-sm btn-primary font-small font-weight-normal stock-order">-->
                                        <!--                                                                                        Asc-->
                                        <!--                                                                                    </button>-->
                                        <!--                                                                                </p>-->
                                        <!--                                                                                <p class="pt-1 pl-3">-->
                                        <!--                                                                                    <button type="button" id="desc" @click="sort('desc')"-->
                                        <!--                                                                                            class=" btn btn-sm btn-light-secondary font-small font-weight-normal stock-order">-->
                                        <!--                                                                                        Desc-->
                                        <!--                                                                                    </button>-->
                                        <!--                                                                                </p>-->
                                        <!--                                                                            </div>-->
                                        <!--                                                                        </div>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                            </div>-->
                                        <!--                                                        </div>-->
                                        <!--                                                    </div>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <div class="col-12 px-3 pb-0 mb-0">
                                            <div class="card mb-1">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="supplier-name">Case#</th>
                                                                <th class="">channel</th>
                                                                <th class="">Customer</th>
                                                                <th class="">Order#</th>
                                                                <th class="">Tracking#</th>
                                                                <th class="">Type</th>
                                                                <th class="">priority</th>
                                                                <th class="">status</th>
                                                                <th class=""></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="open in openCases.data">
                                                                <td class="text-truncate">{{ open.case_number }}</td>
                                                                <td class="text-truncate">{{ open.channel.name }}</td>
                                                                <td class="text-truncate">{{
                                                                        open.order.customer.name
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{
                                                                        open.order.order_number
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{
                                                                        open.tracking_number
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{ open.type }}</td>
                                                                <td class="text-truncate">{{ open.priority }}</td>
                                                                <td class="text-truncate">{{ open.status }}</td>
                                                                <td class="text-right py-0 my-0 truncate custom-padding-right">
                                                                    <div class="dropdown">
                                                                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                    </span>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                    <a :href="route('case.show',open.id)" class="dropdown-item"><i class="bx bx-show mr-1"></i>Show</a>
                                                                    <a class="dropdown-item" v-on:click="confirmDelete(open.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                        <div class="col-12">
                                            <pagination :links="openCases.links"
                                                        class="float-right openCases"></pagination>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                                    <div class="col-12 px-1 pb-0 mb-0">
                                        <!--                                        <div class="col-12 px-3">-->
                                        <!--                                            <div class="card-one py-0 my-0 bg-white">-->
                                        <!--                                                <div class="card-content">-->
                                        <!--                                                    <div data-repeater-list="group-a">-->
                                        <!--                                                        <div>-->
                                        <!--                                                            <div class="top d-flex flex-wrap">-->
                                        <!--                                                                <div class="action-filters flex-grow-1">-->
                                        <!--                                                                    <div class="dataTables_filter">-->
                                        <!--                                                                        <div-->
                                        <!--                                                                            class="input-group form-group d-flex position-relative mt-1 px-1 pr-md-0">-->
                                        <!--                                                                            <input type="text" class="form-control border-light-gray btn-height"-->
                                        <!--                                                                                   placeholder="Search..."-->
                                        <!--                                                                                   aria-label="Search"-->
                                        <!--                                                                                   aria-describedby="basic-addon2" v-model="query.query"-->
                                        <!--                                                                                   @change="search">-->
                                        <!--                                                                            <div class="input-group-append">-->
                                        <!--                                                                                <button class="input-group-text search-btn" @change="search">-->
                                        <!--                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"-->
                                        <!--                                                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"-->
                                        <!--                                                                                         stroke-width="2" stroke-linecap="round"-->
                                        <!--                                                                                         stroke-linejoin="round"-->
                                        <!--                                                                                         class="feather feather-search feather-16 pb-0 mb-0 mt-0">-->
                                        <!--                                                                                        <circle cx="11" cy="11" r="8"></circle>-->
                                        <!--                                                                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>-->
                                        <!--                                                                                    </svg>-->
                                        <!--                                                                                </button>-->
                                        <!--                                                                            </div>-->
                                        <!--                                                                        </div>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="actions action-btns d-flex align-items-center sort-dropdown pl-1">-->
                                        <!--                                                                    <div class="dropdown w-100 pr-1 sort-dropdown2">-->
                                        <!--                                                                        <button class="btn border dropdown-toggle w-100" type="button"-->
                                        <!--                                                                                data-toggle="dropdown" aria-haspopup="true"-->
                                        <!--                                                                                aria-expanded="false">-->
                                        <!--                                                                            Sort-->
                                        <!--                                                                        </button>-->
                                        <!--                                                                        <div class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"-->
                                        <!--                                                                             aria-labelledby="" @click="stopPropagation">-->
                                        <!--                                                                            <div class="col-12 pl-2 pt-1">-->
                                        <!--                                                                                <div class="d-inline-flex w-100">-->
                                        <!--                                                                                    <h6 class="py-0 my-0">Sort</h6>-->
                                        <!--                                                                                    <span class="primary pl-20 ml-2 pointer" @click="resetSort">Reset</span>-->
                                        <!--                                                                                </div>-->
                                        <!--                                                                                <div class="align-items-center text-base pt-1">-->
                                        <!--                                                                                    <p class="tag">-->
                                        <!--                                                                                        <input type="checkbox" name="product_id" id="product_id"-->
                                        <!--                                                                                               v-model="query.product_id">-->
                                        <!--                                                                                        <label class="pl-1 py-0 my-0" for="product_id">Product Name</label>-->
                                        <!--                                                                                    </p>-->
                                        <!--                                                                                    <p class="tag">-->
                                        <!--                                                                                        <input type="checkbox" name="channel_name" id="channel_name"-->
                                        <!--                                                                                               v-model="query.channel_name">-->
                                        <!--                                                                                        <label-->
                                        <!--                                                                                            class="pl-1 py-0 my-0" for="channel_name">Channel Name</label>-->
                                        <!--                                                                                    </p>-->
                                        <!--                                                                                    <p class="tag">-->
                                        <!--                                                                                        <input type="checkbox" name="phone"-->
                                        <!--                                                                                               id="phone"-->
                                        <!--                                                                                               v-model="query.phone">-->
                                        <!--                                                                                        <label class="pl-1 py-0 my-0" for="phone">Phone</label>-->
                                        <!--                                                                                    </p>-->
                                        <!--                                                                                </div>-->
                                        <!--                                                                            </div>-->
                                        <!--                                                                            <div class="dropdown-divider py-0 my-0"></div>-->
                                        <!--                                                                            <div class="col-12 pl-2 d-inline-flex">-->
                                        <!--                                                                                <p class="pt-1">-->
                                        <!--                                                                                    <button type="button" id="asce" @click="sort('asc')"-->
                                        <!--                                                                                            class=" btn btn-sm btn-primary font-small font-weight-normal stock-order">-->
                                        <!--                                                                                        Asc-->
                                        <!--                                                                                    </button>-->
                                        <!--                                                                                </p>-->
                                        <!--                                                                                <p class="pt-1 pl-3">-->
                                        <!--                                                                                    <button type="button" id="desc" @click="sort('desc')"-->
                                        <!--                                                                                            class=" btn btn-sm btn-light-secondary font-small font-weight-normal stock-order">-->
                                        <!--                                                                                        Desc-->
                                        <!--                                                                                    </button>-->
                                        <!--                                                                                </p>-->
                                        <!--                                                                            </div>-->
                                        <!--                                                                        </div>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                            </div>-->
                                        <!--                                                        </div>-->
                                        <!--                                                    </div>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <div class="col-12 px-1 pb-0 mb-0">
                                            <div class="card mb-1">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="supplier-name">Case#</th>
                                                                <th class="">channel</th>
                                                                <th class="">Customer</th>
                                                                <th class="">Order#</th>
                                                                <th class="">Tracking#</th>
                                                                <th class="">Type</th>
                                                                <th class="">priority</th>
                                                                <th class="">status</th>
                                                                <th class=""></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="progress in inprogressCases.data">
                                                                <td class="text-truncate">{{
                                                                        progress.case_number
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{
                                                                        progress.channel.name
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">
                                                                    {{ progress.order.customer.name }}
                                                                </td>
                                                                <td class="text-truncate">{{
                                                                        progress.order.order_number
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{progress.tracking_number }}
                                                                </td>
                                                                <td class="text-truncate">{{ progress.type }}</td>
                                                                <td class="text-truncate">{{ progress.priority }}</td>
                                                                <td class="text-truncate">{{ progress.status }}</td>
                                                                <td class="text-right py-0 my-0 truncate custom-padding-right">
                                                                    <span class="d-inline-flex align-items-center">
                                                                      <inertia-link :href="route('case.show',progress.id)">
                                                                        <span class="badge-circle badge-circle-light-secondary action">
                                                                           <i class="bx bxs-show font-medium-1 align-items-center text-center">
                                                                           </i>
                                                                        </span>
                                                                      </inertia-link>
                                                                    </span>
                                                                    <button v-on:click="confirmDelete(progress.id)">
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
                                        <div class="col-12 mr-5">
                                            <pagination :links="inprogressCases.links" class="float-right"></pagination>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
                                    <div class="col-12 px-1 pb-0 mb-0">
                                        <!--                                        <div class="col-12 px-3">-->
                                        <!--                                            <div class="card-one py-0 my-0 bg-white">-->
                                        <!--                                                <div class="card-content">-->
                                        <!--                                                    <div data-repeater-list="group-a">-->
                                        <!--                                                        <div>-->
                                        <!--                                                            <div class="top d-flex flex-wrap">-->
                                        <!--                                                                <div class="action-filters flex-grow-1">-->
                                        <!--                                                                    <div id="" class="dataTables_filter">-->
                                        <!--                                                                        <div-->
                                        <!--                                                                            class="input-group form-group d-flex position-relative mt-1 px-1 pr-md-0">-->
                                        <!--                                                                            <input type="text" class="form-control border-light-gray btn-height"-->
                                        <!--                                                                                   placeholder="Search..."-->
                                        <!--                                                                                   aria-label="Search"-->
                                        <!--                                                                                   aria-describedby="basic-addon2" v-model="query.query"-->
                                        <!--                                                                                   @change="search">-->
                                        <!--                                                                            <div class="input-group-append">-->
                                        <!--                                                                                <button class="input-group-text search-btn" @change="search">-->
                                        <!--                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"-->
                                        <!--                                                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"-->
                                        <!--                                                                                         stroke-width="2" stroke-linecap="round"-->
                                        <!--                                                                                         stroke-linejoin="round"-->
                                        <!--                                                                                         class="feather feather-search feather-16 pb-0 mb-0 mt-0">-->
                                        <!--                                                                                        <circle cx="11" cy="11" r="8"></circle>-->
                                        <!--                                                                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>-->
                                        <!--                                                                                    </svg>-->
                                        <!--                                                                                </button>-->
                                        <!--                                                                            </div>-->
                                        <!--                                                                        </div>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="actions action-btns d-flex align-items-center sort-dropdown pl-1">-->
                                        <!--                                                                    <div class="dropdown w-100 pr-1 sort-dropdown2">-->
                                        <!--                                                                        <button class="btn border dropdown-toggle w-100" type="button"-->
                                        <!--                                                                                data-toggle="dropdown" aria-haspopup="true"-->
                                        <!--                                                                                aria-expanded="false">-->
                                        <!--                                                                            Sort-->
                                        <!--                                                                        </button>-->
                                        <!--                                                                        <div class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"-->
                                        <!--                                                                             aria-labelledby="" @click="stopPropagation">-->
                                        <!--                                                                            <div class="col-12 pl-2 pt-1">-->
                                        <!--                                                                                <div class="d-inline-flex w-100">-->
                                        <!--                                                                                    <h6 class="py-0 my-0">Sort</h6>-->
                                        <!--                                                                                    <span class="primary pl-20 ml-2 pointer" @click="resetSort">Reset</span>-->
                                        <!--                                                                                </div>-->
                                        <!--                                                                                <div class="align-items-center text-base pt-1">-->
                                        <!--                                                                                    <p class="tag">-->
                                        <!--                                                                                        <input type="checkbox" name="product_id" id="product_id"-->
                                        <!--                                                                                               v-model="query.product_id">-->
                                        <!--                                                                                        <label class="pl-1 py-0 my-0" for="product_id">Product Name</label>-->
                                        <!--                                                                                    </p>-->
                                        <!--                                                                                    <p class="tag">-->
                                        <!--                                                                                        <input type="checkbox" name="channel_name" id="channel_name"-->
                                        <!--                                                                                               v-model="query.channel_name">-->
                                        <!--                                                                                        <label-->
                                        <!--                                                                                            class="pl-1 py-0 my-0" for="channel_name">Channel Name</label>-->
                                        <!--                                                                                    </p>-->
                                        <!--                                                                                    <p class="tag">-->
                                        <!--                                                                                        <input type="checkbox" name="phone"-->
                                        <!--                                                                                               id="phone"-->
                                        <!--                                                                                               v-model="query.phone">-->
                                        <!--                                                                                        <label class="pl-1 py-0 my-0" for="phone">Phone</label>-->
                                        <!--                                                                                    </p>-->
                                        <!--                                                                                </div>-->
                                        <!--                                                                            </div>-->
                                        <!--                                                                            <div class="dropdown-divider py-0 my-0"></div>-->
                                        <!--                                                                            <div class="col-12 pl-2 d-inline-flex">-->
                                        <!--                                                                                <p class="pt-1">-->
                                        <!--                                                                                    <button type="button" id="asce" @click="sort('asc')"-->
                                        <!--                                                                                            class=" btn btn-sm btn-primary font-small font-weight-normal stock-order">-->
                                        <!--                                                                                        Asc-->
                                        <!--                                                                                    </button>-->
                                        <!--                                                                                </p>-->
                                        <!--                                                                                <p class="pt-1 pl-3">-->
                                        <!--                                                                                    <button type="button" id="desc" @click="sort('desc')"-->
                                        <!--                                                                                            class=" btn btn-sm btn-light-secondary font-small font-weight-normal stock-order">-->
                                        <!--                                                                                        Desc-->
                                        <!--                                                                                    </button>-->
                                        <!--                                                                                </p>-->
                                        <!--                                                                            </div>-->
                                        <!--                                                                        </div>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                            </div>-->
                                        <!--                                                        </div>-->
                                        <!--                                                    </div>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <div class="col-12 px-1 pb-0 mb-0">
                                            <div class="card mb-1">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="supplier-name">Cases#</th>
                                                                <th class="">channel</th>
                                                                <th class="">Customer</th>
                                                                <th class="">Order#</th>
                                                                <th class="">Tracking#</th>
                                                                <th class="">Type</th>
                                                                <th class="">priority</th>
                                                                <th class="">status</th>
                                                                <th class=""></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="closed in closedCases.data">
                                                                <td class="text-truncate">{{ closed.case_number }}</td>
                                                                <td class="text-truncate">{{ closed.channel.name }}</td>
                                                                <td class="text-truncate">{{
                                                                        closed.order.customer.name
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{
                                                                        closed.order.order_number
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{
                                                                        closed.tracking_number
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{ closed.type }}</td>
                                                                <td class="text-truncate">{{ closed.priority }}</td>
                                                                <td class="text-truncate">{{ closed.status }}</td>
                                                                <td class="text-right py-0 my-0 truncate custom-padding-right">
                                                                    <span class="d-inline-flex align-items-center">
                                                                          <inertia-link
                                                                              :href="route('cases.show',closed.id)">
                                                                            <span
                                                                                class="badge-circle badge-circle-light-secondary action">
                                                                               <i class="bx bxs-show font-medium-1 align-items-center text-center">
                                                                               </i>
                                                                            </span>
                                                                           </inertia-link>
                                                                    </span>
                                                                    <button v-on:click="confirmDelete(closed.id)">
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
                                        <div class="col-12 mr-5">
                                            <pagination :links="closedCases.links" class="float-right"></pagination>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                               @deleteitem="deleteItem"></ConfirmatiomModal>
        </div>
    </admin-layout>
</template>

<script>
import moment from 'moment';
import AdminLayout from "../../../Layouts/AdminLayout";
import Button from "../../../Jetstream/Button"
import Pagination from "../../../admin/Pagination";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";

export default {

    name: "index",
    props: ['openCases', 'closedCases', 'inprogressCases', 'params'],

    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
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
            sweetAlert: false,
            itemId: '',
            searchItem: false
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Cases"
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
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            this.sweetAlert = false
            this.$inertia.delete(`/erp/cases/${this.itemId}`)
        },
        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
        },
        resetQuery() {
            this.query = {}
            this.loadData()
        },
        stopPropagation(e) {
            e.stopPropagation();
        },
        search() {
            this.searchItem = true;
            this.loadData()
        },
    }
}
</script>

<style scoped>
.openCases {
    margin-right: 30px;
}

.nav-link {
    border-bottom: 1px solid #dee2e6 !important;
    padding: 20px;
}

.nav.nav-tabs .nav-item {
    padding-bottom: 0 !important;
}

.nav-item {
    padding-bottom: 10px !important;
}

.nav.nav-tabs .nav-item, .nav.nav-pills .nav-item {
    margin-right: 0 !important;
}

.nav.nav-tabs .nav-item .nav-link, .nav.nav-pills .nav-item .nav-link {
    border-radius: 0 !important;
}

.nav.nav-tabs .nav-item .nav-link.active, .nav.nav-pills .nav-item .nav-link.active {
    box-shadow: none;
    border-bottom: 0 !important;
    border-top: 1px solid #dee2e6 !important;
    border-top: 1px solid #dee2e6 !important;
    border-right: 1px solid #dee2e6 !important;
    border-left: 1px solid #dee2e6 !important;
}

.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    background-color: #FFFFFF !important;
    color: black !important;
    font-weight: 900;
}

</style>
