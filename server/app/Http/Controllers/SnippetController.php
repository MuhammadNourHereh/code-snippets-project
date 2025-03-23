<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SnippetController extends Controller
{
    // Get all snippets for the authenticated user
    public function index()
    {
        $snippets = Snippet::where('user_id', Auth::id())->get();
        return response()->json($snippets);
    }

    // Store a new snippet
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'lang' => 'required|string|max:50',
            'code' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                "msg" => "missing attr",
                "errors" => $validator->errors()
            ], 422);
        }

        try {
            $snippet = Snippet::create($request->all());
            return response()->json($snippet, 201);
        } catch (Exception $e) {
            return response()->json([
                "msg" => "snippet creation failed",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    // Get a single snippet
    public function show($id)
    {
        $snippet = Snippet::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($snippet);
    }

    // Update a snippet
    public function update(Request $request, $id)
    {
        $snippet = Snippet::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'lang' => 'sometimes|string|max:50',
            'code' => 'sometimes|string',
        ]);

        $snippet->update($validated);

        return response()->json($snippet);
    }

    // Soft delete a snippet
    public function destroy($id)
    {
        $snippet = Snippet::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $snippet->delete();
        return response()->json(['message' => 'Snippet deleted successfully']);
    }
}
