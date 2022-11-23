<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="emailSetting">Edit Email</h4>
                                <h4 class="card-title" v-else>Add Email</h4>
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
                                                    <label>Username *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="username" v-model="form.username"
                                                           class="form-control"
                                                           name="username">
                                                    <ErrorComponent input="username"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="form-body">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>Password *</label>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="password" id="password" v-model="form.password"
                                                               class="form-control"
                                                               name="password">
                                                          <ErrorComponent input="password"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-body">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>protocol *</label>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="text" id="protocol" v-model="form.protocol"
                                                               class="form-control"
                                                               name="protocol">
                                                    <ErrorComponent input="protocol"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-body">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>INCOMING SERVER *</label>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="text" id="incoming-server"
                                                               v-model="form.incoming_server"
                                                               class="form-control"
                                                               name="incoming_server">
                                                         <ErrorComponent input="incoming_server"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-body">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>INCOMING PORT *</label>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="text" id="incoming-port"
                                                               v-model="form.incoming_port"
                                                               class="form-control"
                                                               name="incoming_port">
                                                                <ErrorComponent input="incoming_port"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-body">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>INCOMING ENCRYPTION *</label>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="text" id="incoming-encryption"
                                                               v-model="form.incoming_encryption"
                                                               class="form-control"
                                                               name="incoming_encryption">
                                                     <ErrorComponent input="incoming_encryption"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-body">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>SMTP OUTGOING SERVER *</label>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="text" id="smtp-outgoing-server"
                                                               v-model="form.smtp_outgoing_server"
                                                               class="form-control"
                                                               name="smtp_outgoing_server">
                                                   <ErrorComponent input="smtp_outgoing_server"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-body">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>SMTP OUTGOING PORT *</label>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="text" id="smtp-outgoing-port"
                                                               v-model="form.smtp_outgoing_port"
                                                               class="form-control"
                                                               name="smtp_outgoing_port">
                                                         <ErrorComponent input="smtp_outgoing_port"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-body">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>SMTP OUTGOING ENCRYPTION *</label>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="text" id="smtp-outgoing-encryption"
                                                               v-model="form.smtp_outgoing_encryption"
                                                               class="form-control"
                                                               name="smtp_outgoing_encryption">
                                                      <ErrorComponent input="smtp_outgoing_encryption"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-body">
                                                <div class="row form-group">
                                                    <div class="col-md-3">

                                                        <label>Email Account *</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control" v-model="form.email_account_id"
                                                                name="channel_id">
                                                            <option value=""></option>
                                                            <option v-for="emailAccount in emailAccounts" :value="emailAccount.id">
                                                                {{ emailAccount.name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-body py-1">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>Status *</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset>
                                                            <div class="checkbox">
                                                                <input type="checkbox" class="checkbox-input"
                                                                       v-model="form.status" id="checkbox1" checked="">
                                                                <label for="checkbox1"></label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <!--                                                <button type="submit" class="btn btn-primary mr-1 mb-1"-->
                                                <!--                                                        v-if="form.processing" disabled>-->
                                                <!--                                                    <span class="spinner-border spinner-border-sm pb-0.5" role="status"-->
                                                <!--                                                          aria-hidden="true"></span>-->
                                                <!--                                                    <span class="">Saving...</span>-->
                                                <!--                                                </button>-->
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('email-settings.index')" type="button"
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
    props: ['emailSetting', 'emailAccounts', 'errors'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
         ErrorComponent,
    },
    setup() {
        const form = useForm({
            username: '',
            password: '',
            smtp_outgoing_server: '',
            incoming_server: '',
            incoming_port: '',
            protocol: '',
            incoming_encryption: '',
            smtp_outgoing_port: '',
            smtp_outgoing_encryption: '',
            email_account_id: '',
            status: false
        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Email";
        if (this.emailSetting) {
            this.update = true;
            let data = this.emailSetting;
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
                this.form.post(route('email-settings.update', this.emailSetting.id))
            } else {
                this.form.post('/erp/admin/email-settings')
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
