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

    //test create task
    public function testCreateTask()
    {
        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'status' => 0,
            'sort_order' => 1,
        ];

        $response = $this->postJson('/api/v1/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'payload' => ['id', 'title', 'description', 'status', 'sort_order', 'created_at', 'updated_at'],
                'meta' => ['_timestamp']
            ]);

        $this->assertDatabaseHas('tasks', $taskData);
    }

}
