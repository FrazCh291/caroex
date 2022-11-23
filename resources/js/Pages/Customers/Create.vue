<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="customer">Edit Customer</h4>
                                <h4 class="card-title" v-else>Add Customer</h4>
                                
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <!-- hgghhgh -->
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="name" v-model="form.name"
                                                           class="form-control"
                                                           name="name">
                                                    <ErrorComponent input="name"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Email *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="email" id="amount" v-model="form.email"
                                                           class="form-control"
                                                           name="amount">
                                                    <ErrorComponent input="email"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Chennal *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                   <select v-model="form.channel_id" class="form-select"
                                                    name="channel_id">
                                                        <option value=""></option>
                                                        <option v-for="chennal in chennals"
                                                                :value="chennal.id">
                                                            {{ chennal.name}}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="channel_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Address 1 2 *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="amount" v-model="form.address1_2"
                                                           class="form-control"
                                                           name="amount">
                                                    <ErrorComponent input="address1_2"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>House Number *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="amount" v-model="form.house_number"
                                                           class="form-control"
                                                           name="amount">
                                                    <ErrorComponent input="house_number"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Phone *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="number" id="amount" v-model="form.phone"
                                                           class="form-control"
                                                           name="amount">
                                                    <ErrorComponent input="phone"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>City *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="city" v-model="form.city"
                                                           class="form-control"
                                                           name="city">
                                                    <ErrorComponent input="city"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Post Code *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="postcode" v-model="form.postcode"
                                                           class="form-control"
                                                           name="postcode">
                                                    <ErrorComponent input="postcode"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Country *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="country" v-model="form.country"
                                                           class="form-control"
                                                           name="country">
                                                    <ErrorComponent input="country"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('customers.index')" type="button"
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
    props: ['customer','chennals', 'errors'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            name: '',
            email: '',
            channel_id: '',
            address1_2: '',
            house_number: '',
            phone: '',
            city: '',
            postcode: '',
            country: ''
        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Customer";
        if (this.customer) {
            this.update = true;
            let data = this.customer;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('customers.update', this.customer.id))
            } else {
                this.form.post(route('customers.store'));
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
