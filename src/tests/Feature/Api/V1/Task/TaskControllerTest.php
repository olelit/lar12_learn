<?php
declare(strict_types=1);

namespace Api\V1\Task;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_created_via_api(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('api.v1.tasks.store'), [
                'title' => 'Test Title',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'Test Title',
                ],
            ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Title',
        ]);

    }

    public function test_title_is_required_when_creating_task(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('api.v1.tasks.store'), [
                'title' => '',
            ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);

        $this->assertDatabaseCount('tasks', 0);
    }
}
