<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-12 col-lg-12 col-xl-12 col-12">
            <div class="card invoice-print-area">
              <div class="card-header pb-0 mb-0">
                <div class="pt-0 mt-0 pb-0 mb-0">
                  <div class="row">
                    <div class="col-lg-2">
                      <small class="text-muted lg:font-bold">Company Name:</small>
                      <small class="text-muted ml-1">{{ company.name }}</small>
                    </div>
                  </div>
                  <div class="row" v-if="company.parent_id">
                    <div class="col-lg-2">
                      <small class="text-muted lg:font-bold">Company type:</small>
                      <small class="text-muted ml-2">{{ company.type }}</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="px-2">
                <hr class="line" />
              </div>
              <!-- 1st -->
              <div class="card-content">
                <div class="card-body pb-2 mx-25 px-2">
                  <div>
                    <div v-if="company.parent_id == null" class="row pb-1">
                      <div class="col-10">
                        <div class="mb-0 pt-0.5 lg:font-bold">
                          <h6>Shipment</h6>
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="col form-group pr-0 pb-0.5" >
                          <a data-repeater-create="" :href="route('shippment.create', company.id)">
                            <i class="
                                bx
                                bxs-plus-circle
                                pt-0.5
                                primary
                                float-right
                                add-btn
                                font-large-1
                             "></i></a>
                        </div>
                      </div>
                    </div>
                    <div class="row pb-0.5" v-if="shippments.length > 0">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-content">
                            <div class="table-responsive">
                              <table class="table table-hover mb-0">
                                <thead>
                                  <tr>
                                    <th class="custom-padding">
                                      container Number
                                    </th>
                                    <th>Supply Date</th>
                                    <th>Delivery Date</th>

                                    <th class="text-right custom-padding-right"></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="shippment in shippments">
                                    <td class="text-left pl-2.5">
                                      {{ shippment.container_number }}
                                    </td>
                                    <td class="text-left pl-2.5">
                                      {{
                                      shippment.shipment_date
                                      ? formatDate(shippment.shipment_date)
                                      : ""
                                      }}
                                    </td>
                                    <td class="text-left pl-2.5">
                                      {{
                                      shippment.delivery_date
                                      ? formatDate(shippment.delivery_date)
                                      : ""
                                      }}
                                    </td>
                                    <td class="
                                        text-right
                                        py-0
                                        my-0
                                        custom-padding-right
                                      ">
                                      <span class="d-inline-flex align-items-center">
                                        <inertia-link :href="
                                            route('shippment.show', [
                                              parentId,
                                              shippment.id,
                                            ])
                                          ">
                                          <span class="
                                              badge-circle
                                              badge-circle-light-secondary
                                              action
                                            ">
                                            <i class="
                                                bx
                                                bxs-show
                                                font-medium-1
                                                align-items-center
                                                text-center
                                              "></i>
                                          </span>
                                        </inertia-link>
                                        <inertia-link :href="
                                            route('shippment.edit', [
                                              parentId,
                                              shippment.id,
                                            ])
                                          ">
                                          <span class="
                                              badge-circle
                                              badge-circle-light-secondary
                                              action
                                            ">
                                            <i class="
                                                bx bx-edit
                                                font-medium-1
                                                align-items-center
                                                text-left
                                              "></i>
                                          </span>
                                        </inertia-link>

                                        <button v-on:click="
                                            confirmDelete(
                                              'shippments',
                                              shippment.id
                                            )
                                          ">
                                          <span class="
                                              badge-circle
                                              badge-circle-light-secondary
                                            ">
                                            <i class="
                                                bx bx-trash
                                                font-medium-1
                                                text-center
                                              "></i>
                                          </span>
                                        </button>
                                      </span>
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
                </div>
              </div>
              <!-- 2nd -->
              <div class="card-content">
                <div class="card-body pb-2 mx-25 px-2">
                  <div>
                    <div class="row pb-1">
                      <div class="col-10">
                        <div class="mb-0 pt-0.5 lg:font-bold">
                          <h6>Beneficiary</h6>
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="col form-group pr-0 pb-0.5" >
                          <a data-repeater-create="" :href="route('beneficiaries.create', company.id)">
                            <i class="
                                bx
                                bxs-plus-circle
                                pt-0.5
                                primary
                                float-right
                                add-btn
                                font-large-1
                              "></i></a>
                        </div>
                      </div>
                    </div>
                    <div class="row pb-0.5" v-if="beneficiaries.length > 0">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-content">
                            <div class="table-responsive">
                              <table class="table table-hover mb-0">
                                <thead>
                                  <tr>
                                    <th class="custom-padding">Bank Name</th>
                                    <th>Swift</th>
                                    <th>Beneficiary Name</th>
                                    <th>Beneficiary Account</th>
                                    <th>Bank Address</th>

                                    <th class="text-right custom-padding-right"></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="beneficiary in beneficiaries">
                                    <td class="text-left pl-2.5">
                                      {{ beneficiary.bank_name }}
                                    </td>
                                    <td class="text-left pl-2.5">
                                      {{ beneficiary.swift }}
                                    </td>
                                    <td class="text-left pl-2.5">
                                      {{ beneficiary.beneficiary_name }}
                                    </td>
                                    <td class="text-left pl-2.5">
                                      {{
                                      beneficiary.beneficiary_account_number
                                      }}
                                    </td>
                                    <td class="text-left pl-2.5">
                                      {{ beneficiary.address1 }},
                                      {{ beneficiary.address2 }}
                                    </td>

                                    <td class="
                                        text-right
                                        py-0
                                        my-0
                                        custom-padding-right
                                      ">
                                      <span class="d-inline-flex align-items-center">
                                        <inertia-link :href="
                                            route('beneficiaries.edit', [
                                              parentId,
                                              beneficiary.id,
                                            ])
                                          ">
                                          <span class="
                                              badge-circle
                                              badge-circle-light-secondary
                                              action
                                            ">
                                            <i class="
                                                bx bx-edit
                                                font-medium-1
                                                align-items-center
                                                text-left
                                              "></i>
                                          </span>
                                        </inertia-link>

                                        <button v-on:click="
                                            confirmDelete(
                                              'beneficiaries',
                                              beneficiary.id
                                            )
                                          ">
                                          <span class="
                                              badge-circle
                                              badge-circle-light-secondary
                                            ">
                                            <i class="
                                                bx bx-trash
                                                font-medium-1
                                                text-center
                                              "></i>
                                          </span>
                                        </button>
                                      </span>
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
                </div>
              </div>
              <!-- 3rd -->
<!--              <div class="card-content">-->
<!--                <div class="card-body pb-2 mx-25 px-2">-->
<!--                  <div>-->
<!--                    <div class="row pb-1">-->
<!--                      <div class="col-10">-->
<!--                        <div class="mb-0 pt-0.5 lg:font-bold">-->
<!--                          <h6>Intermediary</h6>-->
<!--                        </div>-->
<!--                      </div>-->
<!--                      <div class="col-2">-->
<!--                        <div class="col form-group pr-0 pb-0.5">-->
<!--                          <a data-repeater-create="" :href="route('intermediaries.create', company.id)"-->
<!--                            data-v-7709b240="">-->
<!--                            <i class="-->
<!--                                bx-->
<!--                                bxs-plus-circle-->
<!--                                pt-0.5-->
<!--                                primary-->
<!--                                float-right-->
<!--                                add-btn-->
<!--                                font-large-1-->
<!--                             "></i></a>-->
<!--                        </div>-->
<!--                      </div>-->
<!--                    </div>-->

<!--                    <div class="row pb-0.5" v-if="intermediaries.length > 0">-->
<!--                      <div class="col-12">-->
<!--                        <div class="card">-->
<!--                          <div class="card-content">-->
<!--                            <div class="table-responsive">-->
<!--                              <table class="table table-hover mb-0">-->
<!--                                <thead>-->
<!--                                  <tr>-->
<!--                                    <th class="custom-padding">Bank Name</th>-->
<!--                                    <th>Swift</th>-->
<!--                                    <th class="text-right custom-padding-right"></th>-->
<!--                                  </tr>-->
<!--                                </thead>-->
<!--                                <tbody>-->
<!--                                  <tr v-for="intermediary in intermediaries">-->
<!--                                    <td class="text-left pl-2.5">-->
<!--                                      {{ intermediary.bank_name }}-->
<!--                                    </td>-->
<!--                                    <td class="text-left pl-2.5">-->
<!--                                      {{ intermediary.swift }}-->
<!--                                    </td>-->
<!--                                    <td class="-->
<!--                                        text-right-->
<!--                                        py-0-->
<!--                                        my-0-->
<!--                                        custom-padding-right-->
<!--                                      ">-->
<!--                                      <span class="d-inline-flex align-items-center">-->
<!--                                        <inertia-link :href="-->
<!--                                            route('intermediary.edit', [-->
<!--                                              parentId,-->
<!--                                              intermediary.id,-->
<!--                                            ])-->
<!--                                          ">-->
<!--                                          <span class="-->
<!--                                              badge-circle-->
<!--                                              badge-circle-light-secondary-->
<!--                                              action-->
<!--                                            ">-->
<!--                                            <i class="-->
<!--                                                bx bx-edit-->
<!--                                                font-medium-1-->
<!--                                                align-items-center-->
<!--                                                text-left-->
<!--                                              "></i>-->
<!--                                          </span>-->
<!--                                        </inertia-link>-->

<!--                                        <button v-on:click="-->
<!--                                            confirmDelete(-->
<!--                                              'intermediary',-->
<!--                                              intermediary.id-->
<!--                                            )-->
<!--                                          ">-->
<!--                                          <span class="-->
<!--                                              badge-circle-->
<!--                                              badge-circle-light-secondary-->
<!--                                            ">-->
<!--                                            <i class="-->
<!--                                                bx bx-trash-->
<!--                                                font-medium-1-->
<!--                                                text-center-->
<!--                                              "></i>-->
<!--                                          </span>-->
<!--                                        </button>-->
<!--                                      </span>-->
<!--                                    </td>-->
<!--                                  </tr>-->
<!--                                </tbody>-->
<!--                              </table>-->
<!--                            </div>-->
<!--                          </div>-->
<!--                        </div>-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                </div>-->
<!--              </div>-->
              <!-- 4th -->
              <div class="card-content">
                <div class="card-body pb-2 mx-25 px-2">
                  <div>
                    <div class="row pb-1">
                      <div class="col-10">
                        <div class="mb-0 pt-0.5 lg:font-bold">
                          <h6>Address</h6>
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="col form-group pr-0 pb-0.5">
                          <div class="col form-group pr-0 pb-0.5">
                            <a data-repeater-create="" :href="route('addresses.create', company.id)">
                              <i class="
                                  bx
                                  bxs-plus-circle
                                  pt-0.5
                                  primary
                                  float-right
                                  add-btn
                                  font-large-1
                               "></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row pb-0.5" v-if="addresses.length > 0">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-content">
                            <div class="table-responsive">
                              <table class="table table-hover mb-0">
                                <thead>
                                  <tr>
                                    <th class="custom-padding">Address</th>

                                    <th class="text-right custom-padding-right"></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="address in addresses">
                                    <td class="text-left pl-2.5">
                                      {{ address.address_1 }}
                                      {{ address.address_2 }},
                                      {{ address.town }}, {{ address.city }},
                                      {{ address.county }},
                                      {{ address.postcode }},
                                      {{ address.country }}
                                    </td>
                                    <td class="
                                        text-right
                                        py-0
                                        my-0
                                        custom-padding-right
                                      ">
                                      <span class="d-inline-flex align-items-center">
                                        <inertia-link :href="
                                           route('companys.address.edit', address.id)
                                          ">
                                          <span class="
                                              badge-circle
                                              badge-circle-light-secondary
                                              action
                                            ">
                                            <i class="
                                                bx bx-edit
                                                font-medium-1
                                                align-items-center
                                                text-left
                                              "></i>
                                          </span>
                                        </inertia-link>

                                        <button v-on:click="
                                            confirmDelete(
                                              'addressesdelete',
                                              address.id
                                            )
                                          ">
                                          <span class="
                                              badge-circle
                                              badge-circle-light-secondary
                                            ">
                                            <i class="
                                                bx bx-trash
                                                font-medium-1
                                                text-center
                                              "></i>
                                          </span>
                                        </button>
                                      </span>
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
                </div>
              </div>
              <div class="col-sm-11 d-flex justify-content-start px-2 mb-3">
                <inertia-link :href="route('companys.index')" type="button" class="btn btn-light-secondary mr-1">
                  Back
                </inertia-link>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </admin-layout>
  <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked" @deleteitem="deleteItem">
  </ConfirmatiomModal>
</template>

<script>
  import AdminLayout from "../../../Layouts/AdminLayout";
  import Button from "../../../Jetstream/Button";
  import Pagination from "../../../admin/Pagination";
  import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";
  import Label from "../../../Jetstream/Label.vue";

  export default {
    name: "Show",
    props: [
      "company",
      "beneficiaries",
      "intermediaries",
      "addresses",
      "shippments",
      "parentId",
    ],

    components: {
      Button,
      AdminLayout,
      Pagination,
      ConfirmatiomModal,
    },
    data() {
      return {
        query: {
          query: "",
        },
        sweetAlert: false,
        itemId: "",
        controller: "",
      };
    },
    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - Company show";
    },
    mounted() { },
    methods: {
      Clicked() {
        this.sweetAlert = false;
      },
      deleteItem() {
        this.sweetAlert = false;
        this.$inertia.delete(`/super/admin/${this.controller}/${this.itemId}`);
      },
      confirmDelete(controller, id) {
        this.sweetAlert = true;
        this.itemId = id;
        this.controller = controller;
      },
      stopPropagation(e) {
        e.stopPropagation();
      },
      resetSort(e) {
        this.query.id = "";
        this.query.rel_first_name = "";
        this.query.date = "";
        this.query.amount_sent = "";
        this.query.direction = "";
        this.query.page = "";
        this.loadData();
      },
      resetFilter(e) {
        this.query.paid = "";
        this.query.un_paid = "";
        this.query.partially_paid = "";
        this.query.direction = "";
        this.query.page = "";
      },
      resetQuery() {
        this.query = {};
        this.loadData();
      },
      formatDate(date) {
        return moment(date).format("DD/MM/YYYY");
      },
    },
  };
</script>

<style scoped>
  .t-header {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
  }

  .action {
    padding-top: 4px !important;
    padding-bottom: 4px !important;
  }

  .card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
    height: auto !important;
  }

  .card-one {
    border: 1px solid #d2d6dc;
    border-bottom: 0px;
  }

  table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
  }

  .popover-content h4 {
    color: #00a1ff;
  }

  .popover-content h4 small {
    color: black;
  }

  .popover-content button.btn-primary {
    color: #00a1ff;
    border-color: #00a1ff;
    background: white;
  }

  .popover-content button.btn-default {
    color: gray;
    border-color: gray;
  }

  .custom-dropdown {
    margin-top: 0.5rem !important;
  }

  .input-group-text {
    padding: 0px !important;
    padding-left: 10px !important;
    padding-right: 10px !important;
  }

  .line {
    border-top: 1px dashed #c7cfd6;
    width: 100%;
  }

  tr.spaceUnder>td {
    padding-bottom: 1em;
  }

  @media (max-width: 1199px) {
    .text-small {
      font-size: 11px !important;
    }

    .text-document {
      font-size: 8px !important;
    }

    .contact-info {
      padding-left: 14px !important;
    }
  }

  @media (min-width: 1200px) {
    .text-small {
      font-size: 14px !important;
    }
  }
</style>
