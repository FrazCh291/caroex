<template>
    <div id="toast-container" class="toast-container toast-top-right" v-if="show">
        <div :class="'toast toast-'+type" aria-live="assertive" style="display: block; opacity: 0.8;">
            <div class="toast-progress" :style="'width: '+progress+'%'"></div>
            <div class="toast-message">{{message}}</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['type', 'message'],
        name: "Toastr",
        created() {
            var obj = this;
            setInterval(function () {
                obj.progress = obj.progress - 1;
            }, 50);

            setTimeout(function () {
                obj.show = false
            }, 5000)
        },
        data() {
            return {
                show: true,
                progress: 100
            }
        }
    }
</script>

<style scoped>

</style>
