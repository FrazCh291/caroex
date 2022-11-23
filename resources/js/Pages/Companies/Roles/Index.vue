<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-lg-9 col-xl-9 col-12">
                        <div class="card invoice-print-area">
                            <div class="card-header pb-0 mb-0">
                                <h1 class="card-title">
                                    {{ company.name }}
                                </h1>
                            </div>
                            <div class="px-2">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body pb-1 mx-25">
                                    <div class="row mt-0">
                                        <div class="col-2">
                                            Owner:
                                        </div>
                                        <div class="col-10">
                                            {{ company.company_owner ? company.company_owner.name : '' }}
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col-2">
                                            Email:
                                        </div>
                                        <div class="col-10">
                                            {{ company.company_owner ? company.company_owner.email : '' }}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="row pb-0.5">

                                            <div class="col-10">
                                                <h2 class="card-title mb-0 pt-1">Add Role</h2>
                                            </div>
                                            <div class="col-2 text-right">
                                                <div class="col form-group pr-0 pb-0.5">
                                                    <label data-toggle="modal"
                                                           data-target="#inlineForm"
                                                           class="px-0">
                                                        <i class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1"></i>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-2" v-if="company.subscription">
                                                <div class="col form-group pr-0 pb-0.5">
                                                    <inertia-link :href="route('company.users',company.id)"
                                                                  class="px-0">
                                                        <i class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1"></i>
                                                    </inertia-link>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-n1">
                                            <div class="row col-12 pr-0" id="table-hover-row">
                                                <div class="col-12 pr-0">
                                                    <div class="card pr-0 pb-0 mb-1">
                                                        <div class="card-content">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="px-2 text-left py-0 my-0 text-truncate t-header">
                                                                            Name
                                                                        </th>

                                                                        <th class="text-right py-0 my-0 text-truncate t-header px-0 mx-0">

                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr v-for="role in company.roles"
                                                                        class="py-0 my-0 px-0 mx-0" >
                                                                        <td class="px-2 small cursor-pointer py-0 my-0 text-truncate" >
                                                                            {{ role.role }}
                                                                        </td>

                                                                        <td class="text-right text-small action-transfer action pr-1">
                                                                              <span
                                                                                  class="d-inline-flex align-items-center">
                                                                                  <inertia-link
                                                                                      :href="route('companies.modules.permissions', role.id)">
                                                                                      <span
                                                                                          class="badge-circle badge-circle-light-secondary ">
                                                                                         <i class="bx bxs-show font-medium-1 align-items-center text-center"></i>
                                                                                      </span>
                                                                                 </inertia-link>
                                                                              </span>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <!--                                            <pagination :links="transfers.links"-->
                                                <!--                                                        class="float-right"></pagination>-->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--                <Toastr v-if="success" :message="message" :type="type"></Toastr>-->
                    <div class="col-lg-3 col-xl-3 col-md-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body px-2 py-2">
                                    <div class="row py-0">
                                        <div class="col-md-12 form-group py-0 my-0">
                                            <div class="position-relative has-icon-left">
                                                <inertia-link href="#">
                                                    <span
                                                        class="btn btn-primary btn-lg btn-block text-small">Roles & Permissions</span>
                                                </inertia-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade text-left" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">Add Role</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                            <form @submit.prevent="submitRole">
                                <div class="modal-body mb-1">
                                    <label>Role: </label>
                                    <div class="form-group">
                                        <input v-model="form1.role" type="text" class="form-control">
                                        <ErrorComponent input="role"></ErrorComponent>
                                    </div>
                                    <label>Slug: </label>
                                    <div class="form-group mb-0">
                                        <input v-model="form1.slug" type="text" class="form-control">
                                        <ErrorComponent input="slug"></ErrorComponent>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary"
                                            id="modal-hide"
                                            ref="closeMod"
                                            data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="button" class="btn btn-primary ml-1" data-dismiss="modal"
                                            @click="stopPropagation">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Save</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </admin-layout>
</template>

<script>

import AdminLayout from "../../../Layouts/AdminLayout";
import Button from "../../../Jetstream/Button"
import Pagination from "../../../admin/Pagination";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";
import Label from "@/Jetstream/Label";
import ErrorComponent from "@/components/ErrorComponent";

export default {

    name: "Index",
    props: ['company', 'error'],

    components: {
        Label,
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
        ErrorComponent
    },
    data() {
        return {
            query: {
                query: '',
                id: false,
                first_name: false,
                date: false,
                amount_sent: false,
                is_admin: false,
                direction: null,
                paid: false,
                un_paid: false,
                partially_paid: false,
                page: 1,
                transfer_request: true
            },

            form1: this.$inertia.form({
                role: '',
                slug: '',
                'company_id': this.company.id
            }),
        }
    },
    beforeMount() {
    },
    mounted() {
        if (this.$page.props.auth.user.is_admin == 1) {
            this.is_admin = true
        }
    },
    methods: {
        submitRole() {
            this.form1.post(route('add.role'), {
                onSuccess: (page) => {
                    $('#modal-hide').trigger('click');
                    this.form1 = this.$inertia.form({
                        role: '',
                        slug: '',
                        'company_id': this.company.id
                    });
                },
            })
        },
        stopPropagation(e) {
            e.stopPropagation();
            this.submitRole();
        },
        resetSort(e) {
            this.query.id = '';
            this.query.rel_first_name = '';
            this.query.date = '';
            this.query.amount_sent = '';
            this.query.direction = '';
            this.query.page = '';
            this.loadData();
        },
        resetFilter(e) {
            this.query.paid = '';
            this.query.un_paid = '';
            this.query.partially_paid = '';
            this.query.direction = '';
            this.query.page = '';
        },
        resetQuery() {
            this.query = {}
            this.loadData()
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
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}


.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
    height: auto !important;
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
    color: #00A1FF;
}

.popover-content h4 small {
    color: black;
}

.popover-content button.btn-primary {
    color: #00A1FF;
    border-color: #00A1FF;
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
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}


tr.spaceUnder > td {
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
}
</style>
