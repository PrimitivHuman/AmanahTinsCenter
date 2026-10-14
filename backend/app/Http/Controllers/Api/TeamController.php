<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    // Admin: Upload foto profil terapis
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'image.required' => 'Silakan pilih berkas foto yang akan diunggah.',
            'image.image' => 'Berkas harus berupa gambar valid.',
            'image.mimes' => 'Format foto yang didukung adalah JPEG, PNG, JPG, atau WEBP.',
            'image.max' => 'Ukuran foto maksimal adalah 5MB.',
        ]);

        $path = $request->file('image')->store('team', 'public');

        return response()->json([
            'message' => 'Foto terapis berhasil diunggah',
            'url' => '/storage/' . $path,
        ]);
    }

    // Hapus berkas foto lokal (hanya yang berada di storage/team)
    private function deleteLocalImage(?string $url): void
    {
        if ($url && str_starts_with($url, '/storage/team/')) {
            Storage::disk('public')->delete(substr($url, strlen('/storage/')));
        }
    }

    // Admin: Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'category' => 'nullable|string|in:tw,ot,si,psi,ft',
            'edu' => 'nullable|string|max:255',
            'specialization' => 'required|string|max:255',
            'tags' => 'nullable|array',
            'bio' => 'nullable|string',
            'philosophy' => 'nullable|string',
            'experience_years' => 'nullable|string',
            'schedule' => 'nullable|string|max:255',
            'str_number' => 'nullable|string|max:255',
            'certifications' => 'nullable|array',
            'image' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['category'])) {
            $validated['category'] = 'tw';
        }

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
            'category' => 'nullable|string|in:tw,ot,si,psi,ft',
            'edu' => 'nullable|string|max:255',
            'specialization' => 'required|string|max:255',
            'tags' => 'nullable|array',
            'bio' => 'nullable|string',
            'philosophy' => 'nullable|string',
            'experience_years' => 'nullable|string',
            'schedule' => 'nullable|string|max:255',
            'str_number' => 'nullable|string|max:255',
            'certifications' => 'nullable|array',
            'image' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['category'])) {
            $validated['category'] = $member->category ?? 'tw';
        }

        $oldImage = $member->image;
        $member->update($validated);

        if ($oldImage && $oldImage !== $member->image) {
            $this->deleteLocalImage($oldImage);
        }

        return response()->json([
            'message' => 'Data anggota tim berhasil diperbarui',
            'data' => $member,
        ]);
    }

    // Admin: Delete
    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);
        $this->deleteLocalImage($member->image);
        $member->delete();

        return response()->json([
            'message' => 'Anggota tim berhasil dihapus',
        ]);
    }
}
