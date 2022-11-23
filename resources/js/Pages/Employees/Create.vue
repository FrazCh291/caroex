<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <h4 class="card-title" v-if="employees">Edit Employee</h4>
                                <h4 class="card-title" v-else>Add Employee</h4>
                                <div
                                    class="header mt-1"
                                    v-if="Object.keys(errors).length > 0"
                                ></div>
                            </div>
                            <div class="px-2 mb-1">
                                <hr class="line"/>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form
                                        @submit.prevent="submit"
                                        class="form form-horizontal"
                                        enctype="multipart/form-data"
                                    >
                                        <div class="form-body">
                                             <h4 class="card-title mb-1">Personal Information</h4>
                                            <div class="row form-group pt-1 pb-0 mb-0">
                                                
                                                <div class="col-md-3">
                                                    <label>Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="name"
                                                        v-model="form.name"
                                                        class="form-control"
                                                        name="name"
                                                    />
                                                    <ErrorComponent input="name"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-1 pb-0 mb-0" v-if="employees">
                                                <div class="col-md-3">
                                                    <label>Employee # </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="number"
                                                        id="employee_id"
                                                        v-model="form.employee_id"
                                                        class="form-control"
                                                        name="employee_id"
                                                       
                                                    />
                                                    <ErrorComponent input="employee_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Email * </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="email"
                                                        id="email"
                                                        v-model="form.email"
                                                        class="form-control"
                                                        name="email"
                                                    />
                                                    <ErrorComponent input="email"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>phone </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="phone"
                                                        v-model="form.phone"
                                                        class="form-control"
                                                        name="phone"
                                                    />
                                                    <ErrorComponent input="phone"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>DOB</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="date"
                                                        id="date_of_birth"
                                                        v-model="form.date_of_birth"
                                                        class="form-control"
                                                        name="date_of_birth"
                                                    />
                                                    <ErrorComponent
                                                        input="date_of_birth"
                                                    ></ErrorComponent>
                                                </div>
                                            </div>
                                              <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>CNIC </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="cnic"
                                                        v-model="form.cnic"
                                                        class="form-control"
                                                        name="cnic"
                                                    />
                                                    <ErrorComponent input="cnic"></ErrorComponent>
                                                </div>
                                            </div>
                                                  <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>GitHub</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="github_account"
                                                        v-model="form.github_account"
                                                        class="form-control"
                                                        name="github_account"
                                                    />
                                                    <ErrorComponent
                                                        input="github_account"
                                                    ></ErrorComponent>
                                                </div>
                                            </div>
                                              <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>LinkedIn</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="linkedin_account"
                                                        v-model="form.linkedin_account"
                                                        class="form-control"
                                                        name="linkedin_account"
                                                    />
                                                    <ErrorComponent
                                                        input="linkedin_account"
                                                    ></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Facebook</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="fb_account"
                                                        v-model="form.fb_account"
                                                        class="form-control"
                                                        name="fb_account"
                                                    />
                                                    <ErrorComponent input="fb_account"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Profile Picture</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="file"
                                                        name="image-upload"
                                                        class="form-control"
                                                        id="image-upload"
                                                        @change="onFileChange('image')"
                                                    />
                                                    <ErrorComponent input="file"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>CNIC PICTURE 1</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="file"
                                                        name="image_cnic-upload"
                                                        class="form-control"
                                                        id="image_cnic-upload"
                                                        @change="onFileChange('image_cnic')"
                                                    />
                                                    <ErrorComponent input="file"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>CNIC PICTURE 2</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="file"
                                                        name="image_cnic-upload"
                                                        class="form-control"
                                                        id="image_cnic_1-upload"
                                                        @change="onFileChange('image_cnic_1')"
                                                    />
                                                    <ErrorComponent input="file"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="px-0 pb-1">
                                              <hr class="line"/>
                                             </div>
                                             <h4 class="card-title  mb-1">Address Information</h4>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Address 1 * </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="address_1"
                                                        v-model="form.address_1"
                                                        class="form-control"
                                                        name="address_1"
                                                       
                                                    />
                                                    <ErrorComponent input="address_1"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Address 2 </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="address_2"
                                                        v-model="form.address_2"
                                                        class="form-control"
                                                        name="address_2"
                                                    />
                                                    <ErrorComponent input="address_2"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>City</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="city"
                                                        v-model="form.city"
                                                        class="form-control"
                                                        name="city"
                                                    />
                                                    <ErrorComponent input="city"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>County</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="county"
                                                        v-model="form.county"
                                                        class="form-control"
                                                        name="county"
                                                    />
                                                    <ErrorComponent input="county"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Post Code</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="postcode"
                                                        v-model="form.postcode"
                                                        class="form-control"
                                                        name="postcode"
                                                    />
                                                    <ErrorComponent input="postcode"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Country</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="country"
                                                        v-model="form.country"
                                                        class="form-control"
                                                        name="country"
                                                    />
                                                    <ErrorComponent input="country"></ErrorComponent>
                                                </div>
                                            </div>
                                              <div class="px-0 pb-1">
                                              <hr class="line"/>
                                             </div>
                                             <h4 class="card-title  mb-1">Department Information</h4>
                                               <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Name</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="department"
                                                        v-model="form.department"
                                                        class="form-control"
                                                        name="department"
                                                    />
                                                    <ErrorComponent input="department"></ErrorComponent>
                                                </div>
                                            </div>
                                               <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Designation </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="designation"
                                                        v-model="form.designation"
                                                        class="form-control"
                                                        name="designation"
                                                    />
                                                    <ErrorComponent input="designation"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Start Date </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="date"
                                                        id="starting_date"
                                                        v-model="form.starting_date"
                                                        class="form-control"
                                                        name="starting_date"
                                                    />
                                                    <ErrorComponent input="starting_date"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="px-0 pb-1">
                                              <hr class="line"/>
                                             </div>
                                             <h4 class="card-title  mb-1">Bank Account Information</h4>
                                             <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Account Title </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="account_title"
                                                        v-model="form.account_title"
                                                        class="form-control"
                                                        name="account_title"
                                                    />
                                                    <ErrorComponent input="account_title"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Bank Name </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="bank_name"
                                                        v-model="form.bank_name"
                                                        class="form-control"
                                                        name="bank_name"
                                                    />
                                                    <ErrorComponent input="bank_name"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Account No </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="account_no"
                                                        v-model="form.account_no"
                                                        class="form-control"
                                                        name="account_no"
                                                    />
                                                    <ErrorComponent input="account_no"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="px-0 pb-1">
                                              <hr class="line"/>
                                             </div>
                                              <h4 class="card-title  mb-1">Salary Information</h4>
                                               <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Total Salary </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="total_salary"
                                                        v-model="form.total_salary"
                                                        class="form-control"
                                                        name="total_salary"
                                                    />
                                                    <ErrorComponent input="total_salary"></ErrorComponent>
                                                </div>
                                            </div>
                                             <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Total Working Days </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input
                                                        type="text"
                                                        id="total_working_days"
                                                        v-model="form.total_working_days"
                                                        class="form-control"
                                                        name="total_working_days"
                                                    />
                                                    <ErrorComponent input="total_working_days"></ErrorComponent>
                                                </div>
                                            </div>
                                               <div class="px-0 pb-1">
                                              <hr class="line"/>
                                             </div> 
                                            <div class="row form-group">
                                                <div class="col-md-3 col-sm-6">
                                                    <label> Status</label>
                                                </div>
                                                <div class="col-md-6 col-sm-12 form-group">
                                                    <div
                                                        class="custom-control custom-switch custom-switch-glow custom-control-inline  mb-1">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            :checked="form.is_status"
                                                            v-model="form.is_status"
                                                            id="customSwitch11" v-if="form.is_status ==  1"
                                                        />
                                                         <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            :checked="form.is_status"
                                                            v-model="form.is_status"
                                                            id="customSwitch11" v-else />
                                                             <label class="custom-control-label" for="customSwitch11" :checked="form.is_status">
                                                            <span class="switch-icon-left"><i
                                                                class="bx bx-check"></i></span>
                                                        <span class="switch-icon-right"><i class="bx bx-check"></i></span>
                                                    </label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link
                                                    :href="route('employees.index')"
                                                    type="button"
                                                    class="btn btn-light-secondary mr-1 mb-1"
                                                >
                                                    Back
                                                </inertia-link>
                                            </div>
                                        </div>
                                    </form>
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
import AdminLayout from "../../Layouts/AdminLayout.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import ErrorComponent from "../../components/ErrorComponent.vue";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal.vue";
import JetInputError from "./../../Jetstream/InputError";

export default {
    name: "Create",
    props: ["errors", "employees"],
    components: {
        AdminLayout,
        ErrorComponent,
        ConfirmatiomModal,
        JetInputError,
    },
    setup() {
        const form = useForm({
            name: "",
            city: "",
            cnic: "",
            town: "",
            phone: "",
            image: "",
            email: "",
            county: "",
            country: "",
            postcode: "",
            address_1: "",
            address_2: "",
            bank_name: "",
            is_status: "",
            designation: "",
            department: "",
            image_cnic: "",
            image_cnic_1: "",
            fb_account: "",
            employee_id: "",
            starting_date:"",
            account_no: "",
            total_salary: "",
            account_title: "",
            date_of_birth: "",
            github_account: "",
            linkedin_account: "",
            total_working_days: "",
        });
        return {form};
    },
    data() {
        return {};
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Employees";
        if (this.employees) {
             this.form.is_status = this.employees
                ? this.employees.is_status
                : "";
            this.form.city = this.employees.addresses[0]
                ? this.employees.addresses[0].city
                : "";
            this.form.county = this.employees.addresses[0]
                ? this.employees.addresses[0].county
                : "";
            this.form.country = this.employees.addresses[0]
                ? this.employees.addresses[0].country
                : "";
            this.form.postcode = this.employees.addresses[0]
                ? this.employees.addresses[0].postcode
                : "";
            this.form.address_2 = this.employees.addresses[0]
                ? this.employees.addresses[0].address_2
                : "";
            this.form.address_1 = this.employees.addresses[0]
                ? this.employees.addresses[0].address_1
                : "";
            this.form.town = this.employees.addresses[0]
                ? this.employees.addresses[0].town
                : "";
            this.form.account_no = this.employees.account
                ? this.employees.account.account_no : '';
            this.form.date_of_birth = this.employees.account
                ? this.employees.account.date_of_birth : "";
            this.form.account_title = this.employees.account
                ? this.employees.account.account_title : "";
            this.form.bank_name = this.employees.account
                ? this.employees.account.bank_name : "";
            this.form.total_salary = this.employees
                ? this.employees.total_salary
                : "";
            this.form.total_working_days = this.employees
                ? this.employees.total_working_days
                : "";
            this.form.image = this.employees
                ? this.employees.image
                : "";
            this.form.image_cnic = this.employees
                ? this.employees.image_cnic
                : "";
            this.form.image_cnic_1 = this.employees
                ? this.employees.image_cnic_1
                : "";
        }

        if (this.employees) {
            this.update = true;
            let data = this.employees;
            Object.assign(data, {
                _method: "PUT",
                is_status:this.form.is_status,
                account_no: this.form.account_no,
                account_title: this.form.account_title,
                bank_name: this.form.bank_name,
                date_of_birth: this.form.date_of_birth,
                address_1: this.form.address_1,
                address_2: this.form.address_2,
                county: this.form.county,
                country: this.form.country,
                city: this.form.city,
                city: this.form.total_salary,
                city: this.form.total_working_days,
                postcode: this.form.postcode
            });
            this.form = this.$inertia.form(data);
        }
    },
    methods: {
        onFileChange(data) {
            var reader = new FileReader();
            (reader.onload = function () {
                if (data == "image") {
                    var output = document.getElementById("image");
                }
                if (data == "image_cnic") {
                    var output = document.getElementById("image_cnic");
                }
                if (data == "image_cnic_1") {
                    var output = document.getElementById("image_cnic_1");
                }

                output.src = reader.result;
            }),
                reader.readAsDataURL(event.target.files[0]);
        },
        submit() {
            this.$page.props.errors = {};
            let files = {};
            if (document.getElementById("image-upload").files.length) {
                this.form.image = document.getElementById("image-upload").files[0];
            }
            if (document.getElementById("image_cnic-upload").files.length) {
                this.form.image_cnic =
                    document.getElementById("image_cnic-upload").files[0];
            }
             if (document.getElementById("image_cnic_1-upload").files.length) {
                 this.form.image_cnic_1 =
                    document.getElementById("image_cnic_1-upload").files[0];
            }
            if (this.update) {
                this.form.post(route("employees.update", this.employees.id));
            } else {
                this.form.post(route("employees.store"));
            }
        },

        Clicked() {
            this.sweetAlert = false;
        },
        deleteItem() {
            this.sweetAlert = false;
            this.$inertia.delete(`/erp/employees/${this.itemId}`);
        },
        confirmDeletedoc(id) {
            this.sweetAlert = true;
            this.itemId = id;
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

.custom-padding {
    padding: 7px;
}
</style>
