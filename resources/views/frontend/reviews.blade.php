<div class="public-livewire-page">

@php
    $c = \App\Support\HotelChannels::all();
    $taWrite = $c['tripadvisor_write_review_url'] ?? '#';
    $googlePlace = $c['google_place_url'] ?? '#';
    $taHotel = $c['tripadvisor_hotel_url'] ?? '#';
    $embedG = $c['google_maps_embed_url'] ?? '';
    $taLocationId = $c['tripadvisor_location_id'] ?? '28135123';
@endphp

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => 'Guest reviews',
    'defaultDescription' => 'Verified feedback on TripAdvisor and Google — leave yours where it counts',
])

{{-- Intro only (actions appear once below in each card) --}}
<div class="rts__section section__padding pb-0">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="mb-3">Reviews you can trust</h2>
                <p class="font-lg text-muted mb-0">
                    We don’t collect reviews on this website. Read what guests posted on <strong>TripAdvisor</strong> and <strong>Google</strong>, or add your own on those platforms.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Two columns: one primary action per platform + embeds --}}
<div class="rts__section section__padding pt-4">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-stretch">
            {{-- TripAdvisor --}}
            <div class="col-lg-6">
                <div class="reviews-platform-card h-100 d-flex flex-column rounded-3 bg-white shadow-sm border overflow-hidden">
                    <div class="px-3 px-lg-4 py-3 border-bottom bg-light">
                        <div class="d-flex align-items-center gap-3 mb-1">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white border" style="width:44px;height:44px;">
                                <i class="fa-brands fa-tripadvisor text-success" style="font-size:1.35rem;" aria-hidden="true"></i>
                            </span>
                            <div>
                                <h3 class="h5 mb-0">TripAdvisor</h3>
                                <a href="{{ $taHotel }}" class="small text-decoration-none" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>See all reviews on TripAdvisor →</a>
                            </div>
                        </div>
                    </div>
                    <div class="reviews-platform-card__widget flex-grow-1 p-3 p-lg-4" style="min-height: 280px;">
                        <div id="TA_selfserveprop482" class="TA_selfserveprop">
                            <ul class="TA_links TA482" id="TA482"></ul>
                        </div>
                        <script async src="https://www.jscache.com/wejs?wtype=selfserveprop&amp;uniq=482&amp;locationId={{ $taLocationId }}&amp;lang=en&amp;rating=true&amp;nreviews=5&amp;reviews=5&amp;writereviewlink=true&amp;popIdx=true&amp;iswide=true&amp;border=true&amp;display_version=2"></script>
                    </div>
                    <div class="px-3 px-lg-4 py-3 mt-auto border-top bg-light">
                        <a href="{{ $taWrite }}" class="theme-btn btn-style fill w-100 text-center" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                            <span>Write a review on TripAdvisor</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Google --}}
            <div class="col-lg-6">
                <div class="reviews-platform-card h-100 d-flex flex-column rounded-3 bg-white shadow-sm border overflow-hidden">
                    <div class="px-3 px-lg-4 py-3 border-bottom bg-light">
                        <div class="d-flex align-items-center gap-3 mb-1">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white border" style="width:44px;height:44px;">
                                <i class="fa-brands fa-google text-primary" style="font-size:1.25rem;" aria-hidden="true"></i>
                            </span>
                            <div>
                                <h3 class="h5 mb-0">Google</h3>
                                <p class="small text-muted mb-0">Map and listing — open to read or write a review</p>
                            </div>
                        </div>
                    </div>
                    <div class="ratio ratio-4x3 border-bottom">
                        @if(filled($embedG))
                            <iframe
                                title="Lucerna Kabgayi Hotel on Google Maps"
                                src="{{ $embedG }}"
                                class="border-0"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light text-muted small p-4">
                                Add <code>HOTEL_GOOGLE_MAPS_EMBED_URL</code> under Settings → Booking &amp; review links (or <code>.env</code>).
                            </div>
                        @endif
                    </div>
                    <div class="px-3 px-lg-4 py-3 mt-auto border-top bg-light">
                        <a href="{{ $googlePlace }}" class="theme-btn btn-style fill w-100 text-center" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                            <span>Open Google Maps — listing &amp; reviews</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stays & contact: single strip (Booking.com + WhatsApp + email) --}}
<div class="rts__section section__padding pt-2 pb-5" style="background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="text-center text-muted small mb-3">Need a room or have another question?</p>
                @include('frontend.includes.hotel-booking-channels', ['contextLabel' => ' (guest reviews page)'])
            </div>
        </div>
    </div>
</div>

</div>
