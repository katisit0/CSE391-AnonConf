<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Confessions with mood: {{ $mood->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(isset($message))
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4">
                            {{ $message }}
                        </div>
                    @else
                        @if($confessions->count() > 0)
                            <div class="space-y-4">
                                @foreach ($confessions as $confession)
                                    <a href="{{ route('confessions.show', $confession->id) }}" 
                                    class="block bg-white p-4 rounded-md mb-4 shadow-md hover:bg-blue-50 hover:shadow-lg transition duration-200">
                                        <p class="text-gray-800 font-medium group-hover:text-blue-700">{{ $confession->content }}</p>
                                    </a>
                                @endforeach
                            </div>
                            
                            <div class="mt-4">
                                {{ $confessions->links() }}
                            </div>
                        @else
                            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4">
                                No active confessions under this mood.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
