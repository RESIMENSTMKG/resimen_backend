<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    /**
     * Display a listing of activities.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Activity::query()->orderBy('event_date', 'desc')->orderBy('created_at', 'desc');

        if ($request->has('category') && $request->query('category') !== 'all') {
            $query->where('category', $request->query('category'));
        }

        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('summary', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%")
                  ->orWhere('location', 'ilike', "%{$search}%");
            });
        }

        $activities = $query->get();

        return response()->json([
            'success' => true,
            'data' => $activities,
        ]);
    }

    /**
     * Store a newly created activity.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'nullable|string|max:100|unique:activities,id',
            'title' => 'required|string|max:200',
            'category' => 'required|string|max:50',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:200',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'template_type' => 'nullable|string|in:diamond,grid',
            'cover_photo_url' => 'nullable|string',
            'photos' => 'nullable|array',
        ]);

        if (empty($validated['id'])) {
            $validated['id'] = Str::slug($validated['title']);
            // Pastikan slug unik
            $originalSlug = $validated['id'];
            $count = 1;
            while (Activity::where('id', $validated['id'])->exists()) {
                $validated['id'] = "{$originalSlug}-{$count}";
                $count++;
            }
        }

        $activity = Activity::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil ditambahkan.',
            'data' => $activity,
        ], 201);
    }

    /**
     * Display the specified activity.
     */
    public function show($id): JsonResponse
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Kegiatan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $activity,
        ]);
    }

    /**
     * Update the specified activity.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Kegiatan tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:200',
            'category' => 'sometimes|required|string|max:50',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:200',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'template_type' => 'nullable|string|in:diamond,grid',
            'cover_photo_url' => 'nullable|string',
            'photos' => 'nullable|array',
        ]);

        $activity->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil diperbarui.',
            'data' => $activity,
        ]);
    }

    /**
     * Remove the specified activity.
     */
    public function destroy($id): JsonResponse
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Kegiatan tidak ditemukan.',
            ], 404);
        }

        $activity->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil dihapus.',
        ]);
    }
}
