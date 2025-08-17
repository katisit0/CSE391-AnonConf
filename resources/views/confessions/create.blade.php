<x-guest-layout>
    <h2 class="text-xl font-semibold mb-4">Post a Confession</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php($moods = \App\Models\Mood::all())

    <form method="POST" action="{{ route('confessions.store') }}" class="space-y-4">
        @csrf

        <div>
            <label for="content" class="block font-medium mb-1">Your Confession</label>
            <textarea name="content" id="content" rows="5" class="w-full border border-gray-300 p-1.5 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Write your confession here..." required>{{ old('content') }}</textarea>
        </div>

        <div>
            <label for="mood_id" class="block font-medium mb-1">Mood (optional)</label>
            <select name="mood_id" id="mood_id" class="w-full border border-gray-300 p-2 rounded">
                <option value="">Select a mood</option>
                @foreach ($moods as $mood)
                    <option value="{{ $mood->id }}" {{ old('mood_id') == $mood->id ? 'selected' : '' }}>
                        {{ $mood->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 block w-fit mt-4 z-10 relative">
            Confess
        </button>

        </div>
    </form>
</x-guest-layout>
