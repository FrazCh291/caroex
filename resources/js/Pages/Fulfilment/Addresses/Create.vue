<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-9 col-12">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h4 class="card-title" v-if="address">Edit Address</h4>
                <h4 class="card-title" v-else>Addresss</h4>
              </div>
              <div class="px-2 pb-1">
                <hr class="line" />
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form @submit.prevent="submit" class="form form-horizontal">
                    <div class="form-body">
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Address_one *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="address_1" v-model="form.address_1" class="form-control"
                            name="address_1" />
                          <ErrorComponent input="address_1"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Address_two</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="address_2" v-model="form.address_2" class="form-control"
                            name="address_2" />
                          <ErrorComponent input="address_2"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Town *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="town" v-model="form.town" class="form-control" name="town" />
                          <ErrorComponent input="town"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>City *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="city" id="city" v-model="form.city" class="form-control" name="city" />
                          <ErrorComponent input="city"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>County *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="county" v-model="form.county" class="form-control" name="county" />
                          <ErrorComponent input="county"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Postcode *</label>
                        </div>
                        <div class="col-md-2 form-group">
                          <input type="text" id="postcode" v-model="form.postcode" class="form-control"
                            name="postcode" />
                          <ErrorComponent input="postcode"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Country *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="country" v-model="form.country" class="form-control" name="country" />
                          <ErrorComponent input="country"></ErrorComponent>
                        </div>
                      </div>
                      <div class="col-sm-11 d-flex justify-content-start px-0">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                          Save
                        </button>
                        <inertia-link :href="route('company.show', companyId)" type="button"
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
  import JetInputError from "./../../../Jetstream/InputError";
  import { useForm } from "@inertiajs/inertia-vue3";
  import ErrorComponent from "../../../components/ErrorComponent";

  export default {
    name: "Create",
    props: ["address", "errors", "companyId"],
    components: {
      Label,
      AdminLayout,
      JetInputError,
      ErrorComponent,
    },
    setup() {
      const form = useForm({
        company_id: "",
        address_1: "",
        address_2: "",
        town: "",
        city: "",
        county: "",
        postcode: "",
        country: "",
      });
      return { form };
    },
    data() {
      return {};
    },
    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - Create address";
      if (this.address) {
        this.update = true;
        let data = this.address;
        Object.assign(data, {
          _method: "PUT",
        });
        this.form = this.$inertia.form(data);
      }
    },

    methods: {
      submit() {
        if (this.update) {
          this.form.post(route("company-addresss.update", this.address.id));
        } else {
          this.form.company_id = this.companyId;
          this.form.post(route("company-addresses.store"));
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
