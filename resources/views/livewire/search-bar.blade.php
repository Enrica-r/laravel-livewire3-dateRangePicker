<div>
    <div id="searchBar" class="bg-white w-full p-4 rounded max-w-6xl mx-auto">
        @if ($parentSearchStatus === 'all-first')
            <h2>Für welchen Zeitraum suchen Sie ein Apartment?</h2>
        @endif
        <!-- <div class="grid lg:grid-cols-searchbar gap-6 w-full min-h-[80px]"> -->
        <div class="flex flex-col lg:flex-row lg:justifiy-between gap-6 w-full min-h-[80px]">
            <!-- <div class="md:col-span-2"> -->
            <div class="flex-1">
                <x-date-range-picker label="Checkin / Checkout:"
                    placeholder="Bitte wählen Sie Ihre Check-in / Check-out Daten" tabindex="1"
                    wireDispatchTo="setRangeDates" :selectedFromDate="$fromDate" :selectedToDate="$toDate"></x-date-range-picker>
                <div class="lg:hidden mt-2">
                    @if ($durationHuman)
                        Aufenthaltsdauer:
                    @endif{{ $durationHuman }}
                </div>
            </div>

            <div>
                <button type="button"
                    class="w-full h-full px-3 py-3 bg-light-darker-bg-color rounded flex items-center justify-center hover:brightness-105"
                    wire:click="startSearch">Dispatch result
                </button>
            </div>


        </div>
        <div class="flex justify-center lg:justify-between">
            <div class="hidden lg:block mt-2">
                @if ($durationHuman)
                    Aufenthaltsdauer:
                @endif{{ $durationHuman }}
            </div>
            @if (!Str::startsWith($parentSearchStatus, 'all'))
                <button class="ml-4 font-bold" wire:click="resetDates" class="mt-2 lg:mr-3">Reset results</button>
            @endif
        </div>
        <div wire:loading.flex wire:target="startSearch"
            class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 px-4 py-6 w-9/12 max-w-lg bg-slate-800 opacity-80 text-white sm:text-2xl
        hidden flex-col sm:flex-row items-center gap-4">
            <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
                role="status">
                <span
                    class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
            </div>
            <div class="sm:ml-2">Suche verfügbare Apartments...</div>
        </div>
    </div>
    <div x-show="$wire.get('parentSearchStatus') === 'found'" class="mt-8 p-4 bg-gray-50">
        <h2 class="text-2xl font-bold">Result after dispatch "setRangeDates"</h2>
        <p>Checkin date: {{$fromDate}}</p>
        <p>Checkout date: {{$toDate}}</p>
        <div class="inline-block mt-8 bg-light-button-color text-white p-2 hover:cursor-pointer" wire:click="resetDates">Reset Dates</div>
    </div>
</div>
