<template>
<div class="card">
    <div :class="{'card-header': true, 'bg-info': primary, 'text-light': primary}">
        {{ resident.name }}
    </div>
    <div class="card-body" v-show="expanded">
        <div>Age: {{ resident.age_range }}</div>
        <div v-if="resident.gender">Gender: {{ resident.gender }}</div>
        <div v-if="!primary && resident.relation">Relation: {{ resident.relation }}</div>
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
            },
            expanded: {
                type: Boolean,
                require: true
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
