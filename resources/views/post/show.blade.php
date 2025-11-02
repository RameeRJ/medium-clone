<x-app-layout>
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-3xl mb-4">{{ $post->title }}</h1>
                {{-- User avatar and details section --}}
                <div class="flex gap-4">
                    <x-avatar :user="$user" />
                    <div>
                        <x-follow-container :user="$user" class="flex gap-2 text-lg">
                            <a href="{{ route('profile.show', $user) }}" class="hover:underline">{{ $user->name }}</a>
                            @if (!auth()->check() || auth()->user()->id !== $user->id)
                                &middot;
                                <a href="#" @click.prevent="follow()" class="text-green-500">
                                    <span x-text="following ? '{{ __('message.unfollow') }}' : '{{ __('message.follow') }}'"
                                        :class="following ? 'text-red-600 hover:text-red-600' :
                                            'text-green-600 hover:text-green-800'">
                                    </span>
                                </a>
                            @endif
                        </x-follow-container>
                        <div class="flex gap-2 text-gray-500 text-sm">
                            {{ $post->readTime() }} min read
                            &middot;
                            {{ $post->created_at->format('M d,Y') }}
                        </div>


                    </div>

                </div>
                {{-- Clap section --}}
                @auth
                    <x-clap-button :post="$post" />
                @endauth

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
                    <a href="{{ route('post.category',$post->category->name) }}" class="px-4 py-2 bg-gray-200 rounded-xl">
                       {{ __('categories.' . $post->category->name) }}

                    </a>
                </div>

                {{-- <x-clap-button :post="$post" /> --}}
                @auth
                    <div id="comment-section">
                        <x-comment-box :post="$post" />
                    </div>
                @endauth

            </div>

        </div>
    </div>

</x-app-layout>
