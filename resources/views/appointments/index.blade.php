<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">My Appointments</h2>

            <a href="{{ route('appointments.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded">
                + Add
            </a>
        </div>
    </x-slot>

    <div class="p-6">

        @foreach($appointments as $a)
            

            <div class="flex gap-3 items-center mb-4 p-4 border rounded">
                <div>
                    <h3 class="font-bold">{{ $a->title }}</h3>
                    <p class="text-sm text-gray-500">
                        {{ $a->appointment_at->format('d M Y H:i') }}
                    </p>
                    
                </div>
                     <a href="{{ route('appointments.edit', $a) }}"
       class="text-blue-600">
        Edit
    </a>
                <form method="POST"
                      action="{{ route('appointments.destroy', $a) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600">
                        Delete
                    </button>
                </form>
            </div>
        @endforeach

    </div>
</x-app-layout>
