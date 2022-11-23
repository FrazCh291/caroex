<template>
    <div>
        <input type="text" v-model="keyword">
        <ul v-if="Product.length > 0">
            <li v-for="product in Product" :key="product.id" v-text="product.name"></li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            keyword: null,
            Books: []
        };
    },
    watch: {
        keyword(after, before) {
            this.getResults();
        }
    },
    methods: {
        getResults() {
            axios.get('product-search', { params: { keyword: this.keyword } })
                .then(res => this.Books = res.data)
                .catch(error => {});
        }
    }
}
</script>