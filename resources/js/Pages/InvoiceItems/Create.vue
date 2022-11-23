<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="invoiceItem">Edit Invoice Item</h4>
                                <h4 class="card-title" v-else>Add Invoice Item</h4>
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
                                                    <label>Item Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="item_name" v-model="form.item_name"
                                                           class="form-control"
                                                           name="item_name">
                                                    <ErrorComponent input="item_name"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2">
                                                <div class="col-md-3">
                                                    <label>Carton *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="carton" v-model="form.carton"
                                                           class="form-control"
                                                           name="carton">
                                                    <ErrorComponent input="carton"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2">
                                                <div class="col-md-3">
                                                    <label>Quantity *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="quantity" v-model="form.quantity"
                                                           class="form-control"
                                                           name="quantity">
                                                    <ErrorComponent input="quantity"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2">
                                                <div class="col-md-3">
                                                    <label>Unit Price *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="unit_price" v-model="form.unit_price"
                                                           class="form-control"
                                                           name="unit_price">
                                                    <ErrorComponent input="unit_price"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1"
                                                        v-if="form.processing" disabled>
                                                    <span class="spinner-border spinner-border-sm pb-0.5" role="status"
                                                          aria-hidden="true"></span>
                                                    <span class="">Saving...</span>
                                                </button>
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('invoice.show',[name,id,invoice_id])" type="button"
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
        props: ['name', 'id', 'invoice_id', 'errors', 'invoiceItem'],
        components: {
            Label,
            AdminLayout,
            JetInputError,
            ErrorComponent,
        },

        setup() {
            const form = useForm({
                item_name: '',
                carton: '',
                quantity: '',
                unit_price: '',
                name: '',
                id: '',
                invoice_id: 0,
            })
            return {form}
        },
        data() {
            return {}
        },

        beforeMount() {
            document.title = process.env.MIX_APP_NAME + " - Create invoice item";
            if (this.invoiceItem) {
                this.update = true;
                let data = this.invoiceItem;
                Object.assign(data, {
                    '_method': 'PUT',
                })
                data.name=this.name;
                data.mid=this.id;
                this.form = this.$inertia.form(data);
            }
        },
        methods: {
            submit() {
                if (this.update) {
                    this.form.post(route('invoiceitems.update', this.invoiceItem.id))
                } else {
                    this.form.name = this.name;
                    this.form.id = this.id;
                    this.form.invoice_id = this.invoice_id;
                    this.form.post('/invoiceitems')
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
