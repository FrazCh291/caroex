<template>
    <div>
        <admin-layout>
            <section class="invoice-view-wrapper">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-12 mt-1">
                        <div class="card invoice-print-area">
                            <div class="card-body pb-0">
                                <div class="row invoice-info pr-0 mr-0">
                                    <div class="col-12">
                                        <div class="mb-0 title-col ">
                                            <p class="align-middle" v-if="logsData.order"> Order#
                                                {{ logsData.order.order_number }}</p>
                                            <p class="align-middle" v-if="logsData.purchase_order"> Purchase Order#
                                                {{ logsData.purchase_order.purchase_order_number }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-0">
                                            <p class="align-middle">User: {{ logsData.user.name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 pt-2">
                        <div class="card">
                            <div class="card-content">
                                <div class="table-responsive">
                                    <div>
                                        <table class="table table-hover mb-0" v-if="logsData.order != null">
                                            <thead>
                                            <tr>
                                                <th class="py-1 my-0 text-truncate">
                                                    Product Name
                                                </th>
                                                <th class="py-1 my-0 text-truncate">
                                                    Product Title
                                                </th>
                                                <th class="py-1 my-0 text-truncate text-right">
                                                    Qauntity
                                                </th>
                                                <th class="py-1 my-0 text-truncate text-right">
                                                    Created At
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="open in logsData.order.order_items">
                                                <td class="text-truncate">{{ open.product.name }}</td>
                                                <td class="text-truncate">{{ open.product_name }}</td>
                                                <td class="text-truncate tepurchase_order_item text-right">{{
                                                        open.quantity
                                                    }}
                                                </td>
                                                <td class="text-truncate tepurchase_order_item text-right">{{
                                                        formatDate(open.created_at)
                                                    }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-hover mb-0" v-if="logsData.purchase_order  != null">
                                            <thead>
                                            <tr>
                                                <th class="py-1 my-0 text-truncate">
                                                    Name
                                                </th>
                                                <th class="py-1 my-0 text-truncate text-right">
                                                    Qauntity
                                                </th>
                                                <th class="py-1 my-0 text-truncate text-right">
                                                    Created At
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="open in logsData.purchase_order.purchase_order_item">
                                                <td class="text-truncate">{{ open.product.name }}</td>
                                                <td class="text-truncate text-right">{{ open.quantity }}</td>
                                                <td class="text-truncate tepurchase_order_item text-right">{{
                                                        formatDate(open.created_at)
                                                    }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-11 d-flex justify-content-start pl-1 px-0">
                        <inertia-link :href="route('deals.index')" type="button"
                                      class="btn btn-light-secondary mr-1 mb-1">
                            Back
                        </inertia-link>
                    </div>
                </div>
            </section>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                               @deleteitem="deleteItem">
            </ConfirmatiomModal>
        </admin-layout>
    </div>
</template>

<script>
import moment from 'moment';
import Button from "../../Jetstream/Button"
import {useForm} from '@inertiajs/inertia-vue3'
import Pagination from "../../admin/Pagination";
import AdminLayout from "../../Layouts/AdminLayout";
import ErrorComponent from '../../components/ErrorComponent'
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {

    name: "Show",
    props: ['logsData'],

    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
        ErrorComponent
    },
    data() {
        return {
            form: this.$inertia.form({
                title: '',
                description: '',
                file: null
            }),
            sweetAlert: false,
            update: false,
            itemId: '',
            url: null,
            rotate: false
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Show Details";
    },
    mounted() {
        if (this.params) {
            Object.assign(this.query, this.params);
        }
    },
    setup() {
        const form = useForm({
            orders: [],
            deal_id: null
        })
        return {form}
    },
    methods: {
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            this.sweetAlert = false
            this.$inertia.delete(`/erp/${this.url}${this.itemId}`)
        },
        confirmDelete(url, id) {
            this.sweetAlert = true;
            this.itemId = id;
            this.url = url;
        },
        stopPropagation(e) {
            e.stopPropagation();
            this.submit();
        },
        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('cores.index'), {
                method: 'get',
                data: {
                    ...query
                }
            })
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        total(data) {
            let length = data.length;
            let totalCommission = length * parseFloat(this.deals.commission_amount)
            let total = 0;
            data.forEach(element => {
                total = total + parseFloat(element.total_price)
            });
            return total - totalCommission;
        },
        selectAll() {
            var select_all = document.getElementsByClassName("selectall");
            var checkboxes = document.getElementsByClassName("checkbox");
            for (i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = select_all[0].checked;
            }
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].addEventListener('change', function (e) {
                    if (this.checked == false) {
                        select_all[0].checked = false;
                    }
                    if (document.querySelectorAll('.checkbox:checked').length == checkboxes.length) {
                        select_all[0].checked = true;
                    }
                });
            }
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        generateInvoice() {
            var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].id != 0) {
                    this.form.orders.push(checkboxes[i].id)
                }
            }
            if (this.form.orders.length > 0) {
                this.form.post(route('deals.invoice.create'))
            }
        },
        rotateIcon(id) {
            let element = 'collaspe-icon' + id;
            if (this.rotate == false) {
                document.getElementById(element).style.transform = 'rotate(180deg)';
                this.rotate = true;
            } else {
                document.getElementById(element).style.transform = 'rotate(0deg)';
                this.rotate = false;
            }
        }
    }
}
</script>

<style scoped>
.t-header {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

.action {
    padding-top: 8px !important;
    padding-bottom: 8px !important;
}

.text-small {
    font-size: 14px !important;
}

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
    height: auto !important;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.text-title-icon {
    vertical-align: super;
}

.collapseIcon {
    margin-top: 15px;
}

#main #faq .card .card-header i:after {
    content: "\f107";
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    float: right;
}

svg {
    transform: rotate(90deg);
}

.custome-table td {
    border-bottom: none !important;
    border-top: 1px solid #DFE3E7 !important;
}

.check-down {
    margin-top: 10px;
    margin-right: 10px;
}

</style>
