<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\VisitorLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VisitorTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_visitor_traffic_on_web_routes(): void
    {
        // Act: Visit home page
        $response = $this->get('/');

        // Assert: Response is successful
        $response->assertStatus(200);

        // Assert: Log was created in database
        $this->assertDatabaseCount('visitor_logs', 1);

        $log = VisitorLog::first();
        $this->assertEquals('/', $log->url_path);
        $this->assertEquals('127.0.0.1', $log->ip_address);
        $this->assertEquals('desktop', $log->device_type);
        $this->assertEquals('Local Loopback', $log->country);
    }

    public function test_it_does_not_log_admin_routes(): void
    {
        // Act: Visit admin page
        $response = $this->get('/admin');

        // Assert: Log was not created for admin path
        $this->assertDatabaseCount('visitor_logs', 0);
    }
}
