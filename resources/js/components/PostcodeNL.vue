<script>
    export default {
        props: ['type'],

        render() {
            return this.$scopedSlots.default({
                checkout: this.checkout
            })
        },

        methods: {
            getAddressFromAPI() {
                if (!this.checkout[this.addressType].manual_input) {
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
                        this.checkout[this.addressType].message = false
                        this.checkout[this.addressType].street[0] = response.street
                        this.checkout[this.addressType].city = response.city
                        this.checkout[this.addressType].hasHouseNumberAdditions = response.houseNumberAdditions !== undefined && response.houseNumberAdditions.length > 1

                        if (response.message) {
                            this.checkout[this.addressType].message = response.message
                        }
                    })
                }
            },
            manualInput() {
                if (this.checkout[this.addressType].manual_input) {
                    return true
                }

                return false
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
