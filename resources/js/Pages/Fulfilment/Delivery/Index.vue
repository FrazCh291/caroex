<template>
    <admin-layout>

        <div class="container-fluid px-2 bg-white">
            <div class="flex flex-wrap">
                <div class="w-full">
                    <ul class="flex mb-0 list-none flex-wrap py-1 flex-row">
                        <li class="-mb-px mr-2 last:mr-0 mt-1 mb-1">
                            <a class="text-xs font-bold uppercase px-5 py-1 w-44  shadow-lg rounded leading-normal"
                               v-on:click="toggleTabs(1)"
                               v-bind:class="{'text-pink-600 bg-white': openTab !== 1, 'text-white bg-blue1': openTab === 1}">
                                Tuffnells
                            </a>
                        </li>
                        <li class="-mb-px mr-2 last:mr-0 mt-1 mb-1">
                            <a class="text-xs font-bold uppercase px-5 py-1 w-44  shadow-lg rounded leading-normal text-truncate"
                               v-on:click="toggleTabs(6)"
                               v-bind:class="{'text-pink-600 bg-white': openTab !== 6, 'text-white bg-blue1': openTab === 6}">
                                Picking List
                            </a>
                        </li>
                        <li class="-mb-px mr-2 last:mr-0 mt-1 mb-1">
                            <a class="text-xs font-bold uppercase px-5 py-1 w-44  shadow-lg rounded  leading-normal text-truncate"
                               v-on:click="toggleTabs(5)"
                               v-bind:class="{'text-pink-600 bg-white': openTab !== 5, 'text-white bg-blue1': openTab === 5}">
                                Delivery Inspection
                            </a>
                        </li>
                    </ul>

                    <div class="relative  min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                        <div class="px-0 py-0 flex-auto bg-white">
                            <div class="tab-content tab-space bg-white">
                                <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                                    <div class="px-1" v-if="deliveries.ready.length>0">

                                        <div class="row pb-1" id="table-hover-row">
                                            <div class="col-12 pt-3">
                                                <div class="card">
                                                    <div class="card-content">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                        TUFFNELL TXT
                                                                    </th>
                                                                    <th class="text-right pl-1 py-0 my-0 text-truncate t-header"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="tuffnell in deliveries.ready">

                                                                    <td class="small cursor-pointer px-1 py-1 my-0 text-truncate">
                                                                        {{

                                                                            (tuffnell.filename ? tuffnell.filename.slice(17)
                                                                                : '')

                                                                        }}
                                                                    </td>

                                                                    <td class="text-right text-small py-0 my-0 action pr-1">
                                                                        <button class="">
                                                                            <!-- manifest.view -->
                                                                            <a :href="route('deliveries.show',tuffnell.id)">
                                                                                <span
                                                                                    class="badge-circle  badge-circle-light-secondary mr-1/4 ml-1/6">
                                                                                    <i class="bx bx-show font-medium-1 text-center"></i>
                                                                                </span>
                                                                            </a>
                                                                        </button>
                                                                        <span
                                                                            class="d-inline-flex align-items-center action">
                                                                            <a :href="route('export.tuffnells.file',tuffnell.id)">
                                                                                  <span
                                                                                      class="badge-circle badge-circle-light-secondary  action  ">
                                                                                      <i class="bx bx-download font-medium-1 align-items-center text-center"></i>
                                                                                  </span>
                                                                            </a>

                                                                         </span>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--            <div class="col-12 ">-->
                                            <!--                <pagination :links="companies.links" class="float-right"></pagination>-->
                                            <!--            </div>-->
                                        </div>


                                    </div>
                                    <div class="row pt-1 pl-3" v-else>
                                        <p>Seems you do not have any ready file to send tuffnell.</p>
                                    </div>
                                </div>
                                <div v-bind:class="{'hidden': openTab !== 5, 'block': openTab === 5}"
                                     v-if="inspections.length>0">
                                    <div class="row pb-1 pt-3 px-1" id="table-hover-row">
                                        <div class="col-12">
                                            <div class="card ">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="pl-1 px-2 py-0 my-0 text-truncate t-header">
                                                                    Date
                                                                </th>
                                                                <th class="pl-2  py-0 my-0 text-center text-truncate t-header">
                                                                    Method
                                                                </th>
                                                                <th class="pl-2 text-center py-0 my-0 text-truncate t-header">
                                                                    Consignment
                                                                </th>
                                                                <th class="pl-1 py-0  text-center text-truncate t-header">
                                                                    Packages
                                                                </th>
                                                                <th class="text-center pl-1 py-0 my-0 text-truncate t-header">
                                                                    Weight(Kg)
                                                                </th>
                                                                <th class="text-center text-truncate t-header">
                                                                    Collected
                                                                </th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            <tr v-for="inspection in inspections">
                                                                <td class="px-2 py-1 my-0 text-truncate">
                                                                   {{   inspection.date }}
                                                                </td>
                                                                <td class="text-center px-2 py-0 my-0 text-truncate">
                                                                    {{
                                                                        inspection.delivery_items.length > 0 ? inspection.delivery_items[0].delivery_method : ''
                                                                    }}
                                                                </td>
                                                                <td class=" text-center py-0 my-0">
                                                                    {{ inspection.No_items }}
                                                                </td>
                                                                <td class="small cursor-pointer text-center py-1 pl-1 text-truncate">
                                                                    {{ inspection.No_items }}
                                                                </td>
                                                                <td class="small cursor-pointer text-center py-1 pl-1 text-truncate">
                                                                    {{ inspection.weight }}
                                                                </td>
                                                                <td class="px-2 text-center text-truncate">
                                                                    <div v-if="!inspection.delivery_items.some(item => item.is_collected === false)">
                                                                        <div>
                                                                            <span
                                                                                class="badge badge-pill badge-success">Collected</span>
                                                                        </div>
                                                                    </div>
                                                                    <div v-else-if="!inspection.delivery_items.some(item => item.is_collected === true)">
                                                                        <div>
                                                                            <span class="badge badge-pill badge-danger">Not Collected</span>
                                                                        </div>
                                                                    </div>
                                                                    <div v-else-if="inspection.delivery_items.some(item => item.is_collected === false) && inspection.delivery_items.some(item => item.is_collected === true) ">
                                                                        <div>
                                                                            <span
                                                                                class="badge badge-pill badge-warning">Partially Collected</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-right text-small py-0 my-0 action pr-1">

                                                                                                                                            <div class="dropdown">
                                                                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                        </span>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a :href="route('deliveries.inspection' ,inspection.id)" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                                        <a :href="route('inspection.export.pdf', inspection.id)" class="dropdown-item"><i class="bx bxs-file-pdf mr-1"></i>Export PDf</a>
                                                                        <a :href="route('inspection.export.csv', inspection.id)" class="dropdown-item"><i class="bx bxs-file'mr-1"></i>Export CSV</a>
                                                                        </div>
                                                                        </div>
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

                                <div v-bind:class="{'hidden': openTab !== 6, 'block': openTab === 6}">
                                    <div class="row pb-1 pt-3 px-1" id="table-hover-row">
                                        <div class="col-12">
                                            <div class="card ">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="pl-1 px-2 py-0 my-0 text-truncate t-header">
                                                                    Date
                                                                </th>
                                                                <th class="pl-1 mb-1 py-0 my-0 text-center text-truncate t-header">
                                                                    Items
                                                                </th>
                                                                <th class="pl-1 py-0 my-0 text-truncate t-header">
                                                                </th>
                                                                <th class="py-0 text-center text-truncate t-header">
                                                                </th>
                                                                <th class="text-right pl-1 py-0 my-0 text-truncate t-header"></th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            <tr v-for="pickingList in pickingLists">

                                                                <td class=" small px-2 py-1 my-0 text-truncate">
                                                                    {{ "ISTARS_DELIVERIES_PICKING_LIST_" + formatDatepick(pickingList.date) }}
                                                                </td>
                                                                <td class="text-center  py-0 my-0 text-truncate">
                                                                    {{ pickingList.No_items }}
                                                                </td>
                                                                <td class=" px-2 py-0 my-0">
                                                                </td>
                                                                <td class="small cursor-pointer text-center py-1 pl-1 text-truncate">
                                                                </td>
                                                                <td class="text-right text-small py-0 my-0 action pr-1">
                                                                <div class="dropdown">
                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                <a :href="route('pickings.list' , pickingList.id)" class="dropdown-item"><i class="bx bx-show mr-1"></i>Show</a>
                                                                 <a :href="route('picking.list.file' , pickingList.id)" class="dropdown-item"><i class="bx bx-download  mr-1"></i>Download</a>
                                                                <a class="dropdown-item" ><i class="bx bx-trash mr-1"></i> delete</a>
                                                                </div>
                                                                </div>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade text-left"
             id="order-modal" tabindex="-1"
             role="dialog"
             aria-labelledby="myModalLabel33"
             aria-hidden="true">
            <div
                class="modal-dialog modal-dialog-centered"
                role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold text-center"
                            id="myModalLabel33">
                            Update Order Status</h4>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form @submit.prevent="submit"
                          class="form form-horizontal">
                        <div class="modal-body">

                            <label class="">Status Update</label>
                            <div class="form-group">
                                <select class="form-control"
                                        v-model="form.status"
                                        id="status">
                                    <option></option>
                                    <option value="processing">Processing</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-light-secondary"
                                    id="modal-hide"
                                    data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"
                                   ref="closeModall"></i>
                                <span
                                    class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit"
                                    @click="stopPropagation"
                                    class="btn btn-primary ml-1"
                                    data-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span
                                    class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade text-left"
             id="order-modal-ini" tabindex="-1"
             role="dialog"
             aria-labelledby="myModalLabel124"
             aria-hidden="true">
            <div
                class="modal-dialog modal-dialog-centered"
                role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold text-center"
                            id="myModalLabel124">
                            Update Order Status </h4>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form @submit.prevent="formSubmit"
                          class="form form-horizontal">
                        <div class="modal-body">
                            <label class="">Status Update</label>
                            <div class="form-group">
                                <select class="form-control"
                                        v-model="form1.order_status"
                                        id="deliveryStatus">
                                    <option></option>
                                    <option value="pending">Pending</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-light-secondary"
                                    id="deliveryModal"
                                    data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"
                                   ref="closeModall"></i>
                                <span
                                    class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit"
                                    @click="stopPropagation"
                                    class="btn btn-primary ml-1"
                                    data-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span
                                    class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </admin-layout>
</template>

<script>
import moment from 'moment';
import Button from "../../../Jetstream/Button";
import AdminLayout from "../../../Layouts/AdminLayout";
import Pagination from "../../../admin/Pagination";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";

export default {
    name: "Index",
    props: ['tuffnelDeliveryItems', 'tuffnellPendingCount', 'deliveries', 'tuffnellCount', 'pickingLists', 'inspections'],
    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
    },
    data() {
        return {
            form: this.$inertia.form({
                status: ''
            }),
            form1: this.$inertia.form({
                order_status: '',
            }),
            showMenu: true,
            openTab: 1,
            orderID: '',
            deliveryOrderID: ''
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Deliveries"
    },
    mounted() {
        if (this.deliveries.ready.length > 0) {
            this.openTab = 1;
        } else {
            this.openTab = 5;
        }

    },
    methods: {
        formatDatepick(date) {
            return moment(date).format('YYYYMMDD')
        },
        changeStatusIni(id) {
            this.deliveryOrderID = id;
        },
        changeStatus(id) {
            this.orderID = id;
        },
        formSubmit() {
            this.deliveryItem = this.tuffnelDeliveryItems.find(deliveryItem => deliveryItem.id === this.deliveryOrderID);

            let data = this.deliveryItem;
            console.log(Object.assign(data, {
                '_method': 'PUT',
                'status': this.form1.order_status,
            }));
            this.form1 = this.$inertia.form(data);

            this.form1.post(route('delivery.update', this.deliveryOrderID),
                {
                    onSuccess: () => {
                        $('#deliveryModal').trigger('click');
                        this.form1 = this.$inertia.form({
                            order_status: '',
                        });
                    },
                });
        },

        submit() {
            this.order = this.deliveries.tuffnell_pending_orders.find(order => order.id === this.orderID);
            let data = this.order;
            Object.assign(data, {
                '_method': 'PUT',
                'status': this.form.status,

            });
            this.form = this.$inertia.form(data);
            this.form.post(route('delivery.update', this.orderID),
                {
                    onSuccess: () => {
                        $('#modal-hide').trigger('click');
                        this.form = this.$inertia.form({
                            status: '',

                        });
                    },
                });
        },
        confirmDelete(id) {
            this.$inertia.get('export/ready/file/' + id)
        },
        toggleNavbar: function () {

            this.showMenu = !this.showMenu;
        },
        toggleTabs: function (tabNumber) {
            this.openTab = tabNumber
        },
        stopPropagation(e) {
            e.stopPropagation();
        },
    }
}
</script>

<style scoped>
.bg-blue1 {
    background-color: #5A8DEE !important;
}

.t-header {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

.action {
    margin-right: 4px !important;
    padding-top: 4px !important;
    padding-bottom: 4px !important;
}

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.tufnells {
    margin-bottom: 14px;
    margin-right: 8px;
}
</style>
