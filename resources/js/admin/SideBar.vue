<template>
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true"
        @mouseenter="modernMenuExpand" @mouseleave="modernMenuCollapse">
        <div class="navbar-header" @mouseenter="modernMenuExpand" @mouseleave="modernMenuCollapse">
            <ul class="nav navbar-nav flex-row">

                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="">
                        <div class="brand-logo">
                            <img alt="Careox" class="logo rounded-circle" src="/images/careox-logo.png">
                        </div>
                        <h2 class="brand-text mb-0">Careox</h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                        <i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i>
                        <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary"
                            data-ticon="bx-disc"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation"
                data-icon-style="lines">
                        <li :class="{ 'active': $page.url === '/dashboard' }">
                            <inertia-link :href="route('dashboard.index')" class="d-flex align-items-center">
                                <i class="menu-livicon livicon-evo-holder" data-icon="desktop"
                            style="visibility: visible; width: 60px;"></i>
                                <span class="menu-item text-truncate">Dashboard</span>
                            </inertia-link>
                        </li>
                  
                <!-- ERP -->
                <li class="navigation-header text-truncate"><span>ERP</span></li>

                <li class="nav-item has-sub"
                    v-if="hasPermission('purchase-orders.index') || hasPermission('suppliers.index') || hasPermission('product-details.index') ||     hasPermission('shipments.index')">
                    <a href="# ">
                        <i class="menu-livicon" data-icon="clapboard"></i>
                        <span class="menu-title text-truncate">SCM</span>
                    </a>
                    <ul class="menu-content" style="">
                        <li
                            :class="currentRoute == 'suppliers.index' || currentRoute == 'suppliers.create' || currentRoute == 'suppliers.edit'|| currentRoute == 'suppliers.show'|| currentRoute == 'invoice.create'|| currentRoute == 'invoice.edit'|| currentRoute == 'invoice.show'|| currentRoute == 'invoice.item.create'|| currentRoute == 'invoice.item.create' ?'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('suppliers.index')" :href="route('suppliers.index')">
                                <i class="bx bxs-group"></i>
                                <span class="menu-item text-truncate">Suppliers</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'product-details.index' || currentRoute == 'product-details.create' || currentRoute == 'product-details.edit' || currentRoute == 'product-details.show'?'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('product-details.index')"
                                :href="route('product-details.index')">
                                <i class="bx bx-purchase-tag"></i>
                                <span class="menu-item text-truncate">Product</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'purchase-orders.index' || currentRoute == 'purchase-orders.create' || currentRoute == 'purchase-orders.edit' || currentRoute == 'purchase-orders.show'  || currentRoute == 'purchase.order.edit.invoice'  || currentRoute == 'purchase.order.create.payment'  || currentRoute == 'purchase.order.edit.payment' ? 'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('purchase-orders.index')"
                                :href="route('purchase-orders.index')">
                                <i class="bx bx-file"></i>
                                <span class="menu-item text-truncate">Purchase Order</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'shipments.index' || currentRoute == 'shipments.create' || currentRoute == 'shipments.edit'|| currentRoute == 'shipments.show' ?'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('shipments.index')" :href="route('shipments.index')">
                                <i class="bx bxs-ship"></i>
                                <span class="menu-item text-truncate">Shipment</span>
                            </inertia-link>
                        </li>
                    </ul>
                </li>
                <li v-if="hasPermission('wowchers.index') || hasPermission('imports.index') ||
                        hasPermission('ejoggas.index') || hasPermission('amazons.index') ||
                        hasPermission('groupon.index') || hasPermission('xstreamgym.index') ||
                        hasPermission('gogroopie.index') || hasPermission('customers.index') ||
                        hasPermission('reviews.index') || hasPermission('orders.index') ||
                        hasPermission('cases.index') || hasPermission('fetch-email.index') ||
                        hasPermission('deliveries.index') || hasPermission('products.index')" class="nav-item has-sub">
                    <a href="# ">
                        <i class="menu-livicon" data-icon="morph-radio-3"></i>
                        <span class="menu-title text-truncate">CRM</span>
                    </a>
                    <ul class="menu-content" style="">
                        <li v-if="hasPermission('customers.index')"
                            :class="currentRoute == 'customers.index'?'active nav-item':'nav-item'">
                            <inertia-link :href="route('customers.index')">
                                <i class="bx bx-user"></i>
                                <span class="menu-item text-truncate">Customers</span>
                            </inertia-link>
                        </li>
                        <li v-if="hasPermission('orders.index')"
                            :class="currentRoute == 'orders.index' || currentRoute == 'orders.edit' || currentRoute == 'orders.show' || currentRoute == 'wowchers.index' || currentRoute == 'ejoggas.index' || currentRoute == 'amazons.index' || currentRoute == 'groupons.index' || currentRoute == 'xstreamgyms.index' || currentRoute == 'gogroopies.index' || currentRoute == 'imports.index' || currentRoute == 'imports.create' ?'active nav-item':'nav-item'">
                            <inertia-link :href="route('orders.index')">
                                <i class="bx bx-package"></i>
                                <span class="menu-item text-truncate">Orders</span>
                            </inertia-link>
                        </li>
                        <li :class="currentRoute == 'products.index'?'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('products.index')" :href="route('products.index')">
                                <i class="bx bx-purchase-tag"></i>
                                <span class="menu-item text-truncate">Products</span>
                            </inertia-link>
                        </li>
                        <li v-if="hasPermission('deliveries.index')"
                            :class="currentRoute == 'deliveries.index'?'active nav-item':'nav-item'">
                            <inertia-link :href="route('deliveries.index')">
                                <i class="bx bxs-truck"></i>
                                <span class="menu-item text-truncate">Deliveries</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'fetch-email.index' || currentRoute == 'fetch.specific.email'  ? 'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('fetch-email.index')" :href="route('fetch-email.index')">
                                <i class="bx bxs-envelope"></i>
                                <span class="menu-item text-truncate">Email</span>
                            </inertia-link>
                        </li>
                        <li v-if="hasPermission('cases.index')"
                            :class="currentRoute == 'cases.index'?'active nav-item':'nav-item'">
                            <inertia-link :href="route('cases.index')">
                                <i class="bx bx-briefcase"></i>
                                <span class="menu-item text-truncate">Cases</span>
                            </inertia-link>
                        </li>
                        <li v-if="hasPermission('reviews.index')"
                            :class="currentRoute == 'reviews.index'|| currentRoute == 'reviews.create'|| currentRoute == 'reviews.edit'?'active nav-item':'nav-item'">
                            <inertia-link :href="route('reviews.index')">
                                <i class="bx bxs-star"></i>
                                <span class="menu-item text-truncate">Reviews</span>
                            </inertia-link>
                        </li>
                    </ul>

                </li>
                <li v-if="hasPermission('invoices.index') || hasPermission('deals.index')" class="nav-item has-sub">
                    <a href="# ">
                        <i class="menu-livicon" data-icon="bank"></i>

                        <span class="menu-title text-truncate">Finance</span>
                    </a>
                    <ul class="menu-content" style="">
                        <li v-if="hasPermission('deals.index')"
                            :class="currentRoute == 'deals.index'?'active nav-item':'nav-item'">
                            <inertia-link :href="route('deals.index')">
                                <i class="bx bx-file" data-v-16459516=""></i>
                                <span class="menu-item text-truncate">Deals</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'invoices.index' ||currentRoute == 'invoices.create' ||currentRoute == 'invoices.edit'  ?'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('invoices.index')" :href="route('invoices.index')">
                                <i class="bx bxl-invision "></i>
                                <span class="menu-item text-truncate">Invoices</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'payments.index' ||currentRoute == 'payments.create' ||currentRoute == 'payments.edit'  ?'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('payments.index')" :href="route('payments.index')">
                                <i class="bx bxl-paypal"></i>
                                <span class="menu-item text-truncate">Payments</span>
                            </inertia-link>
                        </li>
                    </ul>
                </li>
                <li v-if="hasPermission('employees.index') || hasPermission('attendence.create') || hasPermission('attendence.show') || hasPermission('attendence.import.create')"
                    class="nav-item has-sub">
                    <a href="# ">
                        <i class="menu-livicon" data-icon="user"></i>
                        <span class="menu-title text-truncate">HR</span>
                    </a>
                    <ul class="menu-content" style="">

                        <li v-if="hasPermission('attendence.create') || hasPermission('attendence.import.create')"
                            :class="currentRoute == 'attendence.import'|| currentRoute == 'attendence.import.create' ? 'active nav-item':'nav-item'">
                            <inertia-link :href="route('attendence.import.create')">
                                <i class="bx bxs-time"></i>
                                <span class="menu-item text-truncate">Attendance Import</span>
                            </inertia-link>
                        </li>
                        <li :class="currentRoute == 'attendence.show' ? 'active nav-item':'nav-item'">

                              <inertia-link :href="route('attendence.show')">
                                <i class="bx bxs-time"></i>
                                <span class="menu-item text-truncate">Attendance Reports</span>
                            </inertia-link>

                        </li>
                        <li v-if="hasPermission('employees.index')"
                            :class="currentRoute == 'employees.index' || currentRoute == 'employees.edit'||  currentRoute == 'employees.create'|| currentRoute == 'employees.show' ?'active nav-item':'nav-item'">
                            <inertia-link :href="route('employees.index')">
                                <i class="bx bxs-user"></i>
                                <span class="menu-item text-truncate">Employees</span>
                            </inertia-link>
                        </li>
                        <li :class="currentRoute == 'payrolls.index'|| currentRoute == 'payrolls.edit'||  currentRoute == 'payrolls.create'|| currentRoute == 'payrolls.show' ?'active nav-item':'nav-item'">
                            <inertia-link :href="route('payrolls.index')">
                                <i class="bx bx-money"></i>
                                <span class="menu-title text-truncate" data-i18n="payrolls">Payrolls</span>
                            </inertia-link>
                        </li>
                    </ul>
                </li>
                <li v-if="hasPermission('orders.create') || hasPermission('stock-logs.create')"
                    class="nav-item has-sub">
                    <a href="# ">
                        <i class="menu-livicon" data-icon="pie-chart"></i>
                        <span class="menu-title text-truncate">Reports</span>
                    </a>
                    <ul class="menu-content" style="">
                        <li :class="currentRoute == 'sale.report.create' ? 'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('orders.create')" :href="route('sale.report.create')">
                                <i class="bx bx-align-left "></i>
                                <span class="menu-item text-truncate">Sales</span>
                            </inertia-link>
                        </li>
                        <li :class="currentRoute == 'stock.report.create' ? 'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('stock-logs.create')"
                                :href="route('stock.report.create')">
                                <i class="bx bxs-package"></i>
                                <span class="menu-item text-truncate">Stock</span>
                            </inertia-link>
                        </li>
                        <li class="">
                            <inertia-link href=" http://127.0.0.1:8001/app/users/view ">
                                <i class="bx bxs-briefcase"></i>
                                <span class="menu-item text-truncate">Cases</span>
                            </inertia-link>
                        </li>
                    </ul>
                </li>
                <li v-if="hasPermission('logs.index') || hasPermission('user.index') || hasPermission('companies.index') || hasPermission('email-settings.index') ||hasPermission('payment-gateways.index') ||hasPermission('exchanges-rates.index') ||hasPermission('channels.index')"
                    class="nav-item has-sub">
                    <a href="# ">
                        <i class="menu-livicon" data-icon="gear"></i>
                        <span class="menu-title text-truncate">Admin</span>
                    </a>
                    <ul class="menu-content" style="">
                        <li
                            :class="currentRoute == 'company.users.index' || currentRoute == 'company.users.create' || currentRoute == 'company.users.edit' || currentRoute == 'company.users.show' ? 'active nav-item' : 'nav-item'">
                            <inertia-link v-if="hasPermission('user.index')" :href="route('company.users.index')">
                                <i class="bx bxs-user"></i>
                                <span class="menu-item text-truncate">User</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'companies.index' || currentRoute == 'companies.create' || currentRoute == 'companies.edit' || currentRoute == 'companies.show' ?'active nav-item':'nav-item'">
                            <inertia-link
                                v-if="$page.props.user.subscription || is_super || hasPermission('companies.index')"
                                :href="route('companies.index')">
                                <i class="bx bxs-building"></i>
                                <span class="menu-item text-truncate">Companies</span>
                            </inertia-link>
                        </li>
                        <li v-if="hasPermission('email-settings.index')"
                            :class="currentRoute == 'email-settings.index' || currentRoute == 'email-settings.show' || currentRoute == 'email-settings.edit' || currentRoute == 'email-settings.create'?'active nav-item':'nav-item'">
                            <inertia-link :href="route('email-settings.index')">
                                <i class="bx bxs-envelope"></i>
                                <span class="menu-item text-truncate">Email Setting </span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'payment-gateways.index' || currentRoute == 'payment-gateways.create' || currentRoute == 'payment-gateways.edit' ? 'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('payment-gateways.index')"
                                :href="route('payment-gateways.index')">
                                <i class="bx bxs-credit-card"></i>
                                <span class="menu-item text-truncate">Payment Gateways</span>
                            </inertia-link>
                        </li>

                        <li v-if="hasPermission('channels.index')"
                            :class="currentRoute == 'channels.index'?'active nav-item':'nav-item'">
                            <inertia-link :href="route('channels.index')">
                                <i class="bx bx-transfer"></i>
                                <span class="menu-item text-truncate">Channels</span>
                            </inertia-link>
                        </li>
                        <li v-if="is_owner || is_super || hasPermission('subscriptions.index')"
                            :class="$page.props.currentRouteName == 'subscriptions.index'  ?'active nav-item':'nav-item'">
                            <inertia-link :href="route('subscriptions.index')">
                                <i class="bx bxs-collection"></i>
                                <span class="menu-item text-truncate">Subscriptions</span>
                            </inertia-link>
                        </li>
                        <li v-if="hasPermission('logs.index')"
                            :class="$page.props.currentRouteName == 'logs.index'  ?'active nav-item':'nav-item'">
                            <inertia-link :href="route('logs.index')">
                                <i class="bx bx-target-lock"></i>
                                <span class="menu-item text-truncate">Logs</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'stock-logs.index' || currentRoute == 'stock-logs.create' ||currentRoute == 'stock-logs.edit' ? 'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('stock-logs.index')" :href="route('stock-logs.index')">
                                <i class="bx bxs-box"></i>
                                <span class="menu-title" data-i18n="Chat">Stock Log</span>
                            </inertia-link>
                        </li>
                    </ul>
                </li>

                <!-- erp end -->
                <!-- Fulfilment -->
                <li v-if="hasPermission('calendar.index') || hasPermission('product-stocks.index') || hasPermission('warehouse-stocks.index') || hasPermission('stock-log.index')
                        || hasPermission('warehouse-shipments.index') || hasPermission('delivery.index') || hasPermission('order.index')
                          || hasPermission('case.index')"
                    class="navigation-header text-truncate">
                    <span>FULFILLMENT</span>
                </li>
                <li v-if="hasPermission('calendar.index')" class="nav-item"
                    :class="currentRoute == 'calendar.index' ||currentRoute == 'calendar.create' ||currentRoute == 'calendar.edit' ||currentRoute == 'calendar.show'  ?'active nav-item':'nav-item'">
                    <inertia-link :href="route('calendar.index')">
                        <i class="menu-livicon" data-icon="calendar"></i>
                        <span class="menu-title text-truncate">Calendar</span>
                    </inertia-link>

                </li>
                <li v-if="hasPermission('product-stocks.index') || hasPermission('warehouse-stocks.index') || hasPermission('stock-log.index')"
                    class="nav-item has-sub">
                    <a href="# ">
                        <i class="menu-livicon" data-icon="drop"></i>
                        <span class="menu-title text-truncate">Stocks</span>
                    </a>
                    <ul class="menu-content" style="">
                        <li
                            :class="currentRoute == 'stock-log.index' || currentRoute == 'stock-log.create' ||currentRoute == 'stock-log.edit' ? 'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('stock-log.index')" :href="route('stock-log.index')">
                                <i class="bx bxs-box"></i>
                                <span class="menu-item text-truncate">Stock Log</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'product-stocks.index' || currentRoute == 'product-stocks.create' ||currentRoute == 'product-stocks.edit' ? 'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('product-stocks.index')"
                                :href="route('product-stocks.index')">
                                <i class="bx bxs-inbox"></i>
                                <span class="menu-item text-truncate">Product Stocks</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'warehouse-stocks.index' || currentRoute == 'warehouse-stocks.create' ||currentRoute == 'warehouse-stocks.edit' ? 'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('warehouse-stocks.index')"
                                :href="route('warehouse-stocks.index')">
                                <i class="bx bxs-building-house"></i>
                                <span class="menu-item text-truncate">Warehouse Stocks</span>
                            </inertia-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-sub" v-if="hasPermission('warehouse-shipments.index')">
                    <a href="# ">
                        <i class="menu-livicon" data-icon="hand-bottom"></i>
                        <span class="menu-title text-truncate">Goods In</span>
                    </a>
                    <ul class="menu-content" style="">
                        <li v-if="hasPermission('warehouse-shipments.index')"
                            :class="currentRoute == 'warehouse-shipments.index' ||currentRoute == 'warehouse-shipments.create' ||currentRoute == 'warehouse-shipments.edit'  ? 'active nav-item' : 'nav-item'">
                            <inertia-link :href="route('warehouse-shipments.index')">
                                <i class="bx bxs-ship"></i>
                                <span class="menu-item text-truncate">Shipment</span>
                            </inertia-link>
                        </li>
                    </ul>
                </li>
                <li v-if="hasPermission('delivery.index') || hasPermission('order.index')" class="nav-item has-sub">
                    <a href="# ">
                        <i class="menu-livicon" data-icon="hand-top"></i>
                        <span class="menu-title text-truncate">Goods Out</span>
                    </a>
                    <ul class="menu-content" style="">
                        <li v-if="hasPermission('order.index')"
                            :class="currentRoute == 'order.index' || currentRoute == 'order.create' || currentRoute == 'order.edit' || currentRoute == 'order.show'?'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('order.index')" :href="route('order.index')">
                                <i class="bx bx-package"></i>
                                <span class="menu-item text-truncate">Fulfilment Order</span>
                            </inertia-link>
                        </li>
                        <li :class="currentRoute == 'delivery.index'?'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('delivery.index')" :href="route('delivery.index')">
                                <i class="bx bxs-truck"></i>
                                <span class="menu-item text-truncate">Deliveries</span>
                            </inertia-link>
                        </li>
                    </ul>
                </li>
                <li c :class="currentRoute == 'case.index'?'active nav-item':'nav-item'">
                    <inertia-link v-if="hasPermission('case.index')" :href="route('case.index')">
                        <i class="menu-livicon" data-icon="briefcase"></i>
                        <span class="menu-title text-truncate">Cases</span>
                    </inertia-link>
                </li>

                <li>
                    <inertia-link v-if="is_super" href="#">
                        <i class="menu-livicon" data-icon="settings"></i>
                        <span class="menu-title text-truncate">Settings-Logo</span>
                    </inertia-link>
                </li>

                <!--Fulfilment end  -->

                <!-- FULFILLMENT ADMIN -->
                <li v-if="hasPermission('users.index') || hasPermission('warehouse.index') || hasPermission('building.index') || hasPermission('email-setting.index') || hasPermission('company.index') || hasPermission('quotations.index') || hasPermission('quotation-requests.index') || hasPermission('questionnaires.index')"
                    class="navigation-header text-truncate">
                    <span>FULFILLMENT Admin</span>
                </li>
                <li
                    :class="currentRoute == 'companys.users.index' || currentRoute == 'companys.users.create' || currentRoute == 'companys.users.edit' || currentRoute == 'companys.users.show' ? 'active nav-item' : 'nav-item'">
                    <inertia-link v-if="hasPermission('users.index')" :href="route('companys.users.index')">
                        <i class="menu-livicon" data-icon="user"></i>
                        <span class="menu-title text-truncate">Users</span>
                    </inertia-link>
                </li>
                <li
                    :class="currentRoute == 'building.index' || currentRoute == 'building.create' || currentRoute == 'building.edit' || currentRoute == 'building.show'||currentRoute == 'section.create' || currentRoute == 'section.edit' ||currentRoute == 'section.show'||currentRoute == 'aisle.create' || currentRoute == 'aisle.edit' ||currentRoute == 'aisle.show'||currentRoute == 'bay.create' || currentRoute == 'bay.edit' ||currentRoute == 'bay.show'||currentRoute == 'level.create' || currentRoute == 'level.edit' ||currentRoute == 'level.show' ||currentRoute == 'bin.create' || currentRoute == 'bin.edit' ||currentRoute == 'bin.show'  ?'active nav-item':'nav-item'">
                    <inertia-link v-if="hasPermission('building.index')" :href="route('building.index')">
                        <i class="menu-livicon" data-icon="building"></i>
                        <span class="menu-title text-truncate">Building</span>
                    </inertia-link>
                </li>
                <li v-if="hasPermission('email-setting.index')"
                    :class="currentRoute == 'email-setting.index' || currentRoute == 'email-setting.show' || currentRoute == 'email-setting.edit' || currentRoute == 'email-setting.create'?'active nav-item':'nav-item'">
                    <inertia-link :href="route('email-setting.index')">
                        <i class="menu-livicon" data-icon="envelope-pull"></i>
                        <span class="menu-title text-truncate">Email Setting</span>
                    </inertia-link>
                </li>
                <li
                    :class="currentRoute == 'company.index' || currentRoute == 'company.create' || currentRoute == 'company.edit' || currentRoute == 'company.show' ?'active nav-item':'nav-item'">
                    <inertia-link v-if="hasPermission('company.index')" :href="route('company.index')">
                        <i class="menu-livicon" data-icon="building"></i>
                        <span class="menu-title text-truncate">Companies</span>
                    </inertia-link>
                </li>
                <li v-if="hasPermission('quotations.index') || hasPermission('quotation-requests.index') || hasPermission('questionnaires.index')"
                    class="nav-item has-sub">
                    <a href="# ">
                        <i class="menu-livicon" data-icon="handcuffs"></i>
                        <span class="menu-title text-truncate">Quotes</span>
                    </a>
                    <ul class="menu-content" style="">
                        <li
                            :class="currentRoute == 'quotation-requests.index' || currentRoute == 'quotation-requests.create' || currentRoute == 'quotation-requests.edit' ||currentRoute == 'quotation-requests.show'  ?'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('quotation-requests.index')"
                                :href="route('quotation-requests.index')">
                                <i class="bx bxs-message-square"></i>
                                <span class="menu-item text-truncate">Quote Request</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'quotations.index' ||currentRoute == 'quotations.create' || currentRoute == 'quotations.edit' ||currentRoute == 'quotations.show'  ?'active nav-item':'nav-item'">
                            <inertia-link :href="route('quotations.index')">
                                <i class="bx bxs-message-dots"></i>
                                <span class="menu-item text-truncate">Quote Responce</span>
                            </inertia-link>
                        </li>
                        <li
                            :class="currentRoute == 'questionnaires.index' || currentRoute == 'questionnaires.create' || currentRoute == 'questionnaires.edit' ? 'active nav-item':'nav-item'">
                            <inertia-link v-if="hasPermission('questionnaires.index')"
                                :href="route('questionnaires.index')">
                                <i class="bx bxs-quote-right "></i>
                                <span class="menu-item text-truncate">Quote Questions</span>
                            </inertia-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <inertia-link v-if="is_super" href="#">
                        <i class="menu-livicon" data-icon="settings"></i>
                        <span class="menu-title text-truncate">Settings-Logo</span>
                    </inertia-link>
                </li>

                <!-- FULFILLMENT ADMIN end -->

                <!-- Super ADMIN -->
                <li class="navigation-header text-truncate" v-if="is_super">
                    <span>Super Admin</span>
                </li>
                <li
                    :class="currentRoute == 'companys.index' || currentRoute == 'companys.create' || currentRoute == 'companys.edit' || currentRoute == 'companys.show' ?'active nav-item':'nav-item'">
                    <inertia-link v-if="is_super" :href="route('companys.index')">
                        <i class="menu-livicon" data-icon="building"></i>
                        <span class="menu-title text-truncate">Companies</span>
                    </inertia-link>
                </li>
                <li
                    :class="currentRoute == 'modules.index' || currentRoute == 'modules.create' || currentRoute == 'modules.edit' || currentRoute == 'modules.show' ?'active nav-item':'nav-item'">
                    <inertia-link v-if="is_super" :href="route('modules.index')">
                        <i class="menu-livicon" data-icon="plus"></i>
                        <span class="menu-title text-truncate">Modules</span>
                    </inertia-link>
                </li>
                <li
                    :class="currentRoute == 'packages.index' || currentRoute == 'packages.create' || currentRoute == 'packages.edit' || currentRoute == 'packages.show' ?'active nav-item':'nav-item'">
                    <inertia-link v-if="is_super" :href="route('packages.index')">
                        <i class="menu-livicon" data-icon="box-add"></i>
                        <span class="menu-title text-truncate">Packages</span>
                    </inertia-link>
                </li>
                <li
                    :class="currentRoute == 'roles.index' || currentRoute == 'roles.create' || currentRoute == 'roles.edit' || currentRoute == 'roles.show' ? 'active nav-item' : 'nav-item'">
                    <inertia-link v-if="is_super" :href="route('roles.index')">
                        <i class="menu-livicon" data-icon="share"></i>
                        <span class="menu-title text-truncate">Roles</span>
                    </inertia-link>
                </li>
                <li>
                    <inertia-link v-if="is_super" href="#">
                        <i class="menu-livicon" data-icon="diagram"></i>
                        <span class="menu-title text-truncate">Policies</span>
                    </inertia-link>
                </li>
                <li :class="currentRoute == 'lookups.index' || currentRoute == 'lookups.create' || currentRoute == 'lookups.edit' || currentRoute == 'lookups.show' ? 'active nav-item' : 'nav-item'">
                    <inertia-link v-if="is_super" :href="route('lookups.index')">
                        <i class="menu-livicon" data-icon="bomb"></i>
                        <span class="menu-title text-truncate">Lookups</span>
                    </inertia-link>
                </li>
                <li
                    :class="currentRoute == 'exchanges-rates.index' || currentRoute == 'exchanges-rates.create' || currentRoute == 'exchanges-rates.edit' || currentRoute == 'exchanges-rates.show' ? 'active nav-item':'nav-item'">
                    <inertia-link v-if="is_super" :href="route('exchanges-rates.index')">
                        <i class="menu-livicon" data-icon="coins"></i>
                        <span class="menu-title text-truncate">Exchange Rate</span>
                    </inertia-link>
                </li>
                <li v-if="is_super"
                    :class="currentRoute == 'courriers.index' ||currentRoute == 'courriers.create' || currentRoute == 'courriers.edit' ||currentRoute == 'courriers.show'  ? 'active nav-item':'nav-item'">
                    <inertia-link :href="route('courriers.index')">
                        <i class="menu-livicon" data-icon="truck"></i>
                        <span class="menu-title text-truncate">Courrier</span>
                    </inertia-link>
                </li>
                <!-- super end -->
            </ul>
        </div>
    </div>
</template>

<script>
    import SidebarConfig from "./SideBarConfig";
    import { computed } from "vue";
    export default {
        name: "SideBar",
        components: {
            SidebarConfig,
        },
        data() {
            return {
                sidebarInitializer: '',
                is_super: false,
                is_admin: false,
                is_owner: false,
            }
        },
        setup() {
            const permissions = computed(() => this.$page.props.auth.permissions);
            return { permissions };
        }
        ,
        computed: {
            currentRoute() {
                return this.$page.props.currentRouteName;
            },

        },

        beforeMount() {
            this.$page.props.currentRouteName
            if (this.$page.props.auth.user.is_super == 1) {
                this.is_super = true
            }
            if (this.$page.props.auth.user.is_owner == 1) {
                this.is_owner = true
            }
            if (this.$page.props.auth.user.is_admin == 1) {
                this.is_admin = true
            }
            this.sidebarInitializer = new SidebarConfig();
            this.sidebarInitializer.applyInitialConfiguration();
        },

        mounted() {
            this.$page.props.currentRouteName
            if (this.$page.props.auth.user.is_super == 1) {
                this.is_super = true
            }
            this.sidebarInitializer.applyGeneralAppConfiguration();
        },
        methods: {
            modernMenuExpand: function () {
                this.sidebarInitializer.menuExpand();
            },
            modernMenuCollapse: function () {
                this.sidebarInitializer.menuCollapse();
            }
        }

    }
</script>
