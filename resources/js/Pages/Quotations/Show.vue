<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-12 col-lg-12 col-xl-12 col-12">
            <div class="card invoice-print-area">
              <div class="card-header pb-0 mb-0">
                <small class="text-muted mr-1 lg:font-bold">Quotation#</small>
                <small class="text-muted">{{ quotation.id }}</small>
              </div>
              <div class="card-header pt-0 mt-0 pb-0 mb-0">
                <small class="text-muted mr-1 lg:font-bold">Supplier#</small>
                <small class="text-muted">{{ quotation.supplier.name }}</small>
              </div>
              <div class="px-2">
                <hr class=" line-hr">
              </div>
              <div class="card-content">
                <div class="card-body pb-2 mx-25 px-2">
                  <div>
                    <div class="row pb-0.5">
                      <div class="col-10">
                        <div class="mb-0 text-muted pt-1 lg:font-bold">Quotation Items</div>
                      </div>
                      <div class="col-2">
                        <div class="col form-group pr-0 pb-1">
                          <a :href="route('quotationItem.create', quotation.id)"
                            class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1"
                            data-repeater-create="">
                          </a>
                        </div>
                      </div>
                    </div>

                    <div class="row" v-if="quotation.quotation_items.length>0">
                      <div class="row col-12 pr-0 ng-repeat-start"
                        id="table-hover-row">
                        <div class="col-12 pr-0">
                          <div class="card pr-0 pb-0 mb-1">
                            <div class="card-content">
                              <div class="table-responsive">
                                <table class="table table-hover truncate mb-0">
                                  <thead>
                                    <tr>
                                      <th class="text-muted text-left">Product Name</th>
                                      <th class="text-muted text-center">Descriptions</th>
                                      <th class="text-muted text-center">Quantity</th>
                                      <th class="text-muted text-center">Unit Price</th>
                                      <th class="text-muted text-center">Total Price</th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody class="truncate">
                                    <tr
                                      v-for="quotationItem in quotation.quotation_items"
                                    >
                                      <td class="py-0 my-0 text-left">
                                        {{ quotationItem.product.name }}
                                      </td>
                                      <td class="py-0 my-0 text-center">
                                        {{ quotationItem.description }}
                                      </td>
                                      <td class="py-0 my-0 text-center">
                                        {{ quotationItem.quantity }}
                                      </td>
                                      <td class="py-0 my-0 text-center">
                                        {{ quotationItem.unit_price }}£
                                      </td>
                                      <td class="py-0 my-0 text-center">
                                        {{ quotationItem.total_price }}£
                                      </td>
                                      <td
                                        class="text-right py-0 my-0 custom-padding-right"
                                      >
                                        <inertia-link :href=" route('quotationItem.edit',quotationItem.id) ">
                                          <span
                                            class="badge-circle badge-circle-light-secondary  action ">
                                            <i
                                              class="bx bx-edit font-medium-1 align-items-center text-left"></i>
                                          </span>
                                        </inertia-link>
                                        <button v-on:click="confirmDelete(quotationItem.id)" >
                                          <span
                                            class="badge-circle badge-circle-light-secondary ml-1/6 ">
                                            <i
                                              class="bx bx-trash font-medium-1 text-left " ></i>
                                          </span>
                                        </button>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <ConfirmatiomModal
                      v-if="sweetAlert"
                      :sweetAlert="sweetAlert"
                      @clicked="Clicked"
                      @deleteitem="deleteItem"
                    >
                    </ConfirmatiomModal>
                  </div>
                </div>
              </div>
              
      <div class="col-sm-11 d-flex justify-content-start py-0 px-2">
                        <inertia-link
                          :href="route('quotations.index')"
                          type="button"
                          class="btn btn-secondary mr-1 mb-1">
                          Back
                        </inertia-link>
                      </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </admin-layout>
</template>

<script>
import moment from 'moment';
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button";
import Pagination from "../../admin/Pagination";
import { useForm } from "@inertiajs/inertia-vue3";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import Label from "../../Jetstream/Label";
import JetInputError from "../../Jetstream/InputError";
import ErrorComponent from "../../components/ErrorComponent";

export default {
  name: "Show",
  props: ["quotation"],
  components: {
    Button,
    AdminLayout,
    Pagination,
    JetInputError,
    ErrorComponent,
    ConfirmatiomModal,
  },
  setup() {
    const form = useForm({
      company_id: "",
      product_id: "",
      quantity: "",
      unit_price: "",
      total_amount: "",
    });
    return { form };
  },
  data() {
    return {
      query: {
        query: "",
        id: false,
        name: false,
        enable: false,
        disable: false,
        direction: null,
      },
      sweetAlert: false,
      itemId: "",
      searchItem: false,
    };
  },
  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Quotation Items";
  },
  mounted() {
    if (this.params) {
      let params = Object.keys(this.params);
      for (let i of params) {
        Object.assign(this.query, { [i]: this.params[i] });
      }
    }
  },
  methods: {
    submit() {
      if (this.update) {
        this.form.post(
          route("warehouse-containers.update", this.quotationitem.id)
        );
      } else {
        this.form.quotationitem_id = this.quotationitem.id;
        this.form.post("/warehouse-containers/store", this.quotationitem.id);
        $("#addContext").modal("hide");
      }
    },
    addContext() {
      $("#addContext").modal("show");
      this.form.quotationitem_id = this.quotationitem.id;
      this.form = this.$inertia.form({
        warehouse_container_id: this.quotationitem.id,
        company_id: "",
        bill_of_lading_no: "",
        warehouse_id: "",
        product_id: "",
        quantity: "",
        ctn: "",
        unit_price: "",
        total_amount: "",
      });
    },
    resetQuery() {
      this.query = {};
      this.loadData();
    },
    Clicked() {
      this.sweetAlert = false;
    },
    deleteItem() {
      this.sweetAlert = false;
      this.$inertia.delete(`/fulfilment/admin/quotationItem/${this.itemId}`);
    },
    confirmDelete(id) {
      this.sweetAlert = true;
      this.itemId = id;
    },
    stopPropagation(e) {
      e.stopPropagation();
    },

    resetSort(e) {
      this.query = {};
      this.query.direction = "";
      this.query.id = "";
      this.query.name = "";
      this.query.address_1 = "";
      this.query.address_2 = "";
      this.loadData();
    },
    resetFilter() {
      this.query = {};
      this.query.id = "";
      this.query.name = "";
      this.loadData();
    },
    search() {
      this.searchItem = true;
      this.loadData();
    },
    filter() {
      this.loadData();
    },
    sort(direction) {
      this.query.direction = direction;
      this.loadData();
    },
    loadData() {
      let query = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
        }
      }
      this.$inertia.visit(route("quotations.index"), {
        method: "get",
        data: {
          ...query,
        },
      });
    },
  },
};
</script>

<style scoped>
 .line-hr[data-v-67dedaac] {
    width: 1540px;
    margin-left: 3px;
}
.custom-padding {
  padding-left: 24px;
}
.custom-padding-right {
  padding-right: 24px;
}

.action {
  margin-right: 4px !important;
  margin-top: 8px !important;
  margin-bottom: 8px !important;
}

.card {
  border: 1px solid #d2d6dc;
  border-radius: 0px !important;
}

.card-one {
  border: 1px solid #d2d6dc;
  border-bottom: 0px;
}

table thead th {
  vertical-align: bottom;
  border-bottom: 1px solid #d2d6dc;
}

.custom-dropdown {
  margin-top: 0.5rem !important;
}

@media (max-width: 575.98px) {
  .filter-container {
    width: 100% !important;
    padding-right: 22px !important;
    padding-left: 11px !important;
  }

  .filter-dropdown {
    width: 100% !important;
    padding-right: 0px !important;
    padding-left: 11px !important;
  }

  .sort-dropdown {
    width: 100% !important;
    padding-left: 11px !important;
    padding-right: 0px !important;
    padding-top: 15px !important;
  }
}
</style>
