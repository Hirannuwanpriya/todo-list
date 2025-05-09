<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsTasks()
    {
        Task::factory()->count(3)->create(['status' => 0]);

        $response = $this->getJson('/api/v1/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'payload' => [
                    '*' => ['id', 'title', 'status', 'created_at', 'updated_at']
                ],
                'meta' => ['_timestamp']
            ]);
    }
}
