<template>

        <span class="mt-3 list-disc list-inside text-sm text-red-600"  v-if="error">
            {{ error }}
        </span>

</template>

<script>
export default {
    name: "ErrorComponent",
    props: ['input'],

    mounted() {


    },
    computed: {
        errors() {
            return this.$page.props.errors
        },

        hasError() {

          console.log(Object.keys(this.errors).indexOf(this.input) > -1);
        },
        error() {
            return this.errors[this.input];
        }
    }
}
</script>

<style scoped>

</style>
