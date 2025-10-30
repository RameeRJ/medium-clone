    <x-app-layout>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex">
                        {{-- mainprofile --}}
                        <div class="flex-1">
                            <h1 class="text-5xl font-bold"> {{ $user->name }} </h1>

                            <div class="mt-4 ">
                                <div class="mb-4 border-b border-gray-200">
                                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                                        data-tabs-toggle="#default-tab-content" role="tablist">
                                        <li class="me-2" role="presentation">
                                            <button class="inline-block p-4 border-b border-gray-600 rounded-t-lg"
                                                id="profile-tab" data-tabs-target="#profile" type="button"
                                                role="tab" aria-controls="profile"
                                                aria-selected="false">Home</button>
                                        </li>

                                        <li class="me-2" role="presentation">
                                            <button
                                                class="inline-block p-4 border-b text-gray-500 hover:text-black rounded-t-lg"
                                                id="profile-tab" data-tabs-target="#profile" type="button"
                                                role="tab" aria-controls="profile"
                                                aria-selected="false">About</button>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="pr-2">
                                <x-post-item :posts="$posts" />
                            </div>


                        </div>


                        {{-- sideprofile --}}
                        <x-follow-container :user="$user">
                            <x-avatar :user="$user" size="w-24 h-24" />
                            <div class="mt-4">
                                <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
                                <a href="#" class="block py-1 text-gray-500 hover:text-gray-700 "><span
                                        x-text="followersCount">

                                    </span>
                                    followers</a>

                                <p class="text-gray-500">
                                    {{ $user->bio ?? 'No Bio' }}
                                </p>
                                @if (auth()->user() && auth()->user()->id !== $user->id)
                                    <div class="flex items-center gap-3 mt-4">
                                        <button @click="follow()"
                                            class="px-4 py-2 text-white rounded-full  transform hover:scale-110 transition duration-300 ease-in-out flex items-center justify-center shadow-md hover:shadow-lg"
                                            x-text="following ? 'Unfollow' : 'Follow'"
                                            :class="following ? 'bg-red-600 hover:bg-red-600' :
                                                'bg-green-600 hover:bg-green-800'">

                                        </button>
                                        <button
                                            class="px-3 py-2 bg-green-600 text-white rounded-full hover:bg-green-800 transform hover:scale-110 transition duration-300 ease-in-out flex items-center justify-center shadow-md hover:shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                                @if ($user->followingCount() > 0)
                                    <div>
                                        <h4 class="mt-6 font-semibold mb-4">Following</h4>

                                        @foreach ($following as $user)
                                            <div class="flex items-center gap-4">
                                                <x-avatar :user="$user" size="w-8 h-8" />
                                                <a href="{{ route('profile.show', $user) }}"
                                                    class="text-gray-500 hover:text-black hover:underline">{{ $user->name }}</a>
                                            </div>
                                        @endforeach


                                        @if ($user->followingCount() > 10)
                                            <div class="mt-4">
                                                <a href="#"
                                                    class="text-gray-500 hover:underline text-[14px] px-2">
                                                    See all ({{ $user->followingCount() - 10 }} more)
                                                </a>
                                            </div>
                                        @endif


                                    </div>
                                @endif
                        </x-follow-container>
                    </div>
                </div>
            </div>





        </div>
        </div>
    </x-app-layout>
