<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-9 col-12">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h4 class="card-title" v-if="lookup">Edit Lookup</h4>
                <h4 class="card-title" v-else>Add Lookup</h4>
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
                          <label> Type *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="type" v-model="form.type" class="form-control" name="type" />
                          <ErrorComponent input="type"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3">
                          <label> Value *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="value" v-model="form.value" class="form-control" name="value" />
                          <ErrorComponent input="value"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3">
                          <label> Slug *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="slug" v-model="form.slug" class="form-control" name="slug" />
                          <ErrorComponent input="slug"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3">
                          <label> Order By </label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="text" id="order" v-model="form.order"
                            class="form-control"
                            name="order"
                            @input="changeOrder($event)"
                            @change="changeOrder($event)"
                            required/>
                            <div class="error" v-if="!isValidOder">
                              Invalid Value. Add integer.
                            </div>
                        </div>
                      </div>
                      <div class="form-body py-1">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>Status *</label>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="checkbox">
                                        <input type="checkbox" class="checkbox-input"
                                          v-model="form.enable" id="checkbox1" checked="">
                                        <label for="checkbox1"></label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                      </div>
                      <div class="col-sm-11 d-flex justify-content-start px-0">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                          Save
                        </button>
                        <inertia-link :href="route('lookups.index')" type="button"
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
    props: ["lookup", "errors"],
    components: {
      Label,
      AdminLayout,
      JetInputError,
      ErrorComponent,
    },
    setup() {
      const form = useForm({
        type: "",
        slug : "",
        value : "",
        order : "",
        enable : false
      });
      return { form };
    },
    data() {
      return {
        isValidOder: true,
        regexForNum: /^[0-9]*$/
      };
    },
    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - Create Lookup";
      if (this.lookup) {
        this.update = true;
        let data = this.lookup;
        Object.assign(data, {
          _method: "PUT",
        });
        this.form = this.$inertia.form(data);
          if (this.form.enable == 1) {
              this.form.enable = true;
          }
      }
    },
    methods: {
      changeOrder: function (e) {
        console.log(this.regexForNum, 'sdf');
        this.isValidOder = this.regexForNum.test(e.target.value);
      },
      submit() {
        if (this.update) {
          this.form.post(route("lookups.update", this.lookup.id));
        } else {
          this.form.post(route("lookups.store"));
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
  color: #dc2626;
  font-size: 11.5px;
  margin-bottom: 10px;
  margin-top: 0px !important;
}

</style>
