<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 v-if="payments" class="card-title">Edit Payment</h4>
                                <h4 v-else class="card-title">Add Payment</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-horizontal" @submit.prevent="submit">
                                        <div class="form-body">
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Supplier *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select v-model="form.supplier_id" class="form-control" v-if="suppliers.id"
                                                            name="supplier_id" disabled>
                                                        <option value="">Select</option>
                                                        <option  :value="suppliers.id">
                                                            {{ suppliers.name }}
                                                        </option>
                                                    </select>
                                                    <select v-model="form.supplier_id" class="form-select" v-else
                                                            name="supplier_id">
                                                        <option value="">Select</option>
                                                        <option v-for="supplier in suppliers" :value="supplier.id">
                                                            {{ supplier.name }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="supplier_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Invoice *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select v-model="form.invoice_id" class="form-control" v-if="invoices.id"
                                                            name="invoice_id" disabled>
                                                        <option value="">Select</option>
                                                        <option :value="invoices.id">
                                                            {{ invoices.invoice_number }}
                                                        </option>
                                                    </select>
                                                    <select v-model="form.invoice_id" class="form-select" v-else
                                                            name="invoice_id">
                                                        <option value="">Select</option>
                                                        <option v-for="invoice in invoices" :value="invoice.id">
                                                            {{ invoice.invoice_number }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="invoice_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group" v-if="sale_invoice">
                                                <div class="col-md-3">
                                                    <label>Payer's Account *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select v-model="form.payer_account_id" class="form-select"
                                                            name="payer_account_id">
                                                        <option value="">Select</option>
                                                        <option v-for="payeraccount in payeraccounts"
                                                                :value="payeraccount.id">
                                                            {{
                                                                (payeraccount.first_name) + (' ') + (payeraccount.last_name)
                                                            }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="payer_account_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Payer's Currency *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select v-model="form.payer_currency_id" class="form-select"
                                                            name="payer_currency_id" >
                                                        <option value="">Select</option>
                                                        <option v-for="payercurrency in payercurrencys"
                                                                :value="payercurrency.slug">
                                                            {{ payercurrency.value}}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="payer_currency_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Payer's Amount *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input id="amount" v-model="form.amount" class="form-control"
                                                           name="amount"
                                                           type="text">
                                                    <ErrorComponent input="amount"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group" v-if="sale_invoice">
                                                <div class="col-md-3">
                                                    <label>Payee's Account *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select v-model="form.payee_account_id" class="form-select"
                                                            name="payee_account_id">
                                                        <option value="">Select</option>
                                                        <option v-for="payeeaccount in payeeaccounts"
                                                                :value="payeeaccount.id">
                                                            {{
                                                                (payeeaccount.first_name) + (' ') + (payeeaccount.last_name)
                                                            }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="payee_account_id"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Payee's Currency *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select v-model="form.payee_currency_id" class="form-select"
                                                            name="payee_currency_id">
                                                        <option value="">Select</option>
                                                        <option v-for="payeeecurrency in payeeecurrencys"
                                                                :value="payeeecurrency.slug">
                                                            {{ payeeecurrency.from_to?payeeecurrency.from_to:payeeecurrency.value }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="payee_currency_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Payee's Total *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        v-model="form.payee_total"
                                                        class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Date *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input id="payment_date" v-model="form.payment_date"
                                                           class="form-control"
                                                           name="payment_date" type="date">
                                                    <ErrorComponent input="payment_date"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Payment Reference *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input id="payment_reference" v-model="form.payment_reference"
                                                           class="form-control"
                                                           name="payment_reference"
                                                           type="text">
                                                    <ErrorComponent input="payment_reference"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Method</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select v-model="form.payment_method" class="form-select"
                                                            name="payment_method">
                                                        <option value="">Select</option>
                                                        <option v-for="method in methods" :value="method.slug">
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
                                                    <textarea id="description" v-model="form.description"
                                                              class="form-control"
                                                              name="description" placeholder="Textarea"
                                                              rows="2"></textarea>
                                                    <ErrorComponent input="description"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Proof Of Payment *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <div class="custom-file">
                                                        <input id="file" class="custom-file-input" multiple
                                                               name="file"
                                                               type="file"
                                                               @input="form.file = $event.target.files"/>
                                                        <ErrorComponent input="file"></ErrorComponent>
                                                        <label class="custom-file-label" for="file">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button class="btn btn-primary mr-1 mb-1" type="submit">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('invoices.index')" v-if="invoices.id"
                                                              class="btn btn-light-secondary mr-1 mb-1"
                                                              type="button">
                                                    Back
                                                </inertia-link>
                                                <inertia-link :href="route('payments.index')" v-else
                                                              class="btn btn-light-secondary mr-1 mb-1"
                                                              type="button">
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
import ErrorComponent from '../../components/ErrorComponent';

export default {
    name: "Create",
    props: ['suppliers', 'payercurrencys', 'payeeecurrencys', 'errors', 'methods', 'payeraccounts', 'payeeaccounts', 'payments', 'invoices', 'routeName', 'routeId', 'paymentInvoiceId', 'invoice'],

    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            payment_reference: '',
            supplier_id: '',
            invoice_id: '',
            payee_account_id: '',
            payee_currency_id: '',
            payer_account_id: '',
            payer_currency_id: '',
            conversionrate: '',
            payee_total: '',
            payment_method: '',
            payment_date: '',
            amount: '',
            description: '',
            file: '',
            route_name: '',
            route_id:'',
        })
        return {form}
    },
    data() {
        return {
            query: {
                query: "",
                amount: "",
            },
            payer_currency_id: '',
            payercurrency: {},
            amount: '',
            conversion: false,
            conversion_rate: false,
            sale_invoice: true,
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Add Company Payment";
        if(this.payments){
            if (this.payments.invoice){
                this.sale_invoice = this.payments.invoice.is_sale === true?false:true
            }
        }
        if(this.invoices.id){
            this.form.invoice_id = this.invoices.id
            this.form.supplier_id = this.invoices.supplier_id
        }
        if(this.paymentInvoiceId) {
            this.form.invoice_id = this.paymentInvoiceId;
        }
        if (this.payments) {
            this.update = true;
            let data = this.payments;
            Object.assign(data, {
                route_name: '',
                route_id: '',
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
            if(this.payments.conversion_rate_usd){
                this.form.conversionrate = this.payments.conversion_rate_usd;
            }
            if(this.payments.conversion_rate_rmb){
                this.form.conversionrate = this.payments.conversion_rate_rmb;
            }
        }
    },
    methods: {
        submit() {
            if (this.update) {
                if(this.routeName) {
                    this.form.route_name = this.routeName
                }
                if(this.routeId) {
                    this.form.route_id = this.routeId
                }
                this.form.post(route('payments.update', this.payments.id))
            } else {
                if(this.routeName) {
                    this.form.route_name = this.routeName
                }
                if(this.routeId) {
                    this.form.route_id = this.routeId
                }
                this.form.post('/erp/payments')
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


</style>
