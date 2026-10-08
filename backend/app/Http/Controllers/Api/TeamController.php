<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Public: List active team members
    public function index()
    {
        $team = TeamMember::where('is_active', true)
            ->orderBy('order')
            ->get();

        return response()->json($team);
    }

    // Admin: List all team members
    public function adminIndex()
    {
        $team = TeamMember::orderBy('order')->latest()->get();
        return response()->json($team);
    }

    // Admin: Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'experience_years' => 'nullable|string',
            'certifications' => 'nullable|array',
            'image' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $member = TeamMember::create($validated);

        return response()->json([
            'message' => 'Anggota tim berhasil ditambahkan',
            'data' => $member,
        ], 201);
    }

    // Admin: Update
    public function update(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'experience_years' => 'nullable|string',
            'certifications' => 'nullable|array',
            'image' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $member->update($validated);

        return response()->json([
            'message' => 'Data anggota tim berhasil diperbarui',
            'data' => $member,
        ]);
    }

    // Admin: Delete
    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);
        $member->delete();

        return response()->json([
            'message' => 'Anggota tim berhasil dihapus',
        ]);
    }
}
