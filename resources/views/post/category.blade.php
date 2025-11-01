<x-app-layout>
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <x-dashboard-tab />
          
                <div class="p-4 text-gray-900">

                    <x-category-tab>
                        No Categories Found
                    </x-category-tab>

                </div>
            <x-post-item :posts="$posts" />



        </div>
    </div>
</x-app-layout>
