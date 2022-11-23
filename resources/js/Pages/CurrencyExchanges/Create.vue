<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title">EXCHANGES RATE</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line"/>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>From-To*</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select class="form-select" v-model="form.from_to" name="from_to">
                                                        <option value=""> Please Select</option>
                                                        <option v-for="currency_exchange in currency_exchanges"
                                                                :value="currency_exchange.value">
                                                            {{ currency_exchange.value }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="currency_exchange"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Date *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="date"
                                                        id="date"
                                                        v-model="form.date"
                                                        class="form-control"
                                                        name="date"
                                                    />
                                                    <ErrorComponent input="date"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Amount *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="amount"
                                                        v-model="form.amount"
                                                        class="form-control"
                                                        name="amount"
                                                    />
                                                    <ErrorComponent input="amount"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link
                                                    :href="route('exchanges-rates.index')"
                                                    type="button"
                                                    class="btn btn-light-secondary mr-1 mb-1"
                                                >
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
import moment from 'moment';
import AdminLayout from "../../Layouts/AdminLayout";
import Label from "../../Jetstream/Label";
import JetInputError from "./../../Jetstream/InputError";
import {useForm} from "@inertiajs/inertia-vue3";
import ErrorComponent from "../../components/ErrorComponent";

export default {
    name: "Create",
    props: ['currencyExchanges', 'currency_exchanges'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            from_to: "",
            date: "",
            amount: "",
        });
        return {form};
    },
    data() {
        return {};
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Core";
        if (this.currencyExchanges) {
            this.update = true;
            let data = this.currencyExchanges;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('exchanges-rates.update', this.currencyExchanges.id))
            } else {
                this.form.post('/super/admin/exchanges-rates')
            }
        },
    },
};
</script>

<style scoped>
.line {
    border-top: 1px dashed #c7cfd6;
    width: 100%;
}

.error {
    margin-top: 0px !important;
}
</style>
