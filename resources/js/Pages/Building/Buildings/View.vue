<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts" >
                <div class="row match-height">
                    <div class="col-12 ">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <div class="row">
                                    <div class="col-10 pt-1">
                                        <h6 class="invoice-from ">
                                            <img src="/img/building1.svg" alt="Building" class="building-icons">Building: {{building.code}}
                                        </h6>
                                    </div>
                                    <div class="col-2">
                                        <div class="invoice-action-btn pb-0 mb-0">
                                            <a :href="route('building.edit',building.id)">
                        <span class="badge-circle badge-circle-light-secondary  action ml-auto">
                          <i class="bx bx-edit font-medium-1 align-items-center text-center"></i>
                        </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class=" pb-1">
                                    <hr class="line" />
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-12 mb-1">
                                        <h6 v-if="building.name">Name</h6>
                                        <p title="length-height-width" v-if="building.name">{{(building.name)}}</p>
                                        <h6 class="invoice-from">Address</h6>
                                        <p>{{building.address_1}} {{building.address_2}}, {{building.city}}, {{building.state}},
                                            {{building.zip_code}}, {{building.country}}</p>
                                        <h6 class="invoice-from">Phone</h6>
                                        <p>{{building.phone}} </p>
                                        <h6 class="invoice-from">Dimension</h6>
                                        <p title="length-height-width">{{roundValue(building.length)}}m x {{roundValue(building.height)}}m x
                                            {{roundValue(building.width)}}m
                                        </p>
                                        <h6 class="invoice-from">Volume</h6>
                                        <p>{{roundValue(building.volume)}} m<sup>3</sup> </p>
                                        <h6 class="">Occupied</h6>
                                        <p v-if='building.is_occupied'>Yes</p>
                                        <p v-else>No</p>
                                    </div>
                                    <div
                                        class="user-profile-images col-md-4 col-12 d-flex align-items-center justify-content-center mb-2 flex-column">
                                        <div>
                                            <qrcode-vue :value="value" :size="150" level="H" foreground="#000000" />
                                        </div>
                                        <div :style="myBackgroundColor" class="mt-1">
                                            <h6 class="text-white" style="padding: 8px 65px 0px 65px;">{{building.code}}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" px-2">
                                <h6>Building Plan</h6>
                            </div>
                            <div class=" pb-0.5 px-2">
                                <hr class="line" />
                            </div>
                            <div class="col-12">
                                <div class=" ">
                                    <div class="card-content plan">
                                        <div class="">
                                            <table class="table table-hover mb-0" style="height:160px;">
                                                <!-- <tbody> -->
                                                <div
                                                    class="col-md-3 col-lg-2 col-6  d-inline-block text-truncate align-bottom buildingName  dimension pl-3 ">
                                                    Code
                                                </div>
                                                <div
                                                    class="d-inline-block col-lg-2 col-md-3 col-6 location buildingName text-left  text-truncate align-bottom dimension">
                                                    Location</div>
                                                <div
                                                    class="d-lg-inline-block d-none col-lg-2  buildingName text-center text-truncate align-bottom dimension pr-3"
                                                    title="length-height-width" @click="hideTooltipActionSection(section.id)">
                                                    Dimention</div>
                                                <div class=" d-inline-block col-md-2 col-4 buildingName text-right px-lg-4  px-md-2 pl-sm-4">
                                                </div>
                                                <!-- /////First/// -->
                                                <div v-for='section in building.sections' :key='section.id'>
                                                    <div class="collapsible collapse-icon accordion-icon-rotate border-0">
                                                        <div class="card collapse-header border-0 mb-0 mt-0">
                                                            <div id="headingCollapse8" class="card-header collapsed pl-0 "
                                                                 style="padding-top: 0px;padding-bottom: 10px;" aria-controls="collapse4">
                                <span class="collapse-title">
                                  <span class="align-middle ">
                                    <div class="col-md-3 col-lg-2 col-6  d-inline-block  "> <span
                                        data-placement="bottom" :data-toggle='section.id+"section"'
                                        @click="showTooltipSection(section.id)"
                                        @mouseleave="hideTooltipSection(section.id)" data-container="body" type="button"
                                        data-html="true" href="#" id="login">
                                        <span class=" border-gray  buildingName text-truncate "><img
                                            src="/img/section1.svg" alt="Sections" class="building-icons"><span
                                            class="underline-dotted">
                                            Section
                                            {{section.code}} <span v-if="section.name">({{section.name}})</span></span>
                                        </span></span>
                                      <div class="container">
                                        <div :id="'popover-content-section-'+section.id" class="d-none">
                                          <div class="row custom-popover popover-max">
                                            <div class="col-12 px-2 ">
                                              <span>
                                                <span class="font-weight-bold h5 mb-1 small">
                                                  Volume
                                                </span>
                                                <p class="py-0 mb-0 small ">
                                                  {{roundValue(section.volume)}} m<sup>3</sup>
                                                </p>
                                              </span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div
                                        class="d-inline-block col-lg-2 col-md-3 col-6 buildingName text-left text-truncate align-bottom dimension"
                                        title="location" @click="hideTooltipActionSection(section.id)">
                                      {{building.code}}-{{section.code}}</div>
                                    <div
                                        class="d-lg-inline-block d-none col-lg-2  buildingName text-center text-truncate align-bottom dimension"
                                        title="length-height-width" @click="hideTooltipActionSection(section.id)">
                                      {{roundValue(section.length)}}m x {{roundValue(section.height)}}m x
                                      {{roundValue(section.width)}}m</div>
                                    <div
                                        class=" d-inline-block col-md-2 col-4 buildingName text-right px-lg-4  px-md-2 "
                                        @click="hideTooltipActionSection(section.id)">
                                      <span>
                                        <div class="progress  px-0 btn-light-secondary   "
                                             :title="'Occupied '+ progessRating(section.aisles)+'%'">
                                          <div class="progress-bar" role="progressbar"
                                               :style="{width:progessRating(section.aisles)+'%',backgroundColor:`${progessColor(section.aisles)}`}">
                                          </div>
                                        </div>
                                      </span>
                                    </div>
                                    <div
                                        class="d-inline-block col-md-2 col-4 buildingName text-center  align-bottom dimension pl-md-5"
                                        title="Status" @click="hideTooltipActionSection(section.id)">
                                      <p class=" mb-0 small badge badge-light-success badge-pill  status">
                                        Active
                                      </p>
                                        <!-- <p class=" mb-0 small badge badge-light-danger badge-pill  status" v-else>
                                          Inactive
                                        </p> -->
                                    </div>
                                    <div class=" d-inline-block col-md-2 col-4 custom-padding-right action ">
                                      <div class="dropdown dropleft">
                                        <span class="badge-circle badge-circle-light-secondary ml-auto "
                                              id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                              aria-expanded="false">
                                          <svg type="button" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                               fill="currentColor" class="bi bi-three-dots " viewBox="0 0 16 16">
                                            <path
                                                d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                          </svg></span><span data-toggle="collapse" role="button"
                                                             v-bind:data-target='"#collapse1"+section.id' aria-expanded="false"
                                                             @click="hideTooltipActionSection(section.id)"></span>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                          <div class="container">
                                            <div class="row custom-popover popover-max">
                                              <div class="col-12 p-0 m-0">
                                                <div class="d-flex flex-column px-1">
                                                  <div class="d-flex flex-row">
                                                    <inertia-link
                                                        :href="route('section.show',[building.code,section.code])">
                                                      <span class="badge-circle badge-circle-light-secondary action ">
                                                        <i
                                                            class="bx bxs-show font-medium-1 align-items-center mx-1"></i>
                                                      </span>
                                                    </inertia-link>
                                                    <p class=" ml-1 small action-text mb-0 ">View Section</p>
                                                  </div>
                                                  <div class="d-flex flex-row">
                                                    <inertia-link
                                                        :href="route('section.create',{'building_id':building.id})">
                                                      <span class="badge-circle badge-circle-light-secondary action ">
                                                        <img src="/img/section1.svg" alt="Sections"
                                                             class=" align-items-center icons">
                                                      </span>
                                                    </inertia-link>
                                                    <p class="ml-1 small action-text mb-0 ">Add Section</p>
                                                  </div>
                                                  <div class="d-flex flex-row my-0.5">
                                                    <button
                                                        v-on:click="confirmDelete('section',section.id + '-'+ building.code)">
                                                      <span class="badge-circle badge-circle-light-secondary">
                                                        <i class="bx bx-trash font-medium-1 text-center mx-1"></i>
                                                      </span>
                                                    </button>
                                                    <p class=" small action-text mb-0 delete-section">Delete Section</p>
                                                  </div>
                                                  <hr class="m-0">
                                                  <div class="d-flex flex-row mt-0.5 ">
                                                    <inertia-link
                                                        :href="route('aisle.create',{'building_code':building.code,'section_id':section.id})">
                                                      <span class="badge-circle badge-circle-light-secondary action ">
                                                        <img src="/img/aisle1.svg" alt="Aisle"
                                                             class=" align-items-center icons">
                                                      </span>
                                                    </inertia-link>
                                                    <p class=" ml-1 small action-text mb-0">Add Aisle</p>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </span>
                                </span>
                                                            </div>
                                                            <div v-bind:id='"collapse1"+section.id' role="tabpanel" aria-labelledby="headingCollapse8"
                                                                 class="collapse" style="">
                                                                <div class="card-body pl-0 pr-0 pt-0 pb-0">
                                                                    <!-- ////SECOND -->
                                                                    <div v-for='aisle in section.aisles' :key='aisle.id'>
                                                                        <div class="collapsible collapse-icon accordion-icon-rotate ">
                                                                            <div class="card collapse-header border-0 mb-0 mt-0">
                                                                                <div id="headingCollapse8" class="card-header collapsed pl-0 "
                                                                                     style="padding-top: 0px;padding-bottom: 10px;" aria-controls="collapse4">
                                          <span class="collapse-title">
                                            <span class="align-middle ">
                                              <div class="col-md-3 col-lg-2 col-6 aisle  d-inline-block"> <span
                                                  data-placement="bottom" :data-toggle='aisle.id+"aisle"'
                                                  @click="showTooltipAisle(aisle.id)"
                                                  @mouseleave="hideTooltipAisle(aisle.id)" data-container="body"
                                                  type="button" data-html="true" href="#" id="login">
                                                  <span class=" border-gray  buildingName text-truncate "><img
                                                      src="/img/aisle1.svg" alt="Aisle" class="building-icons"><span
                                                      class="underline-dotted">
                                                      Aisle
                                                      {{aisle.code}} <span
                                                      v-if="aisle.name">({{aisle.name}})</span></span>
                                                  </span></span>
                                                <div class="container">
                                                  <div :id="'popover-content-aisle-'+aisle.id" class="d-none">
                                                    <div class="row custom-popover popover-max">
                                                      <div class="col-12 px-2">
                                                        <span>
                                                          <span class="font-weight-bold h5 mb-1 small">
                                                            Volume
                                                          </span>
                                                          <p class="py-0 mb-0 small ">
                                                            {{roundValue(aisle.volume)}} m<sup>3</sup>
                                                          </p>
                                                        </span>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <div
                                                  class="d-inline-block col-lg-2 col-md-3 col-6 buildingName text-left text-truncate align-bottom dimension"
                                                  title="location" @click="hideTooltipActionAisle(aisle.id)">
                                                {{building.code}}-{{section.code}}-{{aisle.code}}</div>
                                              <div
                                                  class="d-lg-inline-block d-none col-lg-2  buildingName text-center text-truncate align-bottom dimension"
                                                  title="length-height-width" @click="hideTooltipActionAisle(aisle.id)">
                                                {{roundValue(aisle.length)}}m x {{roundValue(aisle.height)}}m x
                                                {{roundValue(aisle.width)}}m</div>
                                              <div
                                                  class=" d-inline-block col-md-2 col-4 buildingName text-center px-lg-4  px-md-2 "
                                                  @click="hideTooltipActionAisle(aisle.id)">
                                                <span>
                                                  <div class="progress  px-0 btn-light-secondary "
                                                       :title="'Occupied '+ progessRating(aisle.bays)+'%'">
                                                    <div class="progress-bar" role="progressbar"
                                                         :style="{width:progessRating(aisle.bays)+'%',backgroundColor:`${progessColor(aisle.bays)}`}">
                                                    </div>
                                                  </div>
                                                </span>
                                              </div>
                                              <div
                                                  class="d-inline-block col-md-2 col-4 buildingName text-center  align-bottom dimension pl-md-5"
                                                  title="Status" @click="hideTooltipActionAisle(aisle.id)">
                                                <!-- <p class=" mb-0 small badge badge-light-success badge-pill  status"
                                                  v-if='aisle.is_active'>
                                                  Active
                                                </p>
                                                <p class=" mb-0 small badge badge-light-danger badge-pill  status"
                                                  v-else>
                                                  Inactive
                                                </p> -->
                                              </div>
                                              <div class=" d-inline-block col-md-2 col-4 custom-padding-right action ">
                                                <div class="dropdown dropleft">
                                                  <span class="badge-circle badge-circle-light-secondary ml-auto "
                                                        id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <svg type="button" xmlns="http://www.w3.org/2000/svg" width="20"
                                                         height="20" fill="currentColor" class="bi bi-three-dots "
                                                         viewBox="0 0 16 16">
                                                      <path
                                                          d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                                    </svg></span><span data-toggle="collapse" role="button"
                                                                       v-bind:data-target='"#collapse2"+aisle.id'
                                                                       aria-expanded="false"></span>
                                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                    <div class="container">
                                                      <div class="row custom-popover popover-max">
                                                        <div class="col-12 p-0 m-0">
                                                          <div class="d-flex flex-column px-1">
                                                            <div class="d-flex flex-row">
                                                              <inertia-link
                                                                  :href="route('aisle.show',[building.code,section.code,aisle.code])">
                                                                <span
                                                                    class="badge-circle badge-circle-light-secondary action  ">
                                                                  <i
                                                                      class="bx bxs-show font-medium-1 align-items-center mx-1"></i>
                                                                </span>
                                                              </inertia-link>
                                                              <p class=" ml-1 small action-text mb-0">View Aisle</p>
                                                            </div>
                                                            <div class="d-flex flex-row my-0.5">
                                                              <button
                                                                  v-on:click="confirmDelete('aisle',aisle.id + '-'+building.code)">
                                                                <span class="badge-circle badge-circle-light-secondary">
                                                                  <i
                                                                      class="bx bx-trash font-medium-1 text-center mx-1"></i>
                                                                </span>
                                                              </button>
                                                              <p class=" ml-1 small action-text mb-0">Delete Aisle</p>
                                                            </div>
                                                            <hr class="m-0">
                                                            <div class="d-flex flex-row mt-0.5 ">
                                                              <inertia-link
                                                                  :href="route('bay.create',{'building_code':building.code,'aisle_id':aisle.id})">
                                                                <span
                                                                    class="badge-circle badge-circle-light-secondary action ">
                                                                  <img src="/img/bay1.svg" alt="Bay"
                                                                       class=" align-items-center icons">
                                                                </span>
                                                              </inertia-link>
                                                              <p class="ml-1 small action-text mb-0">Add Bay</p>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </span>
                                          </span>
                                                                                </div>
                                                                                <div v-bind:id='"collapse2"+aisle.id' role="tabpanel"
                                                                                     aria-labelledby="headingCollapse8" class="collapse" style="">
                                                                                    <div class="card-body pt-0 pr-0 pl-0 pb-0">
                                                                                        <!-- ////Third -->
                                                                                        <div v-for='bay in aisle.bays' :key='bay.id'>
                                                                                            <div class="collapsible collapse-icon accordion-icon-rotate">
                                                                                                <div class="card collapse-header border-0 mb-0 mt-0">
                                                                                                    <div id="headingCollapse8" class="card-header collapsed pl-0 pb-0.5"
                                                                                                         style="padding-top: 0px;padding-bottom: 10px;"
                                                                                                         aria-controls="collapse4">
                                                    <span class="collapse-title">
                                                      <span class="align-middle ">
                                                        <div class="col-md-3 col-lg-2 col-6 bay d-inline-block "> <span
                                                            data-placement="bottom" :data-toggle='bay.id+"bay"'
                                                            @click="showTooltipBay(bay.id)"
                                                            @mouseleave="hideTooltipBay(bay.id)" data-container="body"
                                                            type="button" data-html="true" href="#" id="login">
                                                            <span class=" border-gray  buildingName text-truncate "><img
                                                                src="/img/bay1.svg" alt="Aisle"
                                                                class="building-icons"><span class="underline-dotted">
                                                                Bay
                                                                {{bay.code}} <span
                                                                v-if="bay.name">({{bay.name}})</span></span>
                                                            </span>
                                                          </span>
                                                          <div class="container">
                                                            <div :id="'popover-content-bay-'+bay.id" class="d-none">
                                                              <div class="row custom-popover popover-max">
                                                                <div class="col-12 px-2">
                                                                  <span>
                                                                    <span>
                                                                      <span class="font-weight-bold h5 mb-1 small">
                                                                        Volume
                                                                      </span>
                                                                      <p class="py-0 mb-0 small ">
                                                                        {{roundValue(bay.volume)}} m<sup>3</sup>
                                                                      </p>
                                                                      <span class="font-weight-bold h5 mb-1 small">
                                                                        Max Weight
                                                                      </span>
                                                                      <p class="py-0 mb-0 small">
                                                                        {{ bay.max_weight }}
                                                                      </p>
                                                                    </span>
                                                                  </span>

                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <div
                                                            class="d-inline-block col-lg-2 col-md-3 col-6  buildingName text-left text-truncate align-bottom dimension"
                                                            title="location" @click="hideTooltipActionBay(bay.id)">
                                                          {{building.code}}-{{section.code}}-{{aisle.code}}-{{bay.code}}
                                                        </div>
                                                        <div
                                                            class="d-lg-inline-block d-none col-lg-2 buildingName text-center text-truncate align-bottom dimension"
                                                            title="length-height-width"
                                                            @click="hideTooltipActionBay(bay.id)">
                                                          {{roundValue(bay.length)}}m x {{roundValue(bay.height)}}m x
                                                          {{roundValue(bay.width)}}m
                                                        </div>
                                                        <div
                                                            class=" d-inline-block col-md-2 col-4 buildingName text-center px-lg-4  px-md-2 "
                                                            @click="hideTooltipActionBay(bay.id)">
                                                          <span>
                                                            <div class="progress  px-0 btn-light-secondary "
                                                                 :title="'Occupied '+ progessRating(bay.levels)+'%'">
                                                              <div class="progress-bar" role="progressbar"
                                                                   :style="{width:progessRating(bay.levels)+'%',backgroundColor:`${progessColor(bay.levels)}`}">
                                                              </div>
                                                            </div>
                                                          </span>
                                                        </div>
                                                        <div
                                                            class="d-inline-block col-md-2 col-4 buildingName text-center  align-bottom dimension pl-md-5"
                                                            title="Status" @click="hideTooltipActionBay(bay.id)">
                                                          <!-- <p class=" mb-0 small badge badge-light-success badge-pill  status"
                                                            v-if='bay.is_active'>
                                                            Active
                                                          </p>
                                                          <p class=" mb-0 small badge badge-light-danger badge-pill  status"
                                                            v-else>
                                                            Inactive
                                                          </p> -->
                                                        </div>
                                                        <div
                                                            class=" d-inline-block col-md-2 col-4 custom-padding-right action ">
                                                          <div class="dropdown dropleft">
                                                            <span
                                                                class="badge-circle badge-circle-light-secondary ml-auto "
                                                                id="dropdownMenuButton3" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                              <svg type="button" xmlns="http://www.w3.org/2000/svg"
                                                                   width="20" height="20" fill="currentColor"
                                                                   class="bi bi-three-dots " viewBox="0 0 16 16">
                                                                <path
                                                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                                              </svg></span><span data-toggle="collapse" role="button"
                                                                                 v-bind:data-target='"#collapse3"+bay.id'
                                                                                 aria-expanded="false"></span>
                                                            <div class="dropdown-menu"
                                                                 aria-labelledby="dropdownMenuButton3">
                                                              <div class="container">
                                                                <div class="row custom-popover popover-max">
                                                                  <div class="col-12 p-0 m-0">
                                                                    <div class="d-flex flex-column px-1">
                                                                      <div class="d-flex flex-row">
                                                                        <inertia-link
                                                                            :href="route('bay.show',[building.code,section.code,aisle.code,bay.code])">
                                                                          <span
                                                                              class="badge-circle badge-circle-light-secondary action  ">
                                                                            <i
                                                                                class="bx bxs-show font-medium-1 align-items-center mx-1"></i>
                                                                          </span>
                                                                        </inertia-link>
                                                                        <p class=" ml-1 small action-text mb-0">View Bay
                                                                        </p>
                                                                      </div>
                                                                      <div class="d-flex flex-row my-0.5">
                                                                        <button
                                                                            v-on:click="confirmDelete('bay',bay.id + '-'+building.code)">
                                                                          <span
                                                                              class="badge-circle badge-circle-light-secondary">
                                                                            <i
                                                                                class="bx bx-trash font-medium-1 text-center mx-1"></i>
                                                                          </span>
                                                                        </button>
                                                                        <p class=" ml-1 small action-text mb-0">Delete
                                                                          Bay
                                                                        </p>
                                                                      </div>
                                                                      <hr class="m-0">
                                                                      <div class="d-flex flex-row  mt-0.5">
                                                                        <inertia-link
                                                                            :href="route('level.create',{'building_code':building.code,'bay_id':bay.id})">
                                                                          <span
                                                                              class="badge-circle badge-circle-light-secondary action ">
                                                                            <img src="/img/level1.svg" alt="Level"
                                                                                 class=" align-items-center icons">
                                                                          </span>
                                                                        </inertia-link>
                                                                        <p class="ml-1 small action-text mb-0">Add Level
                                                                        </p>
                                                                      </div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </span>
                                                    </span>
                                                                                                    </div>
                                                                                                    <div v-bind:id='"collapse3"+bay.id' role="tabpanel"
                                                                                                         aria-labelledby="headingCollapse8" class="collapse" style="">
                                                                                                        <div class="card-body pt-0 pr-0 pl-0 pb-0">
                                                                                                            <!-- ////Fourth -->

                                                                                                            <div v-for='level in bay.levels' :key='level.id'>

                                                                                                                <div class="collapsible collapse-icon accordion-icon-rotate">
                                                                                                                    <div class="card collapse-header border-0 mb-0 mt-0">
                                                                                                                        <div id="headingCollapse8"
                                                                                                                             class="card-header collapsed pl-0 "
                                                                                                                             style="padding-top: 0px;padding-bottom: 10px;"
                                                                                                                             aria-controls="collapse4">
                                                              <span class="collapse-title">
                                                                <span class="align-middle ">
                                                                  <div
                                                                      class="col-md-3 col-lg-2 col-6 level d-inline-block ">
                                                                    <span data-placement="bottom"
                                                                          :data-toggle='level.id+"level"'
                                                                          @click="showTooltipLevel(level.id)"
                                                                          @mouseleave="hideTooltipLevel(level.id)"
                                                                          data-container="body" type="button"
                                                                          data-html="true" href="#" id="login">
                                                                      <span
                                                                          class=" border-gray  buildingName text-truncate "><img
                                                                          src="/img/level1.svg" alt="Aisle"
                                                                          class="building-icons"><span
                                                                          class="underline-dotted">
                                                                          Level
                                                                          {{level.code}} <span
                                                                          v-if="level.name">({{level.name}})</span></span>
                                                                      </span>
                                                                    </span>
                                                                    <div class="container">
                                                                      <div :id="'popover-content-level-'+level.id"
                                                                           class="d-none">
                                                                        <div class="row custom-popover popover-max">
                                                                          <div class="col-12 px-2">
                                                                            <span
                                                                                class="font-weight-bold h5 mb-1 small">
                                                                              Volume
                                                                            </span>
                                                                            <p class="py-0 mb-0 small">
                                                                              {{roundValue(level.volume)}} m<sup>3</sup>
                                                                            </p>
                                                                            <span>
                                                                              <span
                                                                                  class="font-weight-bold h5 mb-1 small">
                                                                                Max Weight
                                                                              </span>
                                                                              <p class="py-0 mb-0 small">
                                                                                {{ level.max_weight }}
                                                                              </p>
                                                                            </span>
                                                                          </div>
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                  </div>
                                                                  <div
                                                                      class="d-inline-block col-lg-2 col-md-3 col-6 buildingName text-left text-truncate align-bottom dimension"
                                                                      title="location"
                                                                      @click="hideTooltipActionLevel(level.id)">
                                                                    {{building.code}}-{{section.code}}-{{aisle.code}}-{{bay.code}}-{{level.code}}
                                                                  </div>
                                                                  <div
                                                                      class="d-lg-inline-block d-none col-lg-2 buildingName text-center text-truncate align-bottom dimension"
                                                                      title="length-height-width"
                                                                      @click="hideTooltipActionLevel(level.id)">
                                                                    {{roundValue(level.length)}}m x
                                                                    {{roundValue(level.height)}}m x
                                                                    {{roundValue(level.width)}}m</div>
                                                                  <div
                                                                      class=" d-inline-block col-md-2 col-4 buildingName text-center px-lg-4  px-md-2 "
                                                                      @click="hideTooltipActionLevel(level.id)">
                                                                    <div class="progress  px-0 btn-light-secondary "
                                                                         :title="'Occupied '+ progessRating(level.bins)+'%'">
                                                                      <div class="progress-bar" role="progressbar"
                                                                           :style="{width:progessRating(level.bins)+'%',backgroundColor:`${progessColor(level.bins)}`}">
                                                                      </div>
                                                                    </div>
                                                                  </div>
                                                                  <div
                                                                      class="d-inline-block col-md-2 col-4 buildingName text-center  align-bottom dimension pl-md-5"
                                                                      title="Status"
                                                                      @click="hideTooltipActionLevel(level.id)">
                                                                  </div>
                                                                  <div
                                                                      class=" d-inline-block col-md-2 col-4 custom-padding-right action ">
                                                                    <div class="dropdown dropleft">
                                                                      <span
                                                                          class="badge-circle badge-circle-light-secondary ml-auto "
                                                                          id="dropdownMenuButton4" data-toggle="dropdown"
                                                                          aria-haspopup="true" aria-expanded="false">
                                                                        <svg type="button"
                                                                             xmlns="http://www.w3.org/2000/svg" width="20"
                                                                             height="20" fill="currentColor"
                                                                             class="bi bi-three-dots " viewBox="0 0 16 16">
                                                                          <path
                                                                              d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                                                        </svg></span><span data-toggle="collapse"
                                                                                           role="button"
                                                                                           v-bind:data-target='"#collapse4"+level.id'
                                                                                           aria-expanded="false"></span>
                                                                      <div class="dropdown-menu"
                                                                           aria-labelledby="dropdownMenuButton4">
                                                                        <div class="container">
                                                                          <div class="row custom-popover popover-max">
                                                                            <div class="col-12 p-0 m-0">
                                                                              <div class="d-flex flex-column px-1">
                                                                                <div class="d-flex flex-row">
                                                                                  <inertia-link
                                                                                      :href="route('level.show',[building.code,section.code,aisle.code,bay.code,level.code])">
                                                                                    <span
                                                                                        class="badge-circle badge-circle-light-secondary action  ">
                                                                                      <i
                                                                                          class="bx bxs-show font-medium-1 align-items-center mx-1"></i>
                                                                                    </span>
                                                                                  </inertia-link>
                                                                                  <p
                                                                                      class=" ml-1 small action-text mb-0">
                                                                                    View Level
                                                                                  </p>
                                                                                </div>
                                                                                <div class="d-flex flex-row my-0.5">
                                                                                  <button
                                                                                      v-on:click="confirmDelete('level',level.id + '-'+building.code)">
                                                                                    <span
                                                                                        class="badge-circle badge-circle-light-secondary">
                                                                                      <i
                                                                                          class="bx bx-trash font-medium-1 text-center mx-1"></i>
                                                                                    </span>
                                                                                  </button>
                                                                                  <p
                                                                                      class="ml-1 small action-text mb-0">
                                                                                    Delete Level</p>
                                                                                </div>
                                                                                <hr class="m-0">
                                                                                <div class="d-flex flex-row mt-0.5 ">
                                                                                  <inertia-link
                                                                                      :href="route('bin.create',{'building_code':building.code,'level_id':level.id})">
                                                                                    <span
                                                                                        class="badge-circle badge-circle-light-secondary action ">
                                                                                      <img src="/img/bin1.svg" alt="Bin"
                                                                                           class=" align-items-center icons">
                                                                                    </span>
                                                                                  </inertia-link>
                                                                                  <p
                                                                                      class=" ml-1 small action-text mb-0">
                                                                                    Add Bin</p>
                                                                                </div>
                                                                              </div>
                                                                            </div>
                                                                          </div>

                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                  </div>
                                                                </span>
                                                              </span>
                                                                                                                        </div>
                                                                                                                        <div v-bind:id='"collapse4"+level.id' role="tabpanel"
                                                                                                                             aria-labelledby="headingCollapse8" class="collapse"
                                                                                                                             style="">
                                                                                                                            <div class="card-body pt-0 pr-0 pl-0 pb-0">
                                                                                                                                <!-- ////Fifth -->

                                                                                                                                <div v-for='bin in level.bins' :key='bin.id'>

                                                                                                                                    <div
                                                                                                                                        class="collapsible collapse-icon accordion-icon-rotate">
                                                                                                                                        <div
                                                                                                                                            class="card collapse-header border-0 mb-0 mt-0">
                                                                                                                                            <div id="headingCollapse8"
                                                                                                                                                 class="card-header collapsed pl-0 pb-0.5"
                                                                                                                                                 style="padding-top: 0px;padding-bottom: 10px;"
                                                                                                                                                 aria-controls="collapse4">
                                                                        <span class="collapse-title">
                                                                          <span class="align-middle ">
                                                                            <div
                                                                                class="col-md-3 col-lg-2 col-6 bin  d-inline-block ">
                                                                              <span data-placement="bottom"
                                                                                    :data-toggle='bin.id+"bin"'
                                                                                    data-container="body" type="button"
                                                                                    data-html="true" href="#" id="login">
                                                                                <span
                                                                                    class=" border-gray  buildingName text-truncate "><img
                                                                                    src="/img/bin1.svg" alt="Bin"
                                                                                    class="building-icons"><span>
                                                                                    Bin
                                                                                    {{bin.code}} <span
                                                                                    v-if="bin.name">({{bin.name}})</span></span>
                                                                                </span>
                                                                              </span>
                                                                            </div>
                                                                            <div
                                                                                class="d-inline-block col-lg-2 col-md-3 col-6 buildingName text-left text-truncate align-bottom dimension"
                                                                                title="location">
                                                                              {{building.code}}-{{section.code}}-{{aisle.code}}-{{bay.code}}-{{level.code}}-{{bin.code}}
                                                                            </div>
                                                                            <div
                                                                                class="d-lg-inline-block d-none col-lg-2 buildingName text-center align-bottom dimension text-truncate"
                                                                                title="length-height-width">
                                                                              {{roundValue(bin.length)}}m x
                                                                              {{roundValue(bin.height)}}m x
                                                                              {{roundValue(bin.width)}}m</div>
                                                                            <div
                                                                                class="d-inline-block col-md-2 col-4 buildingName text-center text-truncate align-bottom dimension"
                                                                                title="Volume">
                                                                              {{roundValue(bin.volume)}} m<sup>3</sup>
                                                                            </div>
                                                                            <div
                                                                                class=" d-inline-block col-md-2 col-4  buildingName text-center pl-md-5"
                                                                                title="Status">
                                                                            </div>
                                                                            <div
                                                                                class=" d-inline-block col-md-2 col-4 custom-padding-right action ">
                                                                              <div class="dropdown dropleft">
                                                                                <span
                                                                                    class="badge-circle badge-circle-light-secondary ml-auto "
                                                                                    id="dropdownMenuButton5"
                                                                                    data-toggle="dropdown"
                                                                                    aria-haspopup="true"
                                                                                    aria-expanded="false">
                                                                                  <svg type="button"
                                                                                       xmlns="http://www.w3.org/2000/svg"
                                                                                       width="20" height="20"
                                                                                       fill="currentColor"
                                                                                       class="bi bi-three-dots "
                                                                                       viewBox="0 0 16 16">
                                                                                    <path
                                                                                        d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                                                                  </svg></span>
                                                                                <div class="dropdown-menu"
                                                                                     aria-labelledby="dropdownMenuButton5">
                                                                                  <div class="container">
                                                                                    <div
                                                                                        class="row custom-popover popover-max">
                                                                                      <div class="col-12 p-0 m-0">
                                                                                        <div
                                                                                            class="d-flex flex-column px-1">
                                                                                          <div class="d-flex flex-row">
                                                                                            <inertia-link
                                                                                                :href="route('bin.show',[building.code,section.code,aisle.code,bay.code,level.code,bin.code])">
                                                                                              <span
                                                                                                  class="badge-circle badge-circle-light-secondary action  ">
                                                                                                <i
                                                                                                    class="bx bxs-show font-medium-1 align-items-center mx-1"></i>
                                                                                              </span>
                                                                                            </inertia-link>
                                                                                            <p
                                                                                                class="ml-1 small action-text mb-0">
                                                                                              View Bin</p>
                                                                                          </div>
                                                                                          <div
                                                                                              class="d-flex flex-row my-0.5 ">
                                                                                            <button
                                                                                                v-on:click="confirmDelete('bin', bin.id + '-' + building.code)">
                                                                                              <span
                                                                                                  class="badge-circle badge-circle-light-secondary">
                                                                                                <i
                                                                                                    class="bx bx-trash font-medium-1 text-center mx-1"></i>
                                                                                              </span>
                                                                                            </button>
                                                                                            <p
                                                                                                class="ml-1 small action-text mb-0">
                                                                                              Delete Bin</p>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>
                                                                                  </div>
                                                                                </div>
                                                                              </div>
                                                                            </div>
                                                                          </span>
                                                                        </span>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>

                                                                                                                                <!-- Fifth  END -->
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                            <!-- Fourth  END -->
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Third  END -->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- ////END -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- </tbody> -->

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                <inertia-link :href="route('building.index')" type="button"
                                              class="btn btn-light-secondary mb-2 mt-2 ml-2">
                                    Back
                                </inertia-link>
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
import moment from 'moment';
import AdminLayout from "../../../Layouts/AdminLayout";
import JetInputError from ".././../../Jetstream/InputError";
import ConfirmatiomModal from "../../SweetAlert/ConfirmatiomModal";
import QrcodeVue from 'qrcode.vue';

export default {
    name: "View",
    props: ["building", "settings"],
    components: {
        AdminLayout,
        JetInputError,
        ConfirmatiomModal,
        QrcodeVue,
    },
    data() {
        return {
            id: null,
            sweetAlert: false,
            itemId: "",
            controller: "",
            progessValue: 0,
            value: '',
            myBackgroundColor: {
                backgroundColor: "#000000"
            }
        };
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Building Details";
        this.value = window.location.href
    },
    methods: {
        submit() { },

        progessRating(data) {
            if (data.length == 0) {

                return 0;
            } else {
                let total = 0;
                data.forEach(function (item) {
                    if (item.is_occupied == 1) {
                        total++;
                    }
                })
                var count = data.length;

                return parseInt((total / count) * 100);
            }
        },

        Clicked() {
            this.sweetAlert = false;
        },

        deleteItem() {
            this.sweetAlert = false;
            this.$inertia.delete(`/fulfilment/admin/${this.controller}/${this.itemId}`);
        },

        confirmDelete(controller, id) {
            this.sweetAlert = true;
            this.itemId = id;
            this.controller = controller
        },

        progessColor(data) {
            let total = 0;
            data.forEach(function (item) {
                if (item.is_occupied == 1) {
                    total++;
                }
            })
            var count = data.length;
            var percentage = parseInt((total / count) * 100);

            return this.pickColor(percentage);
        },

        pickColor(percentage) {
            if (percentage >= 0 && percentage < 60) {

                return this.colorValue("low");
            } else if (percentage >= 60 && percentage < 75) {

                return this.colorValue("medium");
            } else {

                return this.colorValue("high");
            }
        },

        colorValue(status) {
            switch (status) {
                case "low":
                    let low = this.settings.find(setting => setting.slug === "low");

                    return String(low.value);
                    break;
                case "medium":
                    let medium = this.settings.find(setting => setting.slug === "medium");

                    return String(medium.value);
                    break;
                case "high":
                    let high = this.settings.find(setting => setting.slug === "high");

                    return String(high.value);
                    break;
            }
        },
        roundValue(val) {
            let num = val;
            if ((num / Math.round(val)) == 1) {
                return Math.round(val);
            } else {
                return val;
            }
        },
        showTooltipSection(id) {
            if (this.id == null) {
                this.id = id;
                $("[data-toggle=" + id + "section" + "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-section-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "section" + "]").popover('show')
            } else if (this.id == id) {
                $("[data-toggle=" + this.id + "section" + "]").popover('dispose');
                this.id = null;
            } else {
                $("[data-toggle=" + this.id + "section" + "]").popover('dispose');
                this.id = id;
                $("[data-toggle=" + id + "section" + "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-section-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "section" + "]").popover('show')
            }
        },

        hideTooltipSection(id) {
            $("[data-toggle=" + this.id + "section" + "]").popover('dispose');
            this.id = null;
        },

        showTooltipAisle(id) {
            if (this.id == null) {
                this.id = id;
                $("[data-toggle=" + id + "aisle" + "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-aisle-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "aisle" + "]").popover('show')
            } else if (this.id == id) {
                $("[data-toggle=" + this.id + "aisle" + "]").popover('dispose');
                this.id = null;
            } else {
                $("[data-toggle=" + this.id + "aisle" + "]").popover('dispose');
                this.id = id;
                $("[data-toggle=" + id + "aisle" + "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-aisle-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "aisle" + "]").popover('show')
            }
        },

        hideTooltipAisle(id) {
            $("[data-toggle=" + this.id + "aisle" + "]").popover('dispose');
            this.id = null;
        },

        showTooltipBay(id) {
            if (this.id == null) {
                this.id = id;
                $("[data-toggle=" + id + "bay" + "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-bay-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "bay" + "]").popover('show')
            } else if (this.id == id) {
                $("[data-toggle=" + this.id + "bay" + "]").popover('dispose');
                this.id = null;
            } else {
                $("[data-toggle=" + this.id + "bay" + "]").popover('dispose');
                this.id = id;
                $("[data-toggle=" + id + "bay" + "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-bay-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "bay" + "]").popover('show')
            }
        },

        hideTooltipBay(id) {
            $("[data-toggle=" + this.id + "bay" + "]").popover('dispose');
            this.id = null;
        },

        showTooltipLevel(id) {
            if (this.id == null) {
                this.id = id;
                $("[data-toggle=" + id + "level" + "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-level-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "level" + "]").popover('show')
            } else if (this.id == id) {
                $("[data-toggle=" + this.id + "level" + "]").popover('dispose');
                this.id = null;
            } else {
                $("[data-toggle=" + this.id + "level" + "]").popover('dispose');
                this.id = id;
                $("[data-toggle=" + id + "level" + "]").popover({
                    html: true,
                    content: function () {
                        return $('#popover-content-level-' + id).html();
                    }
                });
                $("[data-toggle=" + id + "level" + "]").popover('show')
            }
        },

        hideTooltipLevel(id) {
            $("[data-toggle=" + this.id + "level" + "]").popover('dispose');
            this.id = null;
        },
    },
};

</script>

<style scoped>
.line {
    border-top: 1px dashed #c7cfd6;
    width: 100%;
}

.plan {
    margin-left: 6px;
    margin-right: 6px
}

.error {
    margin-top: 0px !important;
}

.buildingName {
    font-size: 15px;
}

.delete-section {
    margin-left: 9px;
}

.aisle {
    padding-left: 30px;
}

.status {
    margin-bottom: 0px;
}

.bay {
    padding-left: 45px;
}

.level {
    padding-left: 65px;
}

.bin {
    padding-left: 85px;
}

.action-space {
    margin: 0px 5px;
}

.action-text {
    padding-top: 8px;
}

.collapse-icon.accordion-icon-rotate [aria-expanded=false]:before {
    transform: rotate(90deg);
    right: -30px;
}

.collapse-icon.accordion-icon-rotate [aria-expanded=true]:before {
    transform: rotate(270deg);
    right: -30px;
}

svg {
    transform: rotate(90deg);
}

.icons {
    padding: 8px 8px
}

.dimension {
    margin-bottom: 5px !important;
}

.action {
    bottom: -5px;
    margin-top: 3px;
}

.btn-light-secondary:hover,
.btn-light-secondary.hover {
    background-color: #F2F4F4 !important;
    color: rgb(0, 0, 0) !important;
}

@media (max-width: 768px) {

    .buildingName {
        font-size: 10px;
    }

    .location {
        padding-left: 0px;
    }

    .status {
        margin-bottom: 6px;
        margin-left: 35%;
    }

    .dimension {
        margin-bottom: 5px !important;
    }
}

@media (max-width: 576px) {
    .badge {
        font-size: 7px;
    }

    .status {
        margin-left: 50%;
    }
}

@media (max-width: 1370px) {
    .aisle {
        padding-left: 20px;
    }

    .bay {
        padding-left: 30px;
    }

    .level {
        padding-left: 40px;
    }

    .bin {
        padding-left: 50px;
    }

    .buildingName {
        font-size: 12px;
    }
}
</style>
