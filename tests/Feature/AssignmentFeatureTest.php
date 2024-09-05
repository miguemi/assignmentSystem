<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignmentFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_request_and_assign_randomly()
    {
        // Crear un rol
        $role = Role::create(['name' => 'Analyst']);

        // Crear usuarios con el rol Analyst
        $users = User::factory(3)->create(['role_id' => $role->id]);

        // Crear una solicitud
        $response = $this->postJson('/api/requests', [
            'title' => 'Test Request',
            'description' => 'This is a test description',
        ]);

        $response->assertStatus(201);
        $requestId = $response->json('id');

        // Asignar la solicitud usando el algoritmo random
        $assignResponse = $this->postJson("/api/requests/{$requestId}/assign", [
            'algorithm' => 'random',
            'role' => 'Analyst',
        ]);

        $assignResponse->assertStatus(201);
        $assignedUserId = $assignResponse->json('user_id');

        // Comprobar que el usuario tenga una asignación y que sea uno de los usuarios creados
        $this->assertContains($assignedUserId, $users->pluck('id')->toArray());
    }
}
