<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="address">Edit Courrier Address</h4>
                                <h4 class="card-title" v-else>Add Courrier  Address</h4>
                                <div class="header  mt-1" v-if="Object.keys(errors).length > 0">
                                </div>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                      <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Address 1 *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="address_1" v-model="form.address_1"
                                                           class="form-control"
                                                           name="address_1">
                                                    <ErrorComponent input="address_1"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Address 2 *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="address_2" v-model="form.address_2"
                                                           class="form-control"
                                                           name="address_2">
                                                    <ErrorComponent input="address_2"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Town *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="town" v-model="form.town"
                                                           class="form-control"
                                                           name="town">
                                                    <ErrorComponent input="town"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-1 pb-0 mb-0">
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
                                             <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>County *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="county" v-model="form.county"
                                                           class="form-control"
                                                           name="county">
                                                    <ErrorComponent input="county"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Zip Code *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="postcode" v-model="form.postcode"
                                                           class="form-control"
                                                           name="postcode">
                                                    <ErrorComponent input="postcode"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Country *</label>
                                                </div>
                                                <div class="col-md-6 col-sm-12 form-group">
                                            <select class="form-control" v-model="form.country" name="country">
                                                <option value="">Select Country</option>
                                                <option v-for="country in countries" :value="country.value" >
                                                {{ country.value }}
                                                </option>
                                            </select>
                                            <ErrorComponent input="country"></ErrorComponent>
                                            </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                    <inertia-link
                                                    :href="route('courriers.show',courrier.id)"
                                                    type="button"
                                                    class="btn btn-light-secondary mr-1 mb-1" >
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
    props: ['courrier','countries', 'address', 'errors'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            courrier_id: '',
            address_1: '',
            address_2: '',
            town: '',
            city: '',
            county: '',
            postcode: '',
            country: '',

        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Address";
        if (this.address) {
            this.update = true;
            let data = this.address;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('address.update', this.address.id))
            } else {
                this.form.courrier_id = this.courrier.id
                this.form.post('/super/admin/courrier-address/addressstore')
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
