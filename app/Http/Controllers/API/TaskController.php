<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return rescue(function () use ($request) {
            $tasks = (new Task())
                ->newQuery()
                ->where('status', 0)
                ->take(5)
                ->get();

            return response()->json([
                'status' => true,
                'payload' => $tasks,
                'meta' => [
                    '_timestamp' => Carbon::now()->timestamp,
                ],
            ], 200);
        }, function ($e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 401);
        });
    }

    public function store(Request $request): JsonResponse
    {
        return rescue(function () use ($request) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'string',
            ]);

            $task = Task::create($validated);
            //return created task as json format
            return response()->json([
                'status' => true,
                'payload' => $task,
                'meta' => [
                    '_timestamp' => Carbon::now()->timestamp,
                ],
            ], 200);

        }, function ($e) {
            return response()->json([
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ], 400);
        });
    }

    public function update(Request $request, Task $task)
    {
        return rescue(function () use ($request, $task) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'string',
            ]);

            $task->update($validated);

            return response()->json([
                'status' => true,
                'payload' => $task,
                'meta' => [
                    '_timestamp' => Carbon::now()->timestamp,
                ],
            ], 200);
        }, function ($e) {
            return response()->json([
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ], 400);
        });
    }

    public function complete(Request$request, Task $task)
    {
        return rescue(function () use ($request, $task) {

            $task->update(['status' => 1]);

            return response()->json([
                'status' => true,
                'payload' => $task,
                'meta' => [
                    '_timestamp' => Carbon::now()->timestamp,
                ],
            ], 200);
        }, function ($e) {
            return response()->json([
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ], 400);
        });
    }

    public function destroy(Task $task)
    {
        return rescue(function () use ($task) {
            $task->delete();

            return response()->json([
                'status' => true,
                'payload' => $task,
                'meta' => [
                    '_timestamp' => Carbon::now()->timestamp,
                ],
            ], 200);
        }, function ($e) {
            return response()->json([
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ], 400);
        });
    }
}
