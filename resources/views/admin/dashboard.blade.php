<x-app-layout>
    <div class="flex flex-col min-h-screen">
        <div class="container mx-auto px-4 py-8 flex-grow">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Admin Dashboard</h1>
            
            <div class="grid md:grid-cols-3 gap-6">
                <a href="{{ route('admin.editUsers') }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h2 class="text-xl font-semibold text-blue-600 mb-2">Manage Users</h2>
                    <p class="text-gray-600">Remove user accounts. Manage user roles and permissions.</p>
                </a>

                <a href="{{ route('admin.editPosts') }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h2 class="text-xl font-semibold text-green-600 mb-2">Manage Posts</h2>
                    <p class="text-gray-600">Review, edit, or delete user posts. Moderate content and manage categories.</p>
                </a>

                <a href="{{ route('admin.editComments') }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h2 class="text-xl font-semibold text-purple-600 mb-2">Manage Comments</h2>
                    <p class="text-gray-600">Monitor and moderate user comments. Remove inappropriate content.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
