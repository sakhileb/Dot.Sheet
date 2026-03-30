<x-app-layout>
    <div class="h-screen bg-gray-50 dark:bg-gray-900">
        @livewire('show-spreadsheet', ['spreadsheet_id' => $spreadsheet->id])
    </div>
</x-app-layout>
