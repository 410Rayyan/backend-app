@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome Header -->
    <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Welcome back, {{ auth()->user()->name }}! Here is the latest activity from your MongoDB database.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.properties', ['status' => 'pending']) }}" class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded shadow-sm">
                Pending Approvals ({{ $pendingProperties }})
            </a>
            <a href="/docs/api" target="_blank" class="px-3 py-1.5 bg-gray-800 hover:bg-black text-white text-xs font-semibold rounded shadow-sm">
                Open API Docs
            </a>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Revenue -->
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <div class="text-xs font-medium text-gray-500 uppercase">Total Revenue</div>
            <div class="text-2xl font-bold text-gray-800 mt-1">${{ number_format($totalRevenue, 2) }}</div>
            <div class="text-xs text-green-600 mt-1">From confirmed bookings</div>
        </div>

        <!-- Total Bookings -->
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <div class="text-xs font-medium text-gray-500 uppercase">Total Bookings</div>
            <div class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBookings }}</div>
            <div class="text-xs text-blue-600 mt-1">Total reservations created</div>
        </div>

        <!-- Total Properties -->
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <div class="text-xs font-medium text-gray-500 uppercase">Total Properties</div>
            <div class="text-2xl font-bold text-gray-800 mt-1">{{ $totalProperties }}</div>
            <div class="text-xs text-yellow-600 mt-1">{{ $pendingProperties }} waiting for approval</div>
        </div>

        <!-- Registered Users -->
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <div class="text-xs font-medium text-gray-500 uppercase">Registered Users</div>
            <div class="text-2xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</div>
            <div class="text-xs text-gray-500 mt-1">Guests, hosts, and admins</div>
        </div>
    </div>

    <!-- Recent Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Recent Bookings Table -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-sm font-bold text-gray-700">Recent Bookings</h2>
                <span class="text-xs text-gray-400">MongoDB bookings collection</span>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($recentBookings as $booking)
                    <div class="p-3.5 flex justify-between items-center hover:bg-gray-50">
                        <div>
                            <div class="text-xs font-mono font-bold text-blue-600">{{ $booking->booking_code }}</div>
                            <div class="text-sm font-semibold text-gray-800 mt-0.5">
                                {{ $booking->property->title ?? 'Property' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                Guest: {{ $booking->user->name ?? 'Guest' }} &bull; {{ $booking->check_in_date }} to {{ $booking->check_out_date }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-gray-800">${{ number_format($booking->total_price, 2) }}</div>
                            <span class="inline-block px-2 py-0.5 text-[11px] font-medium rounded 
                                @if($booking->status === 'confirmed') bg-green-100 text-green-700
                                @elseif($booking->status === 'checked_in') bg-blue-100 text-blue-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-sm text-gray-400">No bookings yet.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Properties Table -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-sm font-bold text-gray-700">Properties Overview</h2>
                <a href="{{ route('admin.properties') }}" class="text-xs text-blue-600 hover:underline">Manage All &rarr;</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($recentProperties as $property)
                    <div class="p-3.5 flex justify-between items-center hover:bg-gray-50">
                        <div>
                            <div class="text-sm font-semibold text-gray-800">{{ $property->title }}</div>
                            <div class="text-xs text-gray-500">
                                {{ $property->city }}, {{ $property->country }} &bull; {{ $property->category->name ?? 'House' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-gray-800">${{ $property->price_per_night }} / night</div>
                            <span class="inline-block px-2 py-0.5 text-[11px] font-medium rounded 
                                @if($property->status === 'published') bg-green-100 text-green-700
                                @elseif($property->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-sm text-gray-400">No properties yet.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
