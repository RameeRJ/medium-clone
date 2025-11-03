<x-app-layout>
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ isset($post) ? route('post.update', $post) : route('post.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($post))
                        @method('PUT')
                    @endif

                    @if (isset($post) && $post->getFirstMediaUrl())
                        <img src="{{ $post->getFirstMediaUrl() }}" alt="Post Image"
                            class="mt-2 h-32 w-auto rounded-lg border">
                    @endif
                    <!-- Image -->
                    <div class="mt-2 mb-4">
                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image"
                            autofocus />

                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Title -->
                    <div class="mt-4 mb-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title', $post->title ?? '')" autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div class="mt-4 mb-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <x-select-input id="category_id" name="category_id" class="block mt-1 w-full">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <x-input-label for="content" :value="__('Content')" />
                        <x-textarea-input id="content" class="block mt-1 w-full" name="content">
                            {{ old('content', $post->content ?? '') }}
                        </x-textarea-input>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <x-primary-button class="mt-4">
                        {{ isset($post) ? __('Update') : __('Submit') }}
                    </x-primary-button>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
