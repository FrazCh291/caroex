<template>
    <admin-layout>
        <section class="invoice-view-wrapper">
            <div class="col-12 pl-0">
                <h5 class="card-title mb-0 pt-0">Invoice# {{invoice.id}}</h5>
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-12 col-12 mt-1">
                    <div class="card invoice-print-area mb-0">
                        <div class="card-body mx-25 pb-1">
                            <div class="row invoice-info pr-0 mr-0">
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Name</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="padding-change">{{ invoice.invoiceable.name }}</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Tax</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="padding-change">{{ invoice.tax }}</p>
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Shippment From</p>
                                    </div>
                                    <!-- <div class="col-md-8">
                                        <p class="padding-change">{{ (invoice.addresses.address_1 ?
                                            invoice.addresses.address_1 : '') +
                                            (invoice.addresses.town  ? " " +
                                            invoice.addresses.town  : '') +
                                            (invoice.addresses.city  ? " " +
                                            invoice.addresses.city  : '') +
                                            (invoice.addresses.country  ? " " +
                                            invoice.addresses.country  : '') }}</p>
                                    </div> -->
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Discount</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="padding-change">{{ invoice.discount_total }}</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Shippment To</p>
                                    </div>
                                    <!-- <div class="col-md-8">
                                        <p class="padding-change">{{ (invoice.addressess.address_1 ?
                                            invoice.addressess.address_1 : '') +
                                            (invoice.addressess.town  ? " " +
                                            invoice.addressess.town  : '') +
                                            (invoice.addressess.city  ? " " +
                                            invoice.addressess.city  : '') +
                                            (invoice.addressess.country  ? " " +
                                            invoice.addressess.country  : '') }}</p>
                                    </div> -->
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Amount</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="padding-change">{{ invoice.amount }}</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Shipping Cost</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="padding-change">{{ invoice.shipping_cost }}</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Amount Paid</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="padding-change">{{ invoice.amount_paid }}</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Transaction#</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="padding-change">{{ invoice.transaction_id }}</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Due Date</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="padding-change">{{ formatDate(invoice.due_date) }}</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Note</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="padding-change">{{ invoice.notes }}</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Status</p>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-0">
                                            <span v-if="invoice.status === 'paid'"
                                                  class="badge badge-light-success badge-pill">Paid</span>
                                            <span v-if="invoice.status === 'partial_paid'"
                                                  class="badge badge-light-warning badge-pill">Partial Paid</span>
                                            <span v-if="invoice.status === 'pending'"
                                                  class="badge badge-light-danger badge-pill">Pending</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                </div>
                                <div class="col-6 col-md-6 d-flex">
                                    <div class="col-md-4">
                                        <p class="padding-change">Sent</p>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-0">
                                            <span v-if="invoice.is_sent == true"
                                                  class="badge badge-light-success badge-pill">
                                                <i class="bx bx-check font-medium-1"></i></span>
                                            <span v-else class="badge badge-light-danger badge-pill">
                                                <i class="bx bx-x font-medium-1"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 pt-2 pl-0 pr-0 pb-0">
                <div data-v-3b708b6e="" class="row pb-0.5">
                    <div class="col-10">
                        <h5 class="card-title mb-0 pt-1">
                            Invoice Items</h5></div>
                    <div class="col-2">
                        <!-- <div class="col form-group pr-0 pb-1">
                            <a :href="route('invoice-item.create',[name,id,invoice.id])"
                               class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1">
                            </a>
                        </div> -->
                    </div>
                </div>
                <div class="card border-0 mb-0" v-if="invoiceItems.length>0">
                    <div class="card mb-0 pb-0">
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th class="pl-1 py-0 my-0 text-truncate t-header">Item Name</th>
                                        <!-- <th class="text-center py-0 my-0 text-truncate t-header">Carton</th> -->
                                        <th class="text-center py-0 my-0 text-truncate t-header">Quantity</th>
                                        <th class="text-center py-0 my-0 text-truncate t-header">Total Quantity</th>
                                        <th class="text-center py-0 my-0 text-truncate t-header">Unit Price</th>
                                        <th class="text-center py-0 my-0 text-truncate t-header">Total Price</th>
                                        <th class="text-right py-0 my-0 text-truncate t-header"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="invoiceItem in invoiceItems">
                                        <td class="py-0 my-0">{{invoiceItem.item_name}}</td>
                                        <!-- <td class="text-center py-0 my-0">{{invoiceItem.carton}}</td> -->
                                        <td class="text-center py-0 my-0">{{invoiceItem.quantity}}</td>
                                        <td class="text-center py-0 my-0">{{invoiceItem.total_quantity}}</td>
                                        <td class="text-center py-0 my-0">{{invoiceItem.unit_price}}</td>
                                        <td class="text-center py-0 my-0">{{invoiceItem.total_price}}</td>
                                        <td class="text-right text-small action pr-1 px-0">
                                            <!-- <inertia-link :href="route('invoice-item.edit',[name,id,invoice.id,invoiceItem.id])">
                                                <span class="badge-circle badge-circle-light-secondary  action">
                                                    <i class="bx bx-edit font-medium-1 align-items-center text-left">
                                                    </i>
                                                </span>
                                            </inertia-link> -->
                                            <!-- <button v-on:click="confirmDelete(invoiceItem.id)">
                                                    <span class="badge-circle badge-circle-light-secondary ml-1/6">
                                                        <i class="bx bx-trash font-medium-1 text-left"></i>
                                                    </span>
                                            </button> -->
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12 d-flex justify-content-end pt-1 pb-1 pr-0">
                        <a :href="route('invoice.export.pdf',{'invoice_id': invoice.id})">
                            <button class="btn border px-1 line-height font-small font-weight-normal"
                                    type="button">
                                <i class="bx bx-xs bx-download pr-0.5 pb-0.5"></i><span
                                class="pl-0.5 pt-3">PDF</span>
                            </button>
                        </a>
                    </div> -->
                </div>
                <!-- <div class="col-sm-11 px-0 py-0">
                    <inertia-link type="button" :href="route(name+'.show', id)"
                                  class="btn btn-light-secondary mr-1 mb-1">Back</inertia-link>
                </div> -->
                <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                                   @deleteitem="deleteItem">
                </ConfirmatiomModal>
            </div>
        </section>
    </admin-layout>
</template>

<script>
     import moment from 'moment';
    import AdminLayout from "../../Layouts/AdminLayout";
    import Label from "../../Jetstream/Label";
    import JetInputError from './../../Jetstream/InputError';
    import ErrorComponent from '../../components/ErrorComponent';
    import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";



    export default {
        name: "Create",
        props: ['id', 'name', 'invoice', 'invoiceItems'],
        components: {
            Label,
            AdminLayout,
            JetInputError,
            ErrorComponent,
            ConfirmatiomModal,
        },
        data() {
            return {
                sweetAlert: false,
                itemId: '',
                searchItem: false
            }
        },
        beforeMount() {
            document.title = process.env.MIX_APP_NAME + " - Invoice Details";
            console.log(this.invoice , 'invices')
            console.log(this.invoiceItems , 'invoiceItem')
        },
        methods: {
            formatDate(date) {
                return moment(date).format('DD/MM/YYYY');
            },
            stopPropagation(e) {
                e.stopPropagation();
                this.submit();
                this.sweetAlert = false
            },
            Clicked() {
                this.sweetAlert = false
            },
            deleteItem() {
                this.sweetAlert = false
                this.$inertia.delete(`/erp/invoiceitems/${this.itemId}`)
            },
            confirmDelete(id) {
                this.sweetAlert = true;
                this.itemId = id;
            }
        }
    }
</script>

<style scoped>

    .line {
        border-top: 1px dashed #C7CFD6;
        width: 100%;
    }

    .error {
        margin-top: 0px !important;
    }

    .t-header {
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }

    .action {
        padding-top: 8px !important;
        padding-bottom: 8px !important;
    }

    .text-small {
        font-size: 14px !important;
    }

    .card {
        border: 1px solid #d2d6dc;
        border-radius: 0px !important;
        height: auto !important;
    }

    table thead th {
        vertical-align: bottom;
        border-bottom: 1px solid #d2d6dc;
    }

    .text-title-icon {
        vertical-align: super;
    }

</style>
