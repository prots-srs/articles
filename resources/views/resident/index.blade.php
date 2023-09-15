<x-app-layout>
    <x-slot name="title">Resident list</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Resident list</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
                        <div class="not-prose relative bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25">
                            <div class="relative rounded-xl overflow-auto">
                                <div class="shadow-sm overflow-hidden my-8">
                                    <table class="table-auto border-collapse w-full text-sm">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                                    ID</th>
                                                <th
                                                    class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                                    Name</th>
                                                <th
                                                    class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                                    Email</th>
                                                <th
                                                    class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                                    Verified</th>
                                                <th
                                                    class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-slate-800">
                                            @foreach ($list as $item)
                                                <tr>
                                                    <td
                                                        class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                        {{ $item->id }}</td>
                                                    <td
                                                        class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                        {{ $item->name }}</td>
                                                    <td
                                                        class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                        {{ $item->email }}</td>
                                                    <td
                                                        class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                        {{ $item->email_verified_at }}</td>
                                                    <td
                                                        class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                        <a href="{{ route('resident.edit', $item) }}">Edit</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div
                                class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
