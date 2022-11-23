<template>
  <admin-layout>
    <section id="basic-horizontal-layouts">
      <h4 class="mb-1">Employee View</h4>
      <form
        @submit.prevent="submit"
        class="form form-horizontal"
        enctype="multipart/form-data"
      >
        <div class="form-body">
          <div class="row match-height row1 form-group">
            <div class="card w-100">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div
                        class="col-lg-6 col-md-6 col-sm-6 col-12"
                        id="order2"
                      >
                        <div class="row">
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Name:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  employee ? employee.name : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Email:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  employee ? employee.email : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Phone:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  employee ? employee.phone : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                             <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Github:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  employee ? employee.github_account : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Linkedin:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  employee ? employee.linkedin_account : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Facebook:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  employee ? employee.fb_account : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Department:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  employee ? employee.department : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                           <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Designation:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  employee ? employee.designation : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                            <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Starting date</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  employee ? employee.starting_date : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Basic Salary</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  employee ? employee.total_salary : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold mt-1"
                                  >Status:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">
                                  <span
                                    class="badge badge-light-success badge-pill"
                                    v-if="
                                      employee ? employee.is_status : '' == '1'
                                    "
                                    >Active</span
                                  >
                                  <span
                                    class="badge badge-light-danger badge-pill"
                                    v-else
                                    >Inactive</span
                                  >
                                </small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div
                        class="col-lg-6 col-md-6 col-sm-6 col-12 text-right"
                        id="order1"
                      >
                        <img
                          :src="employee ? employee.image : ''"
                          class="rounded-circle d-inline-block"
                          style="height: 150px; width: 150px"
                          id="EmployeeImg"
                          v-if="employee ? employee.image : ''"
                        />
                        <img
                          :src="'/img/avator.jpg'"
                          class="rounded-circle d-inline-block"
                          style="height: 150px; width: 150px"
                          v-else
                        />
                      </div>
                    </div>
                    <div class="row mt-1"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row match-height row1 form-group">
            <div class="card w-100">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div
                        class="col-lg-6 col-md-6 col-sm-6 col-12"
                        id="order2"
                      >
                        <div class="row">
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >CNIC:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small
                                  class="text-muted text-truncate text-lg-right"
                                  >{{ employee ? employee.cnic : "" }}</small
                                >
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Address_1:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  address ? address.address_1 : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Address_2:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  address ? address.address_2 : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Town:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  address ? address.city : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >County:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  address ? address.county : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Post Code:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  address ? address.postcode : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Country:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  address ? address.country : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Date of Birth:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                 DateOfBirth( accounts ? accounts.date_of_birth : "")
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Bank Account:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  accounts ? accounts.account_no : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                           <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Bank Name:</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  accounts ? accounts.bank_name : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-sm-left">
                            <div class="row">
                              <div class="col-lg-2">
                                <small class="text-muted lg:font-bold"
                                  >Account title :</small
                                >
                              </div>
                              <div class="col-lg-10">
                                <small class="text-muted text-truncate">{{
                                  accounts ? accounts.account_title : ""
                                }}</small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div
                        class="col-lg-3 col-md-3 col-sm-3 col-12 text-right"
                        id="order1"
                      >
                        <img
                          :src="employee.image_cnic"
                          class="rounded d-inline-block"
                          style="height: 200px; width: 300px"
                          v-if="employee ? employee.image_cnic : ''"
                        />
                        <img
                          :src="'/img/idcard.jpg'"
                          class="rounded d-inline-block mr-1"
                          style="height: 200px; width: 300px"
                          v-else
                        />
                      </div>
                     <div
                        class="col-lg-3 col-md-3 col-sm-3 col-12 text-right"
                      >
                        <img
                          :src="employee.image_cnic_1"
                          id="CnicImg"
                          class="rounded d-inline-block mr-1"
                          style="height: 200px; width: 300px"
                          v-if="employee ? employee.image_cnic_1 : ''"
                        />
                        <img
                          :src="'/img/idcard.jpg'"
                          class="rounded d-inline-block mr-1"
                          style="height: 200px; width: 300px"
                          v-else
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row" >
            <div class="col-10">
              <h5 class="mt-1">Add Document</h5>
              </div>
            <div class="col-2">
                <div class="col form-group pr-0 pb-1">
                <a :href="route('employee.document', employee.id)"
                    class="bx bxs-plus-circle pt-1 primary float-right add-btn font-large-1"
                    data-repeater-create="">
                </a>
                </div>
            </div>
            <div class="row col-12 pr-0 ng-repeat-start" id="table-hover-row">
              <div class="col-12 pr-0 mb-2" v-if="employeeDocuments.length>0">
                <div class="card pr-0 pb-0 mb-1">
                  <div class="card-content">
                    <div class="table-responsive">
                      <table class="table table-hover truncate mb-0">
                        <thead>
                          <tr>
                            <th class="text-left custom-padding">Title</th>
                            <th class="">File</th>
                            <th class="">Description</th>
                            <th class="">Created At</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody class="truncate">
                          <tr v-for="document in employeeDocuments" >
                            <td
                              class="

                                cursor-pointer
                                ml-1
                                text-truncate
                              "
                            >
                            {{
                                  document.title
                                }}
                            </td>
                            <td
                              class="

                                cursor-pointer
                                py-0
                                my-0
                                text-truncate
                              "
                            >
                              {{ document.file.substr(18) }}
                            </td>
                            <td
                              class="

                                cursor-pointer
                                py-0
                                my-0
                                text-truncate
                              "
                            >
                              {{ document.description }}
                            </td>
                            <td
                              class="

                                cursor-pointer
                                py-0
                                my-0
                                text-truncate
                              "
                            >
                              {{ formatDate(document.created_at)}}
                            </td>
                            <td class="text-right  action pr-1 mr-2">
                                                        <div class="dropdown">
                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                            </span>
                            <div class="dropdown-menu dropdown-menu-right">
                            <a :href="route('employee.cv.export', document.id)" class="dropdown-item"><i class="bx bx-download mr-1"></i>Download</a>
                            <a :href="route('employees.document.edit', document.id)" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                            <a class="dropdown-item" v-on:click="confirmDeletedocument(document.id)"><i class="bx bx-trash mr-1"></i> delete</a>
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

            </div>
          </div>
          <div class="row" id="table-hover-row form-group">
            <div class="col-12">
              <div class="card-one py-0 my-0 bg-white">
                <div class="card-content">
                  <div class="card-content mt-1 cardcustom">
                    <div class="row form-group mb-0 mt-2">
                      <div
                        class="
                          col-lg-11 col-md-10 col-sm-10 col-12
                          form-group
                          pr-0
                          pl-0
                          file
                        "
                      >
                        <div class="form-group ml-1 mr-1">
                          <select
                            class="form-select"
                            v-model="form.month"
                            name="month"
                          >
                          <option value=""></option>
                            <option
                              v-for="monthyear in monthYear"
                              :value="monthyear.month"
                              selected
                            >
                              {{ monthyear.month }}
                            </option>
                          </select>
                        </div>
                      </div>
                      <div
                        class="
                          col-lg-1 col-md-2 col-sm-2
                          d-flex
                          justify-content-center
                        "
                      >
                        <div class="form-group ml-1" id="strButton">
                          <button
                            type="button"
                            class="btn btn-primary w-100"
                            @click="refreshData"
                          >
                            <span>Start</span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="row my-1 mx-1">
                        <div class="col-sm-3 col-lg-3 dashboard-users-success">
                          <div class="card text-center">
                            <div class="card-content">
                              <div class="card-body py-1 rounded-2xl">
                                <div
                                  class="
                                    badge-circle
                                    badge-circle-lg
                                    badge-circle-primary
                                    mx-auto
                                    mb-50
                                  "
                                >
                                  <i
                                    class="bx bxs-user-check font-medium-5"
                                  ></i>
                                </div>
                                <div class="text-muted line-ellipsis">
                                  Present
                                </div>
                                <h3 class="mb-0">{{ present }}</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 col-lg-3 dashboard-users-success">
                          <div class="card text-center">
                            <div class="card-content">
                              <div class="card-body py-1 rounded-2xl">
                                <div
                                  class="
                                    badge-circle
                                    badge-circle-lg
                                    badge-circle-light-danger
                                    mx-auto
                                    mb-50
                                  "
                                >
                                  <i class="bx bx-user-minus font-medium-5"></i>
                                </div>
                                <div class="text-muted line-ellipsis">
                                  Absent
                                </div>
                                <h3 class="mb-0">{{ absent }}</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                          <div class="card text-center">
                            <div class="card-content">
                              <div class="card-body py-1">
                                <div
                                  class="
                                    badge-circle
                                    badge-circle-lg
                                    badge-circle-warning
                                    mx-auto
                                    mb-50
                                  "
                                >
                                  <i class="bx bx-user font-medium-5"></i>
                                </div>
                                <div class="text-muted line-ellipsis">
                                  Late Minutes
                                </div>
                                <h3 class="mb-0">{{ lateMinute }}</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 col-lg-3 dashboard-users-danger">
                          <div class="card text-center">
                            <div class="card-content">
                              <div class="card-body py-1">
                                <div
                                  class="
                                    badge-circle
                                    badge-circle-lg
                                    badge-circle-success
                                    mx-auto
                                    mb-50
                                  "
                                >
                                  <i class="bx bx-user-plus font-medium-5"></i>
                                </div>
                                <div class="text-muted line-ellipsis">
                                  OverTime Minutes
                                </div>
                                <h3 class="mb-0">{{ overtimeMinute }}</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div data-repeater-list="group-a">
                    <div>
                      <div class="top d-flex flex-wrap">
                        <div class="action-filters flex-grow-1">
                          <div
                            id="DataTables_Table_0_filter"
                            class="dataTables_filter"
                          >
                            <div
                              class="
                                input-group
                                form-group
                                d-flex
                                position-relative
                                mt-1
                                px-2
                                pr-md-0
                              "
                            >
                              <input
                                type="text"
                                class="
                                  form-control
                                  border-light-gray
                                  btn-height
                                "
                                placeholder="Search"
                                aria-label="Search"
                                aria-describedby="basic-addon2"
                                v-model="query.query"
                                @change="search"
                              />
                              <div class="input-group-append">
                                <button
                                  class="input-group-text search-btn"
                                  @change="search"
                                >
                                  <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="23"
                                    height="23"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="
                                      feather feather-search feather-16
                                      pb-0
                                      mb-0
                                      mt-0
                                    "
                                  >
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line
                                      x1="21"
                                      y1="21"
                                      x2="16.65"
                                      y2="16.65"
                                    ></line>
                                  </svg>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="
                            actions
                            action-btns
                            d-flex
                            align-items-center
                            sort-dropdown
                            pl-1
                          "
                        >
                          <div
                            class="
                              dropdown
                              md:w-1/2
                              sm:w-1
                              pr-1
                              filter-dropdown
                            "
                          >
                            <button
                              class="btn border dropdown-toggle w-100"
                              type="button"
                              data-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false"
                            >
                              Filter
                            </button>
                            <div
                              class="
                                dropdown-menu dropdown-menu-right
                                py-0
                                my-0
                                custom-dropdown
                              "
                              @click="stopPropagation"
                              aria-labelledby=""
                            >
                              <div class="col-12 pl-2 pt-1">
                                <div class="d-inline-flex w-100">
                                  <h6 class="py-0 my-0">Status</h6>
                                  <span
                                    class="primary pl-20 ml-2 pointer"
                                    @click="resetFilter"
                                    >Reset</span
                                  >
                                </div>
                                <div class="align-items-center text-base pt-1">
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="enable"
                                      id="enable"
                                      v-model="query.enable"
                                    />
                                    <label class="pl-1 py-0 my-0" for="enable"
                                      >Absent</label
                                    >
                                  </p>
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="disable"
                                      id="disable"
                                      v-model="query.disable"
                                    />
                                    <label class="pl-1 py-0 my-0" for="disable"
                                      >Present</label
                                    >
                                  </p>
                                </div>
                              </div>
                              <div class="dropdown-divider py-0 my-0"></div>
                              <div class="col-12 pl-2">
                                <p class="pt-1">
                                  <button
                                    type="button"
                                    id="asc"
                                    @click="filter"
                                    class="
                                      btn btn-sm btn-primary
                                      font-small font-weight-normal
                                      stock-order
                                    "
                                  >
                                    Filter
                                  </button>
                                </p>
                              </div>
                            </div>
                          </div>
                          <div class="dropdown w-100 pr-2 sort-dropdown2">
                            <button
                              class="btn border dropdown-toggle w-100"
                              type="button"
                              data-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false"
                            >
                              Sort
                            </button>
                            <div
                              class="
                                dropdown-menu dropdown-menu-right
                                py-0
                                my-0
                                custom-dropdown
                              "
                              aria-labelledby=""
                              @click="stopPropagation"
                            >
                              <div class="col-12 pl-2 pt-2">
                                <div class="d-inline-flex w-100">
                                  <h6 class="py-0 my-0">Sort</h6>
                                  <span
                                    class="primary pl-20 ml-2 pointer"
                                    @click="resetSort"
                                    >Reset</span
                                  >
                                </div>
                                <div class="align-items-center text-base pt-1">
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="date"
                                      id="date"
                                      v-model="query.date" v-on:click="check_one()"
                                    />
                                    <label class="pl-1 py-0 my-0" for="date"
                                      >DATE</label
                                    >
                                  </p>
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="clock_in_at"
                                      id="clock_in_at"
                                      v-model="query.clock_in_at" v-on:click="check_one()"
                                    />
                                    <label
                                      class="pl-1 py-0 my-0"
                                      for="clock_in_at"
                                      >Check In</label
                                    >
                                  </p>
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="clock_out_at"
                                      id="clock_out_at"
                                      v-model="query.clock_out_at" v-on:click="check_one()"
                                    />
                                    <label
                                      class="pl-1 py-0 my-0"
                                      for="clock_out_at"
                                      >Check Out</label
                                    >
                                  </p>
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="late_minutes"
                                      id="late_minutes"
                                      v-model="query.late_minutes" v-on:click="check_one()"
                                    />
                                    <label
                                      class="pl-1 py-0 my-0"
                                      for="late_minutes"
                                      >Late Minutes</label
                                    >
                                  </p>
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="overtime_minutes"
                                      id="overtime_minutes"
                                      v-model="query.overtime_minutes" v-on:click="check_one()"
                                    />
                                    <label
                                      class="pl-1 py-0 my-0"
                                      for="overtime_minutes"
                                      >Over  Minutes</label
                                    >
                                  </p>
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name=" short_minutes"
                                      id=" short_minutes"
                                      v-model="query.short_minutes" v-on:click="check_one()"
                                    />
                                    <label
                                      class="pl-1 py-0 my-0"
                                      for="short_minutes"
                                      > Short Minutes</label
                                    >
                                  </p>
                                  <p class="tag">
                                    <input
                                      type="checkbox"
                                      name="work_time_minutes"
                                      id="work_time_minutes"
                                       v-on:click="check_one()"
                                      v-model="query.work_time_minutes" 
                                    />
                                    <label
                                      class="pl-1 py-0 my-0"
                                      for="work_time_minutes"
                                      >Working Minutes</label
                                    >
                                  </p>
                                  
                                </div>
                              </div>
                              <div class="dropdown-divider py-0 my-0"></div>
                              <div class="col-12 pl-2 d-inline-flex">
                                <p class="pt-1">
                                  <button
                                    type="button"
                                    id="asce"
                                    @click="sort('asc')"
                                    class="
                                      btn btn-sm btn-primary
                                      font-small font-weight-normal
                                      stock-order
                                    "
                                  >
                                    Asc
                                  </button>
                                </p>
                                <p class="pt-1 pl-3">
                                  <button
                                    type="button"
                                    id="desc"
                                    @click="sort('desc')"
                                    class="
                                      btn btn-sm btn-light-secondary
                                      font-small font-weight-normal
                                      stock-order
                                    "
                                  >
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
                    <table
                      class="table table-hover mb-0"
                      v-if="employeeRecord.length > 0"
                    >
                      <thead>
                        <tr>
                          <th class="text-truncate">Date</th>
                          <th class="text-truncate text-center">Check In</th>
                          <th class="text-truncate text-center">Check Out</th>
                          <th class="text-truncate text-center">
                            Late Minutes
                          </th>
                          <th class="text-truncate text-center">
                            Over  Minutes
                          </th>
                            <th class="text-truncate text-center">
                            Short Minutes
                          </th>
                          <th class="text-truncate text-center">
                            Working Minutes
                          </th>
                          <th class="text-truncate text-center">Status</th>
                          <th class="text-truncate text-center">
                              <div class="dropdown mr-n1">
                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer ml-auto "
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                            </span>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" data-toggle="modal" data-target="#exportattendence">
                                <i class="bx bx-plus mr-1" data-whatever="@mdo"></i> Export
                              </a>
                            </div>
                          </div>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr v-for="employ in employeeRecord">
                          <td class="text-truncate">
                              {{ formatDate(employ.date) }}
                          </td>
                          <td class="text-truncate text-center">
                              {{ employ.clock_in_at || "---" }}
                          </td>
                          <td class="text-truncate text-center">
                              {{ employ.clock_out_at || "---" }}
                          </td>

                          <td  class="text-truncate text-center"  v-if="employ.late_minutes == 0">
                              {{"---" }}
                          </td>
                          <td  class="text-truncate text-center"  v-else>
                              {{ employ.late_minutes }}
                          </td>

                          <td  class="text-truncate text-center"  v-if="employ.overtime_minutes == 0">
                              {{"---" }}
                          </td>
                          <td  class="text-truncate text-center"  v-else>
                              {{ employ.overtime_minutes }}
                          </td>
                          <td  class="text-truncate text-center" v-if="employ.short_minutes == 0" >
                              {{"---"}}
                          </td>
                          <td  class="text-truncate text-center" v-else >
                              {{ employ.short_minutes }}
                          </td>
                          <td class="text-truncate text-center">
                              {{ employ.attendance_minutes }}/480
                          </td>
                           <td class="py-0 my-0 text-center text-truncate">
                            <span
                              class="badge badge-light-danger badge-pill"
                              v-if="employ.is_absent == '1'"
                              >Absent</span
                            >
                            <span
                              class="badge badge-light-success badge-pill"
                              v-else
                              >Present</span
                            >
                          </td>
                          <td class="text-right py-0 my-0 custom-padding-right">

                            <div class="dropdown">
                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-boundary="window">
                            </span>
                            <div class="dropdown-menu dropdown-menu-right">
                            <a   :href="route('attendence.edit', [employee.id,employ.id,])" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i>Edit</a>
                            <a class="dropdown-item" v-on:click="confirmDelete(employ.id)"><i class="bx bx-trash mr-1"></i>Delete</a>
                            </div>
                            </div>
                          </td>
                      </tr>
                      </tbody>
                    </table>
                    <table class="table table-hover truncate mb-0" v-else>
                      <thead>
                        <tr class="text-center">
                          <h4 class="pt-3">
                            It's seems like you don't have any Record!
                          </h4>
                          <img
                            alt="icon"
                            class="img"
                            src="/img/channelorder.png"
                          />
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-11 d-flex justify-content-start mb-1">
              <inertia-link
                :href="route('employees.index')"
                type="button"
                class="btn btn-secondary mr-1 mt-0"
              >
                Back
              </inertia-link>
            </div>
          </div>
        </div>
        <ConfirmatiomModal
          v-if="sweetAlert"
          :sweetAlert="sweetAlert"
          @clicked="Clicked"
          @deleteitem="deleteItem"
        ></ConfirmatiomModal>
      </form>
    </section>
    <section id="basic-horizontal-layouts">
      <div class="card-content">
        <div>
          <div class="row mt-0 ml-1">
            <div class="modal fade" id="exportattendence" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header text-center">
                    <h4 class="text-center">
                      Export Attendence
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form :action="route('export.attendence.file',employee.id)" method="get"
                      class="form form-horizontal">
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-12 pl-0">
                            <label for="message" class="col-form-label float-left mr-1 ">Month
                              *</label>
                            <div class=" form-group d-flex ">
                               <select
                            class="form-select"
                            v-model="form.month"
                            name="month"
                          >
                          <option value=""></option>
                            <option
                              v-for="monthyear in monthYear"
                              :value="monthyear.month"
                              selected
                            >
                              {{ monthyear.month }}
                            </option>
                          </select>
                              <ErrorComponent input="manager"></ErrorComponent>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                        <div class="col-12  mt-1 mb-1 float-right">
                            <button type="submit" @click="close()"  class="btn btn-primary ml-4">
                                  Generate csv
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
  </admin-layout>
</template>

<script>
import moment from 'moment';
import AdminLayout from "../../Layouts/AdminLayout";
import Button from "../../Jetstream/Button";
import Pagination from "../../admin/Pagination";
import { useForm } from "@inertiajs/inertia-vue3";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";
export default {
  name: "show",
  props: [
    "employee",
    "address",
    "redate",
    "absent",
    "monthYear",
    "employeeRecord",
    "accounts",
    "lateMinute",
    "overtimeMinute",
    "present",
    "absent",
    "employeeDocuments",
    "params",
  ],

  components: {
    Button,
    AdminLayout,
    Pagination,
    ConfirmatiomModal,
  },

  setup() {
    const form = useForm({
      month: "",
    });
    return { form };
  },

  data() {
    return {
      query: {
        query: "",
        id: false,
        date: false,
        on_duty_at: false,
        clock_in_at: false,
        short_minutes: false,
        clock_out_at: false,
        late_minutes: false,
        overtime_minutes: false,
        work_time_minutes: false,
        enable: false,
        disable: false,
        direction: null,
      },
      sweetAlert: false,
      itemId: "",
      searchItem: false,
    };
  },

  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Employees";
    this.form.month = this.redate;
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
    refreshData() {
      this.$inertia.visit(route("employees.show", this.employee.id), {
        method: "get",
        data: {
          dates: this.form.month,
        },
      });
    },
close(){
      $("#exportattendence").modal("hide");
      },
        DateOfBirth(date) {
                return moment(String(date)).format('DD/MM/YYYY')
         },
    resetQuery() {
      this.query = {};
      this.loadData();
    },

    Clicked() {
      this.sweetAlert = false;
    },

    deleteItem() {
      this.sweetAlert = false;
      if (this.itemId){
        this.$inertia.delete(`/erp/employees-record/${this.itemId}`);
      }else{
        this.$inertia.delete(`/erp/document/delete/${this.documentId}`);
      }
    },
    confirmDelete(id) {
      this.sweetAlert = true;
      this.itemId = id;
    },
    confirmDeletedocument(id) {
      this.sweetAlert = true;
      this.documentId = id;
    },

    stopPropagation(e) {
      e.stopPropagation();
    },

    resetFilter() {
      this.query = {};
      this.query.id = "";
      this.query.name = "";
      this.query.employee_id = "";
      this.loadData();
    },

  check_one: function () {
      if ((this.query.date = false)) {
        this.query.date = true;
        this.query.clock_in_at = [];
        this.query.clock_out_at = [];
        this.query.late_minutes = [];
        this.query.overtime_minutes = [];
        this.query.short_minutes = [];
        this.query.work_time_minutes = [];
      }
      if ((this.query.clock_in_at = false)) {
       this.query.clock_in_at = true;
        this.query.date = [];
        this.query.clock_out_at = [];
        this.query.late_minutes = [];
        this.query.overtime_minutes = [];
        this.query.short_minutes = [];
        this.query.work_time_minutes = [];
      }
      if ((this.query.clock_out_at = false)) {
       this.query.clock_out_at = true;
        this.query.clock_in_at = [];
        this.query.date = [];
        this.query.late_minutes = [];
        this.query.overtime_minutes = [];
        this.query.short_minutes = [];
        this.query.work_time_minutes = [];
      }
      if ((this.query.late_minutes = false)) {
        this.query.late_minutes = true;
        this.query.clock_in_at = [];
        this.query.clock_out_at = [];
        this.query.date = [];
        this.query.overtime_minutes = [];
        this.query.short_minutes = [];
        this.query.work_time_minutes = [];
      }
      if ((this.query.overtime_minutes = false)) {
        this.query.overtime_minutes = true;
        this.query.clock_in_at = [];
        this.query.clock_out_at = [];
        this.query.late_minutes = [];
        this.query.date = [];
        this.query.short_minutes = [];
        this.query.work_time_minutes = [];
      }
      if ((this.query.short_minutes = false)) {
       this.query.short_minutes = true;
        this.query.clock_in_at = [];
        this.query.clock_out_at = [];
        this.query.late_minutes = [];
        this.query.overtime_minutes = [];
        this.query.date = [];
        this.query.work_time_minutes = [];
      }
      if ((this.query.work_time_minutes = false)) {
        this.query.work_time_minutes = true;
        this.query.clock_in_at = [];
        this.query.clock_out_at = [];
        this.query.late_minutes = [];
        this.query.overtime_minutes = [];
        this.query.short_minutes = [];
        this.query.date = [];
      }
    },
    resetSort(e) {
      this.query = {};
      this.query.direction = "";
      this.query.id = "";
      this.query.date = "";
      this.query.on_duty_at = "";
      this.query.clock_in_at = "";
      this.query.clock_out_at = "";
      this.query.short_minutes ="",
      this.query.late_minutes = "";
      this.query.overtime_minutes = "";
      this.query.work_time_minutes = "";
      this.query.created_at = "";
      this.query.disable = "";
      this.loadData();
    },

    fileType(title) {
      return title.split(".")[1];
    },

    search() {
      this.searchItem = true;
      this.loadData();
    },

    filter() {
      this.loadData();
    },

    sort(direction) {
      this.query.direction = direction;
      this.loadData();
    },

    loadData() {
      let query = {};
      for (let item in this.query) {
        if (this.query[item]) {
          Object.assign(query, { [item]: this.query[item] });
        }
      }
      this.$inertia.visit(route("employees.show", this.employee.id), {
        method: "get",
        data: {
          ...query,
        },
      });
    },

    formatDate(date) {
      return moment(date).format("DD/MM/YYYY");
    },
  },
};
</script>

<style scoped>

.card {
  border: 1px solid #d2d6dc;
  border-radius: 0px !important;
}

.img {
  height: 480px;
  display: block;
  margin-left: auto;
  margin-top: auto;
  margin-right: auto;
}

.card-one {
  border: 1px solid #d2d6dc;
  border-bottom: 0px;
}

table thead th {
  vertical-align: bottom;
  border-bottom: 1px solid #d2d6dc;
}

.row1 {
  margin-left: 1.3px;
  margin-right: 1.3px;
}

.ml1 {
  margin-left: 4px;
}
.name-header {
  padding-left: 90px;
}
.cardcustom {
  margin-left: 25px;
  margin-right: 25px;
}
@media (max-width: 600px) {
  .sort-dropdown {
    width: 100% !important;
    padding-left: 11px !important;
    padding-right: 0px !important;
    padding-top: 15px !important;
  }
  #strButton {
    margin-right: 215px;
  }

  #order1 {
 margin-top:20px;
    order: 1;
  }
  #order2 {
    order: 2;
  }
}
</style>
