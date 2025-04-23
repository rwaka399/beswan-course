<!doctype html>
<html>

<head>
    <title>Profile</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-50 font-sans antialiased">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm fixed top-0 left-0 right-0 z-20 w-full">
        <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-12">
            <!-- Kiri: Logo -->
            <div class="flex items-center">
                <a href="#" class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h18v4H3V3zM3 9h6v12H3V9zm8 0h10v8H11V9z" />
                    </svg>
                    <span class="font-semibold text-gray-700">Profile Panel</span>
                </a>
            </div>

            <!-- Right: User Dropdown -->
            <div class="relative flex items-center">
                <button id="userDropdown" class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 text-sm">{{ Auth::user()->name }}</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu dengan Shadow -->
                <div id="dropdownMenu"
                    class="hidden absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg text-gray-700 py-2 z-30">
                    <a href="#" class="block px-4 py-2 hover:bg-blue-50 text-sm">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 hover:bg-blue-50 text-sm">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="content" class="pt-3 lg:ml-64 min-h-screen">
        <!-- Breadcrumb -->
        <div class="sticky top-12 inset-x-0 z-10 bg-white border-y border-gray-200 px-4 sm:px-6 lg:px-8 lg:hidden">
            <div class="flex items-center py-2">
                <!-- Navigation Toggle -->
                <button type="button"
                    class="size-8 flex justify-center items-center gap-x-2 border border-gray-200 text-gray-800 hover:text-gray-500 rounded-lg focus:outline-none focus:text-gray-500"
                    aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-application-sidebar"
                    aria-label="Toggle navigation" id="toggleSidebar">
                    <span class="sr-only">Toggle Navigation</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <path d="M15 3v18" />
                        <path d="m8 9 3 3-3 3" />
                    </svg>
                </button>
                <!-- End Navigation Toggle -->

                <!-- Breadcrumb -->
                <ol class="ms-3 flex items-center whitespace-nowrap">
                    <li class="flex items-center text-sm text-gray-800">
                        Application Layout
                        <svg class="shrink-0 mx-3 overflow-visible size-2.5 text-gray-400" width="16" height="16"
                            viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </li>
                    <li class="text-sm font-semibold text-gray-800 truncate" aria-current="page">
                        Dashboard
                    </li>
                </ol>
                <!-- End Breadcrumb -->
            </div>
        </div>
        <!-- End Breadcrumb -->

        <!-- Sidebar -->
        <div id="hs-application-sidebar"
            class="fixed top-12 left-0 h-[calc(100%-3rem)] w-64 z-10 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="relative flex flex-col h-full max-h-full">
                <!-- Content -->
                <div
                    class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
                    <nav class="p-3 w-full flex flex-col flex-wrap">
                        <ul class="flex flex-col space-y-1">
                            <li>
                                <a class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    href="{{ route('profile-index') }}">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    href="{{ route('history') }}">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9M9 21a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                    </svg>
                                    History
                                </a>
                            </li>
                            <li>
                                <a class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    href="{{ route('home') }}">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1h-5.25a.75.75 0 01-.75-.75v-5.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75v5.5a.75.75 0 01-.75.75H4a1 1 0 01-1-1V9.75z" />
                                    </svg>
                                    Home
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                            <polyline points="16 17 21 12 16 7" />
                                            <line x1="21" y1="12" x2="9" y2="12" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </nav>
                </div>
                <!-- End Content -->
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Main Content Area -->
        <div class="p-4 sm:p-6 lg:p-8 animate-fade-in">
            <!-- Header -->
            @yield('content')
        </div>
        <!-- End Main Content Area -->
    </main>

    <style>
        /* Animasi fade-in untuk konten */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('hs-application-sidebar');
            const toggleSidebar = document.getElementById('toggleSidebar');
            const userDropdown = document.getElementById('userDropdown');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const accordions = document.querySelectorAll('.accordion-toggle');

            // Toggle sidebar on mobile
            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                toggleSidebar.setAttribute('aria-expanded', sidebar.classList.contains(
                    '-translate-x-full') ? 'false' : 'true');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (!sidebar.contains(event.target) && !toggleSidebar.contains(event.target) && !sidebar
                    .classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                    toggleSidebar.setAttribute('aria-expanded', 'false');
                }
            });

            // Toggle user dropdown
            userDropdown.addEventListener('click', function() {
                dropdownMenu.classList.toggle('hidden');
                userDropdown.setAttribute('aria-expanded', dropdownMenu.classList.contains('hidden') ?
                    'false' : 'true');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                    userDropdown.setAttribute('aria-expanded', 'false');
                }
            });

            // Accordion functionality
            accordions.forEach(accordion => {
                accordion.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const isOpen = !content.classList.contains('hidden');
                    const svgs = this.querySelectorAll('svg.ms-auto');

                    // Toggle visibility
                    content.classList.toggle('hidden');
                    this.setAttribute('aria-expanded', isOpen ? 'false' : 'true');

                    // Toggle SVG icons
                    svgs.forEach(svg => {
                        svg.classList.toggle('hidden');
                    });

                    // Set height for smooth transition
                    if (!isOpen) {
                        content.style.height = content.scrollHeight + 'px';
                    } else {
                        content.style.height = '0px';
                    }
                });

                // Initialize height for transition
                const content = accordion.nextElementSibling;
                if (!content.classList.contains('hidden')) {
                    content.style.height = content.scrollHeight + 'px';
                }
            });
        });
    </script>
</body>

</html>
