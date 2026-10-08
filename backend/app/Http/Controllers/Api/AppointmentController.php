<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Public: Submit appointment booking
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_name' => 'required|string|max:255',
            'child_name' => 'required|string|max:255',
            'child_age' => 'nullable|string|max:100',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'service_type' => 'required|string|max:150',
            'preferred_date' => 'required|date',
            'preferred_time' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'complaint' => 'nullable|string',
            'how_know' => 'nullable|string',
        ]);

        $notes = $request->notes ?? $request->complaint ?? '';
        if ($request->filled('how_know')) {
            $notes = trim($notes . " (Sumber info: " . $request->how_know . ")");
        }
        $validated['notes'] = $notes;
        $validated['status'] = 'pending';

        $appointment = Appointment::create($validated);

        return response()->json([
            'message' => 'Pendaftaran jadwal terapi berhasil dikirim. Tim kami akan segera menghubungi Anda.',
            'data' => $appointment,
        ], 201);
    }

    // Admin: List appointments with filtering
    public function index(Request $request)
    {
        $query = Appointment::query();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('child_name', 'like', "%{$search}%")
                  ->orWhere('parent_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('service_type', 'like', "%{$search}%");
            });
        }

        $appointments = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json($appointments);
    }

    // Admin: Update status / notes
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'admin_notes' => 'nullable|string',
            'preferred_date' => 'sometimes|date',
            'preferred_time' => 'sometimes|nullable|string',
        ]);

        $appointment->update($validated);

        return response()->json([
            'message' => 'Status janji temu berhasil diperbarui',
            'data' => $appointment,
        ]);
    }

    // Admin: Delete
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json([
            'message' => 'Data janji temu berhasil dihapus',
        ]);
    }
}
