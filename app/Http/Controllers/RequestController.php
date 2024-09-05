<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
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

        return response()->json($newRequest, 201);
    }
}
