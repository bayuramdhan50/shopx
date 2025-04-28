@extends('layouts.main')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">@yield('header', 'Profile')</h1>
            </div>

            @yield('profile_content')
        </div>
    </div>
@endsection
