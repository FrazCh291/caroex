<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-xl-9 col-12 ">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <div class="col-12">
                                    <div class="row invoice-info pr-0 mr-0">
                                        <div class="col-6">
                                            <p class="pt-1">
                                                <span class="headding">iStarz</span><br>
                                                18 Jelley Way
                                                Woking<br>
                                                Surrey<br>
                                                GU22 9FT<br>
                                                info@istarz.co.uk<br>
                                                VAT Registration No.: 280 3468 02 - ISTARZ<br>
                                                LTD
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <img class="float-right" src="/img/iStarz-logo.PNG">
                                        </div>
                                        <div class="col-lg-8 col-md-11 col-sm-3 col-11">
                                            <div class="mb-0 title-col ">
                                                <p class="text-truncate mb-0 headding">INVOICE TO:</p>
                                            </div>
                                            <div class="mb-0 title-col">
                                                <p class="">{{ salesChannel.name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 text-right">
                                            <p class="font-weight-bold mb-0">INVOICE NO:</p>
                                            <div class="mb-0">
                                                <p class="font-weight-bold mb-0">DATE:</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="font-weight-bold mb-0">DUE DATE:</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="font-weight-bold mb-0">TERMS:</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div>
                                                <div class="mb-0">
                                                    <p class="mb-0">{{ invoice.invoice_number }}</p>
                                                </div>
                                                <div class="mb-0">
                                                </div>
                                                <p class="mb-0">{{ formatDate(invoice.invoice_date) }}</p>
                                                <div class="mb-0">
                                                    <p class="mb-0">{{ formatDate(invoice.due_date) }}</p>
                                                </div>
                                                <div class="mb-0">
                                                    <p class="mb-0">14 days</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" pb-1">
                                                <hr class=""/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div v-if="invoice.invoice_items.length>0" class="row py-0 my-0">
                                            <div id="table-hover-row" class="row col-12 pr-0 ng-repeat-start">
                                                <div class="col-12 pr-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover truncate mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="invoice-item">Activity</th>
                                                                            <th class="invoice-item">QTY</th>
                                                                            <th class="invoice-item">RATE</th>
                                                                            <th class="invoice-item">VAT</th>
                                                                            <th class="text-right invoice-item">AMOUNT</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="invoiceItem in invoices"
                                                                            class="py-0 my-0">
                                                                            <td class="invoice-item">{{ invoiceItem.invoice_items[0].product.name}}
                                                                            </td>
                                                                            <td class="invoice-item">{{ invoiceItem.invoice_items_count  }}
                                                                            </td>
                                                                            <td class="invoice-item"> {{
                                                                                invoiceItem.total }}</td>
                                                                            <td class="invoice-item">20% S</td>
                                                                            <td class="text-right invoice-item">{{
                                                                                invoiceItem.total
                                                                                }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="py-0 my-0">
                                                                            <td class="invoice-item"><b>Comission</b></td>
                                                                            <td class="invoice-item"></td>
                                                                            <td class="invoice-item">
                                                                                -{{ commissionAmount }}
                                                                            </td>
                                                                            <td class="invoice-item">
                                                                                20% S
                                                                            </td>
                                                                            <td class="invoice-item text-right">
                                                                                -{{ commissionAmount }}
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12"></div>
                                            </div>
                                        </div>
                                        <div class="row form-group py-0 my-0">
                                            <div class="col-6">
                                            </div>
                                            <div class="col-10 form-group text-right mb-0">
                                                <label>INCLUDED VAT TOTAL</label>
                                            </div>
                                            <div class="col-2 form-group text-center text-truncate mb-0">
                                                <p> {{ vatAmount }}</p>
                                            </div>
                                            <div class="col-10 form-group text-right mb-0">
                                                <label>TOTAL</label>
                                            </div>
                                            <div class="col-2 form-group text-center text-truncate mb-0">
                                                <p> {{ totalReceivable }} </p>
                                            </div>
                                            <div class="col-10 form-group text-right mb-0">
                                                <label>BALANCE DUE</label>
                                            </div>
                                            <div class="col-2 form-group text-center text-truncate mb-0">
                                                <h3> {{ totalReceivable }} </h3>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row py-0 my-0">
                                                <div id="table-hover-row" class="row col-12 pr-0 ng-repeat-start">
                                                    <div class="col-12 pr-0">
                                                        <div class="card pr-0 pb-0 mb-1">
                                                            <div class="card-content">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover truncate mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="invoice-item">RATE</th>
                                                                                <th class="invoice-item">VAT</th>
                                                                                <th class="invoice-item text-right">NET</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="py-0 my-0">
                                                                                <td class="invoice-item">
                                                                                    VAT @ 20%
                                                                                </td>
                                                                                <td class="invoice-item">
                                                                                    {{ vatAmount }}
                                                                                </td>
                                                                                <td class="invoice-item text-right">
                                                                                    {{ netPrice }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6 offset-md-3  col-sm-8 offset-sm-2 text-center">
                                                <p>In According to our contract we expect payment within 30 days after the goods
                                                    have been delivered. Interest rate charges of 0.028% will be applied on the
                                                    total overdue amount in the events of you falling to make payment within the
                                                    specified 30 day window
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="col-sm-11 px-0">
                                            <inertia-link :href="route('deals.show', deal.deal_number)" type="button"
                                                class="btn btn-light-secondary mb-2 mt-2 ml-2">
                                                Back
                                            </inertia-link>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </section>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked" @deleteitem="deleteItem">
            </ConfirmatiomModal>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from "../../../Layouts/AdminLayout";
    import JetInputError from ".././../../Jetstream/InputError";
    import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";
    import moment from 'moment';

    export default {
        name: "View",
        props: ["invoice", "company", "netPrice", "salesChannel", "deal", "commissionAmount", "vatAmount", "totalReceivable", "invoices"],
        components: {
            AdminLayout,
            JetInputError,
            ConfirmatiomModal,
        },
        data() {
            return {
                id: null,
                sweetAlert: false,
                itemId: "",
                controller: "",
            };
        },
        beforeMount() {
            console.log(this.invoices, 'deal');
            document.title = process.env.MIX_APP_NAME + " - Invoice Details";
        },
        methods: {
            submit() { },

            Clicked() {
                this.sweetAlert = false;
            },
            formatDate(date) {
                if (date) {
                    return moment(date).format("DD/MM/YYYY");
                } else {
                    return "";
                }
            },
            commision(data) {
                let length = data.length;
                return length * parseFloat(this.deal.commission_amount);
            },
            totalVat(data) {
                let length = data.length;
                return length * parseFloat(this.deal.vat_amount);
            },
            total(data) {
                let length = data.length;
                // let totalCommission = length * parseFloat(this.deal.commission_amount)
                let total = 0;
                data.forEach(element => {
                    total = total + parseFloat(element.total_price)
                });
                return total;
            },
            deleteItem() {
                this.sweetAlert = false;
                this.$inertia.delete(`/${this.controller}/${this.itemId}`);
            },
            confirmDelete(controller, id) {
                this.sweetAlert = true;
                this.itemId = id;
                this.controller = controller
            },
        },
    };

</script>

<style scoped>
    .line {
        border-top: 1px dashed #c7cfd6;
        width: 100%;
    }

    .error {
        margin-top: 0px !important;
    }

    .invoice-item {
        padding: 12px 31px;
    }

    .net {
        padding-right: 60px;
    }

    .headding{
        font-weight: 800;
        padding-top: 20px;
    }

    @media (max-width: 768px) {
        .net {
            padding-right: 5px;
        }
    }
</style>
