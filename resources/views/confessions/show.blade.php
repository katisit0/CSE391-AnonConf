<!-- BEST VERSION  -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Full Confession') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Confession Content Box -->
                    <div class="bg-gray-100 rounded-lg max-w-3xl mx-auto" style="height: auto; overflow-y: auto;">
                        <h3 class="font-semibold text-lg whitespace-pre-wrap">
                            {!! nl2br(e($confession->content)) !!}
                        </h3>
                    </div>

                    <p class="text-sm text-gray-600 mt-4">Mood: {{ $confession->mood->name ?? 'N/A' }}</p>

                    <p class="text-sm text-gray-500">Posted at: {{ $confession->created_at->format('d M Y, H:i') }}</p>

                    <!-- Success or Warning Messages -->
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @elseif(session('warning'))
                        <div class="bg-yellow-500 text-white p-4 rounded-lg mb-4">
                            <strong>{{ session('warning') }}</strong>
                        </div>
                    @endif

                    <!-- Upvote Button -->
                    <form method="POST" action="{{ route('confessions.upvote', $confession->id) }}" class="mt-4 flex items-center space-x-2">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                            Upvote
                        </button>
                        <span class="text-gray-700 font-medium">
                            {{ $confession->upvotes }} {{ Str::plural('upvote', $confession->upvotes) }}
                        </span>
                    </form>

                    <!-- Report Button & Hidden Textarea -->
                    <form method="POST" action="{{ route('confessions.report', $confession->id) }}" class="mt-2" id="report-form">
                        @csrf
                        <!-- Initially hidden textarea -->
                        <textarea id="report-reason" name="reason" class="w-full border p-2 rounded hidden" placeholder="Report reason" required></textarea>
                        <button type="button" id="show-report-form" style="background-color: #f56565; color: white; padding: 8px 16px; border-radius: 8px; transition: background-color 0.3s; margin-top: 8px;">
                            Report
                        </button>
                        <!-- Submit button, initially hidden -->
                        <button type="submit" id="submit-report" class="text-white bg-blue-500 rounded p-2 mt-2 hidden">
                            Submit Report
                        </button>
                    </form>

                    <!-- Comments Section -->
                    @auth
                        <form method="POST" action="{{ route('comments.store') }}">
                            @csrf
                            <input type="hidden" name="confession_id" value="{{ $confession->id }}">
                            <textarea name="content" required class="w-full border p-2"></textarea>
                            <x-primary-button>Post Comment</x-primary-button>
                        </form>
                    @else
                        <p class="mt-4"><a href="{{ route('login') }}">Log in</a> to comment.</p>
                    @endauth

                    <!-- Loop Through Comments -->
                    @foreach ($confession->comments->whereNull('parent_id') as $comment)
                        @include('components.comment', ['comment' => $comment, 'depth' => 0])
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle the reply form visibility when the "Reply" button is clicked
        document.querySelectorAll('.reply-button').forEach(button => {
            button.addEventListener('click', function () {
                const commentId = this.getAttribute('data-comment-id');
                const replyForm = document.getElementById(`reply-form-${commentId}`);
                replyForm.classList.toggle('hidden');
            });
        });

        // Toggle the visibility of the report reason textarea and submit button
        document.getElementById('show-report-form').addEventListener('click', function () {
            document.getElementById('report-reason').classList.remove('hidden');
            document.getElementById('submit-report').classList.remove('hidden');
            document.getElementById('show-report-form').classList.add('hidden');  // Hide the report button after click
        });

        // Optional: Hide the fields again after submitting the report
        document.getElementById('report-form').addEventListener('submit', function () {
            document.getElementById('report-reason').classList.add('hidden');
            document.getElementById('submit-report').classList.add('hidden');
            document.getElementById('show-report-form').classList.remove('hidden');  // Show the report button again
        });
    </script>
</x-app-layout>
