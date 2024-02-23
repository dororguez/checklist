<?php
// Namespace and imports
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TasksController extends Controller {
  // Render the home page
  public function index() {
    return Inertia::render('HomePage');
  }

  // Create a new task
  public function store(Request $request) {
    // Define validation rules
    $validationRules = [
      'text' => 'required|string|max:255',
      'start_date' => 'required|date_format:Y-m-d',
      'completed' => 'required|boolean',
      'order' => 'integer'
    ];

    // Validate the request data
    $validator = Validator::make($request->all(), $validationRules);

    // If validation fails, return errors
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    // Create a new task and save it
    $task = auth()->user()->tasks()->create($request->all());
    $lastOrder = auth()->user()->tasks()->orderBy('order', 'desc')->first()->order;
    $task->order = $lastOrder + 1;
    $task->save();

    // Return the new task
    return response()->json($task, 201);
  }

  // Update an existing task
  public function update(Request $request, Task $task) {
    try {
      // Check if the user is authorized to update the task
      $this->authorizeAction($task, 'update');

      // Update the task
      $task->update($request->all());

      // Return the updated task
      return response()->json($task, 200);
    } catch (\Exception $exception) {
      // If an error occurs, return the error message
      return response()->json(['errors' => $exception->getMessage()], 422);
    }
  }

  // Delete a task
  public function destroy(Task $task) {
    try {
      // Check if the user is authorized to delete the task
      $this->authorizeAction($task, 'delete');

      // Delete the task
      $task->delete();

      // Return a successful response
      return response()->json(null, 204);
    } catch (\Exception $exception) {
      // If an error occurs, return the error message
      return response()->json(['errors' => $exception->getMessage()], 422);
    }
  }

  // Get tasks with filters and pagination
  public function get(Request $request) {
    // Get the user's tasks
    $tasks = auth()->user()->tasks();

    // Apply filters if they exist
    if (isset($request->filteredData['filter'])) {
      $filter = $this->getFilter($request->filteredData['filter']);
      $tasks->whereIn('completed', $filter);
    }

    // Apply date filter if it exists
    if (isset($request->filteredData['date'])) {
      $selectedDate = $request->filteredData['date'];
      $tasks->whereDate('start_date', '=', $selectedDate);
    }

    // Apply search filter if it exists
    if (isset($request->filteredData['search'])) {
      $searchTerm = $request->filteredData['search'];
      $tasks->where('text', 'LIKE', "%$searchTerm%");
    }

    // Paginate the tasks
    $paginatedTasks = $tasks->orderBy('order', 'desc')->paginate($request->perPage);

    // Return the paginated tasks
    return response()->json($paginatedTasks, 200);
  }

  // Check if the user is authorized to perform an action on a task
  private function authorizeAction(Task $task, string $action) {
    if ($task->user_id !== auth()->id()) {
      throw new \Exception("You are not authorized to $action this task.");
    }
  }

  // Get the filter value based on the filter string
  private function getFilter($filter) {
    if ($filter === 'active') {
      return [0];
    } elseif ($filter === 'completed') {
      return [1];
    } else {
      return [0, 1];
    }
  }

  // Update the order of a task
  public function updateOrder(Request $request, Task $task) {
    $newOrder = $request->newOrder;
    $task->update(['order' => $newOrder]);
    auth()->user()->tasks()->where('order', '>=', $task->order)->whereNot('id', $task->id)->increment('order');
    return response()->json(['message' => 'Changes saved successfully'], 200);
  }
}
