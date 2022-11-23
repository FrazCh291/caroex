<template>
    <admin-layout>
        <section id="basic-horizontal-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                    <div class="card invoice-print-area">
                        <div class="row">
                            <div class="col-6">
                                <div class="card-header pb-0 mb-0">
                                    <small class="text-muted mr-1 lg:font-bold">Supplier Name:</small>
                                    <small class="text-muted">{{ payments.supplier.name }}</small>
                                </div>
                                <div class="card-header pt-0 mt-0 pb-0 mb-0">
                                    <small class="text-muted mr-1 lg:font-bold">Account Name:</small>
                                    <small class="text-muted">{{
                                            payments.account ? payments.account.name : ''
                                        }}</small>
                                </div>
                                <div class="card-header pt-0 mt-0 pb-0 mb-0">
                                    <small class="text-muted mr-1 lg:font-bold">Payment Method:</small>
                                    <small class="text-muted">{{ payments.payment_method }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-header pb-0 mb-0">
                                    <small class="text-muted mr-1 lg:font-bold">Date:</small>
                                    <small class="text-muted">{{ formatDate(payments.date) }}</small>
                                </div>
                                <div class="card-header pt-0 mt-0 pb-0 mb-0">
                                    <small class="text-muted mr-1 lg:font-bold">Amount:</small>
                                    <small class="text-muted">£{{ payments.amount }}</small>
                                </div>
                                <div class="card-header pt-0 mt-0 pb-0 mb-0">
                                    <small class="text-muted mr-1 lg:font-bold">Transaction Id:</small>
                                    <small class="text-muted">{{ payments.supplier.name }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="px-2">
                            <hr class="line">
                        </div>
                        <div class="card-content">
                            <div class="card-body pb-2 mx-25 px-2">
                                <div class="row pb-2 px-1">
                                    <div class="col-12">
                                        <div class="row pb-0.5">
                                            <div class="col-10">
                                                <div class="mb-0 pt-0.5 lg:font-bold">
                                                    Documents
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="col form-group pr-0 pb-1">
                                                    <inertia-link
                                                        :href="route('payment.file.create', payments.id)"
                                                        data-repeater-create="">
                                                        <i class="bx bxs-plus-circle pt-0.5 primary float-right add-btn font-large-1"> </i>
                                                    </inertia-link>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="payments.documents.length>0" class="row">
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
                                                                    <tr v-for="document in payments.documents">
                                                                        <td class="text-left cursor-pointer px-1 py-0 my-0 text-truncate">
                                                                            <div v-if="document.file_type === 'pdf'">
                                                                                <a :href="route('view.payment.file',[payments.id, document.id])">
                                                                                    <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                                                </a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                            <div
                                                                                v-else-if="document.file_type === 'csv'">
                                                                                <a :href="route('view.payment.file',[payments.id, document.id])">
                                                                                    <i class="bx bxs-file success font-large-1"></i>
                                                                                </a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                            <div
                                                                                v-else-if="document.file_type === 'docx'">
                                                                                <a :href="route('view.payment.file',[payments.id, document.id])">
                                                                                    <i class="bx bxs-file-doc primary font-large-1"></i>
                                                                                </a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                            <div
                                                                                v-else-if="document.file_type === 'txt'||'TXT'">
                                                                                <a :href="route('view.payment.file',[payments.id, document.id])">
                                                                                    <i class="bx bxs-file-txt font-large-1"></i>
                                                                                </a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                            <div
                                                                                v-else-if="document.file_type === 'png'">
                                                                                <a :href="route('view.payment.file',[payments.id, document.id])">
                                                                                    <i class="bx bxs-file-png font-large-1"></i>
                                                                                </a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                            <div
                                                                                v-else-if="document.file_type === 'xlsx'">
                                                                                <a :href="route('view.payment.file',[payments.id, document.id])">
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
                                                                        <td class="text-right py-1 my-1 truncate">
                                                                            <a :href="route('export.payment.file',[payments.id, document.id])">
                                                                                <span
                                                                                    class="badge-circle badge-circle-light-secondary action">
                                                                                    <i class="bx bx-download font-medium-1 align-items-center text-center"></i>
                                                                                </span>
                                                                            </a>
                                                                            <inertia-link
                                                                                :href="route('payment.file.edit',[payments.id, document.id])"
                                                                                data-repeater-create="">
                                                                                <span
                                                                                    class="badge-circle badge-circle-light-secondary  action">
                                                                                     <i class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                                                                </span>
                                                                            </inertia-link>
                                                                            <button
                                                                                v-on:click="confirmDelete(document.id)">
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
                                            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert"
                                                               @clicked="Clicked"
                                                               @deleteitem="deleteItem">
                                            </ConfirmatiomModal>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-11 d-flex justify-content-start px-0 pt-0 mt-0 ml-2">
                            <inertia-link :href="route('payments.index')" type="button"
                                          class="btn btn-light-secondary mr-1 mb-1">
                                Back
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </admin-layout>
</template>

<script>
import moment from 'moment';
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {

    name: "index",
    props: ['payments'],
    components: {
        Button,
        AdminLayout,
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
        document.title = process.env.MIX_APP_NAME + " - payments";

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
        resetQuery() {
            this.query = {}
            this.loadData()
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            this.sweetAlert = false
            this.$inertia.delete(`/payments/{id}/doc/delete/${this.itemId}`)
        },
        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
        },
        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('payments.index'), {
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

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

</style>
