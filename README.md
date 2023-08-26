# laravel-livewire3-dateRangePicker

## Don't use this repo at the moment!

It is not working. The Date Range Picker is online only for clarification.

This example is based on Laravel 10.20 and Livewire 3.0.

The included date range picker component uses AlpineJS and it is based on a Blade component.

The Blade component `date-range-picker` itself is use within a Livewire component named `search-bar`. After selecting a date range the Blade component dispatches the result to a given name in a property. The listener is in the Livewire search-bar component.

After this moment the AlpineJS Object within the Blade component looses a part of his properties. The console log is full of errors.

Even if the code line (610 and 611 in date-range-picker) with `$wire.dispatch` is commented out and you press the button "Dispatch result" which fires another event in `searchbar`, the same errors are fired in consol log. This button uses a normal `wire:click="functionName"` action.
The means a request from AlpineJS to the Backend destroys my AlpineJS Object.

Same functionallity worked in Livewire 2.
