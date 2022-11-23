<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title">Add Quotation Request</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row form-group"  v-for="questionnaire in questionnaires">
                                                <div class="col-md-3">
                                                    <label>{{questionnaire.label}} *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text"
                                                           class="form-control"
                                                           v-model="form.first_name"
                                                           name="first_name" v-if="questionnaire.value == 'first_name'">
                                                    <input type="text"
                                                           class="form-control"
                                                           v-model="form.last_name"
                                                           name="last_name" v-if="questionnaire.value == 'last_name'">
                                                    <input type="email"
                                                           class="form-control"
                                                           v-model="form.email"
                                                           name="email" v-if="questionnaire.value == 'email'">
                                                    <input type="integer"
                                                           class="form-control"
                                                           v-model="form.phone"
                                                           name="phone" v-if="questionnaire.value == 'phone'">
                                                    <input type="text"
                                                           class="form-control"
                                                           v-model="form.company"
                                                           name="company" v-if="questionnaire.value == 'company'">
                                                  <select class="form-select"  v-model="form.industry" v-if="questionnaire.value == 'industry'">
                                                            <option value=""> Please Select</option>
                                                            <option v-for="quotation_type in quotation_types" :value="quotation_type.value">
                                                                {{quotation_type.value}}
                                                            </option>
                                                    </select>
                                                   <select class="form-select"  v-model="form.platform" v-if="questionnaire.value == 'platform'">
                                                            <option value=""> Please Select</option>
                                                            <option v-for="quotation_platform in quotation_platforms" :value="quotation_platform.value">
                                                                {{quotation_platform.value}}
                                                            </option>
                                                    </select>
                                                    <select class="form-select" v-model="form.shipment_month" v-if="questionnaire.value == 'shipment_month'">
                                                            <option value="">Shipment per Month</option>
                                                            <option v-for="monthly_quantity_request in monthly_quantity_requests" :value="monthly_quantity_request.value">
                                                                {{monthly_quantity_request.value}}
                                                            </option>
                                                    </select>
                                                     <textarea :type="textarea"
                                                                class="form-control" row="3"
                                                                v-model="form.message"
                                                            name="message" v-if="questionnaire.value == 'message'"> </textarea>

                                                     <ErrorComponent v-if="questionnaire.value == 'first_name'" input="first_name"></ErrorComponent>
                                                     <ErrorComponent v-if="questionnaire.value == 'last_name'" input="last_name"></ErrorComponent>
                                                     <ErrorComponent v-if="questionnaire.value == 'email'" input="email"></ErrorComponent>
                                                     <ErrorComponent v-if="questionnaire.value == 'phone'" input="phone"></ErrorComponent>
                                                     <ErrorComponent v-if="questionnaire.value == 'company'" input="company"></ErrorComponent>
                                                      <ErrorComponent v-if="questionnaire.value == 'industry'" input="industry"></ErrorComponent>
                                                     <ErrorComponent v-if="questionnaire.value == 'platform'" input="platform"></ErrorComponent>
                                                     <ErrorComponent v-if="questionnaire.value == 'shipment_month'" input="shipment_month"></ErrorComponent>
                                                      <ErrorComponent v-if="questionnaire.value == 'message'" input="message"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                        Save
                                                    </button>
                                                    <inertia-link :href="route('quotation-requests.index')" type="button" class="btn btn-light-secondary mr-1 mb-1">
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
    props: ['questionnaires', 'quotation_platforms', 'monthly_quantity_requests', 'quotation_request' ,'errors', 'quotation_types'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            company: '',
            industry: '',
            platform: '',
            shipment_month: '',
             message: '',

        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Quotation Request";
        if (this.quotation_request) {
            this.update = true;
            let data = this.quotation_request;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('quotation-requests.update', this.quotation_request.id))
            } else {
                this.form.post('/fulfilment/admin/quotation-requests')
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

.error {
    margin-top: 0px !important;
}

</style>
