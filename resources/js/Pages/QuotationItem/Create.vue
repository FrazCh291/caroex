<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-9 col-12">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h4 class="card-title" v-if="quotationItems">Edit Quotation</h4>
                <h4 class="card-title" v-else>Add Quotation Item</h4>
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
                                    <label>Product</label>
                                </div>
                        <div class="col-md-6 form-group">
                          <select
                            class="form-control"
                            v-model="form.product_id"
                            name="product"
                          >
                            <option value="">Please select product</option>
                            <option
                              v-for="product in products"
                              :value="product.id" >
                              {{ product.name }}
                            </option>
                          </select>
                          <ErrorComponent input="product_id"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Quantity *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input
                            name="quantity"
                            id="quantity"
                            v-model="form.quantity" @change="totalAmount()"
                            type="text"
                            class="form-control"
                          />
                          <ErrorComponent input="quantity"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Unit Price *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input
                            name="unit_price"
                            id="unit_price"
                            v-model="form.unit_price" @change="Amount()"
                            type="text"
                            class="form-control"
                          />
                          <ErrorComponent input="unit_price"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Total Price *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input
                            name="total_price"
                            v-model="form.total_price" readonly
                            type="text"
                            class="form-control"
                          />
                          <ErrorComponent input="total_price"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Description *</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <textarea
                            type="text"
                            name="description"
                            id="description"
                            rows="2"
                            v-model="form.description"
                            class="form-control"
                          ></textarea>
                          <ErrorComponent input="description"></ErrorComponent>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-11 d-flex justify-content-start px-0">
                      <button
                        type="submit"
                        @click="stopPropagation"
                        class="btn btn-primary ml-1 mr-1"
                      >
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Save</span>
                      </button>
                      <inertia-link
                        :href="
                          route('quotations.show', quotationItems.quotation_id)
                        "
                        type="button"
                        class="btn btn-light-secondary mr-1"
                        v-if="quotationItems"
                      >
                        Back
                      </inertia-link>
                      <inertia-link
                        :href="route('quotations.show', quotation.id)"
                        type="button"
                        class="btn btn-light-secondary mr-1"
                        v-else
                      >
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
  props: ["products", "quotation", "quotationItems", "errors"],
  components: {
    Label,
    AdminLayout,
    JetInputError,
    ErrorComponent,
  },
  setup() {
    const form = useForm({
      quotation_id: "",
      product_id: "",
      description: "",
      quantity: "",
      unit_price: "",
      total_price: "",
    });
    return { form };
  },
  data() {
    return {};
  },
  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Create quotation-item";
    if (this.quotationItems) {
      this.update = true;
      let data = this.quotationItems;
      Object.assign(data, {
        _method: "PUT",
      });
      this.form = this.$inertia.form(data);
    }
  },
  methods: {
    submit() {
      if (this.update) {
        this.form.post(
          route("quotationItem.update", this.quotationItems.quotation_id)
        );
      } else {
        this.form.quotation_id = this.quotation.id;
        this.form.post("/fulfilment/admin/quotationItem", this.quotation.id);
      }
    },
     totalAmount() {
    this.form.total_price = parseFloat(this.form.unit_price) * parseInt(this.form.quantity)
    },

    Amount() {
        if (this.form.quantity) {
            this.form.total_price = this.form.unit_price * this.form.quantity
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
