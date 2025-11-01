<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex">

                    <div class="flex-1" x-data="{ activeTab: 'home' }">
                        <h1 class="text-5xl font-bold"> {{ $user->name }} </h1>

                        <div class="mt-4 ">
                            <div class="mb-4 border-b border-gray-200">
                                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                                    data-tabs-toggle="#default-tab-content" role="tablist">
                                    <li class="me-2" role="presentation">
                                        <button @click="activeTab = 'home'"
                                            :class="activeTab === 'home' ? 'border-gray-600 text-black' :
                                                'border-transparent text-gray-500 hover:text-black'"
                                            class="inline-block p-4 border-b rounded-t-lg" id="home-tab"
                                            data-tabs-target="#home" type="button" role="tab" aria-controls="home"
                                            aria-selected="true">Home</button>
                                    </li>

                                    <li class="me-2" role="presentation">
                                        <button @click="activeTab = 'about'"
                                            :class="activeTab === 'about' ? 'border-gray-600 text-black' :
                                                'border-transparent text-gray-500 hover:text-black'"
                                            class="inline-block p-4 border-b rounded-t-lg" id="about-tab"
                                            data-tabs-target="#about" type="button" role="tab"
                                            aria-controls="about" aria-selected="false">About</button>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <div class="pr-2">
                            {{-- Content for the 'Home' tab (Posts) --}}
                            <div x-show="activeTab === 'home'">
                                <x-post-item :posts="$posts" />
                            </div>

                            {{-- Content for the 'About' tab (New Section) --}}
                            <div x-show="activeTab === 'about'">
                                <div class="p-4 ">
                                    @if ($user->bio)
                                        <h2 class="text-xl mb-8">{{ $user->bio }}</h2>
                                    @endif
                                    <div class="flex text-green-600 gap-2 mb-8">
                                        <a href="#" class="hover:text-green-700">{{ $user->followers()->count() }}
                                            Followers</a>
                                        <span class="text-xl font-bold">&middot;</span>
                                        <a href="#" class="hover:text-green-700">{{ $user->following()->count() }}
                                            Following</a>
                                    </div>

                                    <div class="mt-8 mb-8 text-gray-700 text-sm">
                                        <a href="mailto:{{ $user->email }}" class="flex gap-1">Connected with
                                            <span class="font-semibold">{{ $user->email }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                            </svg>

                                        </a>
                                    </div>
                                    <span class="text-gray-500 text-sm">Writerspace Member Since
                                        {{ $user->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>


                    </div>
                    {{-- sideprofile remains unchanged --}}
                    <x-follow-container :user="$user">
                        {{-- ... (rest of sideprofile code) ... --}}
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
                            @if (!auth()->user() || (auth()->user() && auth()->user()->id !== $user->id))
                                <div class="flex items-center gap-3 mt-4">
                                    <button @click="follow(); triggerFirework(!following)"
                                        class="px-4 py-2 text-white rounded-full transform hover:scale-110 transition duration-300 ease-in-out flex items-center justify-center shadow-md hover:shadow-lg relative overflow-visible"
                                        x-text="following ? 'Unfollow' : 'Follow'"
                                        :class="following ? 'bg-red-600 hover:bg-red-600' : 'bg-green-600 hover:bg-green-800'">
                                    </button>
                                    <a href="mailto:{{ $user->email }}"
                                        class="px-3 py-2 bg-green-600 text-white rounded-full hover:bg-green-800 transform hover:scale-110 transition duration-300 ease-in-out flex items-center justify-center shadow-md hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>
                                    </a>
                                </div>
                            @endif
                            @if ($user->followingCount() > 0)
                                <div>
                                    <h4 class="mt-6 font-semibold mb-4">Following</h4>

                                    @foreach ($following as $user)
                                        <div class="flex items-center gap-4 mb-1">
                                            <x-avatar :user="$user" size="w-8 h-8" />
                                            <a href="{{ route('profile.show', $user) }}"
                                                class="text-gray-500 hover:text-black hover:underline">{{ $user->name }}</a>
                                        </div>
                                    @endforeach


                                    @if ($user->followingCount() > 10)
                                        <div class="mt-4">
                                            <a href="#" class="text-gray-500 hover:underline text-[14px] px-2">
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
    <style>
        @keyframes firework {
            0% {
                transform: translate(0, 0) scale(0);
                opacity: 1;
            }

            100% {
                transform: translate(var(--tx), var(--ty)) scale(1);
                opacity: 0;
            }
        }

        .firework-particle {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            pointer-events: none;
            animation: firework 0.8s ease-out forwards;
        }

        .firework-particle.green {
            background: radial-gradient(circle, #22c55e, #16a34a);
            box-shadow: 0 0 10px #22c55e;
        }

        .firework-particle.red {
            background: radial-gradient(circle, #22c55e, #dc2626);
            box-shadow: 0 0 10px #ef4444;
        }
    </style>

    <script>
        function triggerFirework(isFollowing) {
            const button = event.currentTarget;
            const rect = button.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;

            // Determine color based on action (isFollowing means we're about to follow)
            const colorClass = isFollowing ? 'red' : 'green';

            // Create 12 particles for firework effect
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = `firework-particle ${colorClass}`;

                const angle = (i / 12) * Math.PI * 2;
                const distance = 50 + Math.random() * 30;
                const tx = Math.cos(angle) * distance;
                const ty = Math.sin(angle) * distance;

                particle.style.cssText = `
            left: ${centerX}px;
            top: ${centerY}px;
            --tx: ${tx}px;
            --ty: ${ty}px;
        `;

                document.body.appendChild(particle);

                setTimeout(() => particle.remove(), 800);
            }
        }
    </script>
</x-app-layout>
