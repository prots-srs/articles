<x-app-layout>
    <x-slot name="title">Resident edit</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Resident edit</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
                        <div class="grid grid-cols-1 gap-6">
                            <form method="POST" action="{{ route('resident.update', $item) }}">
                                @csrf
                                @method('patch')
                                <label class="block mt-3">
                                    <span class="text-gray-700">Email</span>
                                    <input type="email" name="email" value="{{ old('email', $item->email) }}"
                                        class="mt-1 block w-full rounded-md bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0 @error('email') border-1 border-rose-600 @enderror">
                                </label>
                                <x-input-error :messages="$errors->get('email')" class="mt-1" />

                                <div class="flex flex-row w-full flex-nowrap gap-4 content-end">
                                    <div class="basis-1/2 self-end">
                                        <label class="block mt-3">
                                            <span class="text-gray-700">Name</span>
                                            <input type="text" name="name" value="{{ old('name', $item->name) }}"
                                                class="mt-1 block w-full rounded-md bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0 @error('name') border-1 border-rose-600 @enderror">
                                        </label>
                                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                                    </div>
                                    <div class="basis-1/4 self-end">
                                        <label class="block">
                                            <input type="checkbox" name="verified" @checked(old('verified', !empty($item->email_verified_at)))
                                                class="mx-2 inline-block rounded-md bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0>
                                            <span class="text-gray-700
                                                align-sub">Verified</span>
                                        </label>
                                    </div>
                                    <div class="basis-1/4 self-end">
                                        <div class="flex flex-row w-full flex-nowrap gap-4 content-end">
                                            <x-primary-button class="mt-4 self-end">Update</x-primary-button>
                                            <x-dropdown-link :href="route('resident.index')" class="self-end">Close</x-dropdown-link>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
