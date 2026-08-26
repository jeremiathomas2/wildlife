@props([
    'featuredTestimonials',
    'contents',
])

<!-- Testimonials Section -->
<section class="py-20 lg:py-28 relative overflow-hidden" style="background: #631e08;">
    <div class="relative z-10 max-w-[1280px] mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-14">
            <span class="text-sm font-semibold uppercase tracking-[0.15em] mb-3 block" style="color: #ff9729; font-family: 'Raleway', sans-serif;">
                {{ $contents['testimonials_label']->value ?? 'Testimonials' }}
            </span>
            <h2
                class="font-bold mb-4"
                style="
                    font-family: 'Raleway', sans-serif;
                    font-size: clamp(1.8rem, 4vw, 3.2rem);
                    color: #ffffff;
                    line-height: 1.15;
                "
            >
                {{ $contents['testimonials_title']->value ?? 'What Our Travelers Say' }}
            </h2>
            <p class="text-base" style="color: rgba(255,255,255,0.8); font-family: 'Raleway', sans-serif;">
                {{ $contents['testimonials_subtitle']->value ?? 'Real experiences from real adventurers' }}
            </p>

            <!-- TripAdvisor Badge -->
            <div class="mt-8 flex justify-center items-center">
                <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-sm rounded-2xl px-8 py-4 inline-flex items-center gap-4 transition-all duration-300 hover:bg-opacity-15" style="border: 1px solid rgba(255,255,255,0.2);">
                    <div id="TA_rated260" class="TA_rated">
                        <ul id="GfkJirIfYgzq" class="TA_links abbMITnMe">
                            <li id="4pOhGBqbk6D" class="Wh6U2f">
                                <a target="_blank" href="https://www.tripadvisor.com/Attraction_Review-g317084-d34526433-Reviews-Tanzania_Daily_Tours_and_Safari-Moshi_Kilimanjaro_Region.html">
                                    <img src="https://www.tripadvisor.com/img/cdsi/img2/badges/ollie-11424-2.gif" alt="TripAdvisor" style="height: 60px; width: auto;" loading="lazy"/>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <script async src="https://www.jscache.com/wejs?wtype=rated&amp;uniq=260&amp;locationId=34526433&amp;lang=en_US&amp;display_version=2" data-loadtrk onload="this.loadtrk=true"></script>
                    <div class="text-left">
                        <p class="text-sm font-semibold" style="color: #ffffff; font-family: 'Raleway', sans-serif;">Rated on TripAdvisor</p>
                        <p class="text-xs" style="color: rgba(255,255,255,0.7); font-family: 'Raleway', sans-serif;">Read verified reviews</p>
                    </div>
                </div>
            </div>
        </div>

        @php
            function getInitials($name) {
                $words = array_filter(explode(' ', trim($name)));
                $initials = '';
                foreach (array_slice($words, 0, 2) as $w) {
                    $initials .= strtoupper($w[0] ?? '');
                }
                return $initials;
            }
        @endphp

        <!-- Testimonials Grid -->
        @if($featuredTestimonials->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Featured Card (1st review) -->
                @php $featured = $featuredTestimonials->first(); @endphp
                <div
                    class="lg:col-span-2 lg:row-span-2 rounded-3xl p-8 lg:p-10 relative overflow-hidden group transition-all duration-500 hover:-translate-y-1 flex flex-col justify-between"
                    style="
                        background: rgba(255,255,255,0.07);
                        backdrop-filter: blur(12px);
                        border: 1px solid rgba(255,255,255,0.12);
                        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
                    "
                >
                    <!-- Decorative quote -->
                    <div class="absolute top-6 right-6 opacity-[0.06]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 lg:w-40 lg:h-40" viewBox="0 0 24 24" fill="#ff9729">
                            <path d="M3 21v-6c0-4.418 3.582-8 8-8h3c4.418 0 8 3.582 8 8v6h-5v-6h-3a5 5 0 00-5 5v1H3zM18 21v-6c0-2.761 2.239-5 5-5h1v6h-6z"/>
                        </svg>
                    </div>

                    <div>
                        <div class="flex items-center gap-1 mb-6">
                            @for($i = 0; $i < ($featured->rating ?? 5); $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="#ff9729" stroke="#ff9729">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            @endfor
                        </div>
                        <p
                            class="text-xl lg:text-2xl italic leading-relaxed mb-8"
                            style="font-family: 'Raleway', sans-serif; color: #ffffff;"
                        >
                            &ldquo;{{ $featured->text }}&rdquo;
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0 text-sm font-bold"
                            style="background: #ff9729; color: #ffffff; font-family: 'Raleway', sans-serif;"
                        >
                            {{ getInitials($featured->name) }}
                        </div>
                        <div>
                            <p class="font-bold" style="color: #ffffff; font-family: 'Raleway', sans-serif;">
                                {{ $featured->name }}
                            </p>
                            <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold" style="background: #088529; color: #ffffff; font-family: 'Raleway', sans-serif;">
                                {{ $featured->tour }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                @if($featuredTestimonials->count() > 1)
                    @php $second = $featuredTestimonials->skip(1)->first(); @endphp
                    <div
                        class="rounded-3xl p-6 lg:p-8 relative overflow-hidden group transition-all duration-500 hover:-translate-y-1 flex flex-col justify-between"
                        style="
                            background: rgba(255,255,255,0.07);
                            backdrop-filter: blur(12px);
                            border: 1px solid rgba(255,255,255,0.12);
                            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
                        "
                    >
                        <div>
                            <div class="flex items-center gap-1 mb-4">
                                @for($i = 0; $i < ($second->rating ?? 5); $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="#ff9729" stroke="#ff9729">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                @endfor
                            </div>
                            <p
                                class="text-base italic leading-relaxed mb-6"
                                style="font-family: 'Raleway', sans-serif; color: #ffffff;"
                            >
                                &ldquo;{{ $second->text }}&rdquo;
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold"
                                style="background: #ff9729; color: #ffffff; font-family: 'Raleway', sans-serif;"
                            >
                                {{ getInitials($second->name) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold" style="color: #ffffff; font-family: 'Raleway', sans-serif;">
                                    {{ $second->name }}
                                </p>
                                <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: #088529; color: #ffffff; font-family: 'Raleway', sans-serif;">
                                    {{ $second->tour }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 3 -->
                @if($featuredTestimonials->count() > 2)
                    @php $third = $featuredTestimonials->skip(2)->first(); @endphp
                    <div
                        class="rounded-3xl p-6 lg:p-8 relative overflow-hidden group transition-all duration-500 hover:-translate-y-1 flex flex-col justify-between"
                        style="
                            background: rgba(255,255,255,0.07);
                            backdrop-filter: blur(12px);
                            border: 1px solid rgba(255,255,255,0.12);
                            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
                        "
                    >
                        <div>
                            <div class="flex items-center gap-1 mb-4">
                                @for($i = 0; $i < ($third->rating ?? 5); $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="#ff9729" stroke="#ff9729">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                @endfor
                            </div>
                            <p
                                class="text-base italic leading-relaxed mb-6"
                                style="font-family: 'Raleway', sans-serif; color: #ffffff;"
                            >
                                &ldquo;{{ $third->text }}&rdquo;
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold"
                                style="background: #ff9729; color: #ffffff; font-family: 'Raleway', sans-serif;"
                            >
                                {{ getInitials($third->name) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold" style="color: #ffffff; font-family: 'Raleway', sans-serif;">
                                    {{ $third->name }}
                                </p>
                                <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: #088529; color: #ffffff; font-family: 'Raleway', sans-serif;">
                                    {{ $third->tour }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- CTA -->
            <div class="mt-10 text-center">
                <a
                    href="{{ route('reviews') }}"
                    class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:opacity-90 hover:gap-3"
                    style="background: #088529; font-family: 'Raleway', sans-serif;"
                >
                    View All Reviews
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/>
                        <path d="m12 5 7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>
