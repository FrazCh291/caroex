<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="shipmentItem">Edit Shipment Item</h4>
                                <h4 class="card-title" v-else>Add Shipment Item</h4>
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
                                                    <label>Company *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select class="form-select" v-model="form.freight_forwarder_id"
                                                        name="freight_forwarder_id">
                                                        <option value="">select</option>
                                                        <option v-for="company in companies" :value="company.id">
                                                            {{ company.name }}</option>
                                                    </select>
                                                    <ErrorComponent input="freight_forwarder_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label> Item Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="item_name" v-model="form.item_name"
                                                        class="form-control" name="item_name">
                                                    <ErrorComponent input="item_name"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>NO of Corton *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="number" id="carton" v-model="form.carton"
                                                        class="form-control" name="carton">
                                                    <ErrorComponent input="carton"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Quantity per/carton *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="number" id="qty_ctn" v-model="form.qty_ctn"
                                                        class="form-control" name="qty_ctn">
                                                    <ErrorComponent input="qty_ctn"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Total Quantity *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="number" id="total_qty" v-model="form.total_qty"
                                                        class="form-control" name="total_qty">
                                                    <ErrorComponent input="total_qty"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Unit Price *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="number" id="unit_price" v-model="form.unit_price"
                                                        class="form-control" name="unit_price">
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
                                                <button type="submit" class="btn btn-primary mr-1 mb-1" v-else>
                                                    Save
                                                </button>
                                                <inertia-link :href="route('shipments.show',shipmentId)" type="button"
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
    import { useForm } from '@inertiajs/inertia-vue3'
    import ErrorComponent from '../../components/ErrorComponent'

    export default {
        name: "Create",
        props: [ 'errors', 'companies', 'shipmentId', 'shipmentItem'],
        components: {
            Label,
            AdminLayout,
            JetInputError,
            ErrorComponent,
        },
        setup() {
            const form = useForm({
                shippment_id: '',
                freight_forwarder_id: '',
                item_name: '',
                carton: '',
                qty_ctn: '',
                total_qty: '',
                unit_price: '',
            })
            return { form }
        },
        data() {
            return {}
        },
        beforeMount() {

            document.title = process.env.MIX_APP_NAME + " - Create Module";
            if (this.shipmentItem) {
                this.update = true;
                let data = this.shipmentItem;
                Object.assign(data, {
                    '_method': 'PUT',
                })
                this.form = this.$inertia.form(data);
            }
        },
        methods: {
            submit() {
                if (this.update) {
                    this.form.post(route('shipmentitems.update', this.shipmentItem.id))
                } else {
                    this.form.shippment_id = this.shipmentId;
                    this.form.post('/shipmentitems')
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