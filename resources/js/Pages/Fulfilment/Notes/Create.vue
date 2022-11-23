<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="notes">Edit Action</h4>
                                <h4 class="card-title" v-else>Add Action</h4>
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
                                                    <label>User *</label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <input type="text" id="user" disabled
                                                           class="form-control" name="user_id" v-model="userName.name">
                                                    <ErrorComponent input="user_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Comment*</label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <textarea class="form-control" id="comment" name="comment"
                                                              v-model="form.comment" rows="3"
                                                              placeholder="Add comment">
                                                    </textarea>
                                                    <ErrorComponent input="comment"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('case.show', cases.id)"
                                                              type="button"
                                                              class="btn btn-light-secondary mr-1 mb-1" v-if="cases">
                                                    Back
                                                </inertia-link>
                                                <inertia-link :href="route('case.show', caseId.id)"
                                                              type="button"
                                                              class="btn btn-light-secondary mr-1 mb-1"
                                                              v-else="caseId">
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
    props: ['notes', 'caseId', 'cases', 'userName'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },

    setup() {
        const form = useForm({
            case_id: '',
            comment: ''
        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Notes";
        if (this.notes) {
            this.update = true;
            let data = this.notes;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },

    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('case.notes.update', this.notes.id))
                this.update = false;
            } else {
                this.form.case_id = this.cases.id;
                this.form.post('/fulfilment/cases/notes/store', this.case_id);
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
