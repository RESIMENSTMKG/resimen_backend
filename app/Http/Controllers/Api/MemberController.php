<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of members.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Member::query()->orderBy('order_index')->orderBy('id');

        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('role', 'ilike', "%{$search}%")
                  ->orWhere('title', 'ilike', "%{$search}%")
                  ->orWhere('major', 'ilike', "%{$search}%");
            });
        }

        $members = $query->get();

        return response()->json([
            'success' => true,
            'data' => $members,
        ]);
    }

    /**
     * Store a newly created member.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'role' => 'required|string|max:100',
            'title' => 'nullable|string|max:100',
            'major' => 'nullable|string|max:100',
            'photo_url' => 'nullable|string',
            'order_index' => 'nullable|integer',
        ]);

        $member = Member::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Anggota berhasil ditambahkan.',
            'data' => $member,
        ], 201);
    }

    /**
     * Display the specified member.
     */
    public function show($id): JsonResponse
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $member,
        ]);
    }

    /**
     * Update the specified member.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:150',
            'role' => 'sometimes|required|string|max:100',
            'title' => 'nullable|string|max:100',
            'major' => 'nullable|string|max:100',
            'photo_url' => 'nullable|string',
            'order_index' => 'nullable|integer',
        ]);

        $member->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data anggota berhasil diperbarui.',
            'data' => $member,
        ]);
    }

    /**
     * Remove the specified member.
     */
    public function destroy($id): JsonResponse
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota tidak ditemukan.',
            ], 404);
        }

        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Anggota berhasil dihapus.',
        ]);
    }
}
