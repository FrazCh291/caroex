<template>
    <div>
        <admin-layout>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                        <div class="card invoice-print-area">
                            <div class="card-header pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">Container Number:</small>
                                <small class="text-muted">{{ warehouseContainer.container_no }}</small>
                            </div>
                            <div class="card-header pt-0 mt-0 pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">Ordered Date:</small>
                                <small class="text-muted">{{
                                        formatDate(warehouseContainer.container_ordered_at)
                                    }}</small>
                            </div>
                            <div class="px-2">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body pb-2 mx-25 px-2">
                                    <div>
                                        <div class="row pb-0.5">
                                            <div class="col-10">
                                                <div class="mb-0 pt-0.5 lg:font-bold">
                                                    Documents
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="col form-group pr-0 pb-0.5">
                                                    <inertia-link
                                                        :href="route('container.file.create',warehouseContainer.id)"
                                                        data-repeater-create="">
                                                        <i class="bx bxs-plus-circle pt-0.5 primary float-right add-btn font-large-1"> </i>
                                                    </inertia-link>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" v-if="warehouseContainer.documents.length>0">
                                            <div class="row col-12 pr-0 ng-repeat-start">
                                                <div class="col-12 pr-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="">Title</th>
                                                                        <th class="text-center">File</th>
                                                                        <th class="text-center">Description</th>
                                                                        <th class="text-right"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="truncate">

                                                                    <tr v-for="document in warehouseContainer.documents">
                                                                        <td class="text-left cursor-pointer px-1 py-0 my-0 text-truncate">
                                                                            <div v-if="document.file_type === 'pdf'">
                                                                                <a :href="route('view.container.file',[warehouseContainer.id,document.id])">
                                                                                    <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                                                </a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                            <div
                                                                                v-else-if="document.file_type === 'csv'">
                                                                                <a :href="route('view.container.file',[warehouseContainer.id,document.id])">
                                                                                    <i class="bx bxs-file success font-large-1"></i>
                                                                                </a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                            <div
                                                                                v-else-if="document.file_type === 'docx'">
                                                                                <a :href="route('view.container.file',[warehouseContainer.id,document.id])">
                                                                                    <i class="bx bxs-file-doc primary font-large-1"></i>
                                                                                </a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                            <div
                                                                                v-else-if="document.file_type === 'txt'||'TXT'">
                                                                                <a :href="route('view.container.file',[warehouseContainer.id,document.id])">
                                                                                    <i class="bx bxs-file-txt font-large-1"></i>
                                                                                </a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                            <div
                                                                                v-else-if="document.file_type === 'png'">
                                                                                <a :href="route('view.container.file',[warehouseContainer.id,document.id])">
                                                                                    <i class="bx bxs-file-png font-large-1"></i>
                                                                                </a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                            <div
                                                                                v-else-if="document.file_type === 'xlsx'">
                                                                                <a :href="route('view.container.file',[warehouseContainer.id,document.id])">
                                                                                        <i class="bx bxs-file-xlsx font-large-1"></i>
                                                                                </a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center py-0 my-0 truncate">
                                                                            {{ document.file.substring(18) }}
                                                                        </td>
                                                                        <td class="text-center py-0 my-0 truncate">
                                                                            {{ document.description }}
                                                                        </td>
                                                                        <td class="text-right py-0 my-0 truncate">
                                                                            <a :href="route('export.container.file',[warehouseContainer.id, document.id])">
                                                                                <span
                                                                                    class="badge-circle badge-circle-light-secondary action">
                                                                                    <i class="bx bx-download font-medium-1 align-items-center text-center"></i>
                                                                                </span>
                                                                            </a>
                                                                            <inertia-link
                                                                                :href="route('container.file.edit', [warehouseContainer.id, document.id])"
                                                                                data-repeater-create="">
                                                                                <span
                                                                                    class="badge-circle badge-circle-light-secondary  action">
                                                                                     <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                                                                </span>
                                                                            </inertia-link>
                                                                            <button
                                                                                v-on:click="confirmDeletedoc(document.id)">
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
                                    <div>
                                        <div class="row pb-0.5 ">
                                            <div class="col-10">
                                                <div class="mb-0 pt-0.5 lg:font-bold">
                                                    Context
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="col form-group pr-0 pb-0.5">
                                                    <inertia-link
                                                        :href="route('containers.addcontext',warehouseContainer.id)"
                                                        data-repeater-create="">
                                                        <i class="bx bxs-plus-circle pt-0.5 primary float-right add-btn font-large-1"> </i>
                                                    </inertia-link>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" v-if="warehouseContainer.warehouse_container_context.length>0">
                                            <div class="row col-12 pr-0 ng-repeat-start" id="table-hover-row">
                                                <div class="col-12 pr-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="">Lading Bill #</th>
                                                                        <th class="">Product</th>
                                                                        <th class="">Warehouse</th>
                                                                        <th class="text-center">Quantity</th>
                                                                        <th class="text-center">Corton</th>
                                                                        <th class="text-right">Unit Price</th>
                                                                        <th class="text-right">Total Amount</th>
                                                                        <th class="text-right"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="truncate">
                                                                    <tr v-for="warehouse_container_contex in warehouseContainer.warehouse_container_context">
                                                                        <td class="py-0 my-0 truncate">
                                                                            {{
                                                                                warehouse_container_contex.bill_of_lading_no
                                                                            }}
                                                                        </td>
                                                                        <td class="py-0 my-0">
                                                                            {{
                                                                                warehouse_container_contex.product.name
                                                                            }}
                                                                        </td>
                                                                        <td class="py-0 my-0">
                                                                            {{
                                                                                warehouse_container_contex.warehouse.name
                                                                            }}
                                                                        </td>
                                                                        <td class="text-center py-0 my-0">
                                                                            {{ warehouse_container_contex.quantity }}
                                                                        </td>
                                                                        <td class="text-center py-0 my-0">
                                                                            {{ warehouse_container_contex.ctn }}
                                                                        </td>
                                                                        <td class="text-right py-0 my-0">
                                                                            {{ warehouse_container_contex.unit_price }}
                                                                        </td>
                                                                        <td class="text-right py-0 my-0">
                                                                            {{
                                                                                warehouse_container_contex.total_amount
                                                                            }}
                                                                        </td>
                                                                        <td class="text-right py-0 my-0">
                                                                            <inertia-link
                                                                                :href="route('container.context.edit',[warehouseContainer.id ,warehouse_container_contex.id])"
                                                                                data-repeater-create="">
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
                                                                    <tfoot class="my-0 mx-0">
                                                                    <tr>
                                                                        <!--                                                                        <th colspan="2"><span>Total :</span></th>-->
                                                                        <td class="border-top lg:font-bold py-1 my-1">
                                                                            <h5>Total:</h5>
                                                                        </td>
                                                                        <td class="text-center border-top py-0 my-0">
                                                                            <strong></strong></td>
                                                                        <td class="text-center border-top py-0 my-0">
                                                                            <strong></strong></td>
                                                                        <td class="text-center border-top py-0 my-0">
                                                                            <strong>{{ quantity }}</strong></td>
                                                                        <td class="text-center border-top py-0 my-0">
                                                                            <strong>{{ ctn }}</strong></td>
                                                                        <td class="text-right border-top py-0 my-0">
                                                                            <strong>£{{ unitprice }}</strong></td>
                                                                        <td class="text-right border-top py-0 my-0">
                                                                            <strong>£{{ totalamount }}</strong></td>
                                                                        <td class="text-right border-top py-0 my-0"></td>
                                                                    </tr>
                                                                    </tfoot>
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
                            <div class="col-sm-11 d-flex justify-content-start px-0 pt-0 mt-0 ml-2">
                                <inertia-link :href="route('containers.index')" type="button"
                                              class="btn btn-light-secondary mr-1 mb-1">
                                    Back
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </admin-layout>
    </div>
</template>
<script>
import moment from 'moment';
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import {useForm} from '@inertiajs/inertia-vue3';
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import JetInputError from "../../Jetstream/InputError";
import ErrorComponent from '../../components/ErrorComponent';

export default {

    name: "show",
    props: ['warehouseContainer', 'products', 'warehouses', 'companies', 'unitprice', 'totalamount', 'quantity', 'ctn'],
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
            ErrorComponent: false,
            sweetAlert: false,
            itemId: '',
            docId: '',
            searchItem: false,
            editDoc: false,
            editCon: false,
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - warehouseContainer";
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
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        addContext() {
            this.form.warehouseContainer_id = this.warehouseContainer.id;
            this.form.post('/containers/addcontext', this.warehouseContainer.id);

        },
        addDocuments() {
            this.form.warehouseContainer_id = this.warehouseContainer.id;
            this.form.post('/containers/files/create', this.warehouseContainer.id);

        },
        resetQuery() {
            this.query = {}
            this.loadData()
        },
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            if (this.itemId) {
                this.sweetAlert = false
                this.$inertia.delete(`/fulfilment/containers/{id}/content/delete/${this.itemId}`)
            }
            if (this.docId) {
                this.sweetAlert = false
                this.$inertia.delete(`/fulfilment/containers/{id}/files/delete/${this.docId}`)
            }
        },
        confirmDelete(id) {
            this.context = true
            this.sweetAlert = true;
            this.itemId = id;
            this.docId = '';
        },
        confirmDeletedoc(id) {
            this.sweetAlert = true;
            this.docId = id;
            this.itemId = '';
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
</script>

<style scoped>

.action {
    margin-right: 4px !important;
    margin-top: 8px !important;
    margin-bottom: 8px !important;
}

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
}

.text-title-icon {
    vertical-align: super;
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
