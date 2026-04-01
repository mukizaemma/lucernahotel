@props([
    'rooms',
    'setting' => null,
    'eyebrow' => 'Book your stay',
    'title' => 'Reserve your perfect room',
    'lead' => 'Tell us your dates and preferences — we\'ll follow up to confirm availability and make your arrival seamless.',
    'headingId' => 'booking-cta-heading',
    'idSuffix' => '',
    'showChildrenField' => false,
])

@php
    $roomList = $rooms instanceof \Illuminate\Support\Collection ? $rooms : collect($rooms ?? []);
    $setting = $setting ?? \App\Models\Setting::first();
@endphp

<section class="home-cta rts__section section__padding" aria-labelledby="{{ $headingId }}">
    <div class="container">
        <div class="home-cta__intro text-center wow fadeInUp">
            <p class="home-cta__eyebrow">{{ $eyebrow }}</p>
            <h2 id="{{ $headingId }}" class="home-cta__title section__title">{{ $title }}</h2>
            <p class="home-cta__lead font-sm">{{ $lead }}</p>
        </div>

        <div class="row g-4 g-xl-4 align-items-stretch">
            <div class="col-lg-6 wow fadeInLeft d-flex">
                <div class="home-cta__panel home-cta__panel--map w-100">
                    <div class="home-cta__map-head">
                        <span class="home-cta__map-icon" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
                        <div class="home-cta__map-head-text">
                            <span class="home-cta__map-label">Visit us</span>
                            <span class="home-cta__map-title">{{ $setting?->company ?? config('app.name') }}</span>
                            @if(filled($setting?->address))
                                <span class="home-cta__map-address">{{ $setting->address }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="home-cta__map-frame">
                        @if(!empty($setting?->google_map_embed))
                            {!! $setting?->google_map_embed !!}
                        @else
                            @php
                                $hotelContact = \App\Models\HotelContact::first();
                                $latitude = $hotelContact?->latitude ?? '-1.9441';
                                $longitude = $hotelContact?->longitude ?? '30.0619';
                            @endphp
                            <iframe
                                title="Hotel location on Google Maps"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.497311415315!2d{{ $longitude }}!3d{{ $latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z{{ $latitude }},{{ $longitude }}!5e0!3m2!1sen!2srw!4v1234567890"
                                width="100%"
                                height="100%"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen=""></iframe>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6 wow fadeInRight d-flex">
                <div class="home-cta__panel home-cta__panel--form w-100">
                    <div class="home-cta__form-badge">
                        <i class="fa-solid fa-calendar-check" aria-hidden="true"></i>
                        <span>Request availability</span>
                    </div>
                    <p class="home-cta__form-note">Fields marked <span class="home-cta__req" aria-hidden="true">*</span> are required.</p>

                    @if(session('success'))
                        <div class="home-cta__alert home-cta__alert--success" role="status">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="home-cta__alert home-cta__alert--error" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="home-cta__alert home-cta__alert--error" role="alert">
                            <ul class="home-cta__alert-list mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bookNow') }}" method="POST" class="home-cta__form booking__form">
                        @csrf

                        <div class="home-cta__block">
                            <div class="row g-3">
                                <div class="{{ $showChildrenField ? 'col-md-6' : 'col-md-8' }}">
                                    <label for="room_id{{ $idSuffix }}" class="home-cta__label">Select room <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <select name="room_id" id="room_id{{ $idSuffix }}" class="form-control home-cta__input home-cta__input--select" required>
                                            <option value="">Choose a room…</option>
                                            @foreach($roomList as $roomOption)
                                                <option value="{{ $roomOption->id }}">{{ $roomOption->title }} — ${{ number_format($roomOption->price, 0) }}/night</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="{{ $showChildrenField ? 'col-md-3' : 'col-md-4' }}">
                                    <label for="adults{{ $idSuffix }}" class="home-cta__label">Adults <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="number" name="adults" id="adults{{ $idSuffix }}" class="form-control home-cta__input" required min="1" value="1" inputmode="numeric">
                                    </div>
                                </div>
                                @if($showChildrenField)
                                    <div class="col-md-3">
                                        <label for="children{{ $idSuffix }}" class="home-cta__label">Children</label>
                                        <div class="home-cta__field">
                                            <input type="number" name="children" id="children{{ $idSuffix }}" class="form-control home-cta__input" min="0" value="0" inputmode="numeric">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="home-cta__block">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="checkin{{ $idSuffix }}" class="home-cta__label">Check-in <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="date" name="checkin" id="checkin{{ $idSuffix }}" class="form-control home-cta__input" required min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="checkout{{ $idSuffix }}" class="home-cta__label">Check-out <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="date" name="checkout" id="checkout{{ $idSuffix }}" class="form-control home-cta__input" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="home-cta__block">
                            <label for="names{{ $idSuffix }}" class="home-cta__label">Full name <span class="home-cta__req">*</span></label>
                            <div class="home-cta__field">
                                <input type="text" name="names" id="names{{ $idSuffix }}" class="form-control home-cta__input" required autocomplete="name">
                            </div>
                        </div>

                        <div class="home-cta__block">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="phone{{ $idSuffix }}" class="home-cta__label">Phone <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="tel" name="phone" id="phone{{ $idSuffix }}" class="form-control home-cta__input" required autocomplete="tel">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email{{ $idSuffix }}" class="home-cta__label">Email <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="email" name="email" id="email{{ $idSuffix }}" class="form-control home-cta__input" required autocomplete="email">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="home-cta__block">
                            <label for="message{{ $idSuffix }}" class="home-cta__label">Special requests <span class="home-cta__label-opt">(optional)</span></label>
                            <div class="home-cta__field">
                                <textarea name="message" id="message{{ $idSuffix }}" class="form-control home-cta__input home-cta__input--textarea" rows="3" placeholder="Dietary needs, late arrival, celebration, etc."></textarea>
                            </div>
                        </div>

                        <button type="submit" class="theme-btn btn-style fill w-100 home-cta__submit">
                            <span>Submit booking request <i class="fa-solid fa-arrow-right home-cta__submit-icon" aria-hidden="true"></i></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
