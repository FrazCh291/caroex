<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="questionnaire">Edit Questionnaire</h4>
                                <h4 class="card-title" v-else>Add Questionnaire</h4>
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
                                                    <label>Label *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="label" v-model="form.label" placeholder=""
                                                           class="form-control"
                                                           name="label">
                                                    <ErrorComponent input="label"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Value *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="	value" v-model="form.value" placeholder=""
                                                           class="form-control"
                                                           name="value">
                                                    <ErrorComponent input="value"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Type *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="	type" v-model="form.type" placeholder=""
                                                           class="form-control"
                                                           name="type">
                                                    <ErrorComponent input="type"></ErrorComponent>
                                                </div>
                                            </div>
                                               <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Description *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                       <textarea  class="form-control no-resize" rows="3"
                                                              v-model="form.description" placeholder="" ></textarea>
                                                    <ErrorComponent input="description"></ErrorComponent>
                                                </div>
                                            </div>
                                           <div class="form-body pt-2 pb-0 mb-0">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>Status</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                 <div class="col-md-6 form-group">
                                                <div
                                                    class="custom-control custom-switch custom-switch-success mr-2 mb-1">
                                                    <input type="checkbox" class="custom-control-input"
                                                           v-model="form.is_enable" v-if="form.is_enable == 1"
                                                           checked id="customSwitch11">
                                                    <input type="checkbox" class="custom-control-input"
                                                           v-model="form.is_enable" v-else id="customSwitch11">
                                                    <label class="custom-control-label" for="customSwitch11">
                                                            <span class="switch-icon-left"><i
                                                                class="bx bx-check"></i></span>
                                                        <span class="switch-icon-right"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                                    </div>
                                                </div>
                                                </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('questionnaires.index')" type="button"
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
    props: ['questionnaire', 'errors'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent
    },
    setup() {
        const form = useForm({
            label: '',
            value: '',
            type: '',
            description: '',
            is_enable: '',
        })
        return {form}
    },
    data() {
        return {
            statusData: false,
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Questionnaire";
        if (this.questionnaire) {
            this.update = true;
            let data = this.questionnaire;
            Object.assign(data, {
                '_method': 'PUT',
                'is_enable': this.questionnaire.is_enable,
            })
            if (data.is_enable == 1) {
                 this.statusData = true
            }
            this.form = this.$inertia.form(data);
        }
    },
        mounted() {
       if(this.statusData)
       {
           this.form.is_enable = true
       }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('questionnaires.update', this.questionnaire.id))
            } else {
                this.form.post('/questionnaires')
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
