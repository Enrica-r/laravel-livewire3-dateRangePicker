@props([
    'name' => 'datepicker',
    'label' => '',
    'error' => '',
    'selectedFromDate' => '',
    'selectedToDate' => '',
    'futureOnly' => true,
    'calendarStartDate' => '',
    'calendarEndDate' => '',
    'clickAutoClose' => true,
    'placeholder' => '',
    'showNights' => true,
    'fromText' => 'Checkin:',
    'toText' => 'Checkout:',
    'rangeUnitSingular' => 'Nacht',
    'rangeUnitPlural' => 'Nächte',
    'wireDispatchTo' => '',
])



<div x-data="dateRangepicker()" x-init="
selectedFromDate = '{{ $selectedFromDate }}';
selectedToDate = '{{ $selectedToDate }}';
futureOnly = {{ $futureOnly }};
calStartDate = '{{ $calendarStartDate }}';
calEndDate = '{{ $calendarEndDate }}';
clickAutoClose = {{ $clickAutoClose }};
showNights = {{ $showNights }};
fromText = '{{ $fromText }}';
toText = '{{ $toText }}';
rangeUnitSingular = '{{ $rangeUnitSingular }}';
rangeUnitPlural = '{{ $rangeUnitPlural }}';
wireDispatchTo = '{{ $wireDispatchTo }}'
initDate();" x-cloak>

    @if ($label != '')
        <label for="datepicker" class="font-bold mb-1 text-gray-700 block">
            {{ $label }}
        </label>
    @endif
    <input type="hidden" name="{{ $name }}-from" x-ref="hiddenFromDate" :value="selectedFromDate" />
    <input type="hidden" name="{{ $name }}-to" x-ref="hiddenToDate" :value="selectedToDate" />
    <div {{ $attributes->merge([
        'class' => 'sm:relative h-full flex items-center justify-between gap-0 w-full py-3 px-2 min-h-[4em] lg:min-w-[41em]
            font-medium border border-gray-300 rounded-md shadow-sm outline-none',
        'tabindex' => '0',
    ]) }}
        @click="openDatePicker()" x-ref="dateInput">

        <div>
            <template x-if="displayFromDate != ''">
                <div class="flex flex-col md:flex-row text-xl sm:text-2xl font-bold">
                    <span x-text="displayFromDate"></span>
                    <template x-if="displayToDate != ''">
                        <div class="self-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="inline-block h-8 origin-center rotate-90 md:ml-3 md:rotate-0"
                                viewBox="0 96 960 960">
                                <path
                                    d="m120 856 180-280-180-280h478q22 0 40 11.5t31 28.5l171 240-171 240q-13 17-31 28.5T598 856H120Zm110-60h380l156-220-156-220H230l142 220-142 220Zm142-220L230 356l142 220-142 220 142-220Z" />
                            </svg>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="inline-block -ml-3 mr-3 h-8 origin-center rotate-90 md:rotate-0"
                                viewBox="0 96 960 960">
                                <path
                                    d="m120 856 180-280-180-280h478q22 0 40 11.5t31 28.5l171 240-171 240q-13 17-31 28.5T598 856H120Zm110-60h380l156-220-156-220H230l142 220-142 220Zm142-220L230 356l142 220-142 220 142-220Z" />
                            </svg>

                        </div>
                    </template>
                    <span x-text="displayToDate"></span>
                </div>
            </template>
            <template x-if="displayFromDate == ''">
                <span class="text-gray-400">{{ $placeholder }}</span>
            </template>
        </div>
        <div class="right-0 px-3" :class="{ 'text-gray-800': showDatepicker }">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>



        @if ($error != '')
            <div class="text-sm text-red-800 mt-1 ml-2">
                {{ $error }}
            </div>
        @endif
        {{-- DateSelector Box --}}
        <div class="bg-white overflow-y-auto border border-gray-200 rounded-lg shadow p-4 fixed z-[50] left-1/2 -translate-x-1/2 w-10/12 xs:w-9/12 top-2 bottom-auto
                            sm:absolute sm:top-0 sm:left-0 sm:bottom-auto sm:z-[47] sm:translate-x-0 sm:translate-y-0 sm:w-[35em] md:w-[43em]"
            x-cloak x-show="showDatepicker" @click.away="closeDatePicker()" x-ref="dateSelector"
            @scroll.window.debounce="checkPosition()" @resize.window.debounce="checkPosition()">
            {{-- Titel box --}}
            @isset($title)
                $title
            @endisset
            {{-- Closing symbol --}}
            <div class="text-right sm:hidden mb-7">
                <div class="inline-block px-2 p-1 border rounded hover:bg-light-bg-color hover:cursor-pointer" @click.stop="closeDatePicker()">
                    <span >X</span>
                </div>
            </div>
            <div class="absolute top-13 sm:top-3.5 left-3.5 focus:outline-none focus:shadow-outline transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-100 p-1 rounded-full"
                :class="hasPreviousMonth() ? '' : 'invisible';" @click="decrementMonth()">
                <svg class="h-6 w-6 text-gray-400 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
            <div class="absolute top-13 sm:top-3.5 right-3.5 focus:outline-none focus:shadow-outline transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-100 p-1 rounded-full"
                :class="hasNextMonth() ? '' : 'invisible'" @click="incrementMonth()">
                <svg class="h-6 w-6 text-gray-400 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>

            {{-- Calendars box --}}
            <div class="grid sm:grid-cols-2 gap-4">
                {{-- Calendar --}}
                <template x-for="(calendar, calIndex) in calendars" :key="calendar['monthName']">
                    <template x-if="calIndex < showCountOfCalendars">
                    <div>
                        {{-- Calendar title --}}
                        <div class="w-full flex justify-center mb-2">

                            <div>
                                <span x-text="calendar['monthName']"
                                    class="text-lg font-bold text-gray-800"></span>
                                <span x-text="calendar['year']" class="ml-1 text-lg text-gray-600 font-normal"></span>
                            </div>

                        </div>


                        {{-- Calendar date grid --}}
                        <div
                            class="w-auto grid grid-cols-7 grid-rows-6 row-gap-2 col-gap-4 justify-center items-center">
                            {{-- row with weekday title --}}
                            <template x-for="(weekday, index) in weekDays" :key="index">
                                <div class="text-gray-100 font-medium text-center text-sm">
                                    <div x-text="weekday" class="text-gray-800 font-medium text-center text-xs"></div>
                                </div>
                            </template>
                            <template x-for="blankday in calendar['blankDays']">
                                <div class="text-center border p-1 border-transparent text-sm sm:aspect-square"></div>
                            </template>
                            <template x-for="(date, dateIndex) in calendar['dates']" :key="date">
                                <div class="aspect-square">
                                    <div @click.stop="clickDate(date)" @mouseenter="onMouseEnter(date)"
                                        x-text="dateIndex + 1" :class="getClass(date)">
                                    </div>
                                </div>
                            </template>
                            <template x-for="fillDay in calendar['fillDays']">
                                <div class="text-center border p-1 border-transparent text-sm aspect-square"></div>
                            </template>
                        </div>
                    </div>
                    </template>
                </template>
            </div>
            <div class="flex flex-wrap justify-between gap-2">
                <template x-if="fromText && displayFromDate">
                    <div>
                        <span x-text="fromText"></span>
                        <span x-text="displayFromDate"></span>
                    </div>
                </template>
                <template x-if="rangeUnitSingular && displayFromDate">
                    <div>
                        <span x-text="countOfNights"></span>
                        <span x-show="countOfNights == 1" x-text="rangeUnitSingular"></span>
                        <span x-show="countOfNights != 1" x-text="rangeUnitPlural"></span>

                    </div>
                </template>
                <template x-if="toText && displayToDate">
                    <div>
                        <span x-text="toText"></span>
                        <span x-text="displayToDate"></span>
                    </div>
                </template>

            </div>

        </div>
    </div>
</div>


@pushOnce('scriptsBottom')
    <script>
        function dateRangepicker() {
            return {
                tempPrep: 0,
                tempSet: 0,
                showDatepicker: false,
                clickAutoClose: false,
                displayFromDate: "",
                displayToDate: "",
                countOfNights: 0,
                selectedFromDate: "",
                selectedToDate: "",
                wireDateFromAttributeName: "",
                wireDateToAttributeName: "",
                preSelectToDate: "",
                calStartDate: "",
                calEndDate: "",
                originalCalStartDate: "",
                futureOnly: false,
                countOfCalendars: 2,
                showCountOfCalendars: this.countOfCalendars,
                startWeekDay: 1, // 0 Sunday, 1 Monday
                weekDays: [],
                fromText: "",
                toText: "",
                rangeUnitSingular: "",
                rangeUnitPlural: "",
                showNights: true,
                wireDispatchTo: '',
                calendars: [], // nested array with [0: {month: 2, year: 2023, dates: ['2023-02-01', '2023-02-02', ...], blankDays: [1,2,3]}]
                initDate() {
                    let range;
                    console.log("initDate");

                    // this.$watch('selectedFromDate', (date) => this.watchSelectedFromDate(date));
                    // this.$watch('selectedToDate', (date) => this.watchSelectedToDate(date));

                    range = this.setDateInRange();
                    this.originalCalStartDate = this.calStartDate;

                    // this.watchSelectedFromDate(this.selectedFromDate);
                    // this.watchSelectedToDate(this.selectedToDate);
                    this.setFormatFromDate(this.selectedFromDate);
                    this.setFormatToDate(this.selectedToDate);
                    this.countOfNights = this.calcCountOfNights(this.selectedFromDate, this.selectedToDate);

                    this.calcWeekDays();
                    this.prepareCalendars(range['from']);
                },
                openDatePicker() {
                    console.log("openDatePicker");
                    if (this.showDatepicker === false) {
                        if (window.matchMedia('(min-width: 640px)').matches == true) {
                            window.scrollBy(0, this.$refs.dateInput.getBoundingClientRect().top - 170);
                        }
                        this.showDatepicker = true;
                        this.checkPosition();
                        this.$nextTick(() => {
                            this.checkPosition();
                        });
                    }
                },
                closeDatePicker() {
                    console.log('closePicker');
                    if (this.displayFromDate != '' && this.displayToDate == '') {
                        this.deleteDate();
                    }

                    this.showDatepicker = false;

                    //this.$nextTick(() => {});
                },
                formatDateForDisplay(date, dateStyle = 'weekdayShort') {
                    if (date === "") {
                        return "";
                    }
                    let options = {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    }
                    switch (dateStyle) {
                        case 'numeric':
                            options = {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            };
                            break;
                        case 'short':
                            options = {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            };
                            break;
                        case 'long':
                            options = {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            };
                            break;
                        case 'weekdayShort':
                            options = {
                                weekday: 'short',
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            };
                            break;
                        case 'full':
                            options = {
                                weekday: 'long',
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            };
                            break;
                    }
                    date = typeof date == 'string' ? new Date(date) : date;
                    return date.toLocaleDateString(navigator.language, options);
                },
                getClass(date) {
                    const base =
                        "w-full h-full flex justify-center items-center cursor-pointer text-sm transition ease-in-out duration-100";
                    const standard = "text-gray-900 hover:bg-light-bg-color"
                    const today = "bg-[#edeae7] rounded-full";
                    const todayDisabled = "bg-[#edeae7] bg-opacity-50 rounded-full p-2";
                    const disabled = "text-gray-400";
                    const rangeFrom = "bg-[#9A8175] text-white hover:bg-opacity-75 rounded-l-full";
                    const rangeTo = "bg-[#9A8175] text-white hover:bg-opacity-75 rounded-r-full";
                    const rangeInDef = "bg-[#dcd5cf] hover:bg-opacity-75";
                    const rangeInProv = "bg-[#edeae7]"

                    let cl = base;
                    let d = this.getDateObject(date);
                    let isToday = (this.getIsoDateFormat(d) == this.getIsoDateFormat(this.getDateObject()));
                    let from = this.selectedFromDate != "" ? new Date(this.selectedFromDate) : d;
                    let to = this.selectedToDate != "" ? new Date(this.selectedToDate) : d;
                    let calStart = this.calStartDate != "" ? new Date(this.calStartDate) : d;
                    let calEnd = this.calEndDate != "" ? new Date(this.calEndDate) : d;

                    if (date == this.selectedFromDate) {
                        cl += ' ' + rangeFrom;
                    }
                    if (date == this.selectedToDate) {
                        cl += ' ' + rangeTo;
                    }
                    if (d < calStart) {
                        cl += isToday == false ? " " + disabled : "";
                    }
                    if (d > calEnd) {
                        cl += isToday == false ? " " + disabled : "";
                    }
                    if (d > from && d < to) {
                        cl += ' ' + rangeInDef;
                    }
                    if (d > from && d < this.preSelectToDate && this.selectedToDate == "") {
                        cl += ' ' + rangeInProv;
                    }
                    if (isToday == true) {
                        cl += this.isDisabled(d) ? ' ' + todayDisabled : ' ' + today;
                    }
                    if (d >= calStart && d <= calEnd && isToday == false && date != this.selectedFromDate && date != this
                        .selectedToDate) {
                        cl += ' ' + standard;
                    }

                    return cl;
                },
                checkPosition() {
                    let topShift = 0;
                    console.log("checkPosition", this.$refs.dateSelector.style.display);
                    if (this.$refs.dateSelector.style.display != 'none') {
                        console.log("checkPosition after if")
                        if (window.matchMedia('(min-width: 640px)').matches == true) {
                            const winHeight = window.innerHeight;
                            const inputRect = this.$refs.dateInput.getBoundingClientRect();
                            const selectorHeight = this.$refs.dateSelector.getBoundingClientRect().height;
                            if (inputRect.bottom + selectorHeight > winHeight) {
                                topShift = Math.min(selectorHeight, inputRect.top - 3) * -1;
                                this.$refs.dateSelector.style.top = topShift + 'px';
                            } else {
                                this.$refs.dateSelector.style.top = inputRect.height + "px";
                            }
                            this.showCountOfCalendars = this.countOfCalendars;
                        } else {
                            this.$refs.dateSelector.style.top = "3em";
                            this.showCountOfCalendars = 1;
                        //    this.$refs.dateSelector.style.removeProperty('top');

                            // if (this.showCountOfCalendars != this.countOfCalendars) {
                               // this.prepareCalendars(this.calendars[0]['dates'][0]);
                                // this.$nextTick(() => {
                                    console.log("normal", window.innerHeight, (this.$refs.dateSelector.offsetHeight + 45) );

                                    // if (this.$refs.dateSelector.height != 'auto' && window.innerHeight < (this.$refs.dateSelector.offsetHeight + 45)) {
                                    //     console.log("set count to 1");
                                    //     this.showCountOfCalendars = 1;
                                    // //    this.prepareCalendars(this.calendars[0]['dates'][0]);
                                    // } else {
                                    //     console.log("set count to 2");
                                    //     this.showCountOfCalendars = this.countOfCalendars;
                                    // }
                                // });

                                // this.$nextTick(() => {
                                //     console.log("nextTick", window.innerHeight, (this.$refs.dateSelector.offsetHeight + 45) );

                                //     if (this.$refs.dateSelector.height != 'auto' && window.innerHeight < (this.$refs.dateSelector.offsetHeight + 45)) {
                                //         console.log("set count to 1");
                                //         this.showCountOfCalendars = 1;
                                //     //    this.prepareCalendars(this.calendars[0]['dates'][0]);
                                //     } else {
                                //         console.log("set count to 2");
                                //         this.showCountOfCalendars = this.countOfCalendars;
                                //     }
                                // });




                                // }
                            // if (window.innerHeight < (this.$refs.dateSelector.offsetHeight + 45)) {
                            //             this.showCountOfCalendars = 1;
                            //         //    this.prepareCalendars(this.calendars[0]['dates'][0]);
                            //         } else {
                            //             this.showCountOfCalendars = this.countOfCalendars;
                            //         }
                            // if (window.innerHeight < (this.$refs.dateSelector.offsetHeight + 20)) {
                            //     this.originalCountOfCalendars = this.originalCountOfCalendars == 0 ? this.countOfCalendars :
                            //         this.originalCountOfCalendars;
                            //     this.countOfCalendars = 1;
                            //    this.prepareCalendars(this.calendars[0]['dates'][0]);

                            // }
                        }
                    }
                },
                getMonthName(month, dateStyle = 'long') {
                    console.log("getMonthName");
                    const format = new Intl.DateTimeFormat(navigator.language, {
                        month: dateStyle
                    }).format;
                    const date = new Date();
                    date.setUTCMonth(month, 1);
                    return format(date);
                },
                getWeekDayName(date = this.getDateObject, dateStyle = 'short') {
                    date = typeof date == 'string' ? this.getDateObject(date) : date;
                    const format = new Intl.DateTimeFormat(navigator.language, {
                        weekday: dateStyle
                    }).format;
                    date.setUTCHours(0, 0, 0, 0);
                    return format(date);
                },
                calcWeekDays() {
                    const format = new Intl.DateTimeFormat(navigator.language, {
                        weekday: 'short'
                    }).format;
                    const date = this.getDateObject();
                    const days = [];
                    date.setDate(date.getUTCDate() - date.getUTCDay() + this.startWeekDay);
                    for (let i = 0; i < 7; i++) {
                        //    this.days.push(format(date));
                        days.push(format(date));
                        date.setUTCDate(date.getUTCDate() + 1);
                    }
                    this.weekDays = days;
                    return days;
                },
                getIsoDateFormat(date) {
                    //console.log("getIsoDateFormat");
                    if (date === ""){
                        return "";
                    }
                    date = typeof date == 'string' ? new Date(date) : date;
                    return date.getUTCFullYear() + '-' + ("0" + (date.getUTCMonth() + 1)).slice(-2) + '-' + ("0" + date
                            .getUTCDate())
                        .slice(-2);
                },

                isToday(date) {
                    const today = this.getDateObject();
                    const d = this.getDateObject(date);
                    return today === d ?
                        true :
                        false;
                },
                isDisabled(date) {
                    let currDate = this.getDateObject(date);

                    if (this.calStartDate) {
                        calStartDate = new Date(this.calStartDate);
                        if (currDate < calStartDate) {
                            return true;
                        }
                    }
                    if (this.calEndDate) {
                        calEndDate = new Date(this.calEndDate);
                        if (currDate > calEndDate) {
                            return true;
                        }
                    }
                    return false;
                },
                hasPreviousMonth(calendar = '') {
                    if (this.calStartDate) {
                        calendar = calendar == '' ? this.calendars[0] : calendar;
                        let currentMonth = new Date(calendar['dates'][0]);
                        let minMonth = new Date(this.calStartDate);
                        minMonth.setUTCDate(1);
                        if (currentMonth > minMonth) {
                            return true;
                        }
                        return false;
                    }
                    return true;
                },
                hasNextMonth(calendar = '') {
                    if (this.calEndDate) {
                        calendar = calendar == '' ? this.calendars[this.calendars.length - 1] : calendar;
                        let currentMonth = new Date(calendar['dates'][0]);
                        let maxMonth = new Date(this.calEndDate);
                        maxMonth.setUTCMonth(maxMonth.getUTCMonth + 1);
                        maxMonth.setUTCDate(0);
                        if (currentMonth < maxMonth) {
                            return true;
                        }
                        return false;
                    }
                    return true;
                },
                incrementMonth() {
                    console.log("incrementMonth");
                    let monthsArray = [];
                    let date = '';
                    if (this.hasNextMonth(this.calendars[this.calendars.length - 1])) {
                        for (let i = 0; i < this.countOfCalendars; i++) {
                            date = new Date(this.calendars[i]['dates'][0]);
                            date.setUTCMonth(date.getUTCMonth() + 1);
                            monthsArray.push(date);
                        }
                        this.prepareCalendars(monthsArray);
                    }
                },

                decrementMonth() {
                    console.log("decrementMonth");
                    let monthsArray = [];
                    let date = '';
                    if (this.hasPreviousMonth()) {
                        for (let i = 0; i < this.countOfCalendars; i++) {
                            date = new Date(this.calendars[i]['dates'][0]);
                            date.setUTCMonth(date.getUTCMonth() - 1);
                            monthsArray.push(date);
                        }
                        this.prepareCalendars(monthsArray);
                    }
                },
                onMouseEnter(date) {
                    this.preSelectToDate = this.getDateObject(date);
                    if (this.displayFromDate != "") {
                         this.countOfNights = this.calcCountOfNights(this.selectedFromDate, this.preSelectToDate);
                    } else {
                        this.countOfNights = 0;
                    }
                },
                onMouseLeave() {
                    this.preSelectToDate = "";
                    this.countOfNights = 0;
                },
                calcCountOfNights(fromDate, toDate) {
                    if (fromDate === "" || toDate === ""){
                        return 0;
                    }

                    fromDate = this.getDateObject(fromDate);
                    toDate = this.getDateObject(toDate);
                    return Math.max((toDate - fromDate) / (1000 * 60 * 60 * 24), 0);
                },
                clickDate(date) {
                    this.setDateValue(date);
                    if (this.clickAutoClose == true && this.selectedToDate != "") {
                            console.log('clickDate before', this.showDatepicker)
                        this.showDatepicker = !this.showDatepicker;
                            console.log('clickDate after', this.showDatepicker)
                    }

                },
                setDateValue(date) {
                    this.tempSet++
                    console.log("setDateValue: ", this.tempSet);
                    if (this.isDisabled(date) === false || date == "") {

                        let selectedDate = this.getDateObject(date);

                        if ((this.selectedFromDate == "" && this.selectedToDate == "") || this.selectedFromDate != "" && this.selectedToDate != "") {
                            // Start range
                            this.selectedFromDate = date;
                            this.selectedToDate = "";
                            this.calStartDate = date;

                        } else if (this.selectedFromDate != "" && this.selectedToDate == "") {
                            // End range
                            if (this.selectedFromDate == date) {
                                this.selectedFromDate = "";
                                this.selectedToDate = "";
                            } else {
                                this.selectedToDate = date;
                            }
                            if (Object.hasOwn(Livewire, 'all') && this.wireDispatchTo != "") {
                                this.$wire.dispatch(this.wireDispatchTo, {from: this.getIsoDateFormat(this.selectedFromDate), to: this
                                    .getIsoDateFormat(this.selectedToDate)});
                            }
                            this.calStartDate = this.originalCalStartDate;

                        }
                        this.setFormatFromDate(this.selectedFromDate);
                        this.setFormatToDate(this.selectedToDate);
                    }
                },
                // watchSelectedFromDate(date){
                //     this.$refs.hiddenFromDate.value = this.getIsoDateFormat(date);
                //     this.displayFromDate = this.formatDateForDisplay(date);
                // },
                // watchSelectedToDate(date){
                //     this.$refs.hiddenToDate.value = this.getIsoDateFormat(date);
                //     this.displayToDate = this.formatDateForDisplay(date);
                // },
                setFormatFromDate(date){
                    this.$refs.hiddenFromDate.value = this.getIsoDateFormat(date);
                    this.displayFromDate = this.formatDateForDisplay(date);
                },
                setFormatToDate(date){
                    this.$refs.hiddenToDate.value = this.getIsoDateFormat(date);
                    this.displayToDate = this.formatDateForDisplay(date);
                },
                deleteDate() {
                    this.selectedFromDate = "";
                    this.selectedToDate = "";
                    this.setFormatFromDate("");
                    this.setFormatToDate("");

                    if (Object.hasOwn(window, 'livewire')) {
                        this.$wire.emit('resetDates');
                    }

                },
                setDateInRange() {
                    console.log("setDateInRange");
                    let today = this.getDateObject()
                    let rangeFrom = this.selectedFromDate != "" ? new Date(this.selectedFromDate) : this.getDateObject();
                    let rangeTo = this.selectedToDate != "" ? new Date(this.selectedToDate) : this.getDateObject();


                    rangeFrom = this.futureOnly == true ? new Date(Math.max(rangeFrom, today)) : rangeFrom;

                    if (this.calStartDate) {
                        let calStartDate = new Date(this.calStartDate);
                        if (rangeFrom < calStartDate) {
                            rangeFrom = calStartDate;
                        }
                    } else if (this.futureOnly == true) {
                        this.calStartDate = this.getIsoDateFormat(rangeFrom);
                    }

                    if (this.calEndDate) {
                        let calEndDate = new Date(this.calEndDate);
                        if (rangeTo > calEndDate) {
                            rangeTo = calEndDate;
                        }
                    }
                    this.selectedFromDate = this.selectedFromDate != '' ? this.getIsoDateFormat(rangeFrom) : '';
                    this.selectedToDate = this.selectedToDate != '' ? this.getIsoDateFormat(rangeTo) : '';

                    return {
                        from: rangeFrom,
                        to: rangeTo
                    };
                },
                getDateObject(date = new Date()) {
                    date = typeof date == 'string' ? new Date(date) : date;
                    date.setUTCHours(0, 0, 0, 0);
                    //    date = new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()));
                    return date;
                },
                prepareCalendars(month = this.getDateObject()) {
                    this.tempPrep++;
                    console.log("prepareCalendars: ", this.tempPrep);
                    let monthsArray = [];
                    let firstDate = Date();
                    if (typeof month == 'number') {
                        firstDate = this.getDateObject();
                        firstDate.setUTCMonth(month, 1);
                        monthsArray.push(firstDate);
                    } else if (typeof month == 'string') {
                        firstDate = this.getDateObject(month);
                        firstDate.setUTCDate(1);
                        monthsArray.push(firstDate);
                    } else if (month.constructor.name == 'Array') {
                        monthsArray = month.map((d) => {
                            if (typeof d == 'string') {
                                firstdate = this.getDateObject(month);
                                firstdate.setUTCDate(1);
                                return firstdate;
                            } else if (typeof d == 'number') {
                                firstDate = this.getDateObject;
                                firstDate.setUTCMonth(d, 1)
                                return firstDate;
                            }
                            return d;
                        })
                    } else if (month.constructor.name == 'Object') {
                        monthsArray = month.map((m) => {
                            return new Date(m['dates'][0]);
                        })
                    } else if (month.constructor.name == 'Date') {
                        month.setUTCDate(1);
                        monthsArray.push(this.getDateObject(month));
                    }
                    let i = 0;

                    for (i = monthsArray.length; i < this.countOfCalendars; i++) {
                        monthsArray.push(this.getDateObject(monthsArray[i - 1].getFullYear() + '-' + ('0' + (monthsArray[i -
                            1].getMonth() + 2)).slice(-2) + '-' + '01'));
                        //                        monthsArray.push(this.getDateObject(monthsArray[i - 1].getFullYear(), monthsArray[i - 1].getMonth() + 1, 1));
                    }
                    // console.log('prepare Calendar: ', this.countOfCalendars)
                    let calStartDate = this.calStartDate != "" ? this.getDateObject(this.calStartDate) : new Date(
                        monthsArray[0]);
                    calStartDate.setUTCDate(1);
                    let calEndDate = this.calEndDate != "" ? this.getDateObject(this.calEndDate) : new Date(monthsArray[
                        monthsArray.length - 1]);
                    calEndDate.setUTCMonth(calEndDate.getUTCMonth() + 1);
                    calEndDate.setUTCDate(0);

                    // console.log(monthsArray);
                    i = 0;
                    this.calendars = [];
                    monthsArray.forEach((date) => {
                        // console.log(date);
                        let day = 1;
                        let daysInMonth = 30;
                        let dayOfWeek = 0;
                        let d = 1;

                        if (date < calStartDate) {
                            return;
                        }
                        if (date > calEndDate) {
                            return;
                        }

                        this.calendars[i] = {};
                        this.calendars[i]['month'] = date.getUTCMonth();
                        this.calendars[i]['monthName'] = this.getMonthName(date.getUTCMonth());
                        this.calendars[i]['year'] = date.getUTCFullYear();
                        daysInMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
                        this.calendars[i]['dates'] = []
                        for (d = 1; d <= daysInMonth; d++) {
                            this.calendars[i]['dates'].push(date.getUTCFullYear() + '-' + ("0" + (date
                                    .getUTCMonth() + 1))
                                .slice(-2) + '-' + ("0" + d).slice(-2));
                        }

                        dayOfWeek = date.getUTCDay() - this.startWeekDay;
                        dayOfWeek = dayOfWeek < 0 ? dayOfWeek + 7 : dayOfWeek;
                        this.calendars[i]['blankDays'] = [];
                        for (d = 1; d <= dayOfWeek; d++) {
                            this.calendars[i]['blankDays'].push(d);
                        }
                        this.calendars[i]['fillDays'] = [];
                        for (d = (daysInMonth + dayOfWeek); d < 42; d++) {
                            this.calendars[i]['fillDays'].push(d);
                        }

                        i++
                    })
                }
            };
        }
    </script>
@endPushOnce
