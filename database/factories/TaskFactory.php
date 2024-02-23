<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
  private $lastOrder;
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $lastOrder = Task::latest()->first()?->order ?? 0;
    $user_id = User::first()->id;
    return [
      'text' => fake()->text(40),
      'completed' => Arr::random([0, 1]),
      'order' => 0,
      'user_id' => $user_id,
    ];
  }

  public function configure(): static
  {
    $this->lastOrder = Task::latest()->first()?->order ?? 0;
    return $this->afterMaking(function (Task $task){
      $task->order = ++$this->lastOrder;
    });
  }
}
