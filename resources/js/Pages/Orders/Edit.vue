<template>
    <admin-layout>
        <div>
            <form class="form" @submit.prevent="submit">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-body">
                                        <h2 class="card-title mb-0 pt-1">Edit Order</h2>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group py-0 my-0">
                                                    <label for="order-number">Order Number#</label>
                                                    <input type="text" v-model="form.order_number" readonly
                                                           id="order-number"
                                                           class="form-control"
                                                           name="order_number">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group py-0 my-0">
                                                    <label for="order-number">Sale Channel</label>
                                                    <input type="text" v-model="order.channel.name" readonly
                                                           id="channel-name"
                                                           class="form-control"
                                                           name="order_number">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group py-0 my-0">
                                                    <label for="order-date">Order date</label>
                                                    <input type="text" v-model="form.order_date" readonly
                                                           id="order-date"
                                                           class="form-control"
                                                           name="order_date">
                                                </div>
                                            </div>

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
                                                    <input type="text" v-model="form.shipping_customer_name" id="name"
                                                           class="form-control"
                                                           name="name">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Address one</label>
                                                    <input type="text" v-model="form.shipping_address_1"
                                                           class="form-control"
                                                           name="address">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Address two </label>
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
                                                    <label>State Province </label>
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
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Email</label>
                                                    <input type="text" v-model="form.shipping_email"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Order status</label>
                                                    <select class="form-control" id="order_status" name="order_status"
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
                                                    <label>Note</label>
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
                                                    <label>Address one</label>
                                                    <input type="text" v-model="form.billing_address_1_2"
                                                           class="form-control"
                                                           name="address">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Address Two</label>
                                                    <input type="text" v-model="form.billing_address_2" class="form-control"
                                                           name="town">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>town </label>
                                                    <input type="number" v-model="form.billing_address_town"
                                                           class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>State Province</label>
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
                                                    <input type="text" v-model="form.shipping_address_phone"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group py-0 my-0">
                                                    <label>Email</label>
                                                    <input type="text" v-model="form.shipping_email"
                                                           class="form-control">
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

                            <div class="row">
                                <div class="col-12">
                                    <div class="row pb-0.5">
                                        <div class="col-10">
                                            <h2 class="card-title mb-0 pt-1">Product</h2>
                                        </div>
                                        <div class="col-2">
                                            <div class="col form-group pr-0 pb-0.5">
                                                <i class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1"
                                                   data-toggle="modal"
                                                   data-target="#addItem"
                                                   @click="addItem(order.id)">
                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" v-if="order.order_items.length > 0">
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
                                                                        product
                                                                    </th>
                                                                    <th class="text-center py-0 my-0 text-truncate t-header">
                                                                        Quantity
                                                                    </th>
                                                                    <th class="text-center py-0 my-0 text-truncate t-header">
                                                                        Product Rate
                                                                    </th>
                                                                    <th class="text-right r py-0 my-0 text-truncate t-header"></th>
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
                                                                        {{
                                                                            orderItem.quantity ? orderItem.quantity : 1
                                                                        }}
                                                                    </td>
                                                                    <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                                        {{
                                                                            orderItem.deal_product_rate?orderItem.deal_product_rate.deal_price:''
                                                                        }}
                                                                    </td>
                                                                    <td class="text-right text-small action pr-1">
                                                                        <span class="d-inline-flex align-items-center"
                                                                              @click="editOrder(orderItem.id)"
                                                                              data-toggle="modal"
                                                                              data-target="#addItem">
                                                                            <span class="badge-circle badge-circle-light-secondary ">
                                                                                <i class="bx bx-edit-alt  font-medium-1 align-items-center text-center"></i>
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
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold"
                                id="myModalLabel33">
                                Add Item </h4>
                            <button type="button"
                                    class="close"
                                    data-dismiss="modal"
                                    aria-label="Close">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <form @submit.prevent="submitt" class="form form-horizontal">
                            <div class="modal-body">
                                <div class="form-group">
                                    <select class="form-control" v-model.lazy="form1.product_id">
                                        <option></option>
                                        <option v-for="product in products" :value="product.id">
                                            {{ product.name }}
                                        </option>
                                    </select>
                                </div>
                                <label>Quantity *</label>
                                <div class="form-group">
                                    <input name="rate" v-model="form1.quantity" id="quantity" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" v-model.lazy="form1.deal_product_rate_id">
                                        <option>Select Rate</option>
                                        <option v-for="rate in dealRates" :value="rate.id">
                                            {{ rate.product_name }}, {{ rate.deal_price }}, {{ formatDate(rate.start_date) }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" id="modal-hide" data-dismiss="modal">
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

export default {
    name: "Edit",
    props: ['order', 'products', 'order_statuses', 'dealRates'],
    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
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


        })
        return {form}
    },
    data() {
        return {
            form1: this.$inertia.form({
                product_id: '',
                quantity: '',
                order_id: '',
            
            }),
        }
    },
    mounted() {
    },

    beforeMount() {
        console.log(this.order);
        document.title = process.env.MIX_APP_NAME + " - Create Core";
        if (this.order) {
            this.update = true;
            let data = this.order;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        addItem(id) {
            this.form1.order_id = id;
            this.form1 = this.$inertia.form({
                product_id: '',
                quantity: '',
                order_id: id
            });
        },

        editOrder(id) {
            var data = this.order.order_items.find(item => item.id === id);
            this.order_idd = data.id;
            this.updateItem = true;
            Object.assign(data, {
                '_method': 'PUT',
                'product_id': data.product_id,
                'quantity': data.quantity,
                
            });

            this.form1 = this.$inertia.form(data);
        },
        submit() {
            if (this.update) {
                this.form.post(route('orders.update', this.order.id))
            }
        },
        submitt() {
            if (this.updateItem) {
                this.form1.post(route('product.update', this.order_idd), {
                    onSuccess: (page) => {
                        this.updateItem = false;
                        $('#modal-hide').trigger('click');
                        this.form1 = this.$inertia.form({
                            product_id: '',
                            quantity: '',
                        

                        });
                    },
                });
            } else {
                this.form1.post('/erp/orders', {
                    onSuccess: (page) => {
                        $('#modal-hide').trigger('click');
                        this.form1 = this.$inertia.form({
                            product_id: '',
                            quantity: '',
                        
                        });
                    },
                });
            }
        },
        formatDate(date) {
            if(date){
                return moment(date).format('DD-MM-YYYY')
            }else{
                return ''
            }
        },
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            this.sweetAlert = false
            this.$inertia.delete(`/samples/${this.itemId}`)
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

.form-group {
    padding-top: 14px !important;
}
</style>
