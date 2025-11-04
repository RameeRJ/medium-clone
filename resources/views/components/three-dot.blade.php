@props(['post'])

<div x-data="{ open: false }" class="relative inline-block text-left"> <!-- Trigger button -->
    <div @click="open = !open" class="text-gray-500 cursor-pointer"> <svg xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm6 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm6 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
        </svg> </div> <!-- Dropdown menu -->
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
        @auth @if (auth()->user()->id === $post->user->id)
            <!-- Edit --> <a href="{{ route('post.edit', $post) }}"
                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm"> Edit </a>
            <!-- Delete -->
            <form action="{{ route('post.delete', $post) }}" method="POST"> @csrf
                @method('DELETE') <button type="submit"
                    class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 text-sm">
                    Delete </button> </form>
        @else
            <!-- Follow/Unfollow --> <x-follow-container :user="$post->user"> <a href="#" @click.prevent="follow()"
                    class="block px-4 py-2 text-green-600 hover:text-green-800 text-sm"> <span
                        x-text="following ? '{{ __('message.unfollow') }}' : '{{ __('message.follow') }}'"></span>
                </a> </x-follow-container>
        @endif
    @else
        <!-- For guest users, only show Follow --> <x-follow-container :user="$post->user"> <a href="#"
                @click.prevent="follow()" class="block px-4 py-2 text-green-600 hover:text-green-800 text-sm"> <span
                    x-text="'{{ __('message.follow') }}'"></span> </a> </x-follow-container>
    @endauth
</div>
