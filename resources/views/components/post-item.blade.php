<div class="mt-5 text-gray-900">
    @forelse ($posts as $post)
        <div class="flex bg-white border border-gray-200 rounded-lg shadow-sm mb-8">

            <div class="p-5 flex-1">
                <div class="flex items-center gap-2 mb-3">
                    <a href="{{ route('profile.show', $post->user) }}" class= "hover:underline flex gap-1 items-center">
                        <x-avatar :user="$post->user" size="w-6 h-6" />
                        <span class="text-gray-700 font-sm text-sm">{{ $post->user->username }}</span>
                    </a>
                </div>
                <a href="{{ route('post.show', ['user' => $post->user, 'post' => $post]) }}">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                        {{ $post->title }}
                    </h5>
                </a>
                <div class="mb-3 font-normal text-gray-700">
                    {{ Str::words($post->content, 20) }}
                </div>
                <div class="mt-4 px-1 mb-4 flex items-center justify-between">
                    {{-- Left section: date + claps --}}
                    <div class="flex gap-5 items-center">
                        <span class="font-sm text-sm text-gray-500">{{ $post->created_at->format('d M') }}</span>

                        <a href="{{ route('post.show', ['user' => $post->user, 'post' => $post]) }}"
                            class="flex gap-1 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5 transition-transform duration-300 text-gray-500">
                                <path
                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                            </svg>
                            <span class="text-sm text-gray-500">{{ $post->claps->count() }}</span>
                        </a>
                        <a href="{{ route('post.show', ['user' => $post->user, 'post' => $post]) }}"
                            class="flex gap-1 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5 transition-transform duration-300 text-gray-500">
                                <path fill-rule="evenodd"
                                    d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.025 4.587 2.674 6.192.232.226.277.428.254.543a3.73 3.73 0 0 1-.814 1.686.75.75 0 0 0 .44 1.223ZM8.25 10.875a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25ZM10.875 12a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875-1.125a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <span class="text-sm text-gray-500">{{ $post->comments->count() }}</span>
                        </a>
                    </div>


                    {{-- Right section: 3 dots --}}
                    @if (!auth()->check() || auth()->user()->id !== $post->user->id)
                        @if (request()->routeIs('dashboard', 'post.categories', 'post.category'))
                            <div x-data="{ open: false }" class="relative inline-block text-left">
                                <!-- Trigger button -->
                                <div @click="open = !open" class="text-gray-500 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm6 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm6 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                </div>


                                <!-- Dropdown menu -->
                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">


                                    {{-- <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Follow author</a> --}}
                                    <x-follow-container :user="$post->user">
                                        <a href="#" @click.prevent="follow()" class="text-green-500">
                                            <span x-text="following ? 'Unfollow' : 'Follow'"
                                                :class="following ? 'block py-2 text-red-600 hover:text-red-600' :
                                                    'block  py-2 text-green-600 hover:text-green-800'">
                                            </span>
                                        </a>
                                    </x-follow-container>
                                </div>
                            </div>
                        @endif
                    @endif


                </div>

                {{-- <a href="{{ route('post.show', ['user' => $post->user, 'post' => $post]) }}">
                    <x-primary-button>
                        Read more
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </x-primary-button>
                </a> --}}
            </div>
            <a href="{{ route('post.show', ['user' => $post->user, 'post' => $post]) }}">
                <img class="w-48 h-full max-h-[16rem] object-cover rounded-r-lg" src="{{ $post->imageUrl() }}"
                    alt="">

            </a>
        </div>
    @empty
        <div class="text-center text-gray-300 py-16">No Posts Found</div>
    @endforelse
</div>
{{ $posts->onEachSide(1)->links('vendor.pagination.tailwind') }}
