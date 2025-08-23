<x-filament-panels::page>
    <form wire:submit.prevent="printPdf">
        {{ $this->form }}

        <div class="mt-6">
            <x-filament::button type="submit">
                Cetak PDF
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>