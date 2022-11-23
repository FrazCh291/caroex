<template>
  <admin-layout>
    <div class="row">
      <div class="col-md-10 col-lg-10 col-sm-10 px-1 pb-0 mb-0">
        <div class="col form-group p-0 mt-1">
          <h4>HR / Payrolls</h4>
        </div>
      </div>
      <div class="col-md-2 col-lg-2 col-sm-2 px-0">
        <div class="col form-group p-0">
          <div class="btn-group dropright float-right mr-1 mt-1">

            <div class="dropdown">
              <span
                class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer badge-circle badge-circle-light-secondary ml-auto "
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
              </span>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" data-toggle="modal" data-target="#additionModel">
                  <i class="bx bx-plus mr-1" data-whatever="@mdo"></i> Add
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <section id="basic-horizontal-layouts">
        <div class="card-content">
          <div>
            <div class="row mt-0 ml-1">
              <div class="modal fade" id="additionModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div>
                      <button type="button" @click="resetPayroll()" s class="close float-right mr-1 mt-1"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <h4 v-if="payrolStatus" class="font-weight-bold mt-5 text-center">
                      Edit Payroll Information
                    </h4>
                    <h4 v-else class="font-weight-bold mt-5 text-center">
                      Add Payroll Information
                    </h4>
                    <p v-if="payrolStatus" class="text-center">
                      Edit a new payroll run for this month
                    </p>
                    <p v-else class="text-center">
                      Create the payroll run for this month
                    </p>
                    <div>
                    </div>
                    <form @submit.prevent="submit" class="form form-horizontal">
                      <div class="modal-body">
                        <span class="text-danger ml-5" v-for="error in errors">{{error}}</span>
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group ml-5 mr-5">
                              <label for="message" class="col-form-label">Reference *</label>
                              <input type="text" id="reference_no" v-model="form.reference_no" class="form-control"
                                name="reference_no">
                              <ErrorComponent input="reference_no"></ErrorComponent>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class=" col-md-6 col-sm-3">
                            <div class=" form-group ml-5">
                              <label for="message" class="col-form-label">Payroll From *</label>
                              <input type="date" id="from" v-model="form.from" class="form-control" name="from">
                              <ErrorComponent input="from"></ErrorComponent>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-3">
                            <div class="form-group  mr-5">
                              <label for="message" class="col-form-label">Payroll To *</label>
                              <input type="date" id="to" v-model="form.to" class="form-control" name="to">
                              <ErrorComponent input="to"></ErrorComponent>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6 col-sm-3">
                            <div class="form-group ml-5">
                              <label for="message" class="col-form-label">Working Days *</label>
                              <input type="text" id="working_days" v-model="form.working_days" class="form-control"
                                name="working_days">
                              <ErrorComponent input="working_days"></ErrorComponent>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-3">
                            <div class="form-group mr-5">
                              <label for="message" class="col-form-label">Status *</label>
                              <select class="form-select" v-model="form.status" name="status">
                                <option v-for="payStatus in payrollStatus" :value="payStatus.slug">
                                  {{ payStatus.value }}
                                </option>
                              </select>
                              <ErrorComponent input="payStatus"></ErrorComponent>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-3 ml-5">
                            <div class="form-group mr-5">
                              <label for="message" class="col-form-label">Currency *</label>
                              <select class="form-select" v-model="form.currency" name="currency">
                                <option v-for="currency in currencys" :value="currency.slug">
                                  {{ currency.value }}
                                </option>
                              </select>
                              <ErrorComponent input="currency"></ErrorComponent>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6 col-sm-3">
                            <button @click="next()" class="btn btn-primary float-right mb-2 mt-2">
                              <span class="btnNext">Next </span>
                            </button>
                          </div>
                          <div class="col-md-6 col-sm-3">
                            <button type="button" @click="resetPayroll()" class="btn btn-light mb-2 mt-2"
                              data-dismiss="modal" aria-label="Close">
                              Cancel
                            </button>
                          </div>
                        </div>
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
              <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div>
                      <button @click="back()" class=" float-left ml-1 mt-1">
                        <i class="
                                      bx 
                                      bx-chevron-left
                                      font-large-1
                                      align-items-center
                                      text-center
                                    "></i>
                      </button>
                      <button type="button" @click="resetPayroll()" class="close float-right mr-1 mt-1"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <h4 class="font-weight-bold mt-1 text-center">
                      Add Employees
                    </h4>
                    <p class="text-center">
                      Create a new payroll entry for this month
                    </p>
                    <div>
                    </div>
                    <form @submit.prevent="submit" class="form form-horizontal">
                      <div class="modal-body">
                        <span class="text-danger ml-5" v-for="eror in errorss">{{eror}}</span>
                        <div class="row" style=" height: 400px;overflow-y: scroll;">
                          <div class="col-lg-4 col-md-4 col-sm-4">
                            <ul>
                              <li class="mt-1 ml-2" v-for="(employee, index) in employees.slice(0,15)" :key="index">
                                <input type="checkbox" id="employee.id" checked="checked" :value="employee.id"
                                  v-model="Saleryemployees">
                                <label for="employee.id" class="ml-1">{{ employee.name }}</label>
                              </li>
                            </ul>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-4">
                            <ul>
                              <li class="mt-1 ml-1" v-for="(employee, index) in employees.slice(15,30)" :key="index">
                                <input type="checkbox" id="employee.id" checked="checked" :value="employee.id"
                                  v-model="Saleryemployees">
                                <label for="employee.id" class="ml-1" active>{{ employee.name }}</label>
                              </li>
                            </ul>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-4">
                            <ul>
                              <li class="mt-1 ml-1" v-for="(employee, index) in employees.slice(30,45)" :key="index">
                                <input type="checkbox" id="employee.id" checked="checked" :value="employee.id"
                                  v-model="Saleryemployees">
                                <label for="employee.id" class="ml-1">{{ employee.name}}</label>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="col-sm-11 d-flex justify-content-center mt-1 mb-5 ">
                          <button type="submit" @click="assign()" class="btn btn-primary pl-2 pr-2 ml-5">
                            <span class="btnNext">Save </span>
                          </button>
                          <button type="button" @click="resetPayroll()" class="btn btn-light  ml-1" data-dismiss="modal"
                            aria-label="Close">
                            Cancel
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
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
                    <div id="DataTables_Table_0_filter" class="dataTables_filter">
                      <div class="
                          input-group
                          form-group
                          d-flex
                          position-relative
                          mt-1
                          px-2
                          pr-md-0
                        ">
                        <input type="text" class="form-control border-light-gray btn-height" placeholder="Search..."
                          aria-label="Search" aria-describedby="basic-addon2" v-model="query.query" @change="search" />
                        <div class="input-group-append">
                          <button class="input-group-text search-btn" @change="search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"
                              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round" class="
                                feather feather-search feather-16
                                pb-0
                                mb-0
                                mt-0
                              ">
                              <circle cx="11" cy="11" r="8"></circle>
                              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="
                      actions
                      action-btns
                      d-flex
                      align-items-center
                      flex flex-wrap
                      filter-container
                      pl-1
                    ">
                    <div class="dropdown md:w-1/2 sm:w-1 pr-1 filter-dropdown">
                      <button class="btn border dropdown-toggle w-100" type="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Filter
                      </button>
                      <div class="dropdown-menu dropdown-menu-right py-0 my-0 custom-dropdown" @click="stopPropagation"
                        aria-labelledby="">
                        <div class="col-12 pl-2 pt-1">
                          <div class="d-inline-flex w-100">
                            <h6 class="py-0 my-0">Status</h6>
                            <span class="primary pl-20 ml-2 pointer" @click="resetFilter">Reset</span>
                          </div>
                          <div class="align-items-center text-base pt-1">
                            <p class="tag">
                              <input type="checkbox" name="in_progress" id="in_progress" v-model="query.in_progress">
                              <label class="pl-1 py-0 my-0" for="in_progress">In Progress</label>
                            </p>
                            <p class="tag">
                              <input type="checkbox" name="complete" id="complete" v-model="query.complete">
                              <label class="pl-1 py-0 my-0" for="complete">Complete</label>
                            </p>
                            <p class="tag">
                              <input type="checkbox" name="deleted" id="deleted" v-model="query.deleted">
                              <label class="pl-1 py-0 my-0" for="deleted">Deleted</label>
                            </p>
                          </div>
                        </div>
                        <div class="dropdown-divider py-0 my-0"></div>
                        <div class="col-12 pl-2">
                          <p class="pt-1">
                            <button type="button" id="asc" @click="filter"
                              class=" btn btn-sm btn-primary font-small font-weight-normal stock-order">
                              Filter
                            </button>
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="dropdown md:w-1/2 sm:w-1 pr-1  pr-2 sort-dropdown2">
                      <button class="btn border dropdown-toggle w-100" type="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Sort
                      </button>
                      <div class="
                          dropdown-menu dropdown-menu-right
                          py-0
                          my-0
                          custom-dropdown
                        " aria-labelledby="" @click="stopPropagation">
                        <div class="col-12 pl-2 pt-1">
                          <div class="d-inline-flex w-100">
                            <h6 class="py-0 my-0">Sort</h6>
                            <span class="primary pl-20 ml-2 pointer" @click="resetSort">Reset</span>
                          </div>
                          <div class="text-base pt-1">
                            <p class="tag">
                              <input type="checkbox" name="reference_no" id="reference_no"
                                v-model="query.reference_no" v-on:click="check_one()" />
                              <label class="pl-1 py-0 my-0" for="reference_no">Reference</label>
                            </p>
                            <p class="tag">
                              <input type="checkbox" name="from" id="from" v-model="query.from" v-on:click="check_one()" />
                              <label class="pl-1 py-0 my-0" for="from">From</label>
                            </p>
                            <p class="tag">
                              <input type="checkbox" name="to" id="to" v-model="query.to"  v-on:click="check_one()"/>
                              <label class="pl-1 py-0 my-0" for="to">To</label>
                            </p>
                            <p class="tag">
                              <input type="checkbox" name="no_of_employees" id="no_of_employees"
                                v-model="query.no_of_employees" v-on:click="check_one()" />
                              <label class="pl-1 py-0 my-0" for="no_of_employees">Staff</label>
                            </p>
                            <p class="tag">
                              <input type="checkbox" name="working_days" id="working_days"
                                v-model="query.working_days" v-on:click="check_one()" />
                              <label class="pl-1 py-0 my-0" for="working_days">Work Days</label>
                            </p>
                            <p class="tag">
                              <input type="checkbox" name="total_paid" id="total_paid" v-model="query.total_paid" v-on:click="check_one()" />
                              <label class="pl-1 py-0 my-0" for="total_paid">Total</label>
                            </p>
                            <p class="tag">
                              <input type="checkbox" name="total_tax" id="total_tax" v-model="query.total_tax" v-on:click="check_one()" />
                              <label class="pl-1 py-0 my-0" for="total_tax">Tax</label>
                            </p>
                             <p class="tag">
                              <input type="checkbox" name="status" id="status" v-model="query.status" v-on:click="check_one()" />
                              <label class="pl-1 py-0 my-0" for="status">Status</label>
                            </p>
                          </div>
                        </div>
                        <div class="dropdown-divider py-0 my-0"></div>
                        <div class="col-12 pl-2 d-inline-flex">
                          <p class="pt-1">
                            <button type="button" id="asce" @click="sort('asc')" class="
                                btn btn-sm btn-primary
                                font-small font-weight-normal
                                stock-order
                              ">
                              Asc
                            </button>
                          </p>
                          <p class="pt-1 pl-3">
                            <button type="button" id="desc" @click="sort('desc')" class="
                                btn btn-sm btn-light-secondary
                                font-small font-weight-normal
                                stock-order
                              ">
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
                    <th class="custom-padding">Reference</th>
                    <th class="text-center text-truncate">Payment from</th>
                    <th class="text-center text-truncate">Payment To</th>
                    <th class="text-center text-truncate">Staff</th>
                    <th class="text-center text-truncate">Work Days</th>
                    <th class="text-right text-truncate">Total</th>
                    <th class="text-right text-truncate">Tax</th>
                    <th class="text-center text-truncate">Status</th>
                    <th class="text-right custom-padding-right"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(payroll,index) in payrolls.data">
                    <td class="custom-padding text-truncate">
                      {{ payroll.reference_no }}
                    </td>
                    <td class="text-center text-truncate">
                      {{ formatDate(payroll.from) }}
                    </td>
                    <td class="text-center text-truncate">
                      {{ formatDate(payroll.to) }}
                    </td>
                    <td class="text-center text-truncate ">
                      <span class="font-medium-1 staff " @click="showPayroll(index)">{{ payroll.no_of_employees
                        }}</span>

                      <section id="basic-horizontal-layouts">
                        <div class="card-content">
                          <div>
                            <div class="row mt-0 ml-1">
                              <div class="modal fade" id="empDetailModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div>
                                      <button type="button" class="close float-right mr-1 mt-1" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="shadow-lg  mb-3 ml-3 mr-3 mt-1  bg-white rounded">
                                      <div class="row">
                                        <span class="ModelHeader text-dark  font-weight-bold  mb-1">STAFF LIST</span>
                                      </div>
                                      <div class="row">
                                        <div class="col-lg-4">
                                          <span v-for="(salary,index) in payrolls.data[modalIndex].salaries.slice(0,15)"
                                            :key="index">
                                            <p class="text-justify ModelContent">{{(index+1) + " . " +
                                              salary.employee.name}}</p>
                                          </span>
                                        </div>
                                        <div class="col-lg-4">
                                          <span
                                            v-for="(salary,index) in payrolls.data[modalIndex].salaries.slice(15,30)"
                                            :key="index">
                                            <p class="text-justify ">{{(index+16) + " . " + salary.employee.name}}</p>
                                          </span>
                                        </div>
                                        <div class="col-lg-4">
                                          <span
                                            v-for="(salary,index) in payrolls.data[modalIndex].salaries.slice(30,45)"
                                            :key="index">
                                            <p class="text-justify ">{{(index+31) + " . " + salary.employee.name}}</p>
                                          </span>
                                        </div>

                                      </div>
                                    </div>
                                    <div>
                                    </div>

                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>

                    </td>
                    <td class="text-center text-truncate">
                      {{ payroll.working_days }}
                    </td>
                    <td class="text-right v">{{ payroll.total_paid }}</td>
                    <td class="text-right text-truncate">
                      {{ payroll.total_tax }}
                    </td>
                    <td class="text-center text-truncate">
                      <span class="badge badge-light-danger badge-pill"
                        v-if="payroll.payroll_status?payroll.payroll_status.value == 'Deleted':''">Deleted</span>
                      <span class="badge badge-light-success badge-pill"
                        v-else-if="payroll.payroll_status?payroll.payroll_status.value == 'Complete':''">Complete</span>
                      <span class="badge badge-light-warning badge-pill" v-else>In Progress</span>
                    </td>
                    <td class="text-right py-0 my-0 custom-padding-right">
                        <div class="dropdown">
                          <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                          </span>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a :href="route('payrolls.show', payroll.id)" class="dropdown-item"><i
                                class=" bx bx-show mr-1"></i>Detail View</a>
                            <a :href="route('payrolls.show', payroll.id)" class="dropdown-item" data-toggle="modal"
                              data-target="#additionModel" @click="editPayroll(payroll)"><i
                                class="bx bx-edit-alt mr-1"></i>Edit</a>
                            <a :href="route('payrolls.show', payroll.id)" class="dropdown-item" data-toggle="modal"
                              data-target="#bankOrderModal" @click="BankOrder(payroll.id)"><i
                                class="bx bxs-bank mr-1"></i>Bank Order</a>
                            <a :href="route('cashorder.cashOrderLetter', payroll.id)" class="dropdown-item"><i
                                class="bx bxs-bank mr-1"></i>Cash Order</a>
                            <a :href="route('export.employee.payslip' , payroll.id)" class="dropdown-item"><i
                                class=" bx bxs-calendar-minus mr-1"></i>Payslips</a>
                            <a :href="route('export.employee.payslip' , payroll.id)" class="dropdown-item"
                              v-on:click="confirmDelete(payroll.id)"><i class=" bx bx-trash mr-1"></i>Delete</a>
                          </div>
                        </div>
                      <section id="basic-horizontal-layouts">
                        <div class="card-content">
                          <div>
                            <div class="row mt-0 ml-1">
                              <div class="modal fade" id="viewModel" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header text-center">
                                      <h4 class="text-center">
                                        Salary History
                                      </h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="row">
                                        <div class="table-responsive">
                                          <table class="table table-hover mb-0">
                                            <thead>
                                              <tr>
                                                <th class="
                                                    custom-padding
                                                    text-truncate
                                                  ">
                                                  Name
                                                </th>
                                                <th class="
                                                    text-truncate text-center
                                                  ">
                                                  Emp #
                                                </th>
                                                <th class="
                                                    text-truncate text-center
                                                  ">
                                                  Date
                                                </th>
                                                <th class="
                                                    text-truncate text-right
                                                  ">
                                                  Gross
                                                </th>
                                                <th class="
                                                    text-truncate text-right
                                                  ">
                                                  Total Detuction
                                                </th>
                                                <th class="
                                                    text-truncate text-right
                                                  ">
                                                  Tax
                                                </th>
                                                <th class="
                                                    text-truncate text-right
                                                  ">
                                                  Net Total
                                                </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr v-for="employeeSalary in payroll.salaries">
                                                <td class="
                                                    my-0
                                                    custom-padding
                                                    mt-1
                                                  ">
                                                  Affaf
                                                </td>
                                                <td class="
                                                    py-0
                                                    my-0
                                                    text-truncate text-center
                                                  ">
                                                  {{
                                                  employeeSalary.employee_id
                                                  }}
                                                </td>
                                                <td class="
                                                    py-0
                                                    my-0
                                                    text-truncate text-center
                                                  ">
                                                  {{ employeeSalary.date }}
                                                </td>
                                                <td class="
                                                    py-0
                                                    my-0
                                                    text-truncate text-right
                                                  ">
                                                  {{ employeeSalary.gross }}
                                                </td>
                                                <td class="
                                                    py-0
                                                    my-0
                                                    text-truncate text-right
                                                  ">
                                                  {{
                                                  employeeSalary.total_detuction
                                                  }}
                                                </td>
                                                <td class="
                                                    py-0
                                                    my-0
                                                    text-truncate text-right
                                                  ">
                                                  {{ employeeSalary.tax }}
                                                </td>
                                                <td class="
                                                    py-0
                                                    my-0
                                                    text-truncate text-right
                                                  ">
                                                  {{ employeeSalary.net_total }}
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
                            </div>
                          </div>
                        </div>
                      </section>
                      <section id="basic-horizontal-layouts">
                        <div class="card-content">
                          <div>
                            <div class="row mt-0 ml-1">
                              <div class="modal fade" id="bankOrderModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header text-center">
                                      <h4 class="text-center">
                                        Bank Letter
                                      </h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">

                                      <form :action="route('bankorder.bankOrderLetter', this.orderId)" method="get"
                                        class="form form-horizontal">
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class=" col-12">
                                              <label for="message" class="col-form-label float-left mr-1 ">Branch
                                                Manager
                                                *</label>
                                              <div class=" form-group d-flex ">
                                                <input type="text" id="manager" v-model="form1.manager"
                                                  class="form-control" name="manager">
                                                <ErrorComponent input="manager"></ErrorComponent>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class=" col-12">
                                              <div class="mt-2"> 
                                              <label for="message" class="col-form-label float-left mr-1 ">Branch
                                                Addresss *</label>
                                              <div class=" form-group d-flex ">
                                                <!-- <textarea class="form-control" id="address" name="address"  v-model="form1.address"></textarea> -->
                                                <select id="address" name="address"  v-model="form1.address" class="form-select">
                                                      <option value=""></option>
                                                      <option v-for="address in bankAddress"
                                                              :value="address.value">
                                                          {{ address.value}}
                                                      </option>
                                                  </select>
                                                <ErrorComponent input="address"></ErrorComponent>
                                              </div>
                                            </div>
                                          </div>
                                          </div>
                                          <div class="row">
                                          <div class="col-12  mt-1 mb-1 float-right">
                                             <button type="submit" @click="close()" class="btn btn-primary">
                                                    Generate PDf
                                                </button>
                                          </div>
                                        </div>
                                        </div>
                                      </form>
                                    </div>
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
                              <div class="modal fade" id="cashOrderModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header text-center">
                                      <h4 class="text-center">
                                        Cash Letter
                                      </h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">

                                      <form :action="route('cashorder.cashOrderLetter', this.cashId)" method="get"
                                        class="form form-horizontal">
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class=" col-12">
                                              <label for="message" class="col-form-label float-left mr-1 ">Branch
                                                Manager
                                                *</label>
                                              <div class=" form-group d-flex ">
                                                <input type="text" id="manager" v-model="form1.manager"
                                                  class="form-control" name="manager">
                                                <ErrorComponent input="manager"></ErrorComponent>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class=" col-12">
                                              <div class="mt-2"> 
                                              <label for="message" class="col-form-label float-left mr-1 ">Branch
                                                Addresss *</label>
                                              <div class=" form-group d-flex ">
                                                <textarea class="form-control" id="address" name="address"  v-model="form1.address"></textarea>
                                                   <select v-model="form1.address" class="form-select">
                                                      <option value=""></option>
                                                      <option v-for="address in bankAddress"
                                                              :value="address.value">
                                                          {{ address.value}}
                                                      </option>
                                                  </select>
                                                <ErrorComponent input="address"></ErrorComponent>
                                              </div>
                                            </div>
                                          </div>
                                          </div>
                                          <div class="row">
                                          <div class="col-12  mt-1 mb-1 float-right">
                                             <button type="submit"  class="btn btn-primary">
                                                    Generate PDf
                                                </button>
                                          </div>
                                        </div>
                                        </div>
                                      </form>
                                    </div>
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
      <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked" @deleteitem="deleteItem">
      </ConfirmatiomModal>
      <div class="col-12">
        <pagination :links="payrolls.links" class="float-right"></pagination>
      </div>
    </div>
  </admin-layout>
</template>

<script>
  import moment from "moment";
  import Button from "../../Jetstream/Button";
  import { useForm } from "@inertiajs/inertia-vue3";
  import Pagination from "../../admin/Pagination";
  import AdminLayout from "../../Layouts/AdminLayout";
  import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

 export default {
    name: "Index",
    props: ["payrolls", "params", "payrollStatus","bankAddress", "currencys", "employees"],
    components: {
      Button,
      AdminLayout,
      Pagination,
      ConfirmatiomModal,
    },
    setup() {
      const form = useForm({
        to: "",
        from: "",
        status: "",
        currency: "",
        working_days: "",
        reference_no: "",
        Saleryemployees: [],
      });
      const form1 = useForm({
        manager: "",
        address: "",
      });
      return { form, form1 };
    },
    data() {
      return {
        query: {
          query: "",
          id: false,
          to: false,
          from: false,
          status: false,
          total_paid: false,
          total_tax: false,
          working_days: false,
          reference_no: false,
          manager: false,
          address: false,
          enable: false,
          disable: false,
          direction: null,
        },
        sweetAlert: false,
        itemId: "",
        sent: false,
        searchItem: false,
        errors: [],
        errorss: [],
        Saleryemployees: [],
        modalIndex: 0,
        payrolStatus: false,
        orderId: '',
        cashId: '',
      };
    },
    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - HR/Payroll";
      if (this.payroll) {
        this.update = true;
        let data = this.payroll;
        Object.assign(data, {
          _method: "PUT",
        });
        this.form = this.$inertia.form(data);
      }
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
      resetQuery() {
        this.query = {};
        this.loadData();
      },
      Clicked() {
        this.sweetAlert = false;
      },
      deleteItem() {
        this.sweetAlert = false;
        this.$inertia.delete(`/erp/payrolls/${this.itemId}`);
      },
      confirmDelete(id) {
        this.sweetAlert = true;
        this.itemId = id;
      },
      stopPropagation(e) {
        e.stopPropagation();
      },
      resetSort(e) {
        this.query.direction = "";
        this.query.to = "";
        this.query.from = "";
        this.query.reference_no = "";
        this.query.no_of_employees = "";
        this.query.total_paid = "";
        this.query.total_tax = "";
        this.query.status = "";
        this.query.working_days = "";
        this.loadData();
      },
      resetFilter() {
        this.query.direction = "";
        this.query.enable = "";
        this.query.disable = "";
        this.query.in_progress = "";
        this.query.complete = ""
        this.query.deleted = ""
        this.loadData();
      },
      search() {
        this.searchItem = true;
        this.loadData();
      },
          check_one: function () {
      if ((this.query.reference_no = false)) {
        this.query.reference_no = true;
        this.query.from = [];
        this.query.to = [];
        this.query.no_of_employees = [];
        this.query.working_days = [];
        this.query.total_paid = [];
        this.query.total_tax = [];
        this.query.status = [];
      }
      if ((this.query.from = false)) {
        this.query.from = true;
        this.query.reference_no = [];
        this.query.to = [];
        this.query.no_of_employees = [];
        this.query.working_days = [];
        this.query.total_paid = [];
        this.query.total_tax = [];
        this.query.status = [];
      }
      if ((this.query.to = false)) {
        this.query.to = true;
        this.query.from = [];
        this.query.reference_no = [];
        this.query.no_of_employees = [];
        this.query.working_days = [];
        this.query.total_paid = [];
        this.query.total_tax = [];
        this.query.status = [];
      }
      if ((this.query.no_of_employees = false)) {
        this.query.no_of_employees = true;
        this.query.from = [];
        this.query.to = [];
        this.query.reference_no = [];
        this.query.working_days = [];
        this.query.total_paid = [];
        this.query.total_tax = [];
        this.query.status = [];
      }
      if ((this.query.working_days = false)) {
        this.query.working_days = true;
        this.query.from = [];
        this.query.to = [];
        this.query.no_of_employees = [];
        this.query.reference_no = [];
        this.query.total_paid = [];
        this.query.total_tax = [];
        this.query.status = [];
      }
      if ((this.query.total_paid = false)) {
        this.query.total_paid = true;
        this.query.from = [];
        this.query.to = [];
        this.query.no_of_employees = [];
        this.query.working_days = [];
        this.query.reference_no = [];
        this.query.total_tax = [];
        this.query.status = [];
      }
      if ((this.query.total_tax = false)) {
        this.query.total_tax = true;
        this.query.from = [];
        this.query.to = [];
        this.query.no_of_employees = [];
        this.query.working_days = [];
        this.query.total_paid = [];
        this.query.reference_no = [];
        this.query.status = [];
      }
      if ((this.query.status = false)) {
        this.query.status = true;
        this.query.from = [];
        this.query.to = [];
        this.query.no_of_employees = [];
        this.query.working_days = [];
        this.query.total_paid = [];
        this.query.total_tax = [];
        this.query.reference_no = [];
      }
    },
      formatDate(created_at) {
        return moment(created_at).format("DD/MM/YYYY");
      },
      showPayroll(index) {
        this.modalIndex = index;
        $("#empDetailModal").modal("show");
      },
      BankOrder(orderId) {
        this.orderId = orderId;
      },
      close(){
      $("#bankOrderModal").modal("hide");
      },
      cashOrder(cashId) {
        this.cashId = cashId;
      },
      resetPayroll() {
        this.form.to = "";
        this.form.from = "";
        this.form.status = "";
        this.form.currency = "";
        this.form.working_days = "";
        this.form.reference_no = "";
        this.form.employees = "";
      },

      editPayroll(payroll) {

        this.payrolStatus = true;
        this.Saleryemployees = [];
        this.form.id = payroll.id;
        this.form.to = payroll.to;
        this.form.currency = payroll.currency;
        this.form.from = payroll.from;
        this.form.status = payroll.status;
        this.form.working_days = payroll.working_days;
        this.form.reference_no = payroll.reference_no;
        payroll.salaries.forEach((element) => {
          this.Saleryemployees.push(element.employee.id);
        });
        this.payroll = true;
      },

      next() {
        this.payrolStatus = false;
        if (!this.form.from) {
          (this.errors = []), this.errors.push("Payroll From required.");
          event.stopPropagation();
        } else if (!this.form.to) {
          (this.errors = []), this.errors.push("Payroll To required.");
          event.stopPropagation();
        } else if (!this.form.reference_no) {
          (this.errors = []), this.errors.push("Reference required.");
          event.stopPropagation();
        } else if (!this.form.working_days) {
          (this.errors = []), this.errors.push("Working Days required.");
          event.stopPropagation();
        } else if (!this.form.status) {
          (this.errors = []), this.errors.push("Status required.");
          event.stopPropagation();
        } else if (!this.form.currency) {
          (this.errors = []), this.errors.push("currency required.");
          event.stopPropagation();
        } else {
          (this.sent = false), $("#additionModel").modal("hide");
          $("#addEmployeeModal").modal("show");
        }
      },
      back() {
        $("#addEmployeeModal").modal("hide");
        $("#additionModel").modal("show");
      },

      filter() {
        this.loadData();
      },
      sort(direction) {
        this.query.direction = direction;
        this.loadData();
      },
      formatDate(date) {
        return moment(date).format("DD/MM/YYYY");
      },
      assign() {
        this.sent = true;
      },
      submit() {
        if (this.sent) {
          console.log(this.Saleryemployees.length);

          if (this.Saleryemployees.length < 1) {
            this.errorss = [];
            this.errorss.push("Please Select Employees.");
            return false;
          }
          $("#addEmployeeModal").modal("hide");
          if (this.payroll) {
            this.form.Saleryemployees = this.Saleryemployees;
            this.form.id = this.form.id;
            this.form.put(route("payrolls.update", this.form.id));
          } else {
            this.form.Saleryemployees = this.Saleryemployees;
            this.form.post("/erp/payrolls");
            this.resetPayroll();
          }
        }
      },
      submit1() {
        this.form1.orderId = this.orderId;
        this.form1.put(route('bankorder.bankOrderLetter', this.orderId));
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
      hideTooltip(id) {
        $("[data-toggle=" + this.id + "]").popover("dispose");
        this.id = null;
      },
      loadData() {
        let query = {};
        for (let item in this.query) {
          if (this.query[item]) {
            Object.assign(query, { [item]: this.query[item] });
          }
        }
        this.$inertia.visit(route("payrolls.index"), {
          method: "get",
          data: {
            ...query,
          },
        });
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

  table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
  }

  .custom-dropdown {
    margin-top: 0.5rem !important;
  }

  .DotsYaxis {
    transform: rotate(90deg);
  }

  .detail {
    color: #727e8c;
  }

  .staff {
    border-bottom: 1px dotted rgb(116, 113, 113);
    text-decoration-style: dotted;
  }

  .ModelHeader {
    margin-left: 30px;
    margin-top: 20px;
  }

  .ModelContent {
    margin-left: 15px;
  }

  .btnNext {
    margin-left: 8px;
    margin-right: 8px;
  }

  a {
    color: inherit;
    text-decoration: none;
  }

  .addPayroll {
    font-size: 16px;
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