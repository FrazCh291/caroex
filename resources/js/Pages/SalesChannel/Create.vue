 <template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="core">Edit Channel</h4>
                                <h4 class="card-title" v-else>Add Channel</h4>
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
                                            <div class="row form-group pt-2">
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
                                                    <label>Slug *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="slug" v-model="form.slug" class="form-control" name="slug">
                                                    <ErrorComponent input="slug"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="form-body py-1">
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label>Status *</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset>
                                                            <div class="checkbox">
                                                                <input type="checkbox" class="checkbox-input"
                                                                       v-model="form.status" id="checkbox1" checked="">
                                                                <label for="checkbox1"></label>
                                                            </div>
                                                        </fieldset>
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
                                                <inertia-link :href="route('channels.index')" type="button"
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
    props: ['channel', 'errors'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            name: '',
            slug: '',
            status: false
        })
        return {form}
    },
    data() {
        return {}
    },

    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Channel";
        if (this.channel) {
            this.update = true;
            let data = this.channel;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
            if (this.form.status == 1) {
                this.form.status = true;
            }
        }
    },

    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('channels.update', this.channel.id))
            } else {
                this.form.post('/erp/admin/channels')
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
