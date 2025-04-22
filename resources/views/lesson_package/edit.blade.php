@extends('master.layout')

@section('title', 'Edit Lesson Package')

@section('content')
    <!-- Breadcrumb -->
    <div class="sticky top-12 inset-x-0 z-10 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center py-3">
            <ol class="flex items-center whitespace-nowrap">
                <li class="flex items-center text-base text-gray-800">
                    <a href="{{ route('lesson-package-index') }}" class="hover:text-blue-600 font-medium">Lesson Packages</a>
                    <svg class="shrink-0 mx-3 overflow-visible size-3 text-gray-400" width="16" height="16"
                        viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </li>
                <li class="text-base font-semibold text-gray-800 truncate" aria-current="page">
                    Edit Lesson Package
                </li>
            </ol>
        </div>
    </div>

    <!-- Form Edit Lesson Package -->
    <div class="max-w-4xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full bg-white rounded-3xl shadow-xl p-8 space-y-6">
            <!-- Header -->
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M12 2a5 5 0 0 0-5 5v3a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2V7a5 5 0 0 0-5-5z" />
                    <path d="M9 15l2 2 4-4" />
                </svg>
                <h2 class="mt-3 text-2xl font-bold text-gray-800">Edit Lesson Package</h2>
                <p class="text-sm text-gray-500">Update the details of the lesson package</p>
            </div>

            <!-- Flash Message -->
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative transition-opacity duration-300"
                    role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Error Validasi -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative transition-opacity duration-300"
                    role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('lesson-package-update', $lessonPackage->lesson_package_id) }}" method="POST" class="space-y-4" aria-label="Edit lesson package form">
                @csrf
                @method('PUT')

                <!-- Lesson Package Name -->
                <div>
                    <label for="lesson_package_name" class="block text-sm font-semibold text-gray-700">Package Name</label>
                    <input type="text" name="lesson_package_name" id="lesson_package_name" value="{{ old('lesson_package_name', $lessonPackage->lesson_package_name) }}"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800"
                        placeholder="Enter package name" required>
                    @error('lesson_package_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lesson Package Description -->
                <div>
                    <label for="lesson_package_description" class="block text-sm font-semibold text-gray-700">Description</label>
                    <textarea name="lesson_package_description" id="lesson_package_description" rows="3"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800 resize-none">{{ old('lesson_package_description', $lessonPackage->lesson_package_description) }}</textarea>
                    @error('lesson_package_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lesson Duration -->
                <div>
                    <label for="lesson_duration" class="block text-sm font-semibold text-gray-700">Duration (Week)</label>
                    <input type="number" name="lesson_duration" id="lesson_duration" value="{{ old('lesson_duration', $lessonPackage->lesson_duration) }}"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800"
                        placeholder="Enter duration in minutes" required min="1">
                    @error('lesson_duration')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lesson Package Price -->
                <div>
                    <label for="lesson_package_price" class="block text-sm font-semibold text-gray-700">Price (IDR)</label>
                    <input type="number" name="lesson_package_price" id="lesson_package_price" value="{{ old('lesson_package_price', $lessonPackage->lesson_package_price) }}"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800"
                        placeholder="Enter price" required min="0">
                    @error('lesson_package_price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('lesson-package-index') }}"
                        class="w-1/2 bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-xl hover:bg-gray-300 transition duration-200 text-center">
                        Cancel
                    </a>
                    <button type="submit"
                        class="w-1/2 bg-blue-600 text-white font-semibold py-3 px-4 rounded-xl hover:bg-blue-700 transition duration-200">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Flash Message auto disappear
            const flashes = document.querySelectorAll('[role="alert"]');
            flashes.forEach(el => {
                setTimeout(() => {
                    el.classList.add('opacity-0');
                    setTimeout(() => el.remove(), 300);
                }, 3000);
            });
        });
    </script>
@endsection