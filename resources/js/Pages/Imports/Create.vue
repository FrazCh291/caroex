<template>
    <admin-layout>
        <toastr type="error" :message="validation_error" v-if="validation_error"/>
        <div class="alert border-warning alert-dismissible mb-2" role="alert" v-if="supervisorError">
            <div class="d-flex align-items-center">
                <i class="bx bx-error-circle"></i>
                <span>
                    Warning! {{supervisorError}}
                </span>
            </div>
        </div>
        <template>
            <div class="row">
                <div class="col-md-10 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body py-0">
                                <file-upload :url="route('imports.store')" @supervisor_error="getError"
                                             @fileError="showToastrMessage"></file-upload>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </admin-layout>
</template>
<script>
import AppLayout from '../../Layouts/AppLayout';
import JetActionMessage from '../../Jetstream/ActionMessage'
import JetButton from '../../Jetstream/Button'
import JetFormSection from '../../Jetstream/FormSection'
import JetInput from '../../Jetstream/Input'
import JetInputError from '../../Jetstream/InputError'
import JetLabel from '../../Jetstream/Label'
import AdminLayout from "../../Layouts/AdminLayout";
import Header from "../../admin/Header";
import FileUpload from "../../admin/FileUpload";
import Toastr from "../../components/Toastr";

export default {
    name: "Create",
    props: {
        errors: Object,
    },
    components: {
        FileUpload,
        AdminLayout,
        AppLayout,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        Header,
        Toastr
    },
    data() {
        return {
            import_suppliers: '',
            sent: false,
            supervisorError: '',
            validation_error: ''
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Import";
    },
    methods: {
        getError(errorMsg) {
            this.supervisorError = errorMsg;
            setTimeout(() => this.supervisorError = '', 3000)
        },
        showToastrMessage(message) {
            this.validation_error = message;
        }
    }
}
</script>
<style scoped>

</style>
