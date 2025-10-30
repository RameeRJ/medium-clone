 @props(['user'])
 
 <div {{ $attributes }} x-data="{
     following: {{ $user->isFollowedBy(auth()->user()) ? 'true' : 'false' }},
     followersCount: {{ $user->followersCount() }},
     follow() {
         this.following = !this.following
         axios.post('/follow/{{ $user->id }}')
             .then(res => {
 
                 this.followersCount = res.data.followers
             })
             .catch(err => {
 
             })
     }
 }" class="border-l w-[320px] px-8">
 {{ $slot }}
 </div>
