<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="stocks">Edit Stock-Items</h4>
                                <h4 class="card-title" v-else>Add Stock</h4>
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
                                        <div class="form-body">
                                            <div class="form-body">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>Products *</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control" v-model="form.product_id"
                                                                name="product_id">
                                                            <option value=""></option>
                                                            <option v-for="product in products" :value="product.id">
                                                                {{ product.name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-body">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>warehouse *</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control" v-model="form.warehouse_id"
                                                                name="warehouse_id">
                                                            <option value=""></option>
                                                            <option v-for="warehouse in warehouses" :value="warehouse.id">
                                                                {{ warehouse.name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Quantity *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="name" v-model="form.quantity"
                                                           class="form-control"
                                                           name="quantity">
                                                    <ErrorComponent input="quantity"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1"
                                                        v-if="form.processing" disabled>
                                                    <span class="spinner-border spinner-border-sm pb-0.5" role="status"
                                                          aria-hidden="true"></span>
                                                    <span class="">Saving...</span>
                                                </button>
                                                <button type="submit" class="btn btn-primary mr-1 mb-1" v-else>
                                                    Save
                                                </button>
                                                <inertia-link :href="route('warehouse-stocks.index')" type="button"
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

export default {
    name: "Create",
    props: ['warehouses', 'products', 'errors', 'stocks'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
    },
    setup() {
        const form = useForm({
            quantity: '',
            product_id: '',
            warehouse_id: '',
        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Email";
        if (this.stocks) {
            this.update = true;
            let data = this.stocks;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
            if (this.form.status == 1) {
                this.form.status = true;
            }
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('stocks.update', this.stocks.id))
            } else {
                this.form.post(route('stocks.store'))
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
