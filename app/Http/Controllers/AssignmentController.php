<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Request;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;

class AssignmentController extends Controller
{
    public function assign(HttpRequest $request, $id)
    {
        $validatedData = $request->validate([
            'algorithm' => 'required|string|in:random,sequential,equity,direct',
            'role' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $requestModel = Request::findOrFail($id);
        $users = User::whereHas('role', function($query) use ($validatedData) {
            $query->where('name', $validatedData['role']);
        })->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users with the specified role found'], 404);
        }

        $assignedUser = null;
        switch ($validatedData['algorithm']) {
            case 'random':
                $assignedUser = $users->random();
                break;
            case 'sequential':
                $lastAssignment = Assignment::where('assignment_method', 'sequential')
                    ->orderBy('created_at', 'desc')
                    ->first();
                $nextUser = $lastAssignment ? $lastAssignment->user_id + 1 : $users->first()->id;
                $assignedUser = $users->find($nextUser) ?? $users->first();
                break;
                case 'equity':
                    // Aquí modificamos el algoritmo para evitar erro cuando no hay asignaciones
                    $assignedUser = $users->sortBy(function ($user) {
                        // Si el usuario no tiene asignaciones, devolver 0
                        return $user->assignments ? $user->assignments->count() : 0;
                    })->first();
                    break;
            case 'direct':
                if (isset($validatedData['user_id'])) {
                    $assignedUser = User::findOrFail($validatedData['user_id']);
                } else {
                    return response()->json(['message' => 'User ID is required for direct assignment'], 400);
                }
                break;
        }

        $assignment = Assignment::create([
            'request_id' => $requestModel->id,
            'user_id' => $assignedUser->id,
            'assignment_method' => $validatedData['algorithm'],
        ]);

        $requestModel->update(['status' => 'assigned']);

        return response()->json($assignment, 201);
    }

    public function list()
    {
        $assignments = Assignment::with('request', 'user')->get();
        return response()->json($assignments);
    }
}
