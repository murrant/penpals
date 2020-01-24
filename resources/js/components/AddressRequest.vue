<template>
    <div class="card mb-3" v-if="pending">
        <div class="card-header">
            <h4>{{ penpal.first_name }} {{ penpal.last_name }}</h4>
            {{ penpal.email }}<br/>
            Total Sent: {{ sent }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h5>Proof of letters sent</h5>
                </div>
                <div class="col">
                    <a :href="'/img/' + request.image">
                        <img :src="'/img/small/' + request.image" class="proof img-fluid" alt="proof">
                    </a>
                </div>
            </div>
            <div class="row" v-if="previous.length > 0">
                <div class="col-12 mt-3">
                    <h5>Previous request images</h5>
                </div>
                <div class="col-12">
                    <a v-for="image in previous" :href="'/img/' + image">
                        <img :src="'/img/tiny/' + image" class="previous-images img-fluid" alt="previous_proof">
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-3">
                    <h5>Message from requester</h5>
                </div>
                <div class="col">
                    <p class="card-text">{{ request.note }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label> Addresses
                        <input type="number" name="amount" class="form-control" v-model="amount"/>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label> Message (Give a reason if denying)
                        <textarea type="text" name="reason" class="form-control" placeholder="Message" v-model="reason" cols="70" rows="5">
                        </textarea>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" @click="submitApproval('approve')" class="btn btn-primary" :disabled="available < amount">Approve</button>
                    &nbsp;
                    <button type="submit" @click="submitApproval('deny')" class="btn btn-primary">Deny</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddressRequest",
        props: {
            "request": Object,
            "penpal": Object,
            "sent": Number,
            "previous": Array,
            "available": Number
        },
        data() {
            return {
                amount: this.request.amount,
                reason: '',
                pending: true
            }
        },
        methods: {
            submitApproval(approval) {
                const formData = new FormData();
                formData.append('amount', this.amount);
                formData.append('message', this.reason);
                let url = '/address-request/' + this.request.id + '/' + approval;
                axios.post(url, formData)
                    .then(res => this.pending = false)

            }
        }
    }
</script>

<style scoped>
    .proof {
        max-height: 300px;
    }

    .previous-images {
        max-height: 100px;
        max-width: 100px;
        margin: 4px;
    }
</style>
