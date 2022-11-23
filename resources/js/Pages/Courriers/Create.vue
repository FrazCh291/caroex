<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="courriers">Edit Courrier </h4>
                                <h4 class="card-title" v-else>Add Courrier </h4>
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
                                                    <label>Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="name" v-model="form.name"
                                                           class="form-control"
                                                           name="name">
                                                    <ErrorComponent input="name"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>warehouseBuilding *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                   <select class="form-select" name="warehousebuilding" v-model="form.warehouseBuilding_id" >
                                                        <option value="">Select warehouse Building</option>
                                                        <option v-for="warehouseBuilding in WarehouseBuildings" :value="warehouseBuilding.id">
                                                            {{ warehouseBuilding.name }}
                                                        </option>
                                                    </select>
                                                     <ErrorComponent input="warehouseBuilding_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('courriers.index')" type="button"
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
    props: ['courriers',  'WarehouseBuildings', 'errors'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            name: '',
            warehouseBuilding_id: '',
        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        if (this.courriers) {

            document.title = process.env.MIX_APP_NAME + " - Edit Courrier";
        }else{

            document.title = process.env.MIX_APP_NAME + " - Create Courrier";
        }
        if (this.courriers) {
            this.update = true;
            let data = this.courriers;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('courriers.update', this.courriers.id))
            } else {
                this.form.post('/super/admin/courriers')
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
