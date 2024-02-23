<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksControllerTest extends TestCase
{
    use RefreshDatabase;

    // Test that a user can be created
    public function test_user_can_be_created(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }

    // Test that a task can be created
    public function test_task_can_be_created(): void
    {
        $user = User::factory()->create();
        $taskData = Task::factory()->make(['user_id' => $user->id])->toArray();

        // Add a start_date to the task data
        $taskData['start_date'] = now()->format('Y-m-d');

        $response = $this->actingAs($user)
                         ->post('/task', $taskData);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'text', 'completed', 'start_date', 'order']);

        $this->assertDatabaseHas('tasks', [
            'id' => $response['id'],
            'user_id' => $user->id,
        ]);
    }

    // Test that a task can be marked as completed
    public function test_task_can_be_completed(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id, 'completed' => false]);

        $response = $this->actingAs($user)
                         ->put("/task/{$task->id}", ['completed' => true]);

        $response->assertStatus(200)
                 ->assertJson(['completed' => true]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => true,
        ]);
    }

    // Test that a task can be updated
    public function test_task_can_be_updated(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $updatedTaskData = [
            'text' => 'Updated task text',
            'start_date' => now()->addDay()->format('Y-m-d'),
            'completed' => true,
        ];

        $response = $this->actingAs($user)
                         ->put("/task/{$task->id}", $updatedTaskData);

        $response->assertStatus(200)
                 ->assertJson($updatedTaskData);

        $this->assertDatabaseHas('tasks', array_merge(['id' => $task->id], $updatedTaskData));
    }

    // Test that a task can be deleted
    public function test_task_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->delete("/task/{$task->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
