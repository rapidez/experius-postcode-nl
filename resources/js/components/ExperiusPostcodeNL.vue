<script>
    export default {
        props: ['type'],
        render() {
            return this.$scopedSlots.default({
                shouldCheckPostcode: this.shouldCheckPostcode,
                callbackPostcodeCheck: this.callbackPostcodeCheck
            })
        },
        methods: {
            clearStreetAndCity() {
                if (!this.checkout[this.addressType + '_manualInput']) {
                    this.checkout[this.addressType].street[0] = ''
                    this.checkout[this.addressType].city = ''
                }
            },
            shouldCheckPostcode() {
                /**
                 * Always clear street and city fields before postcode check
                 */
                this.clearStreetAndCity()

                return !this.checkout[this.addressType + '_manualInput']
                    && this.checkout[this.addressType].postcode !== ''
                    && 1 in this.checkout[this.addressType].street
                    && this.checkout[this.addressType].country_id == 'NL'
            },
            callbackPostcodeCheck(data, response) {
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
