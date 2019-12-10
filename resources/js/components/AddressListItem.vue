<template>
<div class="address-panel row">
    <div>
        <div class="card-group">
            <resident v-for="resident in address.residents" :resident="resident" :key="resident.id"></resident>
        </div>
        <mailing-address :address="address"></mailing-address>
    </div>
    <div>
        <input type="checkbox" class="form-control" v-model="completed">
    </div>
</div>
</template>

<script>
    export default {
        name: "AddressListItem",
        props: {
            address: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                completed: this.address.completed
            }
        }
    }
</script>

<style scoped>
.address-panel {
    display: grid;
    grid-template-columns: auto 80px;
    /*grid-gap: 10px;*/
    margin-bottom: 25px;
}

.resident-panel {
    display:grid;
    grid-gap: 10px;
}
</style>
