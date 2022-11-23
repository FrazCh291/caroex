<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-lg-9 col-xl-9 col-12">
                        <div class="card invoice-print-area">
                            <div class="card-header pb-0 mb-0">
                                <h1 class="card-title">
                                    {{ userData.name }}
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
                                            {{ userData.name }}
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col-2">
                                            Email:
                                        </div>
                                        <div class="col-10">
                                            {{ userData.email }}
                                        </div>
                                    </div>

                                    <div>

                                        <div class="row">
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
                                                                        <th class="py-0 my-0 text-truncate t-header px-0 mx-0"></th>
                                                                        <th class="py-0 my-0 text-truncate t-header px-0 mx-0"></th>

                                                                        <th class="text-center py-0 my-0 text-truncate t-header px-0 mx-0">
                                                                            List
                                                                        </th>
                                                                        <th class="text-center py-0 my-0 text-truncate t-header px-0 mx-0">
                                                                            Create
                                                                        </th>
                                                                        <th class="text-center py-0 my-0 text-truncate t-header px-0 mx-0">
                                                                            Update
                                                                        </th>
                                                                        <th class="text-center py-0 my-0 text-truncate t-header px-0 mx-0">
                                                                            Show
                                                                        </th>
                                                                        <th class="text-center py-0 my-0 text-truncate t-header px-0 mx-0">
                                                                            Destroy
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr v-for="module in modules"
                                                                        class="py-0 my-0 px-0 mx-0">
                                                                        <td class="px-2 small cursor-pointer py-0 my-0 text-truncate">
                                                                            {{ module.name }}
                                                                        </td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td class="text-center text-small action-transfer action  px-0 mx-0">
                                                                            <span>
                                                                                <label
                                                                                    :href="route('companies.edit', 1)">
                                                                                    <span
                                                                                        class="badge-circle badge-circle-light-secondary "
                                                                                        @click="givePermission(module.id , module.name.toLowerCase()+'.index')">
                                                                                    <i v-if="checkPermission(module,'index')"
                                                                                       class="bx bx-check font-medium-1 text-success align-items-center text-center"></i>
                                                                                    <i v-else
                                                                                       class="bx bx-x font-medium-1 text-danger align-items-center text-center"></i>
                                                                                    </span>
                                                                                </label>
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center text-small action-transfer action  px-0 mx-0">
                                                                            <span>
                                                                                <label>
                                                                                    <span
                                                                                        class="badge-circle badge-circle-light-secondary "
                                                                                        @click="givePermission(module.id , module.name.toLowerCase()+'.create')">
                                                                                        <i v-if="checkPermission(module,'create')"
                                                                                           class="bx bx-check font-medium-1 text-success align-items-center text-center"></i>
                                                                                    <i v-else
                                                                                       class="bx bx-x font-medium-1 text-danger align-items-center text-center"></i>
                                                                                    </span>
                                                                                </label>
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center text-small action-transfer action  px-0 mx-0">
                                                                            <span>
                                                                                <label
                                                                                    :href="route('companies.edit', 1)">
                                                                                    <span
                                                                                        class="badge-circle badge-circle-light-secondary"
                                                                                        @click="givePermission(module.id , module.name.toLowerCase()+'.update')">
                                                                                     <i v-if="checkPermission(module,'update')"
                                                                                        class="bx bx-check font-medium-1 text-success align-items-center text-center"></i>
                                                                                    <i v-else
                                                                                       class="bx bx-x font-medium-1 text-danger align-items-center text-center"></i>
                                                                                    </span>
                                                                                </label>
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center text-small action-transfer action  px-0 mx-0">
                                                                            <span>
                                                                                <label
                                                                                    :href="route('companies.edit', 1)">
                                                                                    <span
                                                                                        class="badge-circle badge-circle-light-secondary "
                                                                                        @click="givePermission(module.id , module.name.toLowerCase()+'.show')">
                                                                                      <i v-if="checkPermission(module,'show')"
                                                                                         class="bx bx-check font-medium-1 text-success align-items-center text-center"></i>
                                                                                    <i v-else
                                                                                       class="bx bx-x font-medium-1 text-danger align-items-center text-center"></i>
                                                                                    </span>
                                                                                </label>
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center text-small action-transfer action  px-0 mx-0">
                                                                            <span>
                                                                                <label
                                                                                    :href="route('companies.edit', 1)">
                                                                                    <span
                                                                                        class="badge-circle badge-circle-light-secondary"
                                                                                        @click="givePermission(module.id , module.name.toLowerCase()+'.destroy')">
                                                                                        <i v-if="checkPermission(module,'destroy')"
                                                                                           class="bx bx-check font-medium-1 text-success align-items-center text-center"></i>
                                                                                    <i v-else
                                                                                       class="bx bx-x font-medium-1 text-danger align-items-center text-center"></i>
                                                                                    </span>
                                                                                </label>
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

                    <div class="col-lg-3 col-xl-3 col-md-6 col-12">
                        <div class="card mb-2">
                            <div class="card-content">
                                <div class="card-body py-2 px-2">
                                    <div class="row">
                                        <div class="col-md-12 form-group py-0 my-0">
<!--                                            <div>-->
<!--                                                Sample-->
<!--                                                <span class="float-right">$123</span>-->
<!--                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body px-2 py-2">
                                    <div class="row">
                                        <div class="col-md-12 form-group py-0">
                                            <div class="position-relative has-icon-left">
                                                <inertia-link href="#">
                                                    <span
                                                        class="btn btn-primary btn-lg btn-block text-small">Edit</span>
                                                </inertia-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from "../../../../Layouts/AdminLayout";
import Label from "@/Jetstream/Label";

export default {
    name: "Module",
    props: ['modules', 'userData'],
    components: {Label, AdminLayout},
    mounted() {
        // var irf = this.userData.role.permissions.findIndex(function(per, index) {
        //     if(per.module_id == 2)
        //         return true;
        // });
        // console.log(irf,'founf'); //
    },
    methods: {
        givePermission(id, permission) {
            this.$inertia.visit(route('allow.permissions'), {
                method: 'post',
                data: {
                    id: id,
                    permission: permission,
                    role_id:this.userData.role.id
                }
            })

        },
        checkPermission(module, crud) {
            var rule;
            this.userData.role.permissions.forEach(function (permition) {
                if ((permition.module_id === module.id) && (permition.action === module.name.toLowerCase() + '.' + crud)) {
                    rule = true;
                }
            });
            return rule;
        },
        showCustomerMenuOnLoad() {



            // let customerMenuItems = ['sessions.index', 'sessions.edit', 'sessions.show', 'trainers', 'class.detail', 'user-classes.index'
            //     , 'user-class-detail', 'trainers-classes', 'classes.show', 'user-classes.show'];
            // if (customerMenuItems.indexOf(this.currentRoute) > -1) {
            //     this.showCustomerMenu = true;
            // }
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
    width: 60px !important;
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
