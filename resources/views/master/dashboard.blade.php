@extends('master.layout');

@section('title', 'Dashboard')


@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Welcome to Your Dashboard</h1>
        <p class="text-sm text-gray-500">Monitor key metrics and manage your application efficiently.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Card 1: Total Users -->
        <div
            class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 animate-fade-in flex items-center space-x-4">
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-600">Total Users</h3>
                <p class="text-2xl font-semibold text-gray-800">1,234</p>
                <p class="text-xs text-green-500">+5.2% from last month</p>
            </div>
        </div>
        <!-- Card 2: Active Projects -->
        <div
            class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 animate-fade-in flex items-center space-x-4">
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-600">Active Projects</h3>
                <p class="text-2xl font-semibold text-gray-800">56</p>
                <p class="text-xs text-green-500">+3 new this week</p>
            </div>
        </div>
        <!-- Card 3: Revenue -->
        <div
            class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 animate-fade-in flex items-center space-x-4">
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-600">Revenue</h3>
                <p class="text-2xl font-semibold text-gray-800">$45,678</p>
                <p class="text-xs text-green-500">+12% from last month</p>
            </div>
        </div>
        <!-- Card 4: System Alerts -->
        <div
            class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 animate-fade-in flex items-center space-x-4">
            <div class="p-3 bg-red-100 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-600">System Alerts</h3>
                <p class="text-2xl font-semibold text-gray-800">3</p>
                <p class="text-xs text-red-500">2 critical alerts</p>
            </div>
        </div>
    </div>
@endsection
