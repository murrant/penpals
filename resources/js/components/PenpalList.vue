<template>
    <div class="row">
        <div class="col">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a :class="{'nav-link': true, active: activeTab === 'penpals'}" @click="activeTab='penpals'">PenPals</a>
                </li>
                <li class="nav-item">
                    <a :class="{'nav-link': true, active: activeTab === 'emails'}" @click="activeTab='emails'">Email List</a>
                </li>
            </ul>

            <div v-show="activeTab === 'penpals'">
                <ul>
                    <li v-for="penpal in penpals">{{ penpal.first_name }} {{ penpal.last_name }}</li>
                </ul>
            </div>
            <div v-show="activeTab === 'emails'">
                {{ penpals.map(a => a.email).join('; ') }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PenpalList",
        data() {
            return {
                penpals: [],
                activeTab: 'penpals'
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
