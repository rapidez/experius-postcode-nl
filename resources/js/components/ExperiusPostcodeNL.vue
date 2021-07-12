<script>
    export default {
        props: ['type'],

        render() {
            return this.$scopedSlots.default()
        },

        methods: {
            getAddressFromAPI() {
                if (!this.checkout[this.addressType + '_manualInput']) {
                    let response = magento.post('postcode/information', {
                        houseNumber: this.checkout[this.addressType].street[1] !== undefined
                            ? this.checkout[this.addressType].street[1]
                            : '',
                        houseNumberAddition: this.checkout[this.addressType].street[2] !== undefined
                            ? this.checkout[this.addressType].street[2]
                            : '',
                        postcode: this.checkout[this.addressType].postcode
                    }).then(response => {
                        response = JSON.parse(response.data)
                        this.checkout[this.addressType + '_postcodeMessage'] = false
                        this.checkout[this.addressType].street[0] = response.street
                        this.checkout[this.addressType].city = response.city
                        this.checkout[this.addressType + '_hasHouseNumberAdditions'] = response.houseNumberAdditions !== undefined && response.houseNumberAdditions.length > 1

                        if (response.message) {
                            this.checkout[this.addressType + '_postcodeMessage'] = response.message
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
        },
        watch: {
            'checkout': {
                deep: true,
                handler: function() {
                    if (this.checkout[this.addressType].country_id == 'NL') {
                        this.getAddressFromAPI()
                    }
                }
            }
        }
    }
</script>
