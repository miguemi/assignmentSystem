<?php
namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API de Asignación de Solicitudes",
 *      description="Documentación de la API de Asignación de Solicitudes",
 * )
 */
class RequestController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/requests",
     *     tags={"Requests"},
     *     summary="Crea una nueva solicitud",
     *     description="Crea una solicitud con título y descripción",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","description"},
     *             @OA\Property(property="title", type="string", example="Problema en servidor"),
     *             @OA\Property(property="description", type="string", example="El servidor se cayó y no responde.")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Solicitud creada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Problema en servidor"),
     *             @OA\Property(property="description", type="string", example="El servidor se cayó y no responde."),
     *             @OA\Property(property="status", type="string", example="pending")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validación"
     *     )
     * )
     */
public function createRequest(HttpRequest $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $newRequest = Request::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
        ]);

        // Retornar la respuesta con un código 201 (creado)
        return response()->json($newRequest, 201);
    }
}