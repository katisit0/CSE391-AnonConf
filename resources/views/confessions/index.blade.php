<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confessions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Display all confessions -->
                    <h3 class="font-semibold text-lg mb-4">All Confessions</h3>
                    
                    @if($confessions->isEmpty())
                        <p>No confessions to display.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach($confessions as $confession)
                                <li class="bg-gray-100 p-4 rounded-lg">
                                    <!-- Make confession clickable, linking to its full view -->
                                    <a href="{{ route('confessions.show', $confession->id) }}" class="text-blue-600 hover:text-blue-800">
                                        <p class="text-gray-800">
                                            {{ \Illuminate\Support\Str::limit($confession->content, 150, '...') }}
                                        </p>
                                    </a>
                                    <p class="text-sm text-gray-600">
                                        Mood: {{ $confession->mood->name ?? 'N/A' }}
                                    </p>

                                    <p class="text-sm text-gray-500">Posted at: {{ $confession->created_at->format('d M Y, H:i') }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
