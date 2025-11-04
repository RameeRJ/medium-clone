<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-8 bg-white shadow-sm rounded-2xl">

                {{-- Breadcrumb --}}
                <nav class="flex items-center text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('profile.show', $user) }}"
                                class="inline-flex items-center gap-2 text-gray-400 hover:text-black font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                {{ $user->name }}
                            </a>
                        </li>

                        <li>
                            <svg class="w-3 h-3 mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </li>

                        <li class="text-gray-500 font-medium">Followers</li>
                    </ol>
                </nav>

                {{-- Title --}}
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">
                        Followers ({{ $user->followers->count() }})
                    </h1>
                </div>

                {{-- Followers List with Fixed Height --}}
                @if ($followers->count() > 0)
                    <div class="space-y-6 h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach ($followers as $follower)
                            <div class="flex items-start justify-between">
                                {{-- Left: Avatar + Info --}}
                                <div class="flex items-center gap-4">
                                    <img src="{{ $follower->imageUrl('avatar') }}" alt="{{ $follower->name }}"
                                        class="w-12 h-12 rounded-full object-cover border border-gray-200">

                                    <div>
                                        <a href="{{ route('profile.show', $follower) }}"
                                            class="block text-gray-900 font-semibold text-lg hover:underline">
                                            {{ $follower->name }}
                                        </a>
                                    </div>
                                </div>

                                {{-- Follow Button --}}
                                <div>
                                    @if (!auth()->check() || auth()->user()->id !== $follower->id)
                                        <x-follow-container :user="$follower" class="flex gap-2 text-lg">

                                            <a href="#" @click.prevent="follow()">
                                                <span
                                                    x-text="following ? '{{ __('message.unfollow') }}' : '{{ __('message.follow') }}'"
                                                    :class="following ?
                                                        'px-4 py-1.5 text-sm border border-red-400 text-red-500 rounded-full hover:bg-red-100 transition' :
                                                        'px-4 py-1.5 text-sm border border-green-400 text-green-500 rounded-full hover:bg-green-100 transition'">
                                                </span>
                                            </a>

                                        </x-follow-container>
                                    @endif
                                </div>
                            </div>
                            <hr class="border-gray-200">
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-12 h-12 mx-auto mb-3 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-6 5.25a7.5 7.5 0 1 0 12 0 7.5 7.5 0 0 0-12 0Z" />
                        </svg>
                        <p>No followers yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Custom scrollbar style --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #c1c1c1;
            border-radius: 9999px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #a8a8a8;
        }
    </style>
</x-app-layout>
