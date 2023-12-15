<x-app-layout>
    <x-slot name="title">Articles</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Articles</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
                        <x-table-list />
                    </div>
                    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
                        <x-nav-link :href="route('article.create')" :active="request()->routeIs('article.create')">
                            <x-primary-button class="mt-4">{{ __('Compose new article') }}</x-primary-button>
                        </x-nav-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
