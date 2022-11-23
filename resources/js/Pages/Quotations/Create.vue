<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-9 col-12">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h4 class="card-title" v-if="quotations">Edit Quotation</h4>
                <h4 class="card-title" v-else>Add Quotation</h4>
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
                          <label>Supplier *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <select
                            class="form-control"
                            name="supplier"
                            v-model="form.supplier_id"
                          >
                            <option value="">Select Supplier</option>
                            <option v-for="supplier in suppliers" :value="supplier.id">
                              {{ supplier.name }}
                            </option>
                          </select>
                          <ErrorComponent input="supplier_id"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Description *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <textarea
                            type="text"
                            id="description"
                            v-model="form.description"
                            class="form-control"
                            name="description"
                          ></textarea>
                          <ErrorComponent input="description"></ErrorComponent>
                        </div>
                      </div>
                      <div class="col-sm-11 d-flex justify-content-start px-0">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                          Save
                        </button>
                        <inertia-link
                          :href="route('quotations.index')"
                          type="button"
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
  props: ["quotations", "suppliers", "errors"],
  components: {
    Label,
    AdminLayout,
    JetInputError,
    ErrorComponent,
  },
  setup() {
    const form = useForm({
      supplier_id: "",
      description: "",
    });
    return { form };
  },
  data() {
    return {};
  },
  beforeMount() {
    if(this.quotations){
    document.title = process.env.MIX_APP_NAME + " - Edit Quotation";

    } else {
       document.title = process.env.MIX_APP_NAME + " - Create Quotation";
    };

    if (this.quotations) {
      this.update = true;
      let data = this.quotations;
      Object.assign(data, {
        _method: "PUT",
      });
      this.form = this.$inertia.form(data);
    }
  },
  methods: {
    submit() {
      if (this.update) {
        this.form.post(route("quotations.update", this.quotations.id));
      } else {
        this.form.post("/fulfilment/admin/quotations");
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
