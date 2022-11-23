<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-9 col-12">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h4 class="card-title" v-if="beneficiary">Edit Bank</h4>
                <h4 class="card-title" v-else>Add Bank</h4>
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
                          <label>Bank Name *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="bank_name" v-model="form.bank_name" class="form-control"
                            name="bank_name" />
                          <ErrorComponent input="bank_name"></ErrorComponent>
                        </div>
                      </div>

                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Swift *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="swift" v-model="form.swift" class="form-control" name="swift" />
                          <ErrorComponent input="swift"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Beneficiary Name *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="beneficiary_name" v-model="form.beneficiary_name" class="form-control"
                            name="beneficiary_name" />
                          <ErrorComponent input="beneficiary_name"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>beneficiary Account Number *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="beneficiary_account_number" v-model="form.beneficiary_account_number"
                            class="form-control" name="beneficiary_account_number" />
                          <ErrorComponent input="beneficiary_account_number"></ErrorComponent>
                        </div>
                      </div>

                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label> Address one *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="address1" v-model="form.address1" class="form-control"
                            name="address1" />
                          <ErrorComponent input="address1"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label> Address two </label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="address2" v-model="form.address2" class="form-control"
                            name="address2" />
                          <ErrorComponent input="address2"></ErrorComponent>
                        </div>
                      </div>
                      <div class="col-sm-11 d-flex justify-content-start px-0">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                          Save
                        </button>
                        <inertia-link :href="route('companies.show', companyId)" type="button"
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
  import JetInputError from "./../../Jetstream/InputError";
  import { useForm } from "@inertiajs/inertia-vue3";
  import ErrorComponent from "../../components/ErrorComponent";

  export default {
    name: "Create",
    props: ["beneficiary", "errors", "companyId"],
    components: {
      Label,
      AdminLayout,
      JetInputError,
      ErrorComponent,
    },
    setup() {
      const form = useForm({
        company_id: "",
        bank_name: "",
        swift: "",
        beneficiary_name: "",
        beneficiary_account_number: "",
        address1: "",
        address2: "",
        enable: false,
      });
      return { form };
    },
    data() {
      return {};
    },
    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - Create Beneficiary";

      if (this.companyId) {
        this.company_id = this.companyId;
      }
      if (this.beneficiary) {
        this.update = true;
        let data = this.beneficiary;
        Object.assign(data, {
          _method: "PUT",
        });
        this.form = this.$inertia.form(data);
      }
    },
    methods: {
      submit() {
        if (this.update) {
          this.form.post(route("beneficiary.update", this.beneficiary.id));
        } else {
          this.form.company_id = this.companyId;
          this.form.post("/erp/admin/beneficiary");
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
