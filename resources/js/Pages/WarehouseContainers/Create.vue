<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="warehouseContainers">Edit Container</h4>
                                <h4 class="card-title" v-else>Add Container</h4>
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
                                                    <label>Container # *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="name" v-model="form.container_no"
                                                           class="form-control"
                                                           name="container_no">
                                                    <ErrorComponent input="container_no"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label>Container Ordered Date *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="date" id="container_ordered_at"
                                                           v-model="form.container_ordered_at"
                                                           class="form-control" name="container_ordered_at">
                                                    <ErrorComponent input="container_ordered_at"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('containers.index')" type="button"
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
    props: ['warehouseContainers', 'errors'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent
    },
    setup() {
        const form = useForm({
            container_no: '',
            container_ordered_at: '',
        })
        return {form}
    },
    data() {
        return {}
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Warehouse Container";
        if (this.warehouseContainers) {
            this.update = true;
            let data = this.warehouseContainers;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        submit() {
            if (this.update) {
                this.form.post(route('containers.update', this.warehouseContainers.id))
            } else {
                this.form.post('/fulfilment/containers')
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
