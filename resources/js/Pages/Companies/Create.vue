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
                              name="type" @change="supplierType" v-if="supplier != null" >
                              <option :value="supplier.slug" selected>
                                  {{ supplier.value}}</option>
                          </select>
                          <select class="form-select" v-model="form.type"
                              name="type" @change="supplierType" v-else>
                              <option value="">select</option>
                              <option v-for="companyType in companyTypes" :value="companyType.slug">
                                  {{ companyType.value}}</option>
                          </select>
                          <ErrorComponent input="type"></ErrorComponent>
                        </div>
                      </div>
                      <!-- <div class="col-sm-11 d-flex justify-content-start px-0">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                          Save
                        </button>
                        <inertia-link :href="route('companies.index')" type="button"
                          class="btn btn-light-secondary mr-1 mb-1">
                          Back
                        </inertia-link>
                      </div> -->
                    </div>
                     <div class="form-body" v-if="supplieraddress">
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
                      
                    </div>
                    <div class="col-sm-11 d-flex justify-content-start px-0">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                          Save
                        </button>
                        <!-- :href="route('companies.show', companyId)" -->
                        <inertia-link  type="button"
                          class="btn btn-light-secondary mr-1 mb-1">
                          Back
                        </inertia-link>
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
    props: ["company", "companyTypes", "errors" , 'supplier'],
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
        type: "",
        address_1:"",
        address_2:"",
        town:"",
        city:"",
        county:"",
        postcode:"",
        country:""
      });
      return { form };
    },
    data() {
      return {
        supplieraddress:false,
      };
    },
    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - Create Company";
      console.log(this.supplier, 'faraz')
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
          this.form.post("/erp/admin/companies");
        }
      },
       supplierType: function () {
            if (this.form.type == 'supplier_company') {
                this.form.type = this.form.type;
                this.supplieraddress = true;
            } else {
                this.supplieraddress = false;
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
