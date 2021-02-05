<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Timetable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const events = [];
            
            @foreach ($lessons as $lesson)
                @php
                    // TODO Restructure
                    $color = "#007bff";
                    $isFuture = new DateTime($lesson->end_time) > new DateTime();

                    if (!$isFuture) {
                        $attended = $lesson->students->contains(Auth::id());
                        $color = $attended ? 'green' : 'red';
                    }
                @endphp

                events.push({
                    id: @json($lesson->id),
                    title: @json($lesson->subject->id),
                    start: @json($lesson->start_time),
                    end: @json($lesson->start_time),
                    allDay: false,
                    color: @json($color),
                    url: "#",

                    extendedProps: {
                        class: @json($lesson->subject->name),
                        attended: @json($isFuture ? !$isFuture : $attended),
                        hall: @json($lesson->room->name),
                        status: @json($lesson->status),
                        comment: @json($lesson->comment)
                    }
                });
            @endforeach
        </script>
        <script src="{{ mix('js/timetable.js') }}" defer></script>
    @endpush
</x-app-layout>