<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
       <div class="content-header row">
        			</div>
        <div class="content-body">
				<!-- Dashboard Ecommerce Starts -->
        <section id="dashboard-ecommerce">
          <div class="row">
            <!-- Greetings Content Starts -->
            <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
              <div class="card">
                <div class="card-header">
                  <h3 class="greeting-text">Congratulations John!</h3>
                  <p class="mb-0">Best seller of the month</p>
                </div>
                <div class="card-body pt-0">
                  <div class="d-flex justify-content-between align-items-end">
                  <div class="dashboard-content-left">
                      <h1 class="text-primary font-large-2 text-bold-500">$89k</h1>
                      <p>You have done 57.6% more sales today.</p>
                      <button type="button" class="btn btn-primary glow">View Sales</button>
                    </div>
                    <div class="dashboard-content-right">
                      <img src="/images/icon/cup.png" height="220" width="220" class="img-fluid" alt="Dashboard Ecommerce">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Multi Radial Chart Starts -->
            <div class="col-xl-4 col-md-6 col-12 dashboard-visit">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Visits of 2020</h4>
                  <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                </div>
                <div class="card-body" style="position: relative;">
                    <div id="Radialbars" style="min-height: 200.7px;">
                          <RadialBars></RadialBars>
                   </div>
                 
                  <ul class="list-inline text-center mt-1 mb-0">
                    <li class="mr-2"><span class="bullet bullet-xs bullet-primary mr-50"></span>Target</li>
                    <li class="mr-2"><span class="bullet bullet-xs bullet-danger mr-50"></span>Mart</li>
                    <li><span class="bullet bullet-xs bullet-warning mr-50"></span>Ebay</li>
                  </ul>
                <div class="resize-triggers"><div class="expand-trigger"><div style="width: 449px; height: 263px;"></div></div><div class="contract-trigger"></div></div></div>
              </div>
            </div>
            <div class="col-xl-4 col-12 dashboard-users">
              <div class="row  ">
                <!-- Statistics Cards Starts -->
                <div class="col-12">
                  <div class="row">
                    <div class="col-sm-6 col-12 dashboard-users-success">
                      <div class="card text-center">
                        <div class="card-body py-1">
                          <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                            <i class="bx bx-briefcase-alt font-medium-5"></i>
                          </div>
                          <div class="text-muted line-ellipsis">New Products</div>
                          <h3 class="mb-0">1.2k</h3>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-12 dashboard-users-danger">
                      <div class="card text-center">
                        <div class="card-body py-1">
                          <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                            <i class="bx bx-user font-medium-5"></i>
                          </div>
                          <div class="text-muted line-ellipsis">New Users</div>
                          <h3 class="mb-0">45.6k</h3>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-12 col-lg-6 col-12 dashboard-revenue-growth">
                      <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center pb-0">
                          <h4 class="card-title">Revenue Growth</h4>
                          <div class="d-flex align-items-end justify-content-end">
                            <span class="mr-25">$25,980</span>
                            <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                          </div>
                        </div>
                        <div class="card-body pb-0" style="position: relative;">
                          <div id="revenue-growth-chart" style="min-height: 115px;">
                        </div>
                        <div class="resize-triggers"><div class="expand-trigger"><div style="width: 449px; height: 116px;"></div></div><div class="contract-trigger"></div></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Revenue Growth Chart Starts -->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-8 col-12 dashboard-order-summary">
              <div class="card">
                <div class="row">
                  <!-- Order Summary Starts -->
                  <div class="col-md-8 col-12 order-summary border-right pr-md-0">
                    <div class="card mb-0">
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Order Summary</h4>
                        <div class="d-flex">
                          <button id="orderSummaryLastMonthButton" type="button" class="btn btn-sm btn-light-primary mr-1" @click="orderSummaryMonth('Last Month')">Last Month</button>
                          <button id="orderSummaryThisMonthButton" type="button" class="btn btn-sm btn-primary glow" @click="orderSummaryMonth('This Month')">This Month</button>
                        </div>
                      </div>
                      <div class="card-body p-0" style="position: relative;">
                         <div id="AreaSeries" style="min-height: 200.7px;">
                          <AreaSeries :dateRange="lastMonthDateRange" :chartData="lastMonthChartData" :month="month" v-if="month==='Last Month'"></AreaSeries>
                          <AreaSeries :dateRange="dateRange" :chartData="chartData" :month="month" v-else></AreaSeries>
                   </div>
                      <!-- <apexchart type="area" height="250" :options="AreachartOptions" :series="Areaseries"></apexchart> -->
                      <div class="resize-triggers"><div class="expand-trigger"><div style="width: 622px; height: 271px;"></div></div><div class="contract-trigger"></div></div></div>
                    </div>
                  </div>
                  <!-- Sales History Starts -->
                  <div class="col-md-4 col-12 pl-md-0">
                    <div class="card mb-0">
                      <div class="card-header pb-50">
                        <h4 class="card-title">Best Sellers</h4>
                      </div>
                      <div class="card-body py-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                          <div class="sales-item-name">
                            <p class="mb-0">iPhone</p>
                            <small class="text-muted">Smartphone</small>
                          </div>
                          <h6 class="mb-0">794</h6>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                          <div class="sales-item-name">
                            <p class="mb-0">Airpods</p>
                            <small class="text-muted">Earphone</small>
                          </div>
                          <h6 class="mb-0">550</h6>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="sales-item-name">
                            <p class="mb-0">MacBook</p>
                            <small class="text-muted">Laptop</small>
                          </div>
                          <h6 class="mb-0">271</h6>
                        </div>
                      </div>
                      <div class="card-footer border-top pb-md-0">
                        <h5>Total Sales</h5>
                        <span class="text-primary text-bold-500">$82,950.96</span>
                        <div class="progress progress-bar-primary progress-sm mt-50 mb-md-50">
                          <div class="progress-bar" role="progressbar" aria-valuenow="78" style="width:78%"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Latest Update Starts -->
            <div class="col-xl-4 col-md-6 col-12 dashboard-latest-update">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center pb-50">
                  <h4 class="card-title">Latest Update</h4>
                  <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButtonSec" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      2020
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButtonSec">
                      <a class="dropdown-item" href="javascript:;">2020</a>
                      <a class="dropdown-item" href="javascript:;">2019</a>
                      <a class="dropdown-item" href="javascript:;">2018</a>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0 pb-1 ps ps--active-y">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                      <div class="list-left d-flex">
                        <div class="list-icon mr-1">
                          <div class="avatar bg-rgba-primary m-0">
                            <div class="avatar-content">
                              <i class="bx bxs-zap text-primary font-size-base"></i>
                            </div>
                          </div>
                        </div>
                        <div class="list-content">
                          <span class="list-title">Total Products</span>
                          <small class="text-muted d-block">2k New Products</small>
                        </div>
                      </div>
                      <span>10k</span>
                    </li>
                    <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                      <div class="list-left d-flex">
                        <div class="list-icon mr-1">
                          <div class="avatar bg-rgba-info m-0">
                            <div class="avatar-content">
                              <i class="bx bx-stats text-info font-size-base"></i>
                            </div>
                          </div>
                        </div>
                        <div class="list-content">
                          <span class="list-title">Total Sales</span>
                          <small class="text-muted d-block">39k New Sales</small>
                        </div>
                      </div>
                      <span>26M</span>
                    </li>
                    <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                      <div class="list-left d-flex">
                        <div class="list-icon mr-1">
                          <div class="avatar bg-rgba-danger m-0">
                            <div class="avatar-content">
                              <i class="bx bx-credit-card text-danger font-size-base"></i>
                            </div>
                          </div>
                        </div>
                        <div class="list-content">
                          <span class="list-title">Total Revenue</span>
                          <small class="text-muted d-block">43k New Revenue</small>
                        </div>
                      </div>
                      <span>15M</span>
                    </li>
                    <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                      <div class="list-left d-flex">
                        <div class="list-icon mr-1">
                          <div class="avatar bg-rgba-success m-0">
                            <div class="avatar-content">
                              <i class="bx bx-dollar text-success font-size-base"></i>
                            </div>
                          </div>
                        </div>
                        <div class="list-content">
                          <span class="list-title">Total Cost</span>
                          <small class="text-muted d-block">Total Expenses</small>
                        </div>
                      </div>
                      <span>2B</span>
                    </li>
                    <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                      <div class="list-left d-flex">
                        <div class="list-icon mr-1">
                          <div class="avatar bg-rgba-primary m-0">
                            <div class="avatar-content">
                              <i class="bx bx-user text-primary font-size-base"></i>
                            </div>
                          </div>
                        </div>
                        <div class="list-content">
                          <span class="list-title">Total Users</span>
                          <small class="text-muted d-block">New Users</small>
                        </div>
                      </div>
                      <span>2k</span>
                    </li>
                    <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                      <div class="list-left d-flex">
                        <div class="list-icon mr-1">
                          <div class="avatar bg-rgba-danger m-0">
                            <div class="avatar-content">
                              <i class="bx bx-edit-alt text-danger font-size-base"></i>
                            </div>
                          </div>
                        </div>
                        <div class="list-content">
                          <span class="list-title">Total Visits</span>
                          <small class="text-muted d-block">New Visits</small>
                        </div>
                      </div>
                      <span>46k</span>
                    </li>
                  </ul>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 280px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 185px;"></div></div></div>
              </div>
            </div>
            <!-- Earning Swiper Starts -->
            <div class="col-xl-4 col-md-6 col-12 dashboard-earning-swiper" id="widget-earnings">
              <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                  <h5 class="card-title"><i class="bx bx-dollar font-medium-5 align-middle"></i> <span class="align-middle">Stocks</span></h5>
                  <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                </div>
                <div class="card-body py-1 px-0">
                  <!-- earnings swiper starts -->
                  <div class="widget-earnings-swiper swiper-container p-1 swiper-container-initialized swiper-container-horizontal">
                    <div class="swiper-wrapper" id="swiper-wrapper-3adbde76679fdd97" aria-live="polite" style="transition: all 0ms ease 0s; transform: translate3d(-279.942px, 0px, 0px);">
                      <div class="swiper-slide rounded swiper-shadow py-50 px-2 d-flex align-items-center" id="repo-design" role="group" aria-label="1 / 5" style="margin-right: 30px;">
                        <i class="bx bx-pyramid mr-1 font-weight-normal font-medium-4"></i>
                        <div class="swiper-text">
                          <div class="swiper-heading">Stock</div>
                          <!-- <small class="d-block">Gitlab</small> -->
                        </div>
                      </div>
                      <div class="swiper-slide rounded swiper-shadow py-50 px-2 d-flex align-items-center swiper-slide-prev" id="laravel-temp" role="group" aria-label="2 / 5" style="margin-right: 30px;">
                        <i class="bx bx-sitemap mr-50 font-large-1"></i>
                        <div class="swiper-text">
                          <div class="swiper-heading">Designer</div>
                          <small class="d-block">Women Clothes</small>
                        </div>
                      </div>
                      <div class="swiper-slide rounded swiper-shadow py-50 px-2 d-flex align-items-center" id="repo-design" role="group" aria-label="1 / 5" style="margin-right: 30px;">
                        <i class="bx bx-pyramid mr-1 font-weight-normal font-medium-4"></i>
                        <div class="swiper-text">
                          <div class="swiper-heading">Stock</div>
                          <!-- <small class="d-block">Gitlab</small> -->
                        </div>
                      </div>
                      <div class="swiper-slide rounded swiper-shadow py-50 px-2 d-flex align-items-center swiper-slide-next" id="ux-developer" role="group" aria-label="4 / 5" style="margin-right: 30px;">
                        <i class="bx bx-devices mr-50 font-large-1"></i>
                        <div class="swiper-text">
                          <div class="swiper-heading">Admin Template</div>
                          <small class="d-block">Global Network</small>
                        </div>
                      </div>
                      <div class="swiper-slide rounded swiper-shadow py-50 px-2 d-flex align-items-center" id="marketing-guide" role="group" aria-label="5 / 5" style="margin-right: 30px;">
                        <i class="bx bx-book-bookmark mr-50 font-large-1"></i>
                        <div class="swiper-text">
                          <div class="swiper-heading">Marketing Guide</div>
                          <small class="d-block">Books</small>
                        </div>
                      </div>
                    </div>
                  <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                  <!-- earnings swiper ends -->
                </div>
                <div class="main-wrapper-content" style="height: 286px;overflow: scroll;">
                  <div class="wrapper-content" data-earnings="repo-design">
                    <div class="widget-earnings-scroll table-responsive ps">
                      <table class="table table-borderless widget-earnings-width mb-0">
                        <tbody>
                          <tr v-for="product in products">
                            <td class="w-50">
                              <div class="media align-items-center">
                                <a class="media-left mr-50" href="javascript:;">
                                  <img  :src="product.image ? $page.props.base_path + product.image : '/img/avator.jpg'" alt="avatar" class="rounded-circle" height="30" width="30" :style="'border: 3.5px solid '+colors[product.name]+';'">
                                </a>
                                <div class="media-body">
                                  <h6 class="media-heading mb-0">{{product.name}}</h6>
                                  <!-- <span class="font-small-2">Designer</span> -->
                                </div>
                              </div>
                            </td>
                            <td class="px-0" style="width: 25%;">
                              <div class="progress progress-bar-info" id="stockProgressBar">
                                <div v-if="product.prodcut_stock" class="progress-bar" id="div1" role="progressbar" :style="'width:'+(product.prodcut_stock.quantity/productsTotalQuantity)*stockProgressBarWidth+'px; background-color:'+colors[product.name]+';'"></div>
                              </div>
                            </td>
                               <td class="text-truncate text-center" style="width: 25%;">
                                <span>
                                <span class="badge badge-light-danger">
                                        {{ product.prodcut_stock ? product.prodcut_stock.quantity : 0 }}
                                 </span>
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
            <!-- shipments Starts -->

            <div class="col-xl-8 col-12 dashboard-marketing-campaign">
              <div class="card marketing-campaigns">
                <div class="card-header d-flex justify-content-between align-items-center pb-1">
                  <h4 class="card-title">Shipments Arriving</h4>
                  <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                </div>
                <div class="card-body pb-0">
                  <div class="row mb-1">
                    <div class="col-md-9 col-12">
                      <div class="d-inline-block">
                        <!-- chart-1   -->
                        <div class="d-flex market-statistics-1" style="position: relative;">
                         <div id="DonutChart">
                          <DonutChart :donatChartType="'#FDAC41'"></DonutChart>
                           </div>
                          <div class="statistics-data my-auto">
                            <div class="statistics">
                              <span class="font-medium-2 mr-50 text-bold-600">25,756</span><span class="text-success">(+16.2%)</span>
                            </div>
                            <div class="statistics-date">
                              <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                              <small class="text-muted">May 12, 2020</small>
                            </div>
                          </div>
                          <div class="resize-triggers"><div class="expand-trigger"><div style="width: 224px; height: 55px;"></div></div><div class="contract-trigger"></div></div></div>
                      </div>
                      <div class="d-inline-block">
                        <!-- chart-2 -->
                        <div class="d-flex mb-75 market-statistics-2" style="position: relative;">
                         <div id="DonutChart" >
                          <DonutChart :donatChartType="'#009A17'"></DonutChart>
                           </div>
                          <div class="statistics-data my-auto">
                            <div class="statistics">
                              <span class="font-medium-2 mr-50 text-bold-600">5,352</span><span class="text-danger">(-4.9%)</span>
                            </div>
                            <div class="statistics-date">
                              <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                              <small class="text-muted">Jul 26, 2020</small>
                            </div>
                          </div>
                          <div class="resize-triggers"><div class="expand-trigger"><div style="width: 201px; height: 55px;"></div></div><div class="contract-trigger"></div></div></div>
                      </div>
                    </div>
                    <div class="col-md-3 col-12 text-md-right">
                      <button class="btn btn-sm btn-primary glow mt-md-2 mb-1"><a  :style="{color: ' #FFFFFF'}"
                        :href="route('shipments.index')">View All Shipments</a></button>
                                                                         
                    </div>
                  </div>
                </div>
                <div class="table-responsive ps" style="height: 320px;overflow: scroll;">
                  <!-- table start -->
                  <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
                    <thead>
                    <tr>
                      <th>Container #</th>
                      <th>Contents</th>
                      <th>UK ETA</th>
                      <th>Actual Arrival Date</th>
                      <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(shipment, index) in shipments">
                        <td  class="py-1 line-ellipsis">
                        <span id="login" :data-toggle="shipment.id" data-container="body" data-boundary="window"
                            data-html="true" data-placement="bottom" href="#" type="button"
                            @click="showTooltip(shipment.id)">
                            <span class="underline-dotted border-gray">
                                {{ shipment.container_number }}
                            </span>
                        </span>
                        <div class="container">
                            <div :id="'popover-content-'+shipment.id" class="d-none">
                                <div class="row custom-popover popover-max">
                                    <div class="col-12 px-2">

                                        <span v-if="shipment.container_number">
                                            <p class="py-0 mb-0 small">
                                                <strong>Departure Port:</strong>
                                                {{ shipment.departure_port }}
                                            </p>
                                            <p class="py-0 mb-0 small">
                                                <strong>Shipping Line:</strong>
                                                {{ shipment.shipping_line }}
                                            </p>
                                            <p class="py-0 mb-0 small">
                                                <strong>booking Number:</strong>
                                                {{ shipment.booking_number }}
                                            </p>

                                            <p class="py-0 mb-0 small">
                                                <strong>Container Number:</strong>
                                                {{ shipment.container_number }}
                                            </p>
                                            <p class="py-0 mb-0 small">
                                                <strong>Bill of lading:</strong>
                                                {{ shipment.bill_of_lading_number }}
                                            </p>
                                            <p class="py-0 mb-0 small">
                                                <strong>Seal Number:</strong>
                                                {{ shipment.container_seal_number }}
                                            </p>
                                            <p class="py-0 mb-0 small">
                                                <strong>Load Date:</strong>
                                                {{ shipment.load_date }}
                                            </p>
                                            <p class="py-0 mb-0 small">
                                                <strong>Vessel Etd:</strong>
                                                {{ shipment.vessel_etd }}
                                            </p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </td>
                       <td class="py-1" @mouseout="hideTooltip(shipment.id)">
                        <span :data-toggle="'receiver'+shipment.id" data-container="body" data-boundary="window"
                            data-html="true" data-placement="bottom" type="button"
                            @click="showReceiverTooltip(shipment.id)"
                            @mouseenter="hideTooltip(shipment.id)">


                            <span v-if="shipment.shipment_items.length>0"
                                class="underline-dotted border-gray">

                                {{
                                shipment.shipment_items[0].product ?
                                shipment.shipment_items[0].product.name : ''
                                +
                                shipment.shipment_items[0] ?
                                shipment.shipment_items[0].quantity_ordered : ''
                                }}

                            </span>

                        </span>
                        <div class="container">
                            <div :id="'popover-receiver-content-'+shipment.id" class="d-none">
                                <div class="row custom-popover popover-max">
                                    <div class="col-12 px-2">
                                        <span v-for="item in shipment.shipment_items">
                                            <span class="font-weight-bold h5 mb-1 small">
                                                Products Name and Quantity Orders
                                            </span>

                                            <p class="py-0 mb-0 small">
                                                {{
                                                  item.product ?   
                                                item.product.name + " x " + item.quantity_ordered: ''
                                                }}
                                            </p>
                                        </span>
                                         <span>
                                            <span class="font-weight-bold h5 mb-1 small">
                                                Total Quantity
                                            </span>

                                            <p class="py-0 mb-0 small">
                                                {{ sum(index) }}
                                            </p>


                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>

                         </td>
                      <td class="py-1"> {{ formatDate(shipment.uk_eta) }}</td>
                      <td class="py-1"> {{ formatDate(shipment.actual_arrival_date) }}</td>
                      <td class="text-center py-1">
                        <div class="dropdown">
                          <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" :href="route('shipments.edit', shipment.id)"><i
                                class="bx bx-edit-alt mr-1"></i>Edit</a>
                              <a class="dropdown-item" :href="route('shipment.delete', shipment.id)"><i
                                                            class="bx bx-trash mr-1"></i>Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>

                    </tbody>
                  </table>
                  <!-- table ends -->
                  <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
              </div>
            </div>   
            </div>
        </section>
<!-- Dashboard Ecommerce ends -->
		   	</div>

    </admin-layout>
</template>

<script>
 import moment from 'moment';
import AppLayout from './../Layouts/AppLayout';
import AdminLayout from "../Layouts/AdminLayout";
import RadialBars from "./../admin/RadialBars";
import AreaSeries from "./../admin/AreaSeries";
import DonutChart from "./../admin/DonutChart";


       export default {
        name: "Dashboard",
        props: ["products","productsTotalQuantity","shipments","colors","dateRange","chartData"],
        components: {
            AdminLayout,
            AppLayout,
            RadialBars,
            AreaSeries,
            DonutChart,
        },
      data(){
              var $primary = '#5A8DEE';
              var $danger = '#FF5B5C';
              var $warning = '#FDAC41';
              var $info = '#00CFDD';
              var $secondary = '#828D99';
              var $secondary_light = '#e7edf3';
              var $light_primary = "#E2ECFF";
      return {
        stockProgressBarWidth : 0,
        lastMonthDateRange: [],
        lastMonthChartData: [],
        month: 'This Month',
          }
          
        }, 

      mounted(){
        var $primary = '#5A8DEE';
        var $danger = '#FF5B5C';
        var $warning = '#FDAC41';
        var $info = '#00CFDD';
        var $secondary = '#828D99';
        var $secondary_light = '#e7edf3';
        var $light_primary = "#E2ECFF";

        var div = document.getElementById('div1');

        
    // revenue charts
    
        var revenueChartOptions = {
          chart: {
            height: 100,
            type: 'bar',
            stacked: true,
            toolbar: {
              show: false
            }
          },
          grid: {
            show: false,
            padding: {
              left: 0,
              right: 0,
              top: -20,
              bottom: -15
            }
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '20%',
              endingShape: 'rounded'
            },
          },
          legend: {
            show: false
          },
          dataLabels: {
            enabled: false
          },
          colors: [$info, $secondary_light],
          series: [{
            name: '2020',
            data: [50, 70, 100, 120, 140, 100, 70, 80, 90, 110, 50, 70, 35, 110, 100, 105, 125, 80]
          }, {
            name: '2019',
            data: [70, 50, 20, 30, 20, 90, 90, 60, 50, 0, 50, 60, 140, 50, 20, 20, 10, 0]
          }],
          xaxis: {
            categories: ['0', '', '', '', '', "10", '', '', '', '', '', '15', '', '', '', '', '', '20'],
            axisBorder: {
              show: false
            },
            axisTicks: {
              show: false
            },
            labels: {
              style: {
                colors: $secondary
              },
              offsetY: -5
            }
          },
          yaxis: {
            show: false,
            floating: true,
          },
          
          tooltip: {
            x: {
              show: false,
            },
          }
        }
        var revenueChart = new ApexCharts(
          document.querySelector("#revenue-growth-chart"),
          revenueChartOptions
        );
        revenueChart.render();

        // var multiRadialOptions = {
        //   chart: {
        //     height: 210,
        //     type: "radialBar",
        //   },
        //   colors: [$primary, $danger, $warning],
        //   series: [75, 80, 85],
        //   plotOptions: {
        //     radialBar: {
        //       offsetY: -10,
        //       hollow: {
        //         size: "40%"
        //       },
        //       track: {
        //         margin: 10,
        //         background: '#fff',
        //       },
        //       dataLabels: {
        //         name: {
        //           fontSize: '15px',
        //           colors: [$secondary],
        //           fontFamily: "IBM Plex Sans",
        //           offsetY: 25,
        //         },
        //         value: {
        //           fontSize: '30px',
        //           fontFamily: "Rubik",
        //           offsetY: -15,
        //         },
        //         total: {
        //           show: true,
        //           label: 'Total Visits',
        //           fontSize: '15px',
        //           fontWeight: 400,
        //           fontFamily: "IBM Plex Sans",
        //           color: $secondary
        //         }
        //       }
        //     }
        //   },
        //   stroke: {
        //     lineCap: "round",
        //   },
        //   labels: ['Target', 'Mart', 'Ebay']
        // };
        // var multiradialChart = new ApexCharts(
        //   document.querySelector("#multi-radial-chart"),
        //   multiRadialOptions
        // );
        // multiradialChart.render();
        
        var swiperLength = $(".swiper-slide").length;
        if (swiperLength) {
          swiperLength = Math.floor(swiperLength / 2)
        }

        // Swiper js for this page
        var mySwiper = new Swiper('.widget-earnings-swiper', {
          slidesPerView: 'auto',
          initialSlide: swiperLength,
          centeredSlides: true,
          spaceBetween: 30,
          // active slide on click
          slideToClickedSlide: true,
        });
        

        activeSlide(swiperLength);

        // Active slide change on swipe
        mySwiper.on('slideChange', function () {
          activeSlide(mySwiper.realIndex);
        });

        //add class active content of active slide
        function activeSlide(index) {
          var slideEl = mySwiper.slides[index]
          var slideId = $(slideEl).attr('id');
          $(".wrapper-content").removeClass("active");
          $("[data-earnings=" + slideId + "]").addClass('active')
        };
        if ($('.marketing-campaigns .table-responsive').length > 0) {
          var user_details = new PerfectScrollbar('.marketing-campaigns .table-responsive');
        }

       this.stockProgressBarWidth = document.getElementById('stockProgressBar').getBoundingClientRect().width;
        
        // this.stockProgressBarWidth = document.getElementById('stockProgressBar').getBoundingClientRect().width;
        // alert(this.stockProgressBarWidth);
      },
      methods: {
          orderSummaryMonth(month) {
            if(month === 'Last Month') {
              $('#orderSummaryLastMonthButton').removeClass('btn-light-primary');
              $('#orderSummaryLastMonthButton').addClass('btn-primary');
              $('#orderSummaryThisMonthButton').removeClass('btn-primary');
              $('#orderSummaryThisMonthButton').addClass('btn-light-primary');
              axios.get('order-summary-chart')
                  .then((response) => {
                    this.lastMonthDateRange = response.data.dateRange;
                    this.lastMonthChartData = response.data.chartData;
                    this.month = month;
                  });
            }
            else {
              $('#orderSummaryThisMonthButton').removeClass('btn-light-primary');
              $('#orderSummaryThisMonthButton').addClass('btn-primary');
              $('#orderSummaryLastMonthButton').removeClass('btn-primary');
              $('#orderSummaryLastMonthButton').addClass('btn-light-primary');
              this.lastMonthDateRange = [];
              this.lastMonthChartData = [];
              this.month = month;
            }
          },
          Clicked() {
              this.sweetAlert = false;
          },
          deleteItem() {
              this.sweetAlert = false;
              this.$inertia.delete(`/shipments/${this.itemId}`);
          },
          confirmDelete(id) {
              this.sweetAlert = true;
              this.itemId = id;
          },   
          formatDate(date) {
              if (date) {
                  return moment(date).format('DD/MM/YYYY');
              } else {
                  return '...';
              }
          },
            sum(index) {
            let sum = 0;
            for (
                let i = 0;
                i < this.shipments[index].shipment_items.length;
                i++
            ) {
                sum =
                    sum + this.shipments[index].shipment_items[i].quantity_ordered;
            }
            return sum;
        },
            showReceiverTooltip(id) {
                if (this.receiver_id == null) {
                    this.receiver_id = id;

                    $("[data-toggle=receiver" + id + "]").popover({
                        html: true,

                        content: function () {
                            return $("#popover-receiver-content-" + id).html();
                        },
                    });

                    $("[data-toggle=receiver" + id + "]").popover("show");
                } else if (this.receiver_id == id) {
                    $("[data-toggle=receiver" + this.receiver_id + "]").popover("dispose");

                    this.receiver_id = null;
                } else {
                    $("[data-toggle=receiver" + this.receiver_id + "]").popover("dispose");

                    this.receiver_id = id;

                    $("[data-toggle=receiver" + id + "]").popover({
                        html: true,

                        content: function () {
                            return $("#popover-receiver-content-" + id).html();
                        },
                    });

                    $("[data-toggle=receiver" + id + "]").popover("show");
                }
            },

            hideTooltip(id) {
                $("[data-toggle=" + this.id + "]").popover("dispose");

                $("[data-toggle=receiver" + this.receiver_id + "]").popover("dispose");

                this.receiver_id = null;

                this.id = null;
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
        
      },
    }
</script>

<style scoped>

</style>
