<template>
    <admin-layout>
        <div class="col-12 px-0">
            <div class="row" v-if="packages">
                <div class="col-xl-4 col-sm-6 col-4" v-for="user_package in packages">
                    <div class="card text-center responsive basic-card">
                        <div class="card-content">
                            <div class="card-body" style="">
                                <h1 class="card-title">{{ user_package.name }}</h1>
                                <p class="card-text">${{ user_package.price }}</p>
                                <hr class="line">
                                <p class="card-text">{{ user_package.duration / 30 }} Months</p>
                                <hr class="line">
                                <p>Modules</p>
                                <hr>
                                <div class="scroll" v-if="user_package.modules.length>5" id="style-2">
                                    <p class="card-text" v-for="module in user_package.modules">{{module.name }}</p>
                                </div>
                                <p class="card-text" v-for="module in user_package.modules" v-else>{{ module.name }}</p>
                                <hr class="line">
                                <p class="card-text">{{ user_package.number_of_user }} Users Allowed</p>
                                <hr class="line">
                                <inertia-link class="btn btn-light-primary btn-sm add-btn"
                                              :href="route('subscriptions.create',user_package.id)">
                                    Get Started
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
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
        name: "Subscription",
        props: ["packages", "errors"],
        components: {
            Label,
            AdminLayout,
            JetInputError,
            ErrorComponent
        },
        setup() {
            const form = useForm({
                "package_id": '',
                "card_type": '',
                "card_number": '',
                "expire": '',
                "cvv2": '',
                "first_name": '',
                "last_name": '',
                "street": '',
                "city": '',
                "state": '',
                "country": '',
                "zip": '',
                'auto_renew': false,
                "save_card": false
            });
            return {form}
        },
        data() {
            return {}
        },
        beforeMount() {
            document.title = process.env.MIX_APP_NAME + " - Create Role";
        },
        methods: {
            getPackage(id) {
                this.form.package_id = id;
            },
            submit() {
                this.form.get('/subscription/start');
            },
        }
    }
</script>

<style scoped>

    .action {
        margin-right: 4px !important;
    }

    .card {
        border: 1px solid #d2d6dc;
        border-radius: 0px !important;
    }

    table thead th {
        vertical-align: bottom;
        border-bottom: 1px solid #d2d6dc;
    }

    .scroll {
        height: 180px;
        overflow-y: auto;
    }

    #style-2::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    .basic-card {
        height: 94% !important;
    }

    #style-2::-webkit-scrollbar {
        width: 12px;
        background-color: #F5F5F5;
    }

    #style-2::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #01779F;
    }
</style>
