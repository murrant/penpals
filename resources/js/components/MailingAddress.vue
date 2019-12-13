<template>
    <div class="address">
        <div v-for="line in addressLines">{{ line }}</div>
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
        },
        computed: {
            addressLines() {
                let address = [];

                address.push((this.address.address_number + ' ' + (this.address.unit ? (this.address.unit + ' ') : '') + this.address.street));
                let added = [
                    this.address.building,
                    this.address.floor,
                    this.address.room,
                    this.address.additional
                ].filter(a => a);

                if (added.length > 0) {
                    address.push(added.join(' '));
                }

                address.push(this.address.city + ', ' + this.address.state + ' ' + this.address.zip + (this.address.zip4 ? ('-' + this.address.zip4) : ''));

                return address;
            }
        }

    }
</script>

<style scoped>

</style>
