<template>
    <admin-layout>
        <div> <h5 >ERP/Customer/{{customer.name}}</h5>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                        <div class=" invoice-print-area">
                            <div class="card-content">
                                <div class="card-body pb-2 mx-25 px-2">
                                    <div>

                                        <div class="row pr-0 ng-repeat-start pl-0">
                                            <div class="col-12 row pr-0 pl-0 ">
                                                <div class="col-lg-8 col-xl-8 col-md-8 col-sm-10 col-8 pl-0 ">
                                                    <div class="card">
                                                        <div class="card-header mb-n1">
                                                            <div class="row pl-0 col-12 pr-0">
                                                                <div class="col-lg-11 col-xl-11 col-md-10 col-sm-6 col-8 row" style="margin-left: 1px;">
                                                                    <i class='bx bx-list-ul font-weight-bold'> </i> <h6 class="font-weight-bold header text-dark"> Customer Details</h6>
                                                                </div>
                                                                  <div class="dropdown">
                                                                    <span
                                                                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer badge-circle badge-circle-light-secondary ml-auto "
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false" role="menu"
                                                                        data-boundary="window">
                                                                    </span>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" data-toggle="modal"  data-target="#contextinvoiceForm" @click="addivoiceContext" >
                                                                            <i class="bx bx-plus mr-1"
                                                                                data-whatever="@mdo"></i> Add Invoice
                                                                        </a>
                                                                         <a class="dropdown-item" data-toggle="modal"  data-target="#contextForm" @click="addContext">
                                                                            <i class="bx bx-plus mr-1"
                                                                                data-whatever="@mdo"></i> Add case
                                                                        </a>
                                                                         <a :href="route('customer.create.review',customer.id)" class="dropdown-item" 
                                                                            >
                                                                            <i class="bx bxs-star mr-1"
                                                                                data-whatever="@mdo"></i> Add Review
                                                                        </a>
                                                                         <a :href="route('customer.del',customer.id)" class="dropdown-item">
                                                                            <i class="bx bx-trash mr-1"
                                                                                data-whatever="@mdo"></i>Delete
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <!-- <div class="col-1 col-lg-1 col-xl-1 col-md-1 col-sm-1 pr-0">
                                                                            <span  aria-expanded="false"
                                                                                    class="collapse-icon clap"
                                                                                    data-toggle="collapse"
                                                                                    role="button">
                                                                            </span>
                                                                        <div class="d-inline-block col-md-2 col-4 custom-padding-right  ml-1">
                                                                        <div class="dropdow dropleft">
                                                                        <span id="dropdownMenuButton"
                                                                            aria-expanded="false" aria-haspopup="true"
                                                                            class="badge-circle circle-color-33 badge-circle-light-secondary threedots12"
                                                                            data-toggle="dropdown">
                                                                    <i class='bx bx-dots-vertical-rounded lg:font-bold font-size-bx'></i>
                                                                        </span>
                                                                            <div aria-labelledby="dropdownMenuButton" class="dropdown-menu">
                                                                                <div class="container">
                                                                                    <div class="row custom-popover popover-max">
                                                                                        <div class="col-12 p-0 m-0">
                                                                                            <div class="d-flex flex-column tooltip12 pt-1 pl-2">
                                                                                                <div class="d-flex mb-2 mt-n1">
                                                                                                    <a  class="bx bxl-invision pt-1 lg:font-bold float-right add-btn"
                                                                                                        data-toggle="modal" style="margin-right: 4px; color:#727E8C"
                                                                                                        data-target="#contextinvoiceForm" @click="addivoiceContext">
                                                                                                        <h6 class=" text-gray-500 small action-text addinvoice">Add
                                                                                                            Invoice</h6>
                                                                                                    </a>
                                                                                                </div>
                                                                                                <div class="d-flex caseadd">
                                                                                                    <a  class="bx bx-briefcase pt-1  lg:font-bold float-right add-btn mt-n2"
                                                                                                    style="color:#727E8C"
                                                                                                        data-toggle="modal"
                                                                                                        data-target="#contextForm" @click="addContext">
                                                                                                        <h6 id="delete_icon" class=" text-gray-500 small action-text addcase">Add case
                                                                                                        </h6>
                                                                                                    </a>
                                                                                                </div>
                                                                                                <div class="d-flex">
                                                                                                    <a :href="route('customer.create.review',customer.id)">
                                                                                                    <span
                                                                                                        class="badge-circle  circle-color">
                                                                                                        <i class="bx bxs-star lg:font-bold lg:font-bold float-right add-btn font-medium-1 star"></i>
                                                                                                    </span>
                                                                                                            <h6 id="delete_icon"
                                                                                                            class="small text-gray-500 action-text mb-0 addreview">Add Review</h6>
                                                                                                            </a>
                                                                                                </div>
                                                                                                
                                                                                                <div class="d-flex mt-1">
                                                                                                    <i class="bx bxs-file-doc"></i>
                                                                                                    <a  class=" pt-1  lg:font-bold float-right add-btn mt-n2"
                                                                                                        data-toggle="modal"
                                                                                                        data-target="#CustomerDocumnts" @click="CustomerDocumnts">
                                                                                                        <h6 id="delete_icon" class=" text-gray-500 small action-text addDoc">Add Docs
                                                                                                        </h6> 
                                                                                                    </a>
                                                                                                </div>
                                                                                                <hr class="mt-0 mb-1">
                                                                                                <div class="d-flex ">
                                                                                                    <a :href="route('customer.del',customer.id)">
                                                                                                    <span
                                                                                                        class="badge-circle  circle-color">
                                                                                                        <i class="bx bx-trash iconsize"></i>
                                                                                                    </span>
                                                                                                        <p id="delete_icon"
                                                                                                           class="small text-gray-500 action-text  deletcustomer">Delete</p>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                        </div>

                                                        <div class="card-content cardcontent">
                                                            <div class="row">
                                                                <i class='bx bx-user font-weight-bold'> </i> <h6 class="font-weight-bold header text-dark">Full Name:</h6>&nbsp;{{customer.name}}
                                                            </div>
                                                            <div v-if="customer.order.length>0">
                                                            <div class="row" v-if="customer.order?customer.order[0].billing_address_1_2:'' || customer.order[0].billing_address_1 || customer.order[0].billing_address_2">
                                                                <i class='bx bx-check font-weight-bold'> </i> <h6 class="font-weight-bold header text-dark">Billing Address:</h6>&nbsp;
                                                                <span v-for="order in customer.order">
                                                                     {{
                                                                        (order.billing_address_1_2 ? order.billing_address_1_2 : '') +
                                                                        (order.billing_address_1 ? order.billing_address_1 : '') +
                                                                        (order.billing_address_2 ? order.billing_address_2 : '') +
                                                                        (order.billing_city ? ", " +order.billing_city : '') +
                                                                        (order.billing_country ? ", " +order.billing_country : '') +
                                                                        (order.billing_postcode ? ", " +order.billing_postcode : '')
                                                                    }}
                                                                </span>
                                                            </div>
                                                            </div>
                                                            <div class="row">
                                                                <i class='bx bx-star font-weight-bold'> </i> <h6 class="font-weight-bold header text-dark">Shipping Address:</h6>&nbsp;
                                                                <span v-for="order in customer.order">{{
                                                                        (order.shipping_address_1 ? order.shipping_address_1 : '') +
                                                                        (order.shipping_address_2 ? order.shipping_address_2 : '') +
                                                                        (order.shipping_address_city ? ", " +order.shipping_address_city : '') +
                                                                        (order.shipping_address_county ? ", " +order.shipping_address_county : '') +
                                                                        (order.shipping_address_postcode ? ", " +order.shipping_address_postcode : '')
                                                                    }}</span>
                                                            </div>
                                                            <div class="row">
                                                                <i class='bx bx-flag font-weight-bold'> </i> <h6 class="font-weight-bold header text-dark">Country:</h6>&nbsp;{{customer.country}}
                                                            </div>
                                                        </div>

                                                        <div class="card-body mt-n2 ml-1">
                                                            <!-- <div class="text-muted ml-n1 mb-1">Contact</div> -->
                                                            <div class="row">
                                                                <i class='bx bx-phone font-weight-bold'> </i> <h6 class="font-weight-bold header text-dark"> Contact:</h6> {{customer.phone}}
                                                            </div>
                                                            <div class="row">
                                                                <i class='bx bx-envelope font-weight-bold'></i><h6 class="font-weight-bold header text-dark"> Email:</h6> {{customer.email}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-4 pl-0 pr-0">
                                                    <div class="card scroll">
                                                        <div class="card-header mb-n1">
                                                            <div class="row col-12 pl-0">
                                                                <div class="col-11 row" style="margin-left: 1px;">
                                                                    <i class='bx bx-list-ul font-weight-bold'></i><h6 class="font-weight-bold header text-dark">Activity Timeline</h6>
                                                                </div>

                                                                <div class="dropdown">
              <span
                class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer badge-circle badge-circle-light-secondary ml-auto "
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
              </span>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" data-toggle="modal" data-target="#additionModel">
                  <i class="bx bx-show mr-1" data-whatever="@mdo"></i> View All
                </a>
              </div>
            </div>

                                                                <!-- <div class="col-1">
                                                                    <span  aria-expanded="false"
                                                                            class="collapse-icon clap"
                                                                            data-toggle="collapse"
                                                                            role="button">
                                                                    </span>
                                                                    <div class="">
                                                                        <div class="dropdow dropleft">
                                                                            <span id="dropdownMenuButton"
                                                                                aria-expanded="false" aria-haspopup="true"
                                                                                class="badge-circle circle-color-33 badge-circle-light-secondary threedots12"
                                                                                data-toggle="dropdown">
                                                                                <i class='bx bx-dots-vertical-rounded lg:font-bold font-size-bx'></i>
                                                                         </span>
                                                                            <div aria-labelledby="dropdownMenuButton" class="dropdown-menu">
                                                                                <div class="container">
                                                                                    <div class="row custom-popover popover-max">
                                                                                        <div class="col-12 p-0 m-0">
                                                                                            <div class="d-flex flex-column tooltip12 px-1">
                                                                                                <div class="d-flex mt-1">
                                                                                                    <a class="view1">
                                                                                                        <i class="bx bx-show font-medium-1 align-items-center mx-1"> </i><h6 class="view" >View All</h6>
                                                                                                         </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                        </div>

                                                        <div class="card-content cardcontent12">
                                                <span  class="" v-for="order in customer.order">
                                                   <span v-for="item in  order.order_items" >
                                                       <span v-if="item.tracking_number">
                                                    <div class="row mt-1">
                                                        <!-- <input type="checkbox" class="tui-full-calendar-checkbox-round" value="6" data-v-cdcbb4f4=""> -->
                                                        <span class="color" style=" border-color: rgb(71, 95, 123);background-color: rgb(71, 95, 123);"></span>
                                                        <h6 class="font-weight-bold header">Item Status:</h6>
                                                   </div>
                                                        <span class="activity">Trace And Track:({{item.tracking_number}})</span>
                                                        </span>
                                                   </span>
                                                   <div class="row mt-1">
                                                       <span class="col-9 row">
                                                       <!-- <input type="checkbox" class="tui-full-calendar-checkbox-round" value="6" data-v-cdcbb4f4=""> -->
                                                         <span class="color" style="border-color: rgb(0, 207, 221); background-color: rgb(0, 207, 221);"></span>
                                                        <h6 class="font-weight-bold header">Delivery Schedule:</h6>
                                                       </span>

                                                       <span class="col-3 pr-0 ml-2">{{DateHumanFrinendly(delivery?delivery.updated_at:'')}}</span>
                                                   </div>
                                                    <span class="activity">Sent by Tufnells</span><br>
                                                    <div class="filetxt">
                                                     <a class="text-gray-500" :href="route('export.tuffnell.file', delivery.id)">
                                                    <i class="bx bxs-file"></i>
                                                         Tufnells TxT</a>
                                                     </div>
                                                        <div class="row mt-1">
                                                            <span class="col-9 row">
                                                        <!-- <input type="checkbox" class="tui-full-calendar-checkbox-round" value="3" checked=""/> -->
                                                            <span class="color" style="border-color: rgb(57, 218, 138);background-color: rgb(57, 218, 138);"></span>
                                                            <h6 class="font-weight-bold header">Order Imported:</h6>
                                                             </span>
                                                            <span class="col-3 pr-0 ml-2">{{DateHumanFrinendly(customer.import.created_at)}}</span>
                                                        </div>
                                                        <div class="filetxt">
                                                        <a class="text-gray-500" :href="route('export.import.files', customer.import_id)">
                                                        <i class="bx bxs-file"></i>
                                                            Imports.csv</a>
                                                     </div>
                                                     <div class="row mt-2">
                                                         <span class="col-9 row">
                                                        <!-- <input type="checkbox" class="tui-full-calendar-checkbox-round" value="3" checked=""/> -->
                                                            <span class="color" style="border-color: 	rgb(255, 0, 255);background-color:	rgb(255, 0, 255);"></span>
                                                            <h6 class="font-weight-bold header">Order Placed:</h6>
                                                            </span>
                                                            <span class="col-3 pr-0 ml-2">{{DateHumanFrinendly(order.order_date)}}</span>
                                                        </div>
                                                        <span class="filetxt">
                                                            {{order.product.name}}({{order.product.sku}})
                                                     </span>
                                                        <div v-if="order.case">
                                                     <div class="row mt-1">
                                                         <span class="col-9 row">
                                                        <!-- <input type="checkbox" class="tui-full-calendar-checkbox-round" value="3" checked=""/> -->
                                                            <span class="color" style="border-color:rgb(210, 45, 45);background-color:rgb(210, 45, 45);"></span>
                                                            <h6 class="font-weight-bold header">Case:</h6>
                                                            </span>
                                                            <span class="col-3 pr-0 ml-2">{{DateHumanFrinendly(order.case.created_at)}}</span>
                                                        </div>
                                                        <span class="filetxt">
                                                            {{order.case.case_number}}
                                                     </span>
                                                     <span class="filetxt"  v-for="document in  order.case.documents">
                                                           <a  :href="route('export.cases.document', document.id)">
                                                               <span class="row text-muted" style="margin-left: 10px;    margin-bottom: -25px;">
                                                               <i class="bx bxs-file"> </i> <p class="text-grey-500"> Case Documents</p>
                                                               </span>
                                                           </a>
                                                     </span>
                                                     </div>
                                                </span>
                                                            <span v-for="invoice in customer.invoice">
                                                     <div class="row mt-1">
                                                         <span class="col-9 row">
                                                        <!-- <input type="checkbox" class="tui-full-calendar-checkbox-round" value="3" checked=""/> -->
                                                            <span class="color" style="border-color: 	rgb(172, 83, 83);background-color:	rgb(172, 83, 83);"></span>
                                                            <h6 class="font-weight-bold header">Invoice:</h6>
                                                            </span>
                                                            <span class="col-3 pr-0 ml-2">{{DateHumanFrinendly(invoice.created_at)}}</span>
                                                        </div>
                                                        <span class="filetxt">
                                                            {{invoice.invoice_number}}
                                                     </span>
                                                     <span class="filetxt"  v-for="document in  invoice.documents">
                                                           <a  :href="route('customer.invoice.export' , document.id)">
                                                               <span class="row text-muted" style="margin-left: 10px;    margin-bottom: -25px;">
                                                               <i class="bx bxs-file"> </i> <p class="text-grey-500"> Invoice Documents</p>
                                                               </span>
                                                           </a>
                                                     </span>
                                                     <span v-for="payment in invoice.payments">
                                                         <div class="row mt-1">
                                                         <span class="col-9 row">
                                                        <!-- <input type="checkbox" class="tui-full-calendar-checkbox-round" value="3" checked=""/> -->
                                                            <span class="color" style="border-color: 	rgb(117, 114, 0) ;background-color:	rgb(117, 114, 0) ;"></span>
                                                            <h6 class="font-weight-bold header">Payments:</h6>
                                                            </span>
                                                            <span class="col-3 pr-0 ml-2">{{DateHumanFrinendly(payment.created_at)}}</span>
                                                        </div>
                                 ``                       <span class="filetxt">
                                                            {{payment.payment_reference}}
                                                     </span>
                                                     <span class="filetxt"  v-for="document in  payment.documents">
                                                           <a  :href="route('customer.invoice.export' , document.id)">
                                                               <span class="row text-muted" style="margin-left: 10px;    margin-bottom: -25px;">
                                                               <i class="bx bxs-file"> </i> <p class="text-grey-500">Payments Documents</p>
                                                               </span>
                                                           </a>
                                                     </span>
                                                     </span>
                                                </span>
                                                            <span v-if="emails.length>0">
                                                <span v-for="email in emails">
                                                     <div class="row mt-1">
                                                         <span class="col-9 row">
                                                        <input type="checkbox" class="tui-full-calendar-checkbox-round" value="3" checked=""/>
                                                            <span class="color" style="border-color: 	rgb(207, 170, 167);background-color:	rgb(207, 170, 167);"></span>
                                                            <h6 class="font-weight-bold header">Email:</h6>
                                                            </span>
                                                            <span class="col-3 pr-0 ml-2">{{DateHumanFrinendly(email.created_at)}}</span>
                                                        </div>
                                                        <span class="filetxt">
                                                            {{email.to_name}}
                                                     </span>
                                                </span>
                                                </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row" v-if="customer.order.length>0">
                                            <div class="row col-12 pr-0 ng-repeat-start pl-0" id="table-hover-row">
                                                <div class="col-12 pr-0 pl-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <h5 class="card-header border-bottom ">Order</h5>
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-left custom-padding">Order#</th>
                                                                        <th class="">Product</th>
                                                                        <th class="">Shipping Address</th>
                                                                        <th class="text-center">Order Status</th>
                                                                        <th class="text-center">Channel</th>
                                                                        <th class="">Order Date</th>
                                                                        <th class=""></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="truncate" >
                                                                    <tr  v-for="order in customer.order" >

                                                                        <td class=" py-0 my-0">
                                                                            {{order.order_number}}
                                                                        </td>
                                                                        <td class="">
                                                                            <span v-for="item in order.order_items">
                                                                                 <div class="row">
                                                                                     <div class="col-4 col-md-6 col-sm-6 pr-0 mr-0">
                                                                                    <img v-if="item.product.image !== null" :src="'/'+item.product.image"
                                                                                         class="rounded-circle product-image" width="45" height="40">
                                                                                    <img v-else src="products/empty.jpg" class="rounded-circle empty-image"
                                                                                         width="45" height="40">
                                                                                </div>
                                                                                <div class="col-5 py-1 px-0 mx-0">
                                                                                    {{ item.product? item.product.name : "" }}
                                                                                </div>
                                                                            </div>
                                                                            </span>
                                                                        </td>
                                                                        <td class=" py-0 my-0">
                                                                            {{
                                                                                (order.shipping_address_1 ? order.shipping_address_1 : '') +
                                                                                (order.shipping_address_2 ? ", " + order.shipping_address_2
                                                                                    : '') +
                                                                                (order.shipping_address_town ? ", " +
                                                                                    order.shipping_address_town : '') +
                                                                                (order.shipping_address_postcode ? ", " +
                                                                                    order.shipping_address_postcode : '') +
                                                                                (order.shipping_country ? ", " + order.shipping_country :
                                                                                    '')
                                                                            }}
                                                                        </td>
                                                                        <td class="text-center py-0 my-0">
                                                                            {{order.order_status}}
                                                                        </td>

                                                                        <td class="text-center">
                                                                        <span
                                                                            v-if="order.channel.name == 'Ejogga' || order.channel.name == 'Gogroopie' || order.channel.name == 'Groupon	' || order.channel.name == 'Wowcher' ||
                                                                        order.channel.name == 'Xstreamgym' || order.channel.name == 'Amazon'"
                                                                            class="badge badge-light-success badge-pill text-right ml-1">
                                                                        {{ order.channel ? order.channel.name : '' }}
                                                                            <!-- {{ order.order_status }} -->
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            {{formatDate(order.order_date)}}
                                                                        </td>
                                                                        <td class="text-right py-0 my-0">
                                                                        <span class="d-inline-flex align-items-center mr-n1">
                                                                        <inertia-link :href="route('customer.order.show',[customer.id ,order.id])">
                                                                        <span class="badge-circle badge-circle-light-secondary circle-color">
                                                                            <i class="bx bxs-show font-medium-1 align-items-center text-center"></i>
                                                                        </span>
                                                                        </inertia-link>
                                                                    </span>
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


                                        <div class="row mt1"  v-if="customer.invoice.length>0" >
                                            <div class="row col-12 pr-0 ng-repeat-start pl-0" id="table-hover-row" >
                                                <div class="col-12 pr-0 pl-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <h5 class="card-header border-bottom " data-v-26ed4daa="">Invoices</h5>
                                                        <div class="card-content">
                                                            <div class="table-responsive ">
                                                                <table class="table table-hover  mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-left custom-padding">Invoice #</th>
                                                                        <th class="">Reference</th>
                                                                        <th class="">Total</th>
                                                                        <th class="ml-1">Status</th>
                                                                        <th class="">Date</th>
                                                                        <th class="text-right custom-padding-right">
                                                                            <a  class="bx bx-plus float-right add-btn font-large123 mb-n1 plusicon"
                                                                                data-toggle="modal"
                                                                                data-target="#contextinvoiceForm" @click="addivoiceContext">
                                                                            </a>
                                                                            </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="truncate">
                                                                    <tr v-for="invoice in  customer.invoice">
                                                                        <td class="custom-padding">
                                                                            {{invoice.invoice_number}}
                                                                        </td>
                                                                        <td class=" py-0 my-0">
                                                                            {{invoice.reference_number?invoice.reference_number:''}}
                                                                        </td>
                                                                        <td class=" py-0 my-0">
                                                                            {{invoice.total}}
                                                                        </td>
                                                                        <td class="">
                                                                            <span v-if="invoice.status == 'un_paid'"
                                                                                  class="badge badge-light-danger badge-pill ml-n1">{{
                                                                                    invoice.statuss ? invoice.statuss.value:''
                                                                                }}</span>
                                                                            <span v-else
                                                                                  class="badge badge-light-success badge-pill ">{{ invoice.status }}</span>
                                                                        </td>
                                                                        <td class=" py-0 my-0">
                                                                            {{formatDate(invoice.invoice_date)}}
                                                                        </td>
                                                                        <td class="text-right py-0 my-0" >


                                                                            <div class="dropdown">
                                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                                </span>
                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                <a :href="route('customer.invoice.edit', [customer.id ,invoice.id])" class="dropdown-item" ><i class="bx bx-show mr-1"></i>Show Invoice</a>
                                                                                <a :href="route('customer.invoice.del',[customer.id ,invoice.id])" class="dropdown-item"><i class="bx bx-trash mr-1"></i>Delete Invoice</a>
                                                                                <div class="d-flex" v-for="document in  invoice.documents">
                                                                                <a :href="route('customer.invoice.export' , document.id)" class="dropdown-item"><i class="bx bx-download mr-1"></i>Download Invoice</a>
                                                                                </div>
                                                                                <a :href="route('customer.payments.create', [customer.id,invoice.id])"  class="dropdown-item"><i class="bx bx-plus mr-1"></i>Add Payment</a>
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
                                                                            <!-- <div class="d-inline-block col-md-2 col-4 custom-padding-right" style="z-index:2">
                                                                                <div class="dropdownz dropleft">
                                                                            <span id="dropdownMenuButton"
                                                                                  aria-expanded="false" aria-haspopup="true"
                                                                                  class="badge-circle badge-circle-light-secondary circle-color ml-auto"
                                                                                  data-toggle="dropdown" data-boundary="window">
                                                                            <i class='bx bx-dots-vertical-rounded lg:font-bold font-size-bx'></i>
                                                                            </span>
                                                                                    <div aria-labelledby="dropdownMenuButton" class="dropdown-menu">
                                                                                        <div class="container">
                                                                                            <div class="row custom-popover popover-max">
                                                                                                <div class="col-12 p-0 m-0">
                                                                                                    <div class="d-flex flex-column">
                                                                                                        <div class="d-flex ">
                                                                                                            <inertia-link
                                                                                                                :href="route('customer.invoice.edit', [customer.id ,invoice.id])">
                                                                                                    <span
                                                                                                        class="badge-circle  circle-color action ">
                                                                                                        <i class="bx bx-show font-medium-1 align-items-center mx-1"></i>
                                                                                                    </span>
                                                                                                            </inertia-link>
                                                                                                            <p class=" ml-1 small action-text mt-1 ">Show
                                                                                                                Invoice</p>
                                                                                                        </div>
                                                                                                        <div class="d-flex">
                                                                                                            <a :href="route('customer.invoice.del',[customer.id ,invoice.id])">
                                                                                                    <span
                                                                                                        class="badge-circle  circle-color">
                                                                                                        <i class="bx bx-trash font-medium-1 align-items-center mx-1"></i>
                                                                                                    </span>
                                                                                                            </a>
                                                                                                            <p id="delete_icon"
                                                                                                               class="ml-1 small action-text mb-0">Delete
                                                                                                                Invoice</p>
                                                                                                        </div>
                                                                                                        <div class="d-flex mt-1 " v-for="document in  invoice.documents">
                                                                                                            <a :href="route('customer.invoice.export' , document.id)">
                                                                                                    <span
                                                                                                        class="badge-circle  circle-color">
                                                                                                        <i class="bx bx-download font-medium-1 align-items-center mx-1"></i>
                                                                                                    </span>
                                                                                                            </a>
                                                                                                            <p id="delete_icon"
                                                                                                               class="ml-1 small action-text mb-0">Download
                                                                                                                Invoice</p>
                                                                                                        </div>
                                                                                                        <div class="d-flex mb-1 mt-1">
                                                                                                            <inertia-link :href="route('customer.payments.create', [customer.id,invoice.id])">
                                                                                                            <span
                                                                                                                class="badge-circle circle-color bg-white">
                                                                                                                <i class="bx bx-plus pt-0 float-right add-btn font-large12"></i>
                                                                                                            </span>
                                                                                                            </inertia-link>
                                                                                                            <p class="ml-1 small action-text mb-0">Add
                                                                                                                Payment</p>
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
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="customer.invoice.length>0">
                                          <div class="row mt1" >
                                            <div class="pr-0 row col-12 ng-repeat-start pl-0" id="table-hover-row" >
                                                <div class="col-12 pl-0 pr-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <h5 class="card-header border-bottom " data-v-26ed4daa="">Payments</h5>
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-left custom-padding">Reference</th>
                                                                        <th class="">Amount</th>
                                                                        <th class="">Total</th>
                                                                        <th class="">Date</th>
                                                                        <th></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="truncate" v-for="invoice in customer.invoice">
                                                                    <tr v-for="payment in invoice.payments">
                                                                         <td class=" py-0 my-0">
                                                                          {{payment.payment_reference}}
                                                                        </td>
                                                                        <td class=" py-0 my-0">
                                                                          {{payment.amount?payment.amount:''}}
                                                                        </td>
                                                                        <td class=" py-0 my-0">
                                                                          {{payment.payee_total}}
                                                                        </td>
                                                                        <td class="custom-padding">
                                                                            {{formatDate(payment.payment_date)}}
                                                                        </td>
                                                                     <td class="text-right py-0 my-0"  >

                                                                        <div class="dropdown">
                                                                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                        </span>
                                                                        <div class="dropdown-menu dropdown-menu-right" >
                                                                        <a :href="route('customer.payments.edit',[customer.id  , invoice.id ,payment.id])"  class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit Payment</a>
                                                                        <div class="d-flex mt-n1" v-for="document in payment.documents">
                                                                        <a :href="route('customer.invoice.export', document.id)" class="dropdown-item" ><i class="bx bx-download mr-1"></i>Download Payment</a>
                                                                    </div>
                                                                        <a  :href="route('payments.delete' , payment.id)" class="dropdown-item" ><i class="bx bx-trash mr-1"></i>Delete</a>
                                                                        </div>
                                                                        </div>
                                                                            <!-- <div class="d-inline-block col-md-2  col-4 custom-padding-right ">
                                                                            <div class="dropdown dropleft">

                                                                                <span id="dropdownMenuButton"
                                                                                      aria-expanded="false" aria-haspopup="true"
                                                                                      class="badge-circle badge-circle-light-secondary circle-color ml-auto "
                                                                                      data-toggle="dropdown">
                                                                                    <i class='bx bx-dots-vertical-rounded lg:font-bold font-size-bx'></i>
                                                                                    </span>
                                                                                        <div aria-labelledby="dropdownMenuButton" class="dropdown-menu ">
                                                                                            <div class="container">
                                                                                                <div class="row custom-popover popover-max">
                                                                                                    <div class="col-12 p-0 m-0">
                                                                                                        <div class="d-flex flex-column mt-n1">
                                                                                                            <div class="d-flex ">
                                                                                                                <a
                                                                                                                    :href="route('customer.payments.edit',[customer.id  , invoice.id ,payment.id])">
                                                                                                        <span
                                                                                                            class="badge-circle circle-color action ">
                                                                                                            <i class="bx bx-edit font-medium-1 align-items-center mx-1"></i>
                                                                                                        </span>
                                                                                                                </a>
                                                                                                                <p class=" small action-text mt-1 ">Edit
                                                                                                                    Payment</p>
                                                                                                            </div>
                                                                                                            <div class="d-flex mt-n1" v-for="document in payment.documents">
                                                                                                                <a
                                                                                                                    :href="route('customer.invoice.export', document.id)">
                                                                                                        <span
                                                                                                            class="badge-circle circle-color action ">
                                                                                                            <i class="bx bx-download font-medium-1 align-items-center mx-1"></i>
                                                                                                        </span>
                                                                                                                </a>
                                                                                                                <p class=" small action-text mt-1 " style="margin-left: -2px;">Download
                                                                                                                    Payment</p>
                                                                                                            </div>
                                                                                                            <div class="d-flex d-flex-payment">    
                                                                                                                <a :href="route('payments.delete' , payment.id)"> 
                                                                                                        <span
                                                                                                            class="badge-circle circle-color">
                                                                                                            <i class="bx bx-trash font-medium-1 align-items-center mx-1" style="margin-top: 12px;"></i>
                                                                                                        </span>
                                                                                                        </a>
                                                                                                                <p id="delete_icon"
                                                                                                                   class=" small action-text mb-0" style="margin-top: 14px;">Delete
                                                                                                                    Payment</p>
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
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt1"  v-if="customer.order?customer.order[0].case:''" >
                                            <div class="row col-12 pr-0 ng-repeat-start pl-0" id="table-hover-row">
                                                <div class="col-12 pr-0 pl-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <h5 class="card-header border-bottom ">Cases</h5>
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="">channel</th>
                                                                        <th class="">Type</th>
                                                                        <th class="">priority</th>
                                                                        <th class="">status</th>
                                                                        <th class="">
                                                                            <a  class="bx bx-plus pt-1 secondary-light float-right add-btn font-large12 mb-n1 plusicon1"
                                                                                data-toggle="modal"
                                                                                data-target="#contextForm" @click="addContext">
                                                                            </a></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr v-for="order in customer.order" >
                                                                        <td class="text-truncate" >
                                                                            {{order.channel?order.channel.name:''}}
                                                                        </td>
                                                                        <td class="text-truncate">{{order.case?order.case.type:'' }}</td>
                                                                        <td class="text-truncate">{{order.case?order.case.priority:'' }}</td>
                                                                        <td class="text-truncate">{{order.case?order.case.status: ''}}</td>
                                                                        <td class="text-right py-0 my-0 ">
                                                                            <span aria-expanded="false"
                                                                                  class="collapse-icon clap"
                                                                                  data-toggle="collapse"
                                                                                  role="button"
                                                                                  v-bind:data-target='"#collapse1"+ order.case?order.case.id:""'
                                                                                  v-on:click="rotateIcon(order.case.id)">

                                                                            </span>
                                                                            <div class="d-inline-block col-md-2 col-4 custom-padding-right ">
                                                                                <div class="dropdow dropleft">
                                                                            <span id="dropdownMenuButton"
                                                                                  aria-expanded="false" aria-haspopup="true"
                                                                                  class="badge-circle badge-circle-light-secondary circle-color mr-n1"
                                                                                  data-toggle="dropdown">
                                                                            <i class='bx bx-dots-vertical-rounded lg:font-bold font-size-bx'></i>
                                                                            </span>
                                                                                    <div aria-labelledby="dropdownMenuButton" class="dropdown-menu">
                                                                                        <div class="container">
                                                                                            <div class="row custom-popover popover-max">
                                                                                                <div class="col-12 p-0 m-0">
                                                                                                    <div class="d-flex flex-column  mt-n1">
                                                                                                        <div class="d-flex mb-n1">
                                                                                                            <inertia-link
                                                                                                                :href="route('customer.case.show', [customer.id , order.case.id])">
                                                                                                    <span
                                                                                                        class="badge-circle badge-circle-light-secondary circle-color action ">
                                                                                                        <i class="bx bx-show font-medium-1 align-items-center mx-1"></i>
                                                                                                    </span>
                                                                                                            </inertia-link>
                                                                                                            <p class=" ml-1 small action-text mt-1 ">Show
                                                                                                                Case</p>
                                                                                                        </div>
                                                                                                        <div class="d-flex payment-download" v-for="document in order.case.documents">
                                                                                                            <a
                                                                                                                :href="route('export.cases.document', document.id)">
                                                                                                    <span
                                                                                                        class="badge-circle badge-circle-light-secondary circle-color action ">
                                                                                                        <i class="bx bx-download font-medium-1 align-items-center mx-1"></i>
                                                                                                    </span>
                                                                                                            </a>
                                                                                                            <p class="small action-text mt-1 ">Download
                                                                                                                Case</p>
                                                                                                        </div>
                                                                                                        <div class="d-flex mt-1">
                                                                                                            <a :href="route('customer.case.del', order.case.id)">
                                                                                                    <span
                                                                                                        class="badge-circle badge-circle-light-secondary circle-color">
                                                                                                        <i class="bx bx-trash font-medium-1 align-items-center mx-1"></i>
                                                                                                    </span>
                                                                                                            </a>
                                                                                                            <p id="delete_icon"
                                                                                                               class="ml-1 small action-text mb-0">Delete
                                                                                                                Case</p>
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
                                            </div>
                                        </div>

                                        <div class="row mt1" v-if="customer.reviews.length>0" >
                                            <div class="row col-12 pr-0 ng-repeat-start pl-0" id="table-hover-row">
                                                <div class="col-12 pr-0 pl-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <h5 class="card-header border-bottom ">Reviews</h5>
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-left custom-padding">Product#</th>
                                                                        <th class="text-center">Comment</th>
                                                                        <th class="text-center">Rating</th>
                                                                        <th class="text-center">Status</th>
                                                                        <th class="text-right custom-padding-right">
                                                                            <a  class="bx  bx-plus float-right add-btn font-large123 mb-n1 plusicon text-gray-500"
                                                                                :href="route('customer.create.review',customer.id)">
                                                                            </a></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="truncate" >
                                                                    <tr  v-for="review in customer.reviews" >
                                                                        <td class="text-truncate text-left">
                                                                            {{review.products.name}}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{review.comment}}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{review.rating}}
                                                                        </td>
                                                                        <td class="text-center py-0 my-0">
                                                                        <span v-if="review.status === 'review_approved'"
                                                                              class="badge badge-light-success badge-pill"
                                                                        >Approved</span>
                                                                            <span v-else class="badge badge-light-danger badge-pill"
                                                                            >Unapproved</span></td>

                                                                        <td class=" text-right py-0 my-0">

                                                                             <span  aria-expanded="false"
                                                                                    class="collapse-icon clap"
                                                                                    data-toggle="collapse"
                                                                                    role="button">
                                                                            </span>
                                                                            <div class="d-inline-block col-md-2 col-4 custom-padding-right" style="z-index:2">
                                                                                <div class="dropdownz dropleft">
                                                                            <span id="dropdownMenuButton"
                                                                                  aria-expanded="false" aria-haspopup="true"
                                                                                  class="badge-circle badge-circle-light-secondary circle-color ml-auto"
                                                                                  data-toggle="dropdown">
                                                                            <i class='bx bx-dots-vertical-rounded lg:font-bold font-size-bx'></i>
                                                                            </span>
                                                                                    <div aria-labelledby="dropdownMenuButton" class="dropdown-menu">
                                                                                        <div class="container">
                                                                                            <div class="row custom-popover popover-max">
                                                                                                <div class="col-12 p-0 m-0">
                                                                                                    <div class="d-flex flex-column mt-n1">
                                                                                                        <div class="d-flex ">
                                                                                                            <a :href="route('customer.reviews.view',[customer.id , review.id])">
                                                                                                        <span class="badge-circle badge-circle-light-secondary circle-color " style="margin-top: 8px;">
                                                                                                            <i class="bx bxs-show font-medium-1 align-items-center text-center"></i>
                                                                                                        </span>
                                                                                                            </a>
                                                                                                            <p class=" ml-1 small action-text mt-1 ">Show
                                                                                                                Review</p>
                                                                                                        </div>
                                                                                                        <div class="d-flex">
                                                                                                            <a :href="route('customer.reviews.edit' ,[customer.id , review.id] )">
                                                                                                            <span class="badge-circle badge-circle-light-secondary circle-color">
                                                                                                                <i class="bx bxs-edit font-medium-1 align-items-center text-center"></i>
                                                                                                            </span>
                                                                                                            </a>
                                                                                                            <p id="delete_icon"
                                                                                                               class="ml-1 small action-text mb-0">Edit Review</p>
                                                                                                        </div>
                                                                                                        <div class="d-flex mt-1 ">
                                                                                                            <a :href="route('customer.reviews.delete',[customer.id , review.id])">
                                                                                                        <span class="badge-circle badge-circle-light-secondary circle-color">
                                                                                                            <i class="bx bxs-trash font-medium-1 align-items-center text-center"></i>
                                                                                                        </span>
                                                                                                            </a>
                                                                                                            <p id="delete_icon"
                                                                                                               class="ml-1 small action-text mb-0">Delete Review</p>
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
                                            </div>
                                        </div>



                                        <div v-if="customer.order.length>0">
                                            <div class="row mt1" v-if="customer.order[0]?customer.order[0].case:''">
                                                <div class="col-12 pl-0 pr-0" v-if="customer.order[0]?customer.order[0].case.notes.length>0:''">
                                                    <div class=" row col-12 pr-0 pl-0 ng-repeat-start" id="table-hover-row" >
                                                        <div class="col-12 pl-0 pr-0">
                                                            <div class="card pr-0 pb-0 mb-1">
                                                                <h5 class="card-header border-bottom " data-v-26ed4daa="">Notes</h5>
                                                                <div class="card-content">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover truncate mb-0">
                                                                            <thead>
                                                                            <tr>
                                                                                <th class="text-left custom-padding">Comment</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody  class="truncate" v-for="order in customer.order">
                                                                            <tr v-for="note in order.case.notes" >
                                                                                <td class="custom-padding">
                                                                                    {{note.comment}}
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
                                        </div>


                                        <div v-if="customer.invoice.length>0">
                                            <div class="row mt1" v-if="customer.invoice[0].payments.length>0">
                                                <div class="col-12  pl-0 pr-0" v-if="customer.invoice[0].payments[0].documents.length>0">
                                                    <div class=" row col-12 pr-0 pl-0 ng-repeat-start" id="table-hover-row" >
                                                        <div class="col-12 pl-0 pr-0">
                                                            <div class="card pr-0 pb-0 mb-1">
                                                                <h5 class="card-header border-bottom " data-v-26ed4daa="">Documents</h5>
                                                                <div class="card-content">
                                                                    <div class="row col-12 ml-0 mt-1 mb-1 border-bottom">
                                                                        <div class="col-2 mb-1 font-weight-bolder fontsize">TITLE</div>
                                                                        <div class="col-4 mb-1 font-weight-bolder fontsize">FILE</div>
                                                                        <div class="col-4 mb-1 font-weight-bolder fontsize">DESCRIPTION</div>
                                                                        <div class="col-1 mb-1 font-weight-bolder fontsize">TYPE</div>
                                                                        <div class="col-1 mb-1 font-weight-bolder fontsize"></div>
                                                                    </div>
                                                                        
                                                                        <div class="row col-12 ml-0 mt-1 mb-1 border-bottom" v-for="document in customer.documents">
                                                                            <div class="col-2">{{document.title}}</div>
                                                                            <div class="col-4">{{document.description}}</div>
                                                                            <div class="col-4">{{document.file.substring(18)}}</div>
                                                                            <div class="col-1">Customer</div>
                                                                            
                                                                            <div class="col-1 text-right ml-n1">
                                                                                    <span aria-expanded="false"
                                                                                class="collapse-icon clap"
                                                                                data-toggle="collapse"
                                                                                role="button">
                                                                            </span>
                                                                            <div class="d-inline-block col-md-2 col-4 custom-padding-right ">
                                                                                <div class="dropdow dropleft">
                                                                            <span id="dropdownMenuButton"
                                                                                aria-expanded="false" aria-haspopup="true"
                                                                                class="badge-circle badge-circle-light-secondary circle-color mr-n1"
                                                                                data-toggle="dropdown">
                                                                            <i class='bx bx-dots-vertical-rounded lg:font-bold font-size-bx'></i>
                                                                            </span>
                                                                                    <div aria-labelledby="dropdownMenuButton" class="dropdown-menu">
                                                                                        <div class="container">
                                                                                            <div class="row custom-popover popover-max">
                                                                                                <div class="col-12 p-0 m-0">
                                                                                                    <div class="d-flex flex-column">
                                                                                                        <div class="d-flex mb-0">
                                                                                                            <a
                                                                                                               :href="route('customer.document.export', document.id)">
                                                                                                        <i class="bx bx-download font-medium-1 align-items-center mx-1"></i>
                                                                                                           <p class="text-gray-500 text-setting">Download</p> 
                                                                                                            </a>
                                                                                                        </div>
                                                                                                        <div class="d-flex mb-n1">
                                                                                                            <a :href="route('customer.document.delete', document.id)">
                                                                                                        <i class="bx bx-trash font-medium-1 align-items-center mx-1"></i>
                                                                                                            <p class="text-gray-500 text-setting">Delete</p>
                                                                                                            </a>
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

                                                                        <span  v-for="invoice in customer.invoice">
                                                                            <div class="row col-12 ml-0 mt-1 mb-1 border-bottom" v-for="document in invoice.documents">
                                                                                <div class="col-2">{{document.title}}</div>
                                                                                <div class="col-4">{{document.description}}</div>
                                                                                <div class="col-4">{{document.file.substring(18)}}</div>
                                                                                <div class="col-1">Invoice</div>
                                                                                
                                                                                <div class="col-1">
                                                                                     <a :href="route('customer.invoice.export' , document.id)">
                                                                                        <span
                                                                                        class="badge-circle badge-circle-light-secondary circle-color ml-5 ">
                                                                                        <i class="bx bx-download font-medium-1 align-items-center mx-1"></i>
                                                                                         </span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </span>

                                                                            <span v-for="invoice in customer.invoice">
                                                                              <span  v-for="payment in invoice.payments">
                                                                                <div class="row col-12 ml-0 mt-1 mb-1 border-bottom" v-for="document in payment.documents">
                                                                                    <div class="col-2">{{document.title}}</div>
                                                                                    <div class="col-4">{{document.description}}</div>
                                                                                    <div class="col-4">{{document.file.substring(18)}}</div>
                                                                                    <div class="col-1">Payments</div>
                                                                                    
                                                                                    <div class="col-1">
                                                                                        <a :href="route('export.payment.file',[payment.id, document.id])">
                                                                                        <span
                                                                                            class="badge-circle badge-circle-light-secondary circle-color ml-5 ">
                                                                                            <i class="bx bx-download font-medium-1 align-items-center mx-1"></i>
                                                                                        </span>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </span>
                                                                        </span>

                                                                           <span  class="truncate" v-for="order in customer.order">
                                                                            <div class="row col-12 ml-0 mt-1 mb-1 border-bottom"  v-for="document in order.case.documents" >
                                                                                <div class="col-2">{{document.title}}</div>
                                                                                <div class="col-4">{{document.description}}</div>
                                                                                <div class="col-4">{{document.file.substring(22)}}</div>
                                                                                <div class="col-1">Case</div>
                                                                                
                                                                                <div class="col-1">
                                                                                        <a
                                                                                            :href="route('export.cases.document' , document.id)">
                                                                            <span
                                                                                class="badge-circle badge-circle-light-secondary circle-color ml-5 ">
                                                                                <i class="bx bx-download font-medium-1 align-items-center mx-1"></i>
                                                                            </span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                         </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt1">
                                            <div class="row col-12 pr-0 ng-repeat-start pl-0" v-if="emails.length>0" >
                                                <div class="col-12 pr-0 pl-0">
                                                    <div class="card mb-0">
                                                        <div class="card-body email-card mt-n2 ">
                                                            <!-- <div class="card-header ml-n2 mb-n1 font-weight-bold text-dark">Email</div> -->
                                                            <h5 class="card-header border-bottom ml-n2 mb-n1" data-v-26ed4daa="">Email</h5>
                                                            <div class="row">
                                                                <div class="col-12 px-0 pr-2">
                                                                    <div class="collapsible  email-detail-head" id="collapsible">
                                                                        <div class="card collapse-header ml-1 "
                                                                             @click="changeStatus($event)"
                                                                             role="tablist"
                                                                             v-for="email in emails">
                                                                            <div id="headingCollapse5"
                                                                                 class="px-1 pt-0 pb-0 card-header d-flex justify-content-between align-items-center border-0"
                                                                                 data-toggle="collapse" role="tab"
                                                                                 v-bind:data-target='"#collapse6" + email.id'
                                                                                 aria-expanded="false" aria-controls="collapse5">
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
                                                                            <div v-bind:id='"collapse6" +email.id' role="tabpanel"
                                                                                 aria-labelledby="headingCollapse5"
                                                                                 class="collapse">
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
                                                                                                    <button type="button" title="Reply">
                                                                                                        <svg class="d-inline-block mr-1"
                                                                                                             data-toggle="collapse"
                                                                                                             data-target="#collapseReply"
                                                                                                             aria-expanded="false"
                                                                                                             aria-controls="collapseReply"
                                                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                                                             width="20" height="20"
                                                                                                             viewBox="0 0 24 24"
                                                                                                             style="fill: #CACACA;transform: ;msFilter:;">
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
                                                                                                    class="d-inline-flex align-items-center ">
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
                                                                                            <div class="col-12 px-0 collapse"
                                                                                                 id="collapseReply">
                                                                                                <EmailForm :email="email"></EmailForm>
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
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                                                           @deleteitem="deleteItem">
                                        </ConfirmatiomModal>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div id="CustomerDocumnts"
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
                        <form @submit.prevent="submitdocument"
                              class="form form-horizontal">

                            <li v-for="errorse in errorses" class="error mt-1">{{ errorse }}</li>
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
                                              name="description" placeholder="Textarea"
                                              rows="2"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" id="" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"
                                       ref="closeModall"></i>
                                    <span
                                        class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit"
                                        @click="stopPropagation"
                                        class="btn btn-primary ml-1"
                                        data-dismiss="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span
                                        class="d-none d-sm-block">Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade text-left"
                 id="addContext" tabindex="-1"
                 role="dialog"
                 aria-labelledby="myModalLabel33"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <h5 class="modal-title font-weight-bold heading" id="exampleModalLongTitle">Add Case</h5>
                        <button type="button" class="close close12" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h6 class="modal-title text-muted" id="addContext" style="margin-left: 176px;">Adding Case of an Order</h6>
                        <form @submit.prevent="submit" class="form form-horizontal">
                            <div class="modal-body">
                                <div class=" row">
                                    <div class="col-6">
                                        <label>Order *</label>
                                        <select class="form-select" id="order_id"
                                                name="order_id"
                                                v-model="form.order_id">
                                            <option value="" disabled></option>
                                            <option v-for="order in customer.order" :value="order.id">{{ order.order_number }}</option>
                                        </select>
                                        <ErrorComponent input="order_id"></ErrorComponent>
                                    </div>
                                    <div class="col-6 mt-n1">
                                        <div class="form-group pt-1 my-0">
                                            <label>Source*</label>
                                            <select class="form-select" id="source"
                                                    @change="otherSource"
                                                    name="source"
                                                    v-model="form.source">
                                                <option value="" disabled></option>
                                                <option v-for="source in sources" :value="source.value">{{ source.value }}</option>
                                            </select>
                                            <ErrorComponent input="source"></ErrorComponent>
                                            <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                                                <div class="form-group pt-1 my-0" v-if="sourceField">
                                                    <label for="order-number">Other's</label>
                                                    <input type="text" v-model="form.source_other"
                                                            id="source_other"
                                                            class="form-control"
                                                            name="source_other">
                                                </div>
                                                <ErrorComponent input="source_other"></ErrorComponent>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label>Type *</label>
                                <select class="form-select" id="type"
                                        name="type"
                                        v-model="form.type">
                                    <option value="" disabled></option>
                                    <option v-for="case_type in case_types" :value="case_type.value">{{ case_type.value }}</option>
                                </select>
                                <ErrorComponent input="type"></ErrorComponent>
                                <div class="row ">
                                    <div class="col-6">
                                        <label>	Priority *</label>
                                        <select id="priority" name="priority"
                                                v-model="form.priority"
                                                class="form-select">
                                            <option value="" disabled></option>
                                            <option v-for="prioritys in priorities" :value="prioritys.value">{{ prioritys.value }}</option>
                                        </select>
                                        <ErrorComponent input="priority"></ErrorComponent>
                                    </div>
                                    <div class="col-6">
                                        <label>Status *</label>
                                        <select class="form-select" id="case_status"
                                                name="case_status"
                                                v-model="form.status">
                                            <option value=""></option>
                                            <option v-for="status in case_statuses" :value="status.value">{{ status.value }}</option>
                                        </select>
                                        <ErrorComponent input="status"></ErrorComponent>
                                    </div>
                                </div>
                                <label>Note *</label>
                                <div class="form-group">
                                    <textarea name="note" v-model="form.note" type="text" class="form-control"></textarea>
                                    <ErrorComponent input="note"></ErrorComponent>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" id="" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none" ref="closeModall"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit"
                                        @click="stopPropagation"
                                        class="btn btn-primary ml-1"
                                        data-dismiss="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade text-left"
                 id="addContextinvoice" tabindex="-1"
                 role="dialog"
                 aria-labelledby="myModalLabel33"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <h4 class="modal-title font-weight-bold heading"
                            id="myModalLabel33">
                            Add Invoice </h4>
                        <button type="button"
                                class="close close12"
                                data-dismiss="modal"
                                aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                        <h6 class="text-muted" style="margin-left: 176px;">Add Invoice of the customer</h6>
                        <form @submit.prevent="submitinvoice" class="form form-horizontal">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label>	Supplier *</label>
                                        <select v-model="form1.supplier_id" class="form-select"
                                                name="supplier_id">
                                            <option value=""></option>
                                            <option v-for="supplier in suppliers" :value="supplier.id">
                                                {{ supplier.channel.name }}
                                            </option>
                                        </select>
                                        <ErrorComponent input="supplier_id"></ErrorComponent>
                                        <br>
                                    </div>
                                    <div class="col-6">
                                        <label>Order *</label>
                                        <select v-model="form1.order_id" class="form-select"
                                                name="order_id">
                                            <option value=""></option>
                                            <option v-for="order in customer.order" :value="order.id">
                                                {{ order.order_number }}
                                            </option>
                                        </select>
                                        <ErrorComponent input="order_id"></ErrorComponent>
                                        <br>
                                    </div>
                                </div>
                                <label>Invoice# *</label>
                                <input id="invoice_number" v-model="form1.invoice_number"
                                       class="form-control"
                                       name="invoice_number"
                                       type="text">
                                <ErrorComponent input="invoice_number"></ErrorComponent>
                                <br>
                                <label>Reference *</label>
                                <input id="invoice_number" v-model="form1.reference_number"
                                       class="form-control"
                                       name="invoice_number"
                                       type="text">
                                <ErrorComponent input="invoice_number"></ErrorComponent>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Date *</label>
                                        <input name="date" v-model="form1.date" type="date" class="form-control">
                                        <ErrorComponent input="date"></ErrorComponent>
                                        <br>
                                    </div>
                                    <div class="col-6">
                                        <label>Currency *</label>
                                        <select v-model="form1.currency" class="form-select"
                                                name="payer_currency_id" @change="getExchangeRate()">
                                            <option value=""></option>
                                            <option v-for="currency in currencys"
                                                    :value="currency.slug">
                                                {{ currency.value}}
                                            </option>
                                        </select>
                                        <ErrorComponent input="currency"></ErrorComponent>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" id="" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"
                                       ref="closeModall"></i>
                                    <span
                                        class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit"
                                        @click="stopPropagation"
                                        class="btn btn-primary ml-1"
                                        data-dismiss="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span
                                        class="d-none d-sm-block">Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import moment from 'moment';
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import {useForm} from '@inertiajs/inertia-vue3';
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import Label from "../../Jetstream/Label";
import JetInputError from "../../Jetstream/InputError";
import ErrorComponent from '../../components/ErrorComponent';

export default {

    name: "show",
    props: ['customer' ,'documents' , 'sources' , 'priorities' ,'case_types' ,
        'case_statuses' , 'emails' , 'products' ,'shipments' ,'delivery',
        'statuses', 'currencys' ,'suppliers' ,'paymentDocuments' ,
        'invoicedoucments' ,
    ],
    components: {
        Button,
        AdminLayout,
        Pagination,
        JetInputError,
        ErrorComponent,
        ConfirmatiomModal,
    },
    setup() {
        const form = useForm({
            order_id: '',
            status: '',
            priority: '',
            type: '',
            note:'',
            source:'',
            source_other:'',
            customer_id:''

        });
        const form1 = useForm({
            supplier_id:'',
            order_id:'',
            invoice_number:'',
            reference_number:'',
            date:'',
            currency:'',
            conversion_rate:'',
            customer_id:''

        });
        const form2 = useForm({
            title:'',
            file:'',
            description:'',
            customer_id:''

        });
        return {form}
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
            form1: this.$inertia.form({
                supplier_id:'',
                invoiceable_id:'',
                invoice_number:'',
                reference_number:'',
                date:'',
                currency:'',
                conversion_rate:'',
                customer_id:''
            }),
            form2: this.$inertia.form({
                title:'',
                file:'',
                description:'',
                customer_id:''
            }),
            sweetAlert: false,
            itemId: '',
            searchItem: false
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Customer Show";
        console.log(this.customer);
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
        formatDate(date) {
            return moment(String(date)).format('DD/MM/YYYY')
        },
        DateHumanFrinendly(date) {
            return moment(String(date)).fromNow()
        },
        // currency(value){
        //     alert('fgfdg');
        //     this.currencys.forEach(myFunction);
        //     function myFunction(value) {
        //      console.log(currencys.value , 'fgdfgfd'); 
        //     }            
        // },
        chennalEmail() {
            this.$inertia.visit(route('fetch-email.create'), {
                method: 'get',
                data: {
                    // email: this.cases.emails[0].from_email,
                    // case_id: this.cases.id
                }
            })
        },
        submit() {
            if (this.update) {

            } else {
                this.form.customer_id = this.customer.id
                this.form.post(route('customer.case.store', this.customer.id), {
                    onSuccess:() => $('#addContext').modal('hide'),
                });
            }
        },
        submitinvoice() {
            if (this.update) {

            } else {
                this.form1.customer_id = this.customer.id
                this.form1.post(route('invoice.store' , this.customer.id), {
                    onSuccess:() => $('#addContextinvoice').modal('hide'),
                });
            }
        },
        submitdocument(){
            if (this.update) {

            } else {
                this.form2.customer_id = this.customer.id
                this.form2.post(route('customer.document.store'), {
                    onSuccess:() => $('#CustomerDocumnts').modal('hide'),
                });
            }
        },
        addContext() {
            $('#addContext').modal('show');
            this.form = this.$inertia.form({
                order_id: '',
                status: '',
                priority: '',
                type: '',
                customer_id:'',
                note:'',
                source:'',
                source_other:''
            });
        },
        addivoiceContext() {
            $('#addContextinvoice').modal('show');
            this.form1 = this.$inertia.form({
                supplier_id:'',
                order_id:'',
                invoice_number:'',
                reference_number:'',
                date:'',
                currency:'',
                conversion_rate:'',
                customer_id:''
            });
        },
        CustomerDocumnts() {
            $('#CustomerDocumnts').modal('show');
            this.form2 = this.$inertia.form({
                title:'',
                file:'',
                description:'',
                customer_id:''
            });
        },
        otherSource: function () {
            console.log(this.form.source);
            if (this.form.source == 'Others') {
                this.form.source = this.form.source;
                this.sourceField = true;
            } else {
                this.sourceField = false;
            }
        },
        resetQuery() {
            this.query = {}
            this.loadData()
        },
        getExchangeRate() {
            var currency = this.currencys.find(currency => currency.id == this.form1.currency);
            this.form1.conversion_rate = currency.amount;
        },
        remove(fileName){
            let name =  fileName.substring(18, fileName.length - 4);
            return name;
        },

        removecase(fileName){
            let name =  fileName.substring(22, fileName.length - 4);
            return name;
        },
        Clicked() {
            this.sweetAlert = false
        },
        confirmDeleteInvoice(id) {
            this.sweetAlert = true;
            this.InvoiceId = id;
        },
        deleteItem() {
            this.sweetAlert = false
            this.$inertia.delete(`/erp/customer/case/del/${this.caseId}`)
        },
        confirmDeleteCase(id){
            this.sweetAlert = true;
            this.caseId = id;
        },
        //  deleteItem() {
        //     this.sweetAlert = false
        //     this.$inertia.delete(`/erp/payments/${this.payId}`)
        // },
        confirmDeletePay(id){
            this.sweetAlert = true;
            this.payId = id;
        },
        stopPropagation(e) {
            e.stopPropagation();
        },

        resetSort(e) {
            this.query = {};
            this.query.direction = '';
            this.query.id = '';
            this.query.name = '';
            this.query.address_1 = '';
            this.query.address_2 = '';
            this.loadData();
        },
        resetFilter() {
            this.query = {};
            this.query.id = '';
            this.query.name = '';
            this.loadData();
        },
        search() {
            this.searchItem = true;
            this.loadData()
        },
        filter() {
            this.loadData();
        },
        sort(direction) {
            this.query.direction = direction;
            this.loadData();
        },
        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('warehouseContainer.index'), {
                method: 'get',
                data: {
                    ...query
                }
            })
        },
        showTooltipaddress(id) {
            if (this.id == null) {
                this.id = id;
                $("[data-toggle=address" + id +  "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-address' + id).html();
                    }
                });
                $("[data-toggle=address" + id +  "]").popover('show')
            } else if (this.id == id) {
                $("[data-toggle=address" + this.id +  "]").popover('dispose');
                this.id = null;
            } else {
                $("[data-toggle=address" + this.id +  "]").popover('dispose');
                this.id = id;
                $("[data-toggle=address" + id +  "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-address' + id).html();
                    }
                });
                $("[data-toggle=address" + id +  "]").popover('show')
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
        hideTooltipaddress(id) {
            $("[data-toggle=address" + this.id +   "]").popover('dispose');
            this.id = null;
        },
        hideTooltip(id) {
            $("[data-toggle=" + this.id + "]").popover('dispose');
            this.id = null;
        }
    }
}
</script>

<style scoped>
.custom-padding {
    padding-left: 24px;
}.custom-padding-right {
     padding-right: 24px;
 }

.action {
    margin-right: 4px !important;
    margin-top: 8px !important;
    margin-bottom: 8px !important;
}

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
}

.card-one {
    border: 1px solid #d2d6dc;
    border-bottom: 0px;
}

.caseadd{
    margin-bottom: 7px;
    margin-top: -8px;
}
table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.custom-dropdown {
    margin-top: 0.5rem !important;
}
.header{
    margin-left: 5px;
}
.circle-color-33{
    background-color: white;
    /* margin-left: 89px; */
    margin-top: -9px;
}

@media (max-width: 575.98px) {

    .filter-container {
        width: 100% !important;
        padding-right: 22px !important;
        padding-left: 11px !important;
    }

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
}
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

.back {
    background-color: red !important;
    color: #FFFFFF !important;
}
.view{
    margin-top: -19px;
    margin-left: 36px;
}
.view1{
    margin-top: -8px;
    margin-left: -8px;

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
.threeDots{
    transform: rotate(90deg);
}
.d-flex-payment{
    margin-top: -18px;
    margin-bottom: 0px;
}
.font-large-btn::before{
    font-size: 38px;
}
/* .flex-column-1{
    margin-bottom: 8px;
} */
.flex-column-2{
    margin-bottom: -17px;
}
.payment-download{

    margin-bottom: -10px;
}
.tooltip12{
    margin-left: -9px;
}
.plusicon{
    margin-top: -21px;
    margin-right: -2px;
}
.plusicon1{
    margin-right: -1px;
    margin-top: -35px;
}
.circle-color{
    background-color: white;
}

.circle-color-12{
    background-color: #e6eaee;
}
.font-size-bx{
    font-size: 20px;
}
.card{
    box-shadow: 0 2px 14px rgb(38 60 85 / 16%);
    border-radius: 6px!important;
}
.font-large12{
    font-size: 24px;
    color: black;
}
.font-large123{
    font-size: 24px;
    margin-right: 5px;
    color: black;
}
.bx-plus:before {
    margin-right: -4px;
}
.cardcontent{
    margin-left: 40px;
}
.cardcontent12{
    margin-left: 43px;
    height: 182px;
}
.activity{
    margin-left: 10px;
}
.filetxt{
    margin-left: 8px;
}
.iconsize{
    margin-top: -19px;
    margin-left: -11px;
    font-size: 21px;

}
.addinvoice{
    font-size: 14px;
    margin-left: 29px;
    /* margin-top: 10px; */
    margin-top: -19px;
}
.addcase{
    font-size: 15px;
    margin-top: -19px;
    margin-left: 30px;
}
.star{
    margin-top: -18px;
    margin-left: -20px;;
}
.mt1{
    margin-top: 18px;
}
.mtn1{
    margin-top: -16px;
}
.envelop{
       margin-top: 9px;
    margin-left: -20px;
}
.addreview{
    font-size: 14px;
    margin-top: -36px;
    margin-left: 31px;
}
.deletcustomer{
    font-size: 14px;
    margin-left: 34px;
    margin-top: -37px;
}
.viewall{
    font-size: 14px;
    margin-left: 35px;
    margin-top: -39px;
}
.scroll{
    overflow-y: scroll;
    overflow-x: hidden;
}
.heading{
    margin-left: 209px;
    margin-top: 36px;
    margin-bottom: -26px;
}
.close12{
    margin-left: 457px;
}
.color{
    margin-top: 2px;
}
.badge-circle-others{
    height: 20px!important;
    width: 20px!important;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    background-color: #5A8DEE;
    border-radius: 50%;
}

.actionTd{
    padding-top: 10px!important;
    padding-bottom: 8px!important;
}

.rounded-circle {
    border-radius: 50% !important;
    border: 4px solid #68e7e6!important;
}

.product-image {
    padding-right: 0px!important;
    margin-right: 0px!important;
}

.product-name {
    width: 30% !important;
}
.addDoc{
      margin-left: 14px;
    margin-top: 8px;
    font-size: 14px;
}
.text-setting{
    margin-left: 50px;
    margin-top: -20px;
}
.fontsize{
        font-size: 13px;
}
.addemail{
      font-size: 14px;
    margin-top: -24px;
    margin-left: 33px;
}
</style>
