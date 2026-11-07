<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    // 1. Get all properties (with optional city search)
    public function index(Request $request)
    {
        $query = Property::with(['category', 'host']);

        // Filter by city if user entered one
        if ($request->city) {
            $query->where('city', $request->city);
        }

        // Filter by category
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Get paginated properties (10 per page)
        $properties = $query->latest()->paginate(10);

        return response()->json($properties);
    }

    // 2. Add a new property
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'city' => 'required',
            'country' => 'required',
            'price_per_night' => 'required|numeric',
            'max_guests' => 'required|integer',
        ]);

        $user = $request->user();

        // Save to MongoDB
        $property = Property::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(100, 999),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'host_id' => (string) ($user->_id ?? $user->id),
            'city' => $request->city,
            'country' => $request->country,
            'address' => $request->address ?? 'Main Street',
            'price_per_night' => (float) $request->price_per_night,
            'max_guests' => (int) $request->max_guests,
            'bedrooms' => (int) ($request->bedrooms ?? 1),
            'bathrooms' => (int) ($request->bathrooms ?? 1),
            'amenities' => $request->amenities ?? ['Wi-Fi', 'Kitchen'],
            'images' => $request->images ?? ['https://images.unsplash.com/photo-1566073771259-6a8506099945'],
            'status' => 'published',
            'featured' => false,
        ]);

        return response()->json([
            'message' => 'Property added successfully!',
            'property' => $property,
        ], 201);
    }

    // 3. View one property
    public function show($id)
    {
        $property = Property::with(['category', 'host'])->findOrFail($id);

        return response()->json($property);
    }

    // 4. Update property
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $property->update($request->all());

        return response()->json([
            'message' => 'Property updated successfully!',
            'property' => $property,
        ]);
    }

    // 5. Delete property
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return response()->json([
            'message' => 'Property deleted successfully!',
        ]);
    }

    // 6. Get all categories
    public function categories()
    {
        $categories = Category::all();

        return response()->json($categories);
    }

    // 7. Add a new category
    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description ?? '',
            'icon' => $request->icon ?? 'home',
        ]);

        return response()->json([
            'message' => 'Category created successfully!',
            'category' => $category,
        ], 201);
    }
}
