<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="stockItems">Edit Stock-Items</h4>
                                <h4 class="card-title" v-else>Add Stock</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">

                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>Products *</label>
                                                    </div>
                                                    <div class="col-md-6" >
                                                        <Multiselect123
                                                            v-model="form.value"
                                                            mode="tags"
                                                            :searchable="true"
                                                            :createTag="true"
                                                            :max="1"
                                                            placeholder="Select Product"
                                                            :options="options" class="font-weight-bold"
                                                            />

                                                        <ErrorComponent input="product_id"></ErrorComponent>
                                                                <!-- <select class="form-select" v-model="form.product_id"
                                                                        name="product_id">
                                                                    <option value="">Select Product</option>
                                                                    <option v-for="product in products" :value="product.id">
                                                                        {{ product.name }}
                                                                    </option>
                                                                </select>
                                                                <ErrorComponent input="product_id"></ErrorComponent> -->
                                                                <!-- <ErrorComponent input="products"></ErrorComponent> -->

                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>warehouse *</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-select" v-model="form.warehouse_id"
                                                                name="warehouse_id">
                                                            <option value="" class="font">Select Warehouse</option>
                                                            <option v-for="warehouse in warehouses" :value="warehouse.id">
                                                                {{ warehouse.name }}
                                                            </option>
                                                        </select>
                                                        <ErrorComponent input="warehouse_id"></ErrorComponent>
                                                    </div>
                                                </div>


                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>Supplier *</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-select" v-model="form.supplier_id"
                                                                name="supplier_id">
                                                            <option value="">Select Supplier</option>
                                                            <option v-for="supplier in suppliers" :value="supplier.id">
                                                                {{ supplier.name }}
                                                            </option>
                                                        </select>
                                                        <ErrorComponent input="supplier_id"></ErrorComponent>
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
                                                <button type="submit" class="btn btn-primary mr-1 mb-1" >
                                                    Save
                                                </button>
                                                <inertia-link :href="route('stock-logs.index')" type="button"
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
import Multiselect123 from '@vueform/multiselect'
import ErrorComponent from '../../components/ErrorComponent'

export default {
    name: "Create",
    props: ['warehouses', 'products', 'suppliers', 'errors', 'stockItems','values'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        Multiselect123,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            quantity: '',
            supplier_id: '',
            product_id: '',
            warehouse_id: '',
            old_quantity: '',
            product_title: '',
        })
        return {form}
    },
    data() {
        return {
         options: []
        }
    },
    beforeMount() {
        let modulesArr = [this.options];
        this.products.forEach((value, index) => {
            var obj = {"value": value.id, "label": value.name};
            modulesArr.push(obj);
        });
        this.options = modulesArr;
        document.title = process.env.MIX_APP_NAME + " - Create Module";
        if (this.stockItems) {
            document.title = process.env.MIX_APP_NAME + " - Edit Stock Log";
        } else {
            document.title = process.env.MIX_APP_NAME + " - Add Stock Log";
        }
        if (this.stockItems) {
            this.update = true;
            let data = this.stockItems;
            Object.assign(data, {
                'value': [],
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
      mounted() {
     if(this.statusData)
       {
           this.form.status = true
       }
        if (this.values) {
            var valueArr = [];
            this.values.forEach((value, index) => {
                valueArr.push(value.id);
            });
            this.form.value = valueArr;
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.old_quqntity
                this.form.product_id = this.form.value;
                this.form.post(route('stock-logs.update', this.stockItems.id))
            } else {
                this.form.product_id = this.form.value
                this.form.post(route('stock-logs.store'))
            }
        },
    }
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<style scoped>

.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}

.error {
    margin-top: 0px !important;
}

</style>
