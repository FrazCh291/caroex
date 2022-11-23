<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="document">Edit Documents</h4>
                                <h4 class="card-title" v-else>Add Documents</h4>
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
                                                <div class="col-md-9 form-group">
                                                    <input type="text" id="title"
                                                           class="form-control" name="title" v-model="form.title">
                                                    <ErrorComponent input="title"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Upload File</label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <div class="custom-file">
                                                    <input type="file" name="file" id="file" @input="form.file = $event.target.files" class="custom-file-input"
                                                           multiple
                                                           @change="updateList()"/>
                                                       <label class="custom-file-label" id="fileList">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Description</label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <textarea class="form-control" id="description" name="description"
                                                              v-model="form.description" rows="3"
                                                              placeholder="Add Description">
                                                    </textarea>
                                                    <ErrorComponent input="description"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <!-- <inertia-link :href="route('deals.show', deal.deal_number)"
                                                              type="button"
                                                              class="btn btn-light-secondary mr-1 mb-1" v-if="deal">
                                                    Back
                                                </inertia-link>
                                                <inertia-link :href="route('deals.show', dealNumber.deal_number)"
                                                              type="button"
                                                              class="btn btn-light-secondary mr-1 mb-1"
                                                              v-else="document">
                                                    Back
                                                </inertia-link> -->
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
    name: "Create",
    props: ['employee', 'document'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },

    setup() {
        const form = useForm({
            employee_id: '',
            title: '',
            description: '',
            file: null
        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Employee Documents";
        if (this.document) {
            this.update = true;
            let data = this.document;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },

    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('employee.document.update', this.document.id))
                this.update = false;
            } else {
                this.form.employee_id = this.employee.id;
                this.form.post('/erp/employees/document/store', this.employee_id);
            }
        },
     
        updateList() {
            var input = document.getElementById('file');
            var output = document.getElementById('fileList');
            output.innerHTML = '<div>';
            for (var i = 0; i < input.files.length; ++i) {
                output.innerHTML += '<div>' + input.files.item(i).name + '</div>';
            }
            output.innerHTML += '</div>';
        },

    }
}
</script>

<style scoped>
.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}
</style>
