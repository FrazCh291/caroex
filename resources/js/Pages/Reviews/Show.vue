<template>
    <div>
        <admin-layout>
            <section class="invoice-view-wrapper">
                <div class="col-12 px-0">
                    <h5 class="card-title mb-0 pt-0">Review Detail</h5>
                </div>
                <div class="row ">
                    <div class="col-xl-12 col-md-12 col-12 mt-1 ">
                        <div class="card invoice-print-area mb-0">
                            <div class="card-body mx-25 pb-1 ">
                                <div class="row invoice-info pr-0 mr-0 ">
                                    <div class="col-lg-3 col-md-8 col-sm-6 col-9">
                                        <div class="mb-0 title-col ">
                                            <p class="padding-change text-truncate">Name</p>
                                        </div>
                                        <div class="mb-0 title-col ">
                                            <p class="padding-change text-truncate">Email</p>
                                        </div>
                                        <div class="mb-0 title-col ">
                                            <p class="padding-change text-truncate">Channel</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Url</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Product</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-md-4 col-3">
                                        <div>
                                            <div class="mb-0" >
                                                <p class="padding-change text-truncate">{{ review.name }}</p>
                                            </div>
                                            <div class="mb-0" >
                                                <p class="padding-change text-truncate">{{ review.email }}</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="text-truncate">{{review.channels.name}}</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate" v-if="review.url">{{ review.url }}</p>
                                                <p class="padding-change text-truncate" v-else id="url">null</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate" v-if="review.products">
                                                    {{ review.products.name }}</p>
                                                <p class="padding-change text-truncate" v-else></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-8 col-sm-6 col-9">
                                        <p class="padding-change text-truncate">Rating</p>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Last Sent Date</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Status</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate" id="activeLabel">Active</p>
                                        </div>
                                        <div class="mb-0">
                                            <p class="padding-change text-truncate">Comment</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-md-4 col-3">
                                        <div>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate">{{ review.rating }}</p>
                                            </div>
                                            <div class="mb-0">
                                                <p class="padding-change text-truncate" v-if="review.last_sent_at">
                                                    {{ formatDate(review.last_sent_at) }}</p>
                                                <p class="padding-change text-truncate" v-else id="date">null</p>
                                            </div>
                                            <div class="mb-0">
                                                <span v-if="review.status === 'review_approved'"
                                                      class="badge badge-light-success badge-pill text-truncate">Approved</span>
                                                <span v-else class="badge badge-light-danger badge-pill text-truncate">
                                                    Unapproved</span>
                                            </div>
                                            <div class="mb-0 text-truncate" id="active">
                                                <span v-if="review.is_active == true"
                                                      class="badge badge-light-success badge-pill text-truncate  ">
                                                <i class="bx bx-check font-medium-1"></i></span>
                                                <span v-else class="badge badge-light-danger badge-pill text-truncate">
                                                <i class="bx bx-x font-medium-1"></i></span>
                                            </div>
                                            <div class="mb-0" id="comment">
                                                <p class="padding-change text-truncate">{{ review.comment }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-11 d-flex justify-content-start ml-2 px-0">
                                              
                                                <inertia-link :href="route('reviews.index')" type="button"
                                                              class="btn btn-light-secondary mr-1 mb-1">
                                                    Back
                                                </inertia-link>
                            </div>
                        </div>
                    </div>
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
        props: ['review'],
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
            document.title = process.env.MIX_APP_NAME + " - Review Details";
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
                this.$inertia.visit(route('supplier.index'), {
                    method: 'get',
                    data: {
                        ...query
                    }
                })
            },
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

    #active, #comment {
        margin-top:10px;
    }
    #activeLabel {
        margin-top:15px;
    }
    #url, #date {
        color: white;
    }
</style>
