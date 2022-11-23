<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="card">
          <div class="row mt-2 ml-1 mb-2">
            <div class="col-lg-11 d-flex">
                  <div class="d-inline-block"> <i class='bx bx-list-ul font-weight-bold'> </i></div>
                          <div class="d-inline-block"><h6 class="font-weight-bold header text-dark "> Company Details</h6></div>
            </div>
            <div class="col-lg-1">
              <div class="dropdown float-right mr-1">
<span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
</span>
<div class="dropdown-menu dropdown-menu-right">
<a :href="route('addresss.create', company.id)" class="dropdown-item"><i class="bx bx-plus mr-1"></i>Add</a>
</div>
</div>
            </div>
          </div>
              <!-- <div class="card-header mb-n1">
                  <div class="row">
                      <div class="col-lg-11 col-xl-11 col-md-10 col-sm-6 col-8 row" style="margin-left: 1px;">
                          <i class='bx bx-list-ul font-weight-bold '> </i> <h6 class="font-weight-bold header text-dark d-flex"> Company Details</h6>
                      </div>
                      <div class="col-1 col-lg-1 col-xl-1 col-md-1 col-sm-1">
                        <span  aria-expanded="false"
                                class="collapse-icon clap"
                                data-toggle="collapse"
                                role="button">
                        </span>
                    <div class="d-inline-block col-md-2 col-4 custom-padding-right  ml-1">
                    <div class="dropdow dropleft">
                    <span id="dropdownMenuButton"
                        aria-expanded="false" aria-haspopup="true"
                        class="badge-circle circle-color-33 badge-circle-light-secondary threedots12"
                        data-toggle="dropdown">
                      <i class='bx bx-dots-vertical-rounded lg:font-bold font-size-bx'></i>
                          </span>
                              <div aria-labelledby="dropdownMenuButton" class="dropdown-menu">
                                  <div class="container">
                                      <div class="row custom-popover popover-max">
                                          <div class="col-12 p-0 m-0">
                                              <div class="d-flex flex-column tooltip12 pt-1 pl-2">
                                                  <div class="d-flex  mb-n1 mt-n2">
                                                    <a data-repeater-create="" :href="route('addresss.create', company.id)">
                                                    <i class=" text-gray-500  bx  bx-plus pt-0.5 float-right add-btn font-large-1 ml-n1 "></i></a>
                                                        <p class=" text-gray-500 small action-text addaddress">Add </p>
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
              </div> -->
                <div class="row pr-0 ng-repeat-start pl-0">
              <div class="col-12 row pr-0 pl-0">
                <div class="card-content cardcontent">
                    <div class="row">
                        <i class='bx bx-user font-weight-bold'> </i> <h6 class="font-weight-bold header text-dark">Company Name:</h6>&nbsp;{{ company.name }}
                    </div>
                    <div class="row">
                        <i class='bx bx-check font-weight-bold'> </i> <h6 class="font-weight-bold header text-dark">Company Type:</h6>&nbsp; {{ company.type }}
                    </div>
                    <hr>

                     <div class="card-content">
                <div class="card-body">
                  <form @submit.prevent="submit" class="form form-horizontal">
                    <div class="form-body">
                        <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-2">
                          <label>Company Name *</label>
                        </div>
                        <div class="col-md-4 form-group">
                          <input type="text" id="name" v-model="form.name" class="form-control"
                            name="name"  />
                          <ErrorComponent input="name"></ErrorComponent>
                        </div>
                      </div>
                        <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-2">
                          <label>Company type *</label>
                        </div>
                        <div class="col-md-4 form-group">
                          <input type="text" id="type" v-model="form.type" class="form-control"
                            name="type"  />
                          <ErrorComponent input="type"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-2">
                          <label>Address_1 *</label>
                        </div>
                        <div class="col-md-4 form-group">
                          <input type="text" id="address_1" v-model="form.address_1" class="form-control"
                            name="address_1"  />
                          <ErrorComponent input="address_1"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-2">
                          <label>Address_2</label>
                        </div>
                        <div class="col-md-4 form-group">
                          <input type="text" id="address_2" v-model="form.address_2" class="form-control"
                            name="address_2" />
                          <ErrorComponent input="address_2"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-2">
                          <label>Town *</label>
                        </div>
                        <div class="col-md-4 form-group">
                          <input type="text" id="town" v-model="form.town" class="form-control" name="town" />
                          <ErrorComponent input="town"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-2">
                          <label>City *</label>
                        </div>
                        <div class="col-md-4 form-group">
                          <input type="city" id="city" v-model="form.city" class="form-control" name="city" />
                          <ErrorComponent input="city"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-2">
                          <label>County *</label>
                        </div>
                        <div class="col-md-4 form-group">
                          <input type="text" id="county" v-model="form.county" class="form-control" name="county" />
                          <ErrorComponent input="county"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-2">
                          <label>Postcode *</label>
                        </div>
                        <div class="col-md-2 form-group">
                          <input type="text" id="postcode" v-model="form.postcode" class="form-control"
                            name="postcode" />
                          <ErrorComponent input="postcode"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 pb-0 mb-0">
                        <div class="col-md-2">
                          <label>Country *</label>
                        </div>
                        <div class="col-md-4 form-group">
                           <select v-model="form.country" class="form-select pl-0" >
                                  <option value=""></option>
                                  <option v-for="contry in countries"
                                          :value="contry.slug">
                                      {{contry.value}}
                                  </option>
                              </select>
                          <ErrorComponent input="country"></ErrorComponent>
                        </div>
                      </div>
                       </div>
                      <div class="col-sm-11 d-flex justify-content-start px-0">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                          Save
                        </button>
                        <inertia-link :href="route('companies.index')" type="button"
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
          </div>
      </section>
    </div>
  </admin-layout>
  <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked" @deleteitem="deleteItem">
  </ConfirmatiomModal>
</template>

<script>
  import AdminLayout from "../../Layouts/AdminLayout";
  import Button from "../../Jetstream/Button";
  import Pagination from "../../admin/Pagination";
  import { useForm } from "@inertiajs/inertia-vue3";
  import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
  import Label from "../../Jetstream/Label.vue";
  import { Inertia } from '@inertiajs/inertia';
  import ErrorComponent from "../../components/ErrorComponent";

  export default {
    name: "Show",
    props: [
      "company",
      "beneficiaries",
      "intermediaries",
      "addresses",
      "shipments",
      "parentId",
      "countries",
    ],

    components: {
      Button,
      AdminLayout,
      Pagination,
      ConfirmatiomModal,
      ErrorComponent
    },
    setup() {
      const form = useForm({
        name: "",
        type: "",
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

      console.log()
      document.title = process.env.MIX_APP_NAME + " - Company show";
         if (this.addresses) {
            this.form.name = this.addresses.company
                ? this.addresses.company.name : '';
            this.form.type = this.addresses.company
                ? this.addresses.company.type : "";
            this.form.company_id = this.addresses
                ? this.addresses.company_id : "";
            this.form.address_1 = this.addresses
                ? this.addresses.address_1 : "";
            this.form.address_2 = this.addresses
                ? this.addresses.address_2
                : "";
            this.form.town = this.addresses
                ? this.addresses.town
                : "";
            this.form.city = this.addresses
                ? this.addresses.city
                : "";
             this.form.county = this.addresses
                ? this.addresses.county
                : "";
             this.form.postcode = this.addresses
                ? this.addresses.postcode
                : "";
             this.form.country = this.addresses
                ? this.addresses.country
                : "";
        }

        if (this.addresses) {
      this.update = true;
      let data = this.addresses;
      Object.assign(data, {
        _method: "PUT",    
                name: this.form.name,
                type: this.form.type,
      });
      this.form = this.$inertia.form(data);
    }
    },
    methods: {
       submit() {
          Inertia.visit(route("company-addresses.update",this.addresses.id),{
            method:'put',
            data:this.form
          });
      },
      Clicked() {
        this.sweetAlert = false;
      },
    
     
      deleteItem() {
        this.sweetAlert = false;
        this.$inertia.delete(`/erp/admin/${this.controller}/${this.itemId}`);
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
  .addaddress{
       font-size: 14px;
    margin-left: 5px;
    /* margin-top: 10px; */
    margin-top: 5px;
  }
  .editaddress{
         font-size: 14px;
    margin-left: 15px;
    /* margin-top: 10px; */
    margin-top: -21px;
  }
  .deladdress{
          font-size: 14px;
    margin-left: 15px;
    /* margin-top: 10px; */
    margin-top: -20px;
  }
.cardcontent{
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
    border-radius: 6px!important;
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
    .cardcontent{
          width: 1554px;
    }
  }
</style>
