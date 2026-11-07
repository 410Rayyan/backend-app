@extends('layouts.admin')

@section('title', 'Manage Properties')

@section('content')
<div class="space-y-4">

    <!-- Page Title & Filter Links -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-white p-4 rounded-lg border border-gray-200">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Manage Properties</h1>
            <p class="text-xs text-gray-500">Review and change property listing statuses in MongoDB.</p>
        </div>

        <!-- Filter buttons -->
        <div class="flex space-x-2 text-xs font-medium">
            <a href="{{ route('admin.properties') }}" class="px-3 py-1.5 rounded {{ empty($status) ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">All</a>
            <a href="{{ route('admin.properties', ['status' => 'pending']) }}" class="px-3 py-1.5 rounded {{ $status === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Pending</a>
            <a href="{{ route('admin.properties', ['status' => 'published']) }}" class="px-3 py-1.5 rounded {{ $status === 'published' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Published</a>
            <a href="{{ route('admin.properties', ['status' => 'suspended']) }}" class="px-3 py-1.5 rounded {{ $status === 'suspended' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Suspended</a>
        </div>
    </div>

    <!-- Properties Table -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase font-semibold border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4">Title</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">City</th>
                        <th class="py-3 px-4">Price/Night</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($properties as $property)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium text-gray-900">
                                {{ $property->title }}
                            </td>
                            <td class="py-3 px-4">
                                {{ $property->category->name ?? 'General' }}
                            </td>
                            <td class="py-3 px-4">
                                {{ $property->city }}, {{ $property->country }}
                            </td>
                            <td class="py-3 px-4 font-semibold text-gray-900">
                                ${{ number_format($property->price_per_night, 2) }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-semibold 
                                    @if($property->status === 'published') bg-green-100 text-green-800
                                    @elseif($property->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <!-- Status Update Form -->
                                <form action="{{ route('admin.properties.updateStatus', $property->_id ?? $property->id) }}" method="POST" class="inline-flex items-center gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="border border-gray-300 rounded px-2 py-1 text-xs bg-white">
                                        <option value="published" {{ $property->status === 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="pending" {{ $property->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="suspended" {{ $property->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-2.5 py-1 rounded text-xs">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-400">
                                No properties found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
