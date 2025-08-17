<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            

            <!-- Display the user's streak -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-semibold mb-4">Your Streak</h3>
                    <p class="text-xl font-bold">
                        Streak: {{ $user->streak ?? 0 }} days
                    </p>
                </div>
            </div>


            <!-- Recent Confessions Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-semibold mb-4">Your Confessions</h3>

                    @foreach ($confessions as $confession)
                        <div class="mb-4 border rounded p-3 bg-gray-100">
                            @if ($confession->created_at->gt(now()->subDay())) 
                                <!-- Show full content for confessions within the last 24 hours -->
                                <a href="{{ route('confessions.show', $confession->id) }}" class="text-blue-600 hover:underline">
                                    <div class="font-medium whitespace-pre-wrap">
                                        {{ $confession->content }}
                                    </div>
                                </a>
                                <p class="text-sm text-gray-500">Posted {{ $confession->created_at->diffForHumans() }}</p>
                            @else
                                <!-- Show only metadata for confessions older than 24 hours -->
                                <div class="font-medium">
                                    <p class="text-gray-500">This confession is older than 24 hours. No content shown.</p>
                                </div>
                                <p class="text-sm text-gray-500">Posted {{ $confession->created_at->diffForHumans() }}</p>
                                <p class="text-sm text-gray-500">Mood: {{ $confession->mood ? $confession->mood->name : 'N/A' }}</p>
                            @endif
                        </div>
                    @endforeach

                    @if ($confessions->isEmpty())
                        <p class="text-gray-500">You haven’t posted any confessions yet.</p>
                    @endif
                </div>
            </div>


            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
