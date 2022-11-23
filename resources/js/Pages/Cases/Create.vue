<template>
    <admin-layout>
        <div>
            <form class="form" @submit.prevent="submit">
                <div class="row">
                    <div class="card">
                        <div class="card-header pb-0 mb-0">
                            <h4 class="card-title">Add Case</h4>
                            <div class="header  mt-1" v-if="Object.keys(errors).length > 0">
                                <div class="alert bg-rgba-danger alert-dismissible mb-2 message" role="alert">
                                    <div class="d-flex align-items-center" v-for="error in errors">
                                        <i class="bx bx-error"></i>
                                        <span>
                                            <jet-input-error :message="error" class="mt-2 error "/>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label for="order-number">Order Number#</label>
                                                    <input type="text" v-model="form.order_number" readonly
                                                           id="order-number"
                                                           class="form-control"
                                                           name="order_number">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label for="order-date">Order date</label>
                                                    <input type="text" v-model="form.order_date" readonly
                                                           id="order-date"
                                                           class="form-control"
                                                           name="order_date">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label for="order-date">Received date</label>
                                                    <input type="date" v-model="form.received_at"
                                                           id="received_at"
                                                           class="form-control"
                                                           name="received_at">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                </div>
                                <div class="col-md-5 col-12">
                                    <div class="col-12">
                                        <div class="form-group py-0 my-0">
                                            <label>Case type*</label>
                                            <select class="form-select" id="case_type" name="case_type"
                                                    v-model="form.case_type">
                                                <option value=""> Add Case Type</option>
                                                <option v-for="case_type in case_types" :value="case_type.id">
                                                    {{ case_type.value }}
                                                </option>
                                                <ErrorComponent input="case_types"></ErrorComponent>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group py-0 my-0">
                                            <label>Priority status*</label>
                                            <select id="priority_id" name="priority_id"
                                                    v-model="form.priority_id" class="form-select">
                                                <option value="">Add Priority</option>
                                                <option v-for="prioritys in priorities" :value="prioritys.id">
                                                    {{ prioritys.value }}
                                                </option>
                                                <ErrorComponent input="priority_id"></ErrorComponent>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-12">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12 pt-1 pb-0">
                                                <div class="form-group">
                                                    <h6>Shipping Address</h6>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Name</label>
                                                    <input type="text" readonly v-model="form.shipping_customer_name"
                                                           id="name"
                                                           class="form-control"
                                                           name="name">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Address 1</label>
                                                    <input type="text" v-model="form.shipping_address_1"
                                                           class="form-control"
                                                           name="address">
                                                    <ErrorComponent input="shipping_address_1"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Address 2</label>
                                                    <input type="number" v-model="form.shipping_address_2"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Town </label>
                                                    <input type="text" v-model="form.shipping_address_town " id="town"
                                                           class="form-control"
                                                           name="town">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>County</label>
                                                    <input type="text" v-model="form.shipping_address_city"
                                                           class="form-control"
                                                           name="state">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Postcode</label>
                                                    <input type="text" id="postcode"
                                                           v-model="form.shipping_address_postcode"
                                                           class="form-control">
                                                    <ErrorComponent input="shipping_address_postcode"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Country</label>
                                                    <input type="text" id="country" v-model="form.shipping_country"
                                                           class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Phone</label>
                                                    <input type="text" id="phone" v-model="form.shipping_address_phone"
                                                           class="form-control">
                                                    <ErrorComponent input="shipping_address_phone"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Email</label>
                                                    <input type="text" v-model="form.shipping_email"
                                                           class="form-control">
                                                    <ErrorComponent input="shipping_email"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Order status</label>
                                                    <select class="form-select" id="order_status" name="order_status"
                                                            v-model="form.order_status">
                                                        <option value=""></option>
                                                        <option v-for="status in order_statuses" :value="status.slug">
                                                            {{ status.value }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Customer Note</label>
                                                    <textarea class="form-control no-resize" v-model="form.description"
                                                              rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12"></div>
                                <div class="col-md-5 col-12">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12 pt-1 pb-0">
                                                <div class="form-group">
                                                    <h6>Billing Address</h6>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Name</label>
                                                    <input type="text" v-model="form.billing_customer_name"
                                                           class="form-control"
                                                           name="name">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Address 1</label>
                                                    <input type="text" v-model="form.billing_address_1"
                                                           class="form-control"
                                                           name="address">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Address 2</label>
                                                    <input type="text" v-model="form.billing_address_2"
                                                           class="form-control"
                                                           name="town">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Town</label>
                                                    <input type="number" v-model="form.billing_address_2"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>County</label>
                                                    <input type="text" v-model="form.billing_city" class="form-control"
                                                           name="state">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Postcode</label>
                                                    <input type="text" v-model="form.billing_postcode"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Country</label>
                                                    <input type="text" v-model="form.billing_country"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Phone</label>
                                                    <input type="text" id="phone" v-model="form.shipping_address_phone"
                                                           class="form-control">
                                                    <ErrorComponent input="shipping_address_phone"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Email</label>
                                                    <input type="text" v-model="form.shipping_email"
                                                           class="form-control">
                                                    <ErrorComponent input="shipping_email"></ErrorComponent>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row pb-0.5">
                                        <div class="col-10">
                                            <h2 class="card-title mb-0 pt-1">Order items </h2>
                                        </div>
                                    </div>
                                    <div class="row" v-if="order.order_items.length > 0">
                                        <div class="row col-12 pr-0 ng-repeat-start" id="table-hover-rows">
                                            <div class="col-12 pr-0">
                                                <div class="card pr-0 pb-0 mb-1">
                                                    <div class="card-content">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th class="text-left pl-1 py-0 my-0 text-truncate t-header">
                                                                        Item#
                                                                    </th>
                                                                    <th class="text-left py-0 my-0 text-truncate t-header">
                                                                        Product
                                                                    </th>
                                                                    <th class="text-center py-0 my-0 text-truncate t-header">
                                                                        Sku
                                                                    </th>
                                                                    <th class="text-center py-0 my-0 text-truncate t-header">
                                                                        Quantity
                                                                    </th>
                                                                    <th class="text-right py-0 my-0 text-truncate t-header">
                                                                        Link Item
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="orderItem in order.order_items"
                                                                    class="py-0 my-0">
                                                                    <td class="text-left small cursor-pointer px-1 py-0 my-0 text-truncate">
                                                                        {{ orderItem.id }}
                                                                    </td>
                                                                    <td class="text-left small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ orderItem.product.name }}
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ orderItem.product.sku }}
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{
                                                                            orderItem.quantity ? orderItem.quantity : 1
                                                                        }}
                                                                    </td>
                                                                    <td class="text-right text-small action pr-3">
                                                                        <span class="d-inline-flex align-items-center">
                                                                            <span
                                                                                class="d-inline-flex align-items-center"
                                                                                @click="editOrder(orderItem.product_id)"
                                                                                data-toggle="modal"
                                                                                data-target="#addItem">
                                                                               <span
                                                                                   class="badge-circle badge-circle-light-secondary bg-white">
                                                                                 <i class="bx bx bx-edit-alt pt-0 primary float-right add-btn font-large-1"></i>
                                                                               </span>
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
                                    <div v-else>
                                        <hr class="line mb-0 mt-0.5">
                                        <p class="mt-1">Seems you do not have any rates for this supplier.</p>
                                    </div>
                                    <div class="col-10 px-0" v-if="requestedItems.length > 0">
                                        <h2 class="card-title mb-0 pt-1">Requested Items</h2>
                                    </div>
                                    <div class="row" v-if="requestedItems.length > 0">
                                        <div class="row col-12 pr-0 ng-repeat-start" id="table-hover-row">
                                            <div class="col-12 pr-0">
                                                <div class="card pr-0 pb-0 mb-1">
                                                    <div class="card-content">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th class="text-left pl-1 py-0 my-0 text-truncate t-header">
                                                                        Item#
                                                                    </th>
                                                                    <th class="text-left py-0 my-0 text-truncate t-header">
                                                                        Return Item
                                                                    </th>
                                                                    <th class="text-left py-0 my-0 text-truncate t-header">
                                                                        New product
                                                                    </th>
                                                                    <th class="text-center py-0 my-0 text-truncate t-header">
                                                                        Sku
                                                                    </th>
                                                                    <th class="text-center py-0 my-0 text-truncate t-header">
                                                                        Quantity
                                                                    </th>
                                                                    <th class="text-right py-0 my-0 text-truncate t-header">
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="requestedItem in requestedItems"
                                                                    class="py-0 my-0">
                                                                    <td class="text-left small cursor-pointer px-1 py-0 my-0 text-truncate">
                                                                        {{ requestedItem.id }}
                                                                    </td>
                                                                    <td class="text-left small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ requestedItem.old_product_name }}
                                                                    </td>
                                                                    <td class="text-left small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ requestedItem.product_name }}
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ requestedItem.sku }}
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{ requestedItem.quantity }}
                                                                    </td>
                                                                    <td class="text-right text-small action pr-1">
                                                                        <span class="d-inline-flex align-items-center"
                                                                              v-on:click="deleteReturnItem(requestedItem.id)">
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
                                    <ErrorComponent input="requestedItems"></ErrorComponent>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 pt-2">
                                    <label>Product Images</label>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                    <div class="">
                                        <div class="card-content image-card">
                                            <div class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                <div class="card pt-0 mb-1">
                                                    <input type="file"
                                                           @change="preview_image('p_image1')"
                                                           id="p_image1-upload"
                                                           style="display:none"/>
                                                    <label for="p_image1-upload"
                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                        <img class="image rounded mx-auto d-block px-1" id="p_image1"
                                                             src="/img/camera-icon.png">
                                                            </span>
                                                        <span id="side1" class="text-center mt-1 small"><br>  <span>Product Image 1 *</span></span>
                                                    </label>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                    <div class="">
                                        <div class="card-content image-card">
                                            <div class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                <div class="card pt-0 mb-1">
                                                    <input type="file"
                                                           @change="preview_image('p_image2')"
                                                           id="p_image2-upload"
                                                           style="display:none"/>
                                                    <label for="p_image2-upload"
                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                        <img class="image rounded mx-auto d-block px-1" id="p_image2"
                                                             src="/img/camera-icon.png">
                                                            </span>
                                                        <span id="side1" class="text-center mt-1 small"><br>  <span>Product Image 2 *</span></span>
                                                    </label>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                    <div class="">
                                        <div class="card-content image-card">
                                            <div class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                <div class="card pt-0 mb-1">
                                                    <input type="file"
                                                           @change="preview_image('p_image3')"
                                                           id="p_image3-upload"
                                                           style="display:none"/>
                                                    <label for="p_image3-upload"
                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                        <img class="image rounded mx-auto d-block px-1" id="p_image3"
                                                             src="/img/camera-icon.png">
                                                            </span>
                                                        <span id="side1" class="text-center mt-1 small"><br>  <span>Product Image 3 *</span></span>
                                                    </label>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                    <div class="">
                                        <div class="card-content image-card">
                                            <div class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                <div class="card pt-0 mb-1">
                                                    <input type="file"
                                                           @change="preview_image('p_image4')"
                                                           id="p_image4-upload"
                                                           style="display:none"/>
                                                    <label for="p_image4-upload"
                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                        <img class="image rounded mx-auto d-block px-1" id="p_image4"
                                                             src="/img/camera-icon.png">
                                                            </span>
                                                        <span id="side1" class="text-center mt-1 small"><br>  <span>Product Image 4 *</span></span>
                                                    </label>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                    <div class="">
                                        <div class="card-content image-card">
                                            <div class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                <div class="card pt-0 mb-1">
                                                    <input type="file"
                                                           @change="preview_image('p_image5')"
                                                           id="p_image5-upload"
                                                           style="display:none"/>
                                                    <label for="p_image5-upload"
                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                        <img class="image rounded mx-auto d-block px-1" id="p_image5"
                                                             src="/img/camera-icon.png">
                                                            </span>
                                                        <span id="side1" class="text-center mt-1 small"><br>  <span>Product Image 5 *</span></span>
                                                    </label>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                    <div class="">
                                        <div class="card-content image-card">
                                            <div class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                <div class="card pt-0 mb-1">
                                                    <input type="file"
                                                           @change="preview_image('exchange')"
                                                           id="exchange-upload"
                                                           style="display:none"/>
                                                    <label for="exchange-upload"
                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                        <img class="image rounded mx-auto d-block px-1" id="exchange"
                                                             src="/img/camera-icon.png">
                                                            </span>
                                                        <span id="side1" class="text-center mt-1 small"><br>  <span>Exchange Form *</span></span>
                                                    </label>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                    <div class="">
                                        <div class="card-content image-card">
                                            <div class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                <div class="card pt-0 mb-1">
                                                    <input type="file"
                                                           @change="preview_image('parcel1')"
                                                           id="parcel1-upload"
                                                           style="display:none"/>
                                                    <label for="parcel1-upload"
                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                        <img class="image rounded mx-auto d-block px-1" id="parcel1"
                                                             src="/img/camera-icon.png">
                                                            </span>
                                                        <span id="side1" class="text-center mt-1 small"><br>  <span>Add Parcel Side 1 *</span></span>
                                                        Add License
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                    <div class="">
                                        <div class="card-content image-card">
                                            <div class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                <div class="card pt-0 mb-1">
                                                    <input type="file"
                                                           @change="preview_image('parcel2')"
                                                           id="parcel2-upload"
                                                           style="display:none"/>
                                                    <label for="parcel2-upload"
                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                        <img class="image rounded mx-auto d-block px-1" id="parcel2"
                                                             src="/img/camera-icon.png">
                                                            </span>
                                                        <span id="side1" class="text-center mt-1 small"><br>  <span>Add Parcel Side 2 *</span></span>
                                                    </label>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-sm-11 d-flex justify-content-start px-0">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">
                                        Save
                                    </button>
                                    <inertia-link :href="route('orders.show',order.id)" type="button"
                                                  class="btn btn-light-secondary mr-1 mb-1">
                                        Back
                                    </inertia-link>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="modal fade text-left"
                 id="addItem" tabindex="-1"
                 role="dialog"
                 aria-labelledby="myModalLabel33"
                 aria-hidden="true">
                <div
                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold"
                                id="myModalLabel33">
                                Link Item </h4>
                            <button type="button"
                                    class="close"
                                    data-dismiss="modal"
                                    aria-label="Close">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <form @submit.prevent="submitt"
                              class="form form-horizontal">
                            <div class="modal-body mb-1">

                                <div class="form-group my-0">
                                    <label>Order Item *</label>
                                    <select disabled="true" readonly class="form-control"
                                            v-model.lazy="form1.productt_id">
                                        <option></option>
                                        <option v-for="product in products"
                                                :value="product.id">
                                            {{ product.name }}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group py-0 my-0">
                                    <label>Requested Action</label>
                                    <select class="form-control" id="requested_action"
                                            name="requested_action"
                                            v-model="form1.requested_action">
                                        <option value=""></option>
                                        <option
                                            v-for="requested_action in requested_actions"
                                            :value="requested_action.slug">
                                            {{ requested_action.value }}
                                        </option>
                                    </select>

                                </div>

                                <div class="form-group my-0"
                                     v-if="form1.requested_action !== 'refund'">
                                    <label>Requested Item *</label>
                                    <select class="form-control" v-model.lazy="form1.requested_id">
                                        <option></option>
                                        <option v-for="product in products"
                                                :value="product.id">
                                            {{ product.name }}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group py-0 my-0">
                                    <label>Condition</label>
                                    <select class="form-control" id="product_condition"
                                            name="product_condition"
                                            v-model="form1.product_condition">
                                        <option value=""></option>
                                        <option
                                            v-for="productConditionStatus in productConditionStatuses"
                                            :value="productConditionStatus.id">
                                            {{ productConditionStatus.value }}
                                        </option>
                                    </select>
                                </div>


                                <div class="form-group py-0 my-0">
                                    <label>Staff Note</label>
                                    <textarea class="form-control no-resize" v-model="form1.staff_note"
                                              rows="3"></textarea>
                                </div>


                                <div class="form-group my-0">
                                    <label>Quantity *</label>
                                    <input name="rate"
                                           v-model="form1.quantity"
                                           id="quantity"
                                           type="text"
                                           placeholder=""
                                           class="form-control">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-light-secondary"
                                        id="modal-hide"
                                        data-dismiss="modal">
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
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                               @deleteitem="deleteItem"></ConfirmatiomModal>
        </div>

    </admin-layout>
</template>

<script>
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import {useForm} from '@inertiajs/inertia-vue3';

import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import JetInputError from './../../Jetstream/InputError'

import ErrorComponent from '../../components/ErrorComponent'
import Input from "../../Jetstream/Input";

export default {
    name: "Edit",
    props: ['orders', 'order', 'products', 'order_statuses', 'errors', 'productConditionStatuses', 'requested_actions', 'priorities', 'case_types'],
    components: {
        Input,
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
        ErrorComponent,
        JetInputError
    },
    setup() {
        const form = useForm({
            shipping_customer_name: '',
            shipping_address_1: '',
            shipping_address_2: '',
            shipping_address_town: '',
            shipping_address_city: '',
            shipping_address_postcode: '',
            shipping_country: '',
            description: '',
            billing_customer_name: '',
            billing_address_1: '',
            house_number: '',
            billing_address_2: '',
            billing_city: '',
            billing_postcode: '',
            billing_country: '',
            shipping_address_phone: '',
            shipping_email: '',
            order_status: '',
            id: '',
            parcel_side_1: '',
            parcel_side_2: '',
            exchange_form: '',
            p1_image: '',
            p2_image: '',
            p3_image: '',
            p4_image: '',
            p5_image: '',
            priority_id: '',
            received_at: '',
            case_type: '',
            requestedItems: []

        })
        return {form}
    },
    data() {
        return {
            form1: this.$inertia.form({
                productt_id: '',
                quantity: '',
                requested_id: '',
                requested_action: '',

            }),
            requestedItems: [],

        }
    },
    mounted() {

    },

    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Case";
        if (this.order) {
            this.form.requestedItems = this.requestedItems
            this.form.shipping_customer_name = this.order.shipping_customer_name ? this.order.shipping_customer_name : '',
                this.form.shipping_address_1 = this.order.shipping_address_1 ? this.order.shipping_address_1 : '',
                this.form.shipping_address_2 = this.order.shipping_address_2 ? this.order.shipping_address_2 : '',
                this.form.shipping_address_town = this.order.shipping_address_town ? this.order.shipping_address_town : '',
                this.form.shipping_address_city = this.order.shipping_address_city ? this.order.shipping_address_city : '',
                this.form.shipping_address_postcode = this.order.shipping_address_postcode ? this.order.shipping_address_postcode : '',
                this.form.description = this.order.description ? this.order.description : '',
                this.form.billing_customer_name = this.order.billing_customer_name ? this.order.billing_customer_name : '',
                this.form.billing_customer_name = this.order.billing_customer_name ? this.order.billing_customer_name : '',
                this.form.shipping_country = this.order.shipping_country ? this.order.shipping_country : '',
                this.form.order_number = this.order.order_number ? this.order.order_number : '',
                this.form.order_date = this.order.order_date ? this.order.order_date : '',
                this.form.billing_address_2 = this.order.billing_address_1_2 ? this.order.billing_address_1_2 : '',
                this.form.billing_address_1 = this.order.billing_address_1 ? this.order.billing_address_1 : '',
                this.form.house_number = this.order.house_number ? this.order.house_number : '',
                this.form.billing_city = this.order.billing_city ? this.order.billing_city : '',
                this.form.billing_postcode = this.order.billing_postcode ? this.order.billing_postcode : '',
                this.form.billing_country = this.order.billing_country ? this.order.billing_country : '',
                this.form.order_status = this.order.order_status ? this.order.order_status : '',
                this.form.billing_country = this.order.billing_country ? this.order.billing_country : '',
                this.form.shipping_address_phone = this.order.shipping_address_phone ? this.order.shipping_address_phone : '',
                this.form.shipping_email = this.order.shipping_email ? this.order.shipping_email : ''
        }
    },
    methods: {
        preview_image(data) {
            var reader = new FileReader();
            reader.onload = function () {
                if (data == 'parcel1') {
                    var output = document.getElementById('parcel1');
                }
                if (data == 'parcel2') {
                    var output = document.getElementById('parcel2');
                }
                if (data == 'exchange') {
                    var output = document.getElementById('exchange');
                }
                if (data == 'p_image1') {
                    var output = document.getElementById('p_image1');
                }
                if (data == 'p_image2') {
                    var output = document.getElementById('p_image2');
                }

                if (data == 'p_image3') {
                    var output = document.getElementById('p_image3');
                }
                if (data == 'p_image4') {
                    var output = document.getElementById('p_image4');
                }
                if (data == 'p_image5') {
                    var output = document.getElementById('p_image5');
                }

                output.src = reader.result;
            },
                reader.readAsDataURL(event.target.files[0]);
        },

        editOrder(id) {

            this.form1 = this.$inertia.form({
                productt_id: id,
                quantity: '',
                requested_id: '',
                requested_action: '',
                staff_note: '',
                product_condition: ''
            });

        },
        submitt() {

            var data = this.products.find(item => item.id === parseInt(this.form1.productt_id));

            var product = this.products.find(item => item.id === parseInt(this.form1.requested_id));


            var obj = {};
            obj["id"] = this.form1.requested_id ? this.form1.requested_id : data.id;
            obj["quantity"] = this.form1.quantity;
            obj["product_name"] = product ? product.name : data.name;
            obj["sku"] = product ? product.sku : data.sku;

            obj["old_product_name"] = data.name;
            obj["old_product_id"] = data.id;
            obj['requested_action'] = this.form1.requested_action;
            obj['staff_note'] = this.form1.staff_note;
            obj['product_condition'] = this.form1.product_condition;
            this.requestedItems.push(obj);
            $('#modal-hide').trigger('click');
            this.form1.product_id = '';

        },
        deleteReturnItem(id) {


            this.requestedItems = this.requestedItems.filter(function (item) {
                return item.id != id;
            });

        },
        submit() {
            this.$page.props.errors = {};
            if (document.getElementById('parcel1-upload').files.length) {
                this.form.parcel_side_1 = document.getElementById('parcel1-upload').files[0];
            }
            if (document.getElementById('parcel2-upload').files.length) {
                this.form.parcel_side_2 = document.getElementById('parcel2-upload').files[0];
            }
            if (document.getElementById('exchange-upload').files.length) {
                this.form.exchange_form = document.getElementById('exchange-upload').files[0];
            }
            if (document.getElementById('p_image1-upload').files.length) {
                this.form.p1_image = document.getElementById('p_image1-upload').files[0];
            }
            if (document.getElementById('p_image2-upload').files.length) {
                this.form.p2_image = document.getElementById('p_image2-upload').files[0];
            }
            if (document.getElementById('p_image3-upload').files.length) {
                this.form.p3_image = document.getElementById('p_image3-upload').files[0];
            }
            if (document.getElementById('p_image4-upload').files.length) {
                this.form.p4_image = document.getElementById('p_image4-upload').files[0];
            }
            if (document.getElementById('p_image5-upload').files.length) {
                this.form.p5_image = document.getElementById('p_image5-upload').files[0];
            }
            this.form.id = this.order.id ? this.order.id : '',
                this.form.post('/cases')

        },

        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            this.sweetAlert = false
            this.sweetAlert = false

            const index = this.order.order_items.indexOf(this.itemId);
            if (index > -1) {
                his.order.order_items.splice(index, 1);
            }
        },
        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
        },
        stopPropagation(e) {
            e.stopPropagation();
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
    padding-top: 4px !important;
    padding-bottom: 4px !important;
}

.table-font {
    font-size: small !important;
}

.text-small {
    font-size: 14px !important;
}

.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}

.line-height {
    line-height: 1.7rem !important;
}

.bx-download:before {
    content: "\ea86";
}

.download-btn {
    font-size: 15px !important;
}

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
    height: auto !important;
}

.card-one {
    border: 1px solid #d2d6dc;
    border-bottom: 0px;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.custom-dropdown {
    margin-top: 0.5rem !important;
}

.error {
    margin-top: 0px !important;
}

.image {
    width: auto !important;
    height: 110px !important;
}

.form-group {
    padding-top: 14px !important;
}
</style>
