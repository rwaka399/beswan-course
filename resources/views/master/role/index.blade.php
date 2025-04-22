@extends('master.layout')

@section('title', 'Role Management')

@section('content')
    <div class="mt-4 max-w-full mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Role Management</h1>
        </div>

        <!-- Search Bar -->
        <div class="mb-6">
            <form action="{{ route('role-index') }}" method="GET" class="flex items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search roles..."
                    class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit" class="ml-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Search
                </button>
            </form>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="flash-message transition-opacity duration-500 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6"
                role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="flash-message transition-opacity duration-500 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6"
                role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Role Table -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role Description
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created By
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($roles as $role)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $role->role_name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $role->role_description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $role->creator->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('role-edit', $role->role_id) }}"
                                        class="inline-block bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 mr-2">
                                        Edit
                                    </a>
                                    <button type="button"
                                        class="inline-block bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                                        onclick="openDeleteModal({{ $role->role_id }}, '{{ addslashes($role->role_name) }}')">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No roles found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($roles->hasPages())
                <div class="p-4">
                    {{ $roles->appends(request()->query())->links('vendor.pagination.custom-tailwind') }}
                </div>
            @endif
        </div>

        <div class="pt-3 pb-6">
            <a href="{{ route('role-create') }}"
                class="inline-block bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">
                Create Role
            </a>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center hidden z-50" role="dialog">
        <div class="bg-white rounded-xl shadow-xl p-6 max-w-md w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Konfirmasi Penghapusan</h3>
            </div>
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <p class="mt-4 text-gray-600">
                    Yakin ingin menghapus role <span id="deleteUserName" class="font-semibold text-gray-800"></span>?<br>
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <form id="deleteForm" method="POST" class="mt-6 flex justify-end space-x-4">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-md hover:bg-gray-300">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <script>
        // Flash Message auto disappear
        document.addEventListener('DOMContentLoaded', () => {
            const flashes = document.querySelectorAll('.flash-message');
            flashes.forEach(el => {
                setTimeout(() => {
                    // Add opacity-0 (fade out)
                    el.classList.add('opacity-0');
                    // Remove from DOM after fade (500ms)
                    setTimeout(() => el.remove(), 500);
                }, 3000);
            });
        });

        // Modal
        // Template URL with placeholder :ID
        const deleteUrlTemplate = "{{ route('role-destroy', ['id' => ':ID']) }}";

        function openDeleteModal(roleId, roleName) {
            // Set form action to /role/destroy/{id}
            const form = document.getElementById('deleteForm');
            form.action = deleteUrlTemplate.replace(':ID', roleId);

            // Display role name in modal
            document.getElementById('deleteUserName').textContent = roleName;

            // Open modal
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Click outside modal or Escape key to close
        document.getElementById('deleteModal').addEventListener('click', function(event) {
            if (event.target === this) closeDeleteModal();
        });
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
                closeDeleteModal();
            }
        });
    </script>
@endsection