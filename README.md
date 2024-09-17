# Rapidez Experius Postcode NL
Implementation of the Postcode NL API with the Magento 2 Experius-Postcode-NL module for Rapidez.

## Requirements
Make sure the [Magento 2 Experius-Postcode-NL](https://github.com/experius/Magento-2-Module-Experius-Postcode-NL) and [Mage2-Module-Experius-PostcodeGraphQl](https://github.com/experius/Mage2-Module-Experius-PostcodeGraphQl) modules have been installed and configured in your Magento installation.

## Installation
```bash
composer require rapidez/experius-postcode-nl
```

If you haven't published the Rapidez views yet, publish them with:
```bash
php artisan vendor:publish --provider="Rapidez\Core\RapidezServiceProvider" --tag=views
```

Add a event listener on the [postcode and housenumber fields](https://github.com/rapidez/core/blob/master/resources/views/checkout/partials/address.blade.php#L97):
```blade
    v-on:change="window.app.$emit('postcode-change', {{ $address }})"
    <x-rapidez::input
        name="{{ $type }}_postcode"
        label="Postcode"
        v-model.lazy="checkout.{{ $type }}_address.postcode"
        v-on:change="$root.$nextTick(() => window.app.$emit('postcode-change', checkout.{{ $type }}_address))"
        required
    />

```
