<div x-data="{ open: false }" class="w-full">
    <ul class="relative flex flex-col space-y-3">
        @forelse ($snowReports as $snowReport)
            <li wire:click.debounce="loadSnowReportInfo({{ $snowReport->id }})" @click="open=true"
                wire:key="snowreport-{{ $snowReport['id'] }}"
                class="relative flex items-center justify-between px-4 py-6 transition border border-white rounded-md shadow-md cursor-pointer hover:shadow-sm group bg-gray-50 isolate bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10">
                <div
                    class="absolute inset-0 rounded-md -z-10 bg-gradient-to-t {{ $snowReport->status->toTailwindClass() }} via-gray-50/90 group-hover:via-gray-50/40 transition">
                </div>
                <p class="text-2xl font-extrabold tracking-wide text-slate-800">
                    {{ $snowReport['name'] }}
                </p>
                <div class="flex flex-col text-center">
                    <span class="text-2xl font-semibold leading-none text-slate-500">
                        {{ $snowReport['open_lifts'] ?? 0 }}
                        <span class="text-lg">|</span>
                        {{ $snowReport['total_lifts'] ?? '0' }}
                    </span>
                    <p class="text-slate-500/50">Lifts</p>
                </div>
            </li>
        @empty
            <li>No reports found</li>
        @endforelse
    </ul>

    <div x-cloak x-show="open" x-trap.noscroll='open' class="relative z-10" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">

        <div x-show="open" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75">
        </div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                <div x-transition.opacity @click.outside="open = false"
                    class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div>
                        <div class="mt-2 text-center sm:mt-2">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Περισσότερες
                                Πληροφορίες</h3>

                            <div wire:loading wire:target="selectedSnowReport">
                                Loading post...
                            </div>

                            <div class="grid grid-cols-1 mt-2">

                                <div class="flex flex-col mb-12 space-y-2">
                                    <div>
                                        <h2 class="text-lg font-semibold">Αναβατήρες</h2>
                                    </div>
                                    <ul role="list" class="space-y-6">
                                        @forelse ($selectedSnowReport?->lifts ?? [] as $lift)
                                            <li class="relative flex gap-x-4">
                                                @unless ($loop->last)
                                                    <div class="absolute top-0 left-0 flex justify-center w-6 -bottom-6">
                                                        <div class="w-px bg-gray-200"></div>
                                                    </div>
                                                @endunless
                                                <div
                                                    class="relative flex items-center justify-center flex-none w-6 h-6 bg-white">
                                                    <div
                                                        class="h-1.5 w-1.5 rounded-full {{ $lift->status->toTailwindClass() }} ring-green-400/20 ring-1 ring-inset ring-gray-300">
                                                    </div>
                                                </div>
                                                <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500"><span
                                                        class="font-medium text-gray-900">{{ $lift->name }}</span></p>
                                                <time datetime="2023-01-23T10:32"
                                                    class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ $lift->updated_at->diffForHumans() }}</time>
                                            </li>
                                        @empty
                                            <li>No lifts found</li>
                                        @endforelse
                                    </ul>
                                </div>

                                <div class="flex flex-col space-y-2">
                                    <div>
                                        <h2 class="text-lg font-semibold">Πίστες</h2>
                                    </div>
                                    <ul role="list" class="space-y-6">
                                        @forelse ($selectedSnowReport?->slopes ?? [] as $slope)
                                            <li class="relative flex gap-x-4">
                                                @unless ($loop->last)
                                                    <div class="absolute top-0 left-0 flex justify-center w-6 -bottom-6">
                                                        <div class="w-px bg-gray-200"></div>
                                                    </div>
                                                @endunless
                                                <div
                                                    class="relative flex items-center justify-center flex-none w-6 h-6 bg-white">
                                                    <div
                                                        class="h-1.5 w-1.5 rounded-full {{ $slope->status->toTailwindClass() }} ring-1 ring-gray-300">
                                                    </div>
                                                </div>
                                                <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500"><span
                                                        class="font-medium text-gray-900">{{ $slope->name }}</span>
                                                </p>
                                                <time datetime="2023-01-23T10:32"
                                                    class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ $slope->updated_at->diffForHumans() }}</time>
                                            </li>
                                        @empty
                                            <li>Δεν βρέθηκαν Πίστες</li>
                                        @endforelse
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                        <button type="button" @click="open=false"
                            class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

</div>
