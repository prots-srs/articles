<x-app-layout>
    <x-slot name="title">Article edit</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Article edit</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
                        <div class="grid grid-cols-1 gap-6">
                            <form method="POST" action="{{ route('article.update', $article) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <label class="block">
                                    <input type="checkbox" name="publish" @checked(old('publish', $article->publish))
                                        class="mt-1 inline-block rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('publish')
border-1 border-rose-600
@enderror">
                                    <span class="text-gray-700 align-sub">Publish</span>
                                </label>
                                <label class="block mt-3">
                                    <span class="text-gray-700">Sort index</span>
                                    <input type="text" name="sort" value="{{ old('sort', $article->sort) }}"
                                        class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('sort') border-1 border-rose-600 @enderror">
                                </label>
                                <x-input-error :messages="$errors->get('sort')" class="mt-1" />

                                <label class="block mt-3">
                                    <span class="text-gray-700">Title</span>
                                    <input type="text" name="title" value="{{ old('title', $article->title) }}"
                                        class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('title') border-1 border-rose-600 @enderror">
                                </label>
                                <x-input-error :messages="$errors->get('title')" class="mt-1" />

                                <div class="col-span-full mt-3">
                                    <label for="file-upload"
                                        class="block text-sm font-medium leading-6 text-gray-900">Picture</label>
                                    <div
                                        class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                        <div class="text-center">
                                            @if (isset($article->picture) && Storage::exists($article->picture))
                                                <img src="{{ Storage::url($article->picture) }}"
                                                    alt="{{ $article->title }}"
                                                    class="mr-3 w-56 sm:w-48 rounded max-w-xs" />
                                            @else
                                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                            <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                                <label for="file-upload"
                                                    class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                    <span>Upload a file</span>
                                                    <input id="file-upload" type="file" name="picture"
                                                        value="{{ old('picture') }}" class="sr-only">
                                                </label>
                                                <p class="pl-1">or</p>&nbsp;<label
                                                    class="font-semibold text-indigo-600 cursor-pointer"
                                                    onclick="this.closest('form').elements.pictureclear.checked= this.closest('form').elements.pictureclear.checked? false:true;">
                                                    <input type="checkbox" name="pictureclear"
                                                        class="mt-1 align-sub inline-block rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">
                                                    Clear
                                                    a file</label>

                                            </div>
                                            <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 1MB</p>
                                        </div>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('picture')" class="mt-1" />

                                <label class="block mt-3">
                                    <span class="text-gray-700">Description</span>
                                    <textarea name="description" rows="5"
                                        class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">{{ old('description', $article->description) }}</textarea>
                                </label>
                                <x-input-error :messages="$errors->get('description')" class="mt-1" />
                                <x-primary-button class="mt-4">Update</x-primary-button>
                                <x-dropdown-link :href="route('article.index')">Close</x-dropdown-link>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
