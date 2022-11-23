<template>
    <admin-layout>
        <div class="row">

            <form action="/imports/store" class="dropzone" id="dropzone" encType="multipart/form-data">
                <input type="hidden" name="_token" ref="csrf-token" id="csrf-token" value=""/>
                <div class="fallback">
                    <input name="file" type="file" multiple/>
                </div>
            </form>

            <div class="col-12 px-0 pt-3" v-if="orders.data.length>0">
                <h6>Failed Imports</h6>
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="text-truncate t-header">Order#</th>
                                    <th class="text-truncate t-header">Channel Name</th>
                                    <th class="text-truncate t-header">file</th>
                                    <th class="text-truncate t-header">Product name</th>
                                    <td class="text-right text-small t-header"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="py-0 my-0" v-for="orderItem in orders.data">
                                    <td class="t-header text-truncate">{{ orderItem.order.order_number }}</td>
                                    <td class="t-header text-truncate">{{ orderItem.order.channel.name }}</td>
                                    <td class="t-header text-truncate">
                                        {{
                                            orderItem.order.import ? orderItem.order.import.file_name.substring(19) : ''
                                        }}
                                    </td>
                                    <td class="t-header text-truncate">
                                        {{ orderItem.product_id ? orderItem.product.name : orderItem.product_name }}
                                    </td>
                                    <td class="text-right text-small action pr-1">
                                        <a class="text-gray-500"
                                           :href="route('export.import.files',orderItem.order.import.id)">
                                          <span class="badge-circle badge-circle-light-secondary  action">
                                              <i class="bx bx-download font-medium-1 align-items-center text-center"></i>
                                          </span>
                                        </a>
                                        <span class="d-inline-flex align-items-center"
                                              @click="linkProduct(orderItem.id,orderItem.product_id)"
                                              data-toggle="modal"
                                              data-target="#order-modal">
                                           <span
                                               class="badge-circle badge-circle-light-secondary ">
                                             <i class="bx bxs-plus-circle font-medium-1 align-items-center text-center"></i>
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
            <div class="col-12 ">
                <pagination :links="orders.links" class="float-right"></pagination>
            </div>
            <div class="modal fade text-left"
                 id="order-modal" tabindex="-1"
                 role="dialog"
                 aria-labelledby="myModalLabel33"
                 aria-hidden="true">
                <div
                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold text-center"
                                id="myModalLabel33">
                                Link product </h4>
                            <button type="button"
                                    class="close"
                                    data-dismiss="modal"
                                    aria-label="Close">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <form @submit.prevent="submit"
                              class="form form-horizontal">
                            <div class="modal-body">

                                <label class="">Product name: <span class="ml-0.5">{{
                                        selected ? selected : ""
                                    }}</span></label>
                                <div class="form-group">

                                </div>
                                <div class="form-group">
                                    <select class="form-control" v-on:change="changeItem(form.product_id, $event)"
                                            v-model="form.product_id"
                                            id="product_id">
                                        <option>Select product</option>
                                        <option @change="onChange($event)" v-for="product in products"
                                                :value="product.id">{{ product.name }}
                                        </option>
                                    </select>
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
        </div>

    </admin-layout>
</template>
<script>

import AppLayout from '../../Layouts/AppLayout';
import JetActionMessage from '../../Jetstream/ActionMessage'
import JetButton from '../../Jetstream/Button'
import JetFormSection from '../../Jetstream/FormSection'
import JetInput from '../../Jetstream/Input'
import JetInputError from '../../Jetstream/InputError'
import JetLabel from '../../Jetstream/Label'
import AdminLayout from "../../Layouts/AdminLayout";
import Header from "../../admin/Header";
import Toastr from "../../components/Toastr";
import Pagination from "../../admin/Pagination";
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
    name: "Multiple",
    props: ['errors', 'orders', 'products'],

    components: {
        vueDropzone: vue2Dropzone,
        AdminLayout,
        AppLayout,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        Header,
        Toastr,
        Pagination
    },
    data() {
        return {
            form: this.$inertia.form({
                product_id: '',
                order_id: ''
            }),
            id: null,
            myDropZone: null,
            supervisorError: '',
            selected: '',
            rowId: 10,
            order: {},


            dropzoneOptions: {
                autoProcessQueue: false,
                timeout: 1000,
                addRemoveLinks: true,
                url: '/imports/store'
            },

        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Import";
    },
    mounted() {

        this.$refs["csrf-token"].value = $('meta[name="csrf-token"]').attr('content');
    },
    methods: {
        stopPropagation(e) {
            e.stopPropagation();
        },
        changeItem: function changeItem(productID, event) {
            var productName = this.products.find(product => product.id === productID);
            this.form.product_id = productID;
            this.selected = event.target.value = productName.name;
        },
        linkProduct(orderID, productID) {

            this.selected = '';
            this.form.order_id = orderID;
            this.form.product_id = '';
        },
        submit() {
            this.order = this.orders.data.find(order => order.id === this.form.order_id);
            let data = this.order;
            Object.assign(data, {
                '_method': 'PUT',
                'order_id': this.form.order_id,
                'product_id': this.form.product_id
            });
            this.form = this.$inertia.form(data);

            this.form.post(route('orders.update', this.order.id),
                {
                    onSuccess: () => {
                        $('#modal-hide').trigger('click');
                    },
                });

        },
        uploadSuccess(file, response) {
            this.fileName = response.file;
        },
        uploadError(file, message) {
        },
        fileRemoved() {
        }
    }
}
</script>
<style scoped>
.dropzone {
    min-width: 100%;
}

.t-header {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

.action {
    padding-top: 4px !important;
    padding-bottom: 4px !important;
}

/*.action {*/
/*    margin-right: 4px !important;*/
/*}*/

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



