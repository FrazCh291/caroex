<template>
    <admin-layout>
        <div class="row">
            <div class="col-md-10 col-lg-10 col-sm-10 px-1 pb-0 mb-0">
                <div class="col form-group p-0">
                    <h4>HR / Payrolls / {{ payrollMonth }}</h4>
                </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2 px-0">
                <div class="col form-group p-0">
                    <div class="btn-group dropright float-right mr-1">
                        <div class="dropdown">
                            <span
                                class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                                role="menu"
                            >
                            </span>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a  class="dropdown-item"  data-toggle="modal"  data-target="#additionPayrollModel" >
                                    <i class="bx bx-plus mr-1"></i>ADD</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section id="basic-horizontal-layouts"></section>
            <section id="basic-horizontal-layouts">
                <div class="card-content">
                    <div>
                        <div class="row mt-0 ml-1">
                            <div
                                class="modal fade"
                                id="addEmployeeModal"
                                tabindex="-1"
                                role="dialog"
                                aria-labelledby="exampleModalLabel"
                                aria-hidden="true"
                            >
                                <div
                                    class="modal-dialog modal-lg"
                                    role="document"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="row pb-3" id="table-hover-row">
            <div class="col-12">
                <div class="card-one py-0 my-0 bg-white">
                    <div class="card-content">
                        <div data-repeater-list="group-a">
                            <div>
                                <div class="top d-flex flex-wrap">
                                    <div class="action-filters flex-grow-1">
                                        <div
                                            id="DataTables_Table_0_filter"
                                            class="dataTables_filter"
                                        >
                                            <div
                                                class="input-group form-group d-flex position-relative mt-1 px-2 pr-md-0"
                                            >
                                                <input
                                                    type="text"
                                                    class="form-control border-light-gray btn-height"
                                                    placeholder="Search..."
                                                    aria-label="Search"
                                                    aria-describedby="basic-addon2"
                                                    v-model="query.query"
                                                    @change="search"
                                                />
                                                <div class="input-group-append">
                                                    <button class="input-group-text search-btn" @change="search" >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-search feather-16 pb-0 mb-0 mt-0" >
                                                            <circle cx="11" cy="11"  r="8" ></circle>
                                                            <line x1="21" y1="21" x2="16.65" y2="16.65" ></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="actions action-btns d-flex align-items-center flex flex-wrap filter-container pl-1" >
                                        <div class="dropdown w-100 pr-1 sort-dropdown2" >
                                            <button class="btn border dropdown-toggle w-100"
                                                type="button"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false" > Sort  </button>
                                            <div class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown"  aria-labelledby="" @click="stopPropagation" >
                                                <div class="col-12 pl-2 pt-1">
                                                    <div  class="d-inline-flex w-100"  >
                                                        <h6 class="py-0 my-0">
                                                            Sort
                                                        </h6>
                                                        <span  class="primary pl-20 ml-2 pointer"
                                                            @click="resetSort"
                                                            >Reset</span>
                                                    </div>
                                                    <div class="text-base pt-1">
                                                        <p class="tag">
                                                            <input type="checkbox" name="name"
                                                                id="name"
                                                                v-model=" query.employee_id " v-on:click="check_one()" />
                                                            <label class="pl-1 py-0 my-0" for="name" >Name</label>
                                                        </p>
                                                        <!-- <p class="tag">
                                                            <input type="checkbox" name="total_working_days" id="total_working_days"  v-model=" query.total_working_days " v-on:click="check_one()" />
                                                            <label class="pl-1 py-0 my-0" for="total_working_days" >Work Days</label>
                                                        </p> -->
                                                        <p class="tag">
                                                            <input type="checkbox" name="total_salary" id="total_salary" v-model="query.employee_salary" v-on:click="check_one()"
                                                            />
                                                            <label class="pl-1 py-0 my-0"  for="total_salary" >Salary</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="total_addition" id="total_addition" v-model="query.total_addition" v-on:click="check_one()"/>
                                                            <label class="pl-1 py-0 my-0" for="total_addition" >ADDITIONS</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox"  name="total_detuction" id="total_detuction"
                                                                v-model=" query.total_detuction " v-on:click="check_one()"/>
                                                            <label  class="pl-1 py-0 my-0" for="total_detuction" >DEDUCTIONS</label >
                                                        </p>
                                                        <p class="tag">
                                                            <input
                                                                type="checkbox"
                                                                name="tax"
                                                                id="tax"
                                                                v-model="query.tax" v-on:click="check_one()"/>
                                                            <label class="pl-1 py-0 my-0" for="tax">TAX</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox" name="status"  id="status" v-model="query.status" v-on:click="check_one()"/>
                                                            <label class="pl-1 py-0 my-0" for="status">Status</label>
                                                        </p>
                                                        <p class="tag">
                                                            <input type="checkbox"
                                                                name="net_total"
                                                                id="net_total" v-model="query.net_total" v-on:click="check_one()"/>
                                                            <label class="pl-1 py-0 my-0" for="net_total">TOTALSALARY</label>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider py-0 my-0"></div>
                                                <div class="col-12 pl-2 d-inline-flex">
                                                    <p class="pt-1">
                                                        <button type="button" id="asce" @click="sort('asc')" class="btn btn-sm btn-primary font-small font-weight-normal stock-order">
                                                            Asc
                                                        </button>
                                                    </p>
                                                    <p class="pt-1 pl-3">
                                                        <button type="button" id="desc" @click="sort('desc')" class="btn btn-sm btn-light-secondary font-small font-weight-normal stock-order">
                                                            Desc
                                                        </button>
                                                    </p>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="">Name</th>
                                        <th class="text-center text-truncate">
                                            Work Days
                                        </th>
                                        <th class="text-right text-truncate">
                                            Salary
                                        </th>
                                        <th class="text-right text-truncate">
                                            Additions
                                        </th>
                                        <th class="text-right text-truncate">
                                            Deductions
                                        </th>
                                        <th class="text-right text-truncate">
                                            Tax
                                        </th>
                                        <th class="text-right text-truncate">
                                            Status
                                        </th>
                                        <th class="text-right text-truncate">
                                            Total Salary
                                        </th>
                                        <th class=""></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="( salary, index ) in employeeSalary.data" :key="salary.id" >
                                        <td>{{ salary.employee.name }}</td>
                                        <td class="text-center text-truncate">
                                            {{ salary.payroll.working_days }}
                                        </td>
                                        <td class="text-right text-truncate">
                                            {{ salary.employee.total_salary }}
                                        </td>
                                        <td
                                            class="text-right text-truncate"
                                            id="tooltip-target-1"
                                        >
                                            {{ salary.total_addition }}
                                        </td>
                                        <td class="text-right text-truncate">
                                            {{ salary.total_detuction }}
                                        </td>
                                        <td class="text-right text-truncate">
                                            {{ salary.tax }}
                                        </td>
                                        <td class="text-right text-truncate" v-if="salary.status == 0" >
                                            Un Paid
                                        </td>
                                        <td class="text-right text-truncate" v-else-if="salary.status == 'partially_paid'">
                                            Partially Paid
                                        </td>
                                        <td class="text-right text-truncate"  v-else-if=" salary.status == 'un_paid'">
                                            Un Paid
                                        </td>
                                        <td class="text-right text-truncate" v-else >
                                            Paid
                                        </td>
                                        <td class="text-right text-truncate">
                                            {{ salary.net_total }}
                                        </td>
                                        <td class="text-right py-0 my-0 custom-padding-right">
                                            <div class="dropdown">
                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                    role="menu"> </span>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"  data-toggle="modal"
                                                        @click="viewPayroll(index,salary.id)"
                                                        data-target="#viewModel" ><i class="bx bx-show mr-1"></i>View</a>
                                                    <a class="dropdown-item" @click="salaryId(index,salary.id)" data-target="#additionModel"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                                                    <a class="dropdown-item"
                                                        data-toggle="modal"
                                                        data-whatever="@mdo"
                                                        v-on:click="confirmDelete(salary.id)"><i class="bx bx-trash mr-1"></i>Delete</a >
                                                </div>
                                            </div>
                                            <section id="basic-horizontal-layouts">
                                                <div class="card-content">
                                                    <div class="row mt-0 ml-1">
                                                        <div class="modal fade" id="viewModel"
                                                            tabindex="-1"
                                                            role="dialog"
                                                            aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div>
                                                                    <button type="button" class="close float-right mr-1 mt-1"  data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    </div>
                                                                    <h5 class="font-weight-bold mt-2 text-center">
                                                                        View Payroll Item
                                                                    </h5>
                                                                    <p class="text-center">
                                                                        View
                                                                        Payroll
                                                                        Item
                                                                    </p>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="d-flex mt-1 font-weight-bold col-6">
                                                                                Name
                                                                            </div>
                                                                            <div class="d-flex mt-1 font-weight-bold col-6">
                                                                                Working
                                                                                Days
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="d-flex mt-1 font-weight-light col-6">
                                                                                {{employeeSalary.data[modalIndex].employee.name}}
                                                                            </div>
                                                                            <div class="d-flex mt-1 font-weight-light col-6" >
                                                                                {{employeeSalary.data[modalIndex].payroll.working_days}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="d-flex mt-1 font-weight-bold col-6">
                                                                                Currency
                                                                            </div>
                                                                            <div class="d-flex mt-1 font-weight-bold col-6">
                                                                                Salary
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="d-flex mt-1 font-weight-light col-6">
                                                                                {{employeeSalary.data[modalIndex].currency}}
                                                                            </div>
                                                                            <div class="d-flex mt-1 font-weight-light col-6">
                                                                                {{employeeSalary.data[modalIndex].net_total}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="d-flex mt-1 font-weight-bold col-6">
                                                                                Status
                                                                            </div>
                                                                            <div class="d-flex mt-1 font-weight-bold col-6">
                                                                                Date
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div class="d-flex mt-1 font-weight-light col-6" v-if=" employeeSalary.data[modalIndex].status ==0">
                                                                                Unpaid
                                                                            </div>
                                                                            <div class="d-flex mt-1 font-weight-light col-6" v-else>
                                                                                Paid
                                                                            </div>
                                                                        </div>

                                                                        <h5 class="d-flex font-weight-bold mt-3">
                                                                            Additions/Deductions
                                                                        </h5>
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-left">
                                                                                        Description
                                                                                    </th>
                                                                                    <th class="text-center" >
                                                                                        Value
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(adjustment, index) in employeeSalary.data[modalIndex].adjustments">
                                                                                    <th class="text-left">
                                                                                        {{adjustment.reason}}
                                                                                    </th>
                                                                                    <td class="text-center">
                                                                                        {{adjustment.amount}}
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
                                            </section>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <section id="basic-horizontal-layouts">
                <div class="card-content">
                    <div>
                        <div class="row mt-0 ml-1">
                            <div class="modal fade" id="additionModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div>
                                            <button type="button" class="close float-right mr-1 mt-1" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <h4 class="font-weight-bold mt-1 text-center">
                                            Edit Payroll Item
                                        </h4>
                                        <p class="text-center">
                                            Modify a payroll item for this
                                            month.
                                        </p>
                                        <div></div>
                                        <li v-for="error in errors" class="error-message" >
                                            {{ error }}
                                        </li>
                                        <form @submit.prevent="submit" class="form form-horizontal">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-3">
                                                    <div class="form-group ml-5">
                                                        <label  for="message" class="col-form-label">Name *</label>
                                                        <input type="text" id="" class="form-control" name="" :value="employeeSalary.data[modalIndex].employee.name" readonly/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-3">
                                                    <div class="form-group mr-5">
                                                        <label for="message" class="col-form-label">Working Days*</label>
                                                        <input type="text" id="" class="form-control"
                                                            name="" :value="employeeSalary.data[modalIndex].payroll.working_days" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-3">
                                                    <div class="form-group ml-5">
                                                        <label for="message" class="col-form-label">Currency *</label>
                                                        <select v-model="form1.currency" class="form-select pl-0">
                                                            <option value=""></option>
                                                            <option v-for="currency in currencys" :value="currency.slug">
                                                                {{currency.value}}
                                                            </option>
                                                        </select>
                                                        <ErrorComponent input="currency"></ErrorComponent>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-3">
                                                    <div class="form-group mr-5">
                                                        <label  for="message" class="col-form-label">Salary *</label>
                                                        <input type="text" id="" class="form-control" name=""  :value=" employeeSalary.data[modalIndex].employee.total_salary"  readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-3">
                                                    <div class="form-group ml-5" >
                                                        <label for="message"  class="col-form-label">Status *</label>
                                                        <select v-model="form1.status" class="form-select pl-0">
                                                            <option value=""></option>
                                                            <option v-for="Status in salaryStatus" :value=" Status.slug" readonly>
                                                                {{Status.value}}
                                                            </option>
                                                        </select>
                                                        <ErrorComponent
                                                            input="status"
                                                        ></ErrorComponent>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-3">
                                                    <div class="form-group pr-5" >
                                                        <label for="message" class="col-form-label" >Date *</label>
                                                        <input type="date" id=""  class="form-control"  v-model="form1.date"/>
                                                        <ErrorComponent input="date"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-10">
                                                    <h4 class="ml-3 mt-2">
                                                        Additions/Deductions
                                                    </h4>
                                                </div>
                                                <i class="font-large-1 bx bx-plus ml-0 mt-2" @click="addField"></i>
                                            </div>
                                            <div class="ml-3">
                                                <table class="table">
                                                    <form action=""></form>
                                                    <thead class="border-top-0">
                                                        <tr>
                                                            <th class="p-0" scope="col">
                                                                Reason *
                                                            </th>
                                                            <th class="p-0 text-center" scope="col">Value *</th>
                                                            <th scope="col"  class="border-bottom-0"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(input, k) in inputs" :key="k" >
                                                            <td class="p-0 w-60" >
                                                                <!-- <input  type="text"  id=""  class="form-control"  v-model="inputs[k].reason"/> -->
                                                                <select v-model="inputs[k].reason" class="form-select pl-0" @change="otherReason">
                                                                    <option value=""></option>
                                                                    <option v-for="reason in reasons" :value="reason.slug">
                                                                        {{reason.value}}
                                                                    </option>
                                                                </select>
                                                                <ErrorComponent  input="reason"></ErrorComponent>
                                                            </td>
                                                            <td class="text-center w-60 pr-0">
                                                                <input type="number"  id="" class="form-control" v-model=" inputs[k].value"/>
                                                            </td>
                                                            <td>
                                                                <i class="bx bx-trash mr-1 ml-1"
                                                                    @click="remove(k)"
                                                                    v-show="k || (!k && inputs.length >1)"></i>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-0 w-60" >
                                                               <div v-if="anotherReason" class="form-group pt-1 my-0">
                                                            <label for="order-number">Other's</label>
                                                            <input id="source_other" v-model="form1.other_reason"  class="form-control" name="source_other" type="text"></div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 d-flex justify-content-center mt-3 mb-1">
                                                <button type="submit" class="btn btn-primary">
                                                    <span class="btnNext">Save</span>
                                                </button>
                                                <button type="button" class="btn btn-light ml-1" data-dismiss="modal" aria-label="Close">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="basic-horizontal-layouts">
                <div class="card-content">
                    <div>
                        <div class="row mt-0 ml-1">
                            <div
                                class="modal fade"
                                id="additionPayrollModel"
                                tabindex="-1"
                                role="dialog"
                                aria-labelledby="exampleModalLabel"
                                aria-hidden="true"
                            >
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div>
                                            <button
                                                type="button"
                                                class="close float-right mr-1 mt-1"
                                                data-dismiss="modal"
                                                aria-label="Close"
                                            >
                                                <span aria-hidden="true"
                                                    >&times;</span
                                                >
                                            </button>
                                        </div>
                                        <h4
                                            class="font-weight-bold mt-1 text-center"
                                        >
                                            Add Payroll Item
                                        </h4>
                                        <p class="text-center">
                                            Create a payroll item for this
                                            month.
                                        </p>
                                        <div></div>
                                        <li
                                            v-for="errors in errorses"
                                            class="error-message"
                                        >
                                            {{ errors }}
                                        </li>
                                        <form
                                            @submit.prevent="submitPayrollItem"
                                            class="form form-horizontal"
                                        >
                                            <div class="row">
                                                <div class="col-md-6 col-sm-3">
                                                    <div
                                                        class="form-group ml-5"
                                                    >
                                                        <label
                                                            for="message"
                                                            class="col-form-label"
                                                            >Name *</label
                                                        >
                                                        <select
                                                            v-model="form.id"
                                                            class="form-select pl-0"
                                                            @change="
                                                                getEmployeeDetail()
                                                            "
                                                        >
                                                            <option
                                                                value=""
                                                            ></option>
                                                            <option
                                                                v-for="employee in employees"
                                                                :value="
                                                                    employee.id
                                                                "
                                                            >
                                                                {{
                                                                    employee.name
                                                                }}
                                                            </option>
                                                        </select>
                                                        <ErrorComponent
                                                            input="name"
                                                        ></ErrorComponent>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-3">
                                                    <div
                                                        class="form-group mr-5"
                                                    >
                                                        <label
                                                            for="message"
                                                            class="col-form-label"
                                                            >Working Days
                                                            *</label
                                                        >
                                                        <input
                                                            type="text"
                                                            id=""
                                                            class="form-control"
                                                            name=""
                                                            v-model="
                                                                form.working_days
                                                            "
                                                            readonly
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-3">
                                                    <div
                                                        class="form-group ml-5"
                                                    >
                                                        <label
                                                            for="message"
                                                            class="col-form-label"
                                                            >Currency *</label
                                                        >
                                                        <select
                                                            v-model="
                                                                form.currency
                                                            "
                                                            class="form-select pl-0"
                                                        >
                                                            <option
                                                                value=""
                                                            ></option>
                                                            <option
                                                                v-for="currency in currencys"
                                                                :value="
                                                                    currency.slug
                                                                "
                                                            >
                                                                {{
                                                                    currency.value
                                                                }}
                                                            </option>
                                                        </select>
                                                        <ErrorComponent
                                                            input="currency"
                                                        ></ErrorComponent>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-3">
                                                    <div
                                                        class="form-group mr-5"
                                                    >
                                                        <label
                                                            for="message"
                                                            class="col-form-label"
                                                            >Salary *</label
                                                        >
                                                        <input
                                                            type="text"
                                                            id=""
                                                            class="form-control"
                                                            name=""
                                                            v-model="
                                                                form.salary
                                                            "
                                                            readonly
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-3">
                                                    <div
                                                        class="form-group ml-5"
                                                    >
                                                        <label
                                                            for="message"
                                                            class="col-form-label"
                                                            >Status *</label
                                                        >
                                                        <select
                                                            v-model="
                                                                form.status
                                                            "
                                                            class="form-select pl-0"
                                                        >
                                                            <option
                                                                value=""
                                                            ></option>
                                                            <option
                                                                v-for="Status in salaryStatus"
                                                                :value="
                                                                    Status.slug
                                                                "
                                                            >
                                                                {{
                                                                    Status.value
                                                                }}
                                                            </option>
                                                        </select>
                                                        <ErrorComponent
                                                            input="status"
                                                        ></ErrorComponent>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-3">
                                                    <div
                                                        class="form-group pr-5"
                                                    >
                                                        <label
                                                            for="message"
                                                            class="col-form-label"
                                                            >Date *</label
                                                        >
                                                        <input
                                                            type="date"
                                                            id=""
                                                            class="form-control"
                                                            v-model="form.date"
                                                        />
                                                        <ErrorComponent
                                                            input="date"
                                                        ></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-10">
                                                    <h4 class="ml-3 mt-2">
                                                        Additions/Deductions
                                                    </h4>
                                                </div>
                                                <i
                                                    class="font-large-1 bx bx-plus ml-0 mt-2"
                                                    @click="addField"
                                                ></i>
                                            </div>
                                            <div class="ml-3">
                                                <table class="table">
                                                    <form action=""></form>
                                                    <thead class="border-top-0">
                                                        <tr>
                                                            <th
                                                                class="p-0"
                                                                scope="col"
                                                            >
                                                                Reason *
                                                            </th>
                                                            <th
                                                                class="p-0 text-center"
                                                                scope="col"
                                                            >
                                                                Value *
                                                            </th>
                                                            <th
                                                                scope="col"
                                                                class="border-bottom-0"
                                                            ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(input, k) in inputs" :key="k">
                                                            <td class="p-0 w-60" >
                                                                <!-- <input  type="text"  id=""  class="form-control"  v-model="inputs[k].reason"/> -->
                                                                <select v-model="inputs[k].reason" class="form-select pl-0" @change="otherReason">
                                                                    <option value=""></option>
                                                                    <option v-for="reason in reasons" :value="reason.slug">
                                                                        {{reason.value}}
                                                                    </option>
                                                                </select>
                                                                <ErrorComponent  input="reason"></ErrorComponent>
                                                            </td>
                                                            <td
                                                                class="text-center w-60 pr-0"
                                                            >
                                                                <input
                                                                    type="number"
                                                                    id=""
                                                                    class="form-control"
                                                                    v-model="
                                                                        inputs[
                                                                            k
                                                                        ].value
                                                                    "
                                                                />
                                                            </td>
                                                            <td>
                                                                <i
                                                                    class="bx bx-trash mr-1 ml-1"
                                                                    @click="
                                                                        remove(
                                                                            k
                                                                        )
                                                                    "
                                                                    v-show="
                                                                        k ||
                                                                        (!k &&
                                                                            inputs.length >
                                                                                1)
                                                                    "
                                                                ></i>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-0 w-60" >
                                                               <div v-if="anotherReason" class="form-group pt-1 my-0">
                                                            <label for="order-number">Other's</label>
                                                            <input id="source_other" v-model="form.other_reason"  class="form-control" name="source_other" type="text"></div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div
                                                class="col-sm-12 d-flex justify-content-center mt-3 mb-1"
                                            >
                                                <button
                                                    type="submit"
                                                    class="btn btn-primary"
                                                >
                                                    <span class="btnNext"
                                                        >Save
                                                    </span>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-light ml-1"
                                                    data-dismiss="modal"
                                                    aria-label="Close"
                                                >
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <ConfirmatiomModal
                v-if="sweetAlert"
                :sweetAlert="sweetAlert"
                @clicked="Clicked"
                @deleteitem="deleteItem"
            >
            </ConfirmatiomModal>
            <div class="col-12">
                <pagination
                    :links="employeeSalary.links"
                    class="float-right"
                ></pagination>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import moment from "moment";
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button";
import { useForm } from "@inertiajs/inertia-vue3";
import Pagination from "../../admin/Pagination";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
import { Inertia } from "@inertiajs/inertia";

export default {
    name: "Index",
    props: [
        "employeeSalary",
        "reasons",
        "employeeRecord",
        "payrollId",
        "params",
        "employees",
        "salaryStatus",
        "payrollMonth",
        "currencys",
        'reasons'
    ],
    components: {
        Button,
        AdminLayout,
        Pagination,
        ConfirmatiomModal,
    },
    setup() {
        const form = useForm({
            id: "",
            name: "",
            working_days: "",
            status: "",
            date: "",
            salary: "",
            currency: "",
            other_reason:''
        });
        const form1 = useForm({
            status: "",
            date: "",
            currency: "",
            other_reason:""
        });
        return { form };
    },
    data() {
        return {
            query: {
                query: "",
                id: false,
                name: false,
                inputs: [],
                type: null,
                enable: false,
                disable: false,
                direction: null,
            },
            form1: this.$inertia.form({
                status: "",
                date: "",
                currency: "",
            }),
            sweetAlert: false,
            itemId: "",
            searchItem: false,
            modalIndex: 0,
            errors: [],
            errorses: [],
            inputs: [
              {
                reason: "",
                value: "",
              },
            ],
            inputs1: [
              {
                reason: "",
                value: "",
              },
            ],
        };
    },

    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Show Payroll";
    },

    mounted() {
        if (this.params) {
            let params = Object.keys(this.params);
            for (let i of params) {
                Object.assign(this.query, { [i]: this.params[i] });
            }
        }
    },
    methods: {
        addField() {
            this.inputs.push({
                reason: "",
                value: "",
            });

            event.stopPropagation();  
        },
        remove(index) {
            this.inputs.splice(index, 1);
        },
        submit() {
            if (!this.form1.currency) {
                 this.errors = [];
                this.errors.push("Currency is required.");
                event.stopPropagation();
            } else if (!this.form1.status) {
                this.errors = [];
                this.errors.push("Status is required.");
                event.stopPropagation();
            } else if (!this.form1.date) {
                this.errors = [];
                this.errors.push("Date is required.");
                event.stopPropagation();
            } else if (!this.inputs[0].reason) {
                this.errors = [];
                this.errors.push("Reason is required.");
                event.stopPropagation();
            } else if (!this.inputs[0].value) {
                this.errors = [];
                this.errors.push("Value is required.");
                event.stopPropagation();
            } else {  
                Inertia.visit(route("adjustment.update", this.descriptionId), {
                    method: "put",
                    data: {
                        payrollitems: this.inputs,
                        salary: this.form1,
                        payroll_id: this.payrollId,
                        salary_id: this.descriptionId,
                    },
                });
                $("#additionModel").modal("hide");
            }
        },
        salaryId(index, descriptionId) {
            this.modalIndex = index;
            this.descriptionId = descriptionId;
            $("#additionModel").modal("show");
        },
         otherReason: function () {
            if (this.inputs[0].reason == 'other_reason') {
                this.anotherReason = true;
            } else if(this.inputs[1].reason == 'other_reason'){
            this.anotherReason = true;
            } else if(this.inputs[2].reason == 'other_reason'){
            this.anotherReason = true;
            } else if(this.inputs[3].reason == 'other_reason'){
            this.anotherReason = true;
            } else {
                this.anotherReason = false;
            }
        //   }
        },
        submitPayrollItem() {
          if (!this.form.id) {
                this.errorses = [];
                this.errorses.push("Name is required.");
                event.stopPropagation();
            } else if (!this.form.currency) {
                 this.errorses = [];
                this.errorses.push("Currency is required.");
                event.stopPropagation();
            } else if (!this.form.status) {
                this.errorses = [];
                this.errorses.push("Status is required.");
                event.stopPropagation();
            } else if (!this.form.date) {
                this.errorses = [];
                this.errorses.push("Date is required.");
                event.stopPropagation();
                } else if (!this.inputs[0].reason) {
                this.errorses = [];
                this.errorses.push("Reason is required.");
                event.stopPropagation();
            } else if (!this.inputs[0].value) {
                this.errorses = [];
                this.errorses.push("Value is required.");
                event.stopPropagation();
            } else {
            Inertia.visit(route("store.payroll.item", this.payrollId), {
                method: "post",
                data: {
                    payrollitemsstore: this.inputs,
                    employee: this.form,
                    payroll_id: this.payrollId,
                    salary_id: this.descriptionId,
                    // onSuccess: () => $("#additionPayrollModel").modal("hide"),
                },
            });
            $('#additionPayrollModel').modal('hide')
            }
        },
        getEmployeeDetail() {
            axios
                .get("/erp/search-employee-record", {
                    params: {
                        id: this.form.id,
                    },
                })
                .then((response) => {
                    this.form.working_days =
                        response.data.employeeRecord.total_working_days;
                    this.form.salary =
                        response.data.employeeRecord.total_salary;
                });
        },
        viewPayroll(index, salaryId) {
            this.modalIndex = index;
            $("#empDetailModal").modal("show");
        },
        resetQuery() {
            this.query = {};
            this.loadData();
        },
        addition(id) {
            this.form.id = id;
        },
        Clicked() {
            this.sweetAlert = false;
        },
        deleteItem() {
            this.sweetAlert = false;
            this.$inertia.delete(`/erp/salary/delete/${this.itemId}`);
        },
        confirmDelete(id) {
            this.sweetAlert = true;
            this.itemId = id;
        },
        stopPropagation(e) {
            e.stopPropagation();
        },
        resetSort(e) {
            this.query = {};
            this.query.direction = "";
            this.query.id = "";
            this.query.name = "";
            this.query.name = "";
            this.query.net_total = "";
            this.query.working_days = "";
            this.query.total_salary = "";
            this.query.total_addition = "";
            this.query.total_detuction = "";
            this.query.enable = "";
            this.query.disable = "";
            this.loadData();
        },
        resetFilter() {
            this.query = {};
            this.query.id = "";
            this.query.name = "";
            this.query.direction = "";
            this.query.enable = "";
            this.query.disable = "";
            this.loadData();
        },
         check_one: function () {
      if ((this.query.employee_id = false)) {
        this.query.employee_id = true;
        this.query.total_working_days = [];
        this.query.employee_salary = [];
        this.query.total_addition = [];
        this.query.total_detuction = [];
        this.query.tax = [];
        this.query.status = [];
        this.query.net_total = [];
      }
      if ((this.query.total_working_days = false)) {
         this.query.total_working_days = true;
        this.query.employee_id = [];
        this.query.employee_salary = [];
        this.query.total_addition = [];
        this.query.total_detuction = [];
        this.query.tax = [];
        this.query.status = [];
        this.query.net_total = [];
      }
      if ((this.query.employee_salary = false)) {
        this.query.employee_salary = true;
        this.query.total_working_days = [];
        this.query.employee_id = [];
        this.query.total_addition = [];
        this.query.total_detuction = [];
        this.query.tax = [];
        this.query.status = [];
        this.query.net_total = [];
      }
      if ((this.query.total_addition = false)) {
        this.query.total_addition = true;
        this.query.total_working_days = [];
        this.query.employee_salary = [];
        this.query.employee_id = [];
        this.query.total_detuction = [];
        this.query.tax = [];
        this.query.status = [];
        this.query.net_total = [];
      }
      if ((this.query.total_detuction = false)) {
         this.query.total_detuction = true;
        this.query.total_working_days = [];
        this.query.employee_salary = [];
        this.query.total_addition = [];
        this.query.employee_id = [];
        this.query.tax = [];
        this.query.status = [];
        this.query.net_total = [];
      }
      if ((this.query.tax = false)) {
         this.query.tax = true;
        this.query.total_working_days = [];
        this.query.employee_salary = [];
        this.query.total_addition = [];
        this.query.total_detuction = [];
        this.query.employee_id = [];
        this.query.status = [];
        this.query.net_total = [];
      }
      if ((this.query.status = false)) {
        this.query.status = true;
        this.query.total_working_days = [];
        this.query.employee_salary = [];
        this.query.total_addition = [];
        this.query.total_detuction = [];
        this.query.tax = [];
        this.query.employee_id = [];
        this.query.net_total = [];
      }
      if ((this.query.net_total = false)) {
        this.query.net_total = true;
        this.query.total_working_days = [];
        this.query.employee_salary = [];
        this.query.total_addition = [];
        this.query.total_detuction = [];
        this.query.tax = [];
        this.query.status = [];
        this.query.employee_id = [];
      }
    },
        search() {
            this.searchItem = true;
            this.query.type = this.type;
            this.loadData();
        },
        filter() {
            this.loadData();
        },
        sort(direction) {
            this.query.direction = direction;
            this.loadData();
        },
        total(data) {
            let length = data.length;
            let totalsalary =
                length * parseFloat(this.employeeSalary.net_total);
            let total = 0;
            data.forEach((element) => {
                total = total + parseFloat(element.total_price);
            });
            return total - totalCommission;
        },
        format(date) {
            return moment(String(date)).format("DD/MM/YYYY");
        },
        formatDate(created_at) {
            return moment(created_at).format("DD/MM/YYYY");
        },
        loadData() {
            let query = {};
            for (let item in this.query) {
                if (this.query[item]) {
                    Object.assign(query, { [item]: this.query[item] });
                }
            }
            this.$inertia.visit(route("payrolls.show", this.payrollId), {
                method: "get",
                data: {
                    ...query,
                },
            });
        },

        showTooltip(id) {
            if (this.id == null) {
                this.id = id;
                $("[data-toggle=" + id + "]").popover({
                    html: true,
                    content: function () {
                        return $("#popover-content-" + id).html();
                    },
                });
                $("[data-toggle=" + id + "]").popover("show");
            } else if (this.id == id) {
                $("[data-toggle=" + this.id + "]").popover("dispose");
                this.id = null;
            } else {
                $("[data-toggle=" + this.id + "]").popover("dispose");
                this.id = id;
                $("[data-toggle=" + id + "]").popover({
                    html: true,
                    content: function () {
                        return $("#popover-content-" + id).html();
                    },
                });
                $("[data-toggle=" + id + "]").popover("show");
            }
        },
        showTooltip1(id) {
            if (this.id == null) {
                this.id = id;
                $("[data-toggle=deduction" + id + "]").popover({
                    html: true,
                    content: function () {
                        return $("#popover-content-deduction" + id).html();
                    },
                });
                $("[data-toggle=deduction" + id + "]").popover("show");
            } else if (this.id == id) {
                $("[data-toggle=deduction" + this.id + "]").popover("dispose");
                this.id = null;
            } else {
                $("[data-toggle=deduction" + this.id + "]").popover("dispose");
                this.id = id;
                $("[data-toggle=deduction" + id + "]").popover({
                    html: true,
                    content: function () {
                        return $("#popover-content-deduction" + id).html();
                    },
                });
                $("[data-toggle=deduction" + id + "]").popover("show");
            }
        },
        showTooltip2(id) {
            if (this.id == null) {
                this.id = id;
                $("[data-toggle=employee" + id + "]").popover({
                    html: true,
                    content: function () {
                        return $("#popover-content-employee" + id).html();
                    },
                });
                $("[data-toggle=employee" + id + "]").popover("show");
            } else if (this.id == id) {
                $("[data-toggle=employee" + this.id + "]").popover("dispose");
                this.id = null;
            } else {
                $("[data-toggle=employee" + this.id + "]").popover("dispose");
                this.id = id;
                $("[data-toggle=employee" + id + "]").popover({
                    html: true,
                    content: function () {
                        return $("#popover-content-employee" + id).html();
                    },
                });
                $("[data-toggle=employee" + id + "]").popover("show");
            }
        },
        showTooltip3(id) {
            if (this.id == null) {
                this.id = id;
                $("[data-toggle=addition" + id + "]").popover({
                    html: true,
                    content: function () {
                        return $("#popover-content-addition" + id).html();
                    },
                });
                $("[data-toggle=addition" + id + "]").popover("show");
            } else if (this.id == id) {
                $("[data-toggle=addition" + this.id + "]").popover("dispose");
                this.id = null;
            } else {
                $("[data-toggle=addition" + this.id + "]").popover("dispose");
                this.id = id;
                $("[data-toggle=addition" + id + "]").popover({
                    html: true,
                    content: function () {
                        return $("#popover-content-addition" + id).html();
                    },
                });
                $("[data-toggle=addition" + id + "]").popover("show");
            }
        },
        hideTooltip(id) {
            $("[data-toggle=" + this.id + "]").popover("dispose");
            this.id = null;
        },
        hideTooltip1(id) {
            $("[data-toggle=deduction" + this.id + "]").popover("dispose");
            this.id = null;
        },
        hideTooltip2(id) {
            $("[data-toggle=employee" + this.id + "]").popover("dispose");
            this.id = null;
        },
        hideTooltip3(id) {
            $("[data-toggle=addition" + this.id + "]").popover("dispose");
            this.id = null;
        },
    },
};
</script>

<style scoped>
.custom-padding {
    padding-left: 24px;
}

.custom-padding-right {
    padding-right: 24px;
}

.action {
    margin-right: 4px !important;
    margin-bottom: 10px !important;
    margin-top: 10px !important;
}

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
}

.card-one {
    border: 1px solid #d2d6dc;
    border-bottom: 0px;
}
.dropright .dropdown-menu::before {
    top: 1.285rem;
    left: 131px;
    transform: rotate(140deg) translate(-9px);
}

.DotsYaxis {
    transform: rotate(90deg);
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.custom-dropdown {
    margin-top: 0.5rem !important;
}

.error-message {
   color: #dc2626 !important;
    font-size: 11.5px;
    margin-bottom: 10px;
    margin-left: 41px;
}

@media (max-width: 575.98px) {
    .filter-container {
        width: 100% !important;
        padding-right: 22px !important;
        padding-left: 11px !important;
    }

    .filter-dropdown {
        width: 100% !important;
        padding-right: 0px !important;
        padding-left: 11px !important;
    }

    .sort-dropdown {
        width: 100% !important;
        padding-left: 11px !important;
        padding-right: 0px !important;
        padding-top: 15px !important;
    }
}
</style>
s