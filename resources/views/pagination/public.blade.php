@if ($paginator->hasPages())
    <nav class="flex flex-col items-center justify-between gap-4 sm:flex-row" role="navigation" aria-label="Pagination">
        <p class="text-xs text-neutral-500 sm:text-sm">
            Menampilkan
            <span class="font-semibold text-neutral-700">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-semibold text-neutral-700">{{ $paginator->total() }}</span>
            data
        </p>

        <div class="flex items-center gap-1.5">
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-9 items-center rounded-lg border border-neutral-200 px-3 text-xs font-semibold text-neutral-300" aria-disabled="true">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex h-9 items-center rounded-lg border border-neutral-200 bg-white px-3 text-xs font-semibold text-neutral-600 transition hover:border-[#FF5252]/40 hover:text-[#FF5252]">
                    Sebelumnya
                </a>
            @endif

            <div class="hidden items-center gap-1 sm:flex">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-1 text-sm text-neutral-400">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-[#FF5252] px-2 text-xs font-bold text-white" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-transparent px-2 text-xs font-semibold text-neutral-600 transition hover:border-[#FF5252]/30 hover:bg-[#FF5252]/5 hover:text-[#FF5252]">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            <span class="px-2 text-xs font-semibold text-neutral-600 sm:hidden">
                {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
            </span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex h-9 items-center rounded-lg border border-neutral-200 bg-white px-3 text-xs font-semibold text-neutral-600 transition hover:border-[#FF5252]/40 hover:text-[#FF5252]">
                    Berikutnya
                </a>
            @else
                <span class="inline-flex h-9 items-center rounded-lg border border-neutral-200 px-3 text-xs font-semibold text-neutral-300" aria-disabled="true">
                    Berikutnya
                </span>
            @endif
        </div>
    </nav>
@endif
