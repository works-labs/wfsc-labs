@php
    use App\Models\Branch;
    use App\Models\SiteSetting;

    $branches = Branch::query()
        ->where('is_active', true)
        ->orderBy('id')
        ->get();

    $settings = SiteSetting::query()
        ->pluck('value', 'key');

    $whatsapp = $settings['whatsapp_number'] ?? null;
    $phone = $settings['site_phone'] ?? null;
    $email = $settings['site_email'] ?? null;
    $operatingHours = $settings['operating_hours'] ?? null;

    $instagram = $settings['instagram_url'] ?? null;
    $tiktok = $settings['tiktok_url'] ?? null;
    $threads = $settings['threads_url'] ?? null;

    $whatsappLink = $whatsapp
        ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsapp)
        : null;
@endphp

<footer
    id="contact"
    class="relative overflow-hidden bg-[#FF5252] text-white"
>
    {{-- Decorative background --}}
    <div
        class="pointer-events-none absolute -right-32 -top-32 h-80 w-80 rounded-full bg-white/10 blur-3xl sm:h-96 sm:w-96"
    ></div>

    <div
        class="pointer-events-none absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-white/10 blur-3xl sm:h-96 sm:w-96"
    ></div>

    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-12 lg:py-24">

        {{-- Main Footer Grid --}}
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-[1.35fr_1fr_1fr_1fr] lg:gap-12">

            {{-- BRAND --}}
            <div data-reveal="up" data-delay="100" class="reveal-hidden">

                <a
                    href="{{ url('/') }}"
                    class="inline-flex items-center"
                    aria-label="WFSC Clinic Home"
                >
                    <img src="{{ asset('assets/logo.PNG') }}"
                        alt="WFSC"
                        class="h-24 w-auto brightness-0 invert sm:h-28 lg:h-32">
                </a>

                <p class="mt-4 max-w-sm text-xs leading-relaxed text-white/75 sm:mt-6 sm:text-sm sm:leading-7">
                    Pelayanan kedokteran estetika dan anti-aging
                    dengan teknologi medis terkini untuk membantu
                    memancarkan kecantikan alami Anda.
                </p>

                <div
                    class="mt-6 inline-flex items-center rounded-full border border-white/20 bg-white/10 px-4 py-2 backdrop-blur-md sm:mt-7 sm:px-5 sm:py-2.5"
                >
                    <span class="text-[11px] font-medium tracking-wide sm:text-xs">
                        ✦ 20+ Years of Excellence
                    </span>
                </div>

            </div>


            {{-- BRANCHES --}}
            <div data-reveal="up" data-delay="200" class="reveal-hidden">

                <h3 class="relative mb-5 pb-2.5 text-xs font-semibold uppercase tracking-wider text-white sm:mb-7 sm:pb-3 sm:text-sm">
                    Alamat Cabang

                    <span
                        class="absolute bottom-0 left-0 h-0.5 w-8 rounded-full bg-white/60 sm:w-10"
                    ></span>
                </h3>

                @if ($branches->isNotEmpty())

                    <div class="space-y-3 sm:space-y-4">

                        @foreach ($branches as $branch)

                            <div
                                class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md transition duration-300 hover:-translate-y-1 hover:bg-white/15 sm:p-5"
                            >

                                <p class="text-xs font-bold text-white sm:text-sm">
                                    <span class="mr-1 opacity-80">📍</span>
                                    {{ $branch->name }}
                                </p>

                                <p class="mt-1.5 text-xs leading-relaxed text-white/70 sm:mt-2 sm:text-sm sm:leading-6">
                                    {{ $branch->address }}
                                </p>

                                @if ($branch->google_maps_url)

                                    <a
                                        href="{{ $branch->google_maps_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="mt-3 inline-flex items-center gap-1 text-[11px] font-medium text-white/80 transition hover:text-white sm:text-xs"
                                    >
                                        <span>View on Google Maps</span>
                                        <span class="transition-transform group-hover:translate-x-1">→</span>
                                    </a>

                                @endif

                            </div>

                        @endforeach

                    </div>

                @else

                    <div
                        class="rounded-2xl border border-white/15 bg-white/10 p-4 sm:p-5"
                    >
                        <p class="text-xs text-white/70 sm:text-sm">
                            Informasi cabang akan segera tersedia.
                        </p>
                    </div>

                @endif

            </div>


            {{-- CONTACT --}}
            <div data-reveal="up" data-delay="300" class="reveal-hidden">

                <h3 class="relative mb-5 pb-2.5 text-xs font-semibold uppercase tracking-wider text-white sm:mb-7 sm:pb-3 sm:text-sm">
                    Hubungi Kami

                    <span
                        class="absolute bottom-0 left-0 h-0.5 w-8 rounded-full bg-white/60 sm:w-10"
                    ></span>
                </h3>

                <div class="space-y-4 sm:space-y-6">

                    {{-- WhatsApp --}}
                    @if ($whatsapp && $whatsappLink)

                        <div>
                            <p class="mb-1 text-[10px] uppercase tracking-[0.16em] text-white/60 sm:mb-2 sm:text-[11px]">
                                WhatsApp Consultation
                            </p>

                            <a
                                href="{{ $whatsappLink }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="group inline-flex items-center gap-2.5 text-xs transition duration-300 hover:translate-x-1 sm:gap-3 sm:text-sm"
                            >
                                <span
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-white/20 bg-white/10 sm:h-9 sm:w-9"
                                >
                                    <svg
                                        class="h-3.5 w-3.5 sm:h-4 sm:w-4"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.198.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"
                                        />
                                    </svg>
                                </span>

                                <span class="font-medium">
                                    {{ $whatsapp }}
                                </span>
                            </a>
                        </div>

                    @endif


                    {{-- Phone --}}
                    @if ($phone)

                        <div>
                            <p class="mb-1 text-[10px] uppercase tracking-[0.16em] text-white/60 sm:mb-2 sm:text-[11px]">
                                Customer Service
                            </p>

                            <a
                                href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}"
                                class="inline-flex items-center gap-2.5 text-xs transition duration-300 hover:translate-x-1 sm:gap-3 sm:text-sm"
                            >
                                <span
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-white/20 bg-white/10 sm:h-9 sm:w-9"
                                >
                                    <svg
                                        class="h-3.5 w-3.5 sm:h-4 sm:w-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 11.19 18a19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 3.37 2 2 0 0 1 4.11 1.2h3a2 2 0 0 1 2 1.72 12.8 12.8 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l2.07-2.07a2 2 0 0 1 2.11-.45 12.8 12.8 0 0 0 2.81.7A2 2 0 0 1 22 16.92Z"
                                        />
                                    </svg>
                                </span>

                                <span class="font-medium">
                                    {{ $phone }}
                                </span>
                            </a>
                        </div>

                    @endif


                    {{-- Email --}}
                    @if ($email)

                        <div>
                            <p class="mb-1 text-[10px] uppercase tracking-[0.16em] text-white/60 sm:mb-2 sm:text-[11px]">
                                Email Support
                            </p>

                            <a
                                href="mailto:{{ $email }}"
                                class="inline-flex items-center gap-2.5 text-xs transition duration-300 hover:translate-x-1 sm:gap-3 sm:text-sm"
                            >
                                <span
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-white/20 bg-white/10 sm:h-9 sm:w-9"
                                >
                                    <svg
                                        class="h-3.5 w-3.5 sm:h-4 sm:w-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <rect
                                            x="3"
                                            y="5"
                                            width="18"
                                            height="14"
                                            rx="2"
                                        />
                                        <path d="m3 7 9 6 9-6" />
                                    </svg>
                                </span>

                                <span class="font-medium">
                                    {{ $email }}
                                </span>
                            </a>
                        </div>

                    @endif


                    {{-- Operating Hours --}}
                    @if ($operatingHours)

                        <div class="border-t border-white/15 pt-4 sm:pt-5">

                            <p class="text-[10px] uppercase tracking-[0.16em] text-white/60 sm:text-[11px]">
                                Jam Operasional
                            </p>

                            <p class="mt-1 text-xs text-white/80 sm:mt-2 sm:text-sm">
                                {{ $operatingHours }}
                            </p>

                        </div>

                    @endif

                </div>

            </div>


            {{-- SOCIAL MEDIA --}}
            <div data-reveal="up" data-delay="400" class="reveal-hidden">

                <h3 class="relative mb-5 pb-2.5 text-xs font-semibold uppercase tracking-wider text-white sm:mb-7 sm:pb-3 sm:text-sm">
                    Ikuti Kami

                    <span
                        class="absolute bottom-0 left-0 h-0.5 w-8 rounded-full bg-white/60 sm:w-10"
                    ></span>
                </h3>

                <p class="mb-4 text-xs leading-relaxed text-white/70 sm:mb-6 sm:text-sm sm:leading-6">
                    Dapatkan informasi terbaru, tips kecantikan,
                    dan promo spesial dari WFSC.
                </p>

                <div class="space-y-2.5 sm:space-y-3">

                    {{-- Instagram --}}
                    @if ($instagram)

                        <a
                            href="{{ $instagram }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group flex items-center gap-3 rounded-xl border border-white/15 bg-white/10 px-3.5 py-2.5 backdrop-blur-md transition duration-300 hover:translate-x-1 hover:bg-white/15 sm:gap-4 sm:px-4 sm:py-3.5"
                        >
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 sm:h-9 sm:w-9">

                                <svg
                                    class="h-4 w-4 sm:h-5 sm:w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    viewBox="0 0 24 24"
                                >
                                    <rect
                                        x="2"
                                        y="2"
                                        width="20"
                                        height="20"
                                        rx="5"
                                    />
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="4"
                                    />
                                    <circle
                                        cx="17.5"
                                        cy="6.5"
                                        r=".5"
                                        fill="currentColor"
                                    />
                                </svg>

                            </span>

                            <span class="text-xs font-medium sm:text-sm">
                                Instagram
                            </span>
                        </a>

                    @endif


                    {{-- TikTok --}}
                    @if ($tiktok)

                        <a
                            href="{{ $tiktok }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group flex items-center gap-3 rounded-xl border border-white/15 bg-white/10 px-3.5 py-2.5 backdrop-blur-md transition duration-300 hover:translate-x-1 hover:bg-white/15 sm:gap-4 sm:px-4 sm:py-3.5"
                        >
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 sm:h-9 sm:w-9">

                                <svg
                                    class="h-4 w-4 sm:h-5 sm:w-5"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 1 1-2.89-2.89c.31 0 .61.05.88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 1 0 15 15.67v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-.18-.1Z" />
                                </svg>

                            </span>

                            <span class="text-xs font-medium sm:text-sm">
                                TikTok
                            </span>
                        </a>

                    @endif


                    {{-- Threads --}}
                    @if ($threads)

                        <a
                            href="{{ $threads }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group flex items-center gap-3 rounded-xl border border-white/15 bg-white/10 px-3.5 py-2.5 backdrop-blur-md transition duration-300 hover:translate-x-1 hover:bg-white/15 sm:gap-4 sm:px-4 sm:py-3.5"
                        >
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-xs font-bold sm:h-9 sm:w-9 sm:text-sm">
                                @
                            </span>

                            <span class="text-xs font-medium sm:text-sm">
                                Threads
                            </span>
                        </a>

                    @endif

                </div>

            </div>

        </div>


        {{-- Divider --}}
        <div data-reveal="fade" data-delay="450" class="reveal-hidden my-8 h-px bg-gradient-to-r from-transparent via-white/25 to-transparent sm:my-12"></div>


        {{-- Bottom Copyright & Links --}}
        <div data-reveal="up" data-delay="500" class="reveal-hidden flex flex-col gap-4 text-center sm:flex-row sm:items-center sm:justify-between sm:text-left">

            <p class="text-[11px] text-white/60 sm:text-xs">
                &copy; {{ date('Y') }}
                <span class="font-semibold text-white/80">
                    WFSC Clinic
                </span>.
                All Rights Reserved.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3 text-[11px] text-white/60 sm:gap-4 sm:text-xs">

                <a
                    href="#"
                    class="transition hover:text-white"
                >
                    Privacy Policy
                </a>

                <span class="text-white/25">|</span>

                <a
                    href="#"
                    class="transition hover:text-white"
                >
                    Terms of Service
                </a>

                <span class="text-white/25">|</span>

                <a
                    href="#"
                    class="transition hover:text-white"
                >
                    Sitemap
                </a>

            </div>

        </div>

    </div>
</footer>