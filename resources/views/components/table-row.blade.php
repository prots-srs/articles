{{-- <x-ppr :object="$article->picture" /> --}}
{{-- <x-ppr :object="Storage::exists($article->picture)" /> --}}
{{-- <x-ppr :object="Storage::url($article->picture)" /> --}}
<div
    class="py-5 px-4 flex justify-between border-l-4 border-transparent bg-transparent @if ($article->publish) hover:border-green-400 hover:bg-gray-200 @else hover:border-red-500 hover:bg-red-50 @endif">
    <div class="flex flex-col">
        <div class="sm:pl-4 pr-8 flex sm:items-top">
            @if (isset($article->picture) && Storage::exists($article->picture))
                <img src="{{ Storage::url($article->picture) }}" alt="{{ $article->title }}"
                    class="mr-3 w-56 sm:w-36 rounded max-w-xs" />
            @endif
            <div class="space-y-1">
                <p class="text-sm text-gray-400">
                    @if (isset($article->sort))
                        {{ _('Sort:') }} <span class="text-gray-600">{{ $article->sort }}</span><br>
                    @endif
                    {{ _('Created at:') }} <span
                        class="text-gray-600">{{ $article->created_at->format('j M Y, g:i a') }}</span><br>
                    {{ _('Updated at: ') }}<span
                        class="text-gray-600">{{ $article->updated_at->format('j M Y, g:i a') }}</span>
                </p>
                <x-nav-link :href="route('article.show', $article)">
                    <p class="text-base text-gray-700 font-bold tracking-wide">{{ $article->title }}</p>
                </x-nav-link>
            </div>
        </div>
        <div class="space-y-1 mt-3">
            <p class="text-sm text-gray-500 font-medium">{{ $article->description }}</p>
        </div>
    </div>

    <div class="pr-4 flex flex-col justify-between items-end">
        <div>
            @if ($article->publish)
                <div class="relative">
                    <span class="text-xs text-gray-500 font-semibold">{{ _('Publish') }}</span>
                    <span class="absolute top-1 -right-2 w-2 h-2 rounded-full bg-green-400 animate-pulse" />
                </div>
            @else
                <span class="text-xs text-red-500 font-semibold">{{ _('Unpublish') }}</span>
            @endif
        </div>
        <x-dropdown>
            <x-slot name="trigger">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                </button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link :href="route('article.edit', $article)">
                    {{ __('Edit') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('article.destroy', $article) }}">
                    @csrf
                    @method('delete')
                    <x-dropdown-link :href="route('article.destroy', $article)" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Delete') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</div>
