require('./bootstrap');
import VueApexCharts from "vue3-apexcharts";

import {computed, createApp, h} from 'vue';

import {InertiaProgress} from '@inertiajs/progress';

import {App as InertiaApp, plugin as InertiaPlugin} from '@inertiajs/inertia-vue3';

// import {vue2Dropzone} from 'vue2-dropzone'

// import vue2Dropzone from "vue2-dropzone";
//
// import "vue2-dropzone/dist/vue2Dropzone.min.css";
window.permissions = [];
const hasPermission = (permission) => {
    return window.permissions.indexOf(permission) > -1;
}
const el = document.getElementById('app');

const app = createApp({

    render: () =>

        h(InertiaApp, {

            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => {

                if (process.env.MIX_ENV === 'local') {
                    return require(`./Pages/${name}`).default;
                    //return (await import(`./Pages/${name}`)).default;
                }
                return import(`./Pages/${name}`).then(module => module.default)
            }

            // resolveComponent: async (name) => {
            //     if (process.env.MIX_APP_ENV === 'local') {
            //         return require(`./Pages/${name}`).default;
            //     }
            //     return (await import(`./Pages/${name}`)).default;
            //
            // }

        }),
})
    .mixin({methods: {route}})

    .use(InertiaPlugin)

    .use(VueApexCharts)


app.config.globalProperties.hasPermission = hasPermission;

app.mount(el);

InertiaProgress.init({color: '#4B5563 !important'});

