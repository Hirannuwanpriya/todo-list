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
                'description' => 'nullable|string',
                'status' => 'nullable|integer',
                'sort_order' => 'nullable|integer',
            ]);

            $task = (new Task())
                ->newQuery()
                ->create($validated);
            //return created task as json format


            return response()->json([
                'status' => true,
                'payload' => $task,
                'meta' => [
                    '_timestamp' => Carbon::now()->timestamp,
                ],
            ], 201);

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

    public function complete(Request $request)
    {
        return rescue(function () use ($request) {

            $task = (new Task())
                ->find($request->get('id'));

            if (!$task) {
                return response()->json([
                    'status' => false,
                    'payload' => 'Task not found',
                    'meta' => [
                        '_timestamp' => Carbon::now()->timestamp,
                    ],
                ], 404);
            }

            $status = $request->get('status', 1);

            $task->update([
                'status' => $status,
            ]);

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
