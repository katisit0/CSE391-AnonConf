<div class="ml-{{ $depth * 4 }} mt-4 border p-2 rounded">
    <strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>: {{ $comment->content }}
    
    <form method="POST" action="{{ route('comments.report', $comment->id) }}" class="inline ml-2">
        @csrf
        <button type="submit" class="text-red-600 text-xs">Report</button>
    </form>

    @auth
        <button onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')" 
                class="text-blue-600 text-xs">Reply</button>

        <form method="POST" action="{{ route('comments.store') }}" 
              id="reply-form-{{ $comment->id }}" class="mt-2 ml-4 hidden">
            @csrf
            <input type="hidden" name="confession_id" value="{{ $comment->confession_id }}">
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <textarea name="content" required class="w-full border p-2 mt-2" placeholder="Write a reply..."></textarea>
            <x-primary-button>Reply</x-primary-button>
        </form>
    @endauth

    @foreach ($comment->replies as $reply)
        @include('components.comment', ['comment' => $reply, 'depth' => $depth + 1])
    @endforeach
</div>
