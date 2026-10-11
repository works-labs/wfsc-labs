{{-- =========================================================
    2. TREATMENT DESCRIPTION + PROCEDURE VIDEOS
========================================================== --}}

@if ($treatment->description || $treatment->procedureVideos->isNotEmpty())

<section class="border-t border-neutral-200 bg-neutral-50 py-20 lg:py-28">

    <div class="mx-auto max-w-7xl px-6 lg:px-12">

        <div class="grid gap-14 lg:grid-cols-2 lg:gap-20">


            {{-- Description --}}
            @if ($treatment->description)

                <div class="flex flex-col justify-center">

                    <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-400">
                        About This Treatment
                    </p>

                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-neutral-900 lg:text-4xl">
                        {{ $treatment->name }}
                    </h2>

                    <div class="rich-content mt-6 text-lg leading-8 text-neutral-600">
                        @if (str_contains($treatment->description, '<'))
                            {!! $treatment->description !!}
                        @else
                            {!! nl2br(e($treatment->description)) !!}
                        @endif
                    </div>

                </div>

            @endif


            {{-- Procedure Videos --}}
            @if ($treatment->procedureVideos->isNotEmpty())

                <div>

                    <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-400">
                        Procedure
                    </p>

                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-neutral-900">
                        See How It Works
                    </h2>


                    <div class="mt-8 grid gap-6 sm:grid-cols-2">

                        @foreach ($treatment->procedureVideos->take(2) as $video)

                            <article class="min-w-0">

                                <div class="mx-auto w-full max-w-[260px] overflow-hidden rounded-[1.5rem] bg-black shadow-sm sm:max-w-none">

                                    @php
                                        $videoPath = $video->video_path;
                                        $youtubeId = null;
                                        $instagramId = null;
                                        $tiktokId = null;

                                        if (str_contains($videoPath, 'youtube.com/shorts/')) {
                                            $youtubeId = explode(
                                                'youtube.com/shorts/',
                                                $videoPath
                                            )[1] ?? null;

                                            $youtubeId = explode('?', $youtubeId)[0];

                                        } elseif (str_contains($videoPath, 'youtu.be/')) {
                                            $youtubeId = explode(
                                                'youtu.be/',
                                                $videoPath
                                            )[1] ?? null;

                                            $youtubeId = explode('?', $youtubeId)[0];

                                        } elseif (str_contains($videoPath, 'youtube.com/watch?v=')) {
                                            parse_str(
                                                parse_url(
                                                    $videoPath,
                                                    PHP_URL_QUERY
                                                ) ?? '',
                                                $query
                                            );

                                            $youtubeId = $query['v'] ?? null;
                                        }

                                        if (preg_match('~instagram\.com/(?:reel|p|tv)/([^/?]+)~i', $videoPath, $matches)) {
                                            $instagramId = $matches[1];
                                        }

                                        if (preg_match('~tiktok\.com/@[^/]+/video/(\d+)~i', $videoPath, $matches)) {
                                            $tiktokId = $matches[1];
                                        }
                                    @endphp


                                    @if ($youtubeId)

                                        <div class="relative aspect-[9/16] w-full max-w-[260px] mx-auto">

                                            <iframe
                                                src="https://www.youtube-nocookie.com/embed/{{ $youtubeId }}?autoplay=1&mute=1&loop=1&playlist={{ $youtubeId }}&controls=0&rel=0&modestbranding=1&playsinline=1"
                                                title="{{ $video->title ?: 'Procedure video' }}"
                                                class="absolute inset-0 h-full w-full"
                                                allow="autoplay; encrypted-media; picture-in-picture"
                                                allowfullscreen
                                            ></iframe>

                                        </div>

                                    @elseif ($instagramId)

                                        <div class="relative aspect-[9/16] w-full max-w-[260px] mx-auto">
                                            <iframe
                                                src="https://www.instagram.com/reel/{{ $instagramId }}/embed/?hidecaption=1"
                                                title="{{ $video->title ?: 'Procedure video' }}"
                                                class="absolute inset-0 h-full w-full"
                                                allow="autoplay; encrypted-media; picture-in-picture"
                                                allowfullscreen
                                            ></iframe>
                                        </div>

                                    @elseif ($tiktokId)

                                        <div class="relative aspect-[9/16] w-full max-w-[260px] mx-auto">
                                            <iframe
                                                src="https://www.tiktok.com/player/v1/{{ $tiktokId }}?autoplay=1&loop=1&description=0&music_info=0&rel=0"
                                                title="{{ $video->title ?: 'Procedure video' }}"
                                                class="absolute inset-0 h-full w-full"
                                                allow="autoplay; encrypted-media; picture-in-picture"
                                                allowfullscreen
                                            ></iframe>
                                        </div>

                                    @else

                                        {{-- Legacy uploaded video --}}
                                        <div class="relative mx-auto aspect-[9/16] w-full max-w-[260px]">
                                            <video
                                                controls
                                                playsinline
                                                preload="metadata"
                                                class="absolute inset-0 h-full w-full object-cover"
                                            >

                                                <source
                                                    src="{{ Storage::url($videoPath) }}"
                                                    type="video/mp4"
                                                >

                                                Browser kamu tidak mendukung video.

                                            </video>
                                        </div>

                                    @endif

                                </div>

                            </article>

                        @endforeach

                    </div>

                </div>

            @endif

        </div>

    </div>

</section>

@endif
