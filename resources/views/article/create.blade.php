<x-app-layout>
    <x-slot name="title">Article create</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Article create</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
                        <div class="grid grid-cols-1 gap-6">
                            <form method="POST" action="{{ route('article.store') }}" enctype="multipart/form-data">
                                @csrf
                                <label class="block">
                                    <input type="checkbox" name="publish" @checked(old('publish'))
                                        class="mt-1 inline-block rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('publish') border-1 border-rose-600 @enderror">
                                    <span class="text-gray-700 align-sub" style="vertical-align:sub;">Publish</span>
                                </label>
                                <label class="block mt-3">
                                    <span class="text-gray-700">Sort index</span>
                                    <input type="text" name="sort" value="{{ old('sort') }}"
                                        class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('sort') border-1 border-rose-600 @enderror">
                                </label>
                                <x-input-error :messages="$errors->get('sort')" class="mt-1" />

                                <label class="block mt-3">
                                    <span class="text-gray-700">Title</span>
                                    <input type="text" name="title" value="{{ old('title') }}"
                                        class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('title') border-1 border-rose-600 @enderror">
                                </label>
                                <x-input-error :messages="$errors->get('title')" class="mt-1" />

                                <label class="block mt-3">
                                    <span class="text-gray-700">Picture</span>
                                    <input type="file" name="picture" value="{{ old('picture') }}"
                                        class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">
                                </label>
                                <x-input-error :messages="$errors->get('picture')" class="mt-1" />

                                <label class="block mt-3">
                                    <span class="text-gray-700">Description</span>
                                    <textarea name="description" rows="5"
                                        class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">{{ old('description') }}</textarea>
                                </label>
                                <x-input-error :messages="$errors->get('description')" class="mt-1" />
                                <x-primary-button class="mt-4">Add article</x-primary-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
