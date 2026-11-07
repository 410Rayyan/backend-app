<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class StayHubTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Ensure Database is seeded
        if (User::count() === 0) {
            $this->artisan('db:seed');
        }
    }

    public function test_docs_page_is_accessible(): void
    {
        $response = $this->get('/docs/api');
        $response->assertStatus(200);
    }

    public function test_admin_login_page_is_accessible(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('Sign in to access the administrator dashboard');
    }

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@stayhub.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin/dashboard');

        $admin = User::where('email', 'admin@stayhub.com')->first();
        $this->actingAs($admin);

        $dashResponse = $this->get('/admin/dashboard');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Welcome back');
    }

    public function test_admin_can_moderate_property_status(): void
    {
        $admin = User::where('email', 'admin@stayhub.com')->first();
        $property = Property::first();

        $response = $this->actingAs($admin)->post("/admin/properties/{$property->_id}/status", [
            'status' => 'suspended',
        ]);

        $response->assertRedirect();
        $this->assertEquals('suspended', Property::find($property->_id)->status);

        // Revert back to published
        $this->actingAs($admin)->post("/admin/properties/{$property->_id}/status", [
            'status' => 'published',
        ]);
    }

    public function test_api_user_registration_and_login(): void
    {
        $randomEmail = 'traveler_' . uniqid() . '@example.com';

        // 1. Register
        $regResponse = $this->postJson('/api/register', [
            'name' => 'Alice Wonder',
            'email' => $randomEmail,
            'password' => 'secret123',
            'role' => 'guest',
        ]);

        $regResponse->assertStatus(201);
        $regResponse->assertJsonStructure(['user', 'token']);

        // 2. Login
        $loginResponse = $this->postJson('/api/login', [
            'email' => $randomEmail,
            'password' => 'secret123',
        ]);

        $loginResponse->assertStatus(200);
        $token = $loginResponse->json('token');

        // 3. Authenticated Profile
        $meResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/profile');

        $meResponse->assertStatus(200);
        $meResponse->assertJsonPath('user.email', $randomEmail);
    }

    public function test_api_properties_search_and_show(): void
    {
        $response = $this->getJson('/api/properties?city=Malibu');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'current_page']);

        $property = Property::where('status', 'published')->first();
        $showResponse = $this->getJson("/api/properties/{$property->_id}");
        $showResponse->assertStatus(200);
        $showResponse->assertJsonPath('title', $property->title);
    }

    public function test_api_booking_creation_and_cancellation(): void
    {
        $guest = User::where('email', 'guest@stayhub.com')->first();
        $token = $guest->createToken('test-token')->plainTextToken;
        $property = Property::where('status', 'published')->first();

        $checkIn = Carbon::now()->addDays(10)->toDateString();
        $checkOut = Carbon::now()->addDays(14)->toDateString();

        // 1. Create Booking
        $bookResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/bookings', [
                'property_id' => (string) $property->_id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'guests_count' => 2,
                'special_requests' => 'Quiet room preferred',
            ]);

        $bookResponse->assertStatus(201);
        $bookingId = $bookResponse->json('booking.id');
        $this->assertNotEmpty($bookingId);
        $this->assertEquals('confirmed', $bookResponse->json('booking.status'));

        // 2. Cancel Booking
        $cancelResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson("/api/bookings/{$bookingId}/cancel");

        $cancelResponse->assertStatus(200);
        $cancelResponse->assertJsonPath('booking.status', 'cancelled');
    }

    public function test_api_categories_listing_and_creation(): void
    {
        $guest = User::where('email', 'guest@stayhub.com')->first();
        $token = $guest->createToken('test-token')->plainTextToken;

        // List
        $listResponse = $this->getJson('/api/categories');
        $listResponse->assertStatus(200);

        // Create
        $uniqueName = 'Glamping Domes ' . uniqid();
        $createResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/categories', [
                'name' => $uniqueName,
                'description' => 'Luxury geodesic tents under the starry sky.',
                'icon' => 'tent',
            ]);

        $createResponse->assertStatus(201);
        $createResponse->assertJsonPath('category.name', $uniqueName);
    }
}
