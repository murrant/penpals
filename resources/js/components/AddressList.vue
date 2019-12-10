<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card">
                    <div class="card-header">Assigned PenPals ({{ assigned.length }})</div>
                    <div class="card-body">
                        <div v-if="assigned.length > 0" class="list-header">
                            <div><h4>PenPal</h4></div>
                            <div style="justify-self: end;"><h4>Mail Sent?</h4></div>
                        </div>
                        <div v-else>
                            All letters sent! :D<br />
                            <button role="button" class="btn btn-primary" @click="requestMore">Request More</button>
                        </div>
                        <address-list-item
                            v-for="address in assigned"
                            :key="address.id"
                            :address="address"
                            @address-completed="changeCompleted"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card" >
                    <div class="card-header">Completed ({{ completed.length }})</div>
                    <div class="card-body" v-if="completed.length > 0">
                        <div class="list-header">
                            <div><h4>PenPal</h4></div>
                            <div style="justify-self: end;"><h4>Mail Sent?</h4></div>
                        </div>
                        <address-list-item
                            v-for="address in completed"
                            :key="address.id"
                            :address="address"
                            @address-completed="changeCompleted"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddressList",
        data() {
            return {
                "addresses": []
            }
        },
        mounted() {
            axios.get('ajax/address')
                .then(response => (this.addresses = response.data.addresses))
        },
        computed: {
            assigned() {
                return this.addresses.filter(address => address.completed === null)
            },
            completed() {
                return this.addresses.filter(address => address.completed !== null)
            }
        },
        methods: {
            changeCompleted(event) {
                axios.put('ajax/address/' + event.id, {
                    completed: event.value
                })
                .then(response => {
                    this.addresses = this.addresses.map(address => {
                        if (address.id === response.data.id) {
                            address['completed'] = response.data.completed
                        }
                        return address;
                    });
                });
            },
            requestMore() {
                axios.get('ajax/address/request')
                    .then(response => (this.addresses = response.data.addresses))
            }
        }
    }
</script>

<style scoped>
    .list-header {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }
</style>
