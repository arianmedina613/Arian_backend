<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Listar reportes del usuario autenticado
    public function index() {
        return Report::where('user_id', Auth::id())->get();
    }

    // Guardar un nuevo reporte
    public function store(Request $request) {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Si hay archivo adjunto, lo guardamos
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        return Report::create($data);
    }

    // Actualizar estado del reporte (solo el dueño o admin puede hacerlo)
    public function updateStatus(Request $request, Report $report) {
        $this->authorize('update', $report);

        $request->validate([
            'status' => 'required|in:pending,in_review,resolved'
        ]);

        $report->update(['status' => $request->status]);

        return $report;
    }
}
