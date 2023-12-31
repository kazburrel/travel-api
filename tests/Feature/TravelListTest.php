<?php

namespace Tests\Feature;

use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelListTest extends TestCase
{
    use RefreshDatabase;

    public function test_travels_list_returns_paginated_data_correctly(): void
    {
        Travel::factory(16)->create(['is_public' => true]);

        $response = $this->get('/api/v1/travels');
        $response->assertStatus(200);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonPath('meta.last_page', 2);
    }

    public function test_travels_list_shows_only_public_records()
    {
        // We create two Travels: one public and one private
        $nonPublicTravel = Travel::factory()->create(['is_public' => false]);
        $publicTravel = Travel::factory()->create(['is_public' => true]);

        $response = $this->get('/api/v1/travels');
        $response->assertStatus(200);

        // We check that only the public record is returned
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $publicTravel->id]);
        $response->assertJsonMissing(['id' => $nonPublicTravel->id]);

    }
}
