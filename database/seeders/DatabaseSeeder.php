<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed sample data for StayHub.
     */
    public function run(): void
    {
        // Clear old records
        User::truncate();
        Property::truncate();
        Category::truncate();
        Booking::truncate();

        // 1. Create Default Users (Admin, Host, Guest)
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@stayhub.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '09123456789',
        ]);

        $host = User::create([
            'name' => 'John Host',
            'email' => 'host@stayhub.com',
            'password' => Hash::make('password123'),
            'role' => 'host',
            'phone' => '09187654321',
        ]);

        $guest = User::create([
            'name' => 'Jane Guest',
            'email' => 'guest@stayhub.com',
            'password' => Hash::make('password123'),
            'role' => 'guest',
            'phone' => '09171112233',
        ]);

        // 2. Create Categories
        $catBeach = Category::create([
            'name' => 'Beach House',
            'slug' => 'beach-house',
            'description' => 'Places near the beach and ocean.',
            'icon' => 'sun',
        ]);

        $catCabin = Category::create([
            'name' => 'Mountain Cabin',
            'slug' => 'mountain-cabin',
            'description' => 'Quiet cabins in the mountain and forest.',
            'icon' => 'tree',
        ]);

        $catApartment = Category::create([
            'name' => 'City Apartment',
            'slug' => 'city-apartment',
            'description' => 'Modern condos and apartments located in the city.',
            'icon' => 'building',
        ]);

        $catVilla = Category::create([
            'name' => 'Private Villa',
            'slug' => 'private-villa',
            'description' => 'Spacious villas with private swimming pools.',
            'icon' => 'home',
        ]);

        // 3. Create Sample Properties
        $prop1 = Property::create([
            'title' => 'Sunny Beachfront Villa',
            'slug' => 'sunny-beachfront-villa',
            'description' => 'A nice and cozy villa right next to the beach. Great for family vacations and weekend getaways with friends.',
            'category_id' => (string) $catBeach->_id,
            'host_id' => (string) $host->_id,
            'city' => 'Malibu',
            'country' => 'USA',
            'address' => '123 Ocean Drive',
            'price_per_night' => 250.00,
            'max_guests' => 6,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'amenities' => ['Wi-Fi', 'Swimming Pool', 'Air Conditioning', 'Free Parking', 'Kitchen'],
            'images' => [
                'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1200&q=80',
            ],
            'status' => 'published',
            'featured' => true,
        ]);

        $prop2 = Property::create([
            'title' => 'Cozy Pine Mountain Cabin',
            'slug' => 'cozy-pine-mountain-cabin',
            'description' => 'A warm wooden cabin surrounded by pine trees. Perfect place to relax and enjoy the cool mountain breeze.',
            'category_id' => (string) $catCabin->_id,
            'host_id' => (string) $host->_id,
            'city' => 'Aspen',
            'country' => 'USA',
            'address' => '45 Pine Hill Road',
            'price_per_night' => 180.00,
            'max_guests' => 4,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'amenities' => ['Wi-Fi', 'Fireplace', 'Heating', 'Hot Tub', 'Kitchen'],
            'images' => [
                'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80',
            ],
            'status' => 'published',
            'featured' => true,
        ]);

        $prop3 = Property::create([
            'title' => 'Modern Downtown Studio Loft',
            'slug' => 'modern-downtown-studio-loft',
            'description' => 'Stylish studio apartment in the center of the city. Walking distance to restaurants, malls, and subway station.',
            'category_id' => (string) $catApartment->_id,
            'host_id' => (string) $host->_id,
            'city' => 'New York',
            'country' => 'USA',
            'address' => '88 Broadway Street',
            'price_per_night' => 120.00,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'amenities' => ['Wi-Fi', 'Air Conditioning', 'Elevator', 'Work Desk'],
            'images' => [
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=80',
            ],
            'status' => 'published',
            'featured' => false,
        ]);

        $prop4 = Property::create([
            'title' => 'Santorini Cliffside House',
            'slug' => 'santorini-cliffside-house',
            'description' => 'Beautiful white house with a nice view of the sea and sunset. Perfect for couples on vacation.',
            'category_id' => (string) $catVilla->_id,
            'host_id' => (string) $host->_id,
            'city' => 'Santorini',
            'country' => 'Greece',
            'address' => '14 Sunset View Road',
            'price_per_night' => 300.00,
            'max_guests' => 4,
            'bedrooms' => 2,
            'bathrooms' => 2,
            'amenities' => ['Wi-Fi', 'Sea View', 'Balcony', 'Air Conditioning'],
            'images' => [
                'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=1200&q=80',
            ],
            'status' => 'published',
            'featured' => false,
        ]);

        $prop5 = Property::create([
            'title' => 'Tropical Bamboo Garden Villa',
            'slug' => 'tropical-bamboo-garden-villa',
            'description' => 'Relaxing villa in the middle of nature. Has a private garden and outdoor pool.',
            'category_id' => (string) $catVilla->_id,
            'host_id' => (string) $host->_id,
            'city' => 'Bali',
            'country' => 'Indonesia',
            'address' => 'Jalan Sunset 10',
            'price_per_night' => 150.00,
            'max_guests' => 5,
            'bedrooms' => 2,
            'bathrooms' => 2,
            'amenities' => ['Wi-Fi', 'Private Pool', 'Garden', 'Kitchen'],
            'images' => [
                'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80',
            ],
            'status' => 'pending', // Sample pending property for admin to review/approve
            'featured' => false,
        ]);

        // 4. Create Sample Bookings
        $checkIn1 = Carbon::now()->addDays(3);
        $checkOut1 = Carbon::now()->addDays(6);
        $nights1 = 3;
        $price1 = 250.00;
        $subtotal1 = $nights1 * $price1;
        $cleaningFee1 = 35.00;
        $serviceFee1 = round($subtotal1 * 0.10, 2);
        $totalPrice1 = $subtotal1 + $cleaningFee1 + $serviceFee1;

        Booking::create([
            'booking_code' => 'STAY-' . strtoupper(Str::random(6)),
            'property_id' => (string) $prop1->_id,
            'user_id' => (string) $guest->_id,
            'check_in_date' => $checkIn1->toDateString(),
            'check_out_date' => $checkOut1->toDateString(),
            'total_nights' => $nights1,
            'guests_count' => 3,
            'price_per_night' => $price1,
            'cleaning_fee' => $cleaningFee1,
            'service_fee' => $serviceFee1,
            'total_price' => $totalPrice1,
            'pricing_breakdown' => [
                'nights' => $nights1,
                'rate' => $price1,
                'subtotal' => $subtotal1,
                'cleaning' => $cleaningFee1,
                'service_fee' => $serviceFee1,
                'total' => $totalPrice1,
            ],
            'status' => 'confirmed',
            'special_requests' => 'We will arrive around 2pm.',
        ]);

        $checkIn2 = Carbon::now()->subDays(1);
        $checkOut2 = Carbon::now()->addDays(2);
        $nights2 = 3;
        $price2 = 180.00;
        $subtotal2 = $nights2 * $price2;
        $cleaningFee2 = 35.00;
        $serviceFee2 = round($subtotal2 * 0.10, 2);
        $totalPrice2 = $subtotal2 + $cleaningFee2 + $serviceFee2;

        Booking::create([
            'booking_code' => 'STAY-' . strtoupper(Str::random(6)),
            'property_id' => (string) $prop2->_id,
            'user_id' => (string) $guest->_id,
            'check_in_date' => $checkIn2->toDateString(),
            'check_out_date' => $checkOut2->toDateString(),
            'total_nights' => $nights2,
            'guests_count' => 2,
            'price_per_night' => $price2,
            'cleaning_fee' => $cleaningFee2,
            'service_fee' => $serviceFee2,
            'total_price' => $totalPrice2,
            'pricing_breakdown' => [
                'nights' => $nights2,
                'rate' => $price2,
                'subtotal' => $subtotal2,
                'cleaning' => $cleaningFee2,
                'service_fee' => $serviceFee2,
                'total' => $totalPrice2,
            ],
            'status' => 'checked_in',
            'special_requests' => 'Need extra towels please.',
        ]);

        $this->command->info('Database successfully seeded!');
        $this->command->info('Admin login: admin@stayhub.com / password123');
        $this->command->info('Host login:  host@stayhub.com / password123');
        $this->command->info('Guest login: guest@stayhub.com / password123');
    }
}
