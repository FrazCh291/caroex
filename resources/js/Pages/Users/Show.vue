<template>
    <div>
        <admin-layout>
            <section class="invoice-view-wrapper">
                <div class="col-12 px-0">
                    <h5 class="card-title mb-0 pt-0">Users</h5>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-12 mt-1">
                        <div class="card invoice-print-area mb-0">
                            <div class="card-body mx-25 pb-1">
                                <div class="row invoice-info pr-0 mr-0">
                                    <div class="col-lg-3 col-md-8 col-sm-6 col-6 ">
                                        <div class="mb-0 title-col ">
                                            <p class="padding-change">Name</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change">Email</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-md-4 col-6 ">
                                        <div>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate">{{ user?.name }}</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate">{{ user?.email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                                       @deleteitem="deleteItemInvoice">
                    </ConfirmatiomModal>
                </div>
            </section>
        </admin-layout>
    </div>
</template>

<script>
import moment from 'moment';
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import AdminLayout from "../../Layouts/AdminLayout";
import ErrorComponent from "../../components/ErrorComponent";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {
    name: "Show",
    props: ['user'],
    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
        ErrorComponent,
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
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Show Details";
    },
    mounted() {
        this.user_id = this.user.id;
        if (this.documents) {
            this.user.document = this.documents;
        }
        if (this.params) {
            Object.assign(this.query, this.params);
        }
        this.update = false;

    },
    methods: {
        stopPropagation(e) {
            e.stopPropagation();
            this.submit();
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY');
        },
        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, {[item]: this.query[item]})
                }
            }
            this.$inertia.visit(route('users.index'), {
                method: 'get',
                data: {
                    ...query
                }
            })
        },
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            this.sweetAlert = false
            this.$inertia.delete(`/document/delete/${this.itemId}`)
        },
        deleteItemInvoice() {
            this.sweetAlert = false
            this.$inertia.delete(`/invoices/${this.itemId}`)
        },
        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
        },
        showTooltip(id) {
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
</style>
