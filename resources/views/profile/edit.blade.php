@extends('layouts.profile')

@section('title', 'My Profile')

@section('header', 'My Account Settings')

@section('profile_content')
    <div class="grid md:grid-cols-4 gap-6">
        <!-- Sidebar Navigation -->
        <div class="md:col-span-1">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-3">
                            <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center">
                                <span class="text-white font-bold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
                <nav class="py-2">
                    <a href="#personal-info" class="block px-4 py-2 text-sm text-indigo-600 bg-indigo-50 border-l-4 border-indigo-600 font-medium">
                        Personal Information
                    </a>
                    <a href="#security" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                        Security & Password
                    </a>
                    <a href="#delete-account" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                        Delete Account
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="md:col-span-3 space-y-6">
            <!-- Personal Information Section -->
            <div id="personal-info" class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Security & Password Section -->
            <div id="security" class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Section -->
            <div id="delete-account" class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
