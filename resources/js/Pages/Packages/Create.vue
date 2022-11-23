<template>
    <admin-layout>
        <div>
        <section id="basic-horizontal-layouts">
            <div class="row match-height">
                <div class="col-md-9 col-12">
                    <div class="card">
                        <div class="card-header pb-0 mb-0">
                            <h4 class="card-title" v-if="module">Edit Package</h4>
                            <h4 class="card-title" v-else>Add Package</h4>
                            <!-- <div class="header  mt-1" v-if="Object.keys(errors).length > 0">
                                <div class="alert bg-rgba-danger alert-dismissible mb-2 message" role="alert">
                                    <div class="d-flex align-items-center" v-for="error in errors">
                                        <i class="bx bx-error"></i>
                                        <span>
                                                  <jet-input-error :message="error" class="mt-2 error "/>
                                            </span>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="px-2 pb-1">
                            <hr class="line">
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form @submit.prevent="submit" class="form form-horizontal">
                                    <div class="form-body">
                                        <div class="row form-group pt-2">
                                            <div class="col-md-3">
                                                <label>Name *</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="name" v-model="form.name"
                                                       class="form-control"
                                                       name="title">
                                                <ErrorComponent input="name"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group pt-2">
                                            <div class="col-md-3">
                                                <label>Duration *</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="duration" v-model="form.duration"
                                                       class="form-control"
                                                       name="duration">
                                                <ErrorComponent input="duration"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group pt-2">
                                            <div class="col-md-3">
                                                <label>Number of User *</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="number_of_user" v-model="form.number_of_user"
                                                       class="form-control"
                                                       name="number_of_user">
                                                <ErrorComponent input="number_of_user"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group pt-2">
                                            <div class="col-md-3">
                                                <label>Price *</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" id="price" v-model="form.price"
                                                       class="form-control"
                                                       name="price">
                                                <ErrorComponent input="price"></ErrorComponent>
                                            </div>
                                        </div>

                                        <div class="row form-group pt-2">
                                            <div class="col-md-3">
                                                <label>Modules *</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <Multiselect123
                                                    v-model="form.value"
                                                    mode="tags"
                                                    :searchable="true"
                                                    :createTag="true"
                                                    :options="options"/>
                                                <ErrorComponent input="value"></ErrorComponent>
                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Is One Time</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <select class="form-control" v-model.lazy="form.is_one_time"
                                                        id="is_one_time"
                                                        name="status">
                                                    <option value="1">True</option>
                                                    <option value="0">False</option>

                                                </select>
                                                <ErrorComponent input="is_one_time"></ErrorComponent>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>Status</label>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <div
                                                    class="custom-control custom-switch custom-switch-success mr-2 mb-1">
                                                    <input type="checkbox" class="custom-control-input"
                                                           v-model="form.status" v-if="form.status == 1"
                                                           checked id="customSwitch11">
                                                    <input type="checkbox" class="custom-control-input"
                                                           v-model="form.status" v-else id="customSwitch11">
                                                    <label class="custom-control-label" for="customSwitch11">
                                                            <span class="switch-icon-left"><i
                                                                class="bx bx-check"></i></span>
                                                        <span class="switch-icon-right"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-11 d-flex justify-content-start px-0">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1"
                                                    v-if="form.processing" disabled>
                                                    <span class="spinner-border spinner-border-sm pb-0.5" role="status"
                                                          aria-hidden="true"></span>
                                                <span class="">Saving...</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary mr-1 mb-1" v-else>
                                                Save
                                            </button>
                                            <inertia-link :href="route('packages.index')" type="button"
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
import Multiselect123 from '@vueform/multiselect'

export default {
    name: "Create",
    props: ['modules', 'errors', 'package', 'values'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
        Multiselect123
    },
    setup() {
        const form = useForm({
            name: '',
            price: '',
            is_one_time: '',
            duration: '',
            number_of_user: '',
            status: false,
            value: []
        })
        return {form}
    },
    mounted() {
       if(this.statusData)
       {
           this.form.status = true
       }
        if (this.values) {
            var valueArr = [];
            this.values.forEach((value, index) => {
                valueArr.push(value.id);
            });
            this.form.value = valueArr;
        }
    },
    data() {
        return {
            statusData: false,
            options: []
        }
    },
    beforeMount() {
        let modulesArr = [];
        this.modules.forEach((value, index) => {
            var obj = {"value": value.id, "label": value.name};
            modulesArr.push(obj);
        });
        this.options = modulesArr;
        document.title = process.env.MIX_APP_NAME + " - Create Module";
        if (this.package) {
            this.update = true;
            let data = this.package;
            Object.assign(data, {
                '_method': 'PUT',
                'value': this.form.value,
                'status': this.package.status,
            })
            if (data.status == 1) {
                 this.statusData = true
            }
            this.form = this.$inertia.form(data);
        }
    },

    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('packages.update', this.package.id))
            } else {
                this.form.post('/super/admin/packages')
            }
        },
    }
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>

.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}

.error {
    margin-top: 0px !important;
}

</style>
