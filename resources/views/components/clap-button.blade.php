@props(['post'])

<div>
    <div x-data="{
        hasClapped: {{ auth()->user()->hasClapped($post) ? 'true' : 'false' }},
        clapCount: {{ $post->claps()->count() }},
        commentCount: {{ $post->comments()->count() ?? 0 }},
        isAnimating: false,
        clap() {
            @if (!auth()->user()->hasVerifiedEmail()) window.location.href = '{{ route('verification.notice') }}'; return; @endif
            this.isAnimating = true;
            axios.post('/clap/{{ $post->id }}')
                .then(res => {
                    this.hasClapped = !this.hasClapped;
                    this.clapCount = res.data.claps;
                    setTimeout(() => this.isAnimating = false, 500);
                })
                .catch(err => console.error(err));
        },
        scrollToComments() {
            const commentSection = document.querySelector('#comment-section');
            if (commentSection) commentSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }" class="mt-8 border-b border-t p-2 px-6 flex items-center justify-between gap-4">

        <!-- Left Side: Clap and Comment -->
        <div class="flex items-center gap-4">
            <!-- Clap -->
            <button @click="clap()"
                class="relative flex items-center gap-2 text-gray-500 hover:text-gray-700 cursor-pointer">
                <div x-show="isAnimating" x-transition.scale.origin.center
                    class="absolute -inset-2 rounded-full bg-gray-400/50 animate-ping"></div>

                <template x-if="!hasClapped">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-7 transition-transform duration-300"
                        :class="{ 'scale-125 text-gray-500': isAnimating }">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904" />
                    </svg>
                </template>

                <template x-if="hasClapped">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-7 text-gray-800 transition-transform duration-300"
                        :class="{ 'scale-125': isAnimating }">
                        <path
                            d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777Z" />
                    </svg>
                </template>

                <span x-text="clapCount" class="text-sm font-semibold transition-all duration-300"
                    :class="{ 'scale-125 text-gray-500': isAnimating }"></span>
            </button>

            <!-- Comment -->
            <button @click="scrollToComments()"
                class="flex items-center gap-2 text-gray-500 hover:text-gray-700 cursor-pointer transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM12 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                </svg>
                <span x-text="commentCount" class="text-sm font-semibold"></span>
            </button>
        </div>

        <!-- Right Side: Edit / Delete -->
        @auth
            @if (auth()->id() === $post->user_id)
                <x-three-dot :post="$post" />
            @endif
        @endauth
    </div>
</div>
