<div class="public-livewire-page">

@php
    $c = \App\Support\HotelChannels::all();
    $taWrite = $c['tripadvisor_write_review_url'] ?? '#';
    $googlePlace = $c['google_place_url'] ?? '#';
    $taHotel = $c['tripadvisor_hotel_url'] ?? '#';
    $embedG = $c['google_maps_embed_url'] ?? '';
@endphp

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => 'Guest reviews',
    'defaultDescription' => 'Read verified feedback on TripAdvisor and Google — and share your experience where it counts',
])

<!-- Intro + CTAs -->
<div class="rts__section section__padding" style="background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);">
    <div class="container">
        <div class="row justify-content-center text-center mb-40">
            <div class="col-lg-9">
                <h2 class="mb-3">Reviews you can trust</h2>
                <p class="font-lg text-muted mb-4">
                    We invite guests to leave feedback on <strong>TripAdvisor</strong> and <strong>Google</strong> so reviews stay transparent and tied to those platforms.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3 mb-2">
                    <a href="{{ $taWrite }}" class="theme-btn btn-style fill" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                        <i class="fa-solid fa-pen-to-square me-2" aria-hidden="true"></i>
                        <span>Review on TripAdvisor</span>
                    </a>
                    <a href="{{ $googlePlace }}" class="theme-btn btn-style border" style="border-width:2px;" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                        <i class="fa-brands fa-google me-2" aria-hidden="true"></i>
                        <span>Review on Google</span>
                    </a>
                    <a href="{{ $c['booking_com_url'] ?? '#' }}" class="theme-btn btn-style sm-btn border" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>
                        <i class="fa-solid fa-bed me-2" aria-hidden="true"></i>
                        <span>Book on Booking.com</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 1: TripAdvisor widget + Google map embed -->
<div class="rts__section section__padding pt-0">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-6">
                <div class="reviews-embed-card h-100 p-3 p-lg-4 rounded-3 bg-white shadow-sm border">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <h3 class="h5 mb-0">TripAdvisor</h3>
                        <a href="{{ $taHotel }}" class="small text-primary" target="_blank" rel="noopener noreferrer">See all reviews →</a>
                    </div>
                    <div class="reviews-embed-card__body" style="min-height: 320px;">
                        <div id="TA_selfserveprop482" class="TA_selfserveprop">
                            <ul class="TA_links TA482" id="TA482"></ul>
                        </div>
                        <script async src="https://www.jscache.com/wejs?wtype=selfserveprop&amp;uniq=482&amp;locationId={{ $c['tripadvisor_location_id'] ?? '28135123' }}&amp;lang=en&amp;rating=true&amp;nreviews=5&amp;reviews=5&amp;writereviewlink=true&amp;popIdx=true&amp;iswide=true&amp;border=true&amp;display_version=2"></script>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="reviews-embed-card h-100 p-3 p-lg-4 rounded-3 bg-white shadow-sm border">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <h3 class="h5 mb-0">Google</h3>
                        <a href="{{ $googlePlace }}" class="small text-primary" target="_blank" rel="noopener noreferrer">Open in Google Maps →</a>
                    </div>
                    <div class="ratio ratio-4x3 rounded-2 overflow-hidden border">
                        @if(filled($embedG))
                            <iframe
                                title="Lucerna Kabgayi Hotel on Google Maps"
                                src="{{ $embedG }}"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light text-muted small p-4">
                                Set <code>HOTEL_GOOGLE_MAPS_EMBED_URL</code> in <code>.env</code> for a map preview.
                            </div>
                        @endif
                    </div>
                    <p class="small text-muted mt-3 mb-0">
                        On Google Maps, open the hotel and tap <strong>Reviews</strong> to read or write a review.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Repeat CTAs (strong visual) -->
<div class="rts__section section__padding pt-0 pb-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center p-4 rounded-3 border" style="background:#f0fdf4;border-color:#bbf7d0!important;">
                    <i class="fa-brands fa-tripadvisor fa-2x mb-3" style="color:#00af87;" aria-hidden="true"></i>
                    <h3 class="h5">Share on TripAdvisor</h3>
                    <p class="small text-muted">Help future travellers by reviewing your stay on TripAdvisor.</p>
                    <a href="{{ $taWrite }}" class="theme-btn btn-style fill w-100 mt-2" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>Write a review</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="text-center p-4 rounded-3 border" style="background:#eff6ff;border-color:#bfdbfe!important;">
                    <i class="fa-brands fa-google fa-2x mb-3 text-primary" aria-hidden="true"></i>
                    <h3 class="h5">Share on Google</h3>
                    <p class="small text-muted">Reviews on Google help local visibility and trust.</p>
                    <a href="{{ $googlePlace }}" class="theme-btn btn-style fill w-100 mt-2" target="_blank" rel="noopener noreferrer" data-no-spa-navigate>Review on Google</a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-8 text-center">
                @include('frontend.includes.hotel-booking-channels', ['contextLabel' => ' (reviews page)'])
            </div>
        </div>
    </div>
</div>

</div>
