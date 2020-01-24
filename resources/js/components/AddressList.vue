<template>
    <div class="container">
        <div class="row non-printable">
            <div class="col-lg-8 col-md-10 col-sm-12 offset-lg-2 offset-md-1">
                <div class="card">
                    <div class="card-header">Assigned PenPals ({{ assigned.length }})</div>
                    <div class="card-body">
                        <div v-if="assigned.length > 0" class="list-header">
                            <div><h4>PenPal</h4></div>
                            <div style="justify-self: end;"><h4>Mail Sent?</h4></div>
                        </div>
                        <div v-else>
                            All letters sent! :D<br />
                            <a role="button" class="btn btn-primary" href="/address-request/create">Request More</a>
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
        <div class="row mt-3 non-printable">
            <div class="col-lg-8 col-md-10 col-sm-12 offset-lg-2 offset-md-1">
                If you would like to request more addresses, take a picture of your letters before you mail them!
            </div>
        </div>
        <div class="row mt-3 non-printable">
            <div class="col-lg-8 col-md-10 col-sm-12 offset-lg-2 offset-md-1">
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
        <div class="printable">
            <h3>Penpals for: {{ this.name }}</h3>

            <table>
                <tr v-for="row in chunk(this.assigned, 2)">
                    <td v-for="item in row" class="print-cell">
                        <div class="address" v-for="resident in item.residents"><strong>{{ resident.name }}</strong></div>
                        <mailing-address :address="item" />
                    </td>
                </tr>
            </table>

        </div>
    </div>
</template>

<script>
    export default {
        name: "AddressList",
        props: {
            "name": {
                type: String,
                required: true
            }
        },
        data() {
            return {
                "addresses": []
            }
        },
        mounted() {
            axios.get('ajax/address')
                .then(response => (this.addresses = response.data.addresses.map(function (address) {
                    address.completed = address.completed ? new Date(address.completed) : null;
                    address.assigned = address.assigned ? new Date(address.assigned) : null;
                    return address;
                })));
        },
        computed: {
            assigned() {
                return this.addresses.filter(address => address.completed === null).sort((a, b) => b.assigned - a.assigned)
            },
            completed() {
                return this.addresses.filter(address => address.completed !== null).sort((a, b) => b.completed - a.completed)
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
            chunk (arr, size) {
                return arr.reduce((chunks, el, i) => (i % size
                    ? chunks[chunks.length - 1].push(el)
                    : chunks.push([el])) && chunks, []);
            }
        }
    }
</script>

<style scoped>
    .list-header {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

    table {
        width: 100%;
    }
    .print-cell {
        padding: 30px;
    }
</style>
