<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card mb-0" >
                            <div class="card-header pb-0 mb-0">
                                     <h6 class="d-inline-block">Bay: {{ bay.code }} </h6><span> - </span><h6 class="d-inline-block" v-if="level">Edit Level</h6>
                                <h6 class="d-inline-block" v-else>Add Level</h6>
                            </div>
                             <div class=" pb-1 px-2">
                                <hr class="line" />
                                </div> 
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Name </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="name" v-model="form.name"
                                                        class="form-control" name="name" />
                                                    <ErrorComponent input="name"></ErrorComponent>
                                                </div>
                                            </div>

                                             <div class="row form-group pt-1 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Code *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="code" v-model="form.code"
                                                        class="form-control" name="code" />
                                                    <ErrorComponent input="code"></ErrorComponent>
                                                </div>
                                            </div>

                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3 col-sm-12 ">
                                                    <label>Dimension (L x H x W) (m) *</label>
                                                </div>
                                                <div class="col-md-2 col-4   form-group">
                                                    <input type="number" id="length" v-model="length"
                                                        class="form-control" name="length" placeholder="length m" min="0" max="9999" step=".01" required/>
                                                    <ErrorComponent input="length"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2 col-4  form-group">
                                                    <input type="number" id="height" v-model="height"
                                                        class="form-control" name="height" placeholder="height m" min="0" max="9999" step=".01" required/>
                                                    <ErrorComponent input="height"></ErrorComponent>
                                                </div>
                                                <div class="col-md-2 col-4 form-group ">
                                                    <input type="number" id="width" v-model="width" class="form-control"
                                                        name="width" placeholder="width m" min="0" max="9999" step=".01" required/>
                                                    <ErrorComponent input="width"></ErrorComponent>
                                                </div>
                                                
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Volume (m<sup>3</sup>)</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="number" disabled id="volume" v-model="form.volume"
                                                        class="form-control" name="volume"  />
                                                    <ErrorComponent input="volume"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Max Weight *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="number" id="max_weight" v-model="form.max_weight"
                                                        class="form-control" name="max_weight" />
                                                    <ErrorComponent input="max_weight"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label> Occupied *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <div class="
                                                            custom-control
                                                            custom-switch
                                                            custom-switch-glow
                                                            custom-control-inline
                                                            mb-1
                                                            ">
                                                        <input type="checkbox" class="custom-control-input"
                                                            :checked="form.is_occupied" v-model="form.is_occupied"
                                                            id="is_occupied" />
                                                        <label class="custom-control-label" for="is_occupied">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                               
                                                <button type="submit"
                                                    class="btn btn-primary mr-1 mb-1 save">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('building.show',building_code)"
                                                    type="button" class="btn btn-light-secondary mr-1 mb-1">
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
    import AdminLayout from "../../../Layouts/AdminLayout";
    import Label from "../../../Jetstream/Label";
    import JetInputError from ".././../../Jetstream/InputError";
    import { useForm } from "@inertiajs/inertia-vue3";
    import ErrorComponent from "../../../components/ErrorComponent";

    export default {
        name: "Create",
        props: ['level', 'errors', 'building_code', 'bay'],
        components: {
            Label,
            AdminLayout,
            JetInputError,
            ErrorComponent,
        },
        setup() {
            const form = useForm({
                name: "",
                code: "",
                width: "",
                height: "",
                length: "",
                volume: "",
                is_occupied:false,
                max_weight: ""
            });
            return { form };
        },
        data() {
            return {
                length: '',
                width: '',
                height: ''
            };
        },
        beforeMount() {
            document.title = process.env.MIX_APP_NAME + " - Create Module";
            if (this.level) {
                this.update = true;
                if (this.level.is_occupied == 1) {
                    this.level.is_occupied = 1 ? true : false;
                }
                let data = this.level;
                Object.assign(data, {
                    _method: "PUT",
                });
                this.form = this.$inertia.form(data);
                this.length = this.form.length;
                this.width = this.form.width;
                this.height = this.form.height;
            }
        },
        watch: {
            length: function (val) {
                this.form.length = val;
                this.form.volume = this.form.length * this.form.width * this.form.height;
            },
            width: function (val) {
                this.form.width = val;
                this.form.volume = this.form.length * this.form.width * this.form.height;
            },
            height: function (val) {
                this.form.height = val;
                this.form.volume = this.form.length * this.form.width * this.form.height;
            },

        },
        methods: {
            submit() {
                if (this.update) {
                    this.form.post(route("level.update", this.level.id + "-" + this.building_code));
                } else {
                    this.form.post(route("level.store", { 'building_code': this.building_code, 'bay_id': this.bay.id }));
                }
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
</style>