<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-9 ">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h6 v-if="building">
                  Edit Building
                </h6>
                <h6 v-else>Add Building</h6>
              </div>
              <div class="px-2 pb-1">
                <hr class="line" />
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form @submit.prevent="submit" class="form form-horizontal">
                    <div class="form-body">
                      <div class="row form-group pt-2">
                        <div class="col-md-12 col-12">
                          <!-- First -->
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-6">
                              <label>Name </label>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                              <input type="text" id="name" v-model="form.name" class="form-control" name="name" />
                              <ErrorComponent input="name"></ErrorComponent>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-6">
                              <label>Code *</label>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                              <input type="text" id="code" v-model="form.code" class="form-control" name="code" />
                              <ErrorComponent input="code"></ErrorComponent>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-6 pr-0">
                              <label>Address 1 *</label>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                              <input type="text" id="address_1" v-model="form.address_1" class="form-control"
                                name="address_1" />
                              <ErrorComponent input="address_1"></ErrorComponent>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-6 ">
                              <label>Address 2</label>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                              <input type="text" id="address_2" v-model="form.address_2" class="form-control"
                                name="address_2" />
                              <ErrorComponent input="address_2"></ErrorComponent>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-6">
                              <label>Town *</label>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                              <input type="text" id="city" v-model="form.city" class="form-control" name="city" />
                              <ErrorComponent input="city"></ErrorComponent>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-6 ">
                              <label>County *</label>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                              <input type="text" id="state" v-model="form.state" class="form-control" name="state" />
                              <ErrorComponent input="state"></ErrorComponent>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-6 ">
                              <label>Postcode *</label>
                            </div>
                            <div class="col-md-3 col-sm-12 form-group">
                              <input type="text" id="zip_code" v-model="form.zip_code" class="form-control"
                                name="zip_code" />
                              <ErrorComponent input="zip_code"></ErrorComponent>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-6">
                              <label>Country *</label>
                            </div>
                            <div class="col-md-6 form-group">
                              <select class="form-select" v-model="form.country" name="country">

                                <option value="">Select Country</option>
                                <option v-for="country in countries" :value="country.value">
                                  {{ country.value }}
                                </option>
                              </select>
                              <ErrorComponent input="country"></ErrorComponent>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-6">
                              <label>Phone *</label>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                              <input type="phone" id="phone" v-model="form.phone" class="form-control" name="phone" />
                              <ErrorComponent input="phone"></ErrorComponent>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-12 ">
                              <label>Dimension (L x H x W) (m) *</label>
                            </div>
                            <div class="col-md-2 col-4   form-group">
                              <input type="number" id="length" v-model="length" class="form-control" name="length"
                                placeholder="length m" min="0" max="9999" step=".01" required />
                              <ErrorComponent input="length"></ErrorComponent>
                            </div>
                            <div class="col-md-2 col-4  form-group mx-md-0">
                              <input type="number" id="height" v-model="height" class="form-control" name="height"
                                placeholder="height m" min="0" max="9999" step=".01" required />
                              <ErrorComponent input="height"></ErrorComponent>
                            </div>
                            <div class="col-md-2 col-4 form-group">
                              <input type="number" id="width" v-model="width" class="form-control" name="width"
                                placeholder="width m" min="0" max="9999" step=".01" required />
                              <ErrorComponent input="width"></ErrorComponent>
                            </div>

                          </div>
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-6">
                              <label>Volume (m<sup>3</sup>)</label>
                            </div>
                            <div class="col-md-6 col-sm-3 form-group">
                              <input type="number" id="volume" disabled v-model="form.volume" class="form-control"
                                name="volume" />
                              <ErrorComponent input="volume"></ErrorComponent>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-3 col-sm-6">
                              <label> Occupied *</label>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                              <div class="
                                                            custom-control
                                                            custom-switch
                                                            custom-switch-glow
                                                            custom-control-inline
                                                            mb-1
                                                            ">
                                <input type="checkbox" class="custom-control-input" :checked="form.is_occupied"
                                  v-model="form.is_occupied" id="is_occupied" />
                                <label class="custom-control-label" for="is_occupied">
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-11 d-flex justify-content-start px-0">

                        <button type="submit" class="btn btn-primary mr-1 mb-1 save">
                          Save
                        </button>
                        <inertia-link :href="route('building.index')" type="button"
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
  import AdminLayout from "../../../Layouts/AdminLayout";
  import Label from "../../../Jetstream/Label";
  import JetInputError from ".././../../Jetstream/InputError";
  import { useForm } from "@inertiajs/inertia-vue3";
  import ErrorComponent from "../../../components/ErrorComponent";

  export default {
    name: "Create",
    props: ["countries", "building", "errors"],
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
        phone: "",
        length: "",
        width: "",
        height: "",
        volume: "",
        address_1: "",
        address_2: "",
        city: "",
        state: "",
        country: "",
        zip_code: "",
        is_occupied: false,
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
      document.title = process.env.MIX_APP_NAME + " - Create  Building";
      if (this.building) {
        this.update = true;
        if (this.building.is_occupied == 1) {
          this.building.is_occupied = 1 ? true : false;
        }
        let data = this.building;
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
          this.form.post(route("building.update", this.building.id));
        } else {
          this.form.post(route("building.store"));
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