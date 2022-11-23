<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="suppliers">Edit Payment</h4>
                                <h4 class="card-title" v-else>Add Payment</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Sales Channels *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select class="form-select" v-model="form.channel_id"
                                                            name="channel_id">
                                                        <option value="" disabled>Select Sale Channel</option>
                                                        <option v-for="channel in channels" :value="channel.id">
                                                            {{ channel.name }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="channel_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Invoice *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select class="form-select" v-model="form.invoice_id"
                                                            name="invoice_id">
                                                        <option value="">Select Invoice Number</option>
                                                        <option v-for="invoice in invoices" :value="invoice.id">
                                                            {{ invoice.invoice_number }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="invoice_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Payer's Account *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select class="form-select" v-model="form.payer_account_id"
                                                            name="payer_account_id">
                                                        <option value="">Select Payer Account</option>
                                                        <option v-for="account in accounts" :value="account.id">
                                                            {{ (account.first_name ? account.first_name : '')
                                                        +(account.last_name ? " " + account.last_name: '')
                                                        +(account.account_no ? "," + account.account_no: '') }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="payer_account_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Payer Ammount *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="payer_ammount"
                                                           v-model="form.payer_ammount"
                                                           class="form-control"
                                                           name="payer_ammount">
                                                    <ErrorComponent input="payer_ammount"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Payee's Account *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                        <select class="form-select" v-model="form.payee_account_id"
                                                                name="payee_account_id">
                                                            <option value="">Select Payee Account</option>
                                                            <option v-for="account in accounts" :value="account.id">
                                                                {{ (account.first_name ? account.first_name : '')
                                                            +(account.last_name ? " " + account.last_name: '')
                                                            +(account.account_no ? "," + account.account_no: '') }}
                                                            </option>
                                                        </select>
                                                    <ErrorComponent input="payee_account_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Date *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="date" id="date"
                                                           v-model="form.date"
                                                           class="form-control" name="date">
                                                    <ErrorComponent input="date"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Payment Reference *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="payment_reference"
                                                           v-model="form.payment_reference"
                                                           class="form-control"
                                                           name="payment_reference">
                                                    <ErrorComponent input="payment_reference"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Method *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select class="form-select" v-model="form.payment_method"
                                                            name="payment_method">
                                                        <option value="">Select Payment Method</option>
                                                        <option v-for="method in paymentMethods" :value="method.id">
                                                            {{ method.value }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="payment_method"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Notes</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="notes"
                                                           v-model="form.notes"
                                                           class="form-control"
                                                           name="notes">
                                                    <ErrorComponent input="notes"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Proof of Payment *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="payment_proof" class="custom-file-input"
                                                               id="file"
                                                               multiple
                                                               @input="form.payment_proof = $event.target.files"/>
                                                        <ErrorComponent input="payment_proof"></ErrorComponent>
                                                        <label class="custom-file-label" for="file">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('suppliers.index')" type="button"
                                                              class="btn btn-light-secondary mr-1 mb-1">
                                                    Back
                                                </inertia-link>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </admin-layout>
</template>

<script>

import AdminLayout from "../../Layouts/AdminLayout";
import Label from "../../Jetstream/Label";
import JetInputError from './../../Jetstream/InputError'
import {useForm} from '@inertiajs/inertia-vue3'
import ErrorComponent from '../../components/ErrorComponent'

export default {
    name: "Create",
    props: ['channels', 'errors', 'invoices', 'paymentMethods', 'accounts', 'dealInvoice'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },

    setup() {
        const form = useForm({
            channel_id: '',
            deal_invoice_id: '',
            invoice_id: '',
            payee_account_id: '',
            payer_account_id: '',
            payer_ammount: '',
            date: '',
            payment_reference: '',
            payment_method: '',
            notes: '',
            payment_proof: '',
        })
        return {form}
    },
    data() {
        return {}
    },

    beforeMount() {
        if (this.suppliers) {
            document.title = process.env.MIX_APP_NAME + " - Edit Payment";
            this.update = true;
            let data = this.suppliers;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        } else {
            document.title = process.env.MIX_APP_NAME + " - Add Payment";
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('suppliers.update', this.suppliers.id))
            } else {
                this.form.deal_invoice_id = this.dealInvoice.id;
                this.form.post('/deals/payment/store')
            }
        },
    }
}
</script>

<style scoped>

.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}
svg {
    transform: rotate(90deg);
}
.error {
    margin-top: 0px !important;
}


</style>
