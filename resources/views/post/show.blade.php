<x-app-layout>
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-3xl mb-4">{{ $post->title }}</h1>
                {{-- User avatar and details section --}}
                <div class="flex gap-4">
                    <img src="{{ $user->imageUrl() }}" alt="{{ $user->name }}"
                        class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <div class="flex gap-2 text-lg">
                            <h3>{{ $user->name }}</h3>
                            &middot;
                            <a href="#" class="text-green-500">Follow</a>
                        </div>
                        <div class="flex gap-2 text-gray-500 text-sm">
                            {{ $post->readTime() }} min read
                            &middot;
                            {{ $post->created_at->format('M d,Y') }}
                        </div>
                    </div>

                </div>

                {{-- Clap section --}}
                <x-clap-button />

                {{-- Content section --}}
                <div>
                    <div class="mt-8">
                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"
                            class="w-full h-full h-max-68 object-cover mb-8 rounded-lg">
                        <div class="mt-4">
                            {{ $post->content }}
                        </div>
                    </div>
                </div>

                {{-- Category tag section --}}
                <div class="mt-8">
                    <span class="px-4 py-2 bg-gray-200 rounded-xl">
                        {{ $post->category->name }}
                    </span>
                </div>

                <x-clap-button />

            </div>

        </div>
    </div>
</x-app-layout>
