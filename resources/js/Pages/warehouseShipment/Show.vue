<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <form class="form form-horizontal" @submit.prevent="submit">
                    <div class="row match-height">
                        <div class="col-md-12">
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
                                                    <tr v-for=" purchaseOrder in purchaseOrders">
                                                        <td>{{ purchaseOrder.purchase_filling_ref }}</td>
                                                    </tr>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-3 form-group">
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Departure Port</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <td>{{ warehouseShipment.departure_port }}</td>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                    <label>Supplier</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <td>{{ warehouseShipment.supplier.name }}</td>
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Shipping Line</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <td>{{ warehouseShipment.shipping_line }}</td>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                    <label class="">Shipment Agent</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <td>{{ warehouseShipment.shipment_agent }}</td>
                                                </div>
                                            </div>

                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Booking Number</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <td>{{ warehouseShipment.booking_number }}</td>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                    <label>Freight Forwarder</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <td>
                                                        {{
                                                            warehouseShipment.supplier_freight_forwarder ? warehouseShipment.supplier_freight_forwarder.name : ''
                                                        }}
                                                    </td>
                                                </div>
                                            </div>
                                            <div class="row form-group py-0 my-0">
                                                <div class="col-md-2">
                                                    <label>Container Number </label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <td>{{ warehouseShipment.container_number }}</td>
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
                                                    <td>{{ warehouseShipment.bill_of_lading_number }}</td>
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
                                                    <td>{{ warehouseShipment.container_seal_number }}</td>
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
                                                    <td>{{ formatDate(warehouseShipment.load_date) }}</td>
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
                                                    <td>{{ formatDate(warehouseShipment.vessel_etd) }}</td>
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
                                                    <td>{{ formatDate(warehouseShipment.uk_eta) }}</td>
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
                                                    <td>{{ formatDate(warehouseShipment.load_date) }}</td>
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
                                                        {{
                                                            warehouseShipment.warehouse ? warehouseShipment.warehouse.name : ''
                                                        }}
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
                                                    <label>Freight Forward</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <td>
                                                        {{
                                                            warehouseShipment.purchaser_freight_forwarder ? warehouseShipment.purchaser_freight_forwarder.name : ''
                                                        }}
                                                    </td>

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
                            <div class="card">
                                <div class="card-body">
                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-2">
                                            <label>Off Load Hours *</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <input type="text" id="off_load_hours"
                                                   v-model="form.off_load_hours" class="form-control"
                                                   name="off_load_hours" required>
                                            <ErrorComponent input="off_load_hours"></ErrorComponent>
                                        </div>
                                    </div>

                                    <div class="row form-group py-0 my-0">
                                        <div class="col-md-2">
                                            <label>Actual Arrival Date *</label>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <input type="datetime-local" id="actual_arrival_date"
                                                   v-model="form.actual_arrival_date" class="form-control"
                                                   name="actual_arrival_date" required>
                                            <ErrorComponent input="actual_arrival_date"></ErrorComponent>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div>
                                <div v-if="shipmentItemsData.length>0">
                                    <h5>Shipment Items</h5>
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th class="custom-padding">Product</th>
                                                        <th class="text-center">Qty Ordered</th>
                                                        <th class="text-center">Qty Delivered</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(shipmentItem , index) in shipmentItemsData">
                                                        <td class=" custom-padding">{{ shipmentItem.product.name }}
                                                            ({{ shipmentItem.product.sku }})
                                                        </td>
                                                        <td class="text-center">{{ shipmentItem.quantity_ordered }}</td>
                                                        <td  class="text-center">
                                                            <div class="row">
                                                                <div class="col-md-2"></div>
                                                                <div class="col-md-4 quantity_deliver form-group">
                                                                    <input type="text" @change="sum(quantityDelivered[index].quantity)" class="form-control text-right"
                                                                           v-model="quantityDelivered[index].quantity">
                                                                    <ErrorComponent
                                                                        input="quantityDelivered"></ErrorComponent>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-4">Total</th>
                                                        <th class="col-4"></th>
                                                        <td class="text-right col-4 total_deliver font-weight-bold">
                                                            {{ total }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-11 d-flex justify-content-start px-0">
                                        <button class="btn btn-primary mr-1 mb-1" type="submit">
                                            Save
                                        </button>
                                        <inertia-link :href="route('warehouse-shipments.index')"
                                                      class="btn btn-light-secondary mr-1 mb-1" type="button">
                                            Back
                                        </inertia-link>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </admin-layout>
</template>

<script>
import moment from 'moment';
import AdminLayout from "../../Layouts/AdminLayout";
import Label from "../../Jetstream/Label";
import JetInputError from './../../Jetstream/InputError'
import {useForm} from '@inertiajs/inertia-vue3'
import ErrorComponent from '../../components/ErrorComponent'
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {
    name: "Show",
    props: [
        'shipmentItemsData',
        'suppliers',
        'shipment',
        'companies',
        'freightForwarders',
        'parentId',
        'warehouses',
        'purchaseOrders',
        'products',
        'warehouseShipment',
    ],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ConfirmatiomModal,
        ErrorComponent
    },

    setup() {
        const form = useForm({
            actual_arrival_date: '',
            off_load_hours: '',
            shipment_id: '',
            quantityDelivered: '',
        })
        return {form}
    },
    data() {
        return {
            actual_arrival_date: '',
            off_load_hours: '',
            total: '',
            shipment_id: '',
            quantityDelivered: [],
            shipmentItems: [],
            totalquantity: [],
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - show warehouse shipment";
        for (let i = 0; i < this.shipmentItemsData.length; i++) {
            this.quantityDelivered[i] = {
                "product_id": this.shipmentItemsData[i].product.id,
                "quantity": this.shipmentItemsData[i].quantity_delivered
            }
        }
        if (this.shipmentItemsData) {
            let total = 0;
            this.shipmentItemsData.forEach(element => {
                total += parseFloat(element.quantity_delivered);
            });
            this.total = total?total:0;
            this.update = true;
            let data = this.shipmentItemsData;
            let date = this.form
            Object.assign(data, date, {
                '_method': 'PUT',
                'off_load_hours': this.warehouseShipment.off_load_hours,
            })
            this.form = this.$inertia.form(data);
            this.form.actual_arrival_date = this.warehouseShipment.actual_arrival_date?moment(this.warehouseShipment.actual_arrival_date).format('YYYY-MM-DDThh:mm'): null;

        }
    }, mounted() {
        // Inputmask().mask(document.querySelectorAll("#off_load_hours"));
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
        submit() {
            if (this.update) {
                this.form.shipment_id = this.warehouseShipment.id;
                this.form.quantityDelivered = this.quantityDelivered;
                this.form.post(route("warehouse-shipments.update", this.warehouseShipment.id));
            } else {
                this.form.shipment_id = this.shipment.id;
                this.form.post("/fulfilment/warehouse-shipments", this.shipment_id);
            }
        },
        sum(quantity) {
            let obj = {};
            var total = 0;
            obj.quantity = quantity;
            this.totalquantity.push(obj)
            this.totalquantity.forEach(element => {
                total += parseFloat(element.quantity);
            });
            this.total = total?total:0;
        },

    },

};
</script>

<style scoped>
.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}
.quantity_deliver{
    margin-left: 5rem;
}
.total_deliver{
    padding-right: 215px;
}
.error {
    margin-top: 0px !important;
}
</style>
