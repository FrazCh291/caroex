<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-9 col-12">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h4 class="card-title" v-if="company">Edit company</h4>
                <h4 class="card-title" v-else>Add company</h4>
              </div>
              <div class="px-2 pb-1">
                <hr class="line" />
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form @submit.prevent="submit" class="form form-horizontal">
                    <div class="form-body">
                      <div class="row form-group">
                        <div class="col-md-3">
                          <label> Company Name *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="name" v-model="form.name" class="form-control" name="name" />
                          <ErrorComponent input="name"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3">
                          <label> Contact Name *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="contact_name" v-model="form.contact_name" class="form-control" name="contact_name" />
                          <ErrorComponent input="contact_name"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3">
                          <label> Email *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="email" id="email" v-model="form.email" class="form-control" name="email" />
                          <ErrorComponent input="email"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3">
                          <label> Phone *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="phone" v-model="form.phone" class="form-control" name="phone" />
                          <ErrorComponent input="phone"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3">
                          <label>Type *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <select class="form-select" v-model="form.type"
                              name="type">
                              <option value="">select</option>
                              <option v-for="companyType in companyTypes" :value="companyType.slug">
                                  {{ companyType.value}}</option>
                          </select>
                          <ErrorComponent input="type"></ErrorComponent>
                        </div>
                      </div>
                      <!-- <div class="row form-group">
                        <div class="col-md-3">
                          <label>Value *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input
                            type="text"
                            id="value"
                            v-model="form.value"
                            class="form-control"
                            name="value"
                            placeholder=""
                          />
                          <ErrorComponent input="value"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3">
                          <label>Status</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <div
                            class="
                              custom-control custom-switch custom-switch-success
                              mr-2
                              mb-1
                            "
                          >
                            <input
                              type="checkbox"
                              class="custom-control-input"
                              v-model="form.enable"
                              v-if="form.enable == 1"
                              checked
                              id="customSwitch11"
                            />
                            <input
                              type="checkbox"
                              class="custom-control-input"
                              v-model="form.enable"
                              v-else
                              id="customSwitch11"
                            />
                            <label
                              class="custom-control-label"
                              for="customSwitch11"
                            >
                              <span class="switch-icon-left"
                                ><i class="bx bx-check"></i
                              ></span>
                              <span class="switch-icon-right"
                                ><i class="bx bx-check"></i
                              ></span>
                            </label>
                          </div>
                        </div>
                      </div> -->
                      <div class="col-sm-11 d-flex justify-content-start px-0">
                        <!-- <button
                          type="submit"
                          class="btn btn-primary mr-1 mb-1"
                          v-if="form.processing"
                          disabled
                        >
                          <span
                            class="spinner-border spinner-border-sm pb-0.5"
                            role="status"
                            aria-hidden="true"
                          ></span>
                          <span class="">Saving...</span>
                        </button> -->
                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                          Save
                        </button>
                        <inertia-link :href="route('companies.index')" type="button"
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
    props: ["company", "companyTypes", "errors"],
    components: {
      Label,
      AdminLayout,
      JetInputError,
      ErrorComponent,
    },
    setup() {
      const form = useForm({
        company_id: "",
        name : "",
        contact_name : "",
        email : "",
        phone : "",
        type: ""
      });
      return { form };
    },
    data() {
      return {};
    },
    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - Create Company";
      if (this.company) {
        this.update = true;
        let data = this.company;
        Object.assign(data, {
          _method: "PUT",
        });
        this.form = this.$inertia.form(data);
      }
    },
    methods: {
      submit() {
        if (this.update) {
          this.form.post(route("companies.update", this.company.id));
        } else {
          this.form.post("/super/admin/companys");
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
