<?php

use Illuminate\Testing\Fluent\AssertableJson;

/**
 * Health Check Tests
 *
 * Verifies the /api/health and /api/health/db endpoints respond correctly.
 */
describe('Health Endpoints', function () {

    it('returns 200 from /api/health', function () {
        $response = $this->getJson('/api/health');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('status')
                     ->where('status', 'ok')
                     ->has('service')
                     ->has('timestamp')
                     ->etc()
            );
    });

    it('returns 200 from /api/health/db with SQLite in testing', function () {
        $response = $this->getJson('/api/health/db');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('status')
                     ->has('database')
                     ->has('driver')
                     ->etc()
            );
    });

    it('returns 404 for unknown API routes', function () {
        $response = $this->getJson('/api/v1/unknown-endpoint-that-does-not-exist');
        $response->assertStatus(404);
    });

    it('returns JSON content type on all API responses', function () {
        $response = $this->getJson('/api/health');
        $response->assertHeader('Content-Type', 'application/json');
    });

});
