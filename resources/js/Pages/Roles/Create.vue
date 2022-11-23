<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="role">Edit Role</h4>
                                <h4 class="card-title" v-else>Add Role</h4>
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
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="role" v-model="form.role"
                                                           class="form-control"
                                                           name="role">
                                                    <ErrorComponent input="role"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Slug *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="slug" v-model="form.slug"
                                                           class="form-control"
                                                           name="type" placeholder="">
                                                    <ErrorComponent input="slug"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Order *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="order" v-model="form.order"
                                                           class="form-control"
                                                           name="order" placeholder="">
                                                    <ErrorComponent input="order"></ErrorComponent>
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
                                                               v-model="form.enable" v-if="form.status == 1"
                                                               checked id="customSwitch11">
                                                        <input type="checkbox" class="custom-control-input"
                                                               v-model="form.enable" v-else id="customSwitch11">
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
                                                <inertia-link :href="route('roles.index')" type="button"
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
        props: ["role", "errors"],
        components: {
            Label,
            AdminLayout,
            JetInputError,
            ErrorComponent
        },
        setup() {
            const form = useForm({
                'role': '',
                'slug': '',
                'order': '',
                'enable': false
            });
            return {form}
        },
        data() {
            return {}
        },
        beforeMount() {
            document.title = process.env.MIX_APP_NAME + " - Create Role";
            if (this.role) {
                this.update = true;
                let data = this.role;
                Object.assign(data, {
                    '_method': 'PUT',
                    'enable': this.role.enable
                });
                this.form = this.$inertia.form(data);
            }
        },
        methods: {
            submit() {
                if (this.update) {
                    this.form.post(route('roles.update', this.role.id))
                } else {
                    this.form.post('/super/admin/roles')
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
