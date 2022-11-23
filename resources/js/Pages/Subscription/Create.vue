<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="module">Edit Package</h4>
                                <h4 class="card-title" v-else>Add Package</h4>
                                <div class="header  mt-1" v-if="Object.keys(errors).length > 0">
                                    <div class="alert bg-rgba-danger alert-dismissible mb-2 message" role="alert">
                                        <div class="d-flex align-items-center" v-for="error in errors">
                                            <i class="bx bx-error"></i>
                                            <span>
                                                  <jet-input-error :message="error" class="mt-2 error "/>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Type *</label>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <select class="form-control" id="card_type" name="card_type"
                                                        v-model="form.card_type">
                                                    <option value=""></option>
                                                    <option value="visa">Visa</option>
                                                </select>
                                                <ErrorComponent input="card_type"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Card Number</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="card-number" class="form-control"
                                                       name="card_number" placeholder=""
                                                       v-model="form.card_number">
                                                <ErrorComponent input="card_number"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Expire</label>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <input type="text" name="expire" id="expire" class="form-control"
                                                       v-model="form.expire">
                                                <ErrorComponent input="expire"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>CVV/CVC</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="cvv2" class="form-control"
                                                       name="cvv2" placeholder=""
                                                       v-model="form.cvv2">
                                                <ErrorComponent input="cvv2"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>First Name *</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="first-name" class="form-control"
                                                       name="first_name" placeholder=""
                                                       v-model="form.first_name">
                                                <ErrorComponent input="name"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Last Name</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="last-name" class="form-control"
                                                       name="last_name" placeholder=""
                                                       v-model="form.last_name">
                                                <ErrorComponent input="last_name"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Street</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="street" class="form-control"
                                                       name="street" placeholder=""
                                                       v-model="form.street">
                                                <ErrorComponent input="street"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>City</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="city" class="form-control"
                                                       name="city" placeholder=""
                                                       v-model="form.city">
                                                <ErrorComponent input="city"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>State</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="state" class="form-control"
                                                       name="state" placeholder=""
                                                       v-model="form.state">
                                                <ErrorComponent input="state"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Country</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="country" class="form-control"
                                                       name="country" placeholder=""
                                                       v-model="form.country">
                                                <ErrorComponent input="country"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Zip</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="zip" class="form-control"
                                                       name="zip" placeholder=""
                                                       v-model="form.zip">
                                                <ErrorComponent input="zip"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Auto Renew</label>
                                            </div>
                                            <div class="col-md-6 form-group">

                                                <div
                                                    class="custom-control custom-switch custom-switch-success mr-2 mb-1">
                                                    <input v-if="form.auto_renew == 1" type="checkbox"
                                                           class="custom-control-input"
                                                           v-model="form.auto_renew"
                                                           checked id="customSwitch11">
                                                    <input v-else type="checkbox" class="custom-control-input"
                                                           v-model="form.auto_renew" id="customSwitch11">
                                                    <label class="custom-control-label" for="customSwitch11">
                                                        <span class="switch-icon-left"></span>
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Save Card</label>
                                            </div>
                                            <div class="col-md-6 form-group pb-0 mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-success mr-2 mb-1">
                                                    <input v-if="form.save_card == 1" type="checkbox"
                                                           class="custom-control-input"
                                                           v-model="form.save_card"
                                                           checked id="customSwitch1">
                                                    <input v-else type="checkbox" class="custom-control-input"
                                                           v-model="form.save_card" id="customSwitch1">
                                                    <label class="custom-control-label" for="customSwitch1">
                                                        <span class="switch-icon-left"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-11 d-flex justify-content-start px-0">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                Save
                                            </button>
                                            <inertia-link :href="route('subscriptions.index')" type="button"
                                                          class="btn btn-light-secondary mr-1 mb-1">
                                                Back
                                            </inertia-link>
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
import AdminLayout from "@/Layouts/AdminLayout";
import Label from "../../Jetstream/Label";
import JetInputError from './../../Jetstream/InputError'
import {useForm} from '@inertiajs/inertia-vue3'
import ErrorComponent from '../../components/ErrorComponent'

export default {
    name: "Create",
    props: ['package_id', 'errors'],
    components: {
        AdminLayout,
        Label,
        JetInputError,
        ErrorComponent
    },
    setup() {
        const form = useForm({
            "package_id": '',
            "card_type": '',
            "card_number": '',
            "expire": '',
            "cvv2": '',
            "first_name": '',
            "last_name": '',
            "street": '',
            "city": '',
            "state": '',
            "country": '',
            "zip": '',
            'auto_renew': false,
            "save_card": false
        });
        return {form}
    },
    mounted() {
    },

    methods: {
        submit() {
            this.form.package_id = this.package_id;
            this.form.post('/subscription/start');
        },
    }
}
</script>

<style scoped>

</style>
