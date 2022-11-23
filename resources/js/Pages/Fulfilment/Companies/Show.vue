<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="card">
          <div class="card-header mb-n1">
            <div class="row">
              <div class="col-lg-11 col-xl-11 col-md-10 col-sm-6 col-8 row" style="margin-left: 1px;">
                <i class='bx bx-list-ul font-weight-bold'> </i>
                <h6 class="font-weight-bold header text-dark"> Company Details</h6>
              </div>
              <div class="col-1 col-lg-1 col-xl-1 col-md-1 col-sm-1">
                <span aria-expanded="false" class="collapse-icon clap" data-toggle="collapse" role="button">
                </span>
                <div class="d-inline-block col-md-2 col-4 custom-padding-right  ml-1">
                  <div class="dropdow dropleft">
                    <span id="dropdownMenuButton" aria-expanded="false" aria-haspopup="true"
                      class="badge-circle circle-color-33 badge-circle-light-secondary threedots12"
                      data-toggle="dropdown">
                      <i class='bx bx-dots-vertical-rounded lg:font-bold font-size-bx'></i>
                    </span>
                    <div aria-labelledby="dropdownMenuButton" class="dropdown-menu">
                      <div class="container">
                        <div class="row custom-popover popover-max">
                          <div class="col-12 p-0 m-0">
                            <div class="d-flex flex-column tooltip12 pt-1 pl-2">
                              <div class="d-flex mb-2 mt-n1">
                                <a data-repeater-create="" :href="route('addresss.create', company.id)">
                                  <i
                                    class=" text-gray-500  bx  bx-plus pt-0.5 float-right add-btn font-large-1 ml-n1 "></i></a>
                                <p class=" text-gray-500 small action-text addaddress">Add </p>
                              </div>
                              <div class="d-flex mt-n1">
                                <span class="d-inline-flex align-items-center" v-for="address in addresses">
                                  <inertia-link :href=" route('company.addresss.edit', address.id) ">
                                    <span class="   action " style="margin-left: -9px;">
                                      <i class=" bx bx-edit font-medium-1 align-items-center  text-left "></i>
                                    </span>
                                    <p class=" text-gray-500 small action-text editaddress">Edit </p>
                                  </inertia-link>
                                </span>
                              </div>
                              <div class="d-flex">
                                <button v-on:click=" confirmDelete( 'addressdelete', address.id ) ">
                                  <i class=" bx bx-trash font-medium-1  text-center "
                                    style="margin-left: -56px; margin-top: 10px;"></i>
                                  <p class=" text-gray-500 small action-text deladdress">Delete </p>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row pr-0 ng-repeat-start pl-0">
            <div class="col-12 row pr-0 pl-0">
              <div class="card-content cardcontent">
                <div class="row">
                  <i class='bx bx-user font-weight-bold'> </i>
                  <h6 class="font-weight-bold header text-dark">Company Name:</h6>&nbsp;{{ company.name }}
                </div>
                <div class="row">
                  <i class='bx bx-check font-weight-bold'> </i>
                  <h6 class="font-weight-bold header text-dark">Company Type:</h6>&nbsp; {{ company.type }}
                </div>
                <hr>
                <div class="row">
                  <i class='bx bx-star font-weight-bold'> </i>
                  <h6 class="font-weight-bold header text-dark"> Address:</h6>&nbsp;
                  <span v-for="address in addresses">
                    {{ address.address_1 }}
                    {{ address.address_2 }},
                    {{ address.town }}, {{ address.city }},
                    {{ address.county }},
                    {{ address.postcode }},
                    {{ address.country }}
                  </span>
                </div>
                <div class="col-sm-11 d-flex justify-content-start pt-1 ml-n1 mb-1">
                  <inertia-link :href="route('companies.index')" type="button" class="btn btn-light-secondary mr-1">
                    Back
                  </inertia-link>
                </div>
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
      "shipments",
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
        this.$inertia.delete(`/fulfilment/admin/${this.controller}/${this.itemId}`);
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

  .addaddress {
    font-size: 14px;
    margin-left: 5px;
    /* margin-top: 10px; */
    margin-top: 5px;
  }

  .editaddress {
    font-size: 14px;
    margin-left: 15px;
    /* margin-top: 10px; */
    margin-top: -21px;
  }

  .deladdress {
    font-size: 14px;
    margin-left: 15px;
    /* margin-top: 10px; */
    margin-top: -20px;
  }

  .cardcontent {
    margin-left: 67px;
    margin-bottom: 10px;
  }

  .action {
    padding-top: 4px !important;
    padding-bottom: 4px !important;
  }

  .card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
    height: auto !important;
    box-shadow: 0 2px 14px rgb(38 60 85 / 16%);
    border-radius: 6px !important;
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