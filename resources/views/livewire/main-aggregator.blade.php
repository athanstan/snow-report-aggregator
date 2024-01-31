<div x-data="snowreport" class="w-full">
    <ul class="relative flex flex-col space-y-3">
        @forelse ($snowReports as $snowReport)
            <li wire:click.debounce="loadSnowReportInfo({{ $snowReport->id }})" @click="open=true"
                wire:key="snowreport-{{ $snowReport['id'] }}"
                class="relative flex items-center justify-between px-4 py-6 transition rounded-md shadow-md cursor-pointer bg-[#35366D] hover:shadow-sm group border-b-4 {{ $snowReport['status']->getBorderClass() }}">

                <div class="relative text-2xl font-extrabold tracking-wide text-left text-white">
                    <div class="">
                        {{ $snowReport['name'] }}
                    </div>

                    <div
                        class="inline-flex items-center px-1 rounded-md {{ $snowReport['status']->getParentBackgroundClass() }}">
                        <p class="text-xs {{ $snowReport['status']->getChildTextClass() }} font-semibold ">
                            {{ $snowReport['status']->toGreek() }}</p>
                    </div>
                </div>
                <div class="flex flex-col text-center">
                    <span class="text-2xl font-semibold leading-none text-gray-100">
                        {{ $snowReport['open_lifts'] ?? 0 }}
                        <span class="text-lg">|</span>
                        {{ $snowReport['total_lifts'] ?? '0' }}
                    </span>
                    <p class="text-gray-200">Lifts</p>
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

                            <div wire:loading.remove class="grid grid-cols-1 mt-2">
                                @if ($selectedSnowReport?->getAttributes())
                                    <div class="flex flex-col mb-12 space-y-2">
                                        <x-ui.lists.activity-list :infoList="$selectedSnowReport->lifts ?? null" title="Αναβατήρες" />
                                    </div>

                                    <div class="flex flex-col space-y-2">
                                        <x-ui.lists.activity-list :infoList="$selectedSnowReport->slopes ?? null" title="Πίστες" />
                                    </div>
                                @endif
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
