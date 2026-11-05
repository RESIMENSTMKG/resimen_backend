<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OneGateLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OneGateLinkController extends Controller
{
    /**
     * Display a listing of one-gate links.
     */
    public function index(Request $request): JsonResponse
    {
        $query = OneGateLink::query()->orderBy('order_index')->orderBy('id');

        // Jika bukan admin / tidak menyertakan all=1, hanya tampilkan yang aktif
        if (!$request->boolean('all')) {
            $query->where('is_active', true);
        }

        if ($request->has('category') && $request->query('category') !== 'all') {
            $query->where('category', $request->query('category'));
        }

        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%")
                  ->orWhere('badge', 'ilike', "%{$search}%");
            });
        }

        $links = $query->get();

        return response()->json([
            'success' => true,
            'data' => $links,
        ]);
    }

    /**
     * Store a newly created link.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|string|max:50',
            'badge' => 'nullable|string|max:50',
            'type' => 'required|string|in:drive,form,spreadsheet,link,doc',
            'description' => 'nullable|string',
            'url' => 'required|url',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $link = OneGateLink::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Link berhasil ditambahkan.',
            'data' => $link,
        ], 201);
    }

    /**
     * Display the specified link.
     */
    public function show($id): JsonResponse
    {
        $link = OneGateLink::find($id);

        if (!$link) {
            return response()->json([
                'success' => false,
                'message' => 'Link tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $link,
        ]);
    }

    /**
     * Update the specified link.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $link = OneGateLink::find($id);

        if (!$link) {
            return response()->json([
                'success' => false,
                'message' => 'Link tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:200',
            'category' => 'sometimes|required|string|max:50',
            'badge' => 'nullable|string|max:50',
            'type' => 'sometimes|required|string|in:drive,form,spreadsheet,link,doc',
            'description' => 'nullable|string',
            'url' => 'sometimes|required|url',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $link->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Link berhasil diperbarui.',
            'data' => $link,
        ]);
    }

    /**
     * Remove the specified link.
     */
    public function destroy($id): JsonResponse
    {
        $link = OneGateLink::find($id);

        if (!$link) {
            return response()->json([
                'success' => false,
                'message' => 'Link tidak ditemukan.',
            ], 404);
        }

        $link->delete();

        return response()->json([
            'success' => true,
            'message' => 'Link berhasil dihapus.',
        ]);
    }
}
