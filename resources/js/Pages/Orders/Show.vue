<template>
    <admin-layout>
        <section class="invoice-view-wrapper">
            <div class="row">
                <div class="col-xl-9 col-md-8 col-12 mt-1">
                    <div class="card invoice-print-area">
                        <div class="card-body pb-0 mx-25">
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <span>{{ order.shipping_customer_name }}</span>
                                </div>
                                <div class="col-lg-8 col-md-12 mt-1">
                                    <div class="d-flex align-items-center justify-content-lg-end flex-wrap">
                                        <div class="mr-3"></div>
                                        <div>
                                            <div class="mr-3">
                                                <small class="text-muted mr-1">Order:</small>
                                                <small class="text-muted">{{ order.order_number }}</small>
                                            </div>
                                            <small class="text-muted mr-1" >Order Date:</small>
                                            <small class="text-muted" >{{order.order_date}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row invoice-info pr-0 mr-0 mt-2">
                                <div class="col-sm-6 col-12">
                                    <h6 class="invoice-from">Shipping Address</h6>
                                    <div class="mb-1">
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
                                    </div>
                                    <div class="mb-1">
                                        <span>{{ order.shipping_email }}</span>
                                    </div>
                                    <div class="mb-1">
                                        <span>{{ order.shipping_address_phone }}</span>
                                    </div>


                                    <h6 class="invoice-from">Billing Address</h6>
                                    <div class="mb-1">
                                        {{
                                            (order.billing_address_1 ? order.billing_address_1 : '') +
                                            (order.billing_address_2 ? order.billing_address_2 : '') +
                                            (order.billing_city ? ", " + order.billing_city : '') +
                                            (order.billing_postcode ? ", " + order.billing_postcode : '') +
                                            (order.billing_country ? ", " + order.billing_country : '')
                                        }}
                                    </div>
                                    <div class="mb-1">
                                        <span>{{ order.billing_email }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <h6 class="invoice-from">Order Status</h6>
                                    <div class="mb-0">
                                        <h6 class="invoice-from">Created by</h6>
                                    </div>
                                    <div class="mb-0">
                                        <h6 class="invoice-from">Updated by</h6>
                                    </div>
                                    <div class="mb-0">
                                        <h6 class="invoice-from">Channel Name</h6>
                                    </div>
                                    <div class="mb-1">
                                        <h6 class="invoice-from">Payment Method</h6>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <h6 class="invoice-from mb-0" >
                                        <small class="text-muted mb-0">
                                                <span
                                                    class="badge badge-light-success badge-pill text-right"
                                                    v-if="order.order_status == 'Processing' || order.order_status == 'processing'">
                                                     {{ order.order_status }}
                                             </span>
                                            <span
                                                class="badge badge-pill badge-warning"
                                                v-if="order.order_status == 'pending' || order.order_status == 'Pending'">
                                                     {{ order.order_status }}
                                             </span>
                                            <span
                                                class="badge badge-pill badge-success"
                                                v-if="order.order_status == 'Shipped' || order.order_status == 'shipped'">
                                                     {{ order.order_status }}
                                             </span>
                                            <span
                                                class="badge badge-pill badge-danger"
                                                v-if="order.order_status == 'cancelled' || order.order_status == 'Cancelled'">
                                                     {{ order.order_status }}
                                             </span>
                                            <span
                                                class="badge badge-pill  badge-success"
                                                v-if="order.order_status == 'completed' || order.order_status == 'Completed'">
                                                     {{ order.order_status }}
                                             </span>
                                            <span
                                                class="badge badge-pill  badge-success"
                                                v-if="order.order_status == 'replacement' || order.order_status == 'Replacement'">
                                                     {{ order.order_status }}
                                             </span>
                                            <span
                                                class="badge badge-pill  badge-success"
                                                v-if="order.order_status == 'redispatch' || order.order_status == 'Redispatch'">
                                                     {{ order.order_status }}
                                             </span>
                                            <span
                                                class="badge badge-pill  badge-success"
                                                v-if="order.order_status == 'collection' || order.order_status == 'Collection'">
                                                     {{ order.order_status }}
                                             </span>
                                        </small>

                                    </h6>
                                    <div>
                                        <div class="mb-0" style="margin-top: 7px">
                                            <span> {{ order.created_by ? order.created_by.name : order.updated_by ? order.updated_by.name : '.'}}</span>
                                        </div>
                                        <div class="mb-0" style="margin-top: 7px">
                                            <span>{{ order.updated_by ? order.updated_by.name : order.created_by ? order.created_by.name : '.'}}</span>
                                        </div>
                                        <div class="mb-0" style="margin-top: 7px">
                                            <span class="mb-0">
                                                {{ order.channel.name }}
                                            </span>
                                        </div>
                                        <div class="mb-0" style="margin-top: 7px">
                                            <span class="mb-0">
                                                {{ order.payment_method_type }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="invoice-product-details table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead>
                                <tr class="border-0">
                                    <th scope="col" class="text-center">Products</th>
                                    <th scope="col" class="text-center">TrackinG ID</th>
                                    <th scope="col" class="text-center">Unit Price</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-center">Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="orderItem in order.order_items">
                                    <td class="text-center">{{ orderItem.product ? orderItem.product.name : orderItem.product_name }}</td>
                                    <td class="text-center">{{ orderItem.tracking_number ? orderItem.tracking_number : ' ' }}</td>
                                    <td class="text-center">£{{ orderItem.item_cost ? orderItem.item_cost : ' '}}</td>
                                    <td class="text-center">{{ orderItem.quantity ? orderItem.quantity : ' '}}</td
                                    >
                                    <td class="font-weight-bold text-center">
                                        {{ (orderItem.quantity * orderItem.item_cost) ? (orderItem.quantity * orderItem.item_cost) : ' '}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- invoice subtotal -->
                        <div class="card-body pt-0 mx-25">
                            <hr>
                            <inertia-link :href="route('customers.show',customer_id)" type="button"
                                          class="btn btn-light-secondary mr-1" v-if="customer_id">
                                Back
                            </inertia-link>
                            <inertia-link :href="route('orders.index',order.id)" type="button"
                                          class="btn btn-light-secondary mr-1" v-else>
                                Back
                            </inertia-link>
                            <div class="row">
                                <div class="col-4 col-sm-6 col-12 mt-75">
                                </div>
                                <div class="col-8 col-sm-6 col-12 d-flex justify-content-end mt-75">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-12">
                    <div class="card invoice-action-wrapper shadow-none border">
                        <div class="card-body pb-1 my-0">
                            <div class="invoice-action-btn">
                                <button class="btn btn-light-primary btn-block" data-toggle="modal"
                                        data-target="#update-status" @click="orderStatus">
                                    <span>Update</span>
                                </button>
                                <inertia-link :href="route('orders.edit',order.id)"
                                              class="btn btn-light-primary btn-block"
                                              data-repeater-create="">
                                    Edit
                                </inertia-link>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade text-left" id="update-status" tabindex="-1" aria-labelledby="myModalLabel33"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Update Status</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <form @submit.prevent="submitStatus">
                            <div class="modal-body mb-1">
                                <label>Order#: <span class="ml-0.5"> {{ order.order_number }}</span> </label>
                                <div class="form-group">

                                </div>
                                <label>Statuses: </label>
                                <div class="form-group">
                                    <select class="form-control"
                                            v-model="form.order_status"
                                            name="order_status"
                                            id="product_id">
                                        <option></option>
                                        <option v-for="order_statuss in order_statuses"
                                                :value="order_statuss.slug">{{ order_statuss.value}}
                                        </option>
                                    </select>
                                    <ErrorComponent input="role"></ErrorComponent>
                                </div>
                                <label>Tracking Number: </label>
                                <div class="form-group">
                                    <input class="form-control"
                                           v-model="form.shipment_tracking_number">
                                    <ErrorComponent input="shipment_tracking_number"></ErrorComponent>
                                </div>
                                <label>Notes: </label>
                                <div class="form-group">
                                    <textarea class="form-control no-resize" rows="3"
                                              v-model="form.description"></textarea>
                                    <ErrorComponent input="description"></ErrorComponent>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary"
                                        id="modal-hide"
                                        ref="closeModall"
                                        data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="button" class="btn btn-primary ml-1" data-dismiss="modal"
                                        @click="stopPropagation">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </admin-layout>
</template>

<script>
import moment from 'moment';
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import DeletedModal from "../SweetAlert/DeletedModal";
import ErrorComponent from '../../components/ErrorComponent'

export default {

    name: "Show",
    props: ['order', 'order_statuses' , 'customer_id'],
    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
        ErrorComponent
    },
    data() {
        return {
            form: this.$inertia.form({
                order_status: '',
                'shipment_tracking_number': '',
                description: ''
            }),
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
        document.title = process.env.MIX_APP_NAME + " - Order Show";
    },
    mounted() {
        if (this.params) {
            Object.assign(this.query, this.params);
        }
    },
    methods: {

        submitStatus() {
            this.$inertia.visit(route('order.status.update', this.order.id), {
                    method: 'put',
                    data: {
                        '_method': 'PUT',
                        'order_status': this.form.order_status,
                        'description': this.form.description,
                        'shipment_tracking_number': this.form.shipment_tracking_number
                    }
                },
                $('#modal-hide').trigger('click'));
        },
        orderStatus() {
            this.form.order_status = this.order.order_status;
            this.form.description = this.order.description;
            this.form.shipment_tracking_number = this.order.shipment_tracking_number
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
            this.$inertia.delete(`/cores/${this.itemId}`)
        },
        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
        },
        stopPropagation(e) {
            e.stopPropagation();
            this.submitStatus();
        },
        resetSort(e) {
            this.query = {};
            this.query.direction = '';
            this.query.id = '';
            this.query.name = '';
            this.query.enable = '';
            this.query.disable = '';
            this.loadData();
        },
        resetFilter() {
            this.query = {};
            this.query.id = '';
            this.query.name = '';
            this.query.direction = '';
            this.query.enable = '';
            this.query.disable = '';
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
            this.$inertia.visit(route('cores.index'), {
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
.status-class {
    margin-right: 28px;
}

.action {
    margin-right: 4px !important;
}

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
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
</style>
