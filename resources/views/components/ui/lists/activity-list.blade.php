@props([
    'infoList' => [],
    'title' => null,
])

<div>
    <div>
        <h2 class="text-lg font-semibold text-white">{{ $title }}</h2>
    </div>
    <ul role="list" class="space-y-3">
        @forelse ($infoList as $item)
            <li class="relative flex gap-x-4">
                @unless ($loop->last)
                    <div class="absolute top-0 flex justify-center w-6 -left-0.5 -bottom-3">
                        <div class="w-px bg-gray-100"></div>
                    </div>
                @endunless
                <div
                    class="relative flex items-center justify-center flex-none w-5 h-5 {{ $item->status->getParentBackgroundClass() }} rounded-full">
                    <div
                        class="h-2 w-2 rounded-full {{ $item->status->toTailwindClass() }} ring-green-400/20 ring-1 ring-inset ring-gray-300">
                    </div>
                </div>
                <p class="flex-auto text-left py-0.5 text-xs leading-5 text-white">
                    <span class="font-medium">{{ $item->name }}</span>
                </p>
                <time datetime="2023-01-23T10:32"
                    class="flex-none py-0.5 text-xs leading-5 text-white">{{ $item->updated_at->diffForHumans() }}</time>
            </li>
        @empty
            <li>Δεν βρέθηκαν αναβατήρες</li>
        @endforelse
    </ul>
</div>
