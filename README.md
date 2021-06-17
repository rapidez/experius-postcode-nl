# Rapidez Postcode API
Implementation of the Postcode NL API with the Magento 2 Experius-Postcode-NL module for Rapidez.

## Requirements
Make sure the [Magento 2 Experius-Postcode-NL](https://github.com/experius/Magento-2-Module-Experius-Postcode-NL) module has been installed and configured in your Magento installation.

## Installation
```
composer require rapidez/postcode-nl
```

And register the Vue component in `resources/js/app.js`:
```
Vue.component('postcode-nl', require('Vendor/rapidez/postcode-nl/resources/js/components/PostcodeNL.vue').default)
```

If you haven't published the Rapidez views yet, publish them with:
```
php artisan vendor:publish --provider="Rapidez\Core\RapidezServiceProvider" --tag=views
```

Replace in `resources/views/vendor/rapidez/checkout/partials/form.blade.php` the postcode, street, housenumber and city fields for:
```
@include('postcode-nl::checkout/postcode-nl')
```
