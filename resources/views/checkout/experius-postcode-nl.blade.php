<experius-postcode-nl type="{{ $type }}">
    <div class="col-span-12" slot-scope="{ beforePostcodeCheck, callbackPostcodeCheck }">
        <graphql-mutation
            query="query postcode($postcode: String $houseNumber: String $houseNumberAddition: String) { postcode( postcode: $postcode houseNumber: $houseNumber houseNumberAddition: $houseNumberAddition ) { street houseNumber houseNumberAddition postcode city province houseNumberAdditions } }"
            :variables="{ postcode: checkout.{{ $type }}_address.postcode, houseNumber: checkout.{{ $type }}_address.street[1], houseNumberAddition: '' }"
            :callback="callbackPostcodeCheck"
        >
            <div class="grid grid-cols-12 gap-4 mb-3" slot-scope="{ variables, mutate }">
                <div class="col-span-12 p-3 bg-gray-200">
                    <p><strong>@lang('Address Validation')</strong></p>
                    <p>@lang('Enter your zip code and house number and your address will be completed automatically and without errors. You can of course also fill it in manually.')</p>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-rapidez::input
                        name="{{ $type }}_postcode"
                        v-model="checkout.{{ $type }}_address.postcode"
                        v-on:change="$set(variables, 'postcode', checkout.{{ $type }}_address.postcode)"
                        v-on:blur="beforePostcodeCheck() && mutate()"
                        label="Postcode"
                        :placeholder="__('Postcode')"
                        required
                    />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-rapidez::input
                        name="{{ $type }}_housenumber"
                        v-model="checkout.{{ $type }}_address.street[1]"
                        v-on:change="$set(variables, 'houseNumber', checkout.{{ $type }}_address.street[1])"
                        v-on:blur="beforePostcodeCheck() && mutate()"
                        label="Housenumber"
                        :placeholder="__('Nr.')"
                        required
                    />
                </div>
                <div
                    v-if="checkout.{{ $type }}_address_hasHouseNumberAdditions || checkout.{{ $type }}_address_manualInput"
                    class="col-span-6 sm:col-span-4"
                >
                    <x-rapidez::input
                        name="{{ $type }}_addition"
                        v-model="checkout.{{ $type }}_address.street[2]"
                        v-on:change="$set(variables, 'houseNumberAddition', checkout.{{ $type }}_address.street[2])"
                        v-on:blur="beforePostcodeCheck() && mutate()"
                        label="Addition"
                        :placeholder="__('Addition')"
                    />
                </div>
                <div class="col-span-6 sm:col-span-6 sm:col-start-1">
                    <x-rapidez::checkbox
                        v-model="checkout.{{ $type }}_address_manualInput"
                        v-on:change="beforePostcodeCheck() && mutate()"
                    >
                        @lang('Manually fill in the address')
                    </x-rapidez::checkbox>
                </div>
                <div
                    v-if="checkout.{{ $type }}_address_postcodeMessage"
                    class="col-span-12 sm:col-span-12 p-3 text-red-600 bg-red-100"
                >
                    <p v-text="checkout.{{ $type }}_address_postcodeMessage" />
                </div>
                <div class="col-span-6 sm:col-span-6 sm:col-start-1">
                    <x-rapidez::input
                        v-bind:class="!checkout.{{ $type }}_address_manualInput ? 'bg-gray-200' : ''"
                        name="{{ $type }}_street"
                        v-model="checkout.{{ $type }}_address.street[0]"
                        label="Street"
                        :placeholder="__('Street')"
                        v-bind:disabled="!checkout.{{ $type }}_address_manualInput"
                        required
                    />
                </div>
                <div class="col-span-6 sm:col-span-6 sm:col-start-7">
                    <x-rapidez::input
                        v-bind:class="!checkout.{{ $type }}_address_manualInput ? 'bg-gray-200' : ''"
                        name="{{ $type }}_city"
                        v-model="checkout.{{ $type }}_address.city"
                        label="City"
                        :placeholder="__('City')"
                        v-bind:disabled="!checkout.{{ $type }}_address_manualInput"
                        required
                    />
                </div>
            </div>
        </graphql-mutation>
    </div>
</experius-postcode-nl>
