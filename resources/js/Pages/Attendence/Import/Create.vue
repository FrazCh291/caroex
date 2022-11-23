<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-10 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <div class="header  mt-1" v-if="Object.keys(errors).length > 0">
                                    <div class="alert bg-rgba-danger alert-dismissible mb-2 message" role="alert">
                                        <div class="d-flex align-items-center" v-for="error in errors">
                                            <i class="bx bx-error"></i>
                                            <span>
                                            <jet-input-error :message="error" class="mt-0 error "/>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body md-6">
                                            <div class="form-group">
                                                <label>Imports </label>
                                                <div class="custom-file">
                                                    <input type="file" name="file" id="file" @input="form.file = $event.target.files" class="custom-file-input"
                                                           multiple
                                                           @change="updateList()"/>
                                                    <label class="custom-file-label" id="fileList">Choose file</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Upload
                                                </button>
                                                <inertia-link :href="route('attendence.import')" type="button"
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
import {useForm} from "@inertiajs/inertia-vue3";
import Pagination from "../../../admin/Pagination";
import AdminLayout from "../../../Layouts/AdminLayout";
import JetInputError from '../../../Jetstream/InputError';
import ErrorComponent from "../../../components/ErrorComponent";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";

export default {
    name: "Index",
    props: ["datetimes", "errors", "params"],

    components: {
        AdminLayout,
        ErrorComponent,
        Pagination,
        ConfirmatiomModal,
        JetInputError
    },

    setup() {
        const form = useForm({
            file: "",
        });
        return {form};
    },
    data() {
        return {
            query: {
                query: "",
                id: false,
            },
            sweetAlert: false,
            itemId: "",
            file: ''
        };
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - attendence Import";
    },
    mounted() {
        if (this.params) {
            let params = Object.keys(this.params);
            for (let i of params) {
                Object.assign(this.query, {[i]: this.params[i]});
            }
        }
    },

    methods: {
        resetQuery() {
            this.query = {};
            this.loadData();
        },

        submit() {
            this.form.post("/erp/attendence-store");
        },

        selectFile() {
            let fileInputElement = this.$refs.file;
            fileInputElement.click();

        },

        stopPropagation(e) {
            e.stopPropagation();
        },

        Clicked() {
            this.sweetAlert = false;
        },

        updateList() {
            var input = document.getElementById('file');
            var output = document.getElementById('fileList');
            output.innerHTML = '<div>';
            for (var i = 0; i < input.files.length; ++i) {
                output.innerHTML += '<div>' + input.files.item(i).name + '</div>';
            }
            output.innerHTML += '</div>';
        },

        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]});
                }
            }
            this.$inertia.visit(route("attendence.import"), {
                method: "get",
                data: {
                    ...query,
                },
            });
        },
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

@media screen and (max-width: 600px) {
    #import-button {
        padding-left: 0px;
    }
}

@media screen and (min-width: 1200px) {
    #file {
        margin-left: 5px;
    }

    #import-button {
        padding-left: 32px;
    }
}
</style>
