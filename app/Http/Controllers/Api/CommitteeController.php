<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    /**
     * Display a listing of committees.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Committee::query()->orderBy('division')->orderBy('id');

        if ($request->has('division')) {
            $query->where('division', $request->query('division'));
        }

        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('role', 'ilike', "%{$search}%")
                  ->orWhere('major', 'ilike', "%{$search}%")
                  ->orWhere('division', 'ilike', "%{$search}%");
            });
        }

        $committees = $query->get();

        if ($request->boolean('grouped')) {
            $divisionOrder = [
                'Sekretaris' => 1,
                'Bendahara' => 2,
                'Multimedia' => 3,
                'Biro Hukum' => 4,
                'Humas' => 5,
                'Dana Usaha' => 6,
                'Logistik' => 7,
            ];

            // Kelompokkan per divisi sesuai struktur divisiPanitia
            $grouped = $committees->groupBy('division')->map(function ($items, $divisi) {
                return [
                    'divisi' => $divisi,
                    'members' => $items->map(function ($c) {
                        return [
                            'id' => $c->id,
                            'name' => $c->name,
                            'role' => $c->role,
                            'title' => $c->division,
                            'major' => $c->major,
                            'photo' => $c->photo_url,
                        ];
                    })->values(),
                ];
            })->sortBy(function ($item) use ($divisionOrder) {
                return $divisionOrder[$item['divisi']] ?? 99;
            })->values();

            return response()->json([
                'success' => true,
                'data' => $grouped,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $committees,
        ]);
    }

    /**
     * Store a newly created committee member.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'division' => 'required|string|max:100',
            'name' => 'required|string|max:150',
            'role' => 'nullable|string|max:100',
            'major' => 'nullable|string|max:100',
            'photo_url' => 'nullable|string',
        ]);

        $committee = Committee::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Panitia berhasil ditambahkan.',
            'data' => $committee,
        ], 201);
    }

    /**
     * Display the specified committee member.
     */
    public function show($id): JsonResponse
    {
        $committee = Committee::find($id);

        if (!$committee) {
            return response()->json([
                'success' => false,
                'message' => 'Data panitia tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $committee,
        ]);
    }

    /**
     * Update the specified committee member.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $committee = Committee::find($id);

        if (!$committee) {
            return response()->json([
                'success' => false,
                'message' => 'Data panitia tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'division' => 'sometimes|required|string|max:100',
            'name' => 'sometimes|required|string|max:150',
            'role' => 'nullable|string|max:100',
            'major' => 'nullable|string|max:100',
            'photo_url' => 'nullable|string',
        ]);

        $committee->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data panitia berhasil diperbarui.',
            'data' => $committee,
        ]);
    }

    /**
     * Remove the specified committee member.
     */
    public function destroy($id): JsonResponse
    {
        $committee = Committee::find($id);

        if (!$committee) {
            return response()->json([
                'success' => false,
                'message' => 'Data panitia tidak ditemukan.',
            ], 404);
        }

        $committee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data panitia berhasil dihapus.',
        ]);
    }
}
