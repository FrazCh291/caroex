<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
            </div>
        </div>
        <div class="row pb-3" id="table-hover-row">

            <div class="col-12">
                <h5>Delivery</h5>
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="custom-padding">Date</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-center">Weight(kg)</th>
                                    <th class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="delivery in deliveries.data">
                                    <td class=" custom-padding">{{ delivery.date }}</td>
                                    <td class="text-center">{{ delivery.No_items }}</td>
                                    <td class="text-center">{{ delivery.weight }}</td>
                                    <td class="text-center"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <h5>Delivery Items</h5>
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="custom-padding">Delivery Method</th>
                                    <th class="text-center">Product</th>
                                    <th class="text-center">Delivery Address</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody v-for="delivery in deliveries.data">
                                <tr v-for="delivery_item in delivery.delivery_items">
                                    <td class=" custom-padding">{{ delivery_item.delivery_method }}</td>
                                    <td class="text-center">
                                        {{
                                            delivery_item.order_item.product ? delivery_item.order_item.product.name : ''
                                        }}
                                    </td>
                                    <td class="text-center">{{ delivery_item.order_item.order.shipping_address_1 }}</td>
                                    <!-- <td class="text-center">{{delivery_item.note}}</td> -->
                                    <td class="text-center">{{ delivery_item.status }}</td>
                                    <td class="text-right py-0 my-0 custom-padding-right">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-n2">
                <div class="col form-group ml-1">
                    <a :href="route('upload.manifests.file', this.tuffnelId)"
                       class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1"
                       data-repeater-create="">
                    </a>
                </div>
                <h5>Document</h5>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="text-left">File</th>
                                    <th class="text-left">Reporter Name</th>
                                    <th class="text-left">Date</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody v-for="delivery in deliveries.data">
                                <tr v-for="document in documents">
                                    <td class="text-left">
                                        <div class="d-flex align-items-center" v-if="document.file_type === 'pdf'">
                                            <div>

                                                <i class="bx bxs-file-pdf danger font-large-1 "></i>
                                            </div>
                                            <div>
                                                <span class="text-title-icon ">{{ remove(document.file) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center"
                                             v-else-if="document.file_type === 'csv'">
                                            <div>
                                                <i class="bx bxs-file success font-large-1 "></i>
                                            </div>
                                            <div>
                                                <span class="text-title-icon ">{{ remove(document.file) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center"
                                             v-else-if="document.file_type === 'docx'">
                                            <div>
                                                <i class="bx bxs-file-doc primary font-large-1 "></i>
                                            </div>
                                            <div>
                                                <span class="text-title-icon ">{{ remove(document.file) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center"
                                             v-else-if="document.file_type === 'txt'||'TXT'">
                                            <div>
                                                <i class="bx bxs-file-txt font-large-1  "></i>
                                            </div>
                                            <div>
                                                <span class="text-title-icon ">{{ remove(document.file) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center"
                                             v-else-if="document.file_type === 'png'">
                                            <div>
                                                <i class="bx bxs-file-png font-large-1 "></i>
                                            </div>
                                            <div>
                                                <span class="text-title-icon ">{{ remove(document.file) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center"
                                             v-else-if="document.file_type === 'xlsx'">
                                            <div>
                                                <i class="bx bxs-file-xlsx font-large-1 "></i>
                                            </div>
                                            <div>
                                                <span class="text-title-icon ">{{ remove(document.file) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">{{ document.user ? document.user.name : '' }}</td>
                                    <td class="text-left">{{ delivery ? delivery.date : '' }}</td>
                                    <td class="text-right py-0 my-0 custom-padding-right">
                                            <span class="d-inline-flex align-items-center">
                                                <a :href="route('export.manifests.data.file', document.id)">
                                                <span class="badge-circle badge-circle-light-secondary action">
                                                    <i class="bx bxs-download font-medium-1 align-items-center text-center"></i>
                                                </span>
                                               </a>
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
            <div class="col-12 d-flex">
                <div class="col-3">
                    <inertia-link :href="route('delivery.index')" type="button"
                                  class="btn btn-light-secondary mr-1 mb-1 ml-n1">
                        Back
                    </inertia-link>
                </div>
                <div class="col-6"></div>
                <div class="col-3">
                    <pagination :links="deliveries.links" class="float-right mr-n1"></pagination>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>

import AdminLayout from "../../../Layouts/AdminLayout";
import Button from "../../../Jetstream/Button"
import Pagination from "../../../admin/Pagination";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";
import DeletedModal from "../../SweetAlert/DeletedModal";

export default {

    name: "index",
    props: ['deliveries', 'tuffnelId', 'params', 'documents'],
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
        document.title = process.env.MIX_APP_NAME + " - Manifests";
    },
    mounted() {
        if (this.params) {
            Object.assign(this.query, this.params);
        }
    },
    methods: {
        check_one: function () {
            if (this.query.date = false) {
                this.query.date = true;
                this.query.consignment = [];
                this.query.No_items = [];
                this.query.weight = [];
                this.query.file_name = [];
                this.query.user_id = [];
                this.query.name = [];
            }
            if (this.query.user_id = false) {
                this.query.date = [];
                this.query.consignment = [];
                this.query.No_items = [];
                this.query.weight = [];
                this.query.file_name = [];
                this.query.user_id = true;
                this.query.name = [];
            }
            if (this.query.consignment = false) {
                this.query.date = [];
                this.query.consignment = true;
                this.query.No_items = [];
                this.query.weight = [];
                this.query.file_name = [];
                this.query.user_id = [];
                this.query.name = [];
            }

            if (this.query.No_items = false) {
                this.query.date = [];
                this.query.consignment = [];
                this.query.No_items = true;
                this.query.weight = [];
                this.query.file_name = [];
                this.query.user_id = [];
                this.query.name = [];
            }

            if (this.query.file_name = false) {
                this.query.date = [];
                this.query.consignment = [];
                this.query.No_items = [];
                this.query.weight = [];
                this.query.file_name = true;
                this.query.user_id = [];
                this.query.name = [];
            }

            if (this.query.name = false) {
                this.query.date = [];
                this.query.consignment = [];
                this.query.No_items = [];
                this.query.weight = [];
                this.query.file_name = [];
                this.query.user_id = [];
                this.query.name = true;
            }

            if (this.query.weight = false) {
                this.query.date = [];
                this.query.consignment = [];
                this.query.No_items = [];
                this.query.weight = true;
                this.query.file_name = [];
                this.query.user_id = [];
                this.query.name = [];
            }

        },
        remove(fileName) {
            let name = fileName.substring(5, fileName.length - 4);
            return name;
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
            this.$inertia.delete(`/fulfilment/del/manifest/${this.itemId}`)
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
            this.$inertia.visit(route('manifests.view'), {
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
.custom-padding {
    padding-left: 24px;
}

.custom-padding-right {
    padding-right: 24px;
}

.action {
    margin-right: 4px !important;
    margin-bottom: 10px !important;
    margin-top: 10px !important;
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
