<template>
<ul>
    <li v-for="penpal in penpals">{{ penpal.first_name }} {{ penpal.last_name }}</li>
</ul>
</template>

<script>
    export default {
        name: "PenpalList",
        data() {
            return {
                penpals: []
            }
        },
        mounted() {
            axios.get('ajax/users')
                .then(response => (this.penpals = response.data.penpals))
        },
    }
</script>

<style scoped>

</style>
