<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - StayHub</title>
    <!-- Simple Tailwind styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow border border-gray-200">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">StayHub Admin</h1>
            <p class="text-sm text-gray-500 mt-1">Sign in to access the administrator dashboard</p>
        </div>

        <!-- Feedback Messages -->
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', 'admin@stayhub.com') }}" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 text-sm">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" value="password123" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 text-sm">
            </div>

            <div class="flex items-center justify-between text-xs text-gray-500">
                <label class="flex items-center gap-1.5 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded">
                    <span>Remember me</span>
                </label>
                <a href="/docs/api" target="_blank" class="text-blue-600 hover:underline">View API Docs &rarr;</a>
            </div>

            <button type="submit" 
                class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded shadow transition">
                Sign In
            </button>
        </form>

        <!-- Test Account Info Box for Instructor/Evaluation -->
        <div class="mt-6 p-3 bg-gray-50 border border-gray-200 rounded text-xs text-gray-600">
            <p class="font-bold text-gray-700 mb-1">Testing Credentials (MongoDB Seeded):</p>
            <p>Admin: <span class="font-mono text-blue-700 font-semibold">admin@stayhub.com</span> | <span class="font-mono text-blue-700">password123</span></p>
            <p class="mt-1 text-gray-400 text-[11px]">Note: Regular guest/host accounts cannot access this admin dashboard.</p>
        </div>
    </div>

</body>
</html>
