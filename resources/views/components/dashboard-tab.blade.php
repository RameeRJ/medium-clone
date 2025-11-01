<div class="mt-2">
    <div class="mb-2 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="me-2" role="presentation">
                <a href="{{ route('dashboard') }}"
                    class="{{ Route::currentRouteNamed('dashboard') ? 'inline-block p-4 border-b border-gray-600 rounded-t-lg' : 'inline-block p-4 border-b text-gray-500 hover:text-black rounded-t-lg' }}">For
                    you</a>
            </li>

            <li class="me-2" role="presentation">
                <a href="{{ route('post.categories') }}"
                    class="{{ request()->routeIs('post.categories*') || request()->routeIs('post.category*') ? 'inline-block p-4 border-b border-gray-600 rounded-t-lg' : 'inline-block p-4 border-b text-gray-500 hover:text-black rounded-t-lg' }}">Categories</a>
            </li>
        </ul>
    </div>

</div>
