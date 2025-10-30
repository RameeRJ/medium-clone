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
            <x-post-item :posts="$posts" />

            

        </div>
    </div>
</x-app-layout>
