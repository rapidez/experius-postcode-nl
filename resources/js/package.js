import { set, useDebounceFn, useMemoize } from "@vueuse/core";


document.addEventListener('turbo:load', function () {
    window.app.$on('postcode-change', useDebounceFn(updateAddressFromExperiusPostcode, 100));
})

const getAddressFromExperiusPostcode = useMemoize(
    async function (postcode, housenumber, housenumberAddition = '') {
        return axios.post(
            config.magento_url + '/graphql',
            {
                query: 'query postcode($postcode: String! $houseNumber: String! $houseNumberAddition: String) { postcode(postcode: $postcode houseNumber: $houseNumber houseNumberAddition: $houseNumberAddition) { street houseNumber houseNumberAddition postcode city province houseNumberAdditions } }',
                variables: {
                    postcode: postcode,
                    houseNumber: housenumber,
                    houseNumberAddition: housenumberAddition
                },
            },
            {
                headers: {
                    Store: window.config.store_code,
                }
            }
        )
    }
)

async function updateAddressFromExperiusPostcode(address) {
    if ((address?.country_id || address?.country_code) != 'NL') {
        return
    }

    if(!address.postcode || !(address?.housenumber || address.street[1])) {
        return
    }

    let response = (await getAddressFromExperiusPostcode(address.postcode, address?.housenumber || address.street[1]))?.data

    if (!response?.data?.postcode?.city || !response?.data?.postcode?.street) {
        if (response?.data?.postcode?.error == "Postcode not found") {
            set(address, 'city', '')
            set(address.street, 0, '')
        }
        return
    }

    set(address, 'city', response.data.postcode.city)
    set(address.street, 0, response.data.postcode.street)
}
