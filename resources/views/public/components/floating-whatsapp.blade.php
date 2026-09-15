<div class="fixed bottom-20 right-4 z-[100] flex flex-col items-end gap-3 sm:bottom-6 sm:right-6">

    {{-- 1. Floating Promo Button (Gift Icon with Animated Ping Notification Badge) --}}
    <a
        href="{{ route('promos.index') }}"
        aria-label="Lihat Promo Spesial"
        class="group relative flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-r from-amber-500 to-rose-500 text-white shadow-xl shadow-amber-950/20 transition-all duration-300 hover:scale-110 hover:shadow-2xl sm:h-14 sm:w-14"
    >
        {{-- Animated Pulse Ping Badge --}}
        <span class="absolute -right-1 -top-1 flex h-4.5 w-4.5">
            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-rose-400 opacity-75"></span>
            <span class="relative inline-flex h-4.5 w-4.5 rounded-full bg-rose-600 text-[9px] font-extrabold text-white items-center justify-center">%</span>
        </span>

        {{-- Gift / Promo Icon --}}
        <svg
            class="h-5 w-5 transition-transform duration-300 group-hover:rotate-12 group-hover:scale-110 sm:h-6 sm:w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V6a2 2 0 10-2 2h2zm0 13-4-4m4 4 4-4M4 11h16a1 1 0 011 1v7a1 1 0 01-1 1H4a1 1 0 01-1-1v-7a1 1 0 011-1z" />
        </svg>

        {{-- Tooltip Promo --}}
        <span class="pointer-events-none absolute right-full mr-3 hidden whitespace-nowrap rounded-lg bg-neutral-900 px-3 py-1.5 text-xs font-semibold text-amber-300 shadow-lg transition-opacity duration-300 group-hover:opacity-100 sm:block">
            🎁 Promo Spesial!
        </span>
    </a>

    {{-- 2. Floating WhatsApp Button (WhatsApp Green: #25D366) --}}
    @if (isset($whatsappUrl) && $whatsappUrl)
        <a
            href="{{ $whatsappUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Konsultasi melalui WhatsApp"
            class="group flex h-13 w-13 items-center justify-center rounded-full bg-[#25D366] text-white shadow-xl shadow-emerald-950/25 transition-all duration-300 hover:scale-110 hover:bg-[#20ba5a] hover:shadow-2xl sm:h-16 sm:w-16"
        >
            <svg
                class="h-6 w-6 transition-transform duration-300 group-hover:scale-110 sm:h-8 sm:w-8"
                viewBox="0 0 24 24"
                fill="currentColor"
                aria-hidden="true"
            >
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.198.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>

            {{-- Tooltip WhatsApp --}}
            <span class="pointer-events-none absolute right-full mr-3 hidden whitespace-nowrap rounded-lg bg-neutral-900 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-lg transition-opacity duration-300 group-hover:opacity-100 sm:block">
                Konsultasi Gratis
            </span>
        </a>
    @endif

</div>