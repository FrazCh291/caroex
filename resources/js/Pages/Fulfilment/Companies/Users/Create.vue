<template>
    <div>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title">Add User</h4>
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
                                                    <input type="text" id="name" v-model="form.name"
                                                           class="form-control"
                                                           name="name">
                                                    <ErrorComponent input="name"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Email *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="phone" v-model="form.email"
                                                           class="form-control"
                                                           name="email">
                                                    <ErrorComponent input="email"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Role *</label>
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <div class="d-flex">
                                                        <div class=" w-100">
                                                            <select class="form-control" id="role_id" name="role_id"
                                                                    v-model="form.role_id">
                                                                <option value=""></option>
                                                                <option v-for="role in roles" :value="role.id">
                                                                    {{ role.role }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="flex-shrink-1" data-toggle="modal"
                                                             data-target="#inlineForm">
                                                            <button type="button" class="btn btn-primary modalBtn">
                                                                +
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <ErrorComponent input="role_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('companys.users.index')" type="button"
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
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Add Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form @submit.prevent="submitRole">
                        <div class="modal-body mb-1">
                            <label>Role: </label>
                            <div class="form-group">
                                <input v-model="form1.role" type="text" class="form-control">
                                <ErrorComponent input="role"></ErrorComponent>
                            </div>
                            <label>Slug: </label>
                            <div class="form-group mb-0">
                                <input v-model="form1.slug" type="text" class="form-control">
                                <ErrorComponent input="slug"></ErrorComponent>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary"
                                    id="modal-hide"
                                    ref="closeMod"
                                    data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="btn btn-primary ml-1" data-dismiss="modal"
                                    @click="stopPropagation">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </admin-layout>
    </div>
</template>

<script>
import AdminLayout from "../../../../Layouts/AdminLayout";
import Label from "../../../../Jetstream/Label";
import JetInputError from './../../../../Jetstream/InputError'
import {useForm} from '@inertiajs/inertia-vue3'
import ErrorComponent from '../../../../components/ErrorComponent'

export default {
    name: "Create",
    props: ['company_id', 'errors', 'roles'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            name: '',
            email: '',
            company_id: '',
            role_id: ''
        })
        return {form}
    },
    data() {
        return {
            form1: this.$inertia.form({
                role: '',
                slug: '',
                'company_id': this.company_id
            }),
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Users";
        if (this.sample) {
            this.update = true;
            let data = this.sample;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    mounted() {
    },
    methods: {
        stopPropagation(e) {
            e.stopPropagation();
            this.submitRole();
        },
        submitRole() {
            this.form1.post(route('add.role'), {
                onSuccess: (page) => {
                    $('#modal-hide').trigger('click');
                    this.form1 = this.$inertia.form({
                        role: '',
                        slug: '',
                        'company_id': this.company_id
                    });
                }
            });
        },
        submit() {
            if (this.update) {
                this.form.post(route('samples.update', this.sample.id))
            } else {
                this.form.company_id = this.company_id;
                this.form.post(route('companys.users.store'))
            }
        },
    }
}
</script>

<style scoped>

.modalBtn {
    border-radius: 0rem
}

.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}

.error {
    margin-top: 0px !important;
}


</style>
