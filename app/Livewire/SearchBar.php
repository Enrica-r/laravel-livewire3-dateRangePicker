<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class SearchBar extends Component
{
    public $countOfGuests = 1;

    public string $parentSearchStatus = 'all';

    public string $fromDate = '2023-08-25';
    public string $toDate = '2023-09-01';
    public string $durationHuman = '';

    protected $listeners = ['setRangeDates', 'resetDates', 'setChildSearchStatus' => 'setParentSearchStatus'];

    public function setRangeDates(string $from, string $to) {
        $this->fromDate = $from;
        $this->toDate = $to;
        $this->setDurationHuman();
    }

    public function startSearch() {
        if ($this->fromDate === '' && $this->toDate === ''){
            $this->resetDates();
        } else {
//            $this->dispatch('searchApartmentlist', $this->fromDate, $this->toDate, $this->countOfGuests);
            $this->parentSearchStatus = 'found';
        }
    }

    public function setParentSearchStatus($status) {
        $this->parentSearchStatus = $status;
    }

    public function resetDates() {
        $this->parentSearchStatus = 'all';
        $this->fromDate = '';
        $this->toDate = '';
        $this->setDurationHuman();
    //    $this->dispatch('changeStatus', 'all');
    }

    public function setDurationHuman() {

        if ($this->fromDate == '' || $this->toDate == '') {
            $this->durationHuman = '';
            return $this->durationHuman;
        }

        $diffInMonths = Carbon::parse($this->toDate)->diffInMonths(Carbon::parse($this->fromDate));
        $d = Carbon::parse($this->fromDate)->addMonths($diffInMonths);
        $diffNights = Carbon::parse($this->toDate)->diffInDays($d);
        $this->durationHuman = $diffInMonths > 0 ? $diffInMonths . ($diffInMonths === 1 ? ' Monat' : ' Monate') : '';
        $this->durationHuman .= $diffNights > 0 ? ' ' . $diffNights . ($diffNights === 1 ? ' Nacht' : ' Nächte') : '';
        return $this->durationHuman;
    }


    public function render()
    {
        return view('livewire.search-bar');
    }
}



