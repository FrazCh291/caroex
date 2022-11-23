<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-10 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <div v-if="Object.keys(errors).length > 0" class="header  mt-1">
                                    <div class="alert bg-rgba-danger alert-dismissible mb-2 message" role="alert">
                                        <div v-for="error in errors" class="d-flex align-items-center">
                                            <i class="bx bx-error"></i>
                                            <span>
                                            <jet-input-error :message="error" class="mt-0 error "/>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-horizontal" @submit.prevent="submit">
                                        <div class="form-body md-6">
                                            <div class="form-group">
                                                <label>Imports </label>
                                                <div class="custom-file">
                                                    <input id="inputGroupFile02" class="custom-file-input" multiple
                                                           required type="file"
                                                           @input="form.file = $event.target.files"/>
                                                    <label class="custom-file-label" for="inputGroupFile02">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button class="btn btn-primary mr-1 mb-1" type="submit">
                                                    Upload
                                                </button>
                                                <inertia-link :href="route('orders.index')"
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
import {useForm} from '@inertiajs/inertia-vue3'
import AdminLayout from "../../Layouts/AdminLayout";
import Label from "../../Jetstream/Label";
import JetInputError from './../../Jetstream/InputError';
import ErrorComponent from '../../components/ErrorComponent'


export default {
    props: ["setting", "errors"],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            file: null,
        })

        function submit() {
            this.form.post('/erp/imports/store')
        }

        return {form, submit}
    },
    methods: {
    
    }
}
</script>
