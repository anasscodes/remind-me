<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Add Appointment</h2>
    </x-slot>

    <div class="p-6 max-w-lg">

        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block">Title</label>
                <input type="text" name="title"
                       class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block">Description</label>
                <textarea name="description"
                          class="w-full border rounded p-2"></textarea>
            </div>

            <div class="mb-4">
                <label class="block">Date & Time</label>
                <input type="datetime-local"
                       name="appointment_at"
                       class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block">Remind before (minutes)</label>
                <input type="number"
                       name="remind_before"
                       value="10"
                       class="w-full border rounded p-2" required>
            </div>

            <button class="bg-indigo-600 text-white px-4 py-2 rounded">
                Save
            </button>
        </form>

    </div>
</x-app-layout>
