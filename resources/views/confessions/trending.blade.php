<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trending Confessions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($confessions->isEmpty())
                        <p class="text-gray-600">No trending confessions right now. Check back later!</p>
                    @else
                        @foreach ($confessions as $confession)
                            <a href="{{ route('confessions.show', $confession->id) }}" 
                               class="block bg-white hover:bg-gray-100 p-4 rounded-md shadow mb-4 transition">
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-800">{{ Str::limit($confession->content, 100) }}</p>
                                    <span class="text-sm text-gray-500">
                                        {{ $confession->upvotes + $confession->comments_count }} points
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>