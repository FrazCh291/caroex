<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 v-if="product" class="card-title">Edit Product</h4>
                                <h4 v-else class="card-title">Add Product</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-horizontal" @submit.prevent="submit">
                                        <div class="form-body">
                                            <div class="row form-group pt-2">
                                                <div class="col-md-3">
                                                    <label>Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input id="name" v-model="form.name" class="form-control"
                                                           name="name"
                                                           type="text">
                                                    <ErrorComponent input="name"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Type *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select id="product_type" v-model="form.product_type"
                                                            class="form-select"
                                                            name="product_type">
                                                        <option value="">Select Type</option>
                                                        <option v-for="product_type in productTypes"
                                                                :value="product_type.slug">
                                                            {{ product_type.value }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="product_type"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Sku *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input id="sku" v-model="form.sku" class="form-control"
                                                           name="sku"
                                                           type="text">
                                                    <ErrorComponent input="sku"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Weight(kg) *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input id="weight_unit" v-model="form.weight_unit" class="form-control"
                                                           name="weight_unit"
                                                           type="text">
                                                    <ErrorComponent input="weight_unit"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Image *</label>
                                                </div>
                                                <div class="col-md-6  form-group file">
                                                    <div class="custom-file">
                                                        <input id="image" class="custom-file-input" name="image"
                                                               type="file" @change="onFileChange">
                                                        <label class="custom-file-label pl-1" for="image">Choose
                                                            file</label>
                                                        <ErrorComponent input="image"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--                                            <div class="row form-group">-->
                                            <!--                                                <div class="col-md-3">-->
                                            <!--                                                    <label>Quantity *</label>-->
                                            <!--                                                </div>-->
                                            <!--                                                <div class="col-md-6 form-group">-->
                                            <!--                                                    <input type="text" id="quantity" v-model="form.quantity"-->
                                            <!--                                                           class="form-control"-->
                                            <!--                                                           name="quantity">-->
                                            <!--                                                    <ErrorComponent input="quantity"></ErrorComponent>-->
                                            <!--                                                </div>-->
                                            <!--                                            </div>-->
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Price *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input id="price" v-model="form.price" class="form-control"
                                                           name="price"
                                                           type="text">
                                                    <ErrorComponent input="price"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Shipping method *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input id="shipping_method" v-model="form.shipping_method"
                                                           class="form-control"
                                                           name="shipping_method"
                                                           type="text">
                                                    <ErrorComponent input="shipping_method"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Description</label>
                                                </div>
                                                <div class="col-md-6 form-group">

                                                    <textarea v-model="form.description" class="form-control no-resize"
                                                              rows="3"></textarea>
                                                    <ErrorComponent input="description"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">

                                                <button class="btn btn-primary mr-1 mb-1" type="submit">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('products.index')"
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
import ErrorComponent from '../../components/ErrorComponent'

export default {
    name: "Create",
    props: ['product', 'stock', 'errors', 'productTypes'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            name: '',
            description: '',
            product_type: '',
            price: '',
            sku: '',
            weight_unit:'',
            quantity: '',
            shipping_method: '',
            image: ''
        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        if (this.product) {
            document.title = process.env.MIX_APP_NAME + " - Edit Product";
        } else {
            document.title = process.env.MIX_APP_NAME + " - Add Product";
        }
        if (this.product) {
            this.update = true;
            let data = this.product;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('products.update', this.product.id))
            } else {
                this.form.post('/erp/products')
            }
        },
        onFileChange(event) {
            this.form.image = event.target.files[0];
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
