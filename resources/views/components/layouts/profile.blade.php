<x-layouts.main>
    <x-slot name="title">{{ $title ?? 'Profile' }}</x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">{{ $header ?? 'Profile' }}</h1>
            </div>

            {{ $slot }}
        </div>
    </div>
</x-layouts.main>
