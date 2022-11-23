<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h6 class="invoice-from ">
                                    Add Documents
                                </h6>
                            </div>
                            <div class="header  mt-1" v-if="Object.keys(errors).length > 0">
                                <div class="alert bg-rgba-danger alert-dismissible mb-2 message" role="alert">
                                    <div class="d-flex align-items-center" v-for="error in errors" v-bind:key="error">

                                        <i class="bx bx-error"></i>
                                        <span>
                                            <jet-input-error :message="error" class="mt-2 error " />
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body m-0 p-0">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="modal-body pb-0 ">
                                            <div class="row form-group mb-0">
                                                <div class="col-md-9 col-12 form-group pl-0 file">
                                                    <div class="custom-file">
                                                        <input type="file" name="file" class="custom-file-input"
                                                            id="file" @change="onFileChange">
                                                        <label class="custom-file-label pl-1" for="file">Choose
                                                            file</label>
                                                    </div>
                                                        </div>                                 
                                                    <div class="col-md-2 col-12 pl-0 d-flex justify-content-start  file">
                                                    <button type="submit" class="btn btn-primary mb-3 ">
                                                        Import
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-11 d-flex justify-content-start px-0 file">
                                <inertia-link :href="route('building.index')" type="button"
                                    class="btn btn-light-secondary mb-2 ml-2 mt-0">
                                    Back
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </admin-layout>
</template>

<script>
    import moment from 'moment';
    import AdminLayout from "../../../Layouts/AdminLayout";
    import { useForm } from '@inertiajs/inertia-vue3'
    import ErrorComponent from "../../../components/ErrorComponent";
    import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";
    import JetInputError from ".././../../Jetstream/InputError";

    export default {
        name: "View",
        props: ['errors'],
        components: {
            AdminLayout,
            JetInputError,
            ErrorComponent,
            ConfirmatiomModal,
        },

        setup() {
            const form = useForm({
                file: '',
            })
            return { form }
        },

        data() {
            return {
                sweetAlert: false,
                itemId: "",
            };
        },

        beforeMount() {
            document.title = process.env.MIX_APP_NAME + " - Building Import Export";
        },

        methods: {
            submit() {
                this.form.post('/building-file-import');
            },

            onFileChange(event) {
                this.form.file = event.target.files[0];
            },

            Clicked() {
                this.sweetAlert = false;
            },
            deleteItem() {
                this.sweetAlert = false;
                this.$inertia.delete(`/building-file-delete/${this.itemId}`);
            },
            confirmDeletedoc(id) {
                this.sweetAlert = true;
                this.itemId = id;
            }
        },
    };

</script>

<style scoped>
    .line {
        border-top: 1px dashed #c7cfd6;
        width: 100%;
    }

    .error {
        margin-top: 0px !important;
    }

    .custom-padding {
        padding: 7px;
    }

    .file {
        margin-left: 5px;
    }

    .name {
        padding-top: 7px;
    }

    .icon {
        padding-top: 2px;
    }
</style>