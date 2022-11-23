<template>
    <div>
        <admin-layout>
            <section class="invoice-view-wrapper">
                <div class="col-12 px-0">
                    <h5 class="card-title mb-0 pt-0">Supplier Info</h5>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-12 mt-1">
                        <div class="card invoice-print-area mb-0">
                            <div class="card-body mx-25 pb-1">
                                <div class="row invoice-info pr-0 mr-0">
                                    <div class="col-lg-3 col-md-8 col-sm-6 col-9">
                                        <div class="mb-0 title-col ">
                                            <p class="padding-change">Name</p>
                                        </div>
                                        <div class="mb-0 title-col ">
                                            <p class="padding-change">Email</p>
                                        </div>
                                        <div class="mb-0 title-col ">
                                            <p class="padding-change">Phone</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change">Country</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change">Address</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-md-4 col-3">
                                        <div>
                                            <div class="mb-0">
                                                <p class="padding-change">{{ supplier?.name }}</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="padding-change">{{ supplier?.email }}</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="">{{ supplier?.phone }}</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="padding-change">{{ supplier.lookup.value }}</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="padding-change">
                                                    {{
                                                        (supplier?.address_1 ? supplier?.address_1 : '')
                                                        + (supplier?.address_2 ? ", " + supplier?.address_2 : '')
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-8 col-sm-6 col-9">
                                        <p class="padding-change">City</p>
                                        <div class="mb-0">
                                            <p class="padding-change">State</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change">Post Code</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change">Status</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-md-4 col-3">
                                        <div>
                                            <div class="mb-0">
                                                <p class="padding-change">{{ supplier?.city }}</p>
                                            </div>
                                            <div class="mb-0">
                                            </div>
                                            <p class="padding-change">{{ supplier?.state }}</p>
                                            <div class="mb-0">
                                                <p class="padding-change">{{
                                                        supplier?.postal_code
                                                    }}</p>
                                            </div>
                                            <div class="mb-0">
                                                <span v-if="supplier.status == 1"
                                                      class="badge badge-light-success badge-pill">Active</span>
                                                <span v-else class="badge badge-light-danger badge-pill">Inactive</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 pt-2">
                        <div data-v-3b708b6e="" class="row pb-0.5">
                            <div class="col-10">
                                <h5 class="card-title mb-0 pt-1">
                                    Documents</h5></div>
                            <div class="col-2">
                                <div class="col form-group pr-0 pb-1">
                                    <a :href="route('supplier.file.create',supplier.id)"
                                       class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0" v-if="supplier.documents.length>0">
                            <div class="card">
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr>
                                                <th class="text-left pl-1 py-0 my-0 text-truncate t-header">
                                                    Title
                                                </th>
                                                <th class="text-center py-0 my-0 text-truncate t-header">
                                                    File
                                                </th>
                                                <th class="text-center py-0 my-0 text-truncate t-header">
                                                    Description
                                                </th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="document in documents"
                                                class="py-0 my-0">
                                                <td class="text-left cursor-pointer px-1 py-0 my-0 text-truncate">
                                                    <div v-if="document.file_type === 'pdf'">
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'csv'">
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file success font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'docx'">
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file-doc primary font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'txt'">
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file-txt font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'jpg'">
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file-jpg font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'png'">
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file-png font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>

                                                    <div v-else-if="document.file_type === 'PDF'">
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'CSV'">
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file success font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'DOCX'">
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file-doc primary font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'JPG'">
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file-jpg font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'PNG'">
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file-png font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else>
                                                        <a :href="route('supplier.view.files',document.id)">
                                                            <i class="bx bxs-file-image font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>

                                                </td>
                                                <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                    {{ document.file.substring(18) }}
                                                </td>
                                                <td class="text-center small cursor-pointer py-0 my-0 text-truncate">
                                                    {{ document.description }}
                                                </td>
                                                <td class="text-right text-small action pr-1">
                                                    <a :href="route('supplier.export.files',document.id)">
                                                    <span class="badge-circle badge-circle-light-secondary action">
                                                        <i class="bx bx-download font-medium-1 align-items-center text-center"></i>
                                                    </span>
                                                    </a>
                                                    <inertia-link :href="route('supplier.file.edit', document.id)">
                                                <span class="badge-circle badge-circle-light-secondary  action">
                                                    <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                                </span>
                                                    </inertia-link>
                                                    <button v-on:click="confirmDelete(document.id)">
                                                    <span class="badge-circle badge-circle-light-secondary ml-1/6">
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
                    <div class="col-12 pt-2">
                        <div data-v-3b708b6e="" class="row pb-0.5">
                            <div class="col-10">
                                <h5 class="card-title mb-0 pt-1">
                                    Invoices</h5></div>
                            <div class="col-2">
                                <div class="col form-group pr-0 pb-1">
                                    <a :href="route('invoice.create',['suppliers',supplier.id])"
                                       class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 mb-0" v-if="supplier.invoices.length>0">
                            <div class="card">
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr class="pl-0">
                                                <th class="pl-1 py-0 my-0 text-truncate t-header">Invoice#</th>
                                                <th class="text-center py-0 my-0 text-truncate t-header">Shippment Addresses</th>
                                                <th class="text-center py-0 my-0 text-truncate t-header">Amount</th>
                                                <th class="text-center py-0 my-0 text-truncate t-header">Due Date</th>
                                                <th class="text-center py-0 my-0 text-truncate t-header">Status</th>
                                                <th class="text-right py-0 my-0 text-truncate t-header"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="invoice in supplier.invoices">
                                                <td class="py-0 my-0"
                                                    @click="hideTooltip(invoice.id)">{{invoice.id}}</td>
                                                <td class="text-truncate text-center" v-if="invoice.addresses.address_1.length>10">
                                                     <span data-placement="bottom" :data-toggle="invoice.id"
                                                           @click="showTooltip(invoice.id)" data-container="body"
                                                           type="button" data-html="true" href="#" id="login">
                                                    <span class="underline-dotted border-gray">
                                                        {{invoice.addresses.address_1.substring(0, 15)}}
                                                    </span>
                                                    </span>
                                                    <div class="container">
                                                        <div :id="'popover-content-'+invoice.id" class="d-none">
                                                            <div class="row custom-popover popover-max">
                                                                <div class="col-12 px-2">
                                                                    <span v-if="invoice.addresses.address_1">
                                                                        <span class="font-weight-bold h5 mb-1 small">
                                                                            Shippment From
                                                                        </span>
                                                                        <br>
                                                                        <p class="py-0 mb-0 small">
                                                                            {{ (invoice.addresses.address_1 ?
                                                                            invoice.addresses.address_1 : '') +
                                                                            (invoice.addresses.town  ? " " +
                                                                            invoice.addresses.town  : '') +
                                                                            (invoice.addresses.city  ? " " +
                                                                            invoice.addresses.city  : '') +
                                                                            (invoice.addresses.country  ?
                                                                            invoice.addresses.country  : '') }}
                                                                        </p>
                                                                    </span>
                                                                    <span v-if="invoice.addressess.address_1">
                                                                        <span class="font-weight-bold h5 mb-1 small">
                                                                            Shippment To
                                                                        </span>
                                                                        <br>
                                                                        <p class="py-0 mb-0 small">
                                                                            {{ (invoice.addressess.address_1 ?
                                                                            invoice.addressess.address_1 : '') +
                                                                            (invoice.addressess.town  ? " " +
                                                                            invoice.addressess.town  : '') +
                                                                            (invoice.addressess.city  ? " " +
                                                                            invoice.addressess.city  : '') +
                                                                            (invoice.addressess.country  ?
                                                                            invoice.addressess.country  : '') }}
                                                                        </p>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center py-0 my-0"
                                                    @click="hideTooltip(invoice.id)">{{invoice.amount}}</td>
                                                <td class="text-center py-0 my-0"
                                                    @click="hideTooltip(invoice.id)">
                                                    {{formatDate(invoice.due_date)}}</td>
                                                <td class="text-center py-0 my-0"
                                                @click="hideTooltip(invoice.id)">
                                                    <span v-if="invoice.status === 'paid'" class="badge
                                                    badge-light-success badge-pill" @click="hideTooltip(invoice.id)">
                                                        Paid</span>
                                                    <span v-if="invoice.status === 'partial_paid'" class="badge
                                                    badge-light-warning badge-pill" @click="hideTooltip(invoice.id)">
                                                        Partial Paid</span>
                                                    <span v-if="invoice.status === 'pending'" class="badge badge-light-danger badge-pill"
                                                          @click="hideTooltip(invoice.id)">Pending</span></td>
                                                <td class="text-right text-small action pr-1 px-0"
                                                    @click="hideTooltip(invoice.id)">
                                                    <a :href="route('invoice.show',['suppliers',supplier.id,invoice.id])">
                                                    <span class="badge-circle badge-circle-light-secondary action">
                                                        <i class="bx bxs-show font-medium-1 align-items-center
                                                        text-center"></i>
                                                    </span>
                                                    </a>
                                                    <inertia-link :href="route('invoice.edit',['suppliers',supplier.id,invoice.id])">
                                                <span class="badge-circle badge-circle-light-secondary  action">
                                                    <i class="bx bx-edit font-medium-1 align-items-center text-left">
                                                    </i>
                                                </span>
                                                    </inertia-link>
                                                    <button v-on:click="confirmDelete(invoice.id)">
                                                    <span class="badge-circle badge-circle-light-secondary ml-1/6">
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
                        <div class="col-sm-11 px-0 py-0">
                            <inertia-link :href="route('suppliers.index')" type="button"
                                          class="btn btn-light-secondary mr-1 mb-1">Back</inertia-link>
                        </div>
                    </div>
                    <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                                       @deleteitem="deleteItemInvoice">
                    </ConfirmatiomModal>
                </div>
            </section>
        </admin-layout>
    </div>
</template>

<script>
import moment from 'moment';
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import AdminLayout from "../../Layouts/AdminLayout";
import ErrorComponent from "../../components/ErrorComponent";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {
    name: "Show",
    props: ['supplier', 'documents'],
    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
        ErrorComponent,
    },

    data() {
        return {
            form: this.$inertia.form({
                title: '',
                description: '',
                file: null
            }),
            sweetAlert: false,
            update: false,
            itemId: '',
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Show Details";
    },
    mounted() {
        this.supplier_id = this.supplier.id;
        if (this.documents) {
            this.supplier.document = this.documents;
        }
        if (this.params) {
            Object.assign(this.query, this.params);
        }
        this.update = false;

    },
    methods: {
        stopPropagation(e) {
            e.stopPropagation();
            this.submit();
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY');
        },
        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('supplier.index'), {
                method: 'get',
                data: {
                    ...query
                }
            })
        },
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            this.sweetAlert = false
            this.$inertia.delete(`/document/delete/${this.itemId}`)
        },
        deleteItemInvoice() {
            this.sweetAlert = false
            this.$inertia.delete(`/invoices/${this.itemId}`)
        },
        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
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
        }
    }
}

</script>

<style scoped>
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
