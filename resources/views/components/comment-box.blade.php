@props(['post'])

<div class="mt-8 mb-8 border-t border-gray-800">
    <div x-data="{
        comments: {{ $post->comments()->latest()->with('user')->get()->toJson() }},
        commentText: '',
        isSubmitting: false,
        showAll: false,
    
        get displayedComments() {
            return this.showAll ? this.comments : this.comments.slice(0, 3);
        },
    
        get hasMoreComments() {
            return this.comments.length > 3;
        },
    
        async submitComment() {
            @if(!auth()->user()->hasVerifiedEmail())
            window.location.href = '{{ route('verification.notice') }}';
            return;
            @endif
    
            if (!this.commentText.trim()) return;
    
            this.isSubmitting = true;
    
            try {
                const res = await axios.post('/posts/{{ $post->id }}/comments', {
                    body: this.commentText
                });
    
                this.comments.unshift(res.data.comment);
                this.commentText = '';
            } catch (err) {
                console.error(err);
            } finally {
                this.isSubmitting = false;
            }
        },
    
    
    }">
        <!-- Header -->
        <div class="pt-7 text-2xl font-bold">
            {{ __('message.responses') }} (<span x-text="comments.length"></span>)
        </div>

        <!-- Comment Form -->
        <div class="mt-3 flex items-center gap-3">
            <x-avatar :user="auth()->user()" size="w-8 h-8" />
            <span class="font-sm text-sm text-gray-900">{{ auth()->user()->name }}</span>
        </div>

        <div class="mt-4 border border-gray-300 rounded-lg bg-white">
            <div class="p-3 bg-gray-50 rounded-lg">
                <textarea x-model="commentText" @keydown.ctrl.enter="submitComment()" placeholder={{ __('message.thoughts_placeholder') }}
                    class="w-full border-none focus:ring-0 resize-none text-gray-700 placeholder-gray-500 bg-white rounded-md p-3 shadow-sm"
                    rows="3"></textarea>
                <div class="mt-3 flex justify-end">
                    <button @click="submitComment()" :disabled="isSubmitting || !commentText.trim()" type="button"
                        class="bg-gray-800 text-white font-semibold px-4 py-1.5 rounded-lg disabled:opacity-50 shadow">
                        <span x-show="!isSubmitting">{{ __('message.respond') }}</span>
                        <span x-show="isSubmitting">{{ __('message.posting') }}</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Comments List -->
        <div class="mt-6 space-y-4">
            <template x-for="comment in displayedComments" :key="comment.id">
                <div class="border-b border-gray-200 pb-4">
                    <!-- Comment Header -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img :src="comment.user.avatar_url" class="w-8 h-8 rounded-full object-cover"
                                :alt="comment.user.name">
                            <div>
                                <div class="font-sm text-sm text-gray-900" x-text="comment.user.name"></div>
                                <div class="text-sm text-gray-500"
                                    x-text="new Date(comment.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comment body -->
                    <div class="mt-3 ml-12 text-gray-700 whitespace-pre-wrap" x-text="comment.body"></div>
                </div>
            </template>

            <!-- See All Button -->
            <template x-if="hasMoreComments && !showAll">
                <div class="text-center pt-4">
                    <button @click="showAll = true"
                        class="text-gray-600 hover:text-gray-900 font-medium text-sm border border-black p-2 rounded-full">
                        See all <span x-text="comments.length-3"></span> responses
                    </button>
                </div>
            </template>

            <!-- Show Less Button -->
            <template x-if="showAll && hasMoreComments">
                <div class="text-center pt-4">
                    <button @click="showAll = false"
                        class="text-gray-600 hover:text-gray-900 font-medium text-sm border border-black p-2 rounded-full">
                        Show less
                    </button>
                </div>
            </template>

            <!-- Empty state -->
            <template x-if="comments.length === 0">
                <div class="text-center py-8 text-gray-500">
                    No responses yet. Be the first to share your thoughts!
                </div>
            </template>
        </div>
    </div>
</div>
