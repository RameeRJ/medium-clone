<div x-data="{ scrollLeft() { $refs.tabs.scrollBy({ left: -200, behavior: 'smooth' }) }, scrollRight() { $refs.tabs.scrollBy({ left: 200, behavior: 'smooth' }) } }" class="relative w-full max-w-5xl mx-auto">
    <!-- Left Arrow -->
    <button @click="scrollLeft"
        class="absolute left-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100 z-10">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <!-- Scrollable Categories -->
    <ul x-ref="tabs"
        class="flex flex-nowrap overflow-x-auto no-scrollbar space-x-2 px-10 py-2 text-medium font-medium text-center text-gray-700 justify-start">
        <li>
            <a href="{{ route('post.categories') }}"
                class="{{ request('category') ? 'inline-block px-4 py-2 rounded-xl hover:text-gray-900 hover:bg-gray-300 bg-gray-200 ' : 'inline-block px-4 py-2 text-white bg-gray-800 rounded-xl ' }}">
                All
            </a>
        </li>

        @forelse($categories as $category)
            <li class="flex-shrink-0">
                <a href="{{ route('post.category', $category) }}"
                    class="{{ Route::currentRouteNamed('post.category') && request('category')->id === $category->id ? 'inline-block px-4 py-2 text-white bg-gray-800 rounded-xl ' : 'inline-block px-4 py-2 rounded-xl hover:text-gray-900 hover:bg-gray-300 bg-gray-200 ' }}">
                    {{ $category->name }}
                </a>
            </li>
        @empty
            {{ $slot }}
        @endforelse
    </ul>

    <!-- Right Arrow -->
    <button @click="scrollRight"
        class="absolute right-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100 z-10">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>
</div>
<style>
    /* Add this to your app.css or a Tailwind layer */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }
</style>
