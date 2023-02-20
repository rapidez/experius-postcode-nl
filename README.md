# Rapidez Experius Postcode NL
Implementation of the Postcode NL API with the Magento 2 Experius-Postcode-NL module for Rapidez.

## Requirements
Make sure the [Magento 2 Experius-Postcode-NL](https://github.com/experius/Magento-2-Module-Experius-Postcode-NL) and [Mage2-Module-Experius-PostcodeGraphQl](https://github.com/experius/Mage2-Module-Experius-PostcodeGraphQl) modules have been installed and configured in your Magento installation.

## Installation
```bash
composer require rapidez/experius-postcode-nl
```

Make sure this exists in your `app.js`:
```js
import.meta.glob(['Vendor/rapidez/*/resources/js/app.js'], { eager: true });
```

If you haven't published the Rapidez views yet, publish them with:
```bash
php artisan vendor:publish --provider="Rapidez\Core\RapidezServiceProvider" --tag=views
```

Replace in `resources/views/vendor/rapidez/checkout/partials/form.blade.php` the postcode, street, housenumber and city fields for:
```blade
@include('postcode-nl::checkout/experius-postcode-nl')
```
