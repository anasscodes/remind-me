<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Appointment</h2>
    </x-slot>

    <div class="p-6 max-w-lg">

        <form method="POST"
              action="{{ route('appointments.update', $appointment) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block">Title</label>
                <input type="text"
                       name="title"
                       value="{{ $appointment->title }}"
                       class="w-full border rounded p-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block">Description</label>
                <textarea name="description"
                          class="w-full border rounded p-2">{{ $appointment->description }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block">Date & Time</label>
                <input type="datetime-local"
                       name="appointment_at"
                       value="{{ $appointment->appointment_at->format('Y-m-d\TH:i') }}"
                       class="w-full border rounded p-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block">Remind before (minutes)</label>
                <input type="number"
                       name="remind_before"
                       value="{{ $appointment->remind_before }}"
                       class="w-full border rounded p-2"
                       required>
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Update
            </button>

        </form>

    </div>
</x-app-layout>
