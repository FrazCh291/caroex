<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 v-if="user" class="card-title">Edit Users</h4>
                                <h4 v-else class="card-title">Add Users</h4>
                                <div v-if="Object.keys(errors).length > 0" class="header  mt-1">
                                    <div class="alert bg-rgba-danger alert-dismissible mb-2 message" role="alert">
                                        <div v-for="error in errors" class="d-flex align-items-center">
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
                                    <form class="form form-horizontal" @submit.prevent="submit">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row pt-1 pb-0 mb-0">
                                                        <div class="col-md-3">
                                                            <label>Name *</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input id="name" v-model="form.name" class="form-control"
                                                                   name="name"
                                                                   type="text">
                                                            <ErrorComponent input="name"></ErrorComponent>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="d-flex justify-content-center mb-0 responsive-image">
                                                                <img v-if="photo"
                                                                     class="rounded-circle pro-image justify-content-center"
                                                                     id="profile-image"
                                                                     :src="photo">
                                                                <img v-else
                                                                    :src="form.profile_photo_path ?  $page.props.base_path + form.profile_photo_path: '/img/avator2.jpg'"
                                                                     class="rounded-circle pro-image justify-content-center ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group pb-0 mb-0">
                                                        <div class="col-md-3">
                                                            <label>Email *</label>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <input id="email" v-model="form.email" class="form-control"
                                                                   name="email"
                                                                   type="email">
                                                            <ErrorComponent input="email"></ErrorComponent>
                                                        </div>
                                                        <div  class="col-md-3 form-group">
                                                            <div class="d-flex justify-content-center mb-0 responsive-image">
                                                                <input type="file"
                                                                       @change="preview_image($event)"
                                                                       id="profile-upload"
                                                                       ref="photo"
                                                                       @input="form.profile_photo_path = $event.target.files"
                                                                       style="display:none"/>
                                                                <label for="profile-upload"
                                                                       class="btn btn-light-secondary btn-sm mt-0.5 justify-content-center small">
                                                                    Select Image
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-11 d-flex justify-content-start px-0">
                                                        <button class="btn btn-primary mr-1 mb-1" type="submit">
                                                            Save
                                                        </button>
                                                        <inertia-link class="btn btn-light-secondary mr-1 mb-1"
                                                                      type="button">
                                                            Back
                                                        </inertia-link>
                                                    </div>
                                                </div>
<!--                                                <div class="col-md-2">-->
<!--                                                    <div class="d-flex justify-content-center mb-0 responsive-image">-->
<!--&lt;!&ndash;                                                        <img v-if="user.profile_photo_path"&ndash;&gt;-->
<!--&lt;!&ndash;                                                             class="rounded-circle pro-image justify-content-center"&ndash;&gt;-->
<!--&lt;!&ndash;                                                             id="profile_photo_path"&ndash;&gt;-->
<!--&lt;!&ndash;                                                             :src="/img/avator2.jpg">&ndash;&gt;-->
<!--                                                        <img :src="'/img/avator2.jpg'"-->
<!--                                                             class="rounded-circle pro-image justify-content-center ">-->
<!--                                                    </div>-->
<!--                                                    <div class="d-flex justify-content-center mb-0 responsive-image">-->
<!--                                                        <input type="file"-->
<!--                                                               @change="profile_photo_path"-->
<!--                                                               id="profile_photo_path"-->
<!--                                                               ref="profile_photo_path"-->
<!--                                                               style="display:none"/>-->
<!--                                                        <label for="profile_photo_path"-->
<!--                                                               class="btn btn-light-secondary btn-sm mt-0.5 justify-content-center small">-->
<!--                                                            Select Image-->
<!--                                                        </label>-->
<!--                                                    </div>-->
<!--                                                </div>-->
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
    props: ['users', 'user', 'errors'],
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
            profile_photo_path: '',
        })
        return {form}
    },
    data() {
        return {
            photoPreview: '',
            photo: '',
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Module";
        if (this.user) {
            this.update = true;
            let data = this.user;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    mounted() {
        if (this.user) {
            this.photo = this.user.profile_photo_path ? this.$page.props.base_path + this.user.profile_photo_path : '/img/avator2.jpg'
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('user.profile.update', this.user.id))
            } else {
                this.form.post('/users')
            }
        },
        preview_image(e) {
            const file = e.target.files[0];
            this.photo = URL.createObjectURL(file);
        },
    },
}
</script>

<style scoped>

.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}

.pro-image {
            width: 100px !important;
            height: 100px !important;
}
.error {
    margin-top: 0px !important;
}

@media (max-width: 575.98px) {
    .responsive-image {
        justify-content: left !important;
    }

    .pro-image {
        margin-left: 10px !important;
        margin-bottom: 5px !important;
    }
}


</style>
