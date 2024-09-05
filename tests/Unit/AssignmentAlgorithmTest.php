<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Assignment;
use App\Models\Request;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignmentAlgorithmTest extends TestCase
{
    use RefreshDatabase; // Para resetear bd despues de prueba

    public function test_random_assignment()
    {
        // Crear algunos usuarios con el rol Analyst en este caso 5
        $role = Role::create(['name' => 'Analyst']);
        User::factory(5)->create(['role_id' => $role->id]);
        $users = User::where('role_id', $role->id)->get();
        $randomUser = $users->random();
        $this->assertContains($randomUser->id, $users->pluck('id'));
    }

    public function test_sequential_assignment()
{
    // Crear una solicitud válida
    $request = \App\Models\Request::create([
        'title' => 'Test Request for Sequential Assignment',
        'description' => 'This is a test request for sequential assignment.',
        'status' => 'pending',
    ]);

    // Crear algunos usuarios con el rol Analyst
    $role = Role::create(['name' => 'Analyst']);
    $users = User::factory(5)->create(['role_id' => $role->id]);
    // Crear una asignación para el primer usuario
    $lastAssignedUser = $users->first();
    Assignment::create([
        'request_id' => $request->id,
        'user_id' => $lastAssignedUser->id,
        'assignment_method' => 'sequential'
    ]);

    // proximo usuario
    $nextUser = User::where('id', '>', $lastAssignedUser->id)->first();
    $nextUser = $nextUser ?? $users->first();

    // Comprobar el siguiente usuario asignado
    $this->assertEquals($nextUser->id, $users[1]->id);
}

public function test_equity_assignment()
{
    // Crear una solicitud válida
    $request = \App\Models\Request::create([
        'title' => 'Test Request for Equity Assignment',
        'description' => 'This is a test request for equity assignment.',
        'status' => 'pending',
    ]);

    // Crear algunos usuarios con el rol Analyst
    $role = Role::create(['name' => 'Analyst']);
    $users = User::factory()->count(3)->create(['role_id' => $role->id]);

    // Crear asignaciones para algunos usuarios
    Assignment::create([
        'request_id' => $request->id, 
        'user_id' => $users[0]->id, // Primer usuario
        'assignment_method' => 'equity'
    ]);
    Assignment::create([
        'request_id' => $request->id, 
        'user_id' => $users[1]->id, // Segundo usuario
        'assignment_method' => 'equity'
    ]);
    Assignment::create([
        'request_id' => $request->id, 
        'user_id' => $users[1]->id, // Segundo usuario (dos veces)
        'assignment_method' => 'equity'
    ]);
  // Cargar el recuento de asignaciones para cada usuario
    foreach ($users as $user) {
        $user->loadCount('assignments');
    }
    // Determinar el usuario con menos asignaciones
    $assignedUser = $users->sortBy('assignments_count')->first();

    // Comprobar que el usuario con menos asignaciones es el tercero
    $this->assertEquals($users[2]->id, $assignedUser->id);
}
}
