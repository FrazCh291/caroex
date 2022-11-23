<template>
    <admin-layout>
        <section class="invoice-view-wrapper">
                <!-- <h5 class="mb-n1">Picking List</h5> -->
              <div class="col-12">
                <h5 class="font-weight-bold">Picking List ({{pickingLists.date}})</h5>
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="custom-padding">product</th>
                                    <th class="text-center">Sku</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="pickingList in pickingLists.products">
                                    <td class=" custom-padding">{{pickingList.name}}</td>
                                    <td class="text-center">{{pickingList.sku}}</td>
                                    <td class="text-center">{{pickingList.total_quantity}}</td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th class="text-center text-bold">{{sum()}}</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
          <div class="col-3">
            <inertia-link :href="route('delivery.index')" type="button"
            class="btn btn-light-secondary mr-1 mb-1">
            Back
        </inertia-link>
        </div>
    </admin-layout>
</template>

<script>

import AdminLayout from "../../../Layouts/AdminLayout";
import Button from "../../../Jetstream/Button"
import Pagination from "../../../admin/Pagination";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";
import DeletedModal from "../../SweetAlert/DeletedModal";
import ErrorComponent from '../../../components/ErrorComponent'

export default {

    name: "Show",
    props: ['pickingLists'],
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
        document.title = process.env.MIX_APP_NAME + " - Picking List Show";
    },
    mounted() {
        if (this.params) {
            Object.assign(this.query, this.params);
        }
    },
    methods: {
        sum(){
          const array = this.pickingLists.products;
            let sum = 0;
            for (let i = 0; i < array.length; i++) {
               sum += parseInt(array[i].total_quantity);
            }
          return sum;
        },

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
