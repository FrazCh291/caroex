<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                        <div class="card invoice-print-area">
                            <div class="card-header pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">1st Name:</small>
                                <small class="text-muted">Khurram</small>
                            </div>
                            <div class="card-header pt-0 mt-0 pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">2nd Namw:</small>
                                <small class="text-muted">Azhar</small>
                            </div>
                            <div class="px-2">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body pb-2 mx-25 px-2">
                                    <div>
                                        <div class="row pb-0.5">
                                            <div class="col-10">
                                                <div class="mb-0 pt-1 lg:font-bold">
                                                    Context
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="col form-group pr-0 pb-1">
                                                    <i class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1"
                                                       data-toggle="modal"
                                                       data-target="#contextForm" @click="addContext">
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="row col-12 pr-0 ng-repeat-start" id="table-hover-row">
                                                <div class="col-12 pr-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-left custom-padding">1st Name #</th>
                                                                        <th class="">2nd Name</th>
                                                                        <th class="">Frame Work</th>
                                                                        <th class="">Language</th>
                                                                        <th class="">Work</th>
                                                                        <th class="text-right custom-padding-right"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="truncate">
                                                                    <tr>
                                                                        <td class=" py-0 my-0 custom-padding">
                                                                            Khurram
                                                                        </td>
                                                                        <td class=" py-0 my-0">
                                                                           Azhar
                                                                        </td>
                                                                        <td class=" py-0 my-0">
                                                                            Laravel
                                                                        </td>
                                                                        <td class=" py-0 my-0">
                                                                            Php
                                                                        </td>
                                                                        <td class=" py-0 my-0">
                                                                           Developer
                                                                        </td>
                                                                        <td class="text-right py-0 my-0 custom-padding-right">
                                                                            <inertia-link>
                                                                                <span
                                                                                    class="badge-circle badge-circle-light-secondary  action">
                                                                                    <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                                                                </span>
                                                                            </inertia-link>
                                                                            <button
                                                                                v-on:click="confirmDelete(warehouse_container_contex.id)">
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

            <div class="modal fade text-left"
                 id="addContext" tabindex="-1"
                 role="dialog"
                 aria-labelledby="myModalLabel33"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold"
                                id="myModalLabel33">
                                Add Context </h4>
                            <button type="button"
                                    class="close"
                                    data-dismiss="modal"
                                    aria-label="Close">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <form @submit.prevent="submit" class="form form-horizontal">
                            <div class="modal-body">
                                <label>Warehouse Name *</label>
                                <div class="form-group">
                                    <select class="form-control" name="warehouse_id" v-model="form.warehouse_id">
                                        <option></option>
                                        <option v-for="warehouse in warehouses" :value="warehouse.id">
                                            {{ warehouse.name }}
                                        </option>
                                        <ErrorComponent input="name"></ErrorComponent>
                                    </select>
                                </div>
                                <label>Product Name *</label>
                                <div class="form-group">
                                    <select class="form-control" name="product_id" v-model="form.product_id">
                                        <option></option>
                                        <option v-for="product in products" :value="product.id">
                                            {{ product.name }}
                                        </option>
                                        <ErrorComponent input="name"></ErrorComponent>
                                    </select>
                                </div>
                                <label>Bill Of Lading Number *</label>
                                <div class="form-group">
                                    <input name="bill_of_lading_no" v-model="form.bill_of_lading_no" type="text"
                                           class="form-control">
                                    <ErrorComponent input="bill_of_lading_no"></ErrorComponent>
                                </div>
                                <label>Quantity *</label>
                                <div class="form-group">
                                    <input name="quantity" v-model="form.quantity" type="text" class="form-control">
                                    <ErrorComponent input="quantity"></ErrorComponent>
                                </div>
                                <label>Corton *</label>
                                <div class="form-group">
                                    <input name="ctn" v-model="form.ctn" type="text" class="form-control">
                                    <ErrorComponent input="ctn"></ErrorComponent>
                                </div>
                                <label>Unit Price *</label>
                                <div class="form-group">
                                    <input name="unit_price" v-model="form.unit_price" type="text" class="form-control">
                                    <ErrorComponent input="unit_price"></ErrorComponent>
                                </div>
                                <label>Total Amount *</label>
                                <div class="form-group">
                                    <input name="total_amount" v-model="form.total_amount" type="text"
                                           class="form-control">
                                    <ErrorComponent input="total_amount"></ErrorComponent>
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

import AdminLayout from "../../../Layouts/AdminLayout";
import Button from "../../../Jetstream/Button"
import Pagination from "../../../admin/Pagination";
import {useForm} from '@inertiajs/inertia-vue3';
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";
import Label from "../../../Jetstream/Label";
import JetInputError from "../../../Jetstream/InputError";
import ErrorComponent from '../../../components/ErrorComponent';

export default {

    name: "show",
    props: ['sample'],
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
            company_id: '',
            warehouse_conteiner_id: '',
            bill_of_lading_no: '',
            warehouse_id: '',
            product_id: '',
            quantity: '',
            ctn: '',
            unit_price: '',
            total_amount: ''

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
            sweetAlert: false,
            itemId: '',
            searchItem: false
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Sample";
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
        submit() {
            if (this.update) {
                this.form.post(route('warehouse-containers.update', this.warehouseContainer.id))
            } else {
                this.form.warehouseContainer_id = this.warehouseContainer.id;
                this.form.post('/warehouse-containers/store', this.warehouseContainer.id);
                $('#addContext').modal('hide');
            }
        },
        addContext() {
            $('#addContext').modal('show');
            this.form.warehouseContainer_id = this.warehouseContainer.id;
            this.form = this.$inertia.form({
                warehouse_container_id: this.warehouseContainer.id,
                company_id: '',
                bill_of_lading_no: '',
                warehouse_id: '',
                product_id: '',
                quantity: '',
                ctn: '',
                unit_price: '',
                total_amount: ''
            });
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
            this.$inertia.delete(`/warehouse_container/${this.itemId}`)
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
    }
}

/*export default {*/
/*    name: "Show",*/
/*    props: ['warehouseContainer','products','warehouses'],*/
/*    components: {*/
/*        Label,*/
/*        AdminLayout,*/
/*        JetInputError,*/
/*        ErrorComponent,*/
/*    },*/
/*    setup() {*/
/*        const form = useForm({*/
/*            bill_of_lading_no: '',*/
/*            warehouse_id: '',*/
/*            product_id: '',*/
/*            quantity: ''*/
/*        })*/
/*        return {form}*/
/*    },*/
/*    data() {*/
/*        return {}*/
/*    },*/
/*    beforeMount() {*/
/*        document.title = process...env.MIX_APP_NAME + " - Create Product";*/
/*        if (this.product) {*/
/*            this.update = true;*/
/*            let data = this.product;*/
/*            Object.assign(data, {*/
/*                '_method': 'PUT',*/
/*            })*/
/*            this.form = this.$inertia.form(data);*/
/*        }*/
/*    },*/
//     methods: {
//         submit() {
//             if (this.update) {
//                 this.form.post(route('product-details.update', this.product.id))
//             } else {
//                 this.form.post('/warehouse-containers/store')
//             }
//         },
//     }
// }


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
