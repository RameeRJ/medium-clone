<x-app-layout>
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">

                    <x-category-tab>
                        No Categories Found
                    </x-category-tab>

                </div>
            </div>
            <div class="mt-8 text-gray-900">
                @forelse ($posts as $post)
                    <x-post-item :post="$post"> </x-post-item>
                @empty
                    <div class="text-center text-gray-300 py-16">No Posts Found</div>
                @endforelse
            </div>
            {{ $posts->onEachSide(1)->links('vendor.pagination.tailwind') }}

        </div>
    </div>
</x-app-layout>