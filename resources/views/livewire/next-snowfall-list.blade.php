<div>
    <div class="pt-8 text-center">
        <h2 class="pb-2 text-4xl font-bold tracking-tight text-center lg:text-5xl">
            Επόμενη Χιονόπτωση
        </h2>
        <p class="justify-center hidden text-base font-medium text-gray-400 sm:flex text-pretty sm:text-lg/8">Ανακαλύψτε
            την αμέσως
            επόμενη
            χιονόπτωση &nbsp; <x-svg class="w-4 h-auto text-white" svg="snowflake" /> &nbsp;
        </p>
        <p class="justify-center hidden -mt-2 text-base font-medium text-gray-400 sm:flex text-pretty sm:text-lg/8"> αλλά
            και την
            επόμενη
            πυκνή
            χιονόπτωση
            &nbsp; <x-svg class="w-4 h-auto text-white" svg="snowflake" /><x-svg class="w-4 h-auto text-white"
                svg="snowflake" /> &nbsp; στα
            αγαπημένα σας βουνά.
        </p>
    </div>
    <div
        class="grid max-w-md grid-cols-1 gap-2 mx-auto sm:grid-cols-3 sm:max-w-2xl md:grid-cols-4 md:max-w-4xl lg:grid-cols-4 xl:grid-cols-6 lg:max-w-5xl xl:max-w-7xl py-11">
        @forelse ($nextSnowfallList as $snowresort)
            <div
                class="relative px-4 py-4 sm:py-2 overflow-hidden rounded-lg bg-slate-800/40 bg-opacity-20 backdrop-blur-sm shadow-[#0014cc]/40 shadow-sm hover:shadow-none transition">
                <!-- Blurry SVG in Top Right -->
                <svg class="absolute opacity-50 pointer-events-none -right-20 top-[-15rem] sm:-top-32 blur-lg"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none">
                    <circle cx="100" cy="100" r="50" fill="url(#gradient)" />
                    <defs>
                        <linearGradient id="gradient" x1="0" y1="0" x2="100" y2="100"
                            gradientUnits="userSpaceOnUse">
                            <stop stop-color="#A855F7" />
                            <stop offset="1" stop-color="#3B82F6" />
                        </linearGradient>
                    </defs>
                </svg>

                <!-- Card Content -->
                <div class="relative z-10">
                    <h3 class="text-lg font-bold text-white">{{ $snowresort['name'] }}</h3>
                    @if ($snowresort['snowfall'] !== null)
                        <div class="relative flex space-x-2">
                            <p class="text-[13px] font-medium text-white">
                                {{ $snowresort['snowfall'] }}
                            </p>
                            <div class="flex">
                                <x-svg class="w-4 h-auto" svg="snowflake" />
                            </div>
                        </div>
                    @endif
                    @if ($snowresort['heavySnowfall'] !== null)
                        <div class="relative flex space-x-2">
                            <p class="text-[13px] font-medium text-white ">
                                {{ $snowresort['heavySnowfall'] }}
                            </p>
                            <div class="flex">
                                <x-svg class="w-4 h-auto" svg="snowflake" />
                                <x-svg class="w-4 h-auto" svg="snowflake" />
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
        @endforelse
    </div>
</div>
