<script>
    export default {
        props: ['type'],
        render() {
            return this.$scopedSlots.default({
                postcodeMutate: this.postcodeMutate
            })
        },
        methods: {
            postcodeMutate(mutate) {
                if (!this.checkout[this.addressType + '_manualInput']
                    && this.checkout[this.addressType].postcode !== ''
                    && 1 in this.checkout[this.addressType].street
                    && this.checkout[this.addressType].country_id == 'NL'
                ) {
                    mutate().then((response) => {
                        this.checkout[this.addressType + '_postcodeMessage'] = false
                        if (!response.data.errors) {
                            this.checkout[this.addressType].postcode = response.data.data.postcode.postcode
                            this.checkout[this.addressType].street[0] = response.data.data.postcode.street
                            this.checkout[this.addressType].city = response.data.data.postcode.city
                            this.checkout[this.addressType + '_hasHouseNumberAdditions'] = response.data.data.postcode.houseNumberAdditions !== undefined && response.data.data.postcode.houseNumberAdditions.length > 1
                        }
                        if (response.data.errors) {
                            this.checkout[this.addressType + '_postcodeMessage'] = response.data.errors[0].message
                        }
                    })
                }
            }
        },
        computed: {
            addressType: function () {
                return `${this.type}_address`
            },
            checkout: function () {
                return this.$root.checkout
            }
        }
    }
</script>
