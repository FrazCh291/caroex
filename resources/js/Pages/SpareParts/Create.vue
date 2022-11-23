<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="sample">Edit Spare Part</h4>
                                <h4 class="card-title" v-else>Add Spare Part</h4>
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
                            <!-- hgghhgh -->
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="name" v-model="form.name"
                                                           class="form-control"
                                                           name="name">
                                                    <ErrorComponent input="name"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Code *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="code" v-model="form.code"
                                                           class="form-control"
                                                           name="code">
                                                    <ErrorComponent input="code"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
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
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Image</label>
                                                </div>
                                                <div class="col-md-6  form-group file">
                                                    <div class="custom-file">
                                                        <input type="file" name="image" class="custom-file-input"
                                                               id="image" @change="onFileChange">
                                                        <label class="custom-file-label pl-1" for="image">Choose
                                                            file</label>
                                                        <ErrorComponent input="image"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('spare-parts.index')" type="button"
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
    props: ['sparePart', 'errors'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            name: '',
            image: '',
            code: '',
            quantity: '',
        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Module";
        if (this.sparePart) {
            this.update = true;
            let data = this.sparePart;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('spare-parts.update', this.sparePart.id))
            } else {
                this.form.post('/erp/spare-parts')
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
