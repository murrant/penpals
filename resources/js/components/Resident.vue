<template>
<div class="card">
    <div :class="{'card-header': true, 'bg-info': primary, 'text-light': primary}" v-on:click="shown = !shown">
        {{ resident.name }}
    </div>
    <div class="card-body" v-show="shown">
        <div>Age: {{ resident.age_range }}</div>
        <div>Gender: {{ resident.gender }}</div>
        <div v-if="!primary">Relation: {{ resident.relation }}</div>
    </div>
</div>
</template>

<script>
    export default {
        name: "Resident",
        props: {
            resident: {
                type: Object,
                require: true
            }
        },
        data() {
            return {
                shown: false
            }
        },
        computed: {
            primary() {
                return this.resident.relation === 'Primary'
            }
        }
    }
</script>

<style scoped>
.card-header {
    cursor: pointer;
    font-weight: bold;
}
</style>
