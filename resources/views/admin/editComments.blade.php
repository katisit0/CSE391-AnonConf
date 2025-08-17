<x-app-layout>
    <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Comments</h1>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back to Dashboard</a>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($comments as $comment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $comment->id }}</td>
                        <td class="px-6 py-4">{{ Str::limit($comment->content, 50) }}</td>
                        <td class="px-6 py-4">
                            @foreach($comment->reports as $report)
                                <p class="text-sm text-gray-600 mb-1">{{ $report->reason }} <span class="text-gray-400">(Reported by IP: {{ $report->ip_address }})</span></p>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            @foreach($comment->reports as $report)
                                <form action="{{ route('admin.ignoreCommentReport', ['comment' => $comment->id, 'report' => $report->id]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm">Ignore</button>
                                </form>
                            @endforeach
                            <form action="{{ route('admin.deleteComment', $comment) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
