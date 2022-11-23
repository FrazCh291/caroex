<template>
  <admin-layout>
    <div style="position: relative">
      <section id="basic-horizontal-layouts">
        <div class="card">
          <div class="card-header pb-0 mb-0">
            <h4 class="card-title">Show Shipment</h4>
          </div>
          <div class="px-2 pb-1">
            <hr class="line">
          </div>
          <div class="card-content">
            <div class="card-body">
              <div class="form-body">
                <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Purchase Order</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <tr>
                      <td>{{shipment.purchaseorder?shipment.purchaseorder.purchase_order_number:''}}</td>
                    </tr>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2"> </div>
                  <div class="col-md-3 form-group">
                  </div>
                </div>

                <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Departure Port</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{shipment.departure_port}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                    <label>Supplier</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{shipment.supplier.name}}</td>
                  </div>
                </div>

                <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Shipping Line</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{shipment.shipping_line}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                    <label class="">Shipping Agent</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{shipment.shipment_agent}}</td>
                  </div>
                </div>

                <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Booking Number</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{shipment.booking_number}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                    <label>Freight Forwarder</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>
                      {{shipment.supplier_freight_forwarder?shipment.supplier_freight_forwarder.name:''}}
                    </td>
                  </div>
                </div>

                <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Container Number</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{shipment.container_number}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-3 form-group">
                  </div>
                </div>

                <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Bill Of Lading</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{shipment.bill_of_lading_number}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-3 form-group">
                  </div>
                </div>

                <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Container Seal Number</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{shipment.container_seal_number}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-3 form-group">
                  </div>
                  <div class="col-md-2">
                    <label>Load Date</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{formatDate(shipment.load_date)}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-3 form-group">
                  </div>
                </div>

                <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Vessel Etd</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{formatDate(shipment.vessel_etd)}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-3 form-group">
                  </div>
                </div>

                <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Uk Eta</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{formatDate(shipment.uk_eta)}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-3 form-group">
                  </div>
                </div>
                 <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                  <label>Expected Delivery Date</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{formatDate(shipment.uk_eta)}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-3 form-group">
                  </div>
                </div>
                 <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Shipped Date</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{formatDate(shipment.expected_container_delivery_date)}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-3 form-group">
                  </div>
                </div>
                 <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Actual Arrival Date</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>{{formatDate(shipment.actual_arrival_date)}}</td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-3 form-group">
                  </div>
                </div>

                <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Delivery warehouse</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <td>
                      {{shipment.warehouse?shipment.warehouse.name:""}}
                    </td>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-3 form-group">
                  </div>
                </div>

                <div class="row form-group py-0 my-0">
                  <div class="col-md-2">
                    <label>Freight Forwarder</label>
                  </div>
                  <div class="col-md-3 form-group">
                    <tr>
                      <td>
                        {{shipment.purchaser_freight_forwarder?shipment.purchaser_freight_forwarder.name:""}}
                      </td>
                    </tr>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-3 form-group">
                  </div>
                </div>
              </div>

               </div>
               </div>
                   </div>

                <div class="row match-height">
                    <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                        <div class="card invoice-print-area pt">
                            <div class="card-content">
                                <div class="card-body mt-1 py-1 mx-25 px-2">
                                    <h5>Shipment Item
                                    </h5>
                                    <div>
                                        <div class="row" v-if="shipment.shipment_items.length>0">
                                            <div class="row col-12 pr-0 ng-repeat-start" id="table-hover-row">
                                                <div class="col-12 pr-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-left custom-padding pl-1">
                                                                            Product
                                                                        </th>
                                                                        <th class="">Price</th>
                                                                        <th class="">Qty</th>
                                                                        <th class="">Total</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="truncate">
                                                                    <tr v-for="shipmentitem in shipment.shipment_items">
                                                                        <td class="py-2 my-0 custom-padding">
                                                                            {{ shipmentitem.product.name }}
                                                                        </td>
                                                                        <td class="py-0 my-0">
                                                                            {{ "$" + shipmentitem.unit_price }}
                                                                        </td>
                                                                        <td class="py-0 my-0">
                                                                            {{ shipmentitem.quantity_ordered }}
                                                                        </td>
                                                                        <td class="py-0 my-0">
                                                                            {{ "$" + shipmentitem.total_price }}
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
                                        <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                                                           @deleteitem="deleteItem">
                                        </ConfirmatiomModal>
                                    </div>
                                </div>
                            </div>
                            <!-- 2nd -->
                            <div class="card-content">
                                <div class="card-body py-0 mx-25 px-2">
                                    <div>
                                        <div class="row" v-if="documents.length > 0">
                                            <div class="row col-12 pr-0 ng-repeat-start" id="table-hover-row">
                                                <div class="col-12 pr-0">
                                                    <h5>Documents</h5>
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class=" text-left pt-1 pb-1 pl-1 py-0 my-0 text-truncate t-header">
                                                                            Title
                                                                        </th>
                                                                        <th class=" text-center pt-1 pb-1 pl-5 py-0 my-0 text-truncate t-header">
                                                                            File
                                                                        </th>
                                                                        <th class=" text-center pt-1 pb-1 pl-5 py-0 my-0 text-truncate t-header">
                                                                            Description
                                                                        </th>
                                                                        <th class="text-right pt-1 pb-1 py-0 my-0 text-truncate t-header"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="truncate">
                                                                    <tr v-for="document in documents">
                                                                        <td class=" cursor-pointer px-1 my-0 text-truncate">
                                                                            <div v-if="document.file_type.toLowerCase() == 'txt'">
                                                                                <a>
                                                                                    <i class=" bx bxs-file-txt font-large-1"></i></a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>

                                                                            </div>
                                                                            <div v-if="document.file_type.toLowerCase()== 'jpg' ">
                                                                                <a>
                                                                                    <i class=" bx bxs-file-jpg font-large-1"></i></a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>

                                                                            </div>
                                                                            <div v-if="document.file_type.toLowerCase()== 'docx' ">
                                                                                <a>
                                                                                    <i class=" bx bxs-file-doc font-large-1"></i></a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>

                                                                            </div>
                                                                            <div v-if="document.file_type.toLowerCase() == 'pdf' ">
                                                                                <a>
                                                                                    <i class=" bx bxs-file-pdf font-large-1"></i></a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>

                                                                            </div>
                                                                            <div v-if="document.file_type.toLowerCase() == 'csv' ">
                                                                                <a>
                                                                                    <i class=" bx bxs-file font-large-1"></i></a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>

                                                                            </div>
                                                                            <div v-if="document.file_type.toLowerCase() == 'png'">
                                                                                <a>
                                                                                    <i class=" bx bxs-file-png font-large-1"></i></a>
                                                                                <span class="text-title-icon pl-0.5">{{
                                                                                        document.title
                                                                                    }}</span>
                                                                            </div>
                                                                            <div v-if="document.file_type.toLowerCase() == 'xls'">
                                                                                <a>
                                                                                    <i class=" bx bxs-file-blank font-large-1"></i></a>
                                                                                <span class="text-title-icon pl-0.5">{{document.title}}</span>
                                                                            </div>
                                                                            <div v-if="document.file_type.toLowerCase() == 'xlsx'">
                                                                                <a><i class=" bx bxs-file-blank font-large-1"></i></a>
                                                                                <span class="text-title-icon pl-0.5">{{document.title}}</span>
                                                                            </div>
                                                                        </td>
                                                                        <td class="small cursor-pointer py-0 my-0 text-truncate text-center">
                                                                            {{ document.file.substring(18) }}
                                                                        </td>
                                                                        <td class="small cursor-pointer pl-4 py-0 my-0 text-truncate text-center">
                                                                            {{ document.description }}
                                                                        </td>
                                                                        <td class="text-right text-small action pr-1">
                                                                            <a :href="route('export.shipments.files', document.id )">
                                                                              <span class="badge-circle badge-circle-light-secondary">
                                                                                <i class="bx bx-download font-medium-1 align-items-center text-center"></i>
                                                                              </span>
                                                                            </a>
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

                                        <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                                                           @deleteitem="deleteItem">
                                        </ConfirmatiomModal>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-11 d-flex justify-content-start px-2 pt-1">
                                <inertia-link :href="route('shipments.index')" type="button"
                                              class="btn btn-light-secondary  mr-1 mb-2 ">
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
import {useForm} from "@inertiajs/inertia-vue3";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import Label from "../../Jetstream/Label";
import JetInputError from "../../Jetstream/InputError";
import ErrorComponent from "../../components/ErrorComponent";

export default {
    name: "show",
    props: [
        "shipment",
        "shipmentitems",
        "suppliers",
        "companies",
        "address",
        "documents",
        "freightForwarders",
    ],
    components: {
        Button,
        AdminLayout,
        Pagination,
        JetInputError,
        ErrorComponent,
        ConfirmatiomModal,
    },
    setup() {
        const form = useForm({});
        return {form};
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
            controller: "",
        };
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Shipment";
    },
    mounted() {
        if (this.params) {
            let params = Object.keys(this.params);
            for (let i of params) {
                Object.assign(this.query, {[i]: this.params[i]});
            }
        }
    },
    methods: {
        formatDate(date) {
          if(date){
           return moment(date).format('DD/MM/YYYY');
             }

          else{
            return '...';
          }
        },


        Clicked() {
            this.sweetAlert = false;
        },
        deleteItem() {
            this.sweetAlert = false;
            this.$inertia.delete(`/${this.controller}/${this.itemId}`);
        },

        confirmDelete(controller, id) {
            this.sweetAlert = true;
            this.itemId = id;
            this.controller = controller;
        },

        addContext() {
            $("#addContext").modal("show");
            this.form.warehouseContainer_id = this.warehouseContainer.id;
            this.form = this.$inertia.form({
                warehouse_container_id: this.warehouseContainer.id,
                company_id: "",
                bill_of_lading_no: "",
                warehouse_id: "",
                product_id: "",
                quantity_ordered: "",
                ctn: "",
                unit_price: "",
                total_amount: "",
            });
        },
        resetQuery() {
            this.query = {};
            this.loadData();
        },
        stopPropagation(e) {
            e.stopPropagation();
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
                    Object.assign(query, {[item]: this.query[item]});
                }
            }
            this.$inertia.visit(route("warehouseContainer.index"), {
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

#dates {
    width: 430px;
}

.modal-dialog {
    display: none;
    position: absolute;
    left: 450px;
    top: 0px;
}

.modal-content {
    width: 700px;
}

.modal-footer {
    padding-left: 0px;
    padding-top: 0px;
    padding-bottom: 0px;
    padding-right: 15px;
}

.vertical-line {
    display: inline-block;
    border-left: 1px solid #ccc;
    margin: 0 10px;
    height: 125px;
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

    .form-group {
        margin-bottom: 15px;
    }
}
</style>
