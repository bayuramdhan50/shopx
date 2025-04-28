@extends('layouts.profile')

@section('title', 'My Profile')

@section('header', 'My Account Settings')

@section('profile_content')
    <div class="grid md:grid-cols-4 gap-6">
        <!-- Sidebar Navigation -->
        <div class="md:col-span-1">
            <div class="bg-white shadow rounded-lg overflow-hidden sticky top-6">
                <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-3">
                            <div class="h-14 w-14 rounded-full bg-white flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-xl">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                            <p class="text-xs opacity-80">{{ Auth::user()->email }}</p>
                            @if(Auth::user()->is_admin)
                                <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-800 text-white">
                                    Admin
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <nav class="py-2">
                    <a href="#personal-info" class="profile-sidebar-link block px-4 py-3 text-sm text-indigo-600 bg-indigo-50 border-l-4 border-indigo-600 font-medium hover:bg-indigo-100 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Personal Information
                    </a>
                    <a href="#security" class="profile-sidebar-link block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600 border-l-4 border-transparent hover:border-indigo-400 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Security & Password
                    </a>
                    <a href="#delete-account" class="profile-sidebar-link block px-4 py-3 text-sm text-red-600 hover:bg-red-50 border-l-4 border-transparent hover:border-red-400 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Account
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="md:col-span-3 space-y-6">
            <!-- Personal Information Section -->
            <div id="personal-info" class="bg-white shadow sm:rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-50 to-white px-6 py-4 border-b border-indigo-100">
                    <h3 class="text-lg font-semibold text-indigo-700">Personal Information</h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Security & Password Section -->
            <div id="security" class="bg-white shadow sm:rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-50 to-white px-6 py-4 border-b border-indigo-100">
                    <h3 class="text-lg font-semibold text-indigo-700">Security & Password</h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Section -->
            <div id="delete-account" class="bg-white shadow sm:rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-red-50 to-white px-6 py-4 border-b border-red-100">
                    <h3 class="text-lg font-semibold text-red-700">Delete Account</h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
