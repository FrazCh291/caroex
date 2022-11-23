<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="suppliers">Edit Supplier</h4>
                                <h4 class="card-title" v-else>Add Supplier</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row form-group pt-2">
                                                <div class="col-md-3">
                                                    <label>Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="name" v-model="form.name"
                                                           class="form-control" placeholder="Enter Supplier Name"
                                                           name="name">
                                                    <ErrorComponent input="name"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Address Line 1 *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="address_1" v-model="form.address_1"
                                                           class="form-control" placeholder="Enter Address Line 1"
                                                           name="address_1">
                                                    <ErrorComponent input="address_1"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Address Line 2</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="address_2" v-model="form.address_2"
                                                           class="form-control" placeholder="Enter Address Line 2"
                                                           name="address_2">
                                                    <ErrorComponent input="address_2"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Email *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="email" id="email" v-model="form.email"
                                                           class="form-control" placeholder="xyz@gmail.com"
                                                           name="email">
                                                    <ErrorComponent input="email"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Phone No *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="phone" v-model="form.phone"
                                                           class="form-control"
                                                           name="phone">
                                                    <ErrorComponent input="phone"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>City </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="city"
                                                           v-model="form.city"
                                                           class="form-control"
                                                           name="city">
                                                    <ErrorComponent input="city"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>County </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="state"
                                                           v-model="form.state"
                                                           class="form-control"
                                                           name="state">
                                                    <ErrorComponent input="state"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Country *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select class="form-select" v-model="form.country"
                                                            name="country">
                                                        <option value="">Select Country</option>
                                                        <option v-for="country in countries" :value="country.id">
                                                            {{ country.value }}</option>
                                                    </select>
                                                    <ErrorComponent input="country"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Postal Code *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="postal_code"
                                                           v-model="form.postal_code"
                                                           class="form-control"
                                                           name="postal_code">
                                                    <ErrorComponent input="postal_code"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Supplier Status *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <fieldset>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input"
                                                                   v-model="form.status" id="checkbox1" checked="">
                                                            <label for="checkbox1"></label>
                                                        </div>
                                                    </fieldset>
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
    props: ['suppliers', 'countries','errors'],
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
            phone: '',
            address_1: '',
            address_2: '',
            country: '',
            city: '',
            state: '',
            postal_code: '',
            status: '',
        })
        return {form}
    },
    data() {
        return {}
    },

    beforeMount() {
        if (this.suppliers) {
            document.title = process.env.MIX_APP_NAME + " - Edit suppliers";
            this.update = true;
            let data = this.suppliers;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
        else {
            document.title = process.env.MIX_APP_NAME + " - Add suppliers";
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('suppliers.update', this.suppliers.id))
            } else {
                this.form.post('/erp/suppliers')
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
