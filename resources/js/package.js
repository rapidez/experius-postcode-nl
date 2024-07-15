import { set, useDebounceFn, useMemoize } from "@vueuse/core";


document.addEventListener('turbo:load', function () {
    window.app.$on('postcode-change', useDebounceFn(updateAddressFromExperiusPostcode, 100));
})

const getAddressFromExperiusPostcode = useMemoize(
    async function (postcode, housenumber, housenumberAddition = '') {
        return magentoGraphQL(
            'query postcode($postcode: String! $houseNumber: String! $houseNumberAddition: String) { postcode(postcode: $postcode houseNumber: $houseNumber houseNumberAddition: $houseNumberAddition) { street houseNumber houseNumberAddition postcode city province houseNumberAdditions } }',
            {
                postcode: postcode,
                houseNumber: housenumber,
                houseNumberAddition: housenumberAddition
            }
        )
    }
)

async function updateAddressFromExperiusPostcode(address, type = 'shipping') {
    if ((address?.country_id || address?.country_code) != 'NL') {
        return
    }

    if(!address.postcode || !(address?.housenumber || address.street[1])) {
        return
    }

    let response = await getAddressFromExperiusPostcode(address.postcode, address?.housenumber || address.street[1])

    if (!response.data?.postcode?.city || !response.data?.postcode?.street) {
        if (response.data?.postcode?.error == "Postcode not found") {
            set(address, 'city', '')
            set(address.street, 0, '')
        }
        return
    }

    window.app.checkout[type + '_address'].city = response.data.postcode.city
    window.app.checkout[type + '_address'].street[0] = response.data.postcode.street
}
