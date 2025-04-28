<section>
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-gray-700 font-medium" />
                    <div class="relative mt-1">
                        <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full pr-10" autocomplete="current-password" placeholder="••••••••" />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer password-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 password-eye" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password" :value="__('New Password')" class="text-gray-700 font-medium" />
                    <div class="relative mt-1">
                        <x-text-input id="update_password_password" name="password" type="password" class="block w-full pr-10" autocomplete="new-password" placeholder="••••••••" />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer password-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 password-eye" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')" class="text-gray-700 font-medium" />
                    <div class="relative mt-1">
                        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full pr-10" autocomplete="new-password" placeholder="••••••••" />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer password-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 password-eye" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 my-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            For security reasons, please ensure your password:
                        </p>
                        <ul class="mt-2 text-xs text-yellow-700 list-disc list-inside">
                            <li>Is at least 8 characters long</li>
                            <li>Contains uppercase and lowercase letters</li>
                            <li>Includes numbers and special characters</li>
                            <li>Is not easily guessable or used elsewhere</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-6">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">{{ __('Update Password') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Password updated successfully.') }}</p>
            @endif
        </div>
    </form>
</section>
