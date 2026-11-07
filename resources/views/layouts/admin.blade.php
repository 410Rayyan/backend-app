<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - StayHub</title>
    <!-- Tailwind CSS CDN for simple styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    <!-- Navigation Header -->
    <nav class="bg-blue-600 text-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold tracking-wide flex items-center gap-2">
                    <span>🏠</span> StayHub Admin
                </a>
                <div class="hidden sm:flex space-x-4 text-sm font-medium">
                    <a href="{{ route('admin.dashboard') }}" class="hover:bg-blue-700 px-3 py-1.5 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.properties') }}" class="hover:bg-blue-700 px-3 py-1.5 rounded {{ request()->routeIs('admin.properties') ? 'bg-blue-700' : '' }}">
                        Manage Properties
                    </a>
                    <a href="/docs/api" target="_blank" class="hover:bg-blue-700 px-3 py-1.5 rounded bg-blue-500/40">
                        📄 API Docs (22 Routes)
                    </a>
                </div>
            </div>

            <!-- Admin User Info & Logout -->
            <div class="flex items-center space-x-3 text-sm">
                <span class="hidden md:inline">{{ auth()->user()->name ?? 'Admin' }} ({{ auth()->user()->email }})</span>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded text-xs font-semibold text-white transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="max-w-6xl mx-auto px-4 py-6 flex-1 w-full">
        <!-- Success Alert -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded text-sm">
                ✓ {{ session('success') }}
            </div>
        @endif

        <!-- Error Alert -->
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-800 rounded text-sm">
                ✕ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Student Project Footer -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-500">
        <p>StayHub Booking Application &bull; 2nd Year Backend Web Development Project</p>
        <p class="mt-1 text-gray-400">Built with Laravel 11 &amp; MongoDB Database</p>
    </footer>

</body>
</html>
