<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = auth()->user()
            ->appointments()
            ->latest()
            ->get();

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'appointment_at' => 'required|date',
            'remind_before' => 'required|integer|min:1',
        ]);

        auth()->user()->appointments()->create([
            'title' => $request->title,
            'description' => $request->description,
            'appointment_at' => $request->appointment_at,
            'remind_before' => $request->remind_before,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }


    public function edit(Appointment $appointment)
{
    if ($appointment->user_id !== auth()->id()) {
        abort(403);
    }

    return view('appointments.edit', compact('appointment'));
}

public function update(Request $request, Appointment $appointment)
{
    if ($appointment->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'appointment_at' => 'required|date',
        'remind_before' => 'required|integer|min:1',
    ]);

    $appointment->update([
        'title' => $request->title,
        'description' => $request->description,
        'appointment_at' => $request->appointment_at,
        'remind_before' => $request->remind_before,
    ]);

    return redirect()->route('appointments.index')
        ->with('success', 'Updated successfully.');
}



    public function destroy(Appointment $appointment)
    {
        // حماية: غير المالك يقدر يحذف
        if ($appointment->user_id !== auth()->id()) {
            abort(403);
        }

        $appointment->delete();

        return back()->with('success', 'Deleted successfully.');
    }
}
