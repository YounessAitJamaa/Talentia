<div wire:poll.5s>
    {{-- Refresh every 5 seconds --}}
    @if($pendingCount > 0)
        <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white">
            {{ $pendingCount }}
        </span>
    @endif
</div>