<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Reported Posts</h1>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back to Dashboard</a>
        </div>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Post ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reports Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($confessions as $confession)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $confession->id }}</td>
                            <td class="px-6 py-4">{{ $confession->content }}</td>
                            <td class="px-6 py-4">
                                <span class="{{ $confession->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-2 py-1 rounded-full text-sm">
                                    {{ $confession->isActive() ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm">
                                    {{ $confession->reports_count }} reports
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-2">
                                    @if($confession->reports()->exists())
                                        @foreach($confession->reports()->get() as $report)
                                            <div class="grid grid-cols-2 gap-4 bg-gray-50 p-3 rounded">
                                                <div class="text-sm font-medium text-gray-700">{{ $report->reason }}</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 space-y-2">
                                <form action="{{ route('admin.deletePost', $confession->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Delete Post
                                    </button>
                                </form>
                                @if($confession->reports()->exists())
                                    @foreach($confession->reports()->get() as $report)
                                        <form action="{{ route('admin.ignoreReport', $confession->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="report_id" value="{{ $report->id }}">
                                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                                Ignore Report
                                            </button>
                                        </form>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
