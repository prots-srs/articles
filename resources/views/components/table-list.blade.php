<div class="mx-auto w-full max-w-4xl bg-white">
    <ul class="flex flex-col">
        @foreach ($list as $article)
            <li class="border-b-2 border-gray-100">
                <x-table-row :article="$article" />
            </li>
        @endforeach
    </ul>
    {{ $list->links('vendor.pagination.tailwind-ext') }}
</div>
