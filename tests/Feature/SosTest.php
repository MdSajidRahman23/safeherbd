<?php

namespace Tests\Feature;

use App\Models\SosAlert;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SosTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_sos_alert()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->postJson('/sos/alert', [
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'message' => 'Test SOS message'
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'SOS Alert sent successfully!',
                     'alert_id' => 1
                 ]);

        $this->assertDatabaseHas('sos_alerts', [
            'user_id' => $user->id,
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'message' => 'Test SOS message',
            'status' => 'Open'
        ]);
    }

    public function test_sos_alert_requires_authentication()
    {
        $response = $this->postJson('/sos/alert', [
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'message' => 'Test SOS message'
        ]);

        $response->assertStatus(401);
    }

    public function test_sos_alert_validation()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->postJson('/sos/alert', [
            // Missing required fields
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['latitude', 'longitude']);
    }

    public function test_admin_can_view_sos_alerts()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        SosAlert::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200)
                 ->assertViewHas('alerts');
    }

    public function test_non_admin_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertRedirect('/dashboard');
    }

    public function test_admin_can_close_sos_alert()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $alert = SosAlert::factory()->create(['status' => 'Open']);

        $response = $this->actingAs($admin)->postJson("/admin/alerts/{$alert->id}/close");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Alert closed successfully'
                 ]);

        $this->assertDatabaseHas('sos_alerts', [
            'id' => $alert->id,
            'status' => 'Closed'
        ]);
    }
}
