<template class="pb-2">
    <div class="px-1">
        <div class="p-2 sm:px-20 bg-white border-b border-gray-200">
            <div class="grid grid-cols-9 py-0.5">
                <div>  <span class="text-base">Company</span></div>
                <div>
                    <span class="text-base truncate"> {{
                            $page.props.user.company ? $page.props.user.company.name : ''
                        }}</span>
                </div>
                <div class="col-span-7"></div>
            </div>

            <div class="grid grid-cols-9 py-0.5">
                <span class="text-base">Owner name</span>
                <div>
                    <span class="text-base truncate">
                         {{ $page.props.user ? $page.props.user.name : '' }}
                    </span>
                </div>
                <div class="col-span-7"></div>

            </div>
            <div class="grid grid-cols-9 py-0.5">
                <span class="text-base">Email</span>
                <div>
                    <span class="text-base truncate">
                         {{ $page.props.user.email ? $page.props.user.email : '' }}
                    </span>
                </div>
                <div class="col-span-7"></div>
            </div>
        </div>
        <div class="p-2 sm:px-20 bg-white border-b border-gray-200">
            <p class="text-center font-bold">Available Packages</p>
        </div>
        <div class="bg-gray-200 bg-opacity-25 grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 pt-2 px-2 gap-4">


            <div v-for="packagee in packages">
                <div class="card card-height">
                    <div class="card-header pb-0">
                        <h4 class="card-title text-center text">{{packagee.name}}</h4>
                        <h4 class="card-title text-center text-primary py-0.5">(${{packagee.price}})</h4>
                    </div>
                    <div class="card-body">
                        <div class="module-list-height">
                            <h4 class="card-title text-center my-0 pb-0">Modules</h4>
                            <div class="text-center pb-1">
                                <ul>
                                    <li v-for="module in packagee.modules">{{module.name}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="text-center ">
                            <inertia-link class="btn btn-light-primary btn-xl add-btn text-center"
                                          :href="route('subscriptions.create',packagee.id)">
                                Buy Now
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</template>

<script>

import JetApplicationLogo from '@/Jetstream/ApplicationLogo'
import Button from "./Button";

export default {
    components: {
        Button,
        JetApplicationLogo,
    },
    data(){
        return{
            packages:[]
        }
    },

    mounted()
    {
        this.packages = this.$page.props.packages;
        // console.log(this.$page.props)
        console.log(this.$page.props.packages)
    }

}
</script>
<style scoped>
.card-height{
    height: 311px;
}
.module-list-height
{
    height: 165px;
}

</style>
