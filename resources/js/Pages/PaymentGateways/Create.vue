<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="paymentgateways">Edit Payment Gateway</h4>
                                <h4 class="card-title" v-else>Add Payment Gateway</h4>
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
                                                    <label>Gateway Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="name" v-model="form.name"
                                                           class="form-control"
                                                           name="name">
                                                    <ErrorComponent input="name"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Private Key *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="private_key"
                                                           v-model="form.private_key"
                                                           class="form-control" name="private_key">
                                                    <ErrorComponent input="private_key"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Secret Key *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="secret_key"
                                                           v-model="form.secret_key"
                                                           class="form-control" name="secret_key">
                                                    <ErrorComponent input="secret_key"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('payment-gateways.index')" type="button"
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
import ErrorComponent from '../../components/ErrorComponent';

export default {
    name: "Create",
    props: ['paymentgateways', 'errors'],

    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            name: '',
            private_key: '',
            secret_key: '',
        })
        return {form}
    },
    data() {
        return {}
    },

    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Add Payment Gateway";
        if (this.paymentgateways) {
            this.update = true;
            let data = this.paymentgateways;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('payment-gateways.update', this.paymentgateways.id))
            } else {
                this.form.post('/erp/admin/payment-gateways')
            }
        },
        selectFromParentComponent1() {
            this.item = this.options[0]
        }
    }
}
</script>

<style scoped>

.line {
    bor-top: 1px dashed #C7CFD6;
    width: 100%;
}
.error {
    margin-top: 0px !important;
}

</style>
