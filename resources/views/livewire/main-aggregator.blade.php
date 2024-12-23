<div x-data="snowreport" class="w-full">
    <ul @class([
        'relative grid grid-cols-1',
        'md:grid-cols-2 gap-4' => empty($this->favouriteSnowReports),
        'gap-1' => !empty($this->favouriteSnowReports),
    ])>
        @forelse ($snowReports as $snowReport)
            <li class="relative overflow-hidden hover:cursor-pointer rounded-xl"
                wire:click.debounce="loadSnowReportInfo({{ $snowReport->id }})" @click="open=true"
                wire:key="snowreport-{{ $snowReport['id'] }}">
                <div
                    class="m-[2px] relative bg-indigo-800 rounded-xl {{ $snowReport['status']->getBorderClass() }} p-6 z-10">
                    <div class="flex items-center justify-between space-x-5">
                        <div class="flex items-center flex-1">
                            <span class="flex items-center justify-center w-10 h-10 text-white sm:w-10 sm:h-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512"
                                    viewBox="0 0 24 24 " fill="currentColor"
                                    class="icon icon-tabler icons-tabler-filled icon-tabler-mountain"
                                    id="Windframe_wi9Cx0JGd">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    </path>
                                    <path
                                        d="M6.18 10.95l2.54 3.175l.084 .093a1 1 0 0 0 1.403 -.01l1.637 -1.638l1.324 1.985a1 1 0 0 0 1.457 .226l3.632 -2.906l3.647 7.697a1 1 0 0 1 -.904 1.428h-18a1 1 0 0 1 -.904 -1.428zm5.82 -7.878a3.3 3.3 0 0 1 2.983 1.888l2.394 5.057l-3.15 2.52l-1.395 -2.092l-.075 -.099a1 1 0 0 0 -1.464 -.053l-1.711 1.709l-1.301 -1.627l-1.151 -1.435l1.888 -3.98a3.3 3.3 0 0 1 2.982 -1.888" />
                                    </path>
                                </svg>
                            </span>
                            <div class="flex-1 min-w-0 mt-0 mb-0 ml-4 mr-0">
                                <p class="text-sm font-bold truncate text-indigo-50">{{ $snowReport['name'] }}</p>
                                {{-- <p opacity="70"
                                    class="mt-1 mb-0 ml-0 mr-0 text-sm font-semibold text-indigo-300 truncate">
                                    Δήμος
                                    Γρεβενών</p> --}}
                            </div>
                        </div>
                        <div class="flex flex-col text-center">
                            <span class="text-lg font-semibold leading-none text-gray-100 lg:text-2xl">
                                {{ $snowReport['open_lifts'] ?? 0 }}
                                <span class="text-lg">|</span>
                                {{ $snowReport['total_lifts'] ?? '0' }}
                            </span>
                            <p class="text-gray-200">Lifts</p>
                        </div>
                    </div>
                </div>
                <div
                    class="absolute inset-0 z-0 w-full h-full duration-700 {{ $snowReport['status']->toTailwindClass() }} opacity-90 animate-pulse">
                </div>
            </li>
        @empty
            <li>No reports found</li>
        @endforelse
    </ul>

    <div x-cloak x-show="open" x-trap.noscroll='open' class="relative z-10" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">

        <div x-cloak x-show="open" x-transition.opacity
            class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75">
        </div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                <div x-transition.opacity @click.outside="open = false"
                    class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-gray-900 rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6">

                    <div>
                        <div class="mt-2 text-center sm:mt-2">
                            <h3 class="text-base font-semibold leading-6 text-gray-100" id="modal-title">Περισσότερες
                                Πληροφορίες</h3>

                            <div wire:loading.flex class="flex items-center justify-center">
                                <x-svg svg="snowflake" class="text-white animate-spin" />
                                <p class="font-semibold text-white">
                                    loading...
                                </p>
                            </div>

                            <div wire:loading.remove class="grid grid-cols-1 mt-2 text-slate-800">

                                <div class="grid grid-cols-6 gap-2 mt-8">
                                    <div class="flex flex-col col-span-2 space-y-2">
                                        <div class="flex items-center justify-center p-2 bg-white rounded-md">
                                            <p class="text-3xl font-black">
                                                {{ $selectedSnowReport->base_snow ?? 0 }}<small
                                                    class="text-xs">cm</small></p>
                                        </div>
                                        <p class="text-sm text-white">Χιόνι Βάσης</p>
                                    </div>
                                    <div class="flex flex-col col-span-2 space-y-2">
                                        <div class="flex items-center justify-center p-2 bg-white rounded-md">
                                            <p class="text-3xl font-black">
                                                {{ $selectedSnowReport->mid_snow ?? 0 }}<small
                                                    class="text-xs">cm</small></p>
                                        </div>
                                        <p class="text-sm text-white">Χιόνι Μέσης</p>
                                    </div>
                                    <div class="flex flex-col col-span-2 space-y-2">
                                        <div class="flex items-center justify-center p-2 bg-white rounded-md">
                                            <p class="text-3xl font-black">
                                                {{ $selectedSnowReport->top_snow ?? 0 }}<small
                                                    class="text-xs">cm</small></p>
                                        </div>
                                        <p class="text-sm text-white">Χιόνι Κορυφής</p>
                                    </div>
                                    <div class="flex flex-col col-span-3 space-y-2">
                                        <div class="flex items-center justify-center p-2 bg-white rounded-md">
                                            <p class="text-2xl font-black">
                                                {{ $selectedSnowReport->snow_quality ?? '-' }}</p>
                                        </div>
                                        <p class="text-sm text-white">Ποιότητα Χιονιού</p>
                                    </div>
                                    <div class="flex flex-col col-span-3 space-y-2">
                                        <div class="flex items-center justify-center p-2 bg-white rounded-md">
                                            <p class="text-2xl font-black">
                                                {{ $selectedSnowReport->last_snowfall ?? '-' }}</p>
                                        </div>
                                        <p class="text-sm text-white">Τελ. Χιονόπτωση</p>
                                    </div>
                                </div>

                                @if ($selectedSnowReport?->getAttributes())
                                    <div class="flex flex-col mt-8 mb-12 space-y-2">
                                        <x-ui.lists.activity-list :infoList="$selectedSnowReport->lifts ?? null" title="Αναβατήρες" />
                                    </div>

                                    <div class="flex flex-col space-y-2">
                                        <x-ui.lists.activity-list :infoList="$selectedSnowReport->slopes ?? null" title="Πίστες" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="mt-5">
                        <button type="button" @click="open=false"
                            class="inline-flex justify-center w-full px-3 py-2 mt-5 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Πίσω</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('snowreport', () => ({
                open: false,
                init() {
                    this.$watch('open', (newValue, oldValue) => {
                        if (newValue === false) {
                            // this timeout is used to get read of a stupid flicker.
                            setTimeout(() => {
                                this.$wire.resetSelectedSnowReport();
                            }, 500);
                        }
                    });
                }
            }));
        });
    </script>
</div>
