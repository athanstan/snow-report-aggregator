<div>
    <ul class="flex flex-wrap items-center justify-center gap-2 pt-12 list-none md:gap-6">
        <li
            class="flex flex-col items-center justify-center w-16 h-16 p-4 border-2 border-gray-700 rounded-full md:h-24 md:w-24 border-b-gray-400 border-r-gray-400 border-t-gray-400">
            <p class="font-semibold text-gray-400 uppercase text-[7px] md:text-xs">resorts</p>
            <p class="text-xl font-bold md:text-3xl"> {{ $this->snowResortData->total_snow_resorts }}</p>
        </li>
        <li
            class="flex flex-col items-center justify-center w-16 h-16 p-4 border-2 border-gray-700 rounded-full md:h-24 md:w-24 border-r-gray-400 border-t-gray-400">
            <p class="text-xs font-semibold text-gray-400 uppercase text-[7px] md:text-xs">slopes</p>
            <p class="text-xl font-bold md:text-3xl"> {{ $this->snowResortData->total_open_slopes }}</p>
        </li>
        <li
            class="flex flex-col items-center justify-center w-16 h-16 p-4 border-2 border-gray-700 rounded-full md:h-24 md:w-24 border-b-gray-400 border-r-gray-400 border-t-gray-400">
            <p class="text-xs font-semibold text-gray-400 uppercase text-[7px] md:text-xs">lifts</p>
            <p class="text-xl font-bold md:text-3xl"> {{ $this->snowResortData->total_open_lifts }}</p>
        </li>
    </ul>
</div>
