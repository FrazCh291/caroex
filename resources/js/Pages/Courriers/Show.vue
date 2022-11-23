<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                        <div class="card invoice-print-area">
                            <div class="card-header pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">Courrier Company:</small>
                                <small class="text-muted">{{courrier.name}}</small>
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
                                                    Address
                                                </div>
                                            </div>
                                                <div class="col-2">
                                            <div class="col form-group pr-0 pb-1">
                                            <a :href="route('courrier.address.create', courrier.id)"
                                                class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1"
                                                data-repeater-create="">
                                            </a>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row"   v-if="courrier.addresses.length>0">
                                            <div class="row col-12 pr-0 ng-repeat-start" id="table-hover-row">
                                                <div class="col-12 pr-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-left custom-padding">Company Address</th>
                                                                        <th class="text-right custom-padding-right"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="truncate">
                                                                    <tr v-for="courier in courrier.addresses">
                                                                        <td class="custom-padding">
                         {{courier.address_1}} {{courier.address_2}}, {{courier.town}}, {{courier.city}}, {{courier.county}}, {{courier.postcode}}, {{courier.country}}
                                                                        </td>
                                                                        <td class="text-right custom-padding-right">
                                                                            <div class="dropdown">
                                                                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                    </span>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                    <a :href="route('address.edit',courier.id)" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                                    <a v-on:click="confirmDelete(courier.id)" class="dropdown-item"><i class="bx bx-trash mr-1"></i>Delete</a>
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
            <div class="col-sm-11 d-flex justify-content-start px-0">
                        <inertia-link
                          :href="route('courriers.index')"
                          type="button"
                          class="btn btn-secondary mr-1 mb-1">
                          Back
                        </inertia-link>
                      </div>
        </div>
    </admin-layout>
</template>

<script>
import moment from 'moment';
import Label from "../../Jetstream/Label";
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import {useForm} from '@inertiajs/inertia-vue3';
import AdminLayout from "../../Layouts/AdminLayout";
import JetInputError from "../../Jetstream/InputError";
import ErrorComponent from '../../components/ErrorComponent';
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {

    name: "show",
    props: ['courrier'],
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
        document.title = process.env.MIX_APP_NAME + " - Courrier Address";
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
        // submit() {
        //     if (this.update) {
        //         this.form.post(route('warehouse-containers.update', this.warehouseContainer.id))
        //     } else {
        //         this.form.warehouseContainer_id = this.warehouseContainer.id;
        //         this.form.post('/warehouse-containers/store', this.warehouseContainer.id);
        //         $('#addContext').modal('hide');
        //     }
        // },
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
            this.$inertia.delete(`/super/admin/addressdelete/${this.itemId}`)
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
