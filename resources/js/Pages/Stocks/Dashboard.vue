<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
                <inertia-link :href="route('product-details.create')" class="btn btn-primary" data-repeater-create="">
                    Add Products
                </inertia-link>
            </div>
        </div>
        <div class="row pb-3" id="table-hover-row">
            <div class="col-12">
                <div class="card-one py-0 my-0 bg-white">
                    <div class="card-content">
                        <div data-repeater-list="group-a">
                            <div>
                                <div class="top d-flex flex-wrap">
                                    <div class="action-filters flex-grow-1">
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
                                    <div class="actions action-btns d-flex align-items-center sort-dropdown pl-1">
                                        <div class="dropdown w-100 pr-2 sort-dropdown2">
                                            <button class="btn border dropdown-toggle w-100" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Sort
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"
                                                 aria-labelledby="" @click="stopPropagation">
                                                <div class="col-12 pl-2 pt-2">
                                                    <div class="d-inline-flex w-100">
                                                        <h6 class="py-0 my-0">Sort</h6>
                                                        <span class="primary pl-20 ml-2 pointer" @click="resetSort">Reset</span>
                                                    </div>
                                                    <div class="align-items-center text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="name" id="name"
                                                                   v-model="query.name">
                                                            <label class="pl-1 py-0 my-0" for="name">Name</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base">
                                                        <p class="tag">
                                                            <input type="checkbox" name="sku" id="sku"
                                                                   v-model="query.sku">
                                                            <label class="pl-1 py-0 my-0" for="sku">Sku</label>
                                                        </p>
                                                    </div>
                                                    <div class="align-items-center text-base">
                                                        <p class="tag">
                                                            <input type="checkbox" name="shipping_method" id="shipping_method"
                                                                   v-model="query.shipping_method">
                                                            <label class="pl-1 py-0 my-0" for="shipping_method">Shipping Method</label>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider py-0 my-0"></div>
                                                <div class="col-12 pl-2 d-inline-flex">
                                                    <p class="pt-1">
                                                        <button type="button" id="asce" @click="sort('asc')"
                                                                class=" btn btn-sm btn-primary font-small font-weight-normal stock-order">
                                                            Asc
                                                        </button>
                                                    </p>
                                                    <p class="pt-1 pl-3">
                                                        <button type="button" id="desc" @click="sort('desc')"
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
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="product-name">Product</th>
                                    <th>Sku</th>
                                    <th class="text-center">Shipping method</th>
                                    <th class="text-center">Quantity</th>
                                    <th>Rating</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="product in products.data">
                                    <td class="py-0 my-0" @click="hideTooltip(product.id)">
                                        <div class="row">
                                            <div class="col-2 pr-0 mr-0">
                                                <img v-if="product.image !== null" :src="'/'+product.image"
                                                     class="rounded-circle product-image" width="45" height="40">
                                                <img v-else src="products/empty.jpg" class="rounded-circle empty-image"
                                                     width="45" height="40">
                                            </div>
                                            <div class="col-9 py-1 px-0 mx-0" @click="hideTooltip(product.id)">
                                                {{ product.name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-0 my-0" @click="hideTooltip(product.id)">{{ product.sku }}</td>
                                    <td class="text-center py-0 my-0" @click="hideTooltip(product.id)">
                                        {{ product.shipping_method }}
                                    </td>
                                    <td class="text-truncate text-center" v-if="product.warehouse_stocks.length>0">

                                         <span data-placement="bottom" :data-toggle="product.id"
                                               @click="showTooltip(product.id)" data-container="body"
                                               type="button" data-html="true" href="#" id="login">
                                        <span class="underline-dotted border-gray">
                                        {{ product.prodcut_stock ? product.prodcut_stock.quantity : 0 }}

                                        </span>
                                        </span>
                                        <div class="container">
                                            <div :id="'popover-content-'+product.id" class="d-none">
                                                <div class="custom-popover popover-max">
                                                    <div class="d-flex justify-content-around">
                                                        <div>
                                                            <b class="font-size-small">Warehouse</b>
                                                        </div>
                                                        <div class="pl-5">
                                                            <b class="font-size-small">Quantity</b>
                                                        </div>
                                                    </div>
                                                    <hr class="line">
                                                    <div class="row d-flex justify-content-around"
                                                         v-if="product.warehouse_stocks.length>0"
                                                         v-for="warehouse_stock in product.warehouse_stocks">
                                                        <p class="pr-3 font-size-small">{{ warehouse_stock.ware_house.name }}</p>
                                                        <p class="font-size-small">{{ warehouse_stock.quantity }}</p>
                                                    </div>

                                                    <div class="row d-flex justify-content-around" v-else>
                                                        <div class="pr-3">...</div>
                                                        <div>...</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate text-center" v-else>0</td>
                                    <td class="py-0 my-0" v-if="product.reviews.length>0">
                                        <div class="star-rating">
                                            <span v-for="n in 5">&star;</span>
                                            <div class="star-rating__current" :style="{width: (avgRating(product.reviews)/5)*100 + '%'}">
                                                <span v-for="n in 5">&starf;</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left py-0 my-0" v-else>
                                        Not rated yet.
                                    </td>
                                    <td class="text-right py-0 my-0" @click="hideTooltip(product.id)">
                                        <span class="d-inline-flex align-items-center">
                                            <inertia-link :href="route('product-details.edit',product.id)">
                                                    <span class="badge-circle badge-circle-light-secondary  action">
                                                        <i class="bx bx-edit font-medium-1 align-items-center text-center"></i>
                                                    </span>
                                                </inertia-link>
                                                <button v-on:click="confirmDelete(products.id)">
                                                    <span class="badge-circle badge-circle-light-secondary ml-1/6">
                                                        <i class="bx bx-trash font-medium-1 text-center"></i>
                                                    </span>
                                                </button>
                                        </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                               @deleteitem="deleteItem"></ConfirmatiomModal>
            <div class="col-12 ">
                <pagination :links="products.links" class="float-right"></pagination>
            </div>
        </div>
    </admin-layout>
</template>

<script>

import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import DeletedModal from "../SweetAlert/DeletedModal";

export default {

    name: "Dashboard",
    props: ['products', 'params'],
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
            searchItem: false,
            id: null,
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Products";
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


        avgRating(items) {
            let sum = 0;
            items.forEach(function (item) {
                let calculation = item.rating;
                sum += calculation;
            })
            return parseFloat(sum/items.length).toFixed(2);
        },
        // SumQty(items) {
        //     let sum = 0;
        //     items.forEach(function (item) {
        //         let calculation = item.quantity;
        //         sum += calculation;
        //     })
        //     return sum;
        // },

        resetQuery() {
            this.query = {}
            this.loadData()
        },
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {

            this.sweetAlert = false
            this.$inertia.delete(`/product-details/${this.itemId}`)
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
            this.query.id = '';
            this.query.name = '';
            this.query.sku = '';
            this.query.shipping_method = '';
            this.query.quantity = '';
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
            this.$inertia.visit(route('product-details.index'), {
                method: 'get',
                data: {
                    ...query
                }
            })
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
    }
}

</script>

<style scoped>
.tag {
    line-height: 1rem;
    margin-bottom: 0px !important;
    margin-top: 0px !important;
    padding-bottom: 11px !important;
    padding-top: 0px !important;
}

.product-name {
    width: 30% !important;
}

.star-rating {
    color: rgba(241, 166, 25, 0.993);
    display: inline-block;
    font-size: 1.5em;
    position: relative;
    transform: translate(-6px);
}

.star-rating__current {
    position: absolute;
    top: 0;
}

.star-rating__current {
    overflow: hidden;
    white-space: nowrap;
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

.product-image {
    margin-top: 5px;
}

img.rounded-circle.empty-image {
    height: 40px;
    margin-bottom: 3px;
    width: 45px;
    margin-top: 5px;
}

.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}

.popover-body {
    padding-bottom: 0px !important;
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


