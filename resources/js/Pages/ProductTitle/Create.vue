<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="productt">Edit Product Title</h4>
                                <h4 class="card-title" v-else>Add Product Title</h4>
                                <div class="header mt-1" v-if="Object.keys(errors).length > 0">
                                    <div
                                        class="alert bg-rgba-danger alert-dismissible mb-2 message"
                                        role="alert"
                                    >
                                        <!-- <div
                                          class="d-flex align-items-center"
                                          v-for="error in errors"
                                        >
                                          <i class="bx bx-error"></i>
                                          <span>
                                            <jet-input-error :message="error" class="mt-2 error" />
                                          </span>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line"/>
                            </div>
                            <div class="card-content">
                                <div class="card-body w-100">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row form-group pt-2">
                                                <div class="col-md-3">
                                                    <label>Product title *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="product_title"
                                                        v-model="form.product_title"
                                                        class="form-control"
                                                        name="product_title"
                                                    />
                                                    <ErrorComponent input="product_title"></ErrorComponent>
                                                    <!--                                                    <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.product_title" required autofocus/>-->
                                                    <!--                                                    <ErrorComponent input="product_title"></ErrorComponent>-->
                                                </div>
                                            </div>
                                            <div class="row form-group">

                                                <!--                                                <div class="col-md-6 form-group">-->
                                                <!--                                                    <div class="d-flex">-->
                                                <!--                                                        <div class=" w-100">-->
                                                <!--                                                            <select class="form-control" id="role_id" name="role_id"-->
                                                <!--                                                                    v-model="form.product_id">-->
                                                <!--                                                                <option value=""></option>-->
                                                <!--                                                                <option v-for="product in products" :value="product.id">-->
                                                <!--                                                                    {{ product.name }}-->
                                                <!--                                                                </option>-->
                                                <!--                                                            </select>-->
                                                <!--                                                        </div>-->
                                                <!--                                                        <div class="flex-shrink-1" data-toggle="modal"-->
                                                <!--                                                             data-target="#inlineForm">-->
                                                <!--                                                            <button type="button" class="btn btn-primary modalBtn">-->
                                                <!--                                                                +-->
                                                <!--                                                            </button>-->
                                                <!--                                                        </div>-->
                                                <!--                                                    </div>-->
                                                <!--                                                    <ErrorComponent input="role_id"></ErrorComponent>-->
                                                <!--                                                </div>-->
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <!--                                                <button type="submit" class="btn btn-primary mr-1 mb-1"-->
                                                <!--                                                        v-if="form.processing" disabled>-->
                                                <!--                                                    <span class="spinner-border spinner-border-sm pb-0.5" role="status"-->
                                                <!--                                                          aria-hidden="true"></span>-->
                                                <!--                                                    <span class="">Saving...</span>-->
                                                <!--                                                </button>-->
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link
                                                    :href="route('products.index')"
                                                    type="button"
                                                    class="btn btn-light-secondary mr-1 mb-1"
                                                >
                                                    Back
                                                </inertia-link>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12 mt-2" v-if="productTitle?productTitle:''">
                                <div class="card"  v-if="productTitle.length>0">
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                <tr>
                                                    <th class="custom-padding">Product Title</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="product_title in productTitle">
                                                    <td class=" custom-padding">
                                                        {{ product_title ? product_title.product_title : '' }}
                                                    </td>
                                                    <td class="text-right py-0 my-0 custom-padding-right">
                                                                                                            <div class="dropdown">
                                                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                    <a :href="route('edit.product.title' , product_title.id)" class="dropdown-item" ><i class="bx bx-edit-alt mr-1"></i>Edit Product Title</a>
                                                    <a :href="route('delete.product.title' , product_title.id)" class="dropdown-item" ><i class="bx bx-trash mr-1"></i>Delete</a>
                                                    </div>
                                                    </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
import JetInputError from "./../../Jetstream/InputError";
import {useForm} from "@inertiajs/inertia-vue3";
import Multiselect123 from "@vueform/multiselect";
import ErrorComponent from "../../components/ErrorComponent";

export default {
    name: "Create",
    props: ["product_id", "errors", "productTitle", "values", "productt"],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        Multiselect123,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            product_title: "",
            product_id: "",
            // value: [],
        });
        return {form};
    },
    data() {
        return {
            options: [],
        };
    },

    beforeMount() {
        let modulesArr = [];
        // this.products.forEach((value, index) => {
        //   var obj = { value: value.id, label: value.name };
        //   modulesArr.push(obj);
        // });
        this.options = modulesArr;
        document.title = process.env.MIX_APP_NAME + " - Create Module";
        if (this.productt) {
            document.title = process.env.MIX_APP_NAME + " - Edit Product Title";
        } else {
            document.title = process.env.MIX_APP_NAME + " - Add Product Title";
        }
        if (this.productt) {
            this.update = true;
            let data = this.productt;
            Object.assign(data, {
                _method: "PUT",
                value: this.form.value,
            });
            this.form = this.$inertia.form(data);
        }
    },
    mounted() {
        if (this.statusData) {
            this.form.status = true;
        }
        if (this.values) {
            var valueArr = [];
            this.values.forEach((value, index) => {
                valueArr.push(value.id);
            });
            this.form.value = valueArr;
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route("product-titles.update", this.productt.id), {
                    onSuccess: (page) => {
                    },
                    onError: (errors) => {
                    },
                });
            } else {
                this.form.product_id = this.product_id;
                this.form.post("/erp/product-titles", {
                    onSuccess: (page) => {
                    },
                    onError: (errors) => {
                    },
                });
            }
        },
        deleteItem() {

            this.sweetAlert = false
            this.$inertia.delete(`/erp/del/product/title/ ${this.itemId}`)
        },
        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
        },
    },
};


</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>
.line {
    border-top: 1px dashed #c7cfd6;
    width: 100%;
}

.error {
    margin-top: 0px !important;
}
</style>
