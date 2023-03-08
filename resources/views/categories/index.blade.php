<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categories') }}
            </h2>
            <Link href="{{ route('categories.create') }}"
            class='px-4 py-2 bg-indigo-400 hover:bg-indigo-600 text-white rounded-md'
            style="background-color: rgb(129 140 248);">
            New Category
            </Link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-table :for="$categories">
                    @cell('action',$category)
                        <Link href="{{ route('categories.edit',$category->id) }}"
                            class="text-green-600 hover:text-green-400 font-semibold">✏️</Link>
                        <Link
                        confirm="Delete Category"
                        confirm-text="Are you sure?"
                        confirm-button="Yes"
                        cancel-button="Cancel"
                        href="{{ route('categories.destroy',$category->id) }}"
                        class="text-red-600 hover:text-red-400 font-semibold"
                        method="DELETE"
                        preserve-scroll>
                        🗑️
                        </Link>
                            @endcell
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>