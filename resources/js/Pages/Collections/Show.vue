<template>
    <div>
        <admin-layout>
            <form class="form" @submit.prevent="submit" enctype="multipart/form-data">
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                            <div class="card invoice-print-area">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card-header pb-0 mb-0">
                                            <small class="text-muted mr-1 lg:font-bold">Order Number:</small>
                                            <small class="text-muted">{{ collection.case.order.order_number }}</small>
                                        </div>
                                        <div class="card-header pt-0 mt-0 pb-0 mb-0">
                                            <small class="text-muted mr-1 lg:font-bold">Customer Name:</small>
                                            <small class="text-muted">{{
                                                collection.case.order.shipping_customer_name
                                                }}</small>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="card-header pb-0 mb-0">
                                            <small class="text-muted mr-1 lg:font-bold">Case Number:</small>
                                            <small class="text-muted">{{ collection.case.id }}</small>
                                        </div>
                                        <div class="card-header pt-0 mt-0 pb-0 mb-0">
                                            <small class="text-muted mr-1 lg:font-bold">Collection Number:</small>
                                            <small class="text-muted">{{ collection.id }}</small>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="card-header pb-0 mb-0 pt-1.5 mt-1.5 ml-5">
                                            <span
                                                class="badge badge-warning text-white xl:w-36 h-8"
                                                v-if="collection.case.lookup.value == 'High' || collection.case.lookup.value == 'High'">
                                                         <small class="text-white text-base">{{
                                                                 collection.case.lookup.value
                                                             }}</small>
                                            </span>
                                            <span
                                                class="badge badge-success text-white xl:w-36 h-8"
                                                v-if="collection.case.lookup.value == 'Low' || collection.case.lookup.value == 'Low'">
                                                     <small class="text-white text-base">{{
                                                             collection.case.lookup.value
                                                         }}</small>
                                           </span>
                                            <span
                                                class="badge badge-secondary text-white xl:w-36 h-8"
                                                v-if="collection.case.lookup.value == 'Medium' || collection.case.lookup.value == 'Medium'">
                                                     <small class="text-white text-base">{{
                                                             collection.case.lookup.value
                                                         }}</small>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="card-header pb-0 mb-0 pt-1.5 mt-1.5 mr-5">
                                            <span class="badge badge-danger mr-1 xl:w-36 h-8">
                                                <a v-on:click="confirmDelete(collection.id)" type="button"
                                                   class="text-white text-base">
                                                    Delete
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-2">
                                    <hr class="line">
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-0 pt-0 lg:font-bold">
                                                        Collection Address
                                                    </div>
                                                    <div class="card-header pb-0 mb-0 pt-0.5">
                                                        <small class="text-muted">
                                                            {{ collection.customer.name }}
                                                        </small><br>
                                                        <small class="text-muted">
                                                            {{ collection.customer.address1_2 }}
                                                        </small><br>
                                                        <small class="text-muted">
                                                            {{ collection.customer.city }}
                                                            {{ collection.customer.postcode }}
                                                        </small><br>
                                                        <small class="text-muted">
                                                            {{ collection.customer.email }}
                                                        </small><br>
                                                        <small class="text-muted">
                                                            {{ collection.customer.phone }}
                                                        </small>
                                                    </div>
                                                    <div class="px-2">
                                                        <hr class="line">
                                                    </div>
                                                    <div class="mb-0 pt-0 lg:font-bold">
                                                        Product Details
                                                    </div>
                                                    <div class="card-header pb-0 mb-0">
                                                        <small class="text-muted font-bold pb-0 mb-0">
                                                            Product Name:
                                                        </small>
                                                        <small class="text-muted pr-2">
                                                            {{
                                                            returnItem[0].product ? returnItem[0].product.name : ''
                                                            }}
                                                        </small><br>
                                                        <small class="text-muted font-bold">
                                                            SKU:
                                                        </small>
                                                        <small class="text-muted pr-2">
                                                            {{ returnItem[0].product ? returnItem[0].product.sku : '' }}
                                                        </small><br>
                                                    </div>
                                                    <div class="px-2">
                                                        <hr class="line">
                                                    </div>
                                                    <div class="mb-0 pt-0 lg:font-bold">
                                                        Tracking Information
                                                    </div>
                                                    <div class="card-header pb-0 mb-0">
                                                        <small class="text-muted font-bold">
                                                            Delivery Tracking:
                                                        </small>
                                                        <small class="text-muted pr-2">
                                                            {{ collection.case.tracking_number }}
                                                        </small><br>
                                                        <small class="text-muted font-bold">
                                                            Collection Status:
                                                        </small>
                                                        <small class="text-muted pr-2">
                                                            {{ collection.return_status }}
                                                        </small><br>
                                                        <small class="text-muted font-bold">
                                                            Collection Tracking:
                                                        </small>
                                                        <small class="text-muted pr-2">
                                                            {{ collection.tracking_number }}
                                                        </small><br>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-0 pt-0 lg:font-bold">
                                                        Collection Updates
                                                    </div>
                                                    <div class="card-header pb-0 mb-0 pt-0.5">
                                                        <div class="mb-0 pt-0">Collection Tracking</div>
                                                        <div>
                                                            <input type="text" id="tracking_number"
                                                                   v-model="form.tracking_number"
                                                                   class="form-control"
                                                                   name="tracking_number">
                                                            <ErrorComponent input="tracking_number"></ErrorComponent>
                                                        </div>
                                                    </div>
                                                    <div class="card-header pb-0 mb-0 pt-0.5">
                                                        <div class="mb-0 pt-0">Collection Status</div>
                                                        <select class="form-select" id="return_status"
                                                                name="return_status"
                                                                v-model="form.return_status">
                                                            <option value=""></option>
                                                            <option v-for="return_statu in return_status"
                                                                    :value="return_statu.value">
                                                                {{ return_statu.value }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="card-header pb-0 mb-0 pt-0.5">
                                                        <div class="mb-0 pt-0">Return Date</div>
                                                        <input type="date" id="return_at"
                                                               v-model="form.return_at"
                                                               class="form-control" name="return_at">
                                                        <ErrorComponent input="tracking_number"></ErrorComponent>
                                                    </div>
                                                    <div class="card-header pb-0 mb-0 pt-0.5">
                                                        <div class="mb-0 pt-0">Recieved Date</div>
                                                        <input type="date" id="received_at"
                                                               v-model="form.received_at"
                                                               class="form-control" name="received_at">
                                                        <ErrorComponent input="tracking_number"></ErrorComponent>
                                                    </div>
                                                    <div class="card-header pb-0 mb-0 pt-0.5">
                                                        <div class="mb-0 pt-0">Refund Date</div>
                                                        <input type="date" id="refunded_at"
                                                               v-model="form.refunded_at"
                                                               class="form-control" name="refunded_at">
                                                        <ErrorComponent input="tracking_number"></ErrorComponent>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert"
                                                               @clicked="Clicked"
                                                               @deleteitem="deleteItem">
                                            </ConfirmatiomModal>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-2">
                                    <hr class="line">
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div>
                                            <div class="row">
                                                <div class="col-12 pt-2">
                                                    <label>Product Images</label>
                                                </div>
                                            </div>
                                            <div class="row" v-for="image in collection.media">
                                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                                    <div class="">
                                                        <div class="card-content image-card">
                                                            <div
                                                                class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                                <div class="card pt-0 mb-1">
                                                                    <input type="file"
                                                                           @change="preview_image('p_image1')"
                                                                           id="p_image1-upload"
                                                                           style="display:none"/>
                                                                    <label for="p_image1-upload"
                                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                            <img class="image1 rounded mx-auto d-block px-1"
                                                                 id="p_image1"
                                                                 :src="'/'+image.p1_image"
                                                                 v-if="image.p1_image">
                                                            <img class="image rounded mx-auto d-block px-1"
                                                                 id="p_image1"
                                                                 src="/img/camera-icon.png"
                                                                 v-else>
                                                            </span>
                                                                        <span id="side1"
                                                                              class="text-center mt-1 small"><br>  <span>Product Image 1 *</span></span>
                                                                    </label>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                                    <div class="">
                                                        <div class="card-content image-card">
                                                            <div
                                                                class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                                <div class="card pt-0 mb-1">
                                                                    <input type="file"
                                                                           @change="preview_image('p_image2')"
                                                                           id="p_image2-upload"
                                                                           style="display:none"/>
                                                                    <label for="p_image2-upload"
                                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                            <img class="image1 rounded mx-auto d-block px-1"
                                                                 id="p_image2"
                                                                 :src="'/'+image.p2_image"
                                                                 v-if="image.p2_image">
                                                            <img class="image rounded mx-auto d-block px-1"
                                                                 id="p_image2"
                                                                 src="/img/camera-icon.png"
                                                                 v-else>
                                                            </span>
                                                                        <span id="side1"
                                                                              class="text-center mt-1 small"><br>  <span>Product Image 2 *</span></span>
                                                                    </label>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                                    <div class="">
                                                        <div class="card-content image-card">
                                                            <div
                                                                class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                                <div class="card pt-0 mb-1">
                                                                    <input type="file"
                                                                           @change="preview_image('p_image3')"
                                                                           @input="form.p3_image = $event.target.file"
                                                                           id="p_image3-upload"
                                                                           style="display:none"/>
                                                                    <label for="p_image3-upload"
                                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                            <img class="image1 rounded mx-auto d-block px-1"
                                                                 id="p_image3"
                                                                 :src="'/'+image.p3_image"
                                                                 v-if="image.p3_image">
                                                            <img class="image rounded mx-auto d-block px-1"
                                                                 id="p_image3"
                                                                 src="/img/camera-icon.png"
                                                                 v-else>
                                                            </span>
                                                                        <span id="side1"
                                                                              class="text-center mt-1 small"><br>  <span>Product Image 3 *</span></span>
                                                                    </label>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                                    <div class="">
                                                        <div class="card-content image-card">
                                                            <div
                                                                class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                                <div class="card pt-0 mb-1">
                                                                    <input type="file"
                                                                           @change="preview_image('p_image4')"
                                                                           id="p_image4-upload"
                                                                           style="display:none"/>
                                                                    <label for="p_image4-upload"
                                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                            <img class="image1 rounded mx-auto d-block px-1"
                                                                 id="p_image4"
                                                                 :src="'/'+image.p4_image"
                                                                 v-if="image.p4_image">
                                                            <img class="image rounded mx-auto d-block px-1"
                                                                 id="p_image4"
                                                                 src="/img/camera-icon.png"
                                                                 v-else>
                                                            </span>
                                                                        <span id="side1"
                                                                              class="text-center mt-1 small"><br>  <span>Product Image 4 *</span></span>
                                                                    </label>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                                    <div class="">
                                                        <div class="card-content image-card">
                                                            <div
                                                                class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                                <div class="card pt-0 mb-1">
                                                                    <input type="file"
                                                                           @change="preview_image('p_image5')"
                                                                           id="p_image5-upload"
                                                                           style="display:none"/>
                                                                    <label for="p_image5-upload"
                                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                             <img class="image1 rounded mx-auto d-block px-1"
                                                                  id="p_image5"
                                                                  :src="'/'+image.p5_image"
                                                                  v-if="image.p5_image">
                                                            <img class="image rounded mx-auto d-block px-1"
                                                                 id="p_image5"
                                                                 src="/img/camera-icon.png"
                                                                 v-else>
                                                            </span>
                                                                        <span id="side1"
                                                                              class="text-center mt-1 small"><br>  <span>Product Image 5 *</span></span>
                                                                    </label>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                                    <div class="">
                                                        <div class="card-content image-card">
                                                            <div
                                                                class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                                <div class="card pt-0 mb-1">
                                                                    <input type="file"
                                                                           @change="preview_image('exchange')"
                                                                           id="exchange-upload"
                                                                           style="display:none"/>
                                                                    <label for="exchange-upload"
                                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                             <img class="image1 rounded mx-auto d-block px-1"
                                                                  id="exchange"
                                                                  :src="'/'+image.exchange_form"
                                                                  v-if="image.exchange_form">
                                                            <img class="image rounded mx-auto d-block px-1"
                                                                 id="exchange"
                                                                 src="/img/camera-icon.png"
                                                                 v-else>
                                                            </span>
                                                                        <span id="side1"
                                                                              class="text-center mt-1 small"><br>  <span>Exchange Form *</span></span>
                                                                    </label>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                                    <div class="">
                                                        <div class="card-content image-card">
                                                            <div
                                                                class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                                <div class="card pt-0 mb-1">
                                                                    <input type="file"
                                                                           @change="preview_image('parcel1')"
                                                                           id="parcel1-upload"
                                                                           style="display:none"/>
                                                                    <label for="parcel1-upload"
                                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                        <img class="image1 rounded mx-auto" id="parcel1"
                                                             :src="'/'+image.parcel_side_1"
                                                             v-if="image.parcel_side_1">
                                                            <img class="image rounded mx-auto d-block px-1" id="parcel1"
                                                                 src="/img/camera-icon.png"
                                                                 v-else>
                                                            </span>
                                                                        <span id="side1"
                                                                              class="text-center mt-1 small"><br>  <span>Add Parcel Side 1 *</span></span>
                                                                        Add License
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12 ">
                                                    <div class="">
                                                        <div class="card-content image-card">
                                                            <div
                                                                class="card-body pb-0 pt-0 mb-0 px-0 border-1 border-dashed">
                                                                <div class="card pt-0 mb-1">
                                                                    <input type="file"
                                                                           @change="preview_image('parcel2')"
                                                                           id="parcel2-upload"
                                                                           style="display:none"/>
                                                                    <label for="parcel2-upload"
                                                                           class="text-center my-1 small">
                                                        <span class="text-center">
                                                            <img class="image1 rounded mx-auto d-block px-1"
                                                                 id="parcel2"
                                                                 :src="'/'+image.parcel_side_2"
                                                                 v-if="image.parcel_side_2">
                                                            <img class="image rounded mx-auto d-block px-1" id="parcel2"
                                                                 src="/img/camera-icon.png"
                                                                 v-else>
                                                            </span>
                                                                        <span id="side1"
                                                                              class="text-center mt-1 small"><br>  <span>Add Parcel Side 2 *</span></span>
                                                                    </label>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-header pb-0 mb-0 pt-0.5">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                Save
                                            </button>
                                            <a :href="route('collections.index')" type="button"
                                               class="btn btn-light-secondary mr-1 mb-1">
                                                Back
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ConfirmatiomModal v-if="sweetAlert" :sweetAlert="sweetAlert" @clicked="Clicked"
                                       @deleteitem="deleteItem">
                    </ConfirmatiomModal>
                </section>
            </form>
        </admin-layout>
    </div>
</template>
<script>
c
import Button from "../../Jetstream/Button"
import Pagination from "../../admin/Pagination";
import {useForm} from '@inertiajs/inertia-vue3';
import AdminLayout from "../../Layouts/AdminLayout";
import JetInputError from "../../Jetstream/InputError";
import ErrorComponent from '../../components/ErrorComponent';
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal";

export default {

    name: "show",
    props: ['collection', 'returnItem', 'return_status'],
    components: {
        Button,
        AdminLayout,
        Pagination,
        JetInputError,
        ErrorComponent,
        ConfirmatiomModal,
    },
    setup() {
        const form = useForm({
            refunded_at: '',
            return_at: '',
            received_at: '',
            return_status: '',
            tracking_number: '',
            parcel_side_1: '',
            parcel_side_2: '',
            exchange_form: '',
            p1_image: '',
            p2_image: '',
            p3_image: '',
            p4_image: '',
            p5_image: '',
            _method: 'PUT',
        });
        return {form}
    },
    data() {
        return {
            sweetAlert: false,
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Collections";
        if (this.collection) {
            this.update = true;
            let data = this.collection;
            Object.assign(data, {
                '_method': 'PUT',
            })
            data.refunded_at = data.refunded_at ? moment(data.refunded_at).format('YYYY-MM-DD') : null;
            data.return_at = data.return_at ? moment(data.return_at).format('YYYY-MM-DD') : null;
            data.received_at = data.received_at ? moment(data.received_at).format('YYYY-MM-DD') : null;
            this.form = this.$inertia.form(Object.assign(this.form.data(), data));
        }
    },
    methods: {
        preview_image(data) {
            var reader = new FileReader();
            reader.onload = function () {
                if (data == 'parcel1') {
                    var output = document.getElementById('parcel1');
                }
                if (data == 'parcel2') {
                    var output = document.getElementById('parcel2');
                }
                if (data == 'exchange') {
                    var output = document.getElementById('exchange');
                }
                if (data == 'p_image1') {
                    var output = document.getElementById('p_image1');
                }
                if (data == 'p_image2') {
                    var output = document.getElementById('p_image2');
                }

                if (data == 'p_image3') {
                    var output = document.getElementById('p_image3');
                }
                if (data == 'p_image4') {
                    var output = document.getElementById('p_image4');
                }
                if (data == 'p_image5') {
                    var output = document.getElementById('p_image5');
                }

                output.src = reader.result;
            },
                reader.readAsDataURL(event.target.files[0]);
        },
        submit() {
            this.$page.props.errors = {};
            let files = {};
            if (document.getElementById('parcel1-upload').files.length) {
                this.form.parcel_side_1 = document.getElementById('parcel1-upload').files[0];
            }
            if (document.getElementById('parcel2-upload').files.length) {
                this.form.parcel_side_2 = document.getElementById('parcel2-upload').files[0];
            }
            if (document.getElementById('exchange-upload').files.length) {
                this.form.exchange_form = document.getElementById('exchange-upload').files[0];
            }
            if (document.getElementById('p_image1-upload').files.length) {
                this.form.p1_image = document.getElementById('p_image1-upload').files[0];
            }
            if (document.getElementById('p_image2-upload').files.length) {
                this.form.p2_image = document.getElementById('p_image2-upload').files[0];
            }
            if (document.getElementById('p_image3-upload').files.length) {
                this.form.p3_image = document.getElementById('p_image3-upload').files[0];
            }
            if (document.getElementById('p_image4-upload').files.length) {
                this.form.p4_image = document.getElementById('p_image4-upload').files[0];
            }
            if (document.getElementById('p_image5-upload').files.length) {
                this.form.p5_image = document.getElementById('p_image5-upload').files[0];
            }
            if (this.update) {
                this.form.post(route('collections.update', this.collection.id));
            } else {
                this.form.post('/collections', this.collection.id)
            }
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        Clicked() {
            this.sweetAlert = false
        },
        deleteItem() {
            this.sweetAlert = false;
            this.$inertia.delete(`/collections/${this.itemId}`)
        },
        confirmDelete() {
            this.sweetAlert = true
            this.itemId = this.collection.id;
        },
    }
}
</script>

<style scoped>

.action {
    margin-right: 4px !important;
    margin-top: 8px !important;
    margin-bottom: 8px !important;
}

.card {
    border: 1px solid #d2d6dc;
    border-radius: 0px !important;
}

.text-title-icon {
    vertical-align: super;
}

.card-one {
    border: 1px solid #d2d6dc;
    border-bottom: 0px;
}

.image {
    width: auto !important;
    height: 110px !important;
}

.image1 {
    padding-top: 10px;
    width: 330px;
    height: 110px;
}

table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #d2d6dc;
}

.custom-dropdown {
    margin-top: 0.5rem !important;
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
