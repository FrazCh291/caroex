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
                                                        <input type="file" name="file" class="custom-file-input"
                                                               id="file"
                                                               multiple
                                                               @input="form.file = $event.target.files"/>
                                                        <ErrorComponent input="file"></ErrorComponent>
                                                        <label class="custom-file-label" for="file">Choose file</label>
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
                                                <inertia-link :href="route('cases.show', caseId)" v-if="caseId"
                                                              type="button"
                                                              class="btn btn-light-secondary mr-1 mb-1">
                                                    Back
                                                </inertia-link>
                                                <inertia-link :href="route('cases.show', cases.id)" v-else
                                                              type="button"
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

    import Label from "../../../Jetstream/Label";
    import {useForm} from '@inertiajs/inertia-vue3'
    import AdminLayout from "../../../Layouts/AdminLayout";
    import JetInputError from './../../../Jetstream/InputError'
    import ErrorComponent from '../../../components/ErrorComponent'

    export default {
        name: "Create",
        props: ['cases', 'document', 'caseId'],
        components: {
            Label,
            AdminLayout,
            JetInputError,
            ErrorComponent,
        },

        setup() {
            const form = useForm({
                case_id: '',
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
            document.title = process.env.MIX_APP_NAME + " - Create Cases Documents";
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
                    this.form.post(route('case.document', this.document.id))
                    this.update = false;
                } else {
                    this.form.case_id = this.cases.id;
                    this.form.post('/fulfilment/cases/document/store', this.case_id);
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
</style>
