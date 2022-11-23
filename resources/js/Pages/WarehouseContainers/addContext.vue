<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="warehouseContainerContext">Edit Container Context</h4>
                                <h4 class="card-title" v-else>Add Container Context</h4>
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
                                                    <label>Warehouses *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select class="form-select" v-model="form.warehouse_id"
                                                            name="warehouse_id">
                                                        <option value="">Select Warehouse</option>
                                                        <option v-for="warehouse in warehouses" :value="warehouse.id">
                                                            {{ warehouse.name }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="warehouse_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Products *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select class="form-select" v-model="form.product_id"
                                                            name="product_id">
                                                        <option value="">Select Product</option>
                                                        <option v-for="product in products" :value="product.id">
                                                            {{ product.name }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="product_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Lading Bill# *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="bill_of_lading_no"
                                                           v-model="form.bill_of_lading_no"
                                                           class="form-control"
                                                           name="bill_of_lading_no">
                                                    <ErrorComponent input="bill_of_lading_no"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Quantity# *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="quantity" v-model="form.quantity"
                                                           class="form-control"
                                                           name="quantity">
                                                    <ErrorComponent input="quantity"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Corton# *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="ctn" v-model="form.ctn"
                                                           class="form-control"
                                                           name="ctn">
                                                    <ErrorComponent input="ctn"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Unit Price# *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="unit_price" v-model="form.unit_price"
                                                           class="form-control"
                                                           name="unit_price">
                                                    <ErrorComponent input="unit_price"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Total Amount# *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="total_amount" v-model="form.total_amount"
                                                           class="form-control"
                                                           name="total_amount">
                                                    <ErrorComponent input="total_amount"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link
                                                    :href="route('containers.show', warehouseContainerContext.warehouse_container_id)"
                                                    type="button"
                                                    class="btn btn-light-secondary mr-1 mb-1"
                                                    v-if="warehouseContainerContext">
                                                    Back
                                                </inertia-link>
                                                <inertia-link
                                                    :href="route('containers.show', warehouseContainer.id)"
                                                    type="button"
                                                    class="btn btn-light-secondary mr-1 mb-1" v-else>
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
import Label from "../../Jetstream/Label";
import {useForm} from '@inertiajs/inertia-vue3'
import AdminLayout from "../../Layouts/AdminLayout";
import JetInputError from './../../Jetstream/InputError'
import ErrorComponent from '../../components/ErrorComponent'

export default {
    name: "addContext",
    props: ['warehouseContainer', 'errors', 'warehouses', 'products', 'warehouseContainerContext'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent
    },
    setup() {
        const form = useForm({
            company_id: '',
            warehouseContainer_id: '',
            warehouse_id: '',
            product_id: '',
            bill_of_lading_no: '',
            quantity: '',
            ctn: '',
            unit_price: '',
            total_amount: '',
        })
        return {form}
    },
    data() {
        return {
            update: false,
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Container Context";
        if (this.warehouseContainerContext) {
            this.update = true;
            let data = this.warehouseContainerContext;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },

    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('context-update', this.warehouseContainerContext.id))
            } else {
                this.form.warehouseContainer_id = this.warehouseContainer.id;
                this.form.post(route('container.context.store', this.warehouseContainer.id))
            }
        },
    }
}
</script>
