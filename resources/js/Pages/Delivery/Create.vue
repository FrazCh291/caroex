<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12 ml-1">
                        <div class="card">
                             <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="editmanifest">Edit Manifest File</h4>
                                <h4 class="card-title" v-else>Add Manifest File</h4>
                                <div class="header  mt-1" v-if="Object.keys(errors).length > 0">
                            </div>
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
                                                    <label>File *</label>
                                                </div>
                                               <div class="col-md-6  form-group file">
                                                    <div class="custom-file">
                                                        <input type="file" name="file" class="custom-file-input"
                                                            id="file" @change="onFileChange">
                                                        <label class="custom-file-label pl-1" for="file">Choose
                                                            file</label>
                                                            <ErrorComponent input="file"></ErrorComponent>
                                                    </div>
                                                </div>

                                            </div>
                                           <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('delivery.show', this.deliveryID)" type="button"
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
    props: ['errors' , 'editmanifest' , 'deliveryID'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            file: '',
            file_type:'',
            deliveryID:'',
        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Manifest";
        if (this.editmanifest) {
            this.update = true;
            let data = this.editmanifest;
             Object.assign(data, {
                '_method': 'PUT',
            })
            data.file=this.form.file;
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
         onFileChange(event) {
                this.form.file = event.target.files[0];
            },
        submit() {
            if (this.update) {
                this.form.post(route('manifestUpdate', this.editmanifest.id))
            } else {
                this.form.deliveryID = this.deliveryID
                this.form.post('/erp/admin/importfile/manifest/file')
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
