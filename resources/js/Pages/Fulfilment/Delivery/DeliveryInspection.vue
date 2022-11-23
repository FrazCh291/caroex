<template>
    <admin-layout>
        <form class="form form-horizontal" @submit.prevent="submit">
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-lg-12 col-xl-12 col-12 pr-0">
                        <h5 class="font-weight-bold">Delivery Inspection {{ delivery.date }}</h5>
                        <div class="card invoice-print-area">
                            <div class="invoice-product-details table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody class="line">
                                    <tr class="border-0">
                                        <th scope="col">Service</th>
                                        <th class="text-center" scope="col">Consignment</th>
                                        <th class="text-center" scope="col">Items</th>
                                        <th class="text-center" scope="col">Weight(kg)</th>
                                        <th class="text-right" scope="col"></th>
                                        <th class="text-right" scope="col"></th>
                                    </tr>
                                    <tr>
                                        <th class="small cursor-pointer ml-2 border-0" scope="col">
                                            Next Day
                                        </th>
                                        <td class="text-center">{{ nextDay }}</td>
                                        <td class="text-center">{{ nextDay }}</td>
                                        <td class="text-center"></td>
                                        <td class="text-right"></td>
                                        <td class="text-right"></td>
                                    </tr>
                                    <tr>
                                        <th class="small cursor-pointer">Offshore</th>
                                        <td class="text-center">{{Ofshore}}</td>
                                        <td class="text-center">{{Ofshore}}</td>
                                        <td class="text-center"></td>
                                        <td class="text-right"></td>
                                        <td class="text-right"></td>
                                    </tr>
                                    </tbody>
                                    <tr>
                                        <th>Total</th>
                                        <td class="text-center">{{ delivery.No_items }}</td>
                                        <td class="text-center">{{ delivery.No_items }}</td>
                                        <td class="text-center">{{ delivery.weight }}</td>
                                        <td class="text-right"></td>
                                        <td class="text-right"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class=" card invoice-product-details table-responsive  ml-1">
                        <table class="table table-border-less ">
                            <thead>
                            <tr class="border-0">
                                <th>
                            <input v-model="collected" @click="checkbox()"  class="mt-2" type="checkbox"></th>
                                <th scope="col">Service Type</th>
                                <th scope="col">Product</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Status</th>
                                <th scope="col">Package</th>
                                <th scope="col">Weight (kg)</th>
                            </tr>

                            <tr v-for="deliveryInspecte in deliveryInspection">
                                <td ><input v-model="collected" :value="deliveryInspecte.id" class="mt-2" type="checkbox"></td>
                                <td class="PX-2 py-0 my-0 custom-padding">
                                    Next Day
                                </td>
                                <td class="py-0 PX-2 my-0">{{ deliveryInspecte.order.product?deliveryInspecte.order.product.name:'' }}</td>
                                <td class="text-truncate" @click="inspection(deliveryInspecte.id)">
                                    <div class="text-md-left"> <span
                                        id="login" :data-toggle="deliveryInspecte.id"

                                        data-container="body" data-html="true" data-placement="bottom"
                                        href="#" type="button" @mouseout="hideTooltip(deliveryInspecte.id)"><span
                                        class="underline-dotted border-gray  text-truncate ">{{
                                            (deliveryInspecte.order.shipping_address_1 ? deliveryInspecte.order.shipping_address_1 : '') +
                                            (deliveryInspecte.order.shipping_address_2 ? deliveryInspecte.order.shipping_address_2 : '') +
                                            (deliveryInspecte.order.shipping_city ? ", " + deliveryInspecte.order.shipping_city : '') +
                                            (deliveryInspecte.order.shipping_address_county ? ", " + deliveryInspecte.order.shipping_address_county : '') +
                                            (deliveryInspecte.order.shipping_address_postcode ? ", " + deliveryInspecte.order.shipping_address_postcode : '') +
                                            (deliveryInspecte.order.shipping_country ? ", " + deliveryInspecte.order.shipping_country : '')
                                        }}</span></span>
                                        <div class="container">
                                            <div :id="'popover-content-'+ deliveryInspecte.id" class="d-none">
                                                <div class="custom-popover popover-max">
                                                    <div class="d-flex justify-content">

                                                        <span class="font-weight-bold h5 mb-1 small"> Name : </span>
                                                        &nbsp;&nbsp;
                                                        <p class="py-0 mb-0 small">
                                                            {{ deliveryInspecte.order.customer?deliveryInspecte.order.customer.name:'' }}
                                                        </p>

                                                    </div>

                                                    <div class="d-flex justify-content">

                                                        <span class="font-weight-bold h5 mb-1 small"> Phone : </span>
                                                        &nbsp;&nbsp;
                                                        <p class="py-0 mb-0 small">
                                                            {{ deliveryInspecte.order.customer?deliveryInspecte.order.customer.phone:'' }}
                                                        </p>

                                                    </div>

                                                    <div class="d-flex justify-content">

                                                        <span class="font-weight-bold h5 mb-1 small">Email:</span>
                                                        &nbsp;&nbsp;
                                                        <p class="py-0 mb-0 small">
                                                            {{ deliveryInspecte.order.customer?deliveryInspecte.order.customer.email:'' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center px-0">
                                    <div class="d-flex align-items-center">
                                        <span v-if="deliveryInspecte.is_collected === 1"
                                              class="badge badge-pill badge-success">Collected</span>
                                        <span v-else class="badge badge-pill badge-danger">Not Collected</span>
                                    </div>
                                </td>
                                <td class="px-4  ml-1">
                                    {{ deliveryInspecte.order.quantity }}
                                </td>
                                <td class="px-4  ml-1">
                                    {{ deliveryInspecte.order.product.weight_unit }}
                                </td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-sm-11 d-flex justify-content-start px-0 ml-2">
                        <button class="btn btn-primary mr-1 mb-1" type="submit">
                            Save
                        </button>
                        <inertia-link :href="route('delivery.index')" class="btn btn-light-secondary mr-1 mb-1"
                                      type="button">
                            Back
                        </inertia-link>
                    </div>
                </div>
            </section>

            <!-- <div class="col-12 mt-2">
         <pagination :links="manifestItems.links" class="float-right"></pagination>
       </div> -->
        </form>
    </admin-layout>
</template>

<script>

import AdminLayout from "../../../Layouts/AdminLayout";
import Button from "../../../Jetstream/Button"
import Pagination from "../../../admin/Pagination";
import {useForm} from '@inertiajs/inertia-vue3';
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";
import Label from "../../../Jetstream/Label";
import JetInputError from "../../../Jetstream/InputError";
import ErrorComponent from '../../../components/ErrorComponent';

export default {

    name: "show",
    props: ['delivery', 'deliveryInspection' , 'total' , 'Ofshore' , 'nextDay'],
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
        return {form}
    },
    data() {
        return {
            query: {
                query: '',
                id: false,
                name: false,
                enable: false,
                disable: false,
                direction: null
            },
            collected: [],
            selected: [],
            sweetAlert: false,
            itemId: '',
            searchItem: false
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Delivery Inspection";
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
        submit() {
            this.form.selected = this.selected;
            this.form.collected = this.collected;
            this.$inertia.visit('/fulfilment/admin/delivery/inspected/store', {
                method: 'post',
                data: {delivery_item_ids: this.collected}

            })
        },
        
        sum() {
            const num1 = 5;
            const num2 = 3;
            const sum = num1 + num2;
        },
        stopPropagation(e) {
            e.stopPropagation();
        },
        checkbox(){
            alert('gf');
                    this.deliveryInspection.forEach(function (deliveryInspecte) {
                        this.collected.push(deliveryInspecte.id);
                    });
        },
        inspection(id) {
            if (this.id == null) {
                this.id = id;
                $("[data-toggle=" + id + "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "]").popover('show')
            } else if (this.id == id) {
                $("[data-toggle=" + this.id + "]").popover('dispose');
                this.id = null;
            } else {
                $("[data-toggle=" + this.id + "]").popover('dispose');
                this.id = id;
                $("[data-toggle=" + id + "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "]").popover('show')
            }
        },
        hideTooltip(id) {
            $("[data-toggle=" + this.id + "]").popover('dispose');
            this.id = null;
        },
    }
}

</script>

<style scoped>
.custom-padding {
    padding-left: 24px;
}

.custom-padding-right {
    padding-right: 24px;
}

.line[data-v-48189cb8] {
    border-bottom: 1px solid #dfd9d9;
    padding: 0px;
}

.hr {
    color: blue;
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

#delivery {
    margin-left: 402px;
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

    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

}

.dot {
    height: 20px;
    width: 20px;
    background-color: green;
    border-radius: 50%;
    display: inline-block;
    margin-right: 5px;
}

.dot-not {
    height: 20px;
    width: 20px;
    background-color: red;
    border-radius: 50%;
    display: inline-block;
    margin-right: 5px;
}

/* .invoice-print-area {
    width: 1591px;
    margin-left: -8px;

} */
</style>
