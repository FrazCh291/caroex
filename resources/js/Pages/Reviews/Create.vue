<template>
    <admin-layout>
        <div>
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-9 col-12">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <!-- <h4 class="card-title" v-if="review">Edit Review</h4> -->
                                <h4 class="card-title">Add Review</h4>
                            </div>
                            <div class="px-2 pb-1">
                                <hr class="line">
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form @submit.prevent="submit" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row form-group pt-1 pb-0 mb-0" v-if="customer">
                                                <div class="col-md-3">
                                                    <label>Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="name" v-model="customer.name"
                                                           class="form-control"
                                                           name="name">
                                                    <ErrorComponent input="name"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-1 pb-0 mb-0" v-else>
                                                <div class="col-md-3">
                                                    <label>Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="name" v-model="form.name"
                                                           class="form-control"
                                                           name="name">
                                                    <ErrorComponent input="name"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Email *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="email" id="email" v-model="form.email"
                                                           class="form-control"
                                                           name="email">
                                                    <ErrorComponent input="email"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Channel Name *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select class="form-select" v-model="form.channel_id"
                                                            name="channel_id">
                                                        <option value="">select</option>
                                                        <option v-for="salesChannel in salesChannels"
                                                                :value="salesChannel.id">
                                                            {{ salesChannel.name }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="channel_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Url</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" id="url" v-model="form.url"
                                                           class="form-control"
                                                           name="url">
                                                    <ErrorComponent input="url"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Product Name </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                           <select class="form-select" v-model="form.product_id"
                                                                   name="product_id">
                                                            <option value="">select</option>
                                                            <option v-for="product in products" :value="product.id">
                                                                {{ product.name }}</option>
                                                            </select>
                                                    <ErrorComponent input="product_id"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Rating *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="radio radio-primary">
                                                            <input type="radio" id="rating1"
                                                                   v-model="form.rating" value="1" name="rating">
                                                            <label for="rating1">1</label>
                                                        </div>
                                                        <div class="radio radio-primary">
                                                            <input type="radio" id="rating2"
                                                                   v-model="form.rating" value="2" name="rating">
                                                            <label for="rating2">2</label>
                                                        </div>
                                                        <div class="radio radio-primary">
                                                            <input type="radio" id="rating3"
                                                                   v-model="form.rating" value="3" name="rating">
                                                            <label for="rating3">3</label>
                                                        </div>
                                                        <div class="radio radio-primary">
                                                            <input type="radio" id="rating4"
                                                                   v-model="form.rating" value="4" name="rating">
                                                            <label for="rating4">4</label>
                                                        </div>
                                                        <div class="radio radio-primary">
                                                            <input type="radio" id="rating5"
                                                                   v-model="form.rating" value="5" name="rating">
                                                            <label for="rating5">5</label>
                                                        </div>
                                                    </div>
                                                    <ErrorComponent input="rating"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Status </label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <select class="form-select" v-model="form.status"
                                                            name="status">
                                                        <option value="">select</option>
                                                        <option v-for="review_status in review_statuses"
                                                                :value="review_status.slug">
                                                            {{ review_status.value }}
                                                        </option>
                                                    </select>
                                                    <ErrorComponent input="status"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Last Sent Date</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="date" id="last_sent_at" v-model="form.last_sent_at"
                                                           class="form-control" :max="maxDate"
                                                           name="last_sent_at">
                                                    <ErrorComponent input="last_sent_at"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Comment *</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <textarea type="textarea" rows="4" id="comment"
                                                              v-model="form.comment" class="form-control"
                                                           name="comment"></textarea>
                                                    <ErrorComponent input="comment"></ErrorComponent>
                                                </div>
                                            </div>
                                            <div class="row form-group pt-2 pb-0 mb-0">
                                                <div class="col-md-3">
                                                    <label>Active</label>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <fieldset>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input"
                                                                   v-model="form.is_active" id="is_active">
                                                            <label for="is_active"></label>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-start px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                    Save
                                                </button>
                                                <inertia-link :href="route('reviews.index')" type="button"
                                                              class="btn btn-light-secondary mr-1 mb-1">
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

import moment from 'moment';
import AdminLayout from "../../Layouts/AdminLayout";
import Label from "../../Jetstream/Label";
import JetInputError from './../../Jetstream/InputError'
import {useForm} from '@inertiajs/inertia-vue3'
import ErrorComponent from '../../components/ErrorComponent'

export default {
    name: "Create",
    props: ['review', 'products', 'customer' ,'review_statuses', 'salesChannels', 'currentDate', 'customer_id', 'errors'],
    components: {
        Label,
        AdminLayout,
        JetInputError,
        ErrorComponent,
    },
    setup() {
        const form = useForm({
            product_id: '',
            name: '',
            email: '',
            channel_id: '',
            url: '',
            rating: '',
            status: '',
            last_sent_at: '',
            comment: '',
            customer_id: '',
            is_active: false,
        })
        return {form}
    },
    data() {
        return {
            maxDate: this.currentDate,
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Core";
        if (this.review) {
            this.update = true;
            let data = this.review;
            Object.assign(data, {
                '_method': 'PUT',
            })
            this.form = this.$inertia.form(data);
            this.form.last_sent_at = this.form.last_sent_at ? moment(this.form.last_sent_at).format('YYYY-MM-DD') : null;
            if(this.review.is_active == 1) {
                this.form.is_active = true
            }
        }
    },
    methods: {
        submit() {
            if (this.update) {
                if(this.form.status === '') {
                    this.form.status = 'review_unapproved';
                }
                this.form.post(route('reviews.update', this.review.id))
            } else {
                if(this.form.status === '') {
                    this.form.status = 'review_unapproved';
                }
                this.form.customer_id = this.customer_id
                 this.form.post('/erp/reviews')
            }
        },
    }
}

</script>

<style scoped>

.line {
    border-top: 1px dashed #C7CFD6;
    width: 100%;
}

.error {
    margin-top: 0px !important;
}

</style>
