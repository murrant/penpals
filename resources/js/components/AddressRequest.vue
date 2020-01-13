<template>
    <div class="card mb-3" v-if="pending">
        <div class="card-header">
            <h4>{{ penpal.first_name }} {{ penpal.last_name }}</h4>
            {{ penpal.email }}
        </div>
        <div class="card-body">
            <div class="row">
                <img :src="'/img/' + request.image" class="proof">
            </div>
            <div class="row">
                <p class="card-text">{{ request.note }}</p>
            </div>
            <div class="row">
                <label> Addresses
                    <input type="number" name="amount" class="form-control" v-model="amount"/>
                </label>
            </div>
            <div class="row">
                <label> Message (Give a reason if denying)
                    <textarea type="text" name="reason" class="form-control" placeholder="Message" v-model="reason" cols="70" rows="5">
                </textarea>
                </label>
            </div>
            <div class="row">
                <button type="submit" @click="submitApproval('approve')" class="btn btn-primary">Approve</button>
                &nbsp;
                <button type="submit" @click="submitApproval('deny')" class="btn btn-primary">Deny</button>
            </div>
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
