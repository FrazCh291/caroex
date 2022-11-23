<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="deals">Edit Deal</h4>
                                <h4 class="card-title" v-else>Add Document</h4>
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
                                                    <label>Title *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="deal_number" v-model="form.deal_number"
                                                           class="form-control" name="deal_number">
                                                    <ErrorComponent input="deal_number"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <!-- <div class="col-md-3">
                                                    <label>Upload File</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file" class="custom-file-input" id="file" multiple @input="form.file = $event.target.files"/>
                                                        <label class="custom-file-label" for="file">Choose file</label>
                                                    </div>
                                                </div> -->
                                                <file-upload name="file" @supervisor_error="getError" @input="form.file = $event.target.files"
                                             @fileError="showToastrMessage"></file-upload>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Description</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Textarea"></textarea>
                                                    <ErrorComponent input="description"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('documents.index')" type="button"
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
import FileUpload from "../../admin/FileUpload";

export default {
    name: "Create",
    props: ['deals', 'errors', 'productTitles', 'channelTitles'],

    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
        FileUpload,
    },
    setup() {
        const form = useForm({
            deal_type: '',
            contract_signed_at: '',
            deal_number: '',
            product_id: '',
            channel_name: '',
            deal_cap: '',
            unit_price: '', //Inclusive rate per item
            //Inclusive Tax Amount
            vat: '',
            exclusive_text_amount: '',
            p_p_rate: '',
            //P & P total amount(calculation)
            deal_price: '',
            p_p_vat: '',
            vat_amount: '',
            commission_percentage: '',
            commission_amount: '',
            vat_deduct_commission: '',
            total_net_vat: '',
            total_receivable: '',
            email: '',
            address: '',
            file: null
        })
        return {form}
    },
    data() {
        return {}
    },

    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Add Deal";
        if (this.deals) {
            this.update = true;
            let data = this.deals;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('deals.update', this.deals.id))
            } else {
                this.form.post('/deals')
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
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}
.error {
    margin-top: 0px !important;
}

</style>
