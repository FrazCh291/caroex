<template>
    <admin-layout>
        <div class="row pb-3" id="table-hover-row">
            <div class="col-12">
                <div class="card-one py-0 my-0 bg-white">
                    <div class="card-content">
                        <div data-repeater-list="group-a">
                            <div>
                                <div class="top d-flex flex-wrap">
                                    <div class="action-filters flex-grow-1 pr-2">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                            <div
                                                class="input-group form-group d-flex position-relative mt-1 px-2 pr-md-0">
                                                <input type="text" class="form-control border-light-gray btn-height"
                                                       placeholder="Search..."
                                                       aria-label="Search"
                                                       aria-describedby="basic-addon2" v-model="query.query"
                                                       @change="search">
                                                <div class="input-group-append">
                                                    <button class="input-group-text search-btn" @change="search">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="2" stroke-linecap="round"
                                                             stroke-linejoin="round"
                                                             class="feather feather-search feather-16 pb-0 mb-0 mt-0">
                                                            <circle cx="11" cy="11" r="8"></circle>
                                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                                        </svg>
                                                    </button>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-content" v-if="searchImage">
                        <div class="">
                            <img class="seen" src="/img/viewImage.PNG">
                        </div>
                    </div>
                    <form @submit.prevent="submit"
                          class="form form-horizontal">
                        <div class="card mt-2  mb-1">
                            <div class="col-12 px-0" v-if="orders">
                                <div v-if="orderdata">
                                    <div class="card-content">
                                        <ul class="categories-list" v-for="order in orders.data">
                                            <li class="category">
                                                <h6>
                                                    {{ (order.customer.name ? order.customer.name : '') }},
                                                    <b>Email:</b> {{
                                                        (order.customer.email ? order.customer.email : '')
                                                    }},
                                                    <b>Phone:</b> {{
                                                        (order.customer.phone ? order.customer.phone : '')
                                                    }}

                                                </h6>
                                                <ul class="">
                                                    <li class="category">
                                                        <label>
                                                            <b>Adderess:</b>
                                                            {{
                                                                (order.shipping_address_1 ? ", " + order.shipping_address_1 : '') + (order.shipping_address_2 ? " , " + order.shipping_address_2 : '') +
                                                                (order.billing_address_1_2 ? ", " + order.billing_address_1_2 : '') + (order.shipping_address_2 ? " , " + order.shipping_address_2 : '')
                                                            }}
                                                        </label>
                                                    </li>
                                                    <li class="category ml-5">
                                                        <label class="form-check-label"
                                                               :for="order.id"><b>Order: </b>{{
                                                                order.order_number
                                                            }}</label>
                                                        <input type="checkbox" @click='check_one(order.id)'
                                                               v-model="orderId" :id="order.id"
                                                               :value="order.id">
                                                        <ul class="">
                                                            <li class="category" v-for="item in order.order_items">
                                                                <label class="form-check-label"
                                                                       :for="item.product.id"><b>Product Name: </b>{{
                                                                        item.product.name
                                                                    }}</label>
                                                                <input type="checkbox" v-if="item.length>1"
                                                                       @click='check_prod(order.id, item.product.id)'
                                                                       v-model="productId"
                                                                       :id="item.product.id" :value="item.product.id">
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <hr v-if="orders.data.length>1">
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content" v-else>
                                    <div class="">
                                        No record found
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-11 d-flex justify-content-start px-3 pb-2 pt-1">
                            <button type="submit" class="btn btn-primary mr-1 mb-1" v-if="query.query">
                                Save
                            </button>
                             <button type="submit" class="btn btn-primary mr-1 mb-1" v-else disabled>
                                Save
                            </button>
                            <inertia-link :href="route('case.index')" type="button"
                                          class="btn btn-light-secondary mr-1 mb-1">
                                Back
                            </inertia-link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <pagination :links="orderdata" class="float-right" v-if="orders>0"></pagination>
        </div>
    </admin-layout>
</template>

<script>

import AdminLayout from "../../../Layouts/AdminLayout";
import Button from "../../../Jetstream/Button"
import Pagination from "../../../admin/Pagination";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";
import {useForm} from '@inertiajs/inertia-vue3'
import {reactive} from 'vue';
import {Inertia} from '@inertiajs/inertia';

export default {

    name: "create",
    props: ['orders', 'params'],

    components: {
        Button,
        AdminLayout,
        Pagination,
    },
    setup() {
        const form = useForm({
            // orderId: '',
            // product_id: []
        });
        return {form};
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
            orderId: [],
            productId: [],
            product_id: [],
            sweetAlert: false,
            itemId: '',
            searchItem: false,
            searchImage: true,
            orderdata: false,
            validated: true

        }
    },
    beforeMount() {
        if (this.orders) {
            this.searchImage = false;
            if (this.orders.data.length > 0) {
                this.orderdata = true;
            }
        }
        document.title = process.env.MIX_APP_NAME + " - Case Create";
        this.form = this.$inertia.form();
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
        check_one: function (orderIDD) {
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
        submit() {
            this.$inertia.visit('/fulfilment/case', {
                method: 'post',
                data: {
                    order_id: this.orderId,
                    product_id: this.productId
                }
            })
        },
        resetQuery() {
            this.query = {}
            this.loadData()
        },
        Clicked() {
            this.sweetAlert = false
        },
        stopPropagation(e) {
            e.stopPropagation();
        },
        search() {
            this.searchItem = true;
            this.loadData()
        },

        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('case.create'), {
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

.seen {
    padding: 13px;
    margin: 0 auto;
    height: 293px;
}
.form-check-label{
    margin-top: 4px;
}
</style>
