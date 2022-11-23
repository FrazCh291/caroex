<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="col form-group p-0">
                <inertia-link :href="route('cases.create')" class="btn btn-primary" data-repeater-create="">
                    Add Case
                </inertia-link>
                <a class="btn btn-primary ml-1" @click="addCustomer" data-repeater-create=""  data-toggle="modal" data-target="#addCustomer">
                    Add Customer
                </a>
            </div>
        </div>
        <div class="row pb-2" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="">
                            <div class="tabbable-responsive">
                                <div class="tabbable">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first"
                                               role="tab" aria-controls="first" aria-selected="true">Open</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="second-tab" data-toggle="tab" href="#second"
                                               role="tab" aria-controls="second" aria-selected="false">In Progress</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="third-tab" data-toggle="tab" href="#third"
                                               role="tab" aria-controls="third" aria-selected="false">Closed</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="first" role="tabpanel"
                                     aria-labelledby="first-tab">
                                    <div class="row" id="table-hover">

                                        <div class="col-12 px-3 pb-0 mb-0" v-if="openCases.data.length>0">
                                            <div class="card mb-1">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="supplier-name">Case#</th>
                                                                <th class="">channel</th>
                                                                <th class="">Potential Customer</th>
                                                                <th class="">Customer</th>
                                                                <th class="">Order#</th>
                                                                <th class="">Tracking#</th>
                                                                <th class="">priority</th>
                                                                <th class="">status</th>
                                                                <th class=""></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="open in openCases.data">
                                                                <td class="text-truncate">{{ open.case_number }}</td>
                                                                <td class="text-truncate">
                                                                    {{ open.channel ? open.channel.name: '' }}
                                                                </td>
                                                                 <td class="text-truncate">
                                                                    {{ open.customer?open.customer.name:'' }}
                                                                </td>
                                                                <td class="text-truncate">
                                                                    {{ open.order?open.order.customer?open.order.customer.name: '':'' }}
                                                                </td>
                                                                <td class="text-truncate">{{
                                                                        open.order?open.order.order_number:''
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{
                                                                        open?open.tracking_number:''
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{ open.priority }}</td>
                                                                <td class="text-truncate">{{ open.status }}</td>
                                                                <td class="text-right py-0 my-0 truncate custom-padding-right">
                                                                <div class="dropdown">
                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                <a :href="route('cases.show', open.id)" class="dropdown-item" ><i class="bx bx-show mr-1"></i>Show</a>
                                                                <a class="dropdown-item" v-on:click="confirmDelete(open.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                        <div class="row pt-1 pl-5" style="margin-left :1px " v-else>
                                            <p>You do not have any open cases yet!</p>
                                        </div>
                                        <div class="col-12">
                                            <pagination :links="openCases.links"
                                                        class="float-right openCases"></pagination>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                                    <div class="col-12 px-1 pb-0 mb-0">
                                        <div class="col-12 px-1 pb-0 mb-0" v-if="inprogressCases.data.length>0">
                                            <div class="card mb-1">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="supplier-name">Case#</th>
                                                                <th class="">channel</th>
                                                                <th class="">Potential Customer</th>
                                                                <th class="">Customer</th>
                                                                <th class="">Order#</th>
                                                                <th class="">Tracking#</th>
                                                                <th class="">priority</th>
                                                                <th class="">status</th>
                                                                <th class=""></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="progress in inprogressCases.data">
                                                                <td class="text-truncate">{{
                                                                        progress.case_number
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate" v-if="progress.channel">
                                                                    {{ progress.channel?progress.channel.name:'' }}
                                                                </td>
                                                                <td class="text-truncate" v-else>
                                                                </td>
                                                                <td class="text-truncate" v-if="progress.customer">
                                                                    {{ progress.customer?progress.customer.name:'' }}
                                                                </td>
                                                                <td class="text-truncate" v-else></td>
                                                                <td class="text-truncate" v-if="progress.order">
                                                                    {{ progress.order.customer?progress.order.customer.name:'' }}
                                                                </td>
                                                                <td class="text-truncate" v-else>
                                                                </td>
                                                                <td class="text-truncate" v-if="progress.order">{{
                                                                        progress.order?progress.order.order_number:''
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate" v-else>
                                                                </td>
                                                                <td class="text-truncate">{{
                                                                        progress?progress.tracking_number:''
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{ progress?progress.priority:'' }}</td>
                                                                <td class="text-truncate">{{ progress?progress.status:'' }}</td>
                                                                <td class="text-right py-0 my-0 truncate custom-padding-right">

                                                          <div class="dropdown">
                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                <a :href="route('cases.show',progress.id)" class="dropdown-item" ><i class="bx bx-show mr-1"></i>Show</a>
                                                                <a class="dropdown-item" v-on:click="confirmDelete(progress.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                        <div class="row pt-1 pl-3" v-else>
                                            <p>You do not have any open cases yet!</p>
                                        </div>
                                        <div class="col-12 mr-5">
                                            <pagination :links="inprogressCases.links" class="float-right"></pagination>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
                                    <div class="col-12 px-1 pb-0 mb-0">

                                        <div class="col-12 px-1 pb-0 mb-0" v-if="closedCases.data.length>0">
                                            <div class="card mb-1">
                                                <div class="card-content">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th class="supplier-name">Cases#</th>
                                                                <th class="">channel</th> 
                                                                <th class="">Potential Customer</th>
                                                                <th class="">Customer</th>
                                                                <th class="">Order#</th>
                                                                <th class="">Tracking#</th>
                                                                <th class="">priority</th>
                                                                <th class="">status</th>
                                                                <th class=""></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="closed in closedCases.data">
                                                                <td class="text-truncate">{{ closed.case_number }}</td>
                                                                <td class="text-truncate" v-if="closed.channel">
                                                                    {{ closed.channel?closed.channel.name:'' }}
                                                                </td>
                                                                <td class="text-truncate" v-else>
                                                                </td>
                                                                 <td class="text-truncate" v-if="closed.customer">
                                                                    {{ closed.customer?closed.customer.name:'' }}
                                                                </td>
                                                                <td class="text-truncate" v-if="closed.order">
                                                                    {{ closed.order.customer?closed.order.customer.name:'' }}
                                                                </td>
                                                                <td class="text-truncate" v-else>
                                                                </td>
                                                                <td class="text-truncate" v-if="closed.order">{{
                                                                        closed.order? closed.order.order_number:''
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate" v-else>
                                                                </td>
                                                                <td class="text-truncate">{{
                                                                        closed?closed.tracking_number:''
                                                                    }}
                                                                </td>
                                                                <td class="text-truncate">{{ closed?closed.priority:'' }}</td>
                                                                <td class="text-truncate">{{ closed?closed.status:'' }}</td>
                                                                <td class="text-right py-0 my-0 truncate custom-padding-right">

                                                                                      <div class="dropdown">
                                                                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                                                                            </span>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a  :href="route('cases.show',closed.id)" class="dropdown-item"><i class="bx bx-show mr-1"></i>Show</a>
                                                                            <a class="dropdown-item" v-on:click="confirmDelete(closed.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
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
                                        <div class="row pt-1 pl-3" v-else>
                                            <p>You do not have any open cases yet!</p>
                                        </div>
                                        <div class="col-12 mr-5">
                                            <pagination :links="closedCases.links" class="float-right"></pagination>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                               @deleteitem="deleteItem"></ConfirmatiomModal>
        </div>
        <div class="modal fade text-left"
                 id="addCustomer" tabindex="-1"
                 role="dialog"
                 aria-labelledby="myModalLabel33"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <h4 class="modal-title font-weight-bold heading"
                            id="myModalLabel33">
                            Add Customer </h4>
                        <button type="button"
                                class="close close12"
                                data-dismiss="modal"
                                aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                        <h6 class="text-muted" style="margin-left: 176px;">Add Potential Customer</h6>
                        <form @submit.prevent="submit" class="form form-horizontal">
                            <div class="modal-body">
                                <label>	Name *</label>
                                <input id="name" v-model="form.name"
                                        class="form-control"
                                            name="name"
                                            type="text">
                                <ErrorComponent input="name"></ErrorComponent>
                                <br>
                                <label>Email *</label>
                                <input id="email" v-model="form.email"
                                class="form-control"
                                name="email"
                                type="text">
                                <ErrorComponent input="email"></ErrorComponent>
                                <br>
                                <label>Phone *</label>
                                <input id="phone" v-model="form.phone"
                                       class="form-control"
                                       name="phone"
                                       type="text">
                                <ErrorComponent input="phone"></ErrorComponent>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Address 1 *</label>
                                        <input name="text" v-model="form.address_1" type="text" class="form-control">
                                        <ErrorComponent input="address_1"></ErrorComponent>
                                        <br>


                                    </div>
                                    <div class="col-6">
                                        <label>Address 2 *</label>
                                        <input id="address_2" v-model="form.address_2"
                                       class="form-control"
                                       name="address_2"
                                       type="text">
                                        <ErrorComponent input="address_2"></ErrorComponent>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label>House Number *</label>
                                        <input name="text" v-model="form.house_number" type="text" class="form-control">
                                        <ErrorComponent input="house_number"></ErrorComponent>
                                        <br>
                                    </div>
                                    <div class="col-6">
                                        <label>City *</label>
                                        <input id="city" v-model="form.city"
                                       class="form-control"
                                       name="city"
                                       type="text">
                                        <ErrorComponent input="city"></ErrorComponent>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Post Code *</label>
                                        <input name="text" v-model="form.postcode" type="postcode" class="form-control">
                                        <ErrorComponent input="postcode"></ErrorComponent>
                                        <br>
                                    </div>
                                    <div class="col-6">
                                        <label>Country  *</label>
                                        <input id="country" v-model="form.country"
                                       class="form-control"
                                       name="country"
                                       type="text">
                                        <ErrorComponent input="country"></ErrorComponent>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Source*</label>
                                            <select class="form-select" id="source"
                                                    @change="otherSource"
                                                    name="source"
                                                    v-model="form.source">
                                                <option value="" disabled></option>
                                                <option v-for="source in sources" :value="source.value">{{ source.value }}</option>
                                            </select>
                                            <ErrorComponent input="source"></ErrorComponent>
                                        <br>
                                    </div>
                                    <div class="col-6">
                                        <label>Priority *</label>
                                            <select class="form-select" id="priority"
                                                    name="priority"
                                                    v-model="form.priority">
                                                <option value="" disabled></option>
                                                <option v-for="priority in priorities" :value="priority.value">{{ priority.value }}</option>
                                            </select>
                                            <ErrorComponent input="priority"></ErrorComponent>
                                        <br>
                                    </div>
                                </div>
                                <label> Case Status *</label>
                                <select class="form-select" id="priority"
                                        name="priority"
                                        v-model="form.case_status">
                                    <option value="" disabled></option>
                                    <option v-for="case_status in case_statuses" :value="case_status.value">{{ case_status.value }}</option>
                                </select>
                                <ErrorComponent input="case_status"></ErrorComponent>
                                <br>
                                <label>Customer Note *</label>
                                <textarea id="customer_note" v-model="form.customer_note"
                                class="form-control"
                                name="customer_note"
                                type="text"></textarea>
                                <ErrorComponent input="customer_note"></ErrorComponent>
                                <br>
                                 <label>Is Potential Customer *</label><br>
                               <input type="checkbox"  :value="1" v-model="form.is_potential_customer">
                                <br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" id="" data-dismiss="modal">
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
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button"
import {useForm} from '@inertiajs/inertia-vue3';
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import ErrorComponent from '../../components/ErrorComponent';

export default {

    name: "index",
    props: ['openCases', 'closedCases', 'inprogressCases', 'sources', 'priorities','case_types','case_statuses','params'],

    components: {
        Button,
        AdminLayout,
        Pagination,
        ErrorComponent,
        ConfirmatiomModal,
    },
    setup() {
        const form = useForm({
            name:'',
            email:'',
            phone:'',
            address_1:'',
            address_2:'',
            house_number:'',
            city:'',
            postcode:'',
            country:'',
            is_potential_customer:'',
            source:'',
            priority:'',
            case_status:'',
            customer_note:''

        });
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
            sweetAlert: false,
            itemId: '',
            searchItem: false
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Cases"
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
            this.form.post(route('new.customer.case.store'), {
                onSuccess:() => $('#addCustomer').modal('hide'),
            });
        },
         addCustomer() {
            $('#addCustomer').modal('show');
            this.form = this.$inertia.form({
                name:'',
                email:'',
                phone:'',
                address_1:'',
                address_2:'',
                house_number:'',
                is_potential_customer:'',
                city:'',
                postcode:'',
                country:'',
                source:'',
                priority:'',
                case_status:'',
                customer_note:''
            });
        },
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            this.sweetAlert = false
            this.$inertia.delete(`/erp/cases/${this.itemId}`)
        },
        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
        },
        resetQuery() {
            this.query = {}
            this.loadData()
        },
        stopPropagation(e) {
            e.stopPropagation();
        },
        search() {
            this.searchItem = true;
            this.loadData()
        },
    }
}
</script>

<style scoped>
.openCases {
    margin-right: 30px;
}

.nav-link {
    border-bottom: 1px solid #dee2e6 !important;
    padding: 20px;
}
.close12{
    margin-left: 457px;
}
.nav.nav-tabs .nav-item {
    padding-bottom: 0 !important;
}
.modal-body{
    height: 415px;
   /* // overflow: scrol */
}
.nav-item {
    padding-bottom: 10px !important;
}

.nav.nav-tabs .nav-item, .nav.nav-pills .nav-item {
    margin-right: 0 !important;
}

.nav.nav-tabs .nav-item .nav-link, .nav.nav-pills .nav-item .nav-link {
    border-radius: 0 !important;
}

.nav.nav-tabs .nav-item .nav-link.active, .nav.nav-pills .nav-item .nav-link.active {
    box-shadow: none;
    border-bottom: 0 !important;
    border-bottom: 1px solid #dee2e6 !important;
    /* border-top: 1px solid #dee2e6 !important; */
    border-right: 1px solid #dee2e6 !important;
    /* border-left: 1px solid #dee2e6 !important; */
}
.heading{
    margin-left: 186px;
    margin-top: 36px;
    margin-bottom: -26px;
}

.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    background-color: #FFFFFF !important;
    color: black !important;
    font-weight: 900;
}

.tabbable {
    background-color: #F2F4F4;
}
</style>
