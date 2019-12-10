<template>
    <div class="address">
        {{ address.address }}<br />
        {{ address.city }}, {{ address.state_name }} {{ address.zip }}-{{ address.zip4 }}
    </div>
</template>

<script>
    export default {
        name: "Address",
        props: {
            address: {
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>
