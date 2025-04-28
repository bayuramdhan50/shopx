<section>
    <header class="mb-6">
        <h2 class="text-xl font-medium text-gray-900 border-b pb-2">
            {{ __('Personal Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your personal information and contact details.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('patch')

        @if ($errors->has('update'))
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            {{ $errors->first('update') }}
        </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 font-medium" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800">
                                {{ __('Your email address is unverified.') }}

                                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" :value="__('Phone Number')" class="text-gray-700 font-medium" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
            </div>

            <div class="mt-8 mb-4">
                <h3 class="text-lg font-medium text-gray-800 mb-3 border-b pb-2">Shipping Address</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Address -->
                <div class="md:col-span-2">
                    <x-input-label for="address" :value="__('Street Address')" class="text-gray-700 font-medium" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <!-- City -->
                <div>
                    <x-input-label for="city" :value="__('City')" class="text-gray-700 font-medium" />
                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" />
                    <x-input-error class="mt-2" :messages="$errors->get('city')" />
                </div>

                <!-- State/Province -->
                <div>
                    <x-input-label for="state" :value="__('State/Province')" class="text-gray-700 font-medium" />
                    <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $user->state)" />
                    <x-input-error class="mt-2" :messages="$errors->get('state')" />
                </div>

                <!-- Postal Code -->
                <div>
                    <x-input-label for="postal_code" :value="__('Postal Code')" class="text-gray-700 font-medium" />
                    <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $user->postal_code)" />
                    <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
                </div>

                <!-- Country -->
                <div>
                    <x-input-label for="country" :value="__('Country')" class="text-gray-700 font-medium" />
                    <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->country)" />
                    <x-input-error class="mt-2" :messages="$errors->get('country')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-6">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
