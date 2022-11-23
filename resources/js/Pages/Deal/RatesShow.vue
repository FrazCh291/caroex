<template>
    <div>
        <admin-layout>
            <section class="invoice-view-wrapper">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-12 mt-1">
                        <div class="card invoice-print-area">
                            <div class="card-body pb-0">
                                <div class="row invoice-info pr-0 mr-0">
                                    <div class="col-sm-2">
                                        <div class="mb-0 title-col ">
                                            <p class="align-middle"> Deal# {{ (deals.deal_number) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-12">
                                        <div class="mb-0">
                                            <!-- <p class="align-middle">{{ deals.order_items[0]?deals.order_items[0].product.name:'' }}</p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-success">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div
                                                class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                                <i class="bx bx-cart font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Sales Quantity</div>
                                            <h3 class="mb-0">{{ orderQuantity }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-success">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div
                                                class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                                <i class="bx bx-money font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Deal Cap</div>
                                            <h3 class="mb-0">{{ totalCap }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-danger">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div
                                                class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bx-user font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Total Commission</div>
                                            <h3 class="mb-0">£{{ totalCommission.toFixed(2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-danger">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div
                                                class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bx-user font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Total VAT</div>
                                            <h3 class="mb-0">£{{ (totalVat).toFixed(2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-success">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div
                                                class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                                <i class="bx bx-briefcase-alt font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Total P & P VAT</div>
                                            <h3 class="mb-0">£{{ totalPpVat.toFixed(2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-2 col-md-4 col-sm-6 col-6 dashboard-users-danger">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div
                                                class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bx-user font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Exclusive Tax Amount</div>
                                            <h3 class="mb-0">£{{ totalExclusiveTextAmount.toFixed(2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12 col-12 mt-1">
                        <div class="card invoice-print-area">
                            <div class="card-body mx-25 pb-1">
                                <div class="row invoice-info pr-0 mr-0">
                                    <div class="col-lg-3 col-md-8 col-sm-3 col-9 ">
                                        <div class="mb-0 text-truncate">
                                            <p class="padding-change ">Inclusive Rate Per Item</p>
                                        </div>
                                        <div class="mb-0 title-col ">
                                            <p class="text-truncate"> Total VAT </p>
                                        </div>
                                        <div class="mb-0 title-col text-truncate">
                                            <p class="padding-change text-truncate"> VAT Deduct Commission </p>
                                        </div>
                                        <div class="mb-0 title-col text-truncate ">
                                            <p class="padding-change text-truncate"> Commission Amount</p>
                                        </div>
                                        <div class="mb-0 text-truncate">
                                            <p class="padding-change text-truncate">Commission Percentage</p>
                                        </div>
                                        <div class="mb-0 text-truncate">
                                            <p class="padding-change ">VAT%</p>
                                        </div>
                                        <div class="mb-0 text-truncate">
                                            <p class="padding-change ">VAT Amount on 20%</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-3 col-md-4 col-3 ">
                                        <div>
                                            <div class="mb-0 ">
                                                <p class="padding-change text-truncate">£{{ deals.deal_price }}</p>
                                            </div>
                                            <div class="mb-0 ">
                                                <p class="padding-change text-truncate ">£{{ deals.total_net_vat }}</p>
                                            </div>
                                            <div class="mb-0 ">
                                                <p class="padding-change text-truncate ">{{ deals.vat_deduct_commission
                                                    }}%</p>
                                            </div>
                                            <div class="mb-0 ">
                                                <p class="text-truncate">£{{ deals.commission_amount }}</p>
                                            </div>
                                            <div class="mb-0 ">
                                                <p class="padding-change text-truncate ">{{ deals.plateform_fee
                                                    }}%</p>
                                            </div>
                                            <div class="mb-0 ">
                                                <p class="padding-change text-truncate ">20%</p>
                                            </div>
                                            <div class="mb-0 ">
                                                <p class="padding-change text-truncate ">{{deals.vat}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-8 col-sm-3 col-9">
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Standard Postage</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Highlands Postage</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Exclusive Tax Amount</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Total Receivable</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Contract Signed At</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Start Date</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">End Date</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-3 col-md-4 col-3">
                                        <div>
                                            <div class="mb-0">
                                            </div>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate">£{{ deals.standard_postage }}</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate">£{{ deals.highlands_postage }}</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate">£{{ deals.exclusive_text_amount
                                                    }}</p>
                                            </div>
                                            
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate">£{{ deals.total_receivable
                                                    }}</p>
                                            </div>

                                            <div class="mb-0">
                                                <p class="padding-change text-truncate ">
                                                    {{
                                                    deals ? formatDate(deals.contract_signed_at) : ''
                                                    }}
                                                </p>
                                            </div>

                                            <div class="mb-0">
                                                <p class="padding-change text-truncate ">
                                                    {{
                                                    deals? formatDate(deals.start_date):''
                                                    }}
                                                </p>
                                            </div>

                                            <div class="mb-0">
                                                <p class="padding-change text-truncate ">
                                                    {{
                                                    deals ? formatDate(deals.end_date) : ''
                                                    }}
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 pt-2">
                        <div class="card" v-if="deals.documents.length>0">
                            <div class="card-content">
                                <div class="table-responsive">
                                    <div>
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr>
                                                <th class="text-left pl-1 py-0 my-0 text-truncate t-header">
                                                    Title
                                                </th>
                                                <th class="text-left py-0 my-0 text-truncate t-header">
                                                    File
                                                </th>
                                                <th class="text-left py-0 my-0 text-truncate t-header">
                                                    Description
                                                </th>
                                                <th class="text-right py-0 my-0 text-truncate t-header"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="document in deals.documents"
                                                class="py-0 my-0">
                                                <td class="text-left cursor-pointer px-1 py-0 my-0 text-truncate">
                                                    <div v-if="document.file_type === 'pdf'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'csv'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file success font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'docx'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-doc primary font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'txt'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-txt font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'jpg'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-jpg font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'png'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-png font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'xlsx'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'TXT'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-txt font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'PDF'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-pdf danger font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'CSV'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file success font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'DOCX'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-doc primary font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'JPG'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-jpg font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'PNG'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-png font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else-if="document.file_type === 'XLSX'">
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                    <div v-else>
                                                        <a :href="route('view.deals.document', document.id)">
                                                            <i class="bx bxs-file-image font-large-1"></i>
                                                        </a>
                                                        <span class="text-title-icon pl-0.5">{{ document.title }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-left small cursor-pointer py-0 my-0 text-truncate">
                                                    {{ document.file.substring(23) }}
                                                </td>
                                                <td class="text-left small cursor-pointer py-0 my-0 text-truncate">
                                                    {{ document.description }}
                                                </td>
                                                <td class="text-right text-small action pr-1">
                                                    <a :href=" route('export.deals.document' ,document.id )">
                                                        <span class="badge-circle badge-circle-light-secondary action mb-1">
                                                            <i class="bx bx-download font-medium-1 align-items-center text-center"></i>
                                                        </span>
                                                    </a>
                                                    <button
                                                        v-on:click="confirmDelete('document/delete/', document.id)">
                                                        <span class="badge-circle badge-circle-light-secondary ml-1/6">
                                                            <i class="bx bx-trash font-medium-1 text-left"></i>
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
        props: ['deals', 'orders', 'orderCount', 'totalVat', 'totalCommission', 'totalExclusiveTextAmount', 'orderQuantity', 'totalPpVat', 'dealPrice', 'deal_id', 'invoices', 'totalCap'],

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
            console.log(this.deals);
            document.title = process.env.MIX_APP_NAME + " - Show Details";
            this.form.deal_id = this.deals.id;
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
                if(date){
                    return moment(date).format('DD-MM-YYYY')
                }else{
                    return ''
                }
            },
            // totalFun(dealId, productId) {
            //         axios
            //             .get("/super/admin/search-rate", {
            //                 params: {
            //                     id: this.query.from_to,
            //                 },
            //             })
            //             .then((response) => {
            //                 this.exchange = response.data.exchange;
            //                 this.chart = response.data.chart;
            //             });
            // },
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
