@props(['user'])

<div {{ $attributes }} x-data="{
    following: {{ auth()->check() && $user->isFollowedBy(auth()->user()) ? 'true' : 'false' }},
    followersCount: {{ $user->followersCount() }},
    follow() {
        @auth
@if (!auth()->user()->hasVerifiedEmail())
                    window.location.href = '{{ route('verification.notice') }}';
                    return;
                @endif


this.following = !this.following
            axios.post('/follow/{{ $user->id }}')
                .then(res => {
                    this.followersCount = res.data.followers
                })
                .catch(err => {
                    // Handle error
                })
        @else
            window.location.href = '{{ route('login') }}' @endauth
    }
}" class="border-l w-[320px] px-8">
    {{ $slot }}
</div>
