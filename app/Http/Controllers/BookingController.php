<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // 1. Get my bookings
    public function index(Request $request)
    {
        $user = $request->user();

        // If regular user, only see own bookings
        if ($user->role !== 'admin') {
            $bookings = Booking::with('property')->where('user_id', (string) ($user->_id ?? $user->id))->latest()->get();
        } else {
            $bookings = Booking::with(['property', 'user'])->latest()->get();
        }

        return response()->json($bookings);
    }

    // 2. Make a new booking
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'guests_count' => 'required|integer',
        ]);

        $property = Property::findOrFail($request->property_id);

        // Calculate days / nights
        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = max(1, $checkIn->diffInDays($checkOut));

        // Calculate total amount
        $rate = (float) $property->price_per_night;
        $subtotal = $nights * $rate;
        $cleaningFee = 35.00;
        $totalPrice = $subtotal + $cleaningFee;

        $user = $request->user();

        // Create booking in MongoDB
        $booking = Booking::create([
            'booking_code' => 'STAY-' . strtoupper(Str::random(5)),
            'property_id' => (string) ($property->_id ?? $property->id),
            'user_id' => (string) ($user->_id ?? $user->id),
            'check_in_date' => $checkIn->toDateString(),
            'check_out_date' => $checkOut->toDateString(),
            'total_nights' => $nights,
            'guests_count' => (int) $request->guests_count,
            'price_per_night' => $rate,
            'cleaning_fee' => $cleaningFee,
            'total_price' => $totalPrice,
            'pricing_breakdown' => [
                'nights' => $nights,
                'price_per_night' => $rate,
                'subtotal' => $subtotal,
                'cleaning_fee' => $cleaningFee,
                'total' => $totalPrice,
            ],
            'status' => 'confirmed',
            'special_requests' => $request->special_requests ?? null,
        ]);

        return response()->json([
            'message' => 'Booking created successfully!',
            'booking' => $booking->load('property'),
        ], 201);
    }

    // 3. View single booking
    public function show($id)
    {
        $booking = Booking::with(['property', 'user'])->findOrFail($id);

        return response()->json($booking);
    }

    // 4. Cancel a booking
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'cancelled';
        $booking->save();

        return response()->json([
            'message' => 'Booking cancelled successfully!',
            'booking' => $booking,
        ]);
    }
}
