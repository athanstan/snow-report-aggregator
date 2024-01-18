<div class="w-full">
    <ul class="flex flex-col space-y-3">
        @forelse ($snowReports as $report)
            <li
                class="relative flex items-center justify-between px-4 py-6 border border-white rounded-md shadow-md bg-gray-50 isolate bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10">
                <div class="absolute inset-0 rounded-md -z-10 bg-gradient-to-t from-green-200 via-gray-50/40">
                </div>
                <p class="text-2xl font-extrabold tracking-wide text-slate-800">
                    {{ $report['name'] }}
                </p>
                <div class="flex flex-col text-center">
                    <span class="text-2xl font-semibold leading-none text-slate-500">
                        {{ $report['open_lifts'] ?? 0 }}
                        <span class="text-lg">|</span>
                        {{ $report['total_lifts'] ?? '0' }}
                    </span>
                    <p class="text-slate-500/50">Lifts</p>
                </div>
            </li>
        @empty
            <li>No reports found</li>
        @endforelse
    </ul>
</div>
