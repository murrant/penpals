<template>
    <div class="card" v-if="pending">
        <div class="card-header">
            <h4>{{ penpal.first_name }} {{ penpal.last_name }}</h4>
            {{ penpal.email }}
        </div>
        <div class="card-body">
            <img :src="'/img/' + request.image" class="proof">
            <p class="card-text">{{ request.note }}</p>
            <label> Addresses
                <input type="number" name="amount" class="form-control" v-model="amount"/>
            </label>
            <label> Reason
                <input type="text" name="reason" class="form-control" placeholder="Reason" v-model="reason"/>
            </label>
            <button type="submit" @click="submitApproval('approve')" class="btn btn-primary">Approve</button>
            <button type="submit" @click="submitApproval('deny')" class="btn btn-primary">Deny</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddressRequest",
        props: {
            "request": Object,
            "penpal": Object
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
</style>
